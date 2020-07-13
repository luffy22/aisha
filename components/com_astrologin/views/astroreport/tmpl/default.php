<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$details                    = $this->msg;
//print_r($details);exit;
$fees                       = $details[1]['amount'];
$disc                       = $details[1]['disc_percent'];
$disc_fees                  = $fees - number_format((float)($fees*$disc)/100,2);
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
<form name="get_report" method="post" enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('?option=com_astrologin&task=astroreport.submitReport') ?>">
<div class="form-control" id="choose_ques">
<label for="select_expert">Choose Report Type</label>
<select class="form-control" name="select_report" id="select_report" onchange="javascript:changefees3();">
    <option value='yearly'>Yearly Report</option>
    <option value='life'>Life Report</option>
    <option value='career'>Career Report</option>
    <option value='marriage'>Marriage Report</option>
    <option value='finance'>Finance Report</option>
</select>
</div>
<div class="mb-3"></div>
<input type="hidden" name="yearly_fees" id="yearly_fees" value="<?php echo $details[1]["amount"] ?>" />
<input type="hidden" name="life_fees" id="life_fees" value="<?php echo $details[0]['amount'] ?>" />
<input type="hidden" name="career_fees" id="career_fees" value="<?php echo $details[2]['amount'] ?>" />
<input type="hidden" name="marriage_fees" id="marriage_fees" value="<?php echo $details[3]['amount'] ?>" />
<input type="hidden" name="finance_fees" id="finance_fees" value="<?php echo $details[4]['amount'] ?>" />
<input type="hidden" name="yearly_disc" id="yearly_disc" value="<?php echo $details[1]["disc_percent"] ?>" />
<input type="hidden" name="life_disc" id="life_disc" value="<?php echo $details[0]['disc_percent'] ?>" />
<input type="hidden" name="career_disc" id="career_disc" value="<?php echo $details[2]['disc_percent'] ?>" />
<input type="hidden" name="marriage_disc" id="marriage_disc" value="<?php echo $details[3]['disc_percent'] ?>" />
<input type="hidden" name="finance_disc" id="finance_disc" value="<?php echo $details[4]['disc_percent'] ?>" />
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
<div class="form-control" id="fees_type"><label>Fees:</label> <div id='fees_id'><?php echo $details[1]['amount']."&nbsp;".$details[1]['currency']." only" ?></div></div>
<?php
    }
    else
    {
?>
<div class="form-control" id="fees_type"><label>Fees:</label> <div id='fees_id'><?php echo "<s>".$details[1]["amount"]."&nbsp;".$details[1]['currency']."</s><br/>".$disc_fees."&nbsp;".$details[1]['currency']." only" ?></div></div>

<?php
    }
?>
<div class="mb-3"></div>
<div class="form-control" id="pay_id">
    <label for='expert_choice' class='control-label'>Payment Type: </label>
    <div id="payment_type">
 <?php
if($details[0]['currency'] == 'INR')
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
    <button type="submit" name="report_submit" id="report_submit" class="btn btn-primary" >Next <i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
    <button type="reset" name="ask_reset" id="ask_reset" class="btn btn-danger">Reset</button>
</div>
</form>
<?php 
unset($details);unset($this->msg);
?>
<script>
function changefees3()
{
    var yearly_fees     = document.getElementById("yearly_fees").value;
    var life_fees       = document.getElementById("life_fees").value;
    var career_fees     = document.getElementById("career_fees").value;
    var marriage_fees   = document.getElementById("marriage_fees").value;
    var finance_fees    = document.getElementById("finance_fees").value;
    var yearly_disc     = document.getElementById("yearly_disc").value;
    var life_disc       = document.getElementById("life_disc").value;
    var career_disc     = document.getElementById("career_disc").value;
    var marriage_disc   = document.getElementById("marriage_disc").value;
    var finance_disc    = document.getElementById("finance_disc").value;
    if(document.getElementById("select_report").value == "yearly")
    {
        var fees            = yearly_fees;
        var disc            = parseFloat((yearly_fees*yearly_disc)/100).toFixed(2);
        var disc_fees       = yearly_fees - disc;
    }
    else if(document.getElementById("select_report").value == "life")
    {
        var fees            = life_fees;
        var disc            = parseFloat((life_fees*life_disc)/100).toFixed(2);
        var disc_fees       = life_fees - disc;
    }
    else if(document.getElementById("select_report").value == "career")
    {
        var fees            = career_fees;
        var disc            = parseFloat((career_fees*career_disc)/100).toFixed(2);
        var disc_fees       = career_fees - disc;
    }
    else if(document.getElementById("select_report").value == "finance")
    {
        var fees            = finance_fees;
        var disc            = parseFloat((finance_fees*finance_disc)/100).toFixed(2);
        var disc_fees       = finance_fees - disc;
    }
    else if(document.getElementById("select_report").value == "marriage")
    {
        var fees            = marriage_fees;
        var disc            = parseFloat((marriage_fees*marriage_disc)/100).toFixed(2);
        var disc_fees       = marriage_fees - disc;
    }
    else
    {
        var fees            = document.getElementById("report_fees").value;
        var disc            = parseFloat((report_fees*yearly_disc)/100).toFixed(2);
        var disc_fees       = fees - disc;
    }
    var curr_code       = document.getElementById("report_curr_code").value;
    var currency        = document.getElementById("report_currency").value;
    var curr_full       = document.getElementById("report_curr_full").value;
    if(fees == disc_fees)
    {
        document.getElementById("fees_id").innerHTML    = fees+"&nbsp;"+currency+" only"
        document.getElementById("report_final_fees").value    = fees;
    }
    else
    {
        document.getElementById("fees_id").innerHTML    = "<s>"+fees+"&nbsp;"+currency+"</s><br/>"+
                disc_fees+"&nbsp;"+currency+" only"
        document.getElementById("report_final_fees").value    = disc_fees;
    }
    
}
</script>
