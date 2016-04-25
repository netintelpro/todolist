<?php include 'init.php'; ?>
<?php include 'dal.php';?>
<!DOCTYPE html>

<html>
<head>
<style>
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
</style></head>
<body>
<div id="sidebar">
	<h2>Lists</h2>
<?php 
	$lists = dal::getLists($con);
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
		$items = dal::getItems($con,$list_id);
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
</body>
</html>