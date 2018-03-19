<?php
include_once('bootstrap.php');
session_start();
use PayPal\Api\RedirectUrls;
$baseUrl = getBaseUrl();

if ((isset($_POST['submit']))&&($_POST['submit']=='yes'))
{
    $username = $_POST['user'];
    $passwd = sha1($_POST['pwd']);
    
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
        $query  = "SELECT COUNT(*), user FROM jv_paypal_auth where user='".$username."' 
                  and password='".$passwd."'";
        $data       = mysqli_query($mysqli,$query);
        $result     = mysqli_fetch_array($data);
        $row      = mysqli_num_rows($data);
        if($row == '1')
        {
            $_SESSION['user']        = $result['user'];
            if(isset($_SESSION['user']))
            {
               $query1   = "SELECT jv_questions.UniqueID as uniq_id, jv_questions.name as name, jv_questions.email as email, 
                            jv_paypal_info.paypal_id as pay_id, jv_paypal_info.status as status,jv_paypal_info.authorize_id as auth_id FROM jv_questions
                            INNER JOIN jv_paypal_info ON jv_questions.UniqueID = jv_paypal_info.UniqueID WHERE jv_questions.payment_type='paypal'
                            AND NOT(jv_paypal_info.status= 'Completed')";
               $data1    = mysqli_query($mysqli,$query1);
               $rows     = mysqli_num_rows($data1);
?>
<div class="fluid-container">
    <h3 class="text-center">Paypal Orders</h3>
            <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>Unique ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Paypal ID</th>
                <th>Status</th>
                <th>Authorize</th>
                <th>Capture Order</th>
                <th>Cancel Order</th>
                    
            </tr>
<?php
               while($assoc1    = mysqli_fetch_array($data1))
               {
?>
            <tr>
                <td><?php echo $assoc1['uniq_id'] ?></td>
                <td><?php echo $assoc1['name'] ?></td>
                <td><?php echo $assoc1['email'] ?></td>
                <td><?php echo $assoc1['pay_id'] ?></td>
                <td><?php echo $assoc1['status'] ?></td>
                <td><?php echo $assoc1['auth_id'] ?></td>
                <?php
                        if($assoc1['status'] !== 'Voided')
                        {
                ?>
                <td><button class="btn btn-success" onclick="javascript:capture('<?php echo $assoc1['auth_id'] ?>');">Capture</button></td>
                <td><button class="btn btn-danger" onclick="javascript:cancel('<?php echo $assoc1['auth_id'] ?>');">Cancel</button></td>
                <?php
                        }
                        else
                        {
               ?>
                             <td></td>
                             <td>Order Cancelled</td>
                <?php
                        }
                ?>
            </tr>
<?php
               }
 ?>
                    </table>
    </div>
</div>
 <?php
            }
        }
    }
}
else
{
    header('Location: '.$baseUrl.'/check_cred.php');
}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../templates/astroisha2.0/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" type="text/css" href="../templates/astroisha2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../templates/astroisha2.0/css/style.css" />
    <link rel="stylesheet" type="text/css" href="../templates/astroisha2.0/css/template.css" />
    <script type="text/javascript">
        function capture(order_id)
        {
            document.getElementById("auth_capt").value = order_id;
            document.getElementById("capture_form").submit();
        }
        function cancel(pay_id)
        {
            document.getElementById("void_order").value = pay_id;
            document.getElementById("void_form").submit();
        }
    </script>
</head>
<body>
    <form id="capture_form" method="post" action="<?php echo $baseUrl ?>/auth_capture.php" >
        <input type="hidden" name="auth_capt" id="auth_capt" />
    </form>
    <form id="void_form" method="post" action="<?php echo $baseUrl ?>/void_order.php" >
        <input type="hidden" name="void_order" id="void_order" />
    </form>
</body>
</html>
