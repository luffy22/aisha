<?php
defined('_JEXEC') or die();
$uniq_id                = $_GET['uniq_id'];
$no_of_ques             = $_GET['no_of_ques'];
//echo $no_of_ques;exit;
//print_r($this->data);exit;
?>
<div class="progress" style="height:25px">
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Choose</div>
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Details</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Question(s)</div>
  <div class="progress-bar" style="width:25%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Pay</div>
</div>
<div class="mb-3"></div>
<h3>Enter Your Questions</h3>
<form id="ques_form" role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_astrologin&task=astroask.askQuestions2'); ?>">
<input type="hidden" name="ques_id" id="ques_id" value="<?php echo $uniq_id; ?>" />
<input type="hidden" name="ques_no" id="ques_no" value="<?php echo $no_of_ques; ?>" />
<div class="mb-2"></div>
<?php
for($i=0;$i<$no_of_ques;$i++)
 {
?>
<h3>Question <?php echo $i+1; ?></h3>
<div>
<div class="form-group">
    <label>Choose Subject:</label><br/>
    <select name="ques_select_<?php echo $i+1; ?>" class="form-control">
        <option value="marriage">Marriage</option>
        <option value="divorce">Divorce</option>
        <option value="career">Career</option>
        <option value="education">Education</option>
        <option value="finance">Finance</option>
        <option value="other">Other</option>
    </select>
</div>
<div class="form-group">
    <label for="ques_<?php echo $i+1; ?>">Question <?php echo $i+1; ?></label>
    <input type="text" name="ques_<?php echo $i+1;  ?>" id ="ques_<?php echo $i+1; ?>" class="form-control" placeholder="Enter Your Question" required />
    
</div>
<div class="form-group">
    <label for="ques_details_<?php echo $i+1; ?>">Kindly Share Some Details:</label>
    <textarea name="ques_details_<?php echo $i+1; ?>" id="ques_details_<?php echo $i+1 ?>" rows="10" class="form-control"></textarea>
</div>
</div>
<?php 
}
?>
<div class="mb-2"></div>
<div class="form-group">
    <button type="reset" class="btn btn-danger">Reset</button>
    <button class="btn btn-success" type="submit">$ Pay Now</button>
</div>
</form>
<script src="https://cdn.tiny.cloud/1/rjxia1mcuetdoiri6l19shyroh2q8rjrz7hdwighah58zqgr/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
 <script>
  var no_of_ques    = document.getElementById("ques_no").value;
  for(var i=1;i<=no_of_ques;i++)
{ 
   
  tinymce.init({
    selector: '#ques_details_'+i,
    plugins: "wordcount autolink",
    menubar: false
  });
}
  </script>
