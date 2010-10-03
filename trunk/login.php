<?php
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

}

?>

