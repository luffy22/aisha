<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
//include_once "/home/astroxou/php/Net/GeoIP.php";
//$geoip                  = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoLiteCity.dat");
$ip                         = '117.196.1.11';
//$ip                         = '157.55.39.123';  // ip address
//$ip                       = $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server

$info                       = geoip_country_code_by_name($ip);
$country                    = geoip_country_name_by_name($ip);
//$location                 = $geoip->lookupLocation($ip);
//$info                     = $location->countryCode;
//$country                  = $location->countryName;
$details                    = $this->msg;
//print_r($details);exit;
?>
<div class='card card-outline-info text-center' id="info_expert">
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
<input type='hidden' name='expert_uname' id="expert_uname" value="<?php echo $details['username'] ?>" />
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
<div class="mb-2"></div>
<div class="form-group" id="order_type">
<?php
if($details['phone_or_report']=='phone')
{
?>
    <div class='form-control'><label for='phone_or_report'>Order Type: </label> <i class='fa fa-phone'></i><?php echo ucfirst($details['phone_or_report']) ?></div>
        <input type='hidden' name='expert_order_type' id='expert_order_type' value='phone' />";
<?php
}
else if($details['phone_or_report']=='report')
{
?>
<div class='form-control'><label for='phone_or_report'>Order Type: </label> <i class='fa fa-file-pdf-o'></i><?php echo ucfirst($details['phone_or_report']) ?></div>
<input type='hidden' name='expert_order_type' id='expert_order_type' value='report' />
<?php
}
else if($details['phone_or_report']=='both')
{
?>
<div class='form-control'><label>Order Type: </label>
<input type='radio' name='expert_order_type' id='expert_order_type' value='phone' /> <i class='fa fa-phone'></i> Phone
<input type='radio' name='expert_order_type' id='expert_order_type' value='report' checked /> <i class='fa fa-file-pdf-o'></i> Report
</div>
<?php
}
else 
{
?>
<div class='form-control'><label for='phone_or_report'>Order Type: </label> <i class='fa fa-file-pdf-o'></i> Report</div>
<input type='hidden' name='expert_order_type' id='expert_order_type' value='report' />
<?php   
}
?>
</div>
<input type="hidden" name="expert_fees" id="expert_fees" value="<?php echo $details['amount'] ?>" />
<input type="hidden" name="expert_curr_code" id="expert_curr_code" value="<?php echo $details['curr_code'] ?>" />
<input type="hidden" name="expert_currency" id="expert_currency" value="<?php echo $details['currency']; ?>" />
<input type="hidden" name="expert_curr_full" id="expert_curr_full" value="<?php echo $details['curr_full']; ?>" />
<input type="hidden" name="expert_final_fees" id="expert_final_fees" value="<?php echo $details['amount'] ?>" />
<div class="mb-2"></div>
<div class="form-control" id="fees_type"><label>Fees:</label> <div id='fees_id'><?php echo $details['amount']."&nbsp;".$details['curr_code']."(".$details['currency']."-".$details['curr_full'].")" ?></div></div>
<div class="mb-2"></div>
<div class="form-control" id="pay_id">
    <label for='expert_choice' class='control-label'>Payment Type: </label>
    <div id="payment_type">
 <?php
if($details['currency'] == 'INR')
{
?>
    <input type='radio' name='expert_choice' id='expert_choice1' value='ccavenue' checked /> <i class='fa fa-credit-card'></i> Credit/Debit Card/Netbanking
    <input type='radio' name='expert_choice' id='expert_choice2' value='cheque' /> Cheque
    <input type='radio' name='expert_choice' id='expert_choice3' value='direct' /> Direct Transfer
    <input type='radio' name='expert_choice' id='expert_choice4' value='paytm' />  <img src="<?php echo JURi::base() ?>images/paytm.png" />
    <input type='radio' name='expert_choice' id='expert_choice5' value='bhim' /> <img src="<?php echo JURi::base() ?>images/bhim.png" /> Bhim App
    <input type='radio' name='expert_choice' id='expert_choice6' value='phonepe' /> <img src="<?php echo JURi::base() ?>images/phonepe.png" /> PhonePe
<?php       
}
else
{
?>
    <input type='radio' name='expert_choice' id='expert_choice7' value='paypal' checked /> <i class='fa fa-paypal'></i> Paypal
    <input type='radio' name='expert_choice' id='expert_choice9' value='paypalme' /> <img src="<?php echo JURi::base() ?>images/paypal.png" /> PaypalMe
    <input type='radio' name='expert_choice' id='expert_choice8' value='directint' /> Direct Transfer
<?php
}
?>
    </div>
</div>

<div class="mb-2"></div>
<div class="form-group" id="btn_grp">
    <button type="submit" name="expert_submit" id="ask_submit" class="btn btn-primary" >Next <i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
    <button type="reset" name="ask_reset" id="ask_reset" class="btn btn-danger">Reset</button>
</div>
</form>

