#!/usr/bin/php
<!DOCTYPE html>
<html>
  <head>
    <title>User data</title>
    <link rel="stylesheet" href="recommendation_style.css" />
  </head>
  <body>
      <div class="login-page">
        <div class="form">
          <form class="login-form" action="#" method="post" accept-charset="utf-8">
            <input type="text" name="height" placeholder="Enter your height:">
            <input type="number" name="weight" placeholder="Enter your weight:"> 
            <input type="number" name="age" placeholder="Enter your age"> 
            <input type="text" name="workoutgoal" placeholder="Enter your goal">
            <label for="workouttype">Workout Type</label>
                  <select name="workouttype" id="workouttype">
                    <option value="arms">Arms</option>
                    <option value="core">Core</option>
                    <option value="legs">Legs</option>
                    <option value="cardio">Cardio</option>
		    <option value="back">Back</option>
		    <option value="chest">Chest</option>
                  </select>
            <button type="submit" class="recommendbtn" id="btn">Get Recommendation</button>
          </form>
        </div>
      </div>
  </body>
</html>

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
$request['type'] = "recommendation";
$request['height'] = $_POST["height"];
$request['weight'] = $_POST["weight"];
$request['age'] = $_POST["age"];
$request['workoutgoal'] = $_POST["workoutgoal"];
$request['workouttype'] = $_POST["workouttype"];


$response = $client->send_request($request);

//echo $response['message'];

if ($response['success'] == 1)
echo "it worked";
//header("Location: $response['location']");
else
echo "it didn't work";

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

