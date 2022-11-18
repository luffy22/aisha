<?php
if (isset($_GET['success']) && $_GET['success'] == 'true') 
{
    $token                  = $_GET['uniq_id'];//echo $token;exit;
    $auth_id                = $_GET['auth_id']; 
    $order_id               = $_GET['order_id'];
    $url                    = $_SERVER['HTTP_HOST'];   
    //echo $url;exit;
    if(strpos($url, "host"))
    {
        $server                    = "http://" . $_SERVER['SERVER_NAME'].'/aisha';
    }
    else
    {
        $server                    = "https://" . $_SERVER['SERVER_NAME'];
    }
    //echo $server;exit;
    header('Location:'.$server.'/index.php?option=com_astrologin&task=astroreport.confirmPayment&id='.$order_id.'&auth_id='.$auth_id.'&token='.$token);
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
    header('Location:'.$server.'/index.php?option=com_astrologin&task=astroreport.failPayment&token='.$token.'&status=fail');
}
?>
