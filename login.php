<?php 
require('conn.php');
?>
<?php
	try {

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if(isset($_POST["LOGIN"])){
		$login = $_POST["login"];
		$password = $_POST["password"];

		$stmt = $conn->prepare("SELECT * FROM emp where login = '$login' and password_ = '$password' ");

		$stmt->execute();
		$recordFound = $stmt->rowCount();
		if($recordFound === 1){
			echo "Login sucessfully";
			header("location: hr.php");
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
<body>
	
	<h1>Login </h1></br>
	
	<form action= "login.php" method="POST">	
			<label>Login: </label>
			<input type="text" placeholder="login. . ." name="login"  required><br> 
		    <label>Password: </label>
			<input type="password" placeholder="Password" name="password" required><br>

			<button type="submit" name="LOGIN">Log In</button>
	</form>


</body>
</html>