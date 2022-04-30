#!/usr/bin/php
<?php

ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function connectDB ($request){
	echo 'connecting to the database';
	$client = new rabbitMQClient("testDatabase.ini","testServer");
	$response = $client->send_request($request);
	return $response;	
}


function registerUser($request)
{
    echo "attempting to register";
	return connectDB($request);
}

function loginUser($request)
{
    echo "attempting to login";
	return connectDB($request);
}

function test($request){
	if(isset($request['username']) && isset($request['password'])){
		echo 'username and passowrd check worked';
		return connectDB($request);
		}
		else{
		$request['message'] = 'credentials are not set';
		$response['success'] = 0;
		return $request;
		}
} 

function requestProcessor($request)
{
  echo "received request";
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
	case "login":
	 return loginUser($request);
	case "register":
	 return registerUser($request);
	case "test":{
	 echo 'trying to return';
	 return test($request); 
	 echo "does this work?";
	 //$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	 //$response = $client->send_request($return);
     }
	default:{
     	 echo "request type invalid";
     	 return 0;
}

  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}


$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
$dbserver = new rabbitMQServer("testDatabase.ini","testServer");

echo "LISTENING";
$server->process_requests('requestProcessor');
$dbserver->process_requests('requestProcessor');
echo "DONE";
exit();
?>
