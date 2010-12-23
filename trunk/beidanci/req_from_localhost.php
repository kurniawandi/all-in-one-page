<?php
/*
	已存在		EXIST
	插入成功	OK
	失败		ERROR
	未登录		NOTLOGGEDIN
*/

if ( isset($_POST["req_word"]) )
{
	$address = "192.168.1.102";
	$service_port = "30000";
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	if ( $socket === false )
	{
		echo "ERROR" . socket_strerror(socket_last_error());
	}

	$result = socket_connect($socket, $address, $service_port);
	if ($result === false) 
	{
		echo "ERROR" . socket_strerror(socket_last_error());
	} 

	$in = $_POST["req_word"];
	$buf = 'This is my buffer.';
	socket_write($socket, $in, strlen($in));

	if (false !== ($bytes = socket_recv($socket, $buf, 2048, MSG_WAITALL))) 
	{
		socket_close($socket);
		//header("Content-Type: text/xml");
		echo $buf;
	} 
	else 
	{
		socket_close($socket);
		echo "ERROR" . socket_strerror(socket_last_error());
	}
}
else
{
	echo "ERROR";
}

?>
