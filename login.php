<?php 
require('conn.php');
session_start();
?>
<?php
	try {

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if(isset($_POST["LOGIN"])){
		$login = $_POST["login"];
		$password = $_POST["password"];

		$stmt = $conn->prepare("SELECT * FROM emp where login = '$login' and password = '$password' ");

		$stmt->execute();
		$recordFound = $stmt->rowCount();

		if($recordFound === 1){

			$row = $stmt->fetch();
			$_SESSION["empID"] = $row["emp_id"];

			if($row["designation"] === "HR Manager"){
				echo "Login sucessfully";
				header("location: hr.php");
			}else{
				header("location: attendance.php");
			}
		}else {
			echo"Not Login";
		}
	}

} catch(PDOException $e) {
	
	echo "<br>" . $e->getMessage();
}

?>	

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
	body{
  margin: 0 auto 0 auto;  
  width:100%; 
  text-align:center;
  margin: 40px 0px 40px 0px;   
}

.box{
  background:white;
  width:300px;
  border-radius:6px;
  margin: 0 auto 0 auto;
  padding:0px 0px 70px 0px;
  border: #2980b9 4px solid; 
}

.login{
  background:#ecf0f1;
  border: #ccc 1px solid;
  border-bottom: #ccc 2px solid;
  padding: 8px;
  width:250px;
  color:#AAAAAA;
  margin-top:10px;
  font-size:1em;
  border-radius:4px;
  margin-bottom: 10px;
}

.password{
  border-radius:4px;
  background:#ecf0f1;
  border: #ccc 1px solid;
  padding: 8px;
  width:250px;
  font-size:1em;
}

.btn{
  background:#2ecc71;
  width:125px;
  padding-top:5px;
  padding-bottom:5px;
  color:white;
  border-radius:4px;
  border: #27ae60 1px solid;
  
  margin-top:20px;
  margin-bottom:20px;
  float:left;
  margin-left:90px;
  font-weight:800;
  font-size:0.8em;
}
</style>
<body>
	
	<h1>Login </h1></br>
	
	<form action= "login.php" method="POST">
		<div class="box">	
			<input type="text" placeholder="Email. . ." name="login" class="login" required><br> 
			<input type="password" placeholder="Password" name="password" class="password" required><br>

			<button type="submit" name="LOGIN" class="btn">Log In</button>
		</div>
	</form>


</body>
</html>