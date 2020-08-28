<?php require('conn.php'); 
include("utility.php");
require('empModel.php');
session_start();
$id=0;
$employee = new employee();
$update=FALSE;

if(isset($_POST['add']))
{
	$employee->setName($_REQUEST["name"]);
	$employee->setLogin($_REQUEST["login"]);
	$employee->setPassword($_REQUEST["password"]);
	$employee->setDepartment($_REQUEST["dept"]);
	$employee->setSalary($_REQUEST["salary"]);
	$employee->setBoss($_REQUEST["boss"]);
	$employee->setDesignation($_REQUEST["designation"]);
	
	
	$file=$_FILES["picture"];
	$srcPath=$file["tmp_name"];
	$fileName=$file["name"];
	
	$newName=saveFile($srcPath,$fileName);// this function is in "utility.php" file
	$employee->setPicture($newName);


	try {
	  // set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		$stmt = $conn->prepare("SELECT * FROM emp WHERE login='$employee->getLogin()' ");
		$stmt->execute();
		$recordsFound = $stmt->rowCount();
		if($recordsFound > 0)
		{
			$_SESSION['message']="Login already exist!";
			$_SESSION['msg_type']="danger";
			//unset($employee);
		}
		else
		{
			$stmt = $conn->prepare("INSERT INTO emp (name,login,password,dept,salary,picture,boss,designation)
			VALUES (:name, :login, :password, :dept, :salary, :picture, :boss, :designation)");
			$stmt->bindParam(':name', $employee->getName());
			$stmt->bindParam(':login', $employee->getLogin());
			$stmt->bindParam(':password', $employee->getPassword());
			$stmt->bindParam(':dept', $employee->getDepartment());
			$stmt->bindParam(':salary', $employee->getSalary());
			$stmt->bindParam(':picture', $employee->getPicture());
			$stmt->bindParam(':boss', $employee->getBoss());
			$stmt->bindParam(':designation', $employee->getDesignation());

			$stmt->execute();			

			$_SESSION['message']="Employee has been added!";
			$_SESSION['msg_type']="success";
			//unset($employee);
		}

	} catch(PDOException $e) {
		
		$_SESSION['message']="Book has not been added!";
		$_SESSION['msg_type']="danger";
		//unset($employee);
		echo "<br>" . $e->getMessage();
	}
	header("location: hr.php");
}
if(isset($_GET['delete']))
{	
	$emp_id = $_GET['delete'];
	try {
	  // set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "DELETE FROM emp WHERE emp_id='$emp_id' ";
		$conn->exec($sql);
		
		$_SESSION['message']="Employee has been deleted!";
		$_SESSION['msg_type']="danger";

	} catch(PDOException $e) {
		
		$_SESSION['message']="Employee has not been deleted!";
		$_SESSION['msg_type']="danger";
	  	echo "<br>" . $e->getMessage();
	}

	header("location: hr.php");
}
if(isset($_GET['edit']))
{
	$emp_id = $_GET['edit'];
	$update=TRUE;
	try {
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("SELECT * FROM emp WHERE emp_id='$emp_id' ");
		$stmt->execute();

		$recordsFound = $stmt->rowCount();
		if($recordsFound == 1)
		{
			$row = $stmt->fetch();
			$employee->setID($row['emp_id']);
			$employee->setName($row['name']);
			$employee->setLogin($row["login"]);
			$employee->setPassword($row["password"]);
			$employee->setDepartment($row["dept"]);
			$employee->setSalary($row["salary"]);
			$employee->setBoss($row["boss"]);
			$employee->setDesignation($row["designation"]);
			$employee->setPicture($row['picture']);
		}
	} catch(PDOException $e) {
		echo"<br>" . $e->getMessage();
	}
}
if(isset($_POST['update']))
{
	$employee->setID($_POST['emp_id']);
	$employee->setName($_REQUEST["name"]);
	$employee->setLogin($_REQUEST["login"]);
	$employee->setPassword($_REQUEST["password"]);
	$employee->setDepartment($_REQUEST["dept"]);
	$employee->setSalary($_REQUEST["salary"]);
	$employee->setBoss($_REQUEST["boss"]);
	$employee->setDesignation($_REQUEST["designation"]);


	$emp_id=$_POST['emp_id'];//emp_id is required  for update

	$file=$_FILES["picture"];
	$fileName=$file["name"];

	try {
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		$stmt = $conn->prepare("SELECT * FROM emp WHERE name='$employee->getName()' and login='$employee->getLogin()' and dept='$employee->getDepartment()' and picture='$fileName' and salary = '$employee->getSalary()' and boss='$employee->getBoss()' and designation='$employee->getDesignation()' ");

		$stmt->execute();
		$recordsFound = $stmt->rowCount();
		if($recordsFound > 0)
		{
			$_SESSION['message']="Employee already exist!";
			$_SESSION['msg_type']="danger";
		}
		else
		{
			$srcPath=$file["tmp_name"];
			$newName=saveFile($srcPath,$fileName);
			$employee->setPicture($newName);

			///Storing data in local variables
			///Because get function is not woring in update query	
			$nameL = $employee->getName();
			$salaryL = $employee->getSalary();
			$deptL = $employee->getDepartment();
			$picL = $employee->getPicture();
			$bossL = $employee->getBoss();
			$loginL = $employee->getLogin();
			$desgL = $employee->getDesignation();


			$sql = "UPDATE emp SET name='$nameL' , login='$loginL' , dept='$deptL' , picture='$picL' , salary = '$salaryL' , boss='$bossL' , designation='$desgL'  WHERE emp_id='$emp_id' ";
	
			$stmt1 = $conn->prepare($sql);
			$stmt1->execute();
	
			$_SESSION['message']="Employee has been updated successfully!";
			$_SESSION['msg_type']="warning";	
		}

	} catch(PDOException $e) {

		$_SESSION['message']="Employee has not been updated successfully!";
		$_SESSION['msg_type']="danger";
		echo "<br>" . $e->getMessage();
	}
	header("location: hr.php");
}
?>