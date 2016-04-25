<?php


	session_start();


	$hostname = "localhost";
	$password = "Pepper2014";
	$username = "cp22771_todo";
	$dbname = "cp22771_todolist";
	$con = mysqli_connect($hostname,$username,$password,$dbname);



	require 'models/users.php';
	require 'models/lists.php';
	require 'models/items.php';

	
?>
