<?php
session_start();
include_once('bootstrap.php');
use PayPal\Api\RedirectUrls;
use PayPal\Api\Amount;
use PayPal\Api\Authorization;
use PayPal\Api\Capture;

$baseUrl = getBaseUrl();
if((isset($_POST['auth_capt']))&&(isset($_SESSION['user'])))
{
    $auth_id	=  $_POST['auth_capt'];
    $authorization = Authorization::get($auth_id, $apiContext);
    $amount            = $authorization->getAmount();
    $currency          = $amount->getCurrency();
    $total             = $amount->getTotal();
    
    $amt             = new Amount();
    $amt                ->setCurrency($currency);
    $amt            ->setTotal($total);
    
    $capture = new Capture();
    $capture->setAmount($amt);
    $getCapture = $authorization->capture($capture, $apiContext);
    $capture_id     = $getCapture->getId();
    $capture_state  = $getCapture->getState();

		$host   = "localhost";$user = "astroxou_admin";
		$pwd    = "*Jrp;F.=OKzG";$db   = "astroxou_jvidya";
		$mysqli = new mysqli($host, $user, $pwd, $db);
		/* check connection */
		if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
		}
		else
    { 
        $query  = "UPDATE jv_paypal_info SET status='".ucfirst($capture_state)."', final_capture='yes',
                    capture_id='".$capture_id."' WHERE authorize_id= '".$auth_id."'";
        $data       = mysqli_query($mysqli,$query);
        if($data)
        {
            echo "Successfully Captured the DATA";
        ?>
            <META http-equiv="refresh" content="5;URL=https://www.astroisha.com/vendor/show_order.php">
        <?php
        }
    }
}
else
{
?>
    <META http-equiv="refresh" content="0;URL=https://www.astroisha.com/vendor/check_cred.php">
<?php
}
?>
