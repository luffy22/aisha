<?php
defined('_JEXEC') or die();
$report_type            = $_GET['report'];
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
<form id="report_form" role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_astrologin&task=astroreport.fillDetails'); ?>">
<input type="hidden" name="report_type" value="<?php echo $report_type; ?>" />
<input type="hidden" name="report_fees" value="<?php echo $fees[0]; ?>" />
<input type="hidden" name="report_currency" value="<?php echo $fees[1]; ?>" />
<input type="hidden" name="report_pay_mode" value="<?php echo $pay_mode; ?>" />
<div class="form-group" id="report_grp_1">
    <label for="report_1">Name:</label>
    <input type="text" name="report_name" class="form-control" id="report_1" placeholder="Enter your full name" required />
</div>
<div class="form-group" id="report_grp_2">
    <label for="report_2">Email:</label>
    <input type="email" name="report_email" class="form-control" id="report_2" placeholder="Enter your email" required />
</div>
<div class="form-group" id="report_grp_3">
    <label for="report_gender">Gender:</label><br/>
    <input type="radio" name="report_gender" value="male" id="report_gender1" /> Male
    <input type="radio" name="report_gender" value="female" id="report_gender2" checked /> Female
</div>
<div class="form-group" id="report_grp_4">
    <label for="dob" >Date Of Birth:</label>
     <?php 
        if(isMobileDevice()){
            //Your content or code for mobile devices goes here
    ?>    
        <input type="date" name="report_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
        else
        {
    ?>
        <input type="date" id="report_dob" name="report_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
    ?>
    </div>
<div class="form-group">
    <label>Time Of Birth:</label><br/>
    <input type="time" name="report_time"  id="report_time" class="form-control" placeholder="Enter your Time of Birth"/>
</div>
<div class="form-group  ui-widget" id="report_grp_5">
    <label for="report_pob">Place Of Birth</label>
    <input type="text" id="report_pob" name="report_pob" class="form-control" placeholder="Enter full name of city/town, state, country" />
</div>
<div class="form-group">
    <button type="reset" class="btn btn-danger">Reset</button>
        <button class="btn btn-primary" type="submit">Submit Details
            </button>
        
</div>
</form>
<link rel="stylesheet" href="<?php echo JUri::base().'components'.DS.'com_astrologin'.DS.'script/jquery-ui.min.css' ?>" type="text/css" />
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_astrologin'.DS.'script/jquery-ui.min.js' ?>"></script>
<script>
$(function() {
$("#report_dob").datepicker({yearRange: "1900:2050",changeMonth: true,
  changeYear: true, dateFormat: "yy-mm-dd"});
});
$(function() 
{
   var result       = "";
   $("#report_pob").autocomplete({
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
</script>