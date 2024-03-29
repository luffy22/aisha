<?php
	header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");
	if(isset($_GET['token']))
	{
		$order_id		= $_GET['token'];		// token is taken as unique order 
		$price 			= $_GET['fees'];									// fees
		$email			= $_GET['email'];
		$mobile         = '9999999999'; // email is used as unique customer id
	}
	   
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
	else
	$url = "http://";
     
     
	// Append the host(domain name, ip) to the URL.
	$url .= $_SERVER['HTTP_HOST'];

	if(str_contains($url, "localhost"))
	{
		$callback_url	= $url."/aisha/PaytmKit/pgResponse2.php";
	}
	else
	{
		$callback_url	= $url."/PaytmKit/pgResponse2.php";
	}
	//echo $callback_url;exit;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Merchant Check Out Page</title>
<meta name="GENERATOR" content="Evrsoft First Page">
</head>
<body>
	<h1>Merchant Check Out Page</h1>
	<pre>
	</pre>
	<form method="post" action="pgRedirect2.php" name="txntest2">
		<table border="1">
			<tbody>
				<tr>
					<th>S.No</th>
					<th>Label</th>
					<th>Value</th>
				</tr>
				<tr>
					<td>1</td>
					<td><label>ORDER_ID::*</label></td>
					<td><input id="ORDER_ID" tabindex="1" maxlength="20" size="20"
						name="ORDER_ID" autocomplete="off"
						value="<?php echo $order_id ?>" />
					</td>
				</tr>
				<tr>
					<td>2</td>
					<td><label>CUSTID ::*</label></td>
					<td><input id="CUST_ID" tabindex="2" name="CUST_ID" autocomplete="off" value="<?php echo $email; ?>"></td>
				</tr>
				<tr>
					<td>3</td>
					<td><label>INDUSTRY_TYPE_ID ::*</label></td>
					<td><input id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail"></td>
				</tr>
				<tr>
					<td>4</td>
					<td><label>Channel ::*</label></td>
					<td><input id="CHANNEL_ID" tabindex="4" maxlength="12"
						size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
					</td>
				</tr>
				<tr>
					<td>5</td>
					<td><label>txnAmount*</label></td>
					<td><input title="TXN_AMOUNT" tabindex="10"
						type="text" name="TXN_AMOUNT"
						value="<?php echo trim($price); ?>">
					</td>
				</tr>
                                <tr>
                                    <td>7</td>
                                    <td><label>Mobile:</label></td>
                                    <td><input type="text" title="TXN_MOBILE" name="TXN_MOBILE" value ="<?php echo $mobile; ?>"/></td>
                                </tr>
                                <input type="hidden" name="CALLBACK_URL" value="<?php echo $callback_url; ?>" />
				<tr>
					<td></td>
					<td></td>
					<td><input value="CheckOut" type="submit"	onclick=""></td>
				</tr>
			</tbody>
		</table>
		* - Mandatory Fields
	</form>
	<script type="text/javascript">
			document.txntest2.submit();
		</script>
</body>
</html>
