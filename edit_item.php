<?php 
	include 'dal.php';
	dal::edit_item($_GET['item_id'],urldecode ($_GET['content'])); 
?>