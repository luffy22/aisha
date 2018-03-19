<?php
//print_r($this->msg);exit;
//echo "calls";exit;
defined('_JEXEC') or die('Restricted access');
//print_r($this->msg);exit;
$user       = JFactory::getUser();

   if(isset($_GET['terms'])&&($_GET['terms']=='no'))
    {
?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Kindly accept the Terms and Conditions if you wish to join as an Astrologer.</div>
<?php
    }

?>
<h1 class="display-3">Payment Details</h1>
<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Fields marked with asterix(*) are compulsory</div>
<div class="form-group"><label>Name:</label> <?php echo $user->name; ?></div>
<form enctype="application/x-www-form-urlencoded" method="post" action="<?php echo JRoute::_('index.php?option=com_extendedprofile&task=finance.saveDetails'); ?>">
<div class="form-group">
    <label for="astro_paid" class="control-label">Account Name:</label>
<?php
    if(empty($this->msg['acc_holder_name']))
    {
?>
    <input type ="text" placeholder="Provide Account Name" name="acc_bank" id="acc_bank" class="form-control" />
<?php
    }
    else
    {
?>
    <input type ="text" value="<?php echo $this->msg['acc_holder_name'] ?>" name="acc_bank" id="acc_bank" class="form-control" />
<?php
    }

?>
</div>
<div class="form-group">
    <label for="astro_paid" class="control-label">Account Number:</label>
<?php
    if(empty($this->msg['acc_number']))
    {
?>
    <input type ="number" placeholder="Provide Account Number" name="acc_number" id="acc_number" class="form-control" />
<?php
    }
    else
    {
?>
    <input type ="number" placeholder="Provide Account Number" value="<?php echo $this->msg['acc_number']; ?>" name="acc_number" id="acc_number" class="form-control" />
<?php
    }
?>
</div>
<div class="form-group">
    <label for="astro_paid" class="control-label">Bank Name:</label>
<?php
    if(empty($this->msg['acc_bank_name']))
    {
?>
    <input type ="text" placeholder="Provide Name Of Bank" name="acc_bank_name" id="acc_bank_name" class="form-control" />
<?php
    }
    else
    {
?>
    <input type ="text" placeholder="Provide Name Of Bank" value="<?php echo $this->msg['acc_bank_name']; ?>" name="acc_bank_name" id="acc_bank_name" class="form-control" />
<?php
    }
?>
</div>
<div class="form-group">
    <label for="astro_paid" class="control-label">Bank Address:</label>
<?php
    if(empty($this->msg['acc_bank_addr']))
    {
?>
    <textarea placeholder="Provide Bank Account Address" name="acc_bank_addr" id="acc_bank_addr" class="form-control"></textarea>
<?php
    }
    else
    {
?>
    <textarea placeholder="Provide Bank Account Address" name="acc_bank_addr" id="acc_bank_addr" class="form-control"><?php echo $this->msg['acc_bank_addr'] ?></textarea>
<?php
    }
?>
</div>
<div class="form-group">
    <label for="astro_paid" class="control-label">IBAN Number:</label>
<?php
    if(empty($this->msg['acc_iban']))
    {
?>   <input type ="text" placeholder="Provide IBAN(Internation Bank Account Number)" name="acc_iban" id="acc_iban" class="form-control" />
<?php
    }
    else
    {
?>
    <input type ="text" placeholder="Provide IBAN(Internation Bank Account Number)" value="<?php echo $this->msg['acc_iban'] ?>" name="acc_iban" id="acc_iban" class="form-control" />
<?php
    }
?>
</div>
<div class="form-group">
    <label for="astro_paid" class="control-label">Swift Code:</label>
<?php
    if(empty($this->msg['acc_swift_code']))
    {
?>
    <input type ="text" placeholder="Provide Account Swift Code" name="acc_swift" id="acc_swift" class="form-control" />
<?php
    }
    else
    {
?>
    <input type ="text" placeholder="Provide Account Swift Code" value="<?php echo $this->msg['acc_swift_code']; ?>" name="acc_swift" id="acc_swift" class="form-control" />
<?php
    }
?>
</div>
<div class="form-group">
    <label for="astro_paid" class="control-label">IFSC Code(Indian Banks Only):</label>
<?php
    if(empty($this->msg['acc_ifsc']))
    {
?>
    <input type ="text" placeholder="Provide IFSC Code" name="acc_ifsc" id="acc_ifsc" class="form-control" />
<?php
    }
    else
    {
?>
    <input type ="text" placeholder="Provide IFSC Code" value="<?php echo $this->msg['acc_ifsc'] ?>" name="acc_ifsc" id="acc_ifsc" class="form-control" />
<?php
    }
?>
</div>
<div class="form-group">
    <label for="astro_paid" class="control-label">Paypal Id/Email:</label>
<?php
    if(empty($this->msg['acc_paypalid']))
    {
?>
    <input type ="text" placeholder="Provide Paypal ID Or Email" name="acc_paypal" id="acc_paypal" class="form-control" />
<?php
    }
    else
    {
?>
    <input type ="text" value="<?php echo $this->msg['acc_paypalid']; ?>" placeholder="Provide Paypal ID Or Email" name="acc_paypal" id="acc_paypal" class="form-control" />
<?php
    }
?>
</div>
<div class="form-group">
        <button type="submit" name="bank_submit" class="btn btn-primary" >Submit</button>
        <button type="reset" name="cancel" class="btn btn-warning">Reset</button>
        <a href="<?php echo JURI::base() ?>dashboard" class="btn btn-danger">Cancel</a>
    </div>
</form>

