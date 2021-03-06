<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
//echo $this->data;
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
if(array_key_exists("no_data", $this->data))
{
?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><?php echo $this->data['no_data']; ?></strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
}
?>
<div class="alert alert-info alert-dismissible fade show" role="alert">
    If your location isn't available than add it: <a href="<?php echo JUri::base().'addlocation?redirect=fourstage'; ?>"><i class="fas fa-plus"></i> Add Location</a>
</div>
<div class="mb-3"></div>
<?php
$user =& JFactory::getUser();
if($user->id == "0")
{
?>
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <a href="<?php echo JUri::base().'register' ?>">Register</a> with us to save upto fifty horoscopes
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
}
?>
<div class="mb-3"></div>
<h2>Enter Your Details</h2>
<form role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_horoscope&task=fourstages.findstage'); ?>">
    <div class="form-group" id="stage_grp_1">
        <label for="inputName" class="control-label">Name:</label>
        <input type="text" name="stage_fname" class="form-control" id="stage_1" placeholder="Enter your name..." />
    </div>
    <div class="form-group">
        <label for="inputGender" class="control-label">Gender:</label>
         <input type="radio" name="stage_gender" value="male" id="stage_gender1"> Male
        <input type="radio" name="stage_gender" value="female" id="stage_gender2" checked> Female
    </div>
    <div class="form-group">
	<label for="inputChart" class="control-label">Chart Style:</label>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="stage_chart" id="stage_chart_north" value="north" checked >
	  <label class="form-check-label" for="inlineRadio1">North Indian</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="stage_chart" id="stage_chart_south" value="south">
	  <label class="form-check-label" for="inlineRadio2">South Indian</label>
	</div>
	</div>
    <div class="form-group" id="stage_grp_3">
        <label for="dob" class="control-label">Date Of Birth:</label>
    <?php 
        if(isMobileDevice()){
            //Your content or code for mobile devices goes here
    ?>
        <input type="date" name="stage_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
        else
        {
    ?>
        <input type="date" id="stage_dob" name="stage_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
    ?>
    </div>
    <div class="form-group">
        <label for="dob" class="control-label">Time Of Birth(24 Hour Format):</label><br/>
        <input type="time" name="stage_tob" id="time" class="form-control" placeholder="18:30:00" />
    </div>
    <div class="form-group" id="stage_grp_4">
        <label for="dob" class="control-label">Place Of Birth</label>
        <div class="ui-widget">
        <input type="text" id="stage_pob" name="stage_pob" class="form-control ui-autocomplete-input" placeholder="Enter text for list of places" />
        </div>
    </div>
    <input type="hidden" id="stage_lat" name="stage_lat"  />
    <input type="hidden" id="stage_lon" name="stage_lon"  />
    <input type="hidden" id="stage_tmz" name="stage_tmz"  />
    <div class="form-group">
        <label for="latitude" class="control-label">Latitude</label><br/>
        <input type="text" id="stage_lat_1" class="form-text1" name="lat_deg" placeholder="deg"  />
        <input type="text" id="stage_lat_2" class="form-text1" name="lat_min" placeholder="min" />
        <select class="select2" id="stage_lat_direction" name="lat_dir">
            <option>N</option>
            <option>S</option>
        </select>
        
    </div>
    <div class="form-group">
        <label for="longitude" class="control-label">Longitude</label><br/>
        <input type="text" id="stage_long_1" class="form-text1" name="lon_deg" placeholder="deg"  />
        <input type="text" id="stage_long_2" class="form-text1" name="lon_min" placeholder="min" />
        <select class="select2" id="stage_long_direction" name="lon_dir">
            <option>E</option>
            <option>W</option>
        </select>
    </div>
    <div class="btn-group btn-group-lg">
            <button type="submit" class="btn btn-primary btn-lg" name="stage_submit" >Get Stages</button>
            <button type="reset" class="btn btn-danger btn-lg">Reset Form</button>
    </div>
</form>
<link rel="stylesheet" href="<?php echo JUri::base().'components'.DS.'com_astrologin'.DS.'script/jquery-ui.min.css' ?>" type="text/css" />
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_astrologin'.DS.'script/jquery-ui.min.js' ?>"></script>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/fourstages.js' ?>">
</script>
<div class="mb-3"></div>
