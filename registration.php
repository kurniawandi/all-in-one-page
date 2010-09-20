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
			<table border="0">
				<tr>
					<td>Email地址：</td>
					<td><input id="email" type="text" name="login" valid="0" /><label id="email_valid"></label></td>
				</tr>
				<tr>
					<td><label for="passwd1">密码：</label></td>
					<td>
						<input id="passwd1" type="password" name="passwd1" valid="0" />
						<label class="" id="passwd1_valid">密码请长于6位。</label>
					</td>
				</tr>
				<tr>
					<td><label for="passwd2">请再次输入密码：</label></td>
					<td>
						<input id="passwd2" type="password" name="passwd2" valid="0" />
						<label id="passwd2_valid" for="email">请将上面的密码再输入一遍。</label>
					</td>
				</tr>
				<tr>
					<td>请正确填写生日：</td>
					<td>
					<select id="y" name="proyear" valid="0"> 
					<option value="1960" >1960</option> 
					<option value="1961" >1961</option> 
					<option value="1962" >1962</option> 
					<option value="1963" >1963</option> 
					<option value="1964" >1964</option> 
					<option value="1965" >1965</option> 
					<option value="1966" >1966</option> 
					<option value="1967" >1967</option> 
					<option value="1968" >1968</option> 
					<option value="1969" >1969</option> 
					<option value="1970" >1970</option> 
					<option value="1971" >1971</option> 
					<option value="1972" >1972</option> 
					<option value="1973" >1973</option> 
					<option value="1974" >1974</option> 
					<option value="1975" >1975</option> 
					<option value="1976" >1976</option> 
					<option value="1977" >1977</option> 
					<option value="1978" >1978</option> 
					<option value="1979" >1979</option> 
					<option value="1980" >1980</option> 
					<option value="1981" >1981</option> 
					<option value="1982" >1982</option> 
					<option value="1983" >1983</option> 
					<option value="1984" >1984</option> 
					<option value="1985" >1985</option> 
					<option value="1986" >1986</option> 
					<option value="1987" >1987</option> 
					<option value="1988" >1988</option> 
					<option value="1989" >1989</option> 
					<option value="1990" >1990</option> 
					<option value="1991" >1991</option> 
					<option value="1992" >1992</option> 
					<option value="1993" >1993</option> 
					<option value="1994" >1994</option> 
					<option value="1995" >1995</option> 
					<option value="1996" >1996</option> 
					<option value="1997" >1997</option> 
					<option value="1998" >1998</option> 
					<option value="1999" >1999</option> 
					<option value="2000" >2000</option> 
					<option value="2001" >2001</option> 
					<option value="2002" >2002</option> 
					<option value="2003" >2003</option> 
					<option value="2004" >2004</option> 
					<option value="2005" >2005</option> 
					<option value="2006" >2006</option> 
					<option value="2007" >2007</option> 
					<option value="2008" >2008</option> 
					<option value="2009" >2009</option> 
					<option value="2010" >2010</option> 
					</select><span class="p_lr_10">年</span>
					<select id="m" name="promonth" valid="0"> 
					<option value="1" >1</option> 
					<option value="2" >2</option> 
					<option value="3" >3</option> 
					<option value="4" >4</option> 
					<option value="5" >5</option> 
					<option value="6" >6</option> 
					<option value="7" >7</option> 
					<option value="8" >8</option> 
					<option value="9" >9</option> 
					<option value="10" >10</option> 
					<option value="11" >11</option> 
					<option value="12" >12</option> 
					</select><span class="p_lr_10">月</span>
					<select id="d" name="proday" valid="0"> 
					<option value="1" >1</option> 
					<option value="2" >2</option> 
					<option value="3" >3</option> 
					<option value="4" >4</option> 
					<option value="5" >5</option> 
					<option value="6" >6</option> 
					<option value="7" >7</option> 
					<option value="8" >8</option> 
					<option value="9" >9</option> 
					<option value="10" >10</option> 
					<option value="11" >11</option> 
					<option value="12" >12</option> 
					<option value="13" >13</option> 
					<option value="14" >14</option> 
					<option value="15" >15</option> 
					<option value="16" >16</option> 
					<option value="17" >17</option> 
					<option value="18" >18</option> 
					<option value="19" >19</option> 
					<option value="20" >20</option> 
					<option value="21" >21</option> 
					<option value="22" >22</option> 
					<option value="23" >23</option> 
					<option value="24" >24</option> 
					<option value="25" >25</option> 
					<option value="26" >26</option> 
					<option value="27" >27</option> 
					<option value="28" >28</option> 
					<option value="29" >29</option> 
					<option value="30" >30</option> 
					<option value="31" >31</option> 
					</select><span class="p_lr_10">日</span>&nbsp;可以用来取回密码 
					</td>
				</tr>
				<tr>
					<td>性别：</td>
					<td>
					<!--
					<label for="progender0" class="mr20"><input type="radio" id="progender0" name="progender" value="0" checked /> 保密</label> 
					-->
					<span id="sex" valid="0">
					<label for="progender1" class="mr20"><input type="radio" id="progender1" name="progender" value="1"  /> 男</label> 
					<label for="progender2" class="mr20"><input type="radio" id="progender2" name="progender" value="2" checked /> 女</label>
					</span>
					</td>
				</tr>
				<tr>
					<td><input type="submit" value="注册" /></td>
					<td>&nbsp;忘记密码 | <a href="./registration.php">登录</a></td>
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
							$("#email_valid").attr("valid", "1");
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
				$("#passwd1_valid").text("填写正确。");
				$("#passwd1_valid").attr("valid", "1");
			}
			else
			{
				$("#passwd1_valid").text("密码请长于6位。");
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
						$("#passwd2_valid").attr("valid", "1");
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
		$("select").click( function () {
			$(this).attr("valid", "1");
		});
		$(":submit").click( function () {
			//alert("nihao");
			alert($("select#m").attr("valid"));
		});
		//*/
		</script>
	</body>
</html>

