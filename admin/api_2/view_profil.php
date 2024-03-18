<?php
require 'connection.php';
$data=array();
$user_id=$_REQUEST['user_id'];

$sql="select * from tl_profile where id=$user_id";
$result1=$con->query($sql);
$count=$result1->num_rows;

$base_url=$base_path."api_2/uploads/user/";
 if($count>0){
$row=$result1->fetch_assoc();
$basename=basename($row['avatar']);
// 	print_r($row);
	$data[]=array('id'=>$row['id'],
                  'name'=>($row['id']==null)?"":$row['name'],
                  'last_name'=>($row['last_name']==null)?"":"",
                  'email'=>($row['email']==null)?"":$row['email'],
                  'phone'=>($row['phone']==null)?"":$row['phone'],
                  'place'=>($row['place']==null)?"":$row['place'],
                  'school'=>($row['school']==null)?"":$row['school'],
                  'picture_url'=>$base_url.$basename
                  );
	$status=array('status'=>true,'userDetails'=>$data);
 }
else{
$data=array('id'=>"",
                  'name'=>"",
                  'last_name'=>"",
                  'email'=>"",
                  'phone'=>"",
                  'place'=>"",
                  'school'=>"",
                  'picture_url'=>""
                  );
	$status=array('status'=>false,'userDetails'=>$data);
}
echo(json_encode($status));
?>