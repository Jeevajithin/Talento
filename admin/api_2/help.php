<?php
require 'connection.php';


$content = $_REQUEST['content'];
$userId = $_REQUEST['userid'];
$date=date('d-m-Y');


//$sql = "INSERT INTO report (content, user_id, date) VALUES ('$content', '$userId','$date')";

$sql="INSERT INTO `reports` (`content`, `user_id`, `date`) VALUES ('$content', '$userId','$date')";

if ($con->query($sql) === TRUE) {
    $result = array(
        'status' => true,
        'message' => 'Report submitted successfully'
    );
} else {
    $result = array(
        'status' => false,
        'message' => 'Failed to submit report'
    );
}

echo json_encode($result);
?>
