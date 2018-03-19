<html>
<head>
<title> Non-Seamless-kit</title>
</head>
<body>
<center>

<?php include('Crypto.php')?>
<?php 

	error_reporting(0);
	
	$merchant_data='79450';
	$working_key='143063E52AFFE0A6170B547A9E7CEAE1';// 143063E52AFFE0A6170B547A9E7CEAE1
	$access_code='AVGA06CJ73AM57AGMA';     //AVGA06CJ73AM57AGMA
	
	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}

	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
          //
        //http://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction       //testing
        // https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction  // real-time
?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>

