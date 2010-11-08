<?php
session_start();
include_once("../setting.php");
include_once(ABSPATH . "login.php");
include_once(ABSPATH . "beidanci/include/functions.php");
include_once(ABSPATH . "include/functions.php");
global $super_pw;
//来自于网页跳转的用户
if ( isset($_SESSION["user_id"]) && isset($_SESSION["user_show_name"]) )
{
	//$user_id = $_SESSION["user_id"];
	$_SESSION["bdc_user_id"] = $_SESSION["user_id"];
	//$user_show_name = $_SESSION["user_show_name"];
	$_SESSION["bdc_user_show_name"] = $_SESSION["user_show_name"];
	try
	{
	set_user_visit_time($_SESSION["bdc_user_id"]);
	//set_auto_login_cookies($user_id, null, "/beidanci/");
	set_auto_login_cookies($_SESSION["bdc_user_id"]);
	}
	catch (Exception $e)
	{
		echo "Exception : " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine();
	}
}
//已注册用户或已使用过这个应用的非注册用户
else if ( isset($_COOKIE["hello_user"]) && isset($_COOKIE["nihao_user"]) && 
		md5($_COOKIE["hello_user"].$super_pw) == $_COOKIE["nihao_user"] )
{
	if ($_COOKIE["hello_user"] >=1000 && $_COOKIE["hello_user"] <= 999999 )
	{
		$_SESSION["bdc_user_id"] = $_COOKIE["hello_user"];
		$_SESSION["bdc_user_show_name"] = "guest";
	}
	else 
	{
		$_SESSION["user_id"] = $_COOKIE["hello_user"];
		$_SESSION["bdc_user_id"] = $_COOKIE["hello_user"];
		$_SESSION["user_show_name"] = get_show_name_by_id ($_SESSION["user_id"]);
		$_SESSION["bdc_user_show_name"] = $_SESSION["user_show_name"];
	}
	//$user_id = $_SESSION["bdc_user_id"];
	//$user_show_name = $_SESSION["bdc_user_show_name"];
	set_user_visit_time($_SESSION["bdc_user_id"]);
	set_auto_login_cookies($_SESSION["bdc_user_id"]);
	//set_auto_login_cookies($_COOKIE["hello_user"], $_COOKIE["nihao_user"]);
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
	set_user_visit_time($_SESSION["bdc_user_id"]);
	set_auto_login_cookies($_SESSION["bdc_user_id"]);
	}
	catch (Exception $e)
	{
		echo "Exception : " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine();
	}
}
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
		<style type="text/css">
		</style>
	</head>

	<body>
		<h1>单词分级</h1>
		<p><?php echo "欢迎 " . $_SESSION["bdc_user_show_name"] . "!"; ?></p>
		<a href="http://173.234.55.160/bbs/index.php" target="_blank">关于这个应用我要说两句</a>
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
		<hr />
		<center><div id="footer">author XBQ</div></center>
		<script type="text/javascript">
		$(":submit").click( function (event) {
			event.preventDefault();
			//单词处理
			var text_data = $("textarea").val();
			var selected_level = $("select option:selected").attr("value");
			if (text_data != "" && text_data != undefined)
			{
				$("div#stat_result").empty();
				$("div#stat_result").text("Loading...");
				selected_level = selected_level.substring(5);
				//alert(selected_level);
				text_data = text_data.toLowerCase();
				//x = new Date();
				//去文本中的非字母符号、下划线、数字
				text_data = text_data.replace(/[\W_\d]+/g , " ");
				//去掉单个的字母
				text_data = text_data.replace(/\b.\b/g , " ");
				//去掉首尾空格
				//text_data = text_data.replace(/^\s+|\s+$/g , "");
				//去连续的空格
				text_data = text_data.replace(/\s+/g , " ");
				//然后trim前后一个空格就好
				if (text_data[0] == " ")
				{
					if (text_data[text_data.length-1] == " ")
					{
						text_data = text_data.substring(1, text_data.length-1);
					}
					else
					{
						text_data = text_data.substring(1);
					}
				}
				else
				{
					if (text_data[text_data.length-1] == " ")
					{
						text_data = text_data.substring(0, text_data.length-1);
					}
				}

				/*
				y = new Date();  
				diff = y.getTime() - x.getTime(); 
				alert("载入本页共用了 " + diff/1000 + " 秒"); 
				alert(text_data); 
				return;
				*/
				$.ajax({
					type: "POST",
					url: "http://" + server_address + "/beidanci/words_filter.php",
					data: { text : text_data, selected : selected_level },
					//error can do a lot of work! try to connect like google.
					//in function ajax can do recursively until connected to server.
					error: function(XMLHttpRequest, textStatus, errorThrown){ 
						alert(textStatus);
						alert(errorThrown);
					},
					success: function (xml) {
						//alert(xml);
						//取出传过来的最后一个level的id
						var last_level = parseInt($("level:last", xml).attr("id"));
						$("div#stat_result").empty();
						$("div#stat_result").append(show_statistic_result(xml, last_level));
						$("div.content").hide();
						//只show最难级别的
						$("div#level" + last_level + "_content").show();
						translate_table(last_level);
						$("textarea").focus();
					}//end of success
				});//end of ajax
			}//end of if
		});//end of submit action
		$("a.hid_button").live("click", function (event) {
			var divid = "div#level"+$(this).parent().attr("id")+"_content";
			$("div.content").slideUp();
			$(divid).show();
			event.preventDefault();
		});
		$(".all_translate").live ("click", function (event) {
			translate_table($(this).parent().parent().attr("id").substring(5, 6));
			event.preventDefault();
		});
		$(".unknown").live ("click", function (event) {
			$(this).parent().parent().find("td.trans").empty();
			$(this).parent().parent().find("td.trans").text("Loading...");
			var trans_word = $(this).attr("id").split("@")[0];
			//alert(trans_word);
			translate_word(trans_word, $(this).parent().parent().find("td.trans"));
			var level_id = $(this).parent().parent().parent().parent().attr("id").substring(5, 6);
			$.ajax({
				type: "POST",
				url: "http://" + server_address + "/beidanci/record_difficulty.php",
				data: { word : trans_word, level : level_id },
				//error can do a lot of work! try to connect like google.
				//in function ajax can do recursively until connected to server.
				error: function(){ alert("Network error."); },
				success: function (xml) {
				}//end of success
			});//end of ajax
			event.preventDefault();
		});
		$(".add_to_lib").live ("click", function (event) {
			//var trans_word = $(this).attr("id").split("@")[0];
			//var level_id = $(this).parent().parent().parent().parent().attr("id").substring(5, 6);
			$.ajax({
				type: "POST",
				url: "http://" + server_address + "/beidanci/record_difficulty.php",
				data: { word : trans_word, level : level_id },
				//error can do a lot of work! try to connect like google.
				//in function ajax can do recursively until connected to server.
				error: function() { alert("Network error."); },
				success: function (xml) {
				}//end of success
				//加入哪个生词本
			});//end of ajax
			event.preventDefault();
		});
		$(".add_to_known").live ("click", function (event) {
			var known_word = $(this).attr("id").split("@")[0];
			var this_button = $(this);
			$.ajax({
				type: "POST",
				url: "http://" + server_address + "/beidanci/add_to_known.php",
				data: { word : known_word },
				//error can do a lot of work! try to connect like google.
				//in function ajax can do recursively until connected to server.
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					alert(textStatus);
					alert(errorThrown);
				},
				success: function (xml) {
					//trim这一步是必须的
					xml = $.trim(xml);
					if ( xml == "OK" )
					{
						this_button.parent().parent().fadeOut("slow");
						$("span#remain").text( parseInt($("span#remain").text()) - 1 );
					}
					else
					{
						$("#hint_tips").text("忽略失败，请稍候再试。");
					}
				}//end of success
			});//end of ajax
		});
		$(window).keydown(function(event) {
			//alert(event.keyCode);
			switch(event.keyCode) {
				// ...
				// 不同的按键可以做不同的事情
				// 不同的浏览器的keycode不同
				// 更多详细信息:     http://unixpapa.com/js/key.html
				// ...
				case 191 : {
					if (document.activeElement.tagName != "TEXTAREA")
					{
						//alert(event.keyCode);
						$("textarea").focus();
						event.preventDefault();
					}
				}
			}
		});
		</script>
	</body>
</html>


