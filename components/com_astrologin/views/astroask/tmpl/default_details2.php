<?php
defined('_JEXEC') or die();
$uniq_id                = $_GET['uniq_id'];
$no_of_ques             = $_GET['no_of_ques'];
//echo $no_of_ques;exit;
//print_r($this->data);exit;
?>
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
<?php
    foreach($this->data as $data)
    {   
        if($data->role_super == "0")
        {
            $id         = $data->role_id;
?>
        <option value="<?php echo $data->role_name ?>" disabled><?php echo "Expertise: ".$data->role_name ?></option>
        
<?php
        foreach($this->data as $sub_data)
             {
                if($sub_data->role_super == $id)
                {
?>
                    <option value="<?php echo $sub_data->role_name ?>"><?php echo $sub_data->role_name ?></option>
<?php
                }
                
             }
        }
    }
?>
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
<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
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
