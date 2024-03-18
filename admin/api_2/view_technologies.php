<?php
require("connection.php");
//$userid=$_REQUEST['user_id'];
$data=array();

	$result=$con->query("(SELECT * FROM `technologies` WHERE id = 22)
	UNION ALL
	(SELECT * FROM `technologies` WHERE NOT id = 23 AND NOT name = 'Not Applicable' AND id != 22)
	ORDER BY (id = 22) DESC, id ASC");
	$count=$result->num_rows;
		if($count>0)
			{
				while($row=$result->fetch_assoc())
					{
					  $data[] =array(
						"batch_id" => $row['id'],
						"batch_name" => $row['name'] ,
						"image"=>$base_path."api_2/uploads/".$row['image']                      );                 
	$post = array("status"=>true,"batch_details"=>$data);

					}
			}

		 else 
		 {
			$post=array("status"=>false,"batch_details"=>$data);
		 }

echo(json_encode($post));

?>