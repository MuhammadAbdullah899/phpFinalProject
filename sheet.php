<?php
require('conn.php');

	$date = date("Y-m-d");
	echo $date;

	 try {
	   // set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	

		$stmt = $conn->prepare(" SELECT * FROM emp ");
		$stmt->execute();
		$data = $stmt->fetchAll();
		
		// begin the transaction
  		$conn->beginTransaction();

		foreach ($data as $row ) {
			
			$emp_id=$row["emp_id"];

			$stmt1 = $conn->prepare("INSERT INTO attendence (curr_date, time_in, time_out, status, emp_id)
													VALUES ('$date', null , null , 'absent', '$emp_id')");
			$stmt1->execute();	
		
		}
		// commit the transaction
		$conn->commit();
	 	echo "\nNew records created successfully";
	 	
	} catch(PDOException $e) {
	 	// roll back the transaction if something failed
   		$conn->rollback();
   		echo "<br>" . $e->getMessage();
	 }
?>