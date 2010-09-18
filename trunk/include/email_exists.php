<?php

include_once("./db.php");
if ( isset($_POST["email"]) )
{
	sleep(1);
	$db_name = "core_db";
	$dbcnx = connect_db($db_name);
	$sql = "select count(*) as amount from core_users where user_email=\"" . $_POST["email"] . "\";";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result); 
	$amount = $row[0];
	mysql_close ($dbcnx);
	echo $amount;
}

?>

