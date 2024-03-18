<?php
require 'connection.php';

$server_url = $server_path.'admin/api_2/uploads/user/';


 $name=$_REQUEST['name'];
 $email=$_REQUEST['email'];
 $phone=$_REQUEST['phone'];
 $place=$_REQUEST['place'];
 $school=$_REQUEST['school'];
 $type=$_REQUEST['type'];
  $technology=$_REQUEST['technology'];
 $device_token=$_REQUEST['device_token'];
 $staff_code=$_REQUEST['staff_code'];
 $password=$_REQUEST['password'];


$sql5="SELECT * FROM `admin` where staff_code='$staff_code'";
$result5=$con->query($sql5);
$count5=$result5->num_rows;

if($count5>0)
{



$sql3="select * from tl_profile where phone='$phone'";
$result3=$con->query($sql3);
$count3=$result3->num_rows;

if($count3>0)
{
$result=array('status'=>false,
                'message'=>'Phone number already exists');
}
else
{

	$avatar_name = $_FILES["avatar"]["name"];
    $avatar_tmp_name = $_FILES["avatar"]["tmp_name"];
    $error = $_FILES["avatar"]["error"];
    $file_ext = pathinfo($avatar_name,PATHINFO_EXTENSION);
     //$random_name = rand(1000,1000000)."-".$avatar_name;
    $random_name = rand(1000,1000000).".".$file_ext;
        $upload_name = $server_url.strtolower($random_name);
        $upload_name = preg_replace('/\s+/', '-', $upload_name);
		
$data=array();


		if(move_uploaded_file($avatar_tmp_name , $upload_name))
		{
			 $photo = $upload_name;
		}
		else
		{
			$photo= $server_path."admin/api_2/uploads/user/default-avatar.jpg";
		}
		
		//$sql= "INSERT INTO `tl_profile` (`name`, `last_name`, `email`, `phone`, `place`, `school`, `avatar`, `tech_id`, `course_type`, `device_token`) VALUES ('$name', '$last_name', '$email', '$phone', '$place', '$school', '$photo','$type','$technology','$device_token')";
		$sql="INSERT INTO `tl_profile` (`name`, `email`, `phone`, `place`, `school`, `avatar`, `tech_id`, `course_type`, `device_token`, `staff_code`, `password`) VALUES ('$name', '$email', '$phone', '$place', '$school', '$photo', '$technology', '$type', '$device_token', '$staff_code','$password')";
	$result1=$con->query($sql);
	
$count1=$con->affected_rows;


	if($count1>0)
	{
			$result=array('status'=>true,
                'message'=>'Registration Successfull');
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
                'message'=>'Invalid staff code');
}
 echo json_encode($result);
?>