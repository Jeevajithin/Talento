<?php
require 'connection.php';
$user_id=$_REQUEST['user_id'];
$name=$_REQUEST['name'];
$email=$_REQUEST['email'];
$phone=$_REQUEST['phone'];
$place=$_REQUEST['place'];
$school=$_REQUEST['school'];
$device_token="12345";

$server_url = $server_path.'admin/api_2/uploads/user/';

	$avatar_name = $_FILES["avatar"]["name"];
    $avatar_tmp_name = $_FILES["avatar"]["tmp_name"];
    $error = $_FILES["avatar"]["error"];
    $file_ext = pathinfo($avatar_name,PATHINFO_EXTENSION);
     //$random_name = rand(1000,1000000)."-".$avatar_name;
    $random_name = rand(1000,1000000).".".$file_ext;
        $upload_name = $server_url.strtolower($random_name);
        $upload_name = preg_replace('/\s+/', '-', $upload_name);

		
		
$data=array();
$sql="select * from tl_profile where id='$user_id'";
$result2=$con->query($sql);
$count=$result2->num_rows;
if($count>0)
{
	$row = $result2->fetch_assoc();
    
    
    if ($name == $row['name'] && $email == $row['email'] && $phone == $row['phone'] && $place == $row['place'] && $school == $row['school'] && empty($avatar)) 
	{

        $result = array(
            'status' => true,
            'message' => 'Profile Updated'
        );
    }
	else
	{
		if(move_uploaded_file($avatar_tmp_name , $upload_name))
		{ 
			 $photo = $upload_name;
	$updatetoken="UPDATE `tl_profile` SET `name` = '$name', `email` = '$email', `phone` = '$phone', `place` = '$place', `school` = '$school', `avatar` = '$photo', `device_token` = '$device_token' WHERE `tl_profile`.`id` = '$user_id'";
		}
		else
		{
	$updatetoken="UPDATE `tl_profile` SET `name` = '$name', `email` = '$email', `phone` = '$phone', `place` = '$place', `school` = '$school', `device_token` = '$device_token' WHERE `tl_profile`.`id` = '$user_id'";
		}
	$updateResult=$con->query($updatetoken);
	
	$count1=$con->affected_rows;
	if($count1>0)
	{
			$result=array('status'=>true,
                'message'=>'Profile Updated');
	}
	else
	{
			$result=array('status'=>false,
                'message'=>'Failed');
	}

	}
	
	
}
else
{
	$result=array('status'=>false,
                'message'=>'profile not found'); 
}
 echo json_encode($result);
?>