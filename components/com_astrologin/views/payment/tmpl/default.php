<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
include_once "/home/astroxou/php/Net/GeoIP/GeoIP.php";
$geoip                          = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoIP/GeoLiteCity.dat");
//$ip                           = '117.196.1.11';
//$ip                             = '157.55.39.123';  // ip address
$ip                       	= $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server
//$info                         = geoip_country_code_by_name($ip);
//$country                      = geoip_country_name_by_name($ip);     
$location               	= $geoip->lookupLocation($ip);
$info                   	= $location->countryCode;
$country                	= $location->countryName;


if($info == 'IN'|| $info == "NP" )
{
?>
<p class="text-right">This information was last updated on 18th June 2019</p>
<div class="lead alert alert-dark">Payment and Refunds</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Authorization And Payment</div>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clients can place an order for a astrological reading on <a href="http://www.astroisha.com/ask-question" target="_blank">Ask An Expert</a> page. On submission of question form, client would be transferred to third party payment gateway(Paytm or CCAvenues) to process online payment. 
Clients are advised to keep a reference of payment and notify <strong>Astro Isha</strong> via email: consult@astroisha.com in case they do not get confirmation of payment on their email.
On successful completion of order a confirmation email would be provided to the client. Clients are requested to keep the confirmation email until order is completed to avoid issues later.</p>
<div class="lead alert alert-dark">Order Cancellation And Refunds</div>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If the client has a change of mind and wishes to cancel the order he has 24 working hours to do so. Kindly notify us at <?php echo JHtml::_('email.cloak', 'consult@astroisha.com'); ?> 
and also mention the token number provided in the confirmation email. Astro Isha would cancel the order and money would be credited back to your account. 
A confirmation of cancellation of order would be provided to client with refunded amount as attachment.
</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;After 24 Hours since order has been confirmed, Astro Isha reserves the right to proceed with the order and client requests for cancellation of order 
cannot be entertained.</p>
<div class="lead alert alert-dark">Order Processing and Confirmation</div>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;After 24 Hours Astro Isha would start processing the order. The client query would be provided with a logical answer 
and the answer would be provided as attachment in the email. An online link is also provided to the answer of the question.</p>

<div class="lead alert alert-dark">Order Failure and Refunds</div>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In case there is a failure to give answer to clients query after 12 Days of order placement, the money is credited 
directly back into the account of client.</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In case refund isn't possible in the bank account than client would be mailed 
about a convenient way in which he would like to be refunded the amount back.</p>


<?php
}
else
{
?>
<div class="lead alert alert-dark">Payment and Refunds</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Authorization And Payments</div>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clients can place an order on <a href="http://www.astroisha.com/ask-question" target="_blank">Ask An Expert</a> Page. On placement of order 
clients would be redirected to <a href="www.paypal.com" title="paypal"><i class="fab fa-paypal"></i> Paypal</a> to pay for the order. 
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On successful completion of order a confirmation email would be provided. Clients are requested to keep the confirmation email until order is completed to avoid issues later.</p>
<div class="lead alert alert-dark">Order Cancellation And Refunds</div>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If the Client has a change of mind and wishes to cancel the order he/she has 24 working hours to do so. Kindly notify us at <?php echo JHtml::_('email.cloak', 'consult@astroisha.com'); ?> 
and also mention the token number provided in the confirmation email. Astro Isha would cancel the order and money would be credited back to your account. 
</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;After 24 Hours since order has been confirmed, Astro Isha reserves the right to proceed with the order and client requests for cancellation of order 
cannot be entertained.</p>    
<div class="lead alert alert-dark">Order Processing and Confirmation</div>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;After 24 Hours Astro Isha would start processing client order. The client query would be provided with a logical answer and the answer would be provided as attachment in the email. An online link to client query is also available on our website.</p>      
<div class="lead alert alert-dark">Order Failure and Refunds</div>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In case there is a failure to give answer to clients query in 10 working days, the money is credited 
directly back into the account of client.</p>
<?php
}
?>
<div class="mb-3"></div>