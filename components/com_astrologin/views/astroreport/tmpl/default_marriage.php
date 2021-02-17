<?php
defined('_JEXEC') or die();
$uniq_id                = $_GET['uniq_id'];
$order_type             = $_GET['order_type'];
//echo $uniq_id."<br/>";
//echo $order_type;exit;
?>
<div class="progress" style="height:25px">
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Choose</div>
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Details</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Question(s)</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Pay</div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Kindly share your details</div>
<p>&nbsp;&nbsp;&nbsp;&nbsp;Filling these details would allow us to know more about problems you face. 
 Also it means we don't have to do guess work and can focus on solving your issues better.</p>
<form id="ques_form" role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_astrologin&task=astroreport.fillDetails2'); ?>">
<input type="hidden" name="order_id" id="order_id" value="<?php echo $uniq_id; ?>" />
<input type="hidden" name="order_type" id="order_type" value="<?php echo $order_type; ?>" />
<div class="mb-3"></div>
<div class="form-group">
    <label for="query_about">Status</label>
    <select name="query_about" id="query_about" class="form-control">
        <option value="unmarried">Unmarried</option>
        <option value="married">Married</option>
        <option value="gay">Gay/Lesbian</option>
        <option value="divorce">Divorcee</option>
        <option value="multiple_divorces">Multiple Divorcee</option>
        <option value="widower">Widower</option>
        <option value="other">Other</option>
    </select>
</div><div class="mb-3"></div>
<p></p>
<div class="form-group">
    <label for="query_explain">Please explain in detail</label>
    <textarea name="query_explain" id="query_explain" rows="10" class="form-control"></textarea>
</div>
<div class="form-group">
    <button type="reset" class="btn btn-danger">Reset</button>
    <button class="btn btn-success" type="submit">Pay Now</button>
</div>
</form>
<script src="https://cdn.tiny.cloud/1/rjxia1mcuetdoiri6l19shyroh2q8rjrz7hdwighah58zqgr/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
 <script>
   tinymce.init({
    selector: '#query_explain',
    plugins: "wordcount autolink",
    menubar: true
  });
  </script>
