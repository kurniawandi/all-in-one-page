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
if ( isset($_POST["word"]) && isset($_SESSION["user_id"]) )
{
	$db_name = "beidanci_db";
	$dbcnx = connect_db($db_name);
	//判断生词是否已经在生词本里，会消耗资源
	$sql = "select * from bdc_word_book where wb_user_id = " .$_SESSION["user_id"]. " and wb_word='" .$_POST["word"]. "';";
	$result = mysql_query($sql);
	if ( $result != false )
	{
		//笔记本中已有这个单词的记录
		if (mysql_num_rows($result) > 0)
		{
			mysql_close ($dbcnx);
			echo "EXIST";
		}
		else
		{
			$sql = "insert into bdc_word_book (wb_user_id, wb_word, wb_word_status, wd_record_time) ";
			$sql .= "values ('" .$_SESSION["bdc_user_id"]. "', '" .$_POST["word"]. "', 0, now());";
			$result = mysql_query($sql);
			mysql_close ($dbcnx);
			//插入成功
			if ( $result != false )
			{
				echo $_SESSION["user_id"];
				echo "OK";
			}
			else
			{
				echo "ERROR";
			}
		}
	}
	else
	{
		mysql_close ($dbcnx);
		echo "ERROR";
	}
}
else
{
	echo "NOTLOGGEDIN";
}


?>

