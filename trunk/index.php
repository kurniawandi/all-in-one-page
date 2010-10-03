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
	show_page_login();
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

