<?php include('Crypto.php');?>
<?php

	$workingKey='143063E52AFFE0A6170B547A9E7CEAE1';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
	}
        $values = array("yes");
        for($i = 0; $i < $dataSize; $i++) 
        {
            $information=explode('=',$decryptValues[$i]);
            //echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
            array_push($values, $information[1]);

        }
        //print_r($values);exit;
        $token_number           = $values[1];
        $ccavenue_track_id      = $values[2];
        $ccavenue_bank_ref      = $values[3];
        $ccavenue_order_status  = $values[4];
        $email                  = $values[19];
        //echo $token_number." ".$email;exit;
	if($order_status==="Success")
	{
            header('Location:'.$server.'/index.php?option=com_astrologin&task=transitreport.confirmCCPayment&token='.$token_number.'&track_id='.$ccavenue_track_id.'&bank_ref='.$ccavenue_bank_ref.'&status='.$ccavenue_order_status);
                
	}
      	else if($order_status==="Aborted"||$order_status=="Failure")
	{
            header('Location:'.$server.'/index.php?option=com_astrologin&task=transitreport.failPayment&token='.$token_number.'&email='.$email.'&status='.$ccavenue_order_status);
        }
	else
	{
		echo "<br>Security Error. Illegal access detected. Please wait while you are redirected.";
                header('Refresh: 5; url=http://www.astroisha.com/transitreport');
	
	}

	echo "<br><br>";

	echo "<table cellspacing=4 cellpadding=4>";
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	}

	echo "</table><br>";
	echo "</center>";

?>
