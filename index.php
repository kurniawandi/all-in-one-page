<?php session_start(); ?>
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

include_once("./include/config.php");
include_once("./login.php");
if ( isset($_POST["login"]) && isset($_POST["passwd"]) )
{
	if ( $_SESSION["login_times"] >= 3 )
	{
		if (true)	//验证码正确
		{
			$db_name = "core_db";
			$dbcnx = connect_db($db_name);
			//trim的处理在客户端进行
			$email = $_POST["login"];
			$pw_md5 = md5($_POST["passwd"]);
			$sql = "select * from core_users where user_email=\"$email\" and user_passwd=\"$pw_md5\";";
			$result = mysql_query($sql);
			if (!$result)
			{
				die('Invalid query: ' . mysql_error());
			}
			if ( mysql_num_rows ($result) > 0 )
			{
				$row = mysql_fetch_array($result, MYSQL_BOTH);
				$user_id = $row["user_id"];
				if ( isset($_POST["remember"]) )
				{
					setcookie("hello_user", $user_id, (time()+604800), '/', '', 0);//一周
					setcookie("nihao_user", md5($user_id.$super_pw), (time()+604800), '/', '', 0);
				}
				$_SESSION["user_id"] = $user_id;
				$_SESSION["user_show_name"] = $row["user_show_name"];

			}

			mysql_close ($dbcnx);
		}
	}
}

if ( isset($_GET["logout"]) && $_GET["logout"]=="1" )
{
	unset($_SESSION["user_id"]);
	unset($_SESSION["user_show_name"]);
}
else
{
	if ( isset($_COOKIE["hello_user"]) && isset($_COOKIE["nihao_user"]) && 
		md5($_COOKIE["hello_user"].$super_pw) == $_COOKIE["nihao_user"] )
	{
		echo "hello!";
		setcookie("hello_user", $_COOKIE["hello_user"], (time()+604800), '/', '', 0);//一周
		setcookie("nihao_user", $_COOKIE["nihao_user"], (time()+604800), '/', '', 0);
		if ( !isset($_SESSION["user_id"]) )
		{
			$_SESSION["user_id"] = $_COOKIE["hello_user"];
		}
		show_user_info_center();
	}
	else
	{
		$_SESSION["login_times"] = 0;
		show_page_login();
	}
}

?>
		<script type="text/javascript">
		//帐号的首位是不能有空格存在的，密码可以
		$(":submit").click( function (event) {
			if ( "" == $(":text").val() || "" == $(":password").val() )
			{
				event.preventDefault();
			}
		});
		</script>
	</body>
</html>

