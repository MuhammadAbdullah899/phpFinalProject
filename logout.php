<?php
session_start();
	
	$_SESSION["empID"]=null;
	header("location: login.php");
	
?>