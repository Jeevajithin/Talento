<?php
require 'connection.php';

$phone=$_REQUEST['phone'];
$device=$_REQUEST['device_token'];
$password=$_REQUEST['password'];

$data=array();
$sql="select * from tl_profile where phone='$phone' and password='$password'";
$result=$con->query($sql);

$count=$result->num_rows;
if($count>0)
{
	$row=$result->fetch_assoc();
	
	$updatetoken="update `tl_profile` set `device_token` = '$device' where `phone` = '$phone'";
	$updateResult=$con->query($updatetoken);
	

		$base_url=$base_path."api_2/uploads/user/";
		
		$basename=basename($row['avatar']);
	
			$data[]=array('id'=>$row['id'],
                  'name'=>$row['name'],
				  'last_name'=>"",
                  'email'=>$row['email'],
                  'phone'=>$row['phone'],
                  'place'=>$row['place'],
                  'school'=>$row['school'],
                  'picture_url'=>$base_url.$basename,
				  'technology_id'=>$row['tech_id'],
				  'course_type'=>$row['course_type']
                  );
	
			$result=array('status'=>true,
                'message'=>'Valid User',
				'userDetails'=>$data); 
		
}
else
{
		$result=array('status'=>false,
                'message'=>'Invalid Phone number or Password',
				'userDetails'=>$data); 
}
echo json_encode($result);
?>