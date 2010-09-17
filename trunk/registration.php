<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>用户注册</title>
		
		<script type="text/javascript" src="./include/js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="../include/js/config.js"></script>
		<script type="text/javascript">
		</script>

		<style type="text/css">
		</style>
	</head>

	<body>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" name="reg_form" method="post">
			<table border="1">
				<tr><td>Email地址：</td><td><input id="email" type="text" name="login" /><label id="email_valid"></label></td></tr>
				<tr><td><label for="passwd1">密码：</label></td><td><input id="passwd1" type="text" name="passwd" /></td></tr>
				<tr><td><label for="passwd2">请再次输入密码：</label></td><td><input id="passwd2" type="text" name="passwd" /><label id="passwd_valid" for="email"></label></td></tr>
				<tr><td>请正确填写生日：</td><td><input id="" type="text" name="passwd" />可以用来取回密码</td></tr>
				<tr><td colspan="2">
					<div title="为了确保你的信息安全，请不要在网吧或者公共机房选择此项！&#10;如果今后要取消此选项，只需点击网站右上角的“退出”链接即可">
						<input type="checkbox" name="remember" value="1"> 记住登录状态
					</div>
				</td></tr>
				<tr>
					<td><input type="submit" value="登录" /></td>
					<td>&nbsp;忘记密码 | <a href="./registration.php">注册</a></td>
				</tr>
			</table>
		</form>

<?php


?>
		<script type="text/javascript">
		$("#email").blur( function () {
			//alert("nihao!");
			$.ajax({
				type: "POST",
				url: "http://" + server_address + "/beidanci/words_filter.php",
				data: { text : text_data, selected : selected_level },
				//error can do a lot of work! try to connect like google.
				//in function ajax can do recursively until connected to server.
				error: function(){ alert("Network error."); },
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
				}//end of success
			});//end of ajax
		});
		</script>
	</body>
</html>

