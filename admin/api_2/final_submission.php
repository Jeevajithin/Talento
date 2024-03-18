<?php

require 'connection.php';

$anserArray=array();
$viewData=array();

	$uid=$_REQUEST['user_id'];
 	$exam_details_id=$_REQUEST['exam_id'];
  $exam_type_id=1;
                        
          //$score=$_REQUEST['score'];
          
          
          $time_start=$_REQUEST['time_start'];
          $time_end=$_REQUEST['time_end'];

$sql2="SELECT COUNT(option_no) as skip_count FROM `exam_question_answer` WHERE option_no=5 and question_set_id='$exam_details_id' and userid='$uid'";
$res=$con->query($sql2);
$skip_count=$res->fetch_assoc();
          
$sql3="SELECT COUNT(*) as score_count FROM exam_question_answer WHERE question_set_id = '$exam_details_id' AND userid = '$uid' AND answer = option_no";
$res3=$con->query($sql3);
$score_count=$res3->fetch_assoc();

$sql4="SELECT COUNT(*) as qn_count from online_test WHERE exam_id='$exam_details_id'";
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


$s="select * from exam where exam_id=$exam_details_id";
$r=$con->query($s);
$ro=$r->fetch_assoc();
$batch_id=$ro['batch_id'];
$semester=$ro['semester'];
$subject=$ro['subject'];
$exam_title=$ro['exam_title'];
$date=date('Y-m-d');
 
//echo $batch_id;die();


$sql="select * from exam_result where exam_id=$exam_details_id and stud_id=$uid";
$result=$con->query($sql);
$count=$result->num_rows;
if($count>0)
{
    $row=$result->fetch_assoc();
    $details=$row['result_id'];
    $query="update exam_result set no_of_correct_answer='$score',batch_id='$batch_id',semester='$semester',subject='$subject',exam_title='$exam_title',time_start='$time_start',time_end='$time_end',start_date='$date',total_q='$total_q',flag='0',total_not_attend='$total_not_ate',total_wrong='$total_wrong' where exam_id='$exam_details_id' and stud_id='$uid'";
    $queryResult=$con->query($query);
    $viewData=array();



    $viewdata="SELECT * FROM `exam_result` where result_id='$details' ";
    $viewResult=$con->query($viewdata);
    while($viewRow=$viewResult->fetch_assoc()){
        $viewData[]=array('id'=>$viewRow['result_id'],
                          "user_id"=>$viewRow['stud_id'],
            "exam_details_id"=>$viewRow['exam_id'],
            "exam_type_id"=>"",
            "session_id"=>"",
            "date"=>$viewRow['start_date'],
            "score"=>$score_count['score_count'],
            "total_q"=>$viewRow['total_q'],
            "total_wrong"=>$viewRow['total_wrong'],
            "total_not_ate"=>$skip_count['skip_count'],
            "time_start"=>$viewRow['time_start'],
            "time_end"=>$viewRow['time_end']);
    }
    $result=array('status'=>true,
                'message'=>'Answer Submit Success',
                'mark_status'=>$mark_status,
                'image'=>$image,
                'answerDetails'=>$viewData);

                /*************Exam Code Updation**************/

                // $queryd="DELETE FROM exam_code where userid=$uid";
                // $queryResultd=$con->query($queryd);

                /*************Exam Code Updation**************/
                


}
else{


  //  $query="insert into exam_result(stud_id,exam_id,batch_id,no_of_correct_answer,total_q,time_start,time_end,start_date,semester,subject,exam_title,flag) values('$uid','$','$batch_id','$','$total_q','$time_start','$time_end','$date','$semester','$subject','$exam_title','0')";
  
  $query="INSERT INTO `exam_result` (`exam_id`, `stud_id`, `no_of_correct_answer`, `batch_id`, `semester`, `subject`, `exam_title`, `flag`,`time_start`, `time_end`, `start_date`, `total_q`,`total_not_attend`,`total_wrong`) VALUES ('$exam_details_id', '$uid', '$score', '$batch_id', '$semester', '$subject', '$exam_title', '0','$time_start','$time_end','$date','$total_q','$total_not_ate','$total_wrong')";
  
	
$queryResult=$con->query($query);
  
      $last_id = $con->insert_id;

        /*************Exam Code Updation**************/
                
        // $queryd="DELETE FROM exam_code where userid=$uid";
        // $queryResultd=$con->query($queryd);

        /*************Exam Code Updation**************/
	  
	  $viewData=array();

	  
      $viewdata="SELECT * FROM `exam_result` where  result_id='$last_id' ";
    $viewResult=$con->query($viewdata);
    while($viewRow=$viewResult->fetch_assoc()){
        $viewData[]=array('id'=>$viewRow['result_id'],
                          "user_id"=>$viewRow['stud_id'],
            "exam_details_id"=>$viewRow['exam_id'],
            "exam_type_id"=>"",
            "session_id"=>"",
            "date"=>$viewRow['start_date'],
            "score"=>$viewRow['no_of_correct_answer'],
            "total_q"=>$viewRow['total_q'],
            "total_wrong"=>$viewRow['total_wrong'],
            "total_not_ate"=>$viewRow['total_not_attend'],
            "time_start"=>$viewRow['time_start'],
            "time_end"=>$viewRow['time_end']);
    }


    $result=array('status'=>true,
                'message'=>'Answer Submit Successfully',
                'mark_status'=>$mark_status,
                'image'=>$image,
                'answerDetails'=>$viewData);


}



 echo json_encode($result);
?>