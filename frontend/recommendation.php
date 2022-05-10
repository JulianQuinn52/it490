<!DOCTYPE html>
<html>
  <head>
    <title>User data</title>
    <link rel="stylesheet" href="recommendation_style.css" />
  </head>
  <body>
  <body>
    <div class = "topnav">
            <button class = "button" onclick="location.href = 'index.php';"
     type="button" name="home" > Home </button>
            <button class = "button" onclick="location.href = 'form.php';"
     type="button" name="form" > Register </button>
            <button class = "button" onclick="location.href = 'login.php';"
     type="button" name="about" > Login </button>      	
        </div>
        <body>
      <div class="container">
        <div class="form">
          <form action ="recommendation.php" method="post" accept-charset="utf-8">
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");


$request = array();
$request['type'] = "recommendations";
$request['height'] = $_POST["height"];
$request['weight'] = $_POST["weight"];
$request['age'] = $_POST["age"];
$request['workoutgoal'] = $_POST["workoutgoal"];
$request['workouttype'] = $_POST["workouttype"];
$request['success'] = 0;
$response = $client->send_request($request);

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
