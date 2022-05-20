<?php
defined('_JEXEC') or die();
$uname                  = $_GET['uname'];
$ques                   = $_GET['ques'];
$ques_type              = $_GET['type'];
$fees                   = explode("_",$_GET['fees']);
$pay_mode               = $_GET['pay_mode'];
function isMobileDevice() {
    return preg_match("/(android|iPhone|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
?>
<div class="progress" style="height:25px">
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Choose</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Details</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Question(s)</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Pay</div>
</div>
<div class="mb-3"></div>
<h3>Enter Your Details</h3>
<form id="ques_form" role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_astrologin&task=astroask.askQuestions'); ?>">
<input type="hidden" name="ques_expert" value="<?php echo $uname; ?>" />
<input type="hidden" name="ques_no" value="<?php echo $ques; ?>" />
<input type="hidden" name="ques_type" value="<?php echo $ques_type; ?>" />
<input type="hidden" name="ques_fees" value="<?php echo $fees[0]; ?>" />
<input type="hidden" name="ques_currency" value="<?php echo $fees[1]; ?>" />
<input type="hidden" name="ques_pay_mode" value="<?php echo $pay_mode; ?>" />
<div class="mb-3" id="ques_grp_1">
    <label for="ques_1" class="form-label">Name:</label>
    <input type="text" name="ques_name" class="form-control" id="ques_1" placeholder="Enter your full name" required />
</div>
<div class="mb-3" id="ques_grp_2">
    <label for="ques_2" class="form-label">Email:</label>
    <input type="email" name="ques_email" class="form-control" id="ques_2" placeholder="Enter your email" required />
</div>
<div class="mb-3" id="ques_grp_3">
    <label for="inputChart" class="form-label">Gender:</label>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="ques_gender" id="ques_gender1" value="male">
	  <label class="form-check-label" for="inlineRadio1">Male</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="ques_gender" id="ques_gender2" value="female" checked>
	  <label class="form-check-label" for="inlineRadio2">Female</label>
	</div>
</div>
<div class="mb-3" id="ques_grp_4">
    <label for="dob" class="form-label">Date Of Birth:</label>
     <?php 
        if(isMobileDevice()){
            //Your content or code for mobile devices goes here
    ?>    
        <input type="date" name="ques_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
        else
        {
    ?>
        <input type="date" id="ques_dob" name="ques_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
    ?>
</div>
<div class="mb-3">
    <label class="form-label">Time Of Birth:</label><br/>
    <input type="time" name="ques_time"  id="ques_time" class="form-control" placeholder="Enter your Time of Birth"/>
</div>
<div class="mb-3  ui-widget" id="ques_grp_5">
    <label for="ques_pob" class="form-label">Place Of Birth</label>
    <input type="text" id="ques_pob" name="ques_pob" class="form-control" placeholder="Enter full name of city/town, state, country" />
</div>
<div class="btn btn-group btn-group-lg">
   <button type="reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i> Reset</button>
        <button class="btn btn-primary" type="submit">Submit Details</button>
</div>

</form>
<link rel="stylesheet" href="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.css' ?>" type="text/css" />
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.js' ?>"></script>
<script>
$(function() {
$("#ques_dob").datepicker({yearRange: "1900:2050",changeMonth: true,
  changeYear: true, dateFormat: "yy-mm-dd"});
});
$(function() 
{
    var result       = "";
   $("#ques_pob").autocomplete({
      source: 
       function(request, response) {
        $.ajax({
          url: "ajaxcalls/autocomplete.php",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
          response(data);
          
          }
        
        });
      },
      minLength: 3,
     
      open: function() {
        $('#ques_pob').removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         $(".ui-autocomplete").css("z-index", 1000);
      },
      close: function() {
        $('#ques_pob').removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
   })
   
});
function changefees()
{
    var long_ans        = document.getElementById("long_ans_fees").value;
    var short_ans        = document.getElementById("short_ans_fees").value;
    if(document.getElementById("ques_type1").checked)
    {
        var fees        = long_ans;
    }
    else if(document.getElementById("ques_type2").checked)
    {
        var fees        = short_ans;
    }
    else
    {
        var fees        = document.getElementById("expert_fees").value;
    }
    var no_of_ques      = document.getElementById("max_ques").value;
    var curr_code       = document.getElementById("expert_curr_code").value;
    var currency        = document.getElementById("expert_currency").value;
    var curr_full       = document.getElementById("expert_curr_full").value;
    var new_fees        = parseFloat(fees)*parseFloat(no_of_ques);
    document.getElementById("fees_id").innerHTML    = new_fees+"<html>&nbsp;</html>"+curr_code+"("+currency+"-"+curr_full+")"
    document.getElementById("expert_final_fees").value    = new_fees.toFixed(2);
}
</script>