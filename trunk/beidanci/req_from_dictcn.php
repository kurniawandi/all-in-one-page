<?php

if ( isset($_POST["req_word"]) )
{
	$ch = curl_init("http://dict.cn/ws.php?utf8=true&q=" . $_POST["req_word"]);
	echo curl_exec($ch);
	curl_close($ch);
}

?>
