<?php

function user_change_email ($password1,$new_email,$user_name) {

	global $feedback,$hidden_hash_var;

	if (validate_email($new_email)) {

		$hash=md5($new_email.$hidden_hash_var);

		//改变数据库中确认用的无序码值，但不改变email
		//发出一个带有新认证码的确认email

		$user_name=strtolower($user_name);

		$password1=strtolower($password1);

		$sql="UPDATE user SET confirm_hash='$hash' WHERE user_name='$user_name' AND password='". md5($password1) ."'";

		$result=db_query($sql);

		if (!$result || db_affected_rows($result) < 1) {

			$feedback .= ' ERROR - Incorrect User Name Or Password ';

			return false;

		} else {

			$feedback .= ' Confirmation Sent ';

			user_send_confirm_email($new_email,$hash);

			return true;

		}

	} else {

		$feedback .= ' New Email Address Appears Invalid ';
		return false;
	}
}

function user_confirm($hash,$email) {

	/*

	   用户点击认证email的相关连接时，连到一个确认的页面，该页面会调用这个函数，

	 */

	global $feedback,$hidden_hash_var;

	//verify that they didn't tamper with the email address

	$new_hash=md5($email.$hidden_hash_var);

	if ($new_hash && ($new_hash==$hash)) {

		//在数据库中找出这个记录

		$sql="SELECT * FROM user WHERE confirm_hash='$hash'";

		$result=db_query($sql);

		if (!$result || db_numrows($result) < 1) {

			$feedback .= ' ERROR - Hash Not Found ';

			return false;

		} else {

			//确认email，并且设置帐号为已经激活

			$feedback .= ' User Account Updated - You Are Now Logged In ';

			user_set_tokens(db_result($result,0,'user_name'));

			$sql="UPDATE user SET email='$email',is_confirmed='1' WHERE confirm_hash='$hash'";

			$result=db_query($sql);

			return true;

		}

	} else {

		$feedback .= ' HASH INVALID - UPDATE FAILED ';

		return false;

	}

}

function user_send_confirm_email($email,$hash) {

	/*

	   这个函数在首次注册或者改变email地址时使用

	 */

	$message = "Thank You For Registering at Company.com".

		"nSimply follow this link to confirm your registration: ".

		"nnhttp://www.company.com/account/confirm.php?hash=$hash&email=". urlencode($email). "nnOnce you confirm, you can use the services on PHPBuilder.";

	mail ($email,'Registration Confirmation',$message,'From: noreply@company.com');

}

?>


