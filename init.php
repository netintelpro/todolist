<?php


	session_start();


	$hostname = "localhost";
	$password = "Pepper2014";
	$username = "cp22771_todo";
	$dbname = "cp22771_todolist";
	global $con;
	$con = mysqli_connect($hostname,$username,$password,$dbname);
	// $GLOBALS['con'] = $con;



	

	
?>
