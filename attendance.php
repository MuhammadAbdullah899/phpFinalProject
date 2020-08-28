<?php 
require('conn.php');
session_start();
if(isset($_SESSION["empID"])==false){
	header("location: login.php");
}
?>
<?php
if(isset($_POST["save"])){

	$emp_id=$_SESSION["empID"];

	$time_in = $_POST["time_in"];
	$time_out = $_POST["time_out"];
	//$date = date("Y-m-d");
	$date = "2020-08-27";

	try {
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $conn->prepare("SELECT * FROM attendence WHERE emp_id='$emp_id' and curr_date='$date' ");
		$stmt->execute();
		$recordsFound = $stmt->rowCount();
		if($recordsFound === 1)
		{
			$status = "present";
			if(	 $_POST["time_in"]!="" && $_POST["time_out"]!=""){
				if($_POST["time_in"] < $_POST["time_out"]){

					$time = date('H:i:s',strtotime("11 AM"));
					if($_POST["time_in"] > $time){					
						$status="late";
					}
				
					$sql = "UPDATE attendence SET time_in='$time_in', time_out = '$time_out' , status = '$status' WHERE emp_id='$emp_id' and curr_date='$date' ";
			
					$stmt1 = $conn->prepare($sql);
					$stmt1->execute();
					$_SESSION['message']="attendance updated";
					$_SESSION['msg_type']="success";	
				}else{
					echo "Enter Valid Time!<br>";
				}
			}
			else if($_POST["time_in"]!="" && $_POST["time_out"]==""){
			
				$time = date('H:i:s',strtotime("11 AM"));
				if($_POST["time_in"] > $time){					
					$status="late";
				}
			
				$sql = "UPDATE attendence SET time_in='$time_in' , status = '$status' WHERE emp_id='$emp_id' and curr_date='$date' ";
		
				$stmt1 = $conn->prepare($sql);
				$stmt1->execute();
				$_SESSION['message']="attendance updated";
				$_SESSION['msg_type']="success";

			}
			else if($_POST["time_in"]=="" && $_POST["time_out"]!=""){
				if($_POST["time_in"] < $_POST["time_out"] ){

					$sql = "UPDATE attendence SET time_out='$time_out' , status = '$status' WHERE emp_id='$emp_id' and curr_date='$date' ";
					$stmt1 = $conn->prepare($sql);
					$stmt1->execute();
					$_SESSION['message']="attendance updated";
					$_SESSION['msg_type']="success";
				}else{
					echo "Enter Valid Time!";
				}
			}			
		}	
	} catch(PDOException $e) {
		$_SESSION['message']="Error while updating attendance!";
		$_SESSION['msg_type']="danger";
		echo "<br>" . $e->getMessage();
	}
}
?>	

<!DOCTYPE html>
<html>
<head>
	<title>Hr</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="nav.css">
</head>
<style type="text/css">
	#logout{	position: fixed;	bottom: 2em;	right: 7em;	}
</style>
<body>
	<?php
	$emp_id = $_SESSION["empID"];
	try {
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("SELECT * FROM emp WHERE emp_id = '$emp_id' ");
			$stmt->execute();
			$recordsFound = $stmt->rowCount();
			if($recordsFound === 1)
			{
				$row = $stmt->fetch();
				if($row["designation"] === "HR Manager" ){
					?>
					<div class="topnav">
						<a href="hr.php">HR Home</a>
						<a href='attendance.php' >Mark Attendance</a>
						<a href="todayAttendance.php">Today's Attendance</a>
						<a href="report.php">Monthly Reports</a>	
						<a href='logout.php' >Logout</a>
					</div>
					<?php
				}else{
					?><a href='logout.php' class='btn btn-danger' id="logout" >Logout</a><?php
				}
			}			
		} catch(PDOException $e) {
		$_SESSION['message']="Error while updating attendance!";
		$_SESSION['msg_type']="danger";
		echo "<br>" . $e->getMessage();
	}
	?>

	<?php 
	if(isset($_SESSION['message'])): ?>
		<div class="alert alert-<?=$_SESSION['msg_type'] ?>">
			<?php
			echo $_SESSION['message'];
			unset($_SESSION['message']);
			?>		
		</div>
	<?php endif ?>
	<?php
	try {
			$emp_id=$_SESSION["empID"];
			//$date = "2020-08-27";
			$date= "2020-08-27";
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("SELECT * FROM attendence WHERE emp_id = '$emp_id' and curr_date='$date' ");
			$stmt->execute();
			$recordsFound = $stmt->rowCount();
			if($recordsFound === 1)
			{
				$row = $stmt->fetch();
				$time_in="";
				$time_out="";
				if($row["time_in"]!=null ){
					$time_in=$row["time_in"];
				}
				if($row["time_out"]!=null){
					$time_out=$row["time_out"];
				}
			}			
		} catch(PDOException $e) {
		echo "<br>" . $e->getMessage();
	}
	?>

	<div class="container">
	<form action= "attendance.php" method="POST">
		<br><br>
		<h3>Mark Attendence</h3><br>
		<label>Time In:  </label>
		<input type="Time" name="time_in" value="<?php echo $time_in ?>" ><br>
		<label>Time Out: </label>
		<input type="Time" name="time_out" value="<?php echo $time_out ?>" ><br><br>

		<button type="submit" class="btn btn-primary" name="save">Save</button>
	</form>
	</div>
</body>
</html>