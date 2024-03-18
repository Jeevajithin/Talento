<?php
require 'connection.php';

$viewData=array();

$uid=$_REQUEST['user_id'];
$exam_id=$_REQUEST['exam_id'];


    $viewdata="SELECT * FROM `exam_question_answer` WHERE question_set_id='$exam_id' and userid='$uid'";
    $viewResult=$con->query($viewdata);
	
    while($viewRow=$viewResult->fetch_assoc())
	{
        $answer=$viewRow['option_no'];
        if($answer==5) {
            $ans="";
        }else {
            $ans=$viewRow['option_no'];
        }
        $question_id=$viewRow['question_no'];
		$sql="SELECT * FROM `online_test` WHERE test_id='$question_id'";
    	$result=$con->query($sql);
		$row=$result->fetch_assoc();

		$viewData[]=array('id'=>$viewRow['e_id'],
                        "question_no"=>$viewRow['question_no'],
						"question"=>$row['question'],
						"option1"=>$row['a'],
						"option2"=>$row['b'],
						"option3"=>$row['c'],
						"option4"=>$row['d'],
            			"selected_answer"=>$ans,
						"answer"=>$viewRow['answer']);

    }


    $result=array('status'=>true,
                'message'=>'Exam History',
                'examDetailedHistory'=>$viewData);


 echo json_encode($result);
?>