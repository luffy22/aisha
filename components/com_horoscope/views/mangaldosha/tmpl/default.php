<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
function isMobileDevice() {
    return preg_match("/(android|iPhone|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
?>
<div class="alert alert-primary alert-dismissible fade show" role="alert">
    If your location isn't available than add it: <a href="<?php echo JUri::base().'addlocation?redirect=mangaldosha'; ?>"><i class="bi bi-plus-circle-fill"></i> Add Location</a>
</div>
<div class="mb-3"></div>
<h3>Enter Your Birth Details</h3>
<form role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_horoscope&task=mangaldosha.mdosha'); ?>">
    <div class="mb-3" id="lagna_grp_1">
        <label for="inputName" class="control-label">Name:</label>
        <input type="text" name="mdosha_fname" class="form-control" id="mdosha_name" placeholder="Enter your name..." required />
    </div>
    <div class="mb-3">
        <label for="inputChart" class="control-label">Gender:</label>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="mdosha_gender" id="mdosha_gender_male" value="male">
	  <label class="form-check-label" for="inlineRadio1">Male</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="mdosha_gender" id="mdosha_gender_female" value="female" checked>
	  <label class="form-check-label" for="inlineRadio2">Female</label>
	</div>
    </div>
    <div class="mb-3">
	<label for="inputChart" class="control-label">Chart Style:</label>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="mdosha_chart" id="lagna_chart_north" value="north" checked >
	  <label class="form-check-label" for="inlineRadio1">North Indian</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="mdosha_chart" id="lagna_chart_south" value="south">
	  <label class="form-check-label" for="inlineRadio2">South Indian</label>
	</div>
	</div>
    <div class="mb-3" id="lagna_grp_3">
        <label for="dob" class="control-label">Date Of Birth:</label>
     <?php 
        if(isMobileDevice()){
            //Your content or code for mobile devices goes here
    ?>    
        <input type="date" name="mdosha_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
        else
        {
    ?>
        <input type="date" id="mdosha_dob" name="mdosha_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
    ?>
    </div>
    <div class="mb-3">
        <label for="dob" class="control-label">Time Of Birth(24 Hour Format):</label><br/>
        <input type="time" name="mdosha_tob" id="time" class="form-control" placeholder="18:30:00" />
    </div>
    <div class="mb-3" id="lagna_grp_4">
        <label for="dob" class="control-label">Place Of Birth</label>
        <div class="ui-widget">
        <input type="text" id="mdosha_pob" name="mdosha_pob" class="form-control ui-autocomplete-input" placeholder="Enter text for list of places" />
        </div>
    </div>
    <input type="hidden" id="mdosha_lat" name="mdosha_lat"  />
    <input type="hidden" id="mdosha_lon" name="mdosha_lon"  />
    <input type="hidden" id="mdosha_tmz" name="mdosha_tmz"  />
    <div class="mb-3">
        <label for="latitude" class="control-label">Latitude</label><br/>
        <input type="text" id="mdosha_lat_1" class="form-text1" name="mdosha_lat_deg" maxlength="2" placeholder="deg" />
        <input type="text" id="mdosha_lat_2" class="form-text1" name="mdosha_lat_min" maxlength="2" placeholder="min" />
        <select class="select2" id="mdosha_lat_direction" name="mdosha_lat_dir">
            <option>N</option>
            <option>S</option>
        </select>
        
    </div>
    <div class="mb-3">
        <label for="longitude" class="control-label">Longitude</label><br/>
        <input type="text" id="mdosha_long_1" class="form-text1" name="mdosha_lon_deg" maxlength="3" placeholder="deg"  />
        <input type="text" id="mdosha_long_2" class="form-text1" name="mdosha_lon_min" maxlength="2" placeholder="min" />
        <select class="select2" id="mdosha_long_direction" name="mdosha_lon_dir">
            <option>E</option>
            <option>W</option>
        </select>
    </div>
    <div class="btn btn-group btn-group-lg">
            <button type="submit" class="btn btn-primary btn-lg" name="mdosha_submit" onclick="javascript:getLagna();return false;">Check Dosha</button>
            <button type="reset" class="btn btn-danger btn-lg">Reset Form</button>
    </div>
</form>
<div class="mb-1"></div>
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_horoscope/script/mangaldosha.js' ?>">
</script>
<link rel="stylesheet" href="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.css' ?>" type="text/css" />
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.js' ?>"></script>
