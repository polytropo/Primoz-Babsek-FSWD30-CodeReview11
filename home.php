<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['email']) ) {
		header("Location: index.php");
		exit;
	}
	// select logged-in users detail
	$userEmail = $_SESSION['email'];
	$query = "SELECT * FROM customers WHERE email= '$userEmail'";
	$res = mysqli_query($conn, $query);
	$userRow = mysqli_fetch_assoc($res);
	
	// Fast check to see your assoc array
	// print_r($userRow);  
	
	//  display all orders for user
	$queryOrders = "SELECT start_date, return_date, car_name FROM orders INNER JOIN customers ON orders.fk_email = customers.email INNER JOIN cars ON orders.fk_car_id = cars.car_id WHERE email = '$userEmail' ";
	$resultOrders = mysqli_query($conn, $queryOrders);
	

	// upating personal info - - - - - - - - - - - - - - - - - - - - - -- 

	if ( isset($_POST['btn-update']) ) {
    // sanitize user input to prevent sql injection

    $first_name = trim($_POST['first_name']);
    $first_name = strip_tags($first_name);
    $first_name = htmlspecialchars($first_name);

    $last_name = trim($_POST['last_name']);
    $last_name = strip_tags($last_name);
    $last_name = htmlspecialchars($last_name);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    // basic name validation

    if (empty($first_name)) {
      $error = true;
      $nameError = "Please enter your first name.";

    } else if (strlen($first_name) < 3) {
      $error = true;
      $nameError = "Name must have atleat 3 characters.";

    } else if (!preg_match("/^[a-zA-Z ]+$/",$first_name)) {

      $error = true;
      $nameError = "Name must contain alphabets and space.";
    }

    //basic last name validation
    if (empty($last_name)) {
      $error = true;
      $last_nameError = "Please enter your last name.";

    } else if (strlen($last_name) < 3) {
      $error = true;
      $last_nameError = "Lastname must have atleat 3 characters.";

    } else if (!preg_match("/^[a-zA-Z ]+$/", $last_name)) {

      $error = true;
      $last_nameError = "Lastname must contain alphabets and space.";
    } 
    
    
    // password validation
    if (empty($pass)){
      $error = true;
      $passError = "Please enter password.";
    } else if(strlen($pass) < 6) {
      $error = true;
      $passError = "Password must have atleast 6 characters.";
    }
    // password encrypt using SHA256();
    $password = hash('sha256', $pass);
    
    // if there's no error, continue to signup
    if( !$error ) {
      $query = "UPDATE customers SET first_name='$first_name', last_name='$last_name', password='$password' WHERE email= '$userEmail' ";
      $res = mysqli_query($conn, $query);
      
      if ($res) {
        // $errTyp = "success";
        $errMSG = "Successfully updated your personal info";
                
        unset($first_name);
        unset($last_name);
        unset($email);
        
      } else {
        // $errTyp = "danger";
        $errMSG = "Something went wrong, try again later...";
      }
    }
  }



?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
  	<meta charset="UTF-8">
  	<title>Home</title>
	
</head>

<body>
	<?php include "navbar.php"; ?>
	<div class="row mx-auto">
		<div class="px-5 py-3 col-md-5 col-xs-12">	
			<!-- <h2>Hi <?php echo ucwords($userRow['first_name'] . " " . $userRow['last_name']) . ", welcome."; ?></h2> -->
			<p class="h2">Logged In As - <?php echo $userRow['email']; ?></p>
			<a href="logout.php?logout">Sign Out</a>
		</div>
		<div class="col-md-7 col-xs-5 py-5">
			<p>This is your own dashboard where you can edit your account info and see your past reservations.</p>
			<p>Use navbar to easily navigate through the pages.</p>

		</div>
		<div class="col-md-4 col-xs-12">
			<!-- - - - - -  Show reservations user has made - - - - - - -->
			<p class="h3">Your orders: <hr></p>
			<table class="table table-dark">
				<tr>
					<th>Borrowed On: </th>
					<th> Returned On: </th>
					<th> Car: </th>
				</tr>
				<?php
					;
					while ($rowOrders = mysqli_fetch_assoc($resultOrders)) {

				?>
				<tr>
					<td><?php echo $rowOrders['start_date']; ?></td>
					<td><?php echo $rowOrders['return_date']; ?></td>
					<td><?php echo $rowOrders['car_name']; ?></td>
				</tr>
				<?php
					}
				?>
				
			</table>

		</div>
		
		<!-- - - - - - -  - Show edit user info form - - - - - - -  -->
		<div class="col-md-7 col-xs-12 offset-md-1">
			<form class="form-control" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
      <h2>Update</h2>
      <hr />

      <?php
        if ( isset($errMSG) ) {
      ?>

        <div class="alert bg-success text-white">
          <?php echo $errMSG; ?>
        </div>

      <?php
      }
      ?>
      <div class="form-group">
        <input  type="text" name="first_name" class="form-control" placeholder="Enter First Name" maxlength="50" value="<?php 
        if(isset($_POST['btn-update'])) {
        	echo $_POST['first_name'];
        } else {
        	echo $userRow['first_name'];
        	
        }
        ?> " />
        <span class="text-danger"><?php echo $nameError; ?></span>
      </div>

      <div class="form-group">
        <input  type="text" name="last_name" class="form-control" placeholder="Enter Last Name" maxlength="50" value="<?php 
        if(isset($_POST['btn-update'])) {
        	echo $_POST['last_name'];
        } else {
        	echo $userRow['last_name'];
        	
        }
        ?> " />
        <span class="text-danger"><?php echo $last_nameError; ?></span>
      </div>
      
      <div class="form-group">
        <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="25" />
        <span class="text-danger"><?php echo $passError; ?></span>
      </div>

      <hr />

      <button type="submit" class="btn btn-block btn-primary col-8 m-auto" name="btn-update">Update</button>
      <hr />
      
    </form>
		</div>
		<!-- Show list of available cars + locations where they are available, show list of cars that are notavailable on which date they will be-->
	</div>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
</body>
</html>

<?php ob_end_flush(); ?>