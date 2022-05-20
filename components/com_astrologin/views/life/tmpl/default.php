<!--<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><i class="fas fa-exclamation-circle"></i> Orders Closed!</strong> Orders are temporarily closed. We would begin taking orders from Friday 4th December 2020.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span></button></div>-->
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
<div class='card border-dark mb-3 text-center' id="info_expert">
<div class='card-block'>
<h3><a title='Click to get more info' href='#' data-toggle='modal' data-target='#astroinfo'><img src=<?php echo JURi::base() ?>images/profiles/<?php echo $details['img_new_name'] ?> height='50px' width='50px' title="<?php echo $details['img_name'];?>" /><?php echo $details['name'] ?></a></h3>
<div class='modal fade' id='astroinfo' tabindex='-1' role='dialog' aria-hidden='true' aria-labelledby='astrolabel'>
<div class='modal-dialog' role='document'>
<div class='modal-content'>
    <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>
    <div class='modal-body' id="modal_body">
    <?php echo $details['info']; ?>
    </div>
<div class='modal-footer'>
    <button type='button' class='btn btn-secondary btn-danger' data-dismiss='modal'>Close</button></div>
</div></div></div>
</div></div>
<div class='card border-dark mb-3' id="card-duration">
<div class='card-body'>
	<strong>Order Processing Time</strong>- Minimum 18-20 working days(Monday-Friday). You will be notified via email if 
	there is more delay likely. Max 50 days after which full refund provided.
</div></div>
<ul class="list-group">
	<li class="list-group-item list-group-item-dark"><strong>Life Report Contents</strong></li>
	<li class="list-group-item">Main Chart, Moon Chart and Navamsha Chart Short Analysis</li>
	<li class="list-group-item">Panchang</li>
	<li class="list-group-item">9 planets analysis with diagram of placements and aspects</li>
	<li class="list-group-item">12 houses analysis with diagram of placements and aspects</li>
    <li class="list-group-item">Analysis of Vimshottari Dasha. More of upcoming dashas.</li>
	<li class="list-group-item">Astro Yogas. Analysis of main yogas formed in horoscope</li>
    <li class="list-group-item">Basic Forecast related to education, career, marriage, health, finance and children</li>
	<li class="list-group-item">Analysis of Sade-Sati's and its phases.</li>
    <li class="list-group-item">Answer to 3 queries. 1st related to career, 2nd related to marriage and 3rd any personal query you have</li>
</ul>
<div class="mb-3"></div>
<form name="get_report" method="post" enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('?option=com_astrologin&task=astroreport.submitReport') ?>">
<div class="mb-3"></div>
<input type="hidden" name="select_report" id="select_report" value ="life" />
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
    <label for="expert_choice1" class="form-check-label"><i class='fa fa-credit-card'></i> Credit/Debit Card</label>
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

