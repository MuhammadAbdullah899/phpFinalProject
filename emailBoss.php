<?php
require('conn.php');

	//$date = date("Y-m-d");
	$date = "2020-08-27";

	echo $date."<br>";

	 try {
	   // set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	

		$stmt = $conn->prepare("SELECT e.name , b.login	FROM emp e
								inner join emp b on e.boss=b.emp_id
								inner join attendence a on a.emp_id=e.emp_id
								where a.status = 'absent' and a.curr_date='$date' ");
		$stmt->execute();
		$data = $stmt->fetchAll();
		foreach ($data as $row ) {

			$name=$row["name"];
			echo $name."     ";			
			$email=$row["login"];
			echo $email."<br>";
		
			////////////////////////////////////
			///Code for Email to Boss to notify 
				


		}
		echo "\nEmail send successfully";
	 	
	} catch(PDOException $e) {
	 	echo "<br>" . $e->getMessage();
	 }
?>