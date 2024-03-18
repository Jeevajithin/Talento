<?php
require 'connection.php';


  //production server url
 //$server_url = $server_path.'admin/api_2/uploads/gatepass_photo/';

 //dev server url
   $server_url = $server_path.'Project/talento/admin/api_2/uploads/gatepass_photo/';

$status=$_REQUEST['status'];

if($status=="event")
{
	$event_id=$_REQUEST['event_id'];
	$sql_1="SELECT * FROM `events` WHERE event_id='$event_id'";
	$result_1=$con->query($sql_1);
	$row_1=$result_1->fetch_assoc();

	//$start_date=$row_1['start_date'];
	//$end_date=$row_1['end_date'];
		$start_date = date("d/m/y", strtotime($row_1['start_date']));
        $end_date = date("d/m/y", strtotime($row_1['end_date']));
}
else
{
	$start_date=$_REQUEST['start_date'];
	$end_date=$_REQUEST['end_date'];
	$event_id=0;
}

 $userid=$_REQUEST['uid'];
 $name=$_REQUEST['name'];
 $tech_id=$_REQUEST['tech_id'];
 


 $avatar_name = $_FILES["avatar"]["name"];
 $avatar_tmp_name = $_FILES["avatar"]["tmp_name"];
 $error = $_FILES["avatar"]["error"];
 $file_ext = pathinfo($avatar_name,PATHINFO_EXTENSION);
  //$random_name = rand(1000,1000000)."-".$avatar_name;
 	$random_name = rand(1000,1000000).".".$file_ext;
     $upload_name = $server_url.strtolower($random_name);
     $upload_name = preg_replace('/\s+/', '-', $upload_name);
     
	$data=array();


     move_uploaded_file($avatar_tmp_name , $upload_name);
     
          $photo = $upload_name;
     
    
		
		$sql= "INSERT INTO `gatepass_request` (`uid`, `name`, `tech_id`, `start_date`, `end_date`, `profile_pic`, `status`, `event_id`) VALUES ('$userid', '$name', '$tech_id', '$start_date', '$end_date', '$photo', '0','$event_id')";
        
	    $result1=$con->query($sql);
        
        $count1=$con->affected_rows;
        

	if($count1>0)
	{
			$result=array('status'=>true,
                'message'=>'Successfull');
	}
	else
	{
			$result=array('status'=>false,
                'message'=>'Failed');
	}

    echo json_encode($result);

 ?>