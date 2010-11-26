<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title></title>

<script type="text/javascript">
</script>

<style type="text/css">
</style>
</head>

<body>

<?php
include_once ("../include/db.php");

	$db_name = "stat_renren";
	$dbcnx = connect_db($db_name);
	mysql_query("set names utf8");
	$tab_name = "stat_table";

if ( isset($_POST) )
{
	foreach ($_POST as $key=>$value)
	{
		$id = preg_split("/@/", $key);
		if ("add" == $id[1])
		{
			$sql = "update $tab_name set res_for_one=res_for_one+1, res_for_all=res_for_all+1 where id=" .$id[0]. ";";
			$result = mysql_query($sql);
		}
		else
		{
			$sql = "update $tab_name set res_for_one=res_for_one-1, res_for_all=res_for_all-1 where id=" .$id[0]. ";";
			$result = mysql_query($sql);
		}
	}
}
if (isset ($_GET["setzero"]))
{
	$sql = "update $tab_name set res_for_one=0 where id=1;";
	$result = mysql_query($sql);
	$sql = "update $tab_name set res_for_one=0 where id=2;";
	$result = mysql_query($sql);
	$sql = "update $tab_name set res_for_one=0 where id=3;";
	$result = mysql_query($sql);
	$sql = "update $tab_name set res_for_one=0 where id=4;";
	$result = mysql_query($sql);
	$sql = "update $tab_name set res_for_one=0 where id=5;";
	$result = mysql_query($sql);
	$sql = "update $tab_name set res_for_one=0 where id=6;";
	$result = mysql_query($sql);
	$sql = "update $tab_name set res_for_one=0 where id=7;";
	$result = mysql_query($sql);
	$sql = "update $tab_name set res_for_one=0 where id=8;";
	$result = mysql_query($sql);
	$sql = "update $tab_name set res_for_one=0 where id=9;";
	$result = mysql_query($sql);
	$sql = "update $tab_name set res_for_one=0 where id=10;";
	$result = mysql_query($sql);
	$sql = "update $tab_name set res_for_one=0 where id=11;";
	$result = mysql_query($sql);

}
?>
<p>统计新鲜事中下列行为的出现频率：
<li>从上到先查看新鲜事</li>
<li>如果新鲜事里面出现了一个以下活动，就按"add 1"，如果按错了可以按"cut 1"修改过来</li>
</p>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
<table>

<?php
	$sql = "select * from $tab_name;";
	$result = mysql_query($sql);
	while ( $row = mysql_fetch_array($result, MYSQL_BOTH) ) 
	{
		//echo $row["word"] . "\n";
		echo "<tr>";
		echo "<td>".$row["name"]."</td><td width=\"150\">".$row["res_for_one"]."</td>";
		echo "<td><input type=\"submit\" name=\"".$row["id"]."@add\" value=\"add 1\" />";
		echo "<input type=\"submit\" name=\"".$row["id"]."@cut\" value=\"cut 1\" /></td>";
		echo "</tr>";
	}

	mysql_close ($dbcnx);
?>
</table>
</form>
<script type="text/javascript">
</script>
</body>
</html>

