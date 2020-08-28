<?php require('conn.php');
session_start();
if(isset($_SESSION["empID"])==false){
	header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Monthly Report</title>
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
		//$date = date("Y-m-d");
		//$date = "2020-08-26";
		try {
				// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
			$stmt = $conn->prepare("SELECT YEAR(curr_date) as 'year', MONTHNAME(curr_date) as 'month',
											SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present,
											SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent, 
									        SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late 
									FROM attendence
									WHERE status = 'present' OR status = 'absent' OR status = 'late'
									GROUP BY  YEAR(curr_date), MONTHNAME(curr_date)
									order by  YEAR(curr_date) , MonthNAME(curr_date)
									 ");
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
								<th>Year</th>
								<th>Month</th>
								<th>Present</th>
								<th>Absent</th>
								<th>Late</th>
							</tr>
						</thead>
						<?php foreach ($data as $row ){ ?>
							<tr>
								<td><?php echo $row['year']; ?></td>
								<td><?php echo $row['month']; ?></td>
								<td><?php echo $row['present']; ?></td>
								<td><?php echo $row['absent']; ?></td>
								<td><?php echo $row['late']; ?></td>
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