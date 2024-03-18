<?php
$to = "jeeva.sics@gmail.com";
$subject = "Test Mail";
$message = "This is a test email.";

$headers = "From: jeeva.as87@gmail.com\r\n";
$headers .= "Reply-To: jeeva.sics@gmail.com\r\n";
//$headers .= "CC: cc@example.com\r\n"; // Add CC recipients if needed
//$headers .= "BCC: bcc@example.com\r\n"; // Add BCC recipients if needed
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Email sending failed.";
}
?>
