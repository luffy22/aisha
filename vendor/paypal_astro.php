<?php
header('Content-type: application/json');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once('bootstrap.php');
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Api\Sale;

if(isset($_GET['token']))
{

$name               = $_GET['name'];
$token              = $_GET['token'];
$token1             = substr($token,6);
$email              = $_GET['email'];
$quantity           = (int)1;
$currency           = $_GET['curr'];
$fees               = $_GET['amount'];

$payer_info         = new PayerInfo();
$payer_info         ->setFirstName($name);

$payer = new Payer();
$payer->setPaymentMethod("paypal")
       ->setPayerInfo($payer_info);

$item = new Item();
$item->setName($name)
    ->setCurrency($currency)
    ->setQuantity($quantity)
    ->setSku($token1)
    ->setPrice($fees);
    
$itemlist       = new ItemList();
$itemlist       ->setItems(array($item));

$details        = new Details();
$details        ->setFee($fees);

$amount         = new Amount();
$amount         ->setCurrency($currency)
                ->setTotal($fees)
                ->setDetails($details);
        
$transaction    = new Transaction();
$transaction    ->setAmount($amount)
                ->setItemList($itemlist)
                ->setDescription("AstroPay: ".$token)
                ->setInvoiceNumber("AstroIsha Astrologer ID: ".$token1);
                
$baseUrl = getBaseUrl();

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/executeastro.php?success=true&uniq_id=$token&email=$email")
    ->setCancelUrl("$baseUrl/executeastro.php?success=false&uniq_id=$token&email=$email");

$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));

    $request = clone $payment;
    try {
        $payment->create($apiContext);
    } catch (Exception $ex) {
        echo $payment->getFailureReason();
    }
    $approvalUrl    = $payment->getApprovalLink();
    $payment_id     = $payment->id;
    header('Location:'.$approvalUrl);
    
 //header('Location:'.$approvalUrl);
//echo $approvalUrl;exit;
 //ResultPrinter::printResult("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);


}
else
{
    echo "Crucial Information Mising. Please Try Again...";
?>
<a href="http://www.astroisha.com/ask-question">
  <button type="button" class="btn btn-primary" aria-label="Left Align">
  <span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> Go Back
  </button></a><a href="http://www.astroisha.com">
  <button type="button" class="btn btn-primary" aria-label="Left Align">
  <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home Page
</button></a>
<?php
}
?>
