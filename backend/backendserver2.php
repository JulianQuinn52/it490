#!/usr/bin/php
<?php

ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('../rmq/currenthost.inc');

function connectDB ($request){
	echo 'connecting to the database';
	$client = new rabbitMQClient(validateHost("db"),"testServer");
	$response = $client->send_request($request);
	return $response;	
}


function registerUser($request)
{
echo "attempting to register";
 if(isset($request['username']) && isset($request['password'])){
		echo 'username and password check worked';
		return connectDB($request);
		}
		else{
		$request['message'] = 'credentials are not set';
		$response['success'] = 0;
		return $request;
		}
}

function loginUser($request)
{
echo "attempting to log in";
if(isset($request['username']) && isset($request['password'])){
		echo 'username and password check worked';
		return connectDB($request);
		}
		else{
		$request['message'] = 'credentials are not set';
		$response['success'] = 0;
		return $request;
		}
}

function recommendation($request)
{
echo "attempting to make reccomendation";
if ( $request['workoutgoal'] > $request['weight'])
	$gain = true;
else
	$gain = false;
$response = connectDB($request);
if($response['success'] == 1){
switch($response['workouttype'])
{
case "Arms":{
if ($gain)
	$response['location'] = "../workouts/armgain.php";
else
	$response['location'] = "../workouts/armloss.php";
break;
}
case "Legs":{
echo "legs";
break;
}
case "Core":{
echo "core";
break;
}
case "Back":{
echo "back";
break;
}
case "Chest":{
echo "chest";
break;
}
case "Cardio":{
echo "cardio";
break;
}
default: 
echo "nothing happened";
}
}
return $response;



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

function testbe($request){		
		$request['message'] = 'credentials are     set';
		$response['success'] = 1;
		return $request;
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
	case "recommendation":
	 return recommendation($request);
	case "test":{
	 echo 'trying to return';
	 return test($request); 
	 echo "does this work?";
	 //$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	 //$response = $client->send_request($return);
     }
     case "testbe":{
	 echo 'trying to returnbe';
	 return testbe($request); 
     }
	default:{
     	 echo "request type invalid";
     	 return 0;
     	 
     	 
}

  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}


$server = new rabbitMQServer(validateHost("be"),"testServer");
$dbserver = new rabbitMQServer(validateHost("db"),"testServer");

echo "LISTENING";
$server->process_requests('requestProcessor');
$dbserver->process_requests('requestProcessor');
echo "DONE";
exit();
?>
