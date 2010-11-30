<?php
/*
	已存在		EXIST
	插入成功	OK
	失败		ERROR
	未登录		NOTLOGGEDIN
*/

if ( isset($_POST["req_word"]) )
{
	if ( ($ch = curl_init("http://dict.cn/ws.php?utf8=true&q=" . $_POST["req_word"])) != false )
	{
		if ( true == curl_exec($ch))
		{
			header("Content-Type: text/xml");
			curl_close($ch);
		}
		else
		{
			echo "ERROR";
		}
	}
	else
	{
		echo "ERROR";
	}
}
else
{
	echo "ERROR";
}

?>
