#!/usr/bin/php
<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doRegister($request)
{
echo 'trying to register';
    $hostname = '10.242.222.211';
    $dbuser = 'casey';
    $dbpass = 'it490project';
    $dbname = 'it490';
    $dbport = "3306";
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname, $dbport);
	$username = $request['username'];
	$email = $request['email'];
	$password = $request['password'];
	$phonenumber = $request['phone'];
	
    if (!$conn)
	{
		echo "Error connecting to database: ".$conn->connect_errno.PHP_EOL;
		exit(1);
	}
	echo "Connection Established".PHP_EOL;
	
    $query = "INSERT INTO `it490`.`users` (`username`, `email`, `password`, `phone`) VALUES ('$username', '$email', '$password', '$phonenumber')";
        
    if (mysqli_query($conn, $query)) {
  	echo "New record created successfully";
  	return true;
}   else {
  	echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
    
}

function doLogin($request)
{

echo 'trying to login';
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
	
	$username = $request['username'];
	$password = $request['password'];
	
	//Search database for username and password
	$search = "SELECT * FROM users WHERE username='$username' AND password= '$password'";
	
	//Check credentials
	$result = mysqli_query($conn, $search);
	if($result == false)
	{
		echo "Not Found";
		$result=0;
	
	}
	if(mysqli_num_rows($result)==0)
	{
		echo "Incorrect Login";
	}
	else
	{
		while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			if($username=$row['username'] && $password=['password'])
			{
				echo "Succesful";
				return 1;
			}
			else
			{
				echo "Not Found"
				return 2;
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
	case "login":
	 return doLogin($request);
	case "test":
	 return test($request);
	 default:{
	echo "request type invalid";
	return 0;
	}
  }
return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$ip = ["10.242.222.211", "10.242.244.173"];
$num=0;
for ($i=0; $i<count($ip); $i++)
{
	$host = $ip[$i];
	exec("ping -c 2" . $host, $output, $result);
	
	if($result==0)
	{
		echo PHP_EOL. "[*] ".$host." is Online".PHP_EOL;
		break;
	}
	else
	{
		echo PHP_EOL. "[*] ".$host." is Offline".PHP_EOL;
		$host = "off";
	}

}
if ($host == "10.242.222.211")
{
	$node="testDatabase.ini";
	echo $node .PHP_EOL;
}

if ($host == "10.242.244.173")
{
	$node="testDatabase.ini";
	echo $node .PHP_EOL;
}

if ($host == "off")
{
	$node="No Machine is running";
	echo $node .PHP_EOL;
}

$server = new rabbitMQServer($node,"testServer");

echo "databaseServer BEGIN";
$server->process_requests('requestProcessor');
echo "databaseServer END";
exit();
?>
