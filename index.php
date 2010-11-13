<?php
session_start();
ob_start();
?>
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
include_once("./setting.php");
include_once(ABSPATH . "login.php");
include_once(ABSPATH . "include/functions.php");
global $super_pw;
//登录验证
if ( isset($_POST["login"]) && isset($_POST["passwd"]) )
{
	//登录次数超过3就要验证码了
	if ( isset ($_SESSION["login_times"]) && $_SESSION["login_times"] >= 3 )
	{
		if (true)	//验证码正确
		{
			if ( ($id_name = user_exists($_POST["login"], $_POST["passwd"])) != false )
			{
				$id_name_array = preg_split("/ /", $id_name);
				$user_id = $id_name_array[0];
				if ( isset($_POST["remember"]) )
				{
					try
					{
						set_auto_login_cookies($user_id);
					}
					catch (Exception $e)
					{
						echo "Exception : " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . __LINE__;
					}
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
		else
		{
			$_SESSION["login_times"] += 1;
			$_SESSION["login_code"] = "";
			show_page_login();
		}
	}
	else
	{
		//数据库中存在此用户
		if ( ($id_name = user_exists($_POST["login"], $_POST["passwd"])) != false )
		{
			$id_name_array = preg_split("/ /", $id_name);
			$user_id = $id_name_array[0];
			if ( isset($_POST["remember"]) )
			{
				try
				{
				set_auto_login_cookies($user_id);
				}
				catch (Exception $e)
				{
				echo "Exception : " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine();
				echo "; caught on line " . __LINE__;
				}
			}
			$_SESSION["user_id"] = $user_id;
			$_SESSION["user_show_name"] = $id_name_array[1];
			show_user_info_center();
		}
		else
		{
			if ( isset ($_SESSION["login_times"]) && $_SESSION["login_times"] > 2)
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
//用户登出
else if ( isset($_GET["logout"]) && $_GET["logout"]=="1" )
{
	if ( isset ($_SESSION["user_id"]) )
	{
		unset_auto_login_cookies($_SESSION["user_id"], isset($_COOKIE["nihao_user"])? $_COOKIE["nihao_user"] : null );
	}
	unset($_COOKIE["hello_user"]);
	unset($_COOKIE["nihao_user"]);
	unset($_SESSION["user_id"]);
	unset($_SESSION["user_show_name"]);
	show_page_login();
}
//从别的页面跳转
else if ( isset($_SESSION["user_id"]) && isset($_SESSION["user_show_name"]) && $_SESSION["user_id"] >= 1000000 )
{
	show_user_info_center();
}
//自动登录
else if ( isset($_COOKIE["hello_user"]) && intval($_COOKIE["hello_user"]) < 1000 && 
		intval($_COOKIE["hello_user"]) > 1000000 && isset($_COOKIE["nihao_user"]) && 
		md5($_COOKIE["hello_user"].$super_pw) == $_COOKIE["nihao_user"] )
{
	try
	{
	set_auto_login_cookies($_COOKIE["hello_user"], $_COOKIE["nihao_user"]);
	}
	catch (Exception $e)
	{
	echo "Exception : " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine();
	echo "; caught on line " . __LINE__;
	}
	if ( !isset($_SESSION["user_id"]) )
	{
		$_SESSION["user_id"] = $_COOKIE["hello_user"];
	}
	if (($_SESSION["user_show_name"] = get_show_name_by_id($_SESSION["user_id"])) == null )
	{
		//$_SESSION["user_show_name"] = "guest";
		unset($_SESSION["user_id"]);
		show_page_login();
	}
	else
	{
		show_user_info_center();
	}
}
else
{
	$_SESSION["login_times"] = 0;
	show_page_login();
}
ob_end_flush();
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

