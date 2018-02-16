<?php
  ob_start();
  session_start(); // start a new session or continues the previous

  if( isset($_SESSION['email'])!="" ){
    header("Location: home.php"); // redirects to home.php
  }

  include_once 'dbconnect.php';

  $error = false;

  if ( isset($_POST['btn-signup']) ) {
    // sanitize user input to prevent sql injection

    $first_name = trim($_POST['first_name']);
    $first_name = strip_tags($first_name);
    $first_name = htmlspecialchars($first_name);

    $last_name = trim($_POST['last_name']);
    $last_name = strip_tags($last_name);
    $last_name = htmlspecialchars($last_name);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

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
    
    //basic email validation
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
      $error = true;
      $emailError = "Please enter valid email address.";
    } else {
      // check whether the email exist or not
      $query = "SELECT email FROM customers WHERE email='$email'";
      $result = mysqli_query($conn, $query);
      $count = mysqli_num_rows($result);
      
      if($count!=0){
        $error = true;
        $emailError = "Provided Email is already in use.";
      }
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
      $query = "INSERT INTO customers(first_name, last_name, email, password) VALUES('$first_name', '$last_name', '$email','$password')";
      $res = mysqli_query($conn, $query);
      
      if ($res) {
        // $errTyp = "success";
        // $errMSG = "Successfully registered, you may login now";
        header("Location: index.php?registerok");
        
        unset($first_name);
        unset($last_name);
        unset($email);
        unset($pass);
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <meta charset="UTF-8">
  <title>BigLibrary</title>

</head>

<body>

  <div class="container col-6">

    <form class="form-control" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
      <h2>Registration</h2>
      <hr />

      <?php
        if ( isset($errMSG) ) {
      ?>

        <div class="alert">
          <?php echo $errMSG; ?>
        </div>

      <?php
      }
      ?>
      <div class="form-group">
        <input  type="text" name="first_name" class="form-control" placeholder="Enter First Name" maxlength="50" value="<?php echo $first_name ?>" />
        <span class="text-danger"><?php echo $nameError; ?></span>
      </div>

      <div class="form-group">
        <input  type="text" name="last_name" class="form-control" placeholder="Enter Last Name" maxlength="50" value="<?php echo $last_name ?>" />
        <span class="text-danger"><?php echo $last_nameError; ?></span>
      </div>


      <div class="form-group">
        <input type="email" name="email" class="form-control" placeholder="Enter Your Email. You will need it to login. Cannot be changed later!" maxlength="40" value="<?php echo $email ?>" />
        <span class="text-danger"><?php echo $emailError; ?></span>
      </div>
      
      <div class="form-group">
        <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
        <span class="text-danger"><?php echo $passError; ?></span>
      </div>

      <hr />

      <button type="submit" class="btn btn-block btn-primary col-8 m-auto" name="btn-signup">Register</button>
      <hr />
      <a href="index.php">Already have an account? Log in here...</a>
    </form>
  </div>
  

  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>
<?php ob_end_flush(); ?>

