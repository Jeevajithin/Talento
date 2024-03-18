<?php
require("connection.php");

$data = array();

$result = $con->query("SELECT * FROM `events` WHERE status=1 and end_date >= CURDATE() ORDER BY event_id DESC");
$count = $result->num_rows;

if ($count > 0) {
    while ($row = $result->fetch_assoc()) {
        $start_date = date("d-m-Y", strtotime($row['start_date']));
        $end_date = date("d-m-Y", strtotime($row['end_date']));

        $data[] = array(
            "event_id" => $row['event_id'],
            "event_name" => $row['event_name'],
            "start_date" => $start_date,
            "end_date" => $end_date
        );

        $post = array("status" => true, "event_details" => $data);
    }
} else {
    $post = array("status" => false, "event_details" => $data);
}

echo(json_encode($post));
?>
