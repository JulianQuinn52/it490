#!/usr/bin/php
<?php


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(E_ALL);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doRegister($request)
{
//$client = new rabbitMQClient("testDatabase.ini","testServer");
echo 'trying to register';
    $hostname = '10.242.222.211';
    $dbuser = 'casey';
    $dbpass = 'it490project';
    $dbname = 'it490';
    $dbport = "3306";    
    $hostname2 = '10.242.244.173';
    $dbuser2 = 'repl';
    $dbpass2 = 'password';
    $dbname2 = 'it490';
    $dbport2 = "3306";
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname, $dbport);
	$username = $request['username'];
	$email = $request['email'];
	$password = $request['password'];
	$phone = $request['phone'];
	
    if (!$conn)
	{
		$conn = mysqli_connect($hostname2, $dbuser2, $dbpass2, $dbname2, $dbport2);
		if (!$conn)
		{
			echo "Error connecting to database: ".$conn->connect_errno.PHP_EOL;
			$client = new rabbitMQClient("testDatabase.ini","testServer");
			$request['success'] = 0;
			$request['message'] = "Connection failed"; 
			return $request;
			exit(1);
		}
	}
	echo "Connection Established".PHP_EOL;
	
    $query = "INSERT INTO `it490`.`users` (`username`, `email`, `password`, `phone`) VALUES ('$username', '$email', '$password', '$phone')";
        
    if (mysqli_query($conn, $query)) {
  	echo "New record created successfully";
	$client = new rabbitMQClient("testDatabase.ini","testServer");
			$request['success'] = 1;
			$request['message'] = "registration successful"; 
			return $request;
}   else {
  	echo "Error: " . $query . "<br>" . mysqli_error($conn);
$client = new rabbitMQClient("testDatabase.ini","testServer");
			$request['success'] = 0;
			$request['message'] = "registration failed"; 
			return $request;
}

mysqli_close($conn);
    
}

function doRecommendation($request)
{
//$client = new rabbitMQClient("testDatabase.ini","testServer");
echo 'trying to register';
    $hostname = '10.242.222.211';
    $dbuser = 'casey';
    $dbpass = 'it490project';
    $dbname = 'it490';
    $dbport = "3306";    
    $hostname2 = '10.242.244.173';
    $dbuser2 = 'repl';
    $dbpass2 = 'password';
    $dbname2 = 'it490';
    $dbport2 = "3306";
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname, $dbport);
	$height = $request['height'];
	$weight = $request['weight'];
	$age = $request['age'];
	$workoutgoal = $request['workoutgoal'];
	$workouttype = $request['workouttype'];
	
    if (!$conn)
	{
		$conn = mysqli_connect($hostname2, $dbuser2, $dbpass2, $dbname2, $dbport2);
		if (!$conn)
		{
			echo "Error connecting to database: ".$conn->connect_errno.PHP_EOL;
			$client = new rabbitMQClient("testDatabase.ini","testServer");
			$request['success'] = 0;
			$request['message'] = "Connection failed"; 
			return $request;
			exit(1);
		}
	}
	echo "Connection Established".PHP_EOL;
	
    $query = "INSERT INTO `it490`.`userdata` (`height`, `weight`, `age`, `workoutgoal`, `workouttype`) VALUES ('$height', '$weight', '$age', '$workoutgoal', '$workouttype')";
        
    if (mysqli_query($conn, $query)) {
  	echo "New record created successfully";
	$client = new rabbitMQClient("testDatabase.ini","testServer");
			$request['success'] = 1;
			$request['message'] = "recommendation successful"; 
			return $request;
}   else {
  	echo "Error: " . $query . "<br>" . mysqli_error($conn);
$client = new rabbitMQClient("testDatabase.ini","testServer");
			$request['success'] = 0;
			$request['message'] = "recommendation failed"; 
			return $request;
}

mysqli_close($conn);
    
}

function doLogin($request)
{
//$client = new rabbitMQClient("testDatabase.ini","testServer");
echo 'trying to login';

    $hostname = '10.242.222.211';
    $dbuser = 'casey';
    $dbpass = 'it490project';
    $dbname = 'it490';
    $dbport = "3306";
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname, $dbport);
    echo "trying to log in";

if (!$conn)
	{
		echo "Error connecting to database: ".$conn->connect_errno.PHP_EOL;
		$client = new rabbitMQClient("testDatabase.ini","testServer");
		$request['success'] = 0;
		$request['message'] = "Connection failed"; 
		exit(1);
		return $request;
	}
	echo "Connection Established".PHP_EOL;
	
	$username = $request['username'];
	$password = $request['password'];
	
	
	//Search database for username and password
	$search = "SELECT * FROM users WHERE username='$username' AND password= '$password'";
	
	//Check credentials
	$result = mysqli_query($conn, $search);
	if($result == false)
	{
		echo "Not Found";
		$client = new rabbitMQClient("testDatabase.ini","testServer");
			$request['success'] = 0;
			$request['message'] = "not found"; 
			return $request;
		$result=0;
	
	}
	if(mysqli_num_rows($result)==0)
	{
		echo "Correct Login";
	}
	else
	{
		while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			if($username=$row['username'] && $password=['password'])
			{
				echo "Succesful";
				$client = new rabbitMQClient("testDatabase.ini","testServer");
				$request['success'] = 1;
				$request['message'] = "login success"; 
				return $request;
			}
			else
			{
				echo "Not Found";
				$client = new rabbitMQClient("testDatabase.ini","testServer");
				$request['success'] = 0;
				$request['message'] = "login failed"; 
				return $request;
			}
		}
	
	}

}


function test($request)
{
	echo "test works on the database";
	//doRegister($request);
	$client = new rabbitMQClient("testDatabase.ini","testServer");
	//$response = $client->send_request($request);
	$request['success'] = 1;
	$request['message'] = "test message made it to the database and then made it back wahoo"; 
	return $request;
}

function requestProcessor($request)
{
  echo "received request";
  var_dump($request);
  if(!isset($request['type']))
  {
    echo "ERROR: unsupported message type";
    //return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
	case "register":
	 return doRegister($request);
	case "test":
	 return test($request);
	case "login": 
	return doLogin($request);
	case "reccomendation":
	 return doReccomendation($request);
	 default:{
	$client = new rabbitMQClient("testDatabase.ini","testServer");
	$request['success'] = 0;
	$request['message'] = "request type invalid"; 
	return $request;
	}
}
return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testDatabase.ini","testServer");

echo "databaseServer BEGIN";
$server->process_requests('requestProcessor');
echo "databaseServer END";
exit();
?>
