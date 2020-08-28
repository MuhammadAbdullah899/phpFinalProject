<?php
require('conn.php');

	//$date = date("Y-m-d");
	$date="2020-08-27";

	 try {
	   // set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	

		$stmt = $conn->prepare(" SELECT e.login FROM emp e
									inner join attendence a on a.emp_id = e.emp_id
								where a.status='absent' and a.curr_date='$date' ");
		$stmt->execute();
		$data = $stmt->fetchAll();
		
		foreach ($data as $row ) {

			echo $row["login"]."<br>";	
			////////////////////////////////////
			///Code for Email to Employee to notifiy him/her late
				





		}
	 	echo "\nEmail send successfully";
	 	
	} catch(PDOException $e) {
   		echo "<br>" . $e->getMessage();
	 }
?>