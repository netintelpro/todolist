<?php include 'init.php'; ?>
<?php include 'dal.php';?>
<!DOCTYPE html>

<html>
<head>
<style>

ul#login, ul#register{
	list-style-type: none;
}
#sidebar {
    	background-color:grey;
    	width:30%; 
    	height:1000px;
    	float:left;
		}
#content{
	width:70%;
	height:1000px;
	float:right;


}

input#list_name{
	width: 61%;
    margin-left: 10%;
}
</style></head>
<body>
<?php if (isset($_SESSION['user_id'])) { ?>
	<div id="sidebar">
		<a href="logout.php">Log Out</a>

		<h2>Lists</h2>
		<form style="margin: 0; padding: 0;" action="create_list.php" method="post">
  <p>
  	<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>">
    <input type="text" name="name" id="name" >
    <input style="display: inline;" type="submit" value="Create New List" />
  </p>
</form>

	<?php 
		$lists = dal::getLists($_SESSION['user_id']);
		if ($lists != null)
		{?>
			<table>
			<?php foreach($lists as $list)
				{ ?>
					<tr>
						<td><a href="?list_id=<?php echo $list['id']; ?>"><?php echo $list['name']; ?></a></td>
					</tr>
				<?php } ?>
			</table>	
		<?php } ?>
	</div>
	<div id="content">	
	<h2>Items</h2>
	<?php 
	    $list_id = $_GET['list_id'];
	    if ($list_id != '')
	    {
			$items = dal::getItems($list_id);
			if ($items != null)
			{?>
				<table>
				<?php foreach($items as $item)
					{ ?>
					<tr>
						<td><?php echo $item['id']; ?></td>
						<td><?php echo $item['list_id']; ?></td>
			            <td><?php echo $item['user_id']; ?></td>
			            <td><?php echo $item['content']; ?></td>
			            <td><?php echo $item['time_complete']; ?></td>
					</tr>
					<?php } ?>
				</table>	
			<?php } ?>
		<?php } ?>

	</div>
	<?php } else{?>

	
	<div id="sidebar">

		<?php if($_GET['action'] !='register') {?>
			<form action="login.php" method="post">
				<ul id="login">
					<li>
						Email:<br>
						<input type="text" name="email">
					</li>
					<li>
						Password:<br>
						<input type="password" name="password">
					</li>
					<li>
						<input type="submit" value="Log in">
					</li>
					<li>
						<a href="?action=register">Register</a>
					</li>
					
				</ul>
			</form>
		<?php } else {?>
			<form action="register.php" method="post">
				<ul id="register">
					<li>
						Username:<br>
						<input type="text" name="username">
					</li>
					<li>
						Email:<br>
						<input type="text" name="email">
					</li>
					<li>
						Password:<br>
						<input type="password" name="password">
					</li>
					<li>
						Repeat Password:<br>
						<input type="password" name="password2">
					</li>
					<li>
						<input type="submit" value="Register">
					</li>
					
					
				</ul>
			</form>	

		<?php }?>
	</div>



	<?php }?>


</body>
</html>