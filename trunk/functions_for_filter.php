<?php

function connect_db ($db_name)
{
	//$db_name =  "vrwebmonitor";
	$dbcnx = mysql_connect("127.0.0.1","root","aids00a");
	if (!$dbcnx)
	{
		echo "Failed to connect db.\n";
		exit();
	}

	if (!mysql_select_db("$db_name", $dbcnx) )
	{
		echo "Failed to use db.\n";
		exit();
	}
	return $dbcnx;
}



?>
