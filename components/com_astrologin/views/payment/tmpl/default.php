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
<h3>Payment and Refunds</h3>
<div class="mb-1"></div>
<div id="payments-accordion">
<h3>Authorization And Payment</h3>
<div>
          <p>&nbsp;&nbsp;Clients can place an Order for a Jyotishi(Vedic Astrology) based reading
              on <a href="http://www.astroisha.com/ask-question" target="_blank">Ask An Expert</a> Page. On submission of Question Form, client would be either be transferred to Third Party Payment Gateway(Paytm or CCAvenues) in case the client has applied for Online Payment. If he has applies for payment via Cheque, Direct Transfer or Unified Payment Interface(UPI) then an email with details for payment would be provided to the client. 
              Clients are advised to keep a reference of payment and notify <strong>Astro Isha</strong> via email: admin@astroisha.com. There the client can pay using 
          one of the payment options provided to complete the Order. On successful completion of order a confirmation email would be provided to the client. Clients are requested to keep the Confirmation Email until Order is Completed to avoid issues later.</p>
          <p>&nbsp;&nbsp;The money debited from Clients Bank Account is safe with Third Party Payment Gateway. Astro Isha does not 
          press for Remittance of Client Payment until the Client Query has been resolved.</p>
      </div>
    <h3>Order Cancellation And Refunds</h3>
<div>
          <p>&nbsp;&nbsp;If the Client has a change of mind and wishes to Cancel the Order he has 24 Working Hours to do so. Kindly notify us at <?php echo JHtml::_('email.cloak', 'admin@astroisha.com'); ?> 
              and also mention the token number or Unique Tracking ID or Bank Reference Number provided in the confirmation email. Astro Isha would Cancel the Order and money would be credited back to your account. 
              A confirmation of Cancellation of Order would be provided to Client. As money is still with Third Party Payment Gateway during this time it is 
              advised that the Client asks the concerned Payment Gateway about the duration of time before money is credited back into his/her account.
          </p>
          <p>&nbsp;&nbsp;After 24 Hours since order has been confirmed, Astro Isha reserves the right to proceed with the Order and Client Requests for Cancellation of Order 
          cannot be entertained.</p>
      </div>
  <h3>Order Processing and Confirmation</h3>
  <div>
          <p>&nbsp;&nbsp;After 24 Hours Astro Isha would start processing the Order. The client query would be provided with a logical answer 
          and the answer would be provided as attachment in the email. Astro Isha would only ask for Remittance of Payment once 
          the client query has been resolved with a logical answer.</p>
      </div>
   <h3>Order Failure and Refunds</h3>
   <div>
          <p>&nbsp;&nbsp;As mentioned earlier Astro Isha would only ask for Remittance once the Client is emailed 
          with Answer and Logical Solution to his Questions. This Order would likely be processed in 7-10 Working Days.</p>
          <p>&nbsp;&nbsp;In case there is a failure to give answer to clients query after 12 Days of Order Placement, the money is credited 
          directly back into the Account of Client.</p>
      </div>
 </div>
<?php
}
else
{
?>
<h3>Payment and Refunds</h3>
<div class="mb-1"></div>
<div id="payments-accordion1">
<h3>Authorization And Payments</h3>
<div>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clients can place an Order on <a href="http://www.astroisha.com/ask-question" target="_blank">Ask An Expert</a> Page. For International Clients there are three mode of payments available: 
          <ol>
              <li>Paypal: Client would be redirected to Paypal to complete the Order. Confirmation Email would be provided on completion of payment.</li>
              <li>PaypalMe: Client can pay via Paypal Me also which offers Paypal Payment Services but in a much simplified format. Customer would be provided a link in 
              an email to Pay Online. All the customer needs to do is pay and email confirmation of payment to admin@astroisha.com once payment is complete. Astro Isha would process the order on confirmation of payment.</li>
              <li>Direct Transfer: Customers can also transfer the amount directly to our Bank. Details for International Transfer would be provided in confirmation email. Customers are requested to 
              keep some reference of payment to avoid issues later.</li>
          </ol>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On successful completion of order a confirmation email would be provided. Clients are requested to keep the Confirmation Email until Order is Completed to avoid issues later.</p>
      </div>
<h3>Order Cancellation And Refunds</h3>
<div>
          <p>&nbsp;&nbsp;If the Client has a change of mind and wishes to Cancel the Order he has 24 Working Hours to do so. Kindly notify us at <?php echo JHtml::_('email.cloak', 'admin@astroisha.com'); ?> 
              and also mention the token number or Paypal Transaction ID or Paypal Order ID provided in the confirmation email in case order is done via Paypal or Paypal.Me. Astro Isha would Cancel the Order and money would be credited back to your account. 
              In case for Direct Transfer clients would need to provide Bank Details with Account Name, Account Number and Swift Code for Astro Isha refund back the amount into your account. 
              Bear in mind Astro Isha does not hold liability to Transaction Charges applied to Online Transfer. We can only pay the amount we have received. A confirmation of Cancellation of Order would be provided to Client. 
          </p>
          <p>&nbsp;&nbsp;After 24 Hours since order has been confirmed, Astro Isha reserves the right to proceed with the Order and Client Requests for Cancellation of Order 
          cannot be entertained.</p>
      </div>
  <h3>Order Processing and Confirmation</h3>
 <div>
          <p>&nbsp;&nbsp;After 24 Hours Astro Isha would start processing the Order. The client query would be provided with a logical answer 
          and the answer would be provided as attachment in the email. Astro Isha would only ask for Remittance of Payment once 
          the client query has been resolved with a logical answer.</p>
      </div>
<h3>Order Failure and Refunds</h3>
<div>
          <p>&nbsp;&nbsp;As mentioned earlier Astro Isha would only ask for Remittance once the Client is emailed 
          with Answer and Logical Solution to his Questions. This Order would likely be processed in 7-10 Working Days.</p>
          <p>&nbsp;&nbsp;In case there is a failure to give answer to clients query after 29 Days of Order Placement, the money is credited 
          directly back into the Account of Client.</p>
      </div>
</div>
<?php
}
?>
