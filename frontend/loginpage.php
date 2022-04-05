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
$response = $client->send_request($request);
//$errFlag = False;
//$nameErr = False;
//$passErr = False;

if($response == 1){
	//$error = date("Y-m-d") . "  " . date("h:i:sa") . "  --- Frontend --- " . "Error: failed to login using Username = " . $_POST["uname"] . " and Password = " . $_POST["psw"] . "\n";
	//log_event($error);
	//response received, user authorized
	$_SESSION["username"] = $_POST["username"];
        header("Location: index.html");
	
	
} else{
	//$event = date("Y-m-d") . "  " . date("h:i:sa") . "Login successful using Username = " . $_POST["username"] . " and Password = " . $_POST["password"] . "\n";
	//log_event($event);
	
	//user not found
        header("Location: login.html");
	$msg = "Unauthorized.\nTry Again";
        echo "<script type='text/javascript'>alert('$msg');</script>";

}

exit();		
}
?>

