<?php 
if(isset($_POST["save"])){

	$time_in = $_POST["time_in"];

	//$date = date("Y-m-d");

	//if (time() > strtotime("01:57")) {
	$time = date('H:i:s',strtotime("11 AM"));
	if($time_in < $time){
     // your code

		//$a = strtotime("11:00:00");
	//	$echo strtotime("11:00");
		
		echo "yes on time";
	}
	else{
		echo "no, late";
	}
			
}
?>	

<!DOCTYPE html>
<html>
<head>
<body>
	<form action= "test.php" method="POST">
		<input type="Time" name="time_in" ><br>
		<button type="submit" class="btn btn-primary" name="save">Save</button>
	</form>
</body>
</html>