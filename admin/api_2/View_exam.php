<?php
require 'connection.php';

$exam_type=array();
$exam_details=array();
$result=array();

$user_id=$_REQUEST['user_id'];
$tech_id=$_REQUEST['tech_id'];

if($tech_id==22)
{
	$selection_test=true;
}
else
{
	$selection_test=false;
}

$view_status=0;

 $exam="SELECT * FROM `exam` where batch_id=$tech_id and type=1 ";
 $examResult=$con->query($exam);
 $examCount=$examResult->num_rows;
 if($examCount>0)
 {
  while($value=$examResult->fetch_assoc()){
    //print_r($value);
    $time_id=$value['exam_id'];
      $query="select no_of_correct_answer from exam_result where stud_id= $user_id and exam_id= $time_id ";
    $resultQuery=$con->query($query);
    $row=$resultQuery->fetch_assoc();
	
    if($tech_id==22)
    {
      $question_count=75;
    }
    else
    {
      $question_count_sql="select count(question) as total from online_test where exam_id=$time_id";
      $question_count_query=$con->query($question_count_sql);
      
      $question_row=$question_count_query->fetch_assoc();
      $question_count=$question_row['total'];
    }

	

    $score_details=$row['no_of_correct_answer'];
if($userid==""){
  $loc=$value['g_status'];
}
else{
  $loc=$value['stu_status'];
}
    if($score_details==''){
  $view_status=0;
}
else{
  $view_status=1;
}

$base_name2 = basename($value['exam_icon']);

     $exam_type[]=array("id"=>$value['exam_id'],
                       "test_name"=>$value['exam_title'],
                       "exam_icon"=>$base_path."uploads/".$base_name2,
                       "test_type"=>$type,
                       "duration"=>$value['examtime'],
                       "no_of_ques"=>$question_count,
                       "exam_access_code"=>"",
                       "exam_level"=>"",
                       "exam_company_code"=>"",
                       "exam_college_id"=>"",
                       "visibility"=>"",
                       "score"=>($score_details==null)?"":$score_details,
                       "view_status"=>$view_status,
                     "lock_status"=>$loc,
					 "selection_test"=>$selection_test);

  }

$result=array('status'=>true,
                'message'=>'Exam exist',
                'examDetails'=>$exam_type);
}
else{
   $result=array('status'=>false,
                'message'=>'Exam does not exist',
                'examDetails'=>$exam_type);
}

echo json_encode($result);
?>