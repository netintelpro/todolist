<?php

class Dal{
	static function connect()
	{
		$hostname = "localhost";
		$password = "Pepper2014";
		$username = "cp22771_todo";
		$dbname = "cp22771_todolist";
		return mysqli_connect($hostname,$username,$password,$dbname);
	}
    static function register()
    {
    	$username = trim($_POST['username']);
    	$password = md5(trim($_POST['password']));
    	$email = trim($_POST['email']);
    	$con = self::connect();
    	$query = "insert into users(`username`, `password`, `email`) values ('$username', '$password', '$email');";
   		mysqli_query($con,$query);
   		session_start();
   		$_SESSION['user_id'] = mysqli_insert_id($con);
		header('Location: index.php');
    }

    static function create_list($user_id,$name)
    {
    	 $con = self::connect();
    	 $query = "insert into lists(`user_id`,`name`) values ('$user_id','$name');";
   		 mysqli_query($con,$query);
   		 header('Location: index.php');



    }
     static function get_user_by_email($email)
    {
    	$con = self::connect();
    	$query = "select * from users where email = '$email'";
    	$result = mysqli_query($con, $query); 
		$row = mysqli_fetch_array($result,MYSQLI_BOTH);
		return $row;

    }
    static function login()
    {
    	$email = trim($_POST['email']);
    	$password = md5(trim($_POST['password']));
    	$con = self::connect();
    	$user = self::get_user_by_email($email);



    	if (($user != null) and ($user['password'] == $password) ){
    		session_start();
    		$_SESSION['user_id'] = $user['id'];
    	}

		header('Location: index.php');
    }




    static function getLists($user_id)
    {
    	$con = self::connect();

    	$query = "select * from lists where user_id = '$user_id'";
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


    static function get_user_by_id($user_id)
    {
    	$con = self::connect();
    	$query = "select * from users where user_id = '$user_id'";
    	$result = mysqli_query($con, $query); 
		$row = mysqli_fetch_array($result,MYSQLI_BOTH);
		return $row;

    }
    static function get_user_id_by_email($email)
    {
    	$con = self::connect();
    	$query = "select user_id from users where email = '$email'";
    	$result = mysqli_query($con, $query); 
		$row = mysqli_fetch_array($result,MYSQLI_BOTH);
		return $row['user_id'];
	}

    static function get_user_id_by_username($username)
    {
    	$con = self::connect();
    	$query = "select user_id from users where username = '$username'";
    	$result = mysqli_query($con, $query); 
		$row = mysqli_fetch_array($result,MYSQLI_BOTH);
		return $row['user_id'];

    }

	static function getItems($list_id)
	{
		$con = self::connect();


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