<?php
require("connection.php");
$data=array();

	$uid=$_REQUEST['userid'];

	$sql="SELECT * FROM `gatepass_request` WHERE uid=$uid ORDER BY gp_id DESC";
	$result=$con->query($sql);
	
	$count=$result->num_rows;
		if($count>0)
			{
				while($row=$result->fetch_assoc())
					{
						$gp_id=$row['gp_id'];
						$status=$row['status'];
						if($status==0) { $s="pending"; $pdf="not available"; }
						else if($status==1) { $s="rejected"; $pdf="not available"; }
						else if($status==2)
						 { 
							$s="approved";

							$sql1="SELECT * FROM `gatepass_details` where gp_id='$gp_id'";
							$result1=$con->query($sql1);
							$row1=$result1->fetch_assoc();
							$pdf=$base_path."pdf/pdfs/".$row1['path'];
						 }

						$photo=basename($row['profile_pic']);
					  $data[] =array(
						"gatepass_id" => $gp_id,
						"name" => $row['name'],
						"start_date" => $row['start_date'],
						"end_date" => $row['end_date'],
						"status" => $s,
						 "gate_pass" => $pdf,
						"profile_pic" => $base_path."api_2/uploads/gatepass_photo/".$photo
									);                 
				$post = array("status"=>true,"gatepass_details"=>$data);

					}
			}

		 else 
		 {
			$post=array("status"=>false,"gatepass_details"=>$data);
		 }

echo(json_encode($post));

?>