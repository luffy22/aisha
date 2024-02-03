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
//echo $this->data;
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
<h2>Add Horoscope</h2>
<form role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_horoscope&task=horologin.savehoro'); ?>">
    <div class="mb-3" id="horo_grp_1">
        <label for="inputName" class="control-label">Name:</label>
        <input type="text" name="horo_fname" class="form-control" id="horo_1" placeholder="Enter your name..." required />
    </div>
    <div class="mb-3">
        <label for="inputGender" class="control-label">Gender:</label>
        <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="horo_gender" value="male" id="horo_gender1">
         <label class="form-check-label" for="inlineRadio2">Male</label>
         </div>
          <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="horo_gender" value="female" id="horo_gender2" checked>
        <label class="form-check-label" for="inlineRadio3">Female</label>
        </div>
    </div>
    <div class="mb-3">
	<label for="inputChart" class="control-label">Chart Style:</label>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="horo_chart" id="horo_chart_north" value="north" checked >
	  <label class="form-check-label" for="inlineRadio1">North Indian</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="horo_chart" id="horo_chart_south" value="south">
	  <label class="form-check-label" for="inlineRadio2">South Indian</label>
	</div>
	</div>
    <div class="mb-3" id="horo_grp_3">
        <label for="dob" class="control-label">Date Of Birth:</label>
    <?php 
        if(isMobileDevice()){
            //Your content or code for mobile devices goes here
    ?>
        <input type="date" name="horo_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
        else
        {
    ?>
        <input type="date" id="horo_dob" name="horo_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
    ?>
    </div>
    <div class="mb-3">
        <label for="dob" class="control-label">Time Of Birth(24 Hour Format):</label><br/>
        <input type="time" name="horo_tob" id="time" class="form-control" placeholder="18:30:00" />
    </div>
    <div class="mb-3" id="horo_grp_4">
        <label for="dob" class="control-label">Place Of Birth</label>
        <div class="ui-widget">
        <input type="text" id="horo_pob" name="horo_pob" class="form-control ui-autocomplete-input" placeholder="Enter text for list of places" />
        </div>
    </div>
    <input type="hidden" name="horo_user_id" value="<?php echo $id; ?>" />
    <input type="hidden" id="horo_pl_id" name="horo_pl_id" value="0"  />
    <div class="btn-group btn-group-lg">
            <button type="submit" class="btn btn-primary btn-lg" name="horosubmit" onclick="javascript:getLagna();return false;">Get Horoscope</button>
            <button type="reset" class="btn btn-danger btn-lg">Reset Form</button>
    </div>
</form>
<link rel="stylesheet" href="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.css' ?>" type="text/css" />
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.js' ?>"></script>
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_horoscope/script/horo.js' ?>">
</script>
<div class="mb-3"></div>
<?php
 }
?>
