<?php
include_once('bootstrap.php');
session_start();
use PayPal\Api\RedirectUrls;
use PayPal\Api\Authorization;
use PayPal\Api\Amount;
$baseUrl = getBaseUrl();
if((isset($_POST['void_order']))&&(isset($_SESSION['user'])))
{
	$void_id            =  $_POST['void_order'];
	$authorization      = Authorization::get($void_id, $apiContext);
	$voidedAuth         = $authorization->void($apiContext);
	$capture_id         = $voidedAuth->getId();
	$capture_state      = $voidedAuth->getState();

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
        $query  = "UPDATE jv_paypal_info SET status='".ucfirst($capture_state)."', final_capture='no',
                    capture_id='none' WHERE authorize_id= '".$void_id."'";
        $data       = mysqli_query($mysqli,$query);
        if($data)
        {
            echo "Order Cancelled successfully";
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
