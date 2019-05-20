<?php
	$pay_id				=  $_GET['payment_id'];
    $pay_request_id		= $_GET['payment_request_id'];
	$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payments/'.$pay_id.'/');
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER,
					array("X-Api-Key:test_85986fb6f65a18cb69baefceba4",
						  "X-Auth-Token:test_dbb538238712c500631ed336a49"));

		$response = curl_exec($ch);
		curl_close($ch);
		
		$json 		= json_decode($response);
		print_r($json);exit;
		
?>
