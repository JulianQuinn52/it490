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
	header("Location: index.php");
	exit();
} else {
	header("Location: form.php");
	exit();
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
