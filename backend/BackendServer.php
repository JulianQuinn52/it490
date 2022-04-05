#!/usr/bin/php
<?php

ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function registerUser($phone_number, $username, $email, $password)
{
    $hostname = '10.242.222.211';
    $dbuser = 'casey';
    $dbpass = 'it490project';
    $dbname = 'it490';
    $dbport = "3306";
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname, $dbport);
	
    if (!$conn)
	{
		echo "Error connecting to database: ".$conn->connect_errno.PHP_EOL;
		exit(1);
	}
	echo "Connection Established".PHP_EOL;
	
    
    $username = strtolower(trim($username));
    $email = trim($email); 
    
	
    $query = "INSERT INTO `it490`.`users` (`username`, `email`, `password`, `phone_number`) VALUES ('$username', '$email', '$password', '$phone_number)";
    
    
    if (mysqli_query($conn, $query)) {
  	echo "New record created successfully";
  	return 1;
}   else {
  	echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
    
}

function loginUser($username,$password)
{
    $hostname = '10.242.222.211';
    $dbuser = 'casey';
    $dbpass = 'it490project';
    $dbname = 'it490';
    $dbport = "3306";
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname, $dbport);
	
    if (!$conn)
	{
		echo "Error connecting to database: ".$conn->connect_errno.PHP_EOL;
		exit(1);
	}
	echo "Connection Established".PHP_EOL;
	
	$username = strtolower(trim($username));
	
	// lookup username and password in database
	$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
	// check username and password
	
	$result = mysqli_query($conn, $sql);
	if($result == false)
	{
		echo "Not authorized";
		$result=0;
		
	}
	if (mysqli_num_rows($result)==0)
	{
		echo "User Not Found";
	}
	else
	{
		while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			if ($username = $row['username'] && $password = ['password'])
			{
				echo "Authorized";
				return 1;
			}
			else
			{
				echo "Incorrect username/password";
				return 2;
				
			}
		}
	}
}

function test($testmessage){
	echo "test works";
	echo $testmessage;
	return $testmessage;
}

function processor($request)
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
      return loginUser($request['username'],$request['password']);
    case "register":
      return registerUser($request['phonenumber'], $request['username'], $request['email'], $request['password']);
	case "test":
		return test($request['testmessage']);
  }
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "LISTENING";
$server->process_requests('processor');
echo "DONE";
exit();
?>
