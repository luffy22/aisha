<?php
defined('_JEXEC') or die();
$uniq_id                = $_GET['uniq_id'];
$order_type             = $_GET['order_type'];
//echo $uniq_id."<br/>";
//echo $order_type;exit;
?>
<div class="lead alert alert-dark">Anything else you wish to ask?</div>
<form id="ques_form" role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_astrologin&task=astroreport.fillDetails2'); ?>">
<input type="hidden" name="order_id" id="order_id" value="<?php echo $uniq_id; ?>" />
<input type="hidden" name="order_type" id="order_type" value="<?php echo $order_type; ?>" />
<div class="mb-3"></div>
<div class="form-group">
    <label for="query_about">What's the query about?:</label>
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
    <label for="query_explain">Explain properly:</label>
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
