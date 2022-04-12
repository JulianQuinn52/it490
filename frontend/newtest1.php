#!/usr/bin/php
<?php
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
echo 'sending';

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = "test";
$request['message'] = "bruh";
$request['username'] = "julian";
$request['password'] = "iloveIT490";
$request['email'] = "evil@evil.net";
$request['phonenumber'] = "6116626063";
$request['success'] = 0;
//JMZLAYBLIUXWEBTCDESC

$response = $client->send_request($request);

echo $response['message'];

if ($response['success'] == 1)
	echo 'incredible!';
else
	echo 'bad bad bad bad bad bad bad';

echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";
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
?>
