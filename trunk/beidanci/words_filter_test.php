<?php
session_start();
//include_once("./functions_for_filter.php");
include_once("../include/db.php");
$_SESSION["nihao"] = "ajax got session also!";
if ( isset ($_POST["text"]) )
{
	//$text_data = $_POST["text"];
	//搜索值和搜索键的效率不一样
	//$data_array = preg_split("/ /", $_POST["text"]);
	$temp_array = preg_split("/ /", $_POST["text"]);
	$total_words = count ($temp_array);
	$data_array = array();
	foreach ($temp_array as $key => $value) 
	{
		if ( isset($data_array[$value]) )
		{
			$data_array[$value] += 1;
		}
		else
		{
			$data_array[$value] = 1;
		}
	}
	//array_flip($date_array);
	if ( isset ($_POST["selected"]) )
	{
		$selected_level = intval($_POST["selected"]);
	}
	else
	{
		$selected_level = 1;
	}
}
else
{
	echo "no post!";
	exit();
}

/*
logN跟m*log(N/m)是不一样的
当N很大的时候前者效率更高
当用户文本很大的时候，foreach单词库里面的单词，在用户文本里搜索更快一点
*/

// 建立数据库连接 
$db_name = "beidanci_db";
$dbcnx = connect_db($db_name);
//$suffix_array = array ("d", "ed", "eer", "eest", "eing", "er", "est", "ied", "ier", "ies", "iest", "ily", "irr", "ly", "es", "ing", "prototype", "s");

$level_array = array();
$leveled_data = array();

$begin = microtime(true);

//载入此用户不用统计的单词
$sql = "select * from bdc_known_words where kw_user_id = " . $_SESSION["bdc_user_id"] . ";";
$result = mysql_query($sql);
while ( $row = mysql_fetch_array($result, MYSQL_BOTH) )
{
	//词库里的单词是不重复的
	$level_array[$row["kw_word"]] = 0;
}
foreach ($data_array as $key => $value)
{
	//文本中的这个单词是否在这个难度级别里
	if ( isset($level_array[$key]) )
	{
		unset ($data_array[$key]);
	}
}
unset ($level_array);


//遍历不同难度级别的表，载入表中的单词
for ($index = 1; $index <= $selected_level; $index++)
{
	$sql = "select * from level" .$index. "_words;";
	$result = mysql_query($sql);
	//载入$index级别的单词
	while ( $row = mysql_fetch_array($result, MYSQL_BOTH) )
	{
		//词库里的单词是不重复的
		$level_array[$row["word"]] = $index;
	}
	//遍历用户上传文本，找出在同一难度级别的单词
	//找到后在数组leveled_data中记录出现的次数，并从data_array中删除
	foreach ($data_array as $key => $value)
	{
		//文本中的这个单词是否在这个难度级别里
		if (isset($level_array[$key]))
		{
			$leveled_data[$index][$key] = $value;
			unset ($data_array[$key]);
		}
	}
	unset ($level_array);
}

mysql_close ($dbcnx);

//将不在任何一个已统计的难度级别的单词单独放入一个级别
$last_level = 7;// count ($leveled_data) + 1;
foreach ($data_array as $key => $value)
{
	$leveled_data[$last_level][$key] = $value;
	unset ($data_array[$key]);
}//data_array在这一步之后变为空


$xml_data = "<?xml version=\"1.0\"?><result total=\"" . $total_words . "\" levels=\"" . $selected_level . "\">\n";
foreach ( $leveled_data as $k => $v)
{
	$xml_data .= "<level id=\"" .$k. "\" amount=\"" .count($v). "\">\n";
	foreach ($v as $key => $val)
	{
		$xml_data .= "<word frequency=\"" .$val. "\">" .$key. "</word>\n";
	}
	$xml_data .= "</level>\n";
}

$xml_data .= "</result>";

$end = microtime(true);

//header("Content-Type: text/xml");
echo $end - $begin;
echo $xml_data;

?>

