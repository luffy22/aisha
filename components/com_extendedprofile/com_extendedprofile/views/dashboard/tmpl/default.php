<?php
defined('_JEXEC') or die('Restricted access');
//print_r($this->msg);exit;
$items          = $this->msg;
//print_r($items);exit;
unset($items['country']);
unset($items['amount']);
unset($items['currency']);
unset($items['curr_code']);
unset($items['curr_full']);
$user       = JFactory::getUser();
//print_r($user);exit;
?>
<h3>Enter Your Details</h3>
<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Fields marked with asterix(*) are compulsory.</div>
<div class="form-group"><label>Name: </label> <?php echo $user->name; ?></div>
<div class="form-group"><label>Email: </label> <?php echo $user->email; ?> <?php if($user->sendEmail == '0'){ ?><span style="color:green"><i class="fa fa-check-circle" aria-hidden="true"></i></span><?php } ?></div>
<form enctype="application/x-www-form-urlencoded" method="post" action="<?php echo JRoute::_('?option=com_extendedprofile&task=extendedprofile.registerAstro'); ?>">
<div class="form-group">
    <label>Phone: </label>
    <input type="phone" class="form-control" name="astro_phone" placeholder="Enter Phone Number(Optional)" />
</div>
<div class="form-group">
    <label>Mobile: </label>
    <input type="text" class="form-control" name="astro_mobile" placeholder="Enter Mobile Number(Optional)" />
</div>
<div class="form-group">
    <label>City*: </label>
    <input type="text" class="form-control" name="astro_city" required placeholder="Enter City Name(Compulsory)" />
</div>
<div class="form-group">
    <label>State/Province: </label>
    <input type="text" class="form-control" name="astro_state" placeholder="Enter State/Province/County Name(Optional)" />
</div>  
<div class="form-group">
     <label>Country*: </label>
    <input type="text" class="form-control" name="astro_country" required placeholder="Enter Country Name(Compulsory)" />
</div>    
<div class="form-check">
    <label><strong>Select Expertise*: </strong>(One Compulsory): </label>
<?php
foreach($items as $item)
{ 
    $id     = $item['role_id'];
    $name   = $item['role_name'];
    $role   = $item['role_primary'];
    $role_super     = $item['role_super'];
    if($role  == "1")
    {
?>
    <br/>
   <strong><?php echo $name; ?></strong><br/>
<?php
        foreach($items as $subitems)
        {
            $subid  = $subitems['role_id'];
            $subname    = $subitems['role_name'];
            $sub_role_super = $subitems['role_super'];
            if($id       == $sub_role_super)
            {
?>      
                <label class="form-check-label">
                    <input class="form-check-input" name="astro_subexpert[]" type="checkbox" value="<?php echo $id.":".$subid; ?>" /> <?php echo $subname; ?>
                </label>
<?php   
            }
        }
    }
}
?>
</div>
<div class="form-group">
     <label>Describe Your Expertise(Max 750 Words)*: </label>
    <textarea class="form-control" name="astro_detail" id="astro_detail" placeholder="Enter Country Name(Compulsory)" rows="10" ></textarea>
</div> 
<div class="form-group">
    <input type="checkbox" name="astro_terms" value="yes" required />
    <label for="condition_profile">Kindly Read and Accept the <a href="<?php echo JURI::base() ?>/terms" target="_blank" title="Read the Terms And Conditions before Registering as Astrologer">Terms and Conditions</a> for Registration *</label>
</div>
<div class="form-group">
        <button type="submit" name="submit_profile" class="btn btn-primary" onclick="checkValues();return false;">Submit</button>
        <a class="btn btn-danger" href="<?php echo JURI::base() ?>dashboard">Cancel</a>
    </div>
</form>
<?php
flush($this->msg);
flush($items);
?>
<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
<script>
  tinymce.init({
    selector: '#astro_detail',
    plugins: "wordcount autolink",
    menubar: false
  });
</script>
</body>