<?php
session_start();
include_once("/var/www/setting.php");
include_once(ABSPATH . "include/db.php");
if ( isset($_POST["word"]) && isset($_SESSION["bdc_user_id"]) )
{
	//
	$db_name = "beidanci_db";
	$dbcnx = connect_db($db_name);
	$sql = "insert into bdc_known_words (kw_user_id, kw_word) values ('" .$_SESSION["bdc_user_id"]. "', '" .$_POST["word"]. "');";
	$result = mysql_query($sql);
	mysql_close ($dbcnx);
	if ( $result == false )
	{
		echo mysql_error();
	}
	else
	{
		echo "OK";
	}
}

?>

