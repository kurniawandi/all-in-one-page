<?php

//include_once("./include/config.php");
require_once("./include/config.php");
include_once("./include/db.php");
function show_page_login ()
{
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="login_form" method="post">
	<table border="0">
		<tr><td>帐号：</td><td><input type="text" name="login" /></td></tr>
		<tr><td>密码：</td><td><input type="password" name="passwd" /></td></tr>
		<tr><td colspan="2">
			<div title="为了确保你的信息安全，请不要在网吧或者公共机房选择此项！&#10;如果今后要取消此选项，只需点击网站右上角的“退出”链接即可">
				<input id="remember" type="checkbox" name="remember" value="1"><label for="remember"> 记住登录状态</label>
			</div>
		</td></tr>
		<tr>
			<td><input type="submit" value="登录" /></td>
			<td>&nbsp;忘记密码 | <a href="./registration.php">注册</a></td>
		</tr>
	</table>
</form>

<?php
}

function show_user_info_center ()
{
	if ( !isset($_SESSION["user_show_name"]) )
	{
		$db_name = "core_db";
		$dbcnx = connect_db($db_name);

		$sql = "select * from core_users where user_id='" . $_SESSION["user_id"] . "';";
		$result = mysql_query($sql);
		if ( !$result )
		{
			die('Invalid query: ' . mysql_error());
		}
		while ($row = mysql_fetch_array($result, MYSQL_BOTH))
		{
			$_SESSION["user_show_name"] = $row["user_show_name"];
		}
		mysql_close ($dbcnx);
	}
	echo "<h1>Welcome " . $_SESSION["user_show_name"] . "!</h1>";
	//这里，在函数的内部，使用了一个全局变量，因此要使用关键字global
	global $server_addr;
	echo "<a href=\"http://" . $server_addr . "/?logout=1\">退出</a><br />";
	echo "<h2>应用</h2>";
	echo "<a href=\"http://$server_addr/beidanci/\">背单词</a>";
}

function user_exists ($user_email, $user_pw)
{
	$db_name = "core_db";
	$dbcnx = connect_db($db_name);
	//trim的处理在客户端进行
	$email = $user_email;
	$pw_md5 = md5($user_pw);
	$sql = "select * from core_users where user_email=\"$email\" and user_passwd=\"$pw_md5\";";
	$result = mysql_query($sql);
	if (!$result)
	{
		die('Invalid query: ' . mysql_error());
	}
	if ( mysql_num_rows ($result) > 0 )
	{
		$row = mysql_fetch_array($result, MYSQL_BOTH);
		return $row["user_id"] . " " . $row["user_show_name"];
	}
	mysql_close ($dbcnx);
	return false;
}

function set_auto_login_cookies ($user_id, $md5_pw=null)
{
	global $super_pw;
	$log_interval = 15*24*60*60;
	setcookie("hello_user", $user_id, (time()+$log_interval), '/', '', 0);//一周
	if ($md5_pw == null)
	{
		setcookie("nihao_user", md5($user_id.$super_pw), (time()+$log_interval), '/', '', 0);
	}
	else
	{
		setcookie("nihao_user", $md5_pw, (time()+$log_interval), '/', '', 0);
	}
}

function unset_auto_login_cookies ($user_id, $md5_pw=null)
{
	$log_interval = 15*24*60*60;
	//setcookie("hello_user", $user_id, (time()-$log_interval), '/', '', 0);//一周
	setcookie("hello_user", "", (time()-3600), '/', '', 0);//一周
	if ($md5_pw == null)
	{
		setcookie("nihao_user", "", (time()-3600), '/', '', 0);
	}
	else
	{
		setcookie("nihao_user", "", (time()-3600), '/', '', 0);
	}
}

?>

