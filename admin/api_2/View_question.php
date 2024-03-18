<?php
require 'connection.php';

$question_details=array();
$exam_id=$_REQUEST['exam_id'];
$tech_id=$_REQUEST['tech_id'];
$message="";

$question_type=array();

  //if($p_type==1){
if($tech_id==22)
{
  //$query = "SELECT * FROM (SELECT * FROM online_test WHERE batch_id = 5 LIMIT 45) AS part1 UNION ALL SELECT * FROM (SELECT * FROM online_test WHERE exam_id = 123 LIMIT 30) AS part2";
  $query="SELECT * FROM (SELECT * FROM `online_test` where batch_id in (select selection_technolgy FROM exam where exam_id=$exam_id) LIMIT 45) AS part1 UNION ALL SELECT * FROM (SELECT * FROM online_test WHERE exam_id = 123 LIMIT 30) AS part2";
}
else
{
  $query = "SELECT * FROM online_test where exam_id='$exam_id'"; 
}

$result=$con->query($query);
$count=$result->num_rows;

if($count>0){

  while($value=$result->fetch_assoc()){


$message="mcq";
   $question_type[]=array("id"=>$value['test_id'],
                       "mainques"=>$value['question'],
                       "subques"=>"",
                       'opt1'=>$value['a'],
             'opt2'=>$value['b'],
             'opt3'=>$value['c'],
             'opt4'=>$value['d'],
                       "ans"=>$value['correct_answer'],
                       "exam_details_id"=>"",
                       "test_name"=>"");

    
 }
$result=array('status'=>true,
                'message'=>$message,
                'questionDetails'=>$question_type);
}
else{
   $result=array('status'=>false,
                'message'=>'Questions does not exist',
                'questionDetails'=>$question_type);
}







/*else{
    $query = "SELECT * FROM `exam_q_multi`";
 
$result=$con->query($query);
$count=$result->num_rows;
if($count>0){

 	while($value=$result->fetch_assoc()){


$message="mcq";
   $question_type[]=array("id"=>$value['id'],
                       "mainques"=>$value['question'],
                       "subques"=>"",
                       'opt1'=>$value['opt1'],
             'opt2'=>$value['opt2'],
             'opt3'=>$value['opt3'],
             'opt4'=>$value['opt4'],
                       "ans"=>$value['ans'],
                       "exam_details_id"=>$value['exam_details_id'],
                       "test_name"=>($value['test_name']==null)?"":$value['test_name']);

    
 }
$result=array('status'=>true,
                'message'=>$message,
                'questionDetails'=>$question_type);
}
else{
   $result=array('status'=>false,
                'message'=>'Questions does not exist',
                'questionDetails'=>$question_type);
}}*/

echo json_encode($result);
?>