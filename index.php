<?php
  ob_start();
  session_start();
  require_once 'dbconnect.php';

  // it will never let you open index(login) page if session is set
  if ( isset($_SESSION['email'])!="" ) {
    header("Location: home.php");
    exit;
  }

  $error = false;

  if( isset($_POST['btn-login']) ) {
    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
  
    // prevent sql injections / clear user invalid inputs
    if(empty($email)){
      $error = true;
      $emailError = "Please enter your email address.";
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
      $error = true;
      $emailError = "Please enter valid email address.";
    }

    if(empty($pass)){
      $error = true;
      $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {
      $password = hash('sha256', $pass); // password hashing using SHA256
      $query = "SELECT first_name, last_name, email, password FROM customers WHERE email='$email'";
      $res = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($res);
      $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
      
      // print_r($row); Use it for a fast check to see what is included in $row assoc array!
      
      if( $count == 1 && $row['password']==$password ) {
        $_SESSION['email'] = $row['email'];
        header("Location: home.php");
      } else {
        $errMSG = "Incorrect Credentials, Try again...";
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
    <?php if(isset($_GET['registerok'])) {
    ?>
      <div class="p-3 mb-2 bg-success text-white">Account created successfully, log in below.</div>
    <?php
      }
    ?>
    <form class="form-control" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
      <h2>Log In.</h2>
      <hr />
      <?php
        if ( isset($errMSG) ) {
          echo $errMSG; ?>
        <?php
        }
      ?>
      <div class="form-group">
        <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="50" />
        <span class="text-danger"><?php echo $emailError; ?></span>
      </div>
      <div class="form-group">
        <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="20" />
        <span class="text-danger"><?php echo $passError; ?></span>
      </div>
      
      <hr />
      <button class="btn btn-block btn-primary col-8 m-auto" type="submit" name="btn-login">Log In</button>
      <hr />
      <a href="register.php">New to site? Create an account here...</a>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>

<?php ob_end_flush(); ?>