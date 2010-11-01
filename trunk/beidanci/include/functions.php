<?php
include_once ("../../setting.php");
include_once ( ABSPATH . "include/db.php" );

function set_user_visit_time ($user_id)
{
	$db_name = "beidanci_db";
	$dbcnx = connect_db($db_name);
	$sql = "select * form bdc_users where user_id = $user_id;";
	$result = mysql_query($sql);
	if ( mysql_num_rows ($result) > 0 )
	{
		//更新
		$sql = "update bdc_users set user_last_visit = " . now() . " where user_id = $user_id;";
		$result = mysql_query($sql);
	}
	else
	{
		//插入
	}
	mysql_close ($dbcnx);
}

?>

