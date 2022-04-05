#!/usr/bin/php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doRegister($fname, $username, $email, $password)
{
    $hostname = 'localhost';
    $dbuser = 'root';
    $dbpass = 'admin';
    $dbname = 'project';
    $dbport = "3306";
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname, $dbport);
	
    if (!$conn)
	{
		echo "Error connecting to database: ".$conn->connect_errno.PHP_EOL;
		exit(1);
	}
	echo "Connection Established".PHP_EOL;
	
    $query = "INSERT INTO `Project`.`users` (`username`, `email`, `password`, phonenumber') VALUES ('$username', '$email', '$email', '$password')";
    
//    $query = "INSERT INTO `Project`.`user` (`first_name`, `username`, `email`, `password`) VALUES ('bob', 'bob', 'bob@gmail.com', 'bobby')";
    
    if (mysqli_query($conn, $query)) {
  	echo "New record created successfully";
  	return true;
}   else {
  	echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
    
    //$sql = "INSERT INTO `PROJECT`.`Users` (`userid`, `name`, `username`, `email`, `password`, `Security Answer 1`, `Security Answer 2`) VALUES (123, '$username', '$fname + " "$lname', '$email', '$password', '$seca1', '$seca2')";

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
  return doRegister($request['username'], $request['password'], $request['email'], $request['phonenumber']);
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testDatabase.ini","testServer");

echo "testRabbitMQServer BEGIN";
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END";
exit();
?>
