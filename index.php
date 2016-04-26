<?php include 'init.php'; ?>
<?php include 'dal.php';?>
<!DOCTYPE html>

<html>
<head>
<style>
input#name,input#new_list_button {
	margin: 5px;
}
ul#login, ul#register{
	list-style-type: none;
}
#sidebar {
    	background-color:grey;
    	width:18%%; 
    	height:1000px;
    	float:left;
		}
#content{
	width:82%;
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

		<h2><?php echo dal::get_username_by_id($_SESSION['user_id']);?>'s Lists</h2>
		<form style="margin: 0; padding: 0;" action="create_list.php" method="post">
  <p>
  	<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>">
    <input type="text" name="name" id="name" >
    <input style="display: inline;" type="submit" value="Create New List" id="new_list_button" />
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
					    <td><input type="button" value="Delete List"onclick="confirmDelete(<?php echo $list['id']; ?>)"></td>
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
	    {?>
			<h3><?php echo dal::get_list_name_by_id($list_id);?></h3>
		
	<form style="margin: 0; padding: 0;" action="create_item.php" method="post">
  <p>
  	<input type="hidden" name="list_id" value="<?php echo $_GET['list_id'];?>">
    <input type="text" name="content"  >
    <input style="display: inline;" type="submit" value="Create New Item" />
  </p>
</form>
<?php }?>
	<?php 
	    
	    if ($list_id != '')
	    {
			$items = dal::getItems($list_id);
			if ($items != null)
			{?>
				<table>
				<?php foreach($items as $item)
					{ ?>
					<tr>
			            <td><?php echo $item['content']; ?></td>
			            <td><?php echo $item['time_complete']; ?></td>
			            <td><input type="button" value="Edit"onclick="var content = '<?php echo $item['content']?>'; editItem(<?php echo $item['id'];?>,content);"></td>

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
<script>
function confirmDelete(list_id) {
    var x;
    if (confirm("Are you sure you want to Delete this List?") == true) {
        window.location.assign("delete_list.php?list_id="+list_id);
    } else {
        x = "You pressed Cancel!";
    }
    document.getElementById("demo").innerHTML = x;
}

function editItem(item_id,content) {
    var new_content = prompt("Edit Item: ", content);
    
    if (new_content != null) {
        window.location.assign("edit_item.php?item_id="+item_id+"&content="+new_content);
    }


}
function test()
{alert('test!');}

</script>

</body>
</html>