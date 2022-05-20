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
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Question(s)</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Pay</div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Give Us More Details</div>
<p>Explain your problems in detail. This will help us understand them better as well as give a better advise and remedies.</p>
<form id="ques_form" role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_astrologin&task=astroreport.fillDetails3'); ?>">
<input type="hidden" name="order_id" id="order_id" value="<?php echo $uniq_id; ?>" />
<input type="hidden" name="order_type" id="order_type" value="<?php echo $order_type; ?>" />
<div class="mb-3"></div>
<div class="lead alert alert-dark">Career</div>
<div class="mb-3">
    <label for="query_career_about">Where are you employed?</label>
    <select name="query_career_about" id="query_career_about" class="form-select">
        <option value="unemployed">Unemployed</option>
        <option value="private">Private Sector</option>
        <option value="govt">Government Sector</option>
        <option value="business">Individual Business</option>
        <option value="partnership">Partnership Business</option>
        <option value="other">Other</option>
    </select>
</div><div class="mb-3"></div>
<div class="mb-3">
    <label for="query_career">Your Problem/What you wish to know?:</label>
    <textarea name="query_career" id="query_career" rows="5" class="form-control"></textarea>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Marriage</div>
<div class="mb-3">
    <label for="query_marriage_about">Status</label>
    <select name="query_marriage_about" id="query_marriage_about" class="form-select">
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
<div class="mb-3">
    <label for="query_marraige">Your Problem/What you wish to know?:</label>
    <textarea name="query_marriage" id="query_marriage" rows="5" class="form-control"></textarea>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Anything else you wish to know</div>
<div class="mb-3"></div>
<div class="mb-3">
    <label for="query_other_about">Your Problem/What you wish to know?:</label>
    <select name="query_other_about" id="query_other_about" class="form-select">
        <option value="education">Education</option>
        <option value="finance">Finance</option>
        <option value="health">Health</option>
        <option value="other">Other</option>
    </select>
</div><div class="mb-3"></div>
<div class="mb-3">
    <label for="query_other">What you wish to do/know?</label>
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
    selector: '#query_career, #query_marriage, #query_explain',
    plugins: "wordcount autolink",
    menubar: true
  });
  </script>
