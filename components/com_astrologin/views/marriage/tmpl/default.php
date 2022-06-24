<!--<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><i class="bi bi-exclamation-triangle-fill fs-1"></i> Orders Closed!</strong> Orders are temporarily closed. We apologize for the inconvenience caused.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
</div>-->
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$details                    = $this->msg;
//print_r($details);exit;
$fees                       = $details[0]['amount'];
$disc                       = $details[0]['disc_percent'];
$disc_fees                  = $fees - number_format((float)($fees*$disc)/100,2);
?>
<div class="progress" style="height:25px">
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Contents</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Details</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Question(s)</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Pay</div>
</div>
<div class="mb-3"></div>
<h3 class="text-center"><button class="btn btn-outline-primary" type="button" title='Click to get more info' data-bs-toggle='modal' data-bs-target='#astroinfo'><img src=<?php echo JURi::base() ?>images/profiles/<?php echo $details['img_new_name'] ?> height='50px' width='50px' title="<?php echo $details['img_name'];?>" /><?php echo $details['name'] ?></button></h3>
<div class='modal fade' id='astroinfo' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1'>
<div class='modal-dialog' role='document'>
<div class='modal-content'>
    <div class='modal-header'>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
    <div class='modal-body' id="modal_body">
    <?php echo $details['info']; ?>
    </div>
<div class='modal-footer'>
    <button type='button' class='btn btn-secondary btn-danger' data-bs-dismiss='modal'>Close</button></div>
</div></div></div><div class="mb-3"></div>
<div class='card border-dark mb-3' id="card-duration">
<div class='card-body'>
	<strong>Order Processing Time</strong>- Minimum 5-6 working days(Monday-Friday). You will be notified via email if 
	there is more delay likely. Max 30 days after which full refund provided.
</div></div>
<ul class="list-group">
	<li class="list-group-item list-group-item-dark"><strong>Marriage Report Contents</strong></li>
	<li class="list-group-item">Marriage House analysis with diagram of placements and aspects</li>
	<li class="list-group-item">12th house(house of intimacy) analysis with diagram of placement and aspects</li>
	<li class="list-group-item">Navamsha Chart(D-9) chart analysis with diagram</li>
	<li class="list-group-item">Mangal Dosha if any</li>
	<li class="list-group-item">Divorce Chances if any</li>
	<li class="list-group-item">Remedial Measures</li>
	<li class="list-group-item">Answer to your query</li>
	<li class="list-group-item list-group-item-dark">For married couples</li>
	<li class="list-group-item">5th house(house of progeny) for analysis of children with diagram of placements and aspects</li>
	<li class="list-group-item">Joint Finances</li>
	<li class="list-group-item">Marriage in various dasha periods</li>
	<li class="list-group-item list-group-item-dark">For singles</li>
	<li class="list-group-item">Love or Arranged Marriage</li>
	<li class="list-group-item">Likely Marriage Periods</li>
	<li class="list-group-item">Physical Features. Rough idea</li>
	<li class="list-group-item">Spouse Family Background. Likely nature of in-laws</li>
	<li class="list-group-item">Likely place of meeting. Rough idea</li>
	<li class="list-group-item">What attracts spouse towards you. Based on placement of Jupiter/Venus</li>
</ul>
<div class="mb-3"></div>
<form name="get_report" method="post" enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('?option=com_astrologin&task=astroreport.submitReport') ?>">
<div class="mb-3"></div>
<input type="hidden" name="select_report" id="select_report" value ="marriage" />
<input type="hidden" name="report_fees" id="report_fees" value="<?php echo $details[0]['amount'] ?>" />
<input type="hidden" name="report_curr_code" id="report_curr_code" value="<?php echo $details[0]['curr_code'] ?>" />
<input type="hidden" name="report_currency" id="report_currency" value="<?php echo $details[0]['currency']; ?>" />
<input type="hidden" name="report_curr_full" id="report_curr_full" value="<?php echo $details[0]['curr_full']; ?>" />
<input type="hidden" name="report_final_fees" id="report_final_fees" value="<?php echo $disc_fees; ?>" />
<div class="mb-3"></div>
<?php
    if($disc_fees == $fees)
    {
?>
<div class="form-control" id="fees_type"><label>Fees:</label> <div id='fees_id'><?php echo $details[0]['amount']." ".$details[0]['currency']."(".$details[0]['curr_full'].") only"; ?></div></div>
<?php
    }
    else
    {
?>
<div class="form-control" id="fees_type"><label>Fees:</label> <div id='fees_id'><?php echo "<s>".$details[0]['amount']." ".$details[0]['currency']."(".$details[0]['curr_full'].") only</s><br/>".$disc_fees."&nbsp;".$details[0]['currency']."(".$details[0]['curr_full'].") only" ?></div></div>

<?php
    }
?>
<div class="mb-3"></div>
<div class="form-control" id="pay_id">
    <label for='expert_choice' class='control-label'>Payment Type: </label>
    <div id="payment_type">
 <?php
if($details[0]['currency'] == 'INR' && $details['country_full'] == 'India')
{
?>
    <div class="form-check">
    <input class="form-check-input" type='radio' name='report_choice' id='report_choice1' value='razorpay'  />
    <label for="expert_choice1" class="form-check-label"><i class="bi bi-credit-card fs-3"></i> Credit/Debit Card</label>
    </div>
    <div class="form-check">
    <input class="form-check-input" type='radio' name='report_choice' id='report_choice4' value='paytm' checked />
    <label for="expert_choice4" class="form-check-label"><img src="<?php echo JURi::base() ?>images/paytm.png" title="Pay using Paytm" /></label>
    </div>
<?php       
}
else
{
?>
    <div class="form-check">
    <input class="form-check-input" type='radio' name='report_choice' id='report_choice7' value='paypal' checked />
    <label for="report_choice7" class="form-check-label"> <i class='fab fa-paypal'></i> Paypal</label>
    </div>
<?php
}
?>
</div>
</div>
<div class="mb-3"></div>
<div class="form-group" id="btn_grp">
	<button type="reset" name="ask_reset" id="ask_reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i> Reset</button>
    <button type="submit" name="report_submit" id="report_submit" class="btn btn-primary" >Next <i class="bi bi-arrow-right-short"></i></button>
</div>
</form>
<?php 
unset($details);unset($this->msg);
?>

