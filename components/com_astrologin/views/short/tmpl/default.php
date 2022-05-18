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
$disc                       = number_format((float)($fees*$details[0]['disc_percent'])/100,2);
$disc_fees                  = $fees-$disc;
?>
<div class="progress" style="height:25px">
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Choose</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Details</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Question(s)</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Pay</div>
</div>
<div class="mb-3"></div>
<div class='card border-primary mb-3 text-center' id="info_expert">
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
	<strong>Order Processing Time</strong>- Minimum 3-5 working days(Monday-Friday). You will be notified via email if 
	there is more delay likely. Max 30 days after which full refund provided.
</div></div>
<form name="ask_expert" method="post" enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('?option=com_astrologin&task=astroask.askExpert') ?>">
<input type="hidden" name="expert_uname" id="expert_uname" value="<?php echo $details['username'] ?>" /><div class="mb-2"></div>
<div class="card">
	<div class="card-body">Short answer to your question(s). Explanation not more than 100 words. Maximum 3 allowed.</div>
</div><div class="mb-3"></div>
<div class="form-control" id="choose_ques">
<label for="select_expert">Choose Number Of Questions</label>
<select class="form-select" name="expert_max_ques" id="select_ques" onchange="javascript:changefees2();">
<?php
    for($i=1;$i<=$details['max_no_ques'];$i++)
    {
?>
    <option value='<?php echo $i ?>'><?php echo $i; ?></option>
<?php
    }
?>
</select>
</div>
<div class="mb-3"></div>
<input type="hidden" name="ques_type" id="ques_type" value="short_ans" />
<input type="hidden" name="ques_short_fees" id="short_ans_fees" value="<?php echo $details[0]['amount'] ?>" />
<input type="hidden" name="ques_short_disc" id="short_ans_disc" value="<?php echo $details[0]['disc_percent']; ?>" />
<input type="hidden" name="expert_fees" id="expert_fees" value="<?php echo $details[0]['amount'] ?>" />
<input type="hidden" name="expert_curr_code" id="expert_curr_code" value="<?php echo $details[0]['curr_code'] ?>" />
<input type="hidden" name="expert_currency" id="expert_currency" value="<?php echo $details[0]['currency']; ?>" />
<input type="hidden" name="expert_curr_full" id="expert_curr_full" value="<?php echo $details[0]['curr_full']; ?>" />
<input type="hidden" name="expert_final_fees" id="expert_final_fees" value="<?php echo $disc_fees; ?>" />
<div class="mb-3"></div>
<?php
    if($disc_fees == $fees)
    {
?>
<div class="form-control" id="fees_type"><label>Fees:</label> <div id='fees_id'><?php echo $details[0]["amount"]."&nbsp;".$details[0]['currency']."(".$details[0]['curr_full'].") only"; ?></div></div>

<?php
    }
    else
    {
?>
<div class="form-control" id="fees_type"><label>Fees:</label> <div id='fees_id'><?php echo "<s>".$details[0]["amount"]."&nbsp;".$details[0]['currency']."</s><br/>".$disc_fees."&nbsp;".$details[0]['currency']." only" ?></div></div>

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
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice1' value='razorpay' />
    <label for="expert_choice1" class="form-check-label"><i class='fa fa-credit-card'></i> Credit/Debit Card</label>
    </div>
    <div class="form-check">
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice4' value='paytm' checked />
    <label for="expert_choice4" class="form-check-label"><img src="<?php echo JURi::base() ?>images/paytm.png" title="Pay using Paytm" /></label>
    </div>
<?php       
}
else
{
?>
    <div class="form-check">
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice7' value='paypal' checked />
    <label for="expert_choice7" class="form-check-label"> <i class='fab fa-paypal'></i> Paypal</label>
    </div>
<?php
}
?>
    </div>
</div>
<div class="mb-3"></div>
<div class="form-group" id="btn_grp">
   <button type="submit" name="expert_submit" id="ask_submit" class="btn btn-primary" >Next <i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
    <button type="reset" name="ask_reset" id="ask_reset" class="btn btn-danger">Reset</button>
</div>
</form>
<?php 
unset($details);unset($this->msg);
?>
<script>
function changefees2()
{

	var short_ans           = document.getElementById("short_ans_fees").value;
    var disc_short          = document.getElementById("short_ans_disc").value;
      
	var fees            = short_ans;
	var disc            = parseFloat((short_ans*disc_short)/100).toFixed(2);
	var disc_fees       = short_ans - disc;
    
    var no_of_ques      = document.getElementById("select_ques").value;
    var curr_code       = document.getElementById("expert_currency").value;
    var curr_full		= document.getElementById("expert_curr_full").value;
    if(fees == disc_fees)
    {
        var new_fees        = parseFloat(fees)*parseFloat(no_of_ques);
        document.getElementById("fees_id").innerHTML    = new_fees+"&nbsp;"+curr_code+"("+curr_full+") only"
        document.getElementById("expert_final_fees").value    = new_fees.toFixed(2);
    }
    else
    {
        var fees            = parseFloat(fees)*parseFloat(no_of_ques);
        var new_fees        = parseFloat(disc_fees)*parseFloat(no_of_ques);
        document.getElementById("fees_id").innerHTML    = "<s>"+fees+"&nbsp;"+curr_code+"("+curr_full+")"+"</s>"+"<br/>"+new_fees+"&nbsp;"+curr_code+"("+curr_full+") only"
        document.getElementById("expert_final_fees").value    = new_fees.toFixed(2);
    }
}    
</script>
