<?php

class Dal{


    static function getLists($con)
    {
    	$query = "select * from lists";
    	$result = mysqli_query($con,$query);

			$i=0;
	
				while($row = mysqli_fetch_array($result)) {
                                 $lists[$i++] = array(
					'id'=>$row['id'],
					'name' => $row['name'],
					'user_id'  => $row['user_id'],
					'created_on' => $row['created_on']
				);
 				 
				 } 
			
			return $lists;

    }
	static function getItems($con,$list_id)
	{

		$query = "select * from items where list_id='".$list_id."';";
		$result = mysqli_query($con,$query);

			$i=0;
	
				while($row = mysqli_fetch_array($result)) {
                                 $list_items[$i++] = array(
					'id'=>$row['id'],
					'list_id' => $row['list_id'],
					'user_id'  => $row['user_id'],
					'content' => $row['content'],
					'complete'=> $row['complete'],
					'time_complete' => $row['time_complete']
				);
 				 
				 } 
			
			return $list_items;
			//return array('id'=>'1','list_id'=>'1','user_id'=>'1');
	}
}

?>