<?php
$to = 'kopnite@gmail.com.com';
$subject = 'Test Msg';
$message = 'This is a test message. Please ignore details.'; 
$from = 'admin@astroisha.com';
 
// Sending email
if(mail($to, $subject, $message)){
    echo 'Your mail has been sent successfully.';
} else{
    echo 'Unable to send email. Please try again.';
}
?>