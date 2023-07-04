<?php
defined('_JEXEC') or die();
$uniq_id                = $_GET['uniq_id'];
$order_type             = $_GET['order_type'];
//echo $uniq_id."<br/>";
//echo $order_type;exit;
?>
<div class="progress" style="height:25px">
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Contents</div>
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Details</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Question</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Pay</div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Give Us More Details</div>
<p>Explain your problem in detail. This will help us understand your problem better as well as give a better advise and remedies.</p>
<form id="ques_form" role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_astrologin&task=astroreport.fillDetails2'); ?>">
<input type="hidden" name="order_id" id="order_id" value="<?php echo $uniq_id; ?>" />
<input type="hidden" name="order_type" id="order_type" value="<?php echo $order_type; ?>" />
<div class="mb-3"></div>
<div class="mb-3">
    <label for="query_about">What's your query related to?</label>
    <select name="query_about" id="query_about" class="form-select form-select-lg m-2">
		<option value="school">School</option>
        <option value="college">College Degree</option>
        <option value="masters">Masters/Post Grad</option>
        <option value="upsc">Competitive Exam</option>
        <option value="phd">Phd/Research</option>
        <option value="dropout">Incomplete Education</option>
        <option value="other">Other</option>
    </select>
</div><div class="mb-3"></div>
<div class="mb-3">
    <label for="query_explain">Explain in detail</label>
    <textarea name="query_explain" id="query_explain" rows="5" class="form-control"></textarea>
</div>
<div class="mb-3">
    <button type="reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i> Reset</button>
    <button class="btn btn-success" type="submit"><i class="bi bi-bank"></i> Pay Now</button>
</div>
</form>
<script src="https://cdn.tiny.cloud/1/rjxia1mcuetdoiri6l19shyroh2q8rjrz7hdwighah58zqgr/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
 <script>   
     tinymce.init({
    selector: '#query_explain',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
     toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
  </script>
