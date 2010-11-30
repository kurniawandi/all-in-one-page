<?php
session_start();
include_once("/var/www/setting.php");
include_once(ABSPATH . "include/db.php");
if ( isset($_POST["word"]) && isset($_SESSION["bdc_user_id"]) )
{
	//
	$db_name = "beidanci_db";
	$dbcnx = connect_db($db_name);
	$sql = "select * from global_garbage_words where ggw_word='".$_POST["word"]."';";
	$result = mysql_query($sql);
	if ( 0 < ($num_rows = mysql_num_rows($result)) )
	{
		$sql = "update global_garbage_words set ggw_times=ggw_times+1 where ggw_word='".$_POST["word"]."';";
		$result = mysql_query($sql);
	}
	else
	{
		$sql = "insert into global_garbage_words (ggw_word, ggw_times) values ('".$_POST["word"]."', 1);";
		$result = mysql_query($sql);
	}
	$sql = "insert into bdc_known_words (kw_user_id, kw_word) ";
	$sql .= "values ('" .$_SESSION["bdc_user_id"]. "', '" .$_POST["word"]. "');";
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

