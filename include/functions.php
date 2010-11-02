<?php
include_once("/var/www/setting.php");
include_once(ABSPATH . "include/functions.php");

function get_show_name_by_id ($user_id)
{
	$db_name = "core_db";
	$dbcnx = connect_db($db_name);
	$sql = "select * from core_users where user_id = $user_id;";
	$result = mysql_query($sql);
	mysql_close ($dbcnx);
	if ( !$result )
	{
		throw new Exception ("Query error: Select failed.");
	}
	if ( mysql_num_rows($result) > 0 )
	{
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		return $row["user_show_name"];
	}
	return null;
}

?>

