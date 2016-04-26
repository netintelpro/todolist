<?php 
	include 'dal.php';
	dal::create_item($_POST['list_id'],$_POST['content']); 
?>