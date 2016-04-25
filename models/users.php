<?php 
	class models{
	

		function logged_in() {
			return (isset($_SESSION['user_id'])) ? true : false;
		}

		function user_exists($username) {
			$username = sanitize($username);
			return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'"), 0) == 1) ? true : false;
		}

	}
?>