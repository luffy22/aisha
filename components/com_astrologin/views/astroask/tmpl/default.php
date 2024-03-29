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
<h3><button type="button" title='Click to get more info' data-bs-toggle='modal' data-bs-target='#astroinfo'><img src=<?php echo JURi::base() ?>images/profiles/<?php echo $details['img_new_name'] ?> height='50px' width='50px' title="<?php echo $details['img_name'];?>" /><?php echo $details['name'] ?></button></h3>
<div class='modal fade' id='astroinfo' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1'>
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
<div class="form-check">
<input class="form-check-input" type="radio" name="ques_type" id="ques_type1" value="long_ans" onchange="javascript:changefees2();" checked />
<label class="form-check-label" for="ques_type1">Detailed Report</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="ques_type" id="ques_type2" value="short_ans" onchange="javascript:changefees2();" />
<label class="form-check-label" for="ques_type2">Short Answer</label>
</div>
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
<input type="hidden" name="ques_long_fees" id="long_ans_fees" value="<?php echo $details[0]["amount"] ?>" />
<input type="hidden" name="ques_short_fees" id="short_ans_fees" value="<?php echo $details[1]['amount'] ?>" />
<input type="hidden" name="ques_long_disc" id="long_ans_disc" value="<?php echo $details[0]['disc_percent']; ?>" />
<input type="hidden" name="ques_short_disc" id="short_ans_disc" value="<?php echo $details[1]['disc_percent']; ?>" />
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
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice1' value='razorpay' checked />
    <label for="expert_choice1" class="form-check-label"><i class='fa fa-credit-card'></i> Credit/Debit Card</label>
    </div>
    <div class="form-check">
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice4' value='paytm' />
    <label for="expert_choice4" class="form-check-label"><img src="<?php echo JURi::base() ?>images/paytm.png" title="Pay using Paytm" /></label>
    </div>
<?php       
}
else
{
?>
    <div class="form-group">
      <select id="inputState" name="expert_choice" id="expert_choice7" class="form-control">
        <option value="paypal" selected>Paypal</option>
        <option value="BTC">Bitcoin</option>
        <option value="ETH">Ethereum</option>
        <option value="DOGE">Dogecoin</option>
        <option value="XRP">Ripple</option>
        <option value="USDT">Tether</option>
        <option value="ADA">Cardano</option>
        <option value="LTC">Litecoin</option>
        <option value="XMR">Monero</option>
        <option value="DOT">Polkadot</option>
        <option value="UNI">Uniswap</option>
        <option value="XLM">Stellar</option>
        <option value="TRX">Tron</option>
        <option value="DASH">Dash</option>
        <option value="DGB">DigiByte</option>
        <option value="BCH">Bitcoin Cash</option>
        <option value="ETC">Ethereum Classic</option>
      </select>
    </div>
    <!--<div class="form-check form-check-inline">
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice7' value='paypal' checked />
    <label for="expert_choice7" class="form-check-label"> <i class='fab fa-paypal'></i> Paypal</label>
    </div>
    <div class="form-check form-check-inline">
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice8' value='bitcoin' />
    <label for="expert_choice7" class="form-check-label"> <i class="fab fa-bitcoin"></i> Bitcoin(BTC)</label>
    </div>
    <div class="form-check form-check-inline">
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice9' value='ethereum' />
    <label for="expert_choice7" class="form-check-label"> <i class="fab fa-ethereum"></i> Ethereum(ETH)</label>
    </div>
    <div class="form-check form-check-inline">
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice9' value='doge' />
    <label for="expert_choice7" class="form-check-label"> Ripple(XRP)</label>
    </div>
    <div class="form-check form-check-inline">
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice9' value='doge' />
    <label for="expert_choice7" class="form-check-label"> Ripple(XRP)</label>
    </div>
    <div class="form-check form-check-inline">
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice9' value='tether' />
    <label for="expert_choice7" class="form-check-label"> Tether(USDT)</label>
    </div>
    <div class="form-check form-check-inlin">
    <input class="form-check-input" type='radio' name='expert_choice' id='expert_choice9' value='cardano' />
    <label for="expert_choice7" class="form-check-label"> Cardano(ADA)</label>
    </div>-->
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

    var long_ans            = document.getElementById("long_ans_fees").value;
    var short_ans           = document.getElementById("short_ans_fees").value;
    var disc_long           = document.getElementById("long_ans_disc").value;
    var disc_short          = document.getElementById("short_ans_disc").value;
    
    if(document.getElementById("ques_type1").checked)
    {
        var fees            = long_ans;
        var disc            = parseFloat((long_ans*disc_long)/100).toFixed(2);
        var disc_fees       = long_ans - disc;
    }
    else if(document.getElementById("ques_type2").checked)
    {
        var fees            = short_ans;
        var disc            = parseFloat((short_ans*disc_short)/100).toFixed(2);
        var disc_fees       = short_ans - disc;
    }
    else
    {
        var fees        = document.getElementById("expert_fees").value;
    }
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
