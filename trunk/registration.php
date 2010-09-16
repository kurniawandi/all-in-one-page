<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>用户注册</title>
		
		<script type="text/javascript" src="./include/js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript">
		</script>

		<style type="text/css">
		</style>
	</head>

	<body>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" name="reg_form" method="post">
			<table border="1">
				<tr><td>Email地址：</td><td><input type="text" name="login" /></td></tr>
				<tr><td>密码：</td><td><input type="text" name="passwd" /></td></tr>
				<tr><td>请再次输入：</td><td><input type="text" name="passwd" /></td></tr>
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
		</script>
	</body>
</html>

