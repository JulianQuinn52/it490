<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            Sign Up Page
        </title>
        <link rel = "stylesheet" href = "style.css">
    </head>
    <body>
    <div class = "topnav">
            <button class = "button" onclick="location.href = 'index.php';"
     type="button" name="home" > Home </button>
            <button class = "button" onclick="location.href = 'form.php';"
     type="button" name="form" > Register </button>
            <button class = "button" onclick="location.href = 'login.php';"
     type="button" name="about" > Login </button>
        </div>
        <body>

<form action="registercopy.php" method="post">
  <div class="container">
    <h2>Register</h2>
    <hr>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email:" name="email" id="email" required>
    
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username:" name="uname" id="uname" required>
    
    <label for="pnumber"><b>Phone Number</b></label>
    <input type="text" placeholder="Enter Phone Number:" name="pnumber" id="pnumber" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password:" name="psw" id="psw" required>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password:" name="psw-repeat" id="psw-repeat" required>
    <hr>
    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

    <button type="submit" class="registerbtn">Register</button>
  </div>
  
  <div class="container signin">
    <p>Already have an account? <a href="login.php">Sign in</a>.</p>
  </div>
</form>

</body>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");


$request = array();
$request['type'] = "register";
$request['username'] = $_POST["uname"];
$request['password'] = $_POST["psw"];
$request['email'] = $_POST["email"];
$request['phonenumber'] = $_POST["pnumber"]
$response = $client->send_request($request);

if($response == 1){
	$_POST["uname"] . " and Password = " . $_POST["psw"] . "\n";
	log_event($event);
	header("Location: index.php");
	exit();
} else {
	header("Location: form.php");
	exit();
}
exit();
}
?>
</html>
