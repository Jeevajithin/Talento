<?php
require 'connection.php';

$phone = $_REQUEST['phone'];
$sql3 = "SELECT * FROM tl_profile WHERE phone='$phone'";
$result3 = $con->query($sql3);
$count3 = $result3->num_rows;


date_default_timezone_set('Asia/Kolkata');
$current_time = date('Y-m-d H:i:s');
$new_time = date('Y-m-d H:i:s', strtotime($current_time . '+5 minutes'));
 

if ($count3 > 0) {
    $row = $result3->fetch_assoc();

    $email = $row['email'];
    $containsGmail = strpos($email, 'gmail') !== false;

    if ($containsGmail) {
        $randomNumber = rand(10000, 99999);

        $data[] = array('id' => $row['id'],
            'name' => ($row['id'] == null) ? "" : $row['name'],
            'email' => ($row['email'] == null) ? "" : $row['email'],
            'reset_link' => "https://talento.srishticampus.com/admin/api_2/password_reset.php?token=" . $randomNumber
        );

        $sql = "INSERT INTO `password_reset` (`user_id`, `token`, `expires_at`) VALUES ('{$row['id']}', '$randomNumber','$new_time')";

        if ($con->query($sql) === TRUE) {
            $result = array(
                'status' => true,
                'message' => 'Token Created successfully',
                'userDetails' => $data
            );
        } else {
            $result = array(
                'status' => false,
                'message' => 'Failed to create token',
                'userDetails' => $data
            );
        }
    } else {
        $result = array(
            'status' => false,
            'message' => 'Email does not contain gmail',
            'userDetails' => null
        );
    }
} else {
    $result = array(
        'status' => false,
        'message' => 'Phone number does not exist',
        'userDetails' => null
    );
}

echo json_encode($result);
?>
