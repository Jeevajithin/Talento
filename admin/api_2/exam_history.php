<?php
require 'connection.php';

$viewData=array();

$uid=$_REQUEST['user_id'];


    $viewdata="SELECT *	FROM exam_result WHERE stud_id = '$uid' ORDER BY start_date DESC, time_end DESC";
	
    $viewResult=$con->query($viewdata);
	$count=$viewResult->num_rows;
	if($count>0)
	{

    while($viewRow=$viewResult->fetch_assoc())
	{
		$exam_id=$viewRow['exam_id'];
		

		$sql2="SELECT COUNT(option_no) as skip_count FROM `exam_question_answer` WHERE option_no=5 and question_set_id='$exam_id' and userid='$uid'";
		$res=$con->query($sql2);
		$skip_count=$res->fetch_assoc();

		
		$sql3="SELECT COUNT(*) as score_count FROM exam_question_answer WHERE question_set_id = '$exam_id' AND userid = '$uid' AND answer = option_no";
		$res3=$con->query($sql3);
		$score_count=$res3->fetch_assoc();


		$tech_id=$viewRow['batch_id'];
		$sql="select * from technologies where id='$tech_id'";
    	$result=$con->query($sql);
		$row=$result->fetch_assoc();
	
	
        $viewData[]=array('id'=>$viewRow['result_id'],
                        "user_id"=>$viewRow['stud_id'],
            			"exam_details_id"=>$viewRow['exam_id'],
            			"exam_type_id"=>"",
            			"session_id"=>"",
            			"date"=>$viewRow['start_date'],
            			"score"=>$score_count['score_count'],
            			"total_q"=>$viewRow['total_q'],
            			"total_not_ate"=>$skip_count['skip_count'],
						"total_wrong"=>$viewRow['total_wrong'],
            			"time_start"=>$viewRow['time_start'],
            			"time_end"=>$viewRow['time_end'],
						"exam_title"=>$viewRow['exam_title'],
						"technology_name"=>$row['name'],
						"technology_icon"=>$base_path."api/uploads/".$row['image']);
    }


    $result=array('status'=>true,
                'message'=>'Exam History',
                'examHistory'=>$viewData);

	}
	else
	{
		$result=array('status'=>false,
                'message'=>'No Exam History',
                'examHistory'=>$viewData);
	}
 echo json_encode($result);
?>