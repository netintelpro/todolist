<?php 
	class models{
	
/*
		function logged_in() {
			return (isset($_SESSION['user_id'])) ? true : false;
		}
*/
		function user_exists($username) 
		{
			$username = sanitize($username);
			return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'"), 0) == 1) ? true : false;
		}

		function getUserId($username)
		{

		}

		function login($username, $password) 
		{
			$user_id = getUserId($username);
			$username = sanitize($username);
			$password = md5($password);
			$query = "SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'";
			return (mysql_result(mysql_query($query), 0) == 1) ? $user_id : false;
		}
		static function logged_in() 
		{
			return (isset($_SESSION['user_id'])) ? true : false;
		}
	}
?>