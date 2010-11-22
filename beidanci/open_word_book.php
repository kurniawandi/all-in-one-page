<?php
/*
	已存在		EXIST
	插入成功	OK
	插入失败	ERROR
	未登录		NOTLOGGEDIN
*/

session_start();
include_once("/var/www/setting.php");
include_once(ABSPATH . "include/db.php");
if ( isset($_SESSION["user_id"]) )
{
	$db_name = "beidanci_db";
	$dbcnx = connect_db($db_name);
	$sql = "select * from bdc_word_book where wb_user_id=".$_SESSION["user_id"].";";
	$result = mysql_query($sql);
	mysql_close ($dbcnx);
}
else
{
	echo "NOTLOGGEDIN"
}
?>

