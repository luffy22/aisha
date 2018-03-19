<?php
header('Content-type: application/json');
include_once('bootstrap.php');
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

if (isset($_GET['success']) && $_GET['success'] == 'true') 
{
    $token                  = $_GET['uniq_id'];
    $paymentId              = $_GET['paymentId']; 
    $payment                = Payment::get($paymentId, $apiContext);
    $payer_id               = $payment->getPayer()->getPayerInfo()->getPayerId();
    $transactions           = $payment->getTransactions();
    $transaction            = $transactions[0];
    $execution              = new PaymentExecution();
    $execution              ->setPayerId($payer_id);
    $execution              ->addTransaction($transaction);
    $result                 = $payment->execute($execution, $apiContext);
   
    $payment                = Payment::get($paymentId, $apiContext);
    $transactions           = $payment->getTransactions();
    $relatedResources       = $transactions[0]->getRelatedResources();
    $auth                   = $relatedResources[0]->getAuthorization();
    $auth_id                = $auth->getId();
    $server                 = "http://" . $_SERVER['SERVER_NAME'];
             //echo $server;exit;
    header('Location:'.$server.'/aisha2017/index.php?option=com_astrologin&task=astroask.confirmPayment&id='.$paymentId.'&auth_id='.$auth_id.'&token='.$token);
    //$execution = new PaymentExecution();
    //$execution->setPayerId($_GET['PayerID']);
    //if($execution)
    //{
       // href();
    //}
}
else if(isset($_GET['success']) && $_GET['success'] == 'false')
{
    $token                  = $_GET['uniq_id'];
    header('Location:'.$server.'/aisha2017/index.php?option=com_astrologin&task=astroask.failPayment&token='.$token);
}
?>
