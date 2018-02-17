<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['email']) ) {
		header("Location: index.php");
		exit;
	}

	// Get gps locations for cars from mysql
	$queryGPS = "SELECT car_name FROM cars WHERE latitude IS NOT NULL AND longitude IS NOT NULL ";
	$resultGPS = mysqli_query($conn, $queryGPS);
	
	// Check if filter is applied
	if(isset($_POST['myOfficeSelect'])) {
		$selectValue = $_POST['myOfficeSelect'];
		if ($selectValue == 'showAll')	{
		// Query to select all cars and show their current locations if available and no filter is applied
		$queryCars = "SELECT * FROM cars INNER JOIN offices ON cars.fk_office_id = offices.office_id WHERE cars.latitude IS NULL AND cars.longitude IS NULL ORDER BY car_name ";
		$resultCars = mysqli_query($conn, $queryCars);

		} else {

			// Query to show only selected filter cars
			$queryCars = "SELECT * FROM cars INNER JOIN offices ON cars.fk_office_id = offices.office_id  WHERE cars.fk_office_id = $selectValue AND cars.latitude IS NULL AND cars.longitude IS NULL ORDER BY cars.car_name ";
			$resultCars = mysqli_query($conn, $queryCars);
		}
	} else { 
		// Query to select all cars and show their current locations -- same as above in if statement
		$queryCars = "SELECT * FROM cars INNER JOIN offices ON cars.fk_office_id = offices.office_id WHERE cars.latitude IS NULL AND cars.longitude IS NULL ORDER BY car_name ";
		$resultCars = mysqli_query($conn, $queryCars);
	}

	// Query to display all offices in select filter
		
		$queryOffices = "SELECT * FROM offices ";
		$resultOffices = mysqli_query($conn, $queryOffices);


	// Query to display all offices longitude and latitude in select filter and write it info json file
		
		$queryGPSOffices = "SELECT longitude, latitude FROM offices";
		$resultGPSOffices = mysqli_query($conn, $queryGPSOffices);
		$arrayGPSOffices = array();
		while($rowGPSOffices = mysqli_fetch_assoc($resultGPSOffices)) {
			$arrayGPSOffices[] = $rowGPSOffices;
		}
		
		// Write to json file
		$fp = fopen('officesdata.json', 'w');
		fwrite($fp, json_encode($arrayGPSOffices));
		fclose($fp);	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Offices</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style>
    #map{
      height:400px;
      width:100%;
    }
  </style>
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
				<th></th>
				<th>Car Name</th>
				<th>Currently Available at</th>
				<th>Office Name</th>

			</tr>
			<?php 
				// print_r(mysqli_fetch_assoc($resultCars));
				while($rowCars = mysqli_fetch_assoc($resultCars)) {
			?>
			<tr>
				<td><img src="<?php echo $rowCars['image_url']; ?>" style="width:50px; height:50px";></td>
				<td><?php echo $rowCars['car_name']; ?></td>
				<td><?php echo $rowCars['office_location']; ?></td>
				<td><?php echo $rowCars['office_name']; ?></td>
				
				
			</tr>
			<?php
				}
			?>
		</table>
		<h1 class="pt-5">Locations of all cars</h1>
		<p class="">If a car is on the road and currently unavailable you will see it marked as redIcon. You can also see our locations with blueIcon.</p>
		<div id="map"></div>
	</div>

	
	<!-- - - - - - - - -   Code for google maps - - - - - - - - -  -->
	<script src="script.js"></script>
	<script>

		function initMap(){
		  // Map options
		  
		  var options = {
		    zoom:12,
		    center:{lat:48.2078430,lng:16.4377690}
		  }

		// New map
		var map1 = new google.maps.Map(document.getElementById('map'), options);

		// Add marker
		  
		var image1 = {
		    url: 'carmoving.png', // url
		    scaledSize: new google.maps.Size(50, 50), // scaled size
		    origin: new google.maps.Point(0,0), // origin
		    anchor: new google.maps.Point(0, 0) // anchor
		};

		var image2 = {
		    url: 'offices.png', // url
		    scaledSize: new google.maps.Size(50, 50), // scaled size
		    origin: new google.maps.Point(0,0), // origin
		    anchor: new google.maps.Point(0, 0) // anchor
		};


		// Add A marker without a function
		// var markerCar1 = new google.maps.Marker({
		// 	position:{lat:48.214627,lng:16.393657},
		// 	map : map1,
		// 	icon: image1
		// });


		
		function officeMarkers(longitude, latitude, image, text) {
			new google.maps.Marker({
				
				position:{lat:parseFloat(longitude),lng:parseFloat(latitude)},
				map : map1,
				icon: image,
				content: text
			
			});
		}


		var markerOffice1 = officeMarkers(48.178047, 16.394657,image2,'Office 1');
		var markerOffice2 = officeMarkers(48.178761, 16.375388,image2,'Office 2');
		var markerOffice3 = officeMarkers(48.225202, 16.342203,image2,'Office 3');
		var markerOffice4 = officeMarkers(48.215956, 16.385990,image2,'Office 4');
		var markerCar1 = officeMarkers(48.214627, 16.393657,image1,'Car 3');
		

		// var infoWindow = new google.maps.InfoWindow({
		// 	content:'<h1>Lynn Ma</h1>'
		// })
		// marker.addEventListener('click', function(){
		// 	infoWindow.open(map, marker);
		// });		

		 
	}
		  
	
		  
		  
		
  	</script>
  	<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGWEgwJqV-QMS51BZWS3_dcXVdncwZelM&callback=initMap">
    </script>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>