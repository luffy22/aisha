<?php include('Crypto.php')?>
<?php
if((isset($_GET['payment']))&&($_GET['payment']=='fail'))
{
    header('Location:http://www.astroisha.com/?option=com_extendedprofile&task=finance.confirmCCPayment&token='.$token_number.'&email='.$email.'&status=fail');
}
else
{
        $server             = 'https://www.astroisha.com';
	error_reporting(0);
	$workingKey='143063E52AFFE0A6170B547A9E7CEAE1';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
        //print_r($decryptValues);exit;
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

        $token                  = "token_".$values[1];
        $track_id               = $values[2];
        $bank_ref               = $values[3];
        $order_status           = $values[4];
        $email                  = $values[19];
        
	if($order_status==="Success")
	{
             header('Location:'.$server.'/index.php?option=com_extendedprofile&task=finance.confirmCCPayment&token='.$token.'&track_id='.$track_id.'&bank_ref='.$bank_ref.'&status='.$order_status.'&email='.$email);
                
	}
	else if($order_status==="Aborted")
	{
		header('Location:'.$server.'/index.php?option=com_extendedprofile&task=finance.confirmCCPayment&token='.$token.'&track_id='.$track_id.'&status='.$order_status.'&email='.$email);
	}
	else if($order_status==="Failure")
	{
		header('Location:'.$server.'/index.php?option=com_extendedprofile&task=finance.confirmCCPayment&token='.$token.'&track_id='.$track_id.'&status='.$order_status.'&email='.$email);
	}
	else
	{
		echo "<br>Security Error. Illegal access detected. Please wait while you are redirected.";
                header('Refresh: 5; url=http://www.astroisha.com/dashboard');
	
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
}
?>
