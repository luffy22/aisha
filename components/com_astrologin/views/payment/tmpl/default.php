<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
function getIP() {
  foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
     if (array_key_exists($key, $_SERVER) === true) {
        foreach (explode(',', $_SERVER[$key]) as $ip) {
           if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
              return $ip;
           }
        }
     }
  }
    //$ip = '117.196.1.11';
  //$ip = '212.58.244.20';
  //$ip   = '223.223.146.119';
  //$ip   = '208.91.198.52';
 //$ip = '66.249.73.190';
  //$ip    = '176.102.49.192'; // uk ip
  //$ip = '122.175.21.127';
  //$ip = '157.55.39.123';
  return $ip;
}
   
$json = file_get_contents('http://getcitydetails.geobytes.com/GetCityDetails?fqcn='. getIP()); 
$data = json_decode($json);
if($data->geobytesinternet == 'IN')
{
?>
<p class="text-right">This information was last updated on 26th December 2018</p>
<h3 class="lead alert alert-dark">Payment and Refunds</h3>
<div class="mb-1"></div>
<div id="payments-accordion">
<h3>Authorization And Payment</h3>
<div>
          <p>&nbsp;&nbsp;Clients can place an order for a astrological reading on <a href="http://www.astroisha.com/ask-question" target="_blank">Ask An Expert</a> page. On submission of question form, client would be transferred to third party payment gateway(Paytm or CCAvenues) to process online payment. 
              Clients are advised to keep a reference of payment and notify <strong>Astro Isha</strong> via email: admin@astroisha.com in case they do not get confirmation of payment on their email.
              On successful completion of order a confirmation email would be provided to the client. Clients are requested to keep the confirmation email until order is completed to avoid issues later.</p>
 </div>
    <h3>Order Cancellation And Refunds</h3>
<div>
          <p>&nbsp;&nbsp;If the client has a change of mind and wishes to cancel the order he has 24 working hours to do so. Kindly notify us at <?php echo JHtml::_('email.cloak', 'admin@astroisha.com'); ?> 
              and also mention the token number provided in the confirmation email. Astro Isha would cancel the order and money would be credited back to your account. 
              A confirmation of cancellation of order would be provided to client with refunded amount as attachment.
          </p>
          <p>&nbsp;&nbsp;After 24 Hours since order has been confirmed, Astro Isha reserves the right to proceed with the order and client requests for cancellation of order 
          cannot be entertained.</p>
      </div>
  <h3>Order Processing and Confirmation</h3>
  <div>
          <p>&nbsp;&nbsp;After 24 Hours Astro Isha would start processing the order. The client query would be provided with a logical answer 
          and the answer would be provided as attachment in the email. An online link is also provided to the answer of the question.</p>
      </div>
   <h3>Order Failure and Refunds</h3>
   <div>
          <p>&nbsp;&nbsp;In case there is a failure to give answer to clients query after 12 Days of order placement, the money is credited 
          directly back into the account of client.</p>
      </div>
 </div>
<?php
}
else
{
?>
<h3  class="lead alert alert-dark">Payment and Refunds</h3>
<div class="mb-1"></div>
<div id="payments-accordion1">
<h3>Authorization And Payments</h3>
<div>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clients can place an order on <a href="http://www.astroisha.com/ask-question" target="_blank">Ask An Expert</a> Page. On placement of order 
              clients would be redirected to <a href="www.paypal.com" title="paypal"><i class="fab fa-paypal"></i> Paypal</a> to pay for the order. 
              
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On successful completion of order a confirmation email would be provided. Clients are requested to keep the confirmation email until order is completed to avoid issues later.</p>
      </div>
<h3>Order Cancellation And Refunds</h3>
<div>
          <p>&nbsp;&nbsp;If the Client has a change of mind and wishes to cancel the order he/she has 24 working hours to do so. Kindly notify us at <?php echo JHtml::_('email.cloak', 'admin@astroisha.com'); ?> 
              and also mention the token number provided in the confirmation email. Astro Isha would cancel the order and money would be credited back to your account. 
             
          </p>
          <p>&nbsp;&nbsp;After 24 Hours since order has been confirmed, Astro Isha reserves the right to proceed with the order and client requests for cancellation of order 
          cannot be entertained.</p>
      </div>
  <h3>Order Processing and Confirmation</h3>
 <div>
          <p>&nbsp;&nbsp;After 24 Hours Astro Isha would start processing client order. The client query would be provided with a logical answer 
          and the answer would be provided as attachment in the email. An online link to client query is also available on our website.</p>
      </div>
<h3>Order Failure and Refunds</h3>
<div>
          <p>&nbsp;&nbsp;In case there is a failure to give answer to clients query in 10 working days, the money is credited 
          directly back into the account of client.</p>
      </div>
</div>
<?php
}
?>
