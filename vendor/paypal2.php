<html>
<head>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>
<body>
<div class="alert alert-danger alert-dismissible fade show" role="alert" id="cancel-order">
  <strong>Order Failed.</strong> Please try again if you wish to avail our services
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<form>
<?php
//echo "calls";exit;
if(isset($_GET['token']))
{
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
$name               = str_replace("_"," ",$_GET['name']);
$token              = $_GET['token'];
$token1             = substr($token,6);
$email              = $_GET['email'];
$quantity           = (int)1;
$currency           = $_GET['curr'];
$fees               = $_GET['fees'];

?>
<input type="hidden" value="<?php echo $name; ?>" name="order_name" id="order_name" />
<input type="hidden" value="<?php echo $email;?>" name="order_email" id="order_email" />
<input type="hidden" value="<?Php echo $token; ?>" name="order_token" id="order_token" />
<input type="hidden" value="<?php echo $currency; ?>" name="order_curr" id="order_curr"/>
<input type="hidden" value="<?php echo $fees; ?>" name="order_val" id="order_val" />
<input type="hidden" value="<?php echo $server; ?>" name="order_server" id="order_server" />
</form>
<?php 
}
?>
<br/><br/>
<div id="smart-button-container">
      <div style="text-align: center;">
        <div id="paypal-button-container"></div>
        <div class="d-grid col-6 mx-auto">
        <a class="btn btn-primary p-2" href="<?php echo $server; ?>"><i class="bi bi-house-door-fill"></i> Home</a>
        </div>
      </div>
    
    </div>
<!-- test mode -->
<!--<script src="https://www.paypal.com/sdk/js?client-id=sb&intent=authorize&currency=<?php //echo $currency; ?>" data-sdk-integration-source="button-factory"></script>-->
  <!--production mode -->
  <script src="https://www.paypal.com/sdk/js?client-id=AZSURibGprhN1hx1hxMOJ_AnClc5dy7eamJeWdjcllzY6tQe7K0oRIikKKs9ntzh_n_lrEphL0c72h8G&intent=authorize&currency=<?php echo $currency; ?>" data-sdk-integration-source="button-factory"></script>
 <script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'paypal',
          
        },

        createOrder: function(data, actions) {
          var amount    = document.getElementById("order_val").value;
          var currency  = document.getElementById("order_curr").value;
          var email     = document.getElementById("order_email").value;
          var token     = document.getElementById("order_token").value;
          return actions.order.create({
       
            purchase_units: [{"amount":{"currency_code":currency,"value":amount}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.authorize().then(function(authorization) {
            var amount          = document.getElementById("order_val").value;
            var currency        = document.getElementById("order_curr").value;
            var email           = document.getElementById("order_email").value;
            var token           = document.getElementById("order_token").value;
            var server 		 	= document.getElementById("order_server").value;
            var order_id        = data['orderID'];
            // Full available details
            //console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            var auth_id = authorization.purchase_units[0].payments.authorizations[0].id;
            //alert(auth_id);
            // Show a success message within this page, e.g.
            //const element = document.getElementById('paypal-button-container');
            //element.innerHTML = "Auth ID:"+authorizationID;
            //element.innerHTML = '<h3>Thank you for your payment!</h3>';
            window.location.replace(server+'/vendor/executepayment.php?success=true&uniq_id='+token+'&auth_id='+auth_id+'&order_id='+order_id);
            // Or go to another URL:  actions.redirect('thank_you.html');
            
          });
        },
        onCancel: function (data) {

           var msg      = document.getElementById("cancel-order");
           msg.style.visibility = 'visible';
        },
        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
  </script> 
  <link rel="stylesheet" href="<?php echo $server; ?>/templates/astroisha_4/css/bootstrap.min.css" type="text/css" />
<script src="<?php echo $server; ?>/templates/astroisha_4/js/bootstrap.bundle.min.js" type="text/javascript"></script>  
  <style type="text/css">
      #cancel-order{visibility: hidden;}
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"><link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet">
</body>
</html>

