<?php require('conn.php');
session_start();
if(isset($_SESSION["empID"])==false){
	header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Today's Attendance</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="nav.css">
</head>
<body>
	<div class="topnav">
		<a href="hr.php">HR Home</a>
		<a href='attendance.php' >Mark Attendance</a>
		<a href="todayAttendance.php">Today's Attendance</a>
		<a href="report.php">Monthly Reports</a>	
		<a href='logout.php' >Logout</a>
	</div><br><br><br>
	<div class="container">
	<?php
		$date = date("Y-m-d");
		//$date = "2020-08-26";
		try {
				// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
			$stmt = $conn->prepare("SELECT e.emp_id, e.name, e.dept, e.designation, a.status FROM emp e Inner Join attendence a on e.emp_id = a.emp_id WHERE a.curr_date = '$date' ");
			$stmt->execute();
			$recordsFound = $stmt->rowCount();
			if($recordsFound > 0)
			{
				$data = $stmt->fetchAll();
			?>
				<div class="row justify-content-center">
					<table class="table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Department</th>
								<th>Designation</th>
								<th>Status</th>
							</tr>
						</thead>
						<?php foreach ($data as $row ){ ?>
							<tr>
								<td><?php echo $row['emp_id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['dept']; ?></td>
								<td><?php echo $row['designation']; ?></td>
								<td><?php echo $row['status']; ?></td>
							</tr>
						<?php } ?> 
					</table>
				</div>
			<?php	
			}else{
				echo "Error while retreving data";
			}
		} catch(PDOException $e) {
			echo "Error while retreving data";
			echo "<br>" . $e->getMessage();
		}
		?>
	<div>
</body>
</html>