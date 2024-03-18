<?php
require 'connection.php';


	  $exam_id=$_REQUEST['exam_id'];
      $question_id=$_REQUEST['question_id'];
      $option=$_REQUEST['option'];
      $answer=$_REQUEST['answer'];
      $userid=$_REQUEST['userid'];
      $user_id=$userid;
      $question_set_it="";


$sql="select * from exam_question_answer where question_set_id='$exam_id' and question_no='$question_id' and userid='$userid'";
$result=$con->query($sql);
$count=$result->num_rows;
if($count>0)
{

	$row=$result->fetch_assoc();
	$details=$row['e_id'];
	$question_set_it=$row['question_set_id'];
	
	$query="update exam_question_answer set option_no='$option', answer='$answer',userid='$uid' where question_set_id='$exam_id' and question_no='$question_id' and userid='$uid'";
	$queryResult=$con->query($query);


	$query1="update exam_question_answer set option_no='$option', answer='$answer',
                  userid='$userid' where question_set_id='$exam_id' and question_no='$question_id' and userid='$user_id'";
	$queryResult=$con->query($query1);
	 $result=array('status'=>true,
                'message'=>'Updated Successfully');

}
else
{


	$query="insert into exam_question_answer(question_set_id,question_no,option_no,answer,userid) values('$exam_id','$question_id','$option','$answer','$user_id')";
	$queryResult=$con->query($query);
	 $count=$queryResult->affected_rows;

	 $result=array('status'=>true,
                'message'=>'Inserted Successfully');

}


/******************************************************************/



/*else{




$sql="select * from exam_question_answer where question_set_id='$question_set' and question_no='$question_id' and userid='$user_id'";
$result=$con_it->query($sql);
$count=$result->num_rows;
if($count>0){
	$row=$result->fetch_assoc();
	$details=$row['e_id'];
	$query="update exam_question_answer set option_no='$option', answer='$answer',
                  userid='$userid' where question_set_id='$question_set' and question_no='$question_id' and userid='$user_id'";
	$queryResult=$con_it->query($query);
	 $result=array('status'=>true,
                'message'=>'Updated Successfully');

}
else{
	$query="insert into exam_question_answer(question_set_id,question_no,option_no,answer,userid) values('$question_set','$question_id','$option','$answer','$user_id')";
	$queryResult=$con_it->query($query);
	 $count=$queryResult->affected_rows;

	 $result=array('status'=>true,
                'message'=>'Inserted Successfully');


}
}*/

 echo json_encode($result);
?>