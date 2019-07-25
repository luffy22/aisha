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
<div class="lead alert alert-dark">Anything else you wish to ask?</div>
<p>&nbsp;&nbsp;&nbsp;&nbsp;If you wish to know if transit is favorable or not. Example for getting married or 
for finding a job.</p>
<form id="ques_form" role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_astrologin&task=transitreport.fillDetails2'); ?>">
<input type="hidden" name="order_id" id="order_id" value="<?php echo $uniq_id; ?>" />
<input type="hidden" name="order_type" id="order_type" value="<?php echo $order_type; ?>" />
<div class="mb-3"></div>
<div class="form-group">
    <label for="query_about">Subject?</label>
    <select name="query_about" id="query_about" class="form-control">
        <option value="marriage">Marriage</option>
        <option value="divorce">Divorce</option>
        <option value="career">Career</option>
        <option value="education">Education</option>
        <option value="finance">Finance</option>
        <option value="other">Other</option>
    </select>
</div><div class="mb-3"></div>
<div class="form-group">
    <label for="query_explain">Explain in detail</label>
    <textarea name="query_explain" id="query_explain" rows="10" class="form-control"></textarea>
</div>
<div class="form-group">
    <button type="reset" class="btn btn-danger">Reset</button>
    <button class="btn btn-success" type="submit">Pay Now</button>
</div>
</form>
<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
 <script>
   tinymce.init({
    selector: '#query_explain',
    plugins: "wordcount autolink",
    menubar: true
  });
  </script>
