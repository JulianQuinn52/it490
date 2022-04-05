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
	echo 'response sent';
}


function registerUser($request)
{
    echo "attempting to register";
	if(!isset($request['username']) && !isset($request['password'])){
		echo 'credentials are not set';
		return 0;
	}
	else{
	return connectDB($request);
	}
}

function loginUser($request)
{
    echo "attempting to login";
	if(!isset($request['username']) && !isset($request['password'])){
		echo 'credentials are not set';
		return 0;
	}
	else{
	return connectDB($request);
	}
}

function test($request){
	echo 'test works on the backend';
	$client = new rabbitMQClient("testDatabase.ini","testServer");
	if(isset($request['username']) && isset($request['password'])){
		echo 'username and passowrd check worked';
		$result = connectDB($request)
		if $result == 1
			echo 'this is a good result';
		return connectDB($request);
	}
	if ($response == 1){
		echo 'it worked apparently';
		return $response;
	}
	else {
		echo 'database failed';
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
   /*
	case "login":
      return loginUser($request['username'],$request['password']);
    case "register":
      return registerUser($request['phonenumber'], $request['username'], $request['email'], $request['password']);
	case "test":
		return test($request['testmessage']);
		*/
	case "login":
	 return loginUser($request);
	case "register":
	 return registerUser($request);
	case "test":
	 return test($request);
  }
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "LISTENING";
$server->process_requests('requestProcessor');
echo "DONE";
exit();
?>
