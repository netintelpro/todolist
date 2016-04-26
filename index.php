<?php include 'init.php'; ?>
<?php include 'dal.php';?>
<!DOCTYPE html>

<html>
<head>
<style>
.item_complete{
	text-decoration: line-through;

}
#content_container{}

#item_heading{
	position:relative;
	top:-6px;
}
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
	margin-top: 24px;


}

input#list_name{
	width: 61%;
    margin-left: 10%;
}
</style></head>
<body  >
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
<div id="content_container">
	
		<h2 id="item_heading">Items</h2>
		

	<?php 
		$list_id = $_GET['list_id'];

	    if ($list_id != '')
	    {?>
			
		
	<form style="margin: 0; padding: 0;" action="create_item.php" method="post">
  <p>
  	<input type="hidden" name="list_id" value="<?php echo $_GET['list_id'];?>">
    <input type="text" name="content"  >
    <input style="display: inline;" type="submit" value="Create New Item" />
  </p>
</form>
<span>
	<h3><?php echo dal::get_list_name_by_id($list_id);?></h3>
	<select  id="list_filter" name="list_filter"  onchange="filterSelect(<?php echo $list_id;?>);">
		  <option value="all">All</option>
		  <option value="incomplete">Incomplete</option>
		  <option value="complete">Complete</option>
	</select>
</span>

<?php }?>
	<?php 
	    if ($_GET['complete'] == 'true')
	    	$complete = 'true';
	    else if ($_GET['complete'] == 'false') 
	    	$complete = 'false';
	    else
	    	$complete = 'all';

	    if ($list_id != '')
	    {
			$items = dal::getItems($list_id,$complete);
			if ($items != null)
			{?>
				<table>

				<?php foreach($items as $item)
					{ ?>
					<tr>
						<td><input style="<?php if ($item['complete']=='true') echo'display:none;';?>" type="checkbox" id="item_<?php echo $item['id'] ?>" class="item_checkbox" onchange="completeItem(<?php echo $item['id']; ?>);"></td>
			            <td><p class="<?php if ($item['complete']=='true') echo'item_complete';?>"><?php echo $item['content']; ?><p></td>
			            <td><?php echo $item['time_complete']; ?></td>
			            <td><input type="button" value="Edit"onclick="var content = '<?php echo $item['content']?>'; editItem(<?php echo $item['id'];?>,content);"></td>
					    <td><input type="button" value="Delete Item"onclick="confirmDeleteItem(<?php echo $item['id']; ?>)"></td>

					</tr>
					<?php } ?>
					<tr>
						<td><input type="button" value="Email List"onclick="emailList(<?php echo $list_id; ?>);"></td>
						<td><input type="button" value="Print List"onclick="printList(<?php echo $list_id; ?>);"></td>

					</tr>
				</table>

			<?php } ?>
		<?php } ?>

	</div>
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
    
    if (confirm("Are you sure you want to Delete this List?") == true) {
        window.location.assign("delete_list.php?list_id="+list_id);
    } 
}
function confirmDeleteItem(item_id) {
    
    if (confirm("Are you sure you want to Delete this Item?") == true) {
        window.location.assign("delete_item.php?item_id="+item_id);
    } 
}

function editItem(item_id,content) {
    var new_content = prompt("Edit Item: ", content);
    
    if (new_content != null) {
        window.location.assign("edit_item.php?item_id="+item_id+"&content="+new_content);
    }


}

function completeItem(item_id){
    
    if (confirm("Are you sure this Item is Complete?") == true) {
        window.location.assign("complete_item.php?item_id="+item_id);
    } 
    else
    	document.getElementById("item_"+item_id).checked = false;
 }

 function filterSelect(list_id){
 	var filter = document.getElementById("list_filter").value;
 	switch(filter) {
    case 'complete':
        window.location.assign("index.php?list_id="+list_id+"&complete=true");
		break;
    case 'incomplete':
        window.location.assign("index.php?list_id="+list_id+"&complete=false");
		break;
    default:
        window.location.assign("index.php?list_id="+list_id);
	
	}
}
function printList(list_id){
	   window.location.assign("print_list.php?list_id="+list_id+"&email="+friends_email);

}
function emailList(list_id){
	var friends_email = prompt("Enter email address: ", "");
    
    if (friends_email!= null) {
        window.location.assign("email_list.php?list_id="+list_id+"&email="+friends_email);
    }
 
}


 


</script>

</body>
</html>