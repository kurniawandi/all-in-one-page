<?php
/*
指定表格，请求分页数据
传入的变量：
$_POST["tab_name"]
$_POST["page"]			//第几页
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

//请求单词列表的操作
if ( isset ($_POST["page"]) )
{
	if ( isset ($_POST["page"]) )
	{
		$page = intval ( $_POST["page"] );
	}
	else
	{
		$page = 1;
	}
	
	// 每页数量 
	$page_size = 20; 
	// 获取总数据量，可以考虑用mysql_num_rows($result) 实现
	$sql = "select count(*) as amount from $tab_name;"; 

	$result = mysql_query($sql);
	$row = mysql_fetch_row($result); 
	//echo $row[0] . $row[1] . "\n";
	//$amount = $row["amount"];
	$amount = $row[0];
	// 记算总共有多少页 
	if( $amount )
	{
		if( $amount < $page_size ){ $page_count = 1; } //如果总数据量小于$PageSize，那么只有一页 
		if( $amount % $page_size )
		{ //取总数据量除以每页数的余数 
			$page_count = (int)($amount / $page_size) + 1; //如果有余数，则页数等于总数据量除以每页数的结果取整再加一 
		}else
		{ 
			$page_count = $amount / $page_size; //如果没有余数，则页数等于总数据量除以每页数的结果 
		} 
	} 
	else
	{
		$page_count = 0; 
	} 

// 翻页链接 
$page_string = ""; 
if( $page == 1 )
{
	$page_string .= "第一页|上一页|"; 
} 
else
{
	$page_string .= "<a href=\"". $_SERVER["PHP_SELF"] ."?page=1\">第一页</a>|<a href=\"". $_SERVER["PHP_SELF"] ."?page=". ($page-1) ."\">上一页</a>|";
}

if( ($page == $page_count) || ($page_count == 0) )
{
	$page_string .= "下一页|尾页"; 
} 
else
{ 
	$page_string .= "<a href=\"". $_SERVER["PHP_SELF"] ."?page=" . ($page+1) . "\">下一页</a>|<a href=\"". $_SERVER["PHP_SELF"] ."?page=" . $page_count . "\">尾页</a>"; 
} 

// 获取数据，以二维数组格式返回结果 
if( $amount )
{
	$sql = "select * from $tab_name limit ". ($page-1)*$page_size . ", $page_size"; 
	$result = mysql_query($sql); 

	setcookie("name", "xubingqing", time() + 10000000, "/project/", "unknow.com", "", true);
	header("Content-Type: text/xml");
	$xml_data = "<?xml version=\"1.0\"?><page id=\"" . $page . "\" page_count=\"" . $page_count . "\">\n";
	$xml_words = "";

	while ( $row = mysql_fetch_array($result, MYSQL_BOTH) ) 
	{
		//echo $row["word"] . "\n";
		$xml_words .= "\t<word>" . $row["word"] . "</word>\n";
	}
	$xml_data .= $xml_words . "</page>";
	echo $xml_data;
	//echo $page_string;
}
else
{ 
	$rowset = array(); 
} 
}

mysql_close ($dbcnx);


?>

