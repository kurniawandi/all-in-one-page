<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>用户注册</title>
		
		<script type="text/javascript" src="./include/js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="./include/js/config.js"></script>
		<script type="text/javascript">
		</script>

		<style type="text/css">
		</style>
	</head>

	<body>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" name="reg_form" method="post">
			<table border="1">
				<tr>
					<td>Email地址：</td>
					<td><input id="email" type="text" name="login" /><label id="email_valid"></label></td>
				</tr>
				<tr>
					<td><label for="passwd1">密码：</label></td>
					<td>
						<input id="passwd1" type="password" name="passwd1" />
						<label class="" id="passwd1_valid">密码请长于6位。</label>
					</td>
				</tr>
				<tr>
					<td><label for="passwd2">请再次输入密码：</label></td>
					<td>
						<input id="passwd2" type="password" name="passwd2" />
						<label id="passwd2_valid" for="email">请将上面的密码再输入一遍。</label>
					</td>
				</tr>
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
			var email_addr = $(this).val();
			var email_reg = /^[-a-zA-Z0-9_\.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/;
			if(!email_reg.test(email_addr))
			{
				//输入格式不正确
				$("#email_valid").text("请输入正确的邮箱地址作为您的登录帐户名");
			}
			else
			{
				$("#email_valid").text("检测中，请稍候...");
				$.ajax({
					type: "POST",
					url: "http://" + server_address + "/include/email_exists.php",
					data: { email : email_addr },
					//error can do a lot of work! try to connect like google.
					//in function ajax can do recursively until connected to server.
					error: function(){ alert("Network error."); },
					success: function (xml) {
						//邮箱地址可用
						if ( 0 == xml )
						{
							$("#email_valid").text("填写正确。");
						}
						else
						{
							$("#email_valid").text("该邮箱已被注册，请更换邮箱。");
						}
					}//end of success
				});//end of ajax
			}
		});
		///*
		$("#passwd1").keyup( function () {
			var password1 = $(this).val();
			if ( password1.length >= 6)
			{
				$("#passwd1_valid").empty();
				$("#passwd1_valid").text("填写正确。");
			}
			else
			{
			}
		});
		$("#passwd2").keyup( function () {
			var passwd2 = $(this).val();
			var passwd1 = $("#passwd1").val();
			function pw_cmp (first_pw, current_pw) {
				//
				if ( current_pw.length > 0 )
				{
					if ( current_pw === first_pw.substring(0, current_pw.length) )
					{
						return 0;
					}
					else
					{
						return 1;
					}
				}
				return -1;
			}
			var stat = pw_cmp (passwd1, passwd2);
			switch (stat)
			{
				case 0 : 
				{
					if (passwd2.length == passwd1.length)
					{
						$("#passwd2_valid").text("两次输入密码一致。");
					}
					else
					{
						$("#passwd2_valid").text("一致，请继续输入。");
					}
					break;
				}
				case 1 : 
				{
					$("#passwd2_valid").text("两次输入密码不一致。");
					break;
				}
				default : 
				{
					$("#passwd2_valid").text("请上面的密码再输入一遍。");
				}
			}
		});
		//*/
		</script>
	</body>
</html>

