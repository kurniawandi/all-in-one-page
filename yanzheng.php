<?php
$hidden_hash_var='your_secret_password_here';

$LOGGED_IN=false;

unset($LOGGED_IN);

function user_isloggedin() {

	global $user_name,$id_hash,$hidden_hash_var,$LOGGED_IN;

	//已经进行无序码的检测了吗
	//如果是的话，返回该变量

	if ( isset($LOGGED_IN) ) {
		return $LOGGED_IN;
	}

	//are both cookies present?

	if ($user_name && $id_hash) {
		/*
		   由cookies中得来的用户名和系统超级密码产生一个认证用的无序码如果该无序码与cookie中的无序码一样，则cookies中的变量是可信的，用户已经登录
		 */
		$hash=md5($user_name.$hidden_hash_var);
		if ($hash == $id_hash) 
		{
			//无序码符合，设置一个全局变量，这样我们在再次调用该函数的时候，
			//就无需再次进行md5()运算
			$LOGGED_IN=true;
			return true;
		} 
		else 
		{
			//两个无序码不符合，没有登录
			$LOGGED_IN=false;
			return false;
		}
	} 
	else 
	{
		$LOGGED_IN=false;
		return false;
	}

}

function user_set_tokens($user_name_in) {

	/*
	   一旦用户名和密码通过验证，就调用这个函数
	 */

	global $hidden_hash_var,$user_name,$id_hash;

	if (!$user_name_in) {
		$feedback .= ' ERROR - User Name Missing When Setting Tokens ';
		return false;
	}

	$user_name=strtolower($user_name_in);

	//使用用户名和超级密码创建一个无序码，作判断是否已经登录用

	$id_hash= md5($user_name.$hidden_hash_var);

	//设置cookies的有效期为一个月，可设置为任何的值

	setcookie('user_name',$user_name,(time()+2592000),'/','',0);

	setcookie('id_hash',$id_hash,(time()+2592000),'/','',0);

}

?>

