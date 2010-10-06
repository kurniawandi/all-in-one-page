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
			if ( ($id_name = user_exists($_POST["login"], $_POST["passwd"])) != false )
			{
				$id_name_array = split($id_name, " ");
				$user_id = $id_name_array[0];
				if ( isset($_POST["remember"]) )
				{
					put_auto_login_cookies($user_id);
				}
				$_SESSION["user_id"] = $user_id;
				$_SESSION["user_show_name"] = $row["user_show_name"];
				show_user_info_center();
			}
			else
			{
				if ($_SESSION["login_times"] > 2)
				{
					$_SESSION["login_times"] += 1;
					$_SESSION["login_code"] = "";
					show_page_login();
				}
				else
				{
					$_SESSION["login_times"] += 1;
					show_page_login();
				}
			}
		}
		else
		{
			$_SESSION["login_times"] += 1;
			$_SESSION["login_code"] = "";
			show_page_login();
		}
	}
	else
	{
		if ( ($id_name = user_exists($_POST["login"], $_POST["passwd"])) != false )
		{
			$id_name_array = split($id_name, " ");
			$user_id = $id_name_array[0];
			if ( isset($_POST["remember"]) )
			{
				put_auto_login_cookies($user_id);
			}
			$_SESSION["user_id"] = $user_id;
			$_SESSION["user_show_name"] = $id_name_array[1];
			show_user_info_center();
		}
		else
		{
			if ($_SESSION["login_times"] > 2)
			{
				$_SESSION["login_times"] += 1;
				$_SESSION["login_code"] = "";
				show_page_login();
			}
			else
			{
				$_SESSION["login_times"] += 1;
				show_page_login();
			}
		}
	}
}

if ( isset($_GET["logout"]) && $_GET["logout"]=="1" )
{
	unset($_SESSION["user_id"]);
	unset($_SESSION["user_show_name"]);
}
//else
{
	if ( isset($_COOKIE["hello_user"]) && isset($_COOKIE["nihao_user"]) && 
		md5($_COOKIE["hello_user"].$super_pw) == $_COOKIE["nihao_user"] )
	{
		echo "hello! " . $_COOKIE["hello_user"];
		put_auto_login_cookies($_COOKIE["hello_user"], $_COOKIE["nihao_user"]);
		if ( !isset($_SESSION["user_id"]) )
		{
			$_SESSION["user_id"] = $_COOKIE["hello_user"];
		}
		echo __LINE__;
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

