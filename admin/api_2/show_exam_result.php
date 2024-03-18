<?php

require 'connection.php';

$viewData=array();

	$uid=$_REQUEST['user_id'];
 	$exam_id=$_REQUEST['exam_id'];
    

$sql2="SELECT COUNT(option_no) as skip_count FROM `exam_question_answer` WHERE option_no=5 and question_set_id='$exam_id' and userid='$uid'";
$res=$con->query($sql2);
$skip_count=$res->fetch_assoc();

$sql3="SELECT COUNT(*) as score_count FROM exam_question_answer WHERE question_set_id = '$exam_id' AND userid = '$uid' AND answer = option_no";
$res3=$con->query($sql3);
$score_count=$res3->fetch_assoc();

$sql4="SELECT COUNT(*) as qn_count from online_test WHERE exam_id='$exam_id'";
$res4=$con->query($sql4);
$qn_count=$res4->fetch_assoc();

$score=$score_count['score_count'];
$total_not_ate=$skip_count['skip_count'];
$total_q=$qn_count['qn_count'];

$total_wrong=$total_q-($score+$total_not_ate);

$sc= $score;
		  
        $ttotal=$total_q;
        $percentage=($sc/$ttotal)*100;
        $mark_status="";
        $image="";
if($percentage==100){
    $mark_status="Outstanding";
    $image="";
}
else if($percentage>=80 ){
    $mark_status="Excellent";
    $image="";

}
else if($percentage>=70){
$mark_status="Very good";
$image="";
}
else if($percentage>=60){
$mark_status="Good";
$image="";
}
else if($percentage>=50){
$mark_status="Average";
$image="";
}
else if($percentage>=40){
$mark_status="Poor";
$image="";
}
else if($percentage>=0){
$mark_status="Very Bad";
$image="";
}

    
        $viewData[]=array("Skipped_questions"=>$skip_count['skip_count'],
                            "total_score"=>$score_count['score_count'],
                            "total_questions"=>$qn_count['qn_count'],
                            "total_wrong"=>$total_wrong,
                            'mark_status'=>$mark_status);
    
    $result=array('status'=>true,
                'message'=>'Final Result',
                'scoreDetails'=>$viewData);

 echo json_encode($result);
?>