<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['email']) ) {
		header("Location: index.php");
		exit;
	}

	// Query to select all cars
	$queryCars = "SELECT * FROM cars";
	$resultCars = mysqli_query($conn, $queryCars);

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
	<div class="container">
		<p class="h2">All of the cars that we have: </p>
		<div class="row">
			
			<?php while ($rowCars = mysqli_fetch_assoc($resultCars)) {
			?>
				<div class="col-sm-10 col-md-6 col-lg-4">

					<img src="<?php echo $rowCars['image_url'] ?>"  style="width: 100%;"></img>
					<p class="h4"><?php echo $rowCars['car_name'] ?></p>
					<div class="py-3"><p>Type of car: <?php echo $rowCars['car_type'] ?></p></div>
					<hr class="py-3">
				</div>
			<?php 
				}
			?>	
		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>