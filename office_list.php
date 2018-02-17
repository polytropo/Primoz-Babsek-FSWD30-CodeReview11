<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['email']) ) {
		header("Location: index.php");
		exit;
	}

	// Query to get all offices and show amount of cars in each office
	$queryOffice = "SELECT office_name, office_location, COUNT(cars.car_id) AS car_number FROM offices LEFT JOIN cars ON offices.office_id = cars.fk_office_id WHERE cars.longitude IS NULL AND cars.latitude IS NULL GROUP BY offices.office_name ORDER BY car_number DESC, office_name ";
	$resultOffice = mysqli_query($conn, $queryOffice);
	
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Offices</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<?php include "navbar.php"; ?>
	<div class="col-10 mx-auto">
		<p class="h2">We currently have offices at 4 locations across Vienna</p>
		<p>You can quickly see how many cars does each office have currently</p>
		<table class="table table-striped table-dark">
			<tr>
				<th>Office Name</th>
				<th>Office Location</th>
				<th>Number of avilable cars</th>
			</tr>
			<?php 
				while($rowOffice = mysqli_fetch_assoc($resultOffice)) {
			?>
			<tr>
				<td><?php echo $rowOffice['office_name']; ?></td>
				<td><?php echo $rowOffice['office_location']; ?></td>
				<td><?php echo $rowOffice['car_number']; ?></td>
				
			</tr>
			<?php
				}
			?>
		</table>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>