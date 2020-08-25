<?php 
require('conn.php');
//require('empModel.php');
require_once 'hrProcess.php';

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
</head>
<body>
	<?php 
	if(isset($_SESSION['message'])): ?>
		<div class="alert alert-<?=$_SESSION['msg_type'] ?>">
			<?php
			echo $_SESSION['message'];
			unset($_SESSION['message']);
			?>		
		</div>
	<?php endif ?>
	<div class="container">


	<h1 style="text-align: center;"></h1></br>
	
	<div class="row">
	
	<form action= "hrProcess.php" method="POST" enctype="multipart/form-data">
		<h3>Add New Employee</h3>	
	
		<input type="hidden" name="emp_id" value="<?php echo $employee->getID(); ?>">	
	
			<label>Name: </label>
			<input type="text" placeholder="Name" name="name" value="<?php echo $employee->getName(); ?>" required><br> 
		    <label>Login: </label>
			<input type="text" placeholder="Login" name="login" value="<?php echo $employee->getLogin(); ?>" required><br>
			<label>Password: </label>
			<input type="text" name="password" value="<?php echo $employee->getPassword(); ?>" required><br>
			<label>Department: </label>
			<select name="dept" value="<?php echo $employee->getDepartment(); ?>">
				<option value="">--Select--</option>
			  <option value="IT">IT</option>
			  <option value="HR">HR</option>
			  <option value="Accounts">Accounts</option>
			  <option value="Development">Development</option>
			</select><br>
			<label>Salary: </label>
			<input type="Number" name="salary" value="<?php echo $employee->getSalary(); ?>" required><br>

			<label>Profile Picture:</label>
			<input type="file" name="picture" value="<?php echo $employee->getPicture(); ?>" required><br>

			<label>Boss: </label>
			<select name="boss" >
				<option value="">--Select--</option>
				<!-- .........................................  -->
<?php
			try {
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT * FROM emp where designation='Manager' ");
				$stmt->execute();
				$data = $stmt->fetchAll();
				//Count total number of rows
		        $rowCount = $stmt->rowCount();
		        
		        //Display states list
		        if($rowCount > 0){
		            foreach ($data as $row ) { 
		                echo '<option value="'.$row['emp_id'].'">'.$row['name'].'</option>';
		            }
		        }
			} catch(PDOException $e) {		
				echo "<br>" . $e->getMessage();
			}
?>
			</select><br>
			<label>Designation: </label>
			<select name="designation">
				<option value="">--Select--</option>
			  <option value="Developer">Developer</option>
			  <option value="HR Manager">HR Manager</option>
			  <option value="Manager">Manager</option>
			  <option value="CEO">CEO</option>
			</select>

		<div class="form-group">
			<?php if($update==TRUE): ?>
				<button type="submit" class="btn btn-info" name="update">Update</button>
			<?php else: ?>
				<button type="submit" class="btn btn-primary" name="add">Add</button>
			<?php endif; ?>
		</div>

	</form>
	</div>
	<?php
		try {

		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$page1=0;		
		if(isset($_GET["page"])){
			$page=$_GET["page"];

			if($page=="" || $page=="1"){
				$page1=0;
			}
			else{
				$page1=($page*3)-3;
			}
		}

		$stmt = $conn->prepare("SELECT * FROM emp limit $page1,3");
		$stmt->execute();
		$data = $stmt->fetchAll();

		
		foreach ($data as $row ) {
			
			$empObj = new employee();	
			
			$empObj->setID($row["emp_id"]);
			$empObj->setName($row["name"]);
			$empObj->setLogin($row["login"]);
			$empObj->setPassword($row["password_"]);
			$empObj->setDepartment($row["dept"]);
			$empObj->setSalary($row["salary"]);
			$empObj->setBoss($row["boss"]);
			$empObj->setDesignation($row["designation"]);
			$empObj->setPicture($row["picture"]);


		
			$emp_id=$row["emp_id"];
			// $name=$row["name"];
			// $dept=$row["dept"];
			// $salary=$row["salary"];
			// $boss=$row["boss"];//////////
			// $designation=$row["designation"];
			$picture=$row["picture"];

			echo "<div>";
			echo "Name: ".$empObj->getName()."<br>";
			echo "Department: ".$empObj->getDepartment()."<br>";
			echo "Salary: ".$empObj->getSalary()."<br>";
			echo "Boss: ".$empObj->getBoss()."<br>";
			echo "Designation: ".$empObj->getDesignation()."<br>";
			echo "<img src='img/$picture' style='width:100px;height:100px'/><br>";

			echo "<a href='hr.php?edit=$emp_id' class='btn btn-info' >Edit   </a>";
			echo "<a href='hr.php?delete=$emp_id' class='btn btn-danger' >Delete</a>";

			echo "</div>";
			unset($empObj);
		}
		echo "<br>";
		$stmt1 = $conn->prepare("SELECT * FROM emp ");
		$stmt1->execute();
		$count=$stmt1->rowCount();
		$pages=ceil($count/3);
		for($a=1;$a<=$pages;$a++){
			echo "<a href='hr.php?page=$a' style='text-decoration: none'>$a</a>  ";
		}
	} catch(PDOException $e) {
		echo "<br>" . $e->getMessage();
	}
	
	?>
</body>
</html>