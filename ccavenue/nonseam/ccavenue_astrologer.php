<html>
<head>
<script>
	window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;
	};   
</script>
</head>
<body>
<?php
        if(isset($_GET['token']))
{
        $name               = str_replace("_"," ",$_GET['name']);
        $token              = $_GET['token'];
        $token1             = substr($token,6);
        $email              = $_GET['email'];
        $quantity           = (int)1;
        $currency           = "INR";
        $fees               = $_GET['amount'];
        if(!empty($_GET['city']))
        {
            $city           = $_GET['city'];
        }
        else
        {
            $city           = "none";
        }
        if(!empty($_GET['state']))
        {
            $state           = $_GET['state'];
        }
        else
        {
            $state           = "none";
        }if(!empty($_GET['country']))
        {
            $country           = $_GET['country'];
        }
        else
        {
            $country           = "none";
        }
        if(!empty($_GET['pcode']))
        {
            $pincode           = $_GET['pcode'];
        }
        else
        {
            $pincode           = 00000;
        }
        if(!empty($_GET['mobile']))
        {
            $mobile           = $_GET['mobile'];
        }
        else
        {
            $mobile           = 0000000000;
        }
        //  $server             = 'http://'.$_SERVER['SERVER_NAME'];  // uncomment on server
        $server             = 'https://www.astroisha.com';

?>
    <form method="post" id="customerData" name="customerData" action="ccavRequestHandler.php">
        <input type="text" name="tid" id="tid" readonly />
        <input type="text" name="merchant_id" value="79450"/>
        <input type="text" name="order_id" value="<?php echo trim($token1); ?>"/>
        <input type="text" name="amount" value="<?php echo trim($fees); ?>"/>
        <input type="text" name="currency" value="<?php echo trim($currency); ?>"/>
        <input type="text" name="redirect_url" value="<?php echo $server.'/ccavenue/nonseam/ccavResponseHandler2.php?payment=success&email='.$email.'&token='.$token; ?>" />
        <input type="text" name="cancel_url" value="<?php echo $server.'/ccavenue/nonseam/ccavResponseHandler2.php?payment=fail&email='.$email.'&token='.$token; ?>"/>
        <input type="text" name="language" value="EN"/>
        <input type="text" name="billing_name" value="<?php echo trim($name); ?>"/>
        <input type="text" name="billing_email" value="<?php echo trim($email); ?>"/>
        <input type="text" name="billing_address" value="Dummy Address. Please ignore details."/>
        <input type="text" name="billing_city" value="<?php echo $city ?>"/>
        <input type="text" name="billing_state" value="<?php echo $state; ?>"/>
        <input type="text" name="billing_country" value="<?php echo $country; ?>"/>
        <input type="text" name="billing_zip" value="<?php echo $pincode; ?>"/>
        <input type="text" name="billing_tel" value="<?php echo $mobile; ?>"/>
        <input type="submit" value="CheckOut" />
<?php
}
?>
</form>
    <script language='javascript'>document.customerData.submit();</script>
	</body>
</html>


