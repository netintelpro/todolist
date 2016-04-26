<?php 
	include 'dal.php';
	dal::email_list($_GET['list_id'],$_GET['email']); 
?>