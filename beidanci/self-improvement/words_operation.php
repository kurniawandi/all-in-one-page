<?php
/*
标识例外的单词
传入的变量：
$_POST["tab_name"]
$_POST["exceptive_word"]	//用户找出的例外的单词
$_POST["operation"]	//用户对例外单词的操作，或+或-
*/

//include_once("../functions_for_filter.php");
include_once("../../include/db.php");

if ( isset ($_POST["tab_name"]) )
{
	$tab_name = $_POST["tab_name"];
}
else
{
	//如果不指定表名的话，一切都操作都无从谈起
	exit();
}
// 建立数据库连接 
$db_name = "filter_words";
$dbcnx = connect_db($db_name);

//找到特殊单词后的操作
if ( isset ($_POST["exceptive_word"]) && isset ($_POST["operation"]) )
{
	$sql = "select * from $tab_name where word=\"" . $_POST["exceptive_word"] . "\";";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	if ( null == $row["exception"] )
	{
		if ( "f" == $_POST["operation"] )
		{
			$sql = "update $tab_name set exception=1 where word=\"" . $_POST["exceptive_word"] . "\";";
			$result = mysql_query($sql);
		}
	}
	else
	{
		if ( "f" == $_POST["operation"] )
		{
			$sql = "update $tab_name set exception=exception+1 where word=\"" . $_POST["exceptive_word"] . "\";";
			$result = mysql_query($sql);
		}
		else
		{
			$sql = "update $tab_name set exception=exception-1 where word=\"" . $_POST["exceptive_word"] . "\";";
			$result = mysql_query($sql);
		}
	}
}
else
{
	exit();
}

mysql_close ($dbcnx);

?>

