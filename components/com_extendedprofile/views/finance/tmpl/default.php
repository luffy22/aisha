<?php
//print_r($this->msg);exit;
defined('_JEXEC') or die('Restricted access');
$user       = JFactory::getUser();
if(isset($_GET['terms'])&&($_GET['terms']=='no'))
{
?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Kindly accept the Terms and Conditions if you wish to join as an Astrologer.</div>
<?php
}
?>
<h3>Get Paid Membership</h3>
<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Fields marked with asterix(*) are compulsory</div>
<p>Name: <?php echo $user->name; ?></p>
<p>Email: <?php echo $user->email; ?></p>
<p>Amount: <?php echo $this->msg['amount'].' '.$this->msg['curr_code']."(".$this->msg['currency'].'-'.$this->msg['curr_full'].')'; ?></p>
<form enctype="application/x-www-form-urlencoded" method="post" action="<?php echo JRoute::_('index.php?option=com_extendedprofile&task=finance.paidMember'); ?>">
<div class="form-group">
    <label for="" class="control-label">Payment Type: </label>
<?php 
if($this->msg['currency'] == 'INR')
{
?>
    <input type="radio" name="pay_choice" id="pay_choice1" value="ccavenue" /> <i class="fa fa-credit-card"></i> Credit/Debit Card/Netbanking
    <input type="radio" name="pay_choice" id="pay_choice2" value="cheque" /> Cheque
    <input type="radio" name="pay_choice" id="pay_choice10" value="direct" /> Direct Transfer
    <input type="radio" name="pay_choice" id="pay_choice3" value="paytm" />  <img src="<?php echo JURi::base() ?>images/paytm.png" />
    <input type="radio" name="pay_choice" id="pay_choice5" value="bhim" /> <img src="<?php echo JURi::base() ?>images/bhim.png" />Bhim App
    <input type="radio" name="pay_choice" id="pay_choice6" value="phonepe" /> <img src="<?php echo JURi::base() ?>images/phonepe.png" />PhonePe
<?php
}
else
{
?>
    <input type="radio" name="pay_choice" id="pay_choice7" value="paypal" /> <i class="fa fa-paypal"></i> Paypal
    <input type="radio" name="pay_choice" id="pay_choice9" value="paypalme" /> <img src="<?php echo JURi::base() ?>images/paypal.png" /> PaypalMe
    <input type="radio" name="pay_choice" id="pay_choice8" value="directint" /> Direct Transfer
<?php
}
?>
</div>
<input type="hidden" name="pay_currency" id="pay_currency" value="<?php echo $this->msg['currency'] ?>" />
<input type="hidden" name ="pay_country" id="pay_country" value="<?php echo $this->msg['country_full']; ?>" />
<input type="hidden" name="pay_amount" id="pay_amount" value="<?php echo $this->msg['amount'] ?>" />
<div class="form-group">
    <button type="submit" name="pay_submit" class="btn btn-primary" >Pay Now</button>
    <button type="reset" name="cancel" class="btn btn-warning">Reset</button>
    <a href="<?php echo JURI::base() ?>dashboard" class="btn btn-danger">Cancel</a>
</div>
</form>

