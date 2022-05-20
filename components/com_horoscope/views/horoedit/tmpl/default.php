<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
$user   = JFactory::getUser();
$id     = $user->id;
//echo $id;exit;
//echo $this->data
//print_r($this->data);exit;
$date   = new DateTime($this->data->dob_tob);
//echo $date->format('d/m/Y');exit;
if(empty($this->data->state) && (empty($this->data->country)))
{
    $place      = $this->data->city;
}
else if(empty($this->data->state) && (!empty($this->data->country)))
{
    $place      = $this->data->city.", ". $this->data->country;
}
else
{
    $place      = $this->data->city.", ".$this->data->state.", ".$this->data->country;
}
if($id == "0")
{
    $app        = JFactory::getApplication();
        $link       = JURI::base().'login';
        $app->enqueueMessage("Please login first to add users.", 'warning');
        $app        ->redirect($link);
}
 else {
    
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
?>
<div class="alert alert-info alert-dismissible fade show" role="alert">
    If your location isn't available than add it: <a href="<?php echo JUri::base().'addlocation?redirect=horoscope'; ?>"><i class="fas fa-plus"></i> Add Location</a>
</div>
<div class="mb-3"></div>
<h2>Edit Horoscope</h2>
<form role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_horoscope&task=horoedit.edithoro'); ?>">
    <div class="mb-3" id="edit_grp_1">
        <label for="inputName" class="form-label">Name:</label>
        <input type="text" name="edit_fname" class="form-control" id="edit_1" placeholder="Enter your name..."  value="<?php echo $this->data->fname; ?>" required />
    </div>
    <div class="mb-3">
        <label for="inputGender" class="form-label">Gender:</label>
  <?php
        if($this->data->gender =="male")
        {
  ?>
  <div class="mb-3">
        <label for="inputChart" class="form-label">Gender:</label>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="edit_gender" id="edit_gender_male" value="male" checked>
	  <label class="form-check-label" for="inlineRadio1">Male</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="edit_gender" id="edit_gender_female" value="female">
	  <label class="form-check-label" for="inlineRadio2">Female</label>
	</div>
    </div>
<?php
        }
        else 
        {
?>
        <div class="mb-3">
        <label for="inputChart" class="form-label">Gender:</label>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="edit_gender" id="edit_gender_male" value="male">
	  <label class="form-check-label" for="inlineRadio1">Male</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="edit_gender" id="edit_gender_female" value="female" checked>
	  <label class="form-check-label" for="inlineRadio2">Female</label>
	</div>
    </div>
<?php     
        }
?>
    </div>
    <div class="mb-3">
	<label for="inputChart" class="form-label">Chart Style:</label>
<?php
        if($this->data->chart_type =="north")
        {
?>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="edit_chart" id="edit_chart_north" value="north" checked >
	  <label class="form-check-label" for="inlineRadio1">North Indian</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="edit_chart" id="edit_chart_south" value="south">
	  <label class="form-check-label" for="inlineRadio2">South Indian</label>
	</div>
<?php
        }
        else
        {
?>
        <div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="edit_chart" id="edit_chart_north" value="north" >
	  <label class="form-check-label" for="inlineRadio1">North Indian</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="edit_chart" id="edit_chart_south" value="south" checked>
	  <label class="form-check-label" for="inlineRadio2">South Indian</label>
	</div>
<?php
        }
?>
	</div>
    <div class="mb-3" id="edit_grp_3">
        <label for="dob" class="form-label">Date Of Birth:</label>
        <input type="date" id="edit_dob" name="edit_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" value="<?php echo $date->format('Y-m-d'); ?>" />
    </div>
    <div class="mb-3">
        <label for="dob" class="form-label">Time Of Birth(24 Hour Format):</label><br/>
        <input type="time" name="edit_tob" id="time" class="form-control" placeholder="18:30:00" value="<?php echo $date->format('H:i'); ?>" />
    </div>
    <div class="mb-3" id="edit_grp_4">
        <label for="dob" class="form-label">Place Of Birth</label>
        <div class="ui-widget">
        <input type="text" id="edit_pob" name="edit_pob" class="form-control ui-autocomplete-input" placeholder="Enter text for list of places" value="<?php echo $place; ?>" />
        </div>
    </div>
    <input type="hidden" name="edit_user_id" value="<?php echo $id; ?>" />
    <input type="hidden" id="edit_pl_id" name="edit_pl_id" value="<?php echo $this->data->loc_id; ?>"  />
    <input type="hidden" id="edit_uniq_id" name="edit_uniq_id" value="<?php echo $this->data->uniq_id; ?>" />
    <div class="btn-group btn-group-lg">
            <button type="submit" class="btn btn-primary btn-lg" name="editsubmit" onclick="javascript:getLagna();return false;">Save Horoscope</button>
            <button type="reset" class="btn btn-danger btn-lg">Reset Form</button>
    </div>
</form>
<link rel="stylesheet" href="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.css' ?>" type="text/css" />
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.js' ?>"></script>
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_horoscope/script/edit.js' ?>">
</script>
<div class="mb-3"></div>
<?php
 }
?>
