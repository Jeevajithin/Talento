<?php
require 'connection.php';
$data=array();
$user_id=$_REQUEST['user_id'];
$code=$_REQUEST['code'];

$sql="SELECT * FROM `exam_code` where userid='$user_id' and code='$code' and status=0";
$result1=$con->query($sql);
$count=$result1->num_rows;

 if($count>0)
 {
	$row=$result1->fetch_assoc();
	// 	print_r($row);
	$data[]=array('id'=>$row['id'],
				'code'=>$row['code']
                  );
	$status=array('status'=>true,'message'=>'Valid Exam Code');
 }
else
{
$data=array('id'=>"",
              'code'=>""   
                  );
	$status=array('status'=>false,'message'=>'Invalid Exam Code');
}
echo(json_encode($status));
?>