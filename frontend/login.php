<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

$request = array();
$request['type'] = "login";
$request['username'] = $_POST["uname"];
$request['password'] = $_POST["psw"];
$request['success'] = 0;
$response = $client->send_request($request);


if($response['success'] == 1){
	$_SESSION["username"] = $_POST["username"];
        header("Location: index.php");
	
	
} else{
        header("Location: index.php");
	$msg = "Unauthorized.\nTry Again";
        echo "<script type='text/javascript'>alert('$msg');</script>";

}
	
	function requestProcessor($return)
{
echo "request processed";
echo $return;
return $return;
  
}
	
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "LISTENING";
$server->process_requests('requestProcessor');
echo "DONE";
echo $argv[0]." END".PHP_EOL;
exit();		
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Login</title>
<link rel="stylesheet" href="login_style.css">

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
<div id="login-form-wrap">
  <h2>Login </h2>
  <form id="login-form" action="loginpage.php" method="post">
    <p>
    <input type="text" id="username" name="username" placeholder="Username" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
    <input type="pwd" id="password" name="password" placeholder="Password" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
    <input type="submit" id="login" value="Login">
    </p>
  </form>
  <div id="create-account-wrap">
    <p>Not a member? <a href="form.php">Create Account</a><p>
  </div>
</div>
</body>
</html>