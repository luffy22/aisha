<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if($isValidChecksum == "TRUE") {
	echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
            //echo $_POST['STATUS'];exit;
		$txnid          = $_POST['TXNID'];
                $order          = str_replace("order_","token_",$_POST['ORDERID']);
                $bank_ref       = $_POST['BANKTXNID'];
                $status         = $_POST['STATUS'];
                header("Location: https://www.astroisha.com/index.php?option=com_astrologin&task=astroask.confirmCCPayment&track_id=".$txnid.
                        "&token=".$order."&bank_ref=".$bank_ref."&status=".$status);
		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.
	}
	else {
            //echo $_POST['STATUS'];exit;
		$txnid          = $_POST['TXNID'];
                $order          = str_replace("order_","token_",$_POST['ORDERID']);
                $bank_ref       = $_POST['BANKTXNID'];
                $status         = $_POST['STATUS'];
                header("Location: https://www.astroisha.com/index.php?option=com_astrologin&task=astroask.confirmCCPayment&track_id=".$txnid.
                        "&token=".$order."&bank_ref=".$bank_ref."&status=".$status);
	}

	if (isset($_POST) && count($_POST)>0 )
	{ 
		foreach($_POST as $paramName => $paramValue) {
				echo "<br/>" . $paramName . " = " . $paramValue;
		}
	}
	

}
else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}

?>