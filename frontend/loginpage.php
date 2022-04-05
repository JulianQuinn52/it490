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

if($response == 1){
	$_SESSION["username"] = $_POST["username"];
        header("Location: index.html");
	
	
} else{
        header("Location: login.html");
	$msg = "Unauthorized.\nTry Again";
        echo "<script type='text/javascript'>alert('$msg');</script>";

}

exit();		
}
?>

