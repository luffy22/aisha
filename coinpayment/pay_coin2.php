<?php
header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");

// following files need to be included
require_once("./src/CoinpaymentsAPI.php");
require_once("./src/keys_example.php");

//echo "paycoin";exit;
/** Scenario: Create a complex transaction that uses all available fields. **/

// Create a new API wrapper instance
$cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

// Enter amount for the transaction
// This would be the price for the product or service that you're selling
$amount = $_GET['fees'];
//echo $amount;exit;

// The currency for the amount above (original price)
$currency1 = 'USD';
//echo $currency1;exit;

// Litecoin Testnet is a no value currency for testing
// The currency the buyer will be sending equal to amount of $currency1
$currency2 = 'LTCT';

// Enter buyer email below
$buyer_email = $_GET['email'];
//echo $buyer_email;exit;

// Set a custom address to send the funds to.
// Will override the settings on the Coin Acceptance Settings page
$address = '';

// Enter a buyer name for later reference
$buyer_name = $_GET['name'];

// Enter additional transaction details
$item_name = 'Detailed Report';
$item_number = $_GET['token'];
$custom = '';
$invoice = '';
$ipn_url = 'https://www.astroisha.com/refund';
$fields     = array("amount"=>$amount, "currency1"=>$currency1,"currency2"=>$currency2,
                        "buyer_email"=>$buyer_email,"buyer_name"=>$buyer_name,"item_number"=>$item_number,"item_name"=>$item_name);
// Make call to API to create the transaction
try {
    $transaction_response = $cps_api->CreateCustomTransaction($fields);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}
    
//print_r($transaction_response);exit;
// Output the response of the API call
if ($transaction_response["error"] == "ok") {
    //var_dump($transaction_response);
    $url =  $transaction_response["result"]["checkout_url"];
    header('Location:'.$url);
    //$transaction    = $transaction_response->GetOnlyCallbackAddress($currency2);
     //echo $transaction;exit; 
} else {
    echo $transaction_response["error"];
}
