<?php
	$pay_id				= $_GET['payment_id'];
    $pay_request_id		= $_GET['payment_request_id'];
    $token 				= $_GET['token'];
    $server				= 'https://'.$_SERVER['SERVER_NAME'];
	$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://instamojo.com/api/1.1/payments/'.$pay_id.'/');
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER,
					array("X-Api-Key:b40083c8e7b7a7fcb0c6feed9ddf832a",
						  "X-Auth-Token:f0acdcbbba59f3df31f24121c3f5fc8a"));

		$response = curl_exec($ch);
		curl_close($ch);
		
		$json 		= json_decode($response);
		//print_r($json);exit;
		$status 	= $json->payment->status;
		if($status		== "Credit")
		{
			header('Location:'.$server.'/index.php?option=com_astrologin&task=astroask.confirmCCPayment&token='.$token.'&track_id='.$pay_id.'&status='.$status);
		}
		else
		{
			header('Location:'.$server.'/index.php?option=com_astrologin&task=astroask.confirmCCPayment&payment=fail');
		}
		
?>
