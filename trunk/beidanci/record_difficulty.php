<?php

//include_once("./functions_for_filter.php");
include_once("../include/db.php");
if ( isset ($_POST["word"]) && isset ($_POST["level"]) )
{
	$db_name = "filter_words";
	$dbcnx = connect_db($db_name);
	$tab_name = "level" . $_POST["level"] . "_words";
	$sql = "update $tab_name set difficulty=difficulty+1 where word=\"" . $_POST["word"] . "\";";
	$result = mysql_query($sql);
	mysql_close ($dbcnx);
}

?>

