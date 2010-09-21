<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title></title>

		<script type="text/javascript" src="./include/js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="./include/js/common.js"></script>
		<script type="text/javascript" src="./include/js/config.js"></script>
		<script type="text/javascript">
		</script>

		<style type="text/css">
		</style>
	</head>

	<body>
<?php
include_once("./include/db.php");
if ( isset($_POST["login"]) && isset($_POST["passwd"]) )
{
	echo $_POST["login"] . $_POST["passwd"] . "nihao1\n";
	$db_name = "core_db";
	$dbcnx = connect_db($db_name);
	//trim的处理在客户端进行
	$email = $_POST["login"];
	$pw_md5 = md5($_POST["passwd1"]);
	$sql = "select * from core_users where user_email='$email' and user_passwd='$pw_md5';";
	echo $sql . "\n";
	$result = mysql_query($sql);
	if (!$result)
	{
	    die('Invalid query: ' . mysql_error());
	}
	if (mysql_num_fields ( $result ) > 0)
	{
		echo "login in!";
		$row = mysql_fetch_array($result, MYSQL_BOTH)
		echo $row["user_email"] . " " . $row["user_passwd"];
	}

	mysql_close ($dbcnx);
}
else
{
?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="login_form" method="post">
			<table border="1">
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
//echo '<form action="" name="" method=""><table>';
//echo '<tr><td>帐号：</td><td><input type="text" name="" /></td></tr>';
//echo '<tr><td>密码：</td></tr></table></form>';
?>
		<script type="text/javascript">
		//帐号的首位是不能有空格存在的，密码可以
		</script>
	</body>
</html>

