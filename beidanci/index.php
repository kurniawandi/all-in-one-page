<?php
session_start();
//ob_start();
include_once("../setting.php");
include_once(ABSPATH . "login.php");
include_once(ABSPATH . "beidanci/include/functions.php");
include_once(ABSPATH . "include/functions.php");
global $super_pw;
//来自于网页跳转的用户
if ( isset($_SESSION["user_id"]) && isset($_SESSION["user_show_name"]) )
{
	$_SESSION["bdc_user_id"] = $_SESSION["user_id"];
	$_SESSION["bdc_user_show_name"] = $_SESSION["user_show_name"];
	try
	{
		echo "hi0";
	set_user_visit_time($_SESSION["bdc_user_id"]);
	set_auto_login_cookies($_SESSION["bdc_user_id"]);
	}
	catch (Exception $e)
	{
		echo "Exception : " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine();
		echo "; caught on line " . __LINE__;
	}
}
//已注册用户或已使用过这个应用的非注册用户
else if ( isset($_COOKIE["hello_user"]) && isset($_COOKIE["nihao_user"]) && 
		md5($_COOKIE["hello_user"].$super_pw) == $_COOKIE["nihao_user"] )
{
	if ( intval($_COOKIE["hello_user"]) >=1000 && intval($_COOKIE["hello_user"]) <= 999999 )
	{
		echo "hi1";
		$_SESSION["bdc_user_id"] = $_COOKIE["hello_user"];
		$_SESSION["bdc_user_show_name"] = "guest";
	}
	else 
	{
		echo "hi2";
		$_SESSION["user_id"] = $_COOKIE["hello_user"];
		$_SESSION["bdc_user_id"] = $_COOKIE["hello_user"];
		$_SESSION["user_show_name"] = get_show_name_by_id ($_SESSION["user_id"]);
		$_SESSION["bdc_user_show_name"] = $_SESSION["user_show_name"];
	}
	try
	{
		echo "hi3";
	set_user_visit_time($_SESSION["bdc_user_id"]);
	set_auto_login_cookies($_SESSION["bdc_user_id"]);
	}
	catch (Exception $e)
	{
	echo "Exception : " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine();
	echo "; caught on line " . __LINE__;
	}
}
//未注册用户第一次登录
else 
{
	$_SESSION["bdc_user_id"] = generate_rand_id();
	$_SESSION["bdc_user_show_name"] = "guest";
	//$user_id = $_SESSION["bdc_user_id"];
	//$user_show_name = $_SESSION["bdc_user_show_name"];
	try
	{
		echo "hi5";
	set_user_visit_time($_SESSION["bdc_user_id"]);
	set_auto_login_cookies($_SESSION["bdc_user_id"]);
	}
	catch (Exception $e)
	{
		echo "Exception : " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine();
		echo "; caught on line " . __LINE__;
	}
}
//ob_end_flush();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>单词分级</title>
		
		<script type="text/javascript" src="http://www.google.com/jsapi"></script>
		<script type="text/javascript" src="../include/js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="./js/js_fn.js"></script>
		<script type="text/javascript" src="../include/js/config.js"></script>
		<script type="text/javascript" src="./js/jquery-ui-1.8.6.custom.min.js"></script>
		<script type="text/javascript">
		google.load("language", "1");
		function translate_word (word, obj_place) {
			google.language.detect(word, function(result) {
				if (!result.error && result.language) {
					google.language.translate(word, result.language, "zh", function(result) {
						if (result.translation) {
							//text()方法之前不用empty()
							obj_place.text(result.translation);
						}
					});
				}
			});
		}
		function translate_table (level_id) {
			$("table#level" + level_id).find("tr").each(function () {
				var word = $(this).find("td.w").text();
				var this_td_obj = $(this).find("td.trans");
				translate_word (word, this_td_obj);
				if (level_id != "7")
				{
					$(this).find("td.o").empty();
					$(this).find("td.o").append(add_to_lib_button_html(word));
				}
			});
		}
		$(document).ready(function(){
			$("textarea").focus();
		});
		</script>

		<link rel="stylesheet" type="text/css" href="./css/common.css" />
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<!--
		<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css" />
		-->
		<style type="text/css">
		</style>
	</head>

	<body style="font-size:100%;">
		<h1>单词分级</h1>
		<p><?php echo "欢迎 " . $_SESSION["bdc_user_show_name"] . "!"; ?></p>
		<!--
		<a href="http://173.234.55.160/bbs/index.php" target="_blank">关于这个应用我要说两句</a>
		-->
		<div id="hint_tips"></div>
		<form action="" method="post" enctype="text/plain">
			请粘贴整篇英语文本到下面的文本框中，选择过滤单词的难度级别，我们将迅速找出您可能不会的生词！
			<textarea rows="10" cols="100" ></textarea>
			<br />
			过滤掉
			<select name="levels">
				<option value="level1">level 1</option>
				<option value="level2">level 2</option>
				<option value="level3">level 3</option>
				<option value="level4">level 4</option>
				<option value="level5">level 5</option>
				<option value="level6" selected="selected">level 6</option>
			</select>
			及其以下难度的单词
			<br />

			<input type="submit" value="发送">
			<input type="reset" value="重置">

		</form>
		<div id="stat_result">
		</div>
		<div id="hint_window"></div>
		<div id="log_reg" style="display:none;">
			您尚未登录，请<a href="http://173.234.55.160">登录</a>或者<a href="http://173.234.55.160/beidanci/registration.php">注册</a>，谢谢！
			<?php
				//show_page_login();
			?>
		</div>
		<hr />
		<center><div id="footer">author XBQ</div></center>
		<script type="text/javascript" src="./js/text_paste_oper.js"></script>
		<script type="text/javascript">
		</script>
	</body>
</html>


