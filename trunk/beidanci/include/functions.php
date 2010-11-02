<?php
include_once ("../../setting.php");
include_once ( ABSPATH . "include/db.php" );

//给未登录用户产生随机ID
function rand_id ()
{
	//为使随机数的乱度最大，每次在取随机数之前最好使用srand()以配置新的随机数种子
	srand((double)microtime()*1000000);
	//用户ID是7位，从1000000开始
	return rand(1000, 999999);
}

function generate_user ($user_id)
{

}

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
		$sql = "insert into bdc_users (user_id, user_level, user_last_visit) values ('" . $user_id . "', '" . . "', now());";
		$result = mysql_query($sql);
	}
	mysql_close ($dbcnx);
}

function set_user_level ($user_id, $level)
{
	$db_name = "beidanci_db";
	$dbcnx = connect_db($db_name);
	$sql = "select * form bdc_users where user_id = $user_id;";
	$result = mysql_query($sql);
	if ( mysql_num_rows ($result) > 0 )
	{
		//更新
		$sql = "update bdc_users set user_level = $level where user_id = $user_id;";
		$result = mysql_query($sql);
	}
	mysql_close ($dbcnx);
}

?>

