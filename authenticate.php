<?php
	function authenticate($account)
	{
		$string = $_SERVER['HTTP_USER_AGENT'];
		$string .= $account;
		
		$auth = md5($string);
		$_SESSION['auth'] = $auth;
		$_SESSION['auth_time'] = time();
		
		//output_add_rewrite_var('auth', $auth);
		
		return $auth;
	}
?>