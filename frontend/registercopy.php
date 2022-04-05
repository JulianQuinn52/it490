<?php
//session_start();

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
	//$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- Frontend --- " . "Success: Registration successful using Username = " . $_POST["uname"] . " and Password = " . $_POST["psw"] . "\n";
	//log_event($event);
	//$usr = $_POST['uname'];
	//$email = $_POST['email'];
	//$output = shell_exec("python3 emailscript.py $usr $email");
	header("Location: index.html");
	exit();
} else {
	//$error = date("Y-m-d") . "  " . date("h:i:sa") . " --- Frontend --- " . "Error: failed to register using Username = " . $_POST["uname"] . " and Password = " . $_POST["psw"] . "\n";
	//log_event($error);
	//session_destroy();
	header("Location: form.html");
	exit();
}
//header("Location: signup.php");
exit();
}
?>
