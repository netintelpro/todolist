<?php 
	include 'dal.php';
	dal::create_list($_POST['user_id'],$_POST['name']); 
?>