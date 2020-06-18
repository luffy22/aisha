<?php 
$order_id       = $_POST['order_id'];
$payment_id     = $_POST['razorpay_payment_id'];
$server         = "https://" . $_SERVER['SERVER_NAME'] ;
header('Location:'.$server.'/index.php?option=com_astrologin&task=astroask.confirmCCPayment&token='.$order_id.'&track_id='.$payment_id.'&status=confirmed');
?>