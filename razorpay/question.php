<?php
require_once('config.php');
$token          = $_GET['token'];
$description    = "Get Answer To Query";
$name           = $_GET['name'];
$email          = $_GET['email'];
$amount         = $_GET['fees'].'00';
$curr           = $_GET['curr'];
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width">
        <style>
            .razorpay-payment-button
            {
                color: #fff;
                background-color: #007bff;
                border-color: #007bff;
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <form action="https://www.astroisha.com/razorpay/process_ques.php?token=<?php echo $token; ?>" method="POST"> 
            <script    src="https://checkout.razorpay.com/v1/checkout.js"    
            data-key="<?php echo $razor_api_key; ?>" 
            data-amount="<?php echo $amount; ?>" 
            data-currency="<?php echo $curr; ?>"    
            data-order_id="<?php //echo $token; ?>"
            data-buttontext="Pay with Razorpay"    
            data-name="Astro Isha"    
            data-description="Answer to Question"    
            data-image="https://www.astroisha.com/logo.png"    
            data-prefill.name="<?php echo $name; ?>"    
            data-prefill.email="<?php echo $email; ?>"    
            data-prefill.contact=""    
            data-theme.color="#F37254"></script>
            <input type="hidden" custom="Hidden Element" name="order_id" id="order_id" value="<?php echo $token; ?>"></form>
    </body>
</html>
