<?php

include_once("./functions_for_filter.php");
//header("Content-Type: text/xml");
if ( isset ($_POST["text"]) )
{
	//$text_data = $_POST["text"];
	//搜索值和搜索键的效率不一样
	$data_array = split(" ", $_POST["text"]);
	$total_words = count ($data_array);
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
	exit();
}

/*
logN跟m*log(N/m)是不一样的
当N很大的时候前者效率更高
当用户文本很大的时候，foreach单词库里面的单词，在用户文本里搜索更快一点
*/

// 建立数据库连接 
$db_name = "filter_words";
$dbcnx = connect_db($db_name);
//$suffix_array = array ("d", "ed", "eer", "eest", "eing", "er", "est", "ied", "ier", "ies", "iest", "ily", "irr", "ly", "es", "ing", "prototype", "s");

$level_array = array();
$leveled_data = array();
for ($index = 1; $index <= $selected_level; $index++)
{
	//遍历同一难度级别的所有表，将表中的单词存入到数组level_array
	//for ($i = 0; $i < sizeof ($suffix_array); $i++)
	{
		//$sql = "select * from level" .$index. "_words_" .$suffix_array[$i]. ";";
		$sql = "select * from level" .$index. "_words;";
		$result = mysql_query($sql);
		while ( $row = mysql_fetch_array($result, MYSQL_BOTH) )
		{
			//词库里的单词是不重复的
			$level_array[$row["word"]] = $index;
		}
	}
	//遍历用户上传文本，找出在同一难度级别的单词，找到后在数组leveled_data中记录出现的次数，并从data_array中删除
	foreach ($data_array as $key => $value)
	{
		//文本中的这个单词是否在这个难度级别里
		if (isset($level_array[$value]))
		{
			if ( isset($leveled_data[$index][$value]) )
			{
				$leveled_data[$index][$value] += 1;
			}
			else
			{
				$leveled_data[$index][$value] = 1;
			}
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
	if ( isset($leveled_data[$last_level][$value]) )
	{
		$leveled_data[$last_level][$value] += 1;
	}
	else
	{
		$leveled_data[$last_level][$value] = 1;
	}
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

header("Content-Type: text/xml");
echo $xml_data;

?>

