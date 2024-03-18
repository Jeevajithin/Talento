<?php
require 'connection.php';

$user_id = $_REQUEST['user_id'];
$password = $_REQUEST['current_password'];
$newPassword = $_REQUEST['new_password'];

$data = array();
$sql = "SELECT * FROM tl_profile WHERE id='$user_id' AND password='$password'";
$result = $con->query($sql);

$count = $result->num_rows;
if ($count > 0) {
    // User exists with the provided phone and password, proceed to update password
    $updatePasswordSql = "UPDATE tl_profile SET password='$newPassword' WHERE id='$user_id'";
    $updatePasswordResult = $con->query($updatePasswordSql);

    if ($updatePasswordResult) {
        $result = array(
            'status' => true,
            'message' => 'Password updated successfully'
        );
    } else {
        $result = array(
            'status' => false,
            'message' => 'Failed to update password'
        );
    }
} else {
    // No user found with the provided phone and password
    $result = array(
        'status' => false,
        'message' => 'Invalid Current Password'
    );
}

echo json_encode($result);
?>
