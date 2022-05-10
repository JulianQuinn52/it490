<?php

function validateHost(string $type)
{
	$ips = ["10.242.196.151","10.242.242.207", "10.242.60.95"];
	$names =["Julian", "Mike", "Deep"];
	for ($i = 0; $i<count($ips); $i++){

		 exec("ping -c 4 " . $ips[$i], $output, $result);
			
			if ($result == 0)
			{
				$validhost = $names[$i];
				break;
			} 

			else
				$validhost = "invalid";
}

		switch ($validhost)
		{
			
		case "Julian":
			if($type == "db")
			{
				return "../rmq/databaseJ.ini";
			}
			else
			{
				return "../rmq/backendJ.ini";
			}
			case "Mike" :
				if($type == "db")
			{
				return "../rmq/databaseM.ini";
			}
			else
			{
				return "../rmq/backendM.ini";
			}
			case "Deep" :
			if($type == "db")
			{
				return "../rmq/databaseD.ini";
			}
			else
			{
				return "../rmq/backendD.ini";
			}
		}
}


?>
