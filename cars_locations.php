<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['email']) ) {
		header("Location: index.php");
		exit;
	}

	// Check if filter is applied
	if(isset($_POST['myOfficeSelect'])) {
		$selectValue = $_POST['myOfficeSelect'];
		if ($selectValue == 'showAll')	{
		// Query to select all cars and show their current locations if available and no filter is applied
		$queryCars = "SELECT * FROM cars INNER JOIN offices ON cars.fk_office_id = offices.office_id ORDER BY car_name ";
		$resultCars = mysqli_query($conn, $queryCars);

		} else {

			// Query to show only selected filter cars
			$queryCars = "SELECT * FROM cars INNER JOIN offices ON cars.fk_office_id = offices.office_id  WHERE cars.fk_office_id = $selectValue ORDER BY cars.car_name ";
			$resultCars = mysqli_query($conn, $queryCars);
		}
	} else { 
		// Query to select all cars and show their current locations if available and no filter is applied
		$queryCars = "SELECT * FROM cars INNER JOIN offices ON cars.fk_office_id = offices.office_id ORDER BY car_name ";
		$resultCars = mysqli_query($conn, $queryCars);
	}
	
	
	

	// Query to display all 4 offices 
		
		$queryOffices = "SELECT * FROM offices ";
		$resultOffices = mysqli_query($conn, $queryOffices);
	

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
		<p class="h2">Choose from cars that are currently available</p>
		<p>Keep checking the page for when more cars are returned</p>
		<table class="table table-striped table-dark">
			<div class="form-group col-lg-4 col-xs-10 col-sm-8 col-md-6">
				<form method="post" action="" >
	                <label for="filter">Only show cars available at:</label>
	                <select id="filter" name="myOfficeSelect" class="form-control">
	                	<option value="showAll">Show All Locations</option>
	                	<?php while($rowOffices = mysqli_fetch_assoc($resultOffices)) 
	                		{ 
                		?>
	                		<option value="<?php echo $rowOffices['office_id'] ?>"><?php echo $rowOffices['office_location'] ?></option>
	                	<?php 
	                		} 
	                	?>
	                	
	                </select>
	                <input class="btn btn-primary my-2" name="submit" type="submit" value="Apply Filter">
           		</form>
            </div>
			<tr>
				<th>Car Name</th>
				<th>Currently Available at</th>
				<th>Office Name</th>
			</tr>
			<?php 
				// print_r(mysqli_fetch_assoc($resultCars));
				while($rowCars = mysqli_fetch_assoc($resultCars)) {
			?>
			<tr>
				<td><?php echo $rowCars['car_name']; ?></td>
				<td><?php echo $rowCars['office_location']; ?></td>
				<td><?php echo $rowCars['office_name']; ?></td>
				
				
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