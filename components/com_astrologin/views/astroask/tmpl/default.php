<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$details                    = $this->msg;
//print_r($details);exit;
?>
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
<form name="ask_expert" method="post" enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('?option=com_astrologin&task=astroask.askExpert') ?>">
<input type="hidden" name="expert_uname" id="expert_uname" value="<?php echo $details['username'] ?>" /><div class="mb-2"></div>
<div class='form-control'>
<label for="ques_type">Answer Type:</label>
<input type="radio" name="ques_type" id="ques_type1" value="long_ans" onchange="javascript:changefees2();" checked /> Detailed Report&nbsp;&nbsp;&nbsp;
<input type="radio" name="ques_type" id="ques_type2" value="short_ans" onchange="javascript:changefees2();" /> Short Answer
</div><div class="mb-3"></div>
<div class="form-control" id="choose_ques">
<label for="select_expert">Choose Number Of Questions</label>
<select class="form-control" name="expert_max_ques" id="select_ques" onchange="javascript:changefees2();">
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
<input type="hidden" name="ques_long_fees" id="long_ans_fees" value="<?php echo $details[0]["amount"] ?>" />
<input type="hidden" name="ques_short_fees" id="short_ans_fees" value="<?php echo $details[1]['amount'] ?>" />
<input type="hidden" name="expert_fees" id="expert_fees" value="<?php echo $details[0]['amount'] ?>" />
<input type="hidden" name="expert_curr_code" id="expert_curr_code" value="<?php echo $details[0]['curr_code'] ?>" />
<input type="hidden" name="expert_currency" id="expert_currency" value="<?php echo $details[0]['currency']; ?>" />
<input type="hidden" name="expert_curr_full" id="expert_curr_full" value="<?php echo $details[0]['curr_full']; ?>" />
<input type="hidden" name="expert_final_fees" id="expert_final_fees" value="<?php echo $details[0]['amount'] ?>" />
<div class="mb-3"></div>
<div class="form-control" id="fees_type"><label>Fees:</label> <div id='fees_id'><?php echo $details[0]['amount']."&nbsp;".$details[0]['curr_code']."(".$details[0]['currency']."-".$details[0]['curr_full'].")" ?></div></div>
<div class="mb-3"></div>
<div class="form-control" id="pay_id">
    <label for='expert_choice' class='control-label'>Payment Type: </label>
    <div id="payment_type">
 <?php
if($details[0]['currency'] == 'INR')
{
?>
    <input type='radio' name='expert_choice' id='expert_choice1' value='ccavenue'  /> <i class='fa fa-credit-card'></i> Credit/Debit Card
    <input type='radio' name='expert_choice' id='expert_choice4' value='paytm' checked /> Internet Banking/<img src="<?php echo JURi::base() ?>images/bhim.png" title="Pay using UPI Payments" />BHIM /<img src="<?php echo JURi::base() ?>images/paytm.png" title="Pay using Paytm" />
<?php       
}
else
{
?>
    <input type='radio' name='expert_choice' id='expert_choice7' value='paypal' checked /> <i class='fab fa-paypal'></i> Paypal
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

