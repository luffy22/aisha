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
?>
<div class="alert alert-primary alert-dismissible fade show" role="alert">
    If your location isn't available than add it: <a href="<?php echo JUri::base().'addlocation?redirect=investwhere'; ?>"><i class="bi bi-plus-circle-fill"></i> Add Location</a>
</div>
<div class="mb-3"></div>
<h2>Where To Invest</h2>
<form role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_horoscope&task=savings.checksavings'); ?>">
    <div class="mb-3" id="savings_grp_1">
        <label for="inputName" class="form-label">Name:</label>
        <input type="text" name="savings_fname" class="form-control" id="savings_1" placeholder="Enter your name..." required />
    </div>
    <div class="mb-3">
        <label for="inputChart" class="form-label">Gender:</label>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="savings_gender" id="savings_gender_male" value="male">
	  <label class="form-check-label" for="inlineRadio1">Male</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="savings_gender" id="savings_gender_female" value="female" checked>
	  <label class="form-check-label" for="inlineRadio2">Female</label>
	</div>
    </div>
    <div class="mb-3">
	<label for="inputChart" class="form-label">Chart Style:</label>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="savings_chart" id="savings_chart_north" value="north" checked >
	  <label class="form-check-label" for="inlineRadio1">North Indian</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="savings_chart" id="savings_chart_south" value="south">
	  <label class="form-check-label" for="inlineRadio2">South Indian</label>
	</div>
	</div>
    <div class="mb-3" id="savings_grp_3">
        <label for="dob" class="form-label">Date Of Birth:</label>
    <?php 
        if(isMobileDevice()){
            //Your content or code for mobile devices goes here
    ?>
        <input type="date" name="savings_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
        else
        {
    ?>
        <input type="date" id="savings_dob" name="savings_dob" class="form-control" placeholder="25/03/1984" min="1900-01-01" max="2030-12-31" />
    <?php
        }
    ?>
    </div>
    <div class="mb-3">
        <label for="dob" class="form-label">Time Of Birth(24 Hour Format):</label><br/>
        <input type="time" name="savings_tob" id="time" class="form-control" placeholder="18:30:00" />
    </div>
    <div class="mb-3" id="savings_grp_4">
        <label for="dob" class="form-label">Place Of Birth</label>
        <div class="ui-widget">
        <input type="text" id="savings_pob" name="savings_pob" class="form-control ui-autocomplete-input" placeholder="Enter text for list of places" />
        </div>
    </div>
    <input type="hidden" id="savings_lat" name="savings_lat"  />
    <input type="hidden" id="savings_lon" name="savings_lon"  />
    <input type="hidden" id="savings_tmz" name="savings_tmz"  />
    <div class="mb-3">
        <label for="latitude" class="form-label">Latitude</label><br/>
        <input type="text" id="savings_lat_1" class="form-text1" name="lat_deg" maxlength="2" placeholder="deg" />
        <input type="text" id="savings_lat_2" class="form-text1" name="lat_min" maxlength="2" placeholder="min" />
        <select class="select2" id="savings_lat_direction" name="lat_dir">
            <option>N</option>
            <option>S</option>
        </select>
        
    </div>
    <div class="mb-3">
        <label for="longitude" class="form-label">Longitude</label><br/>
        <input type="text" id="savings_long_1" class="form-text1" name="lon_deg" maxlength="3" placeholder="deg"  />
        <input type="text" id="savings_long_2" class="form-text1" name="lon_min" maxlength="2" placeholder="min" />
        <select class="select2" id="savings_long_direction" name="lon_dir">
            <option>E</option>
            <option>W</option>
        </select>
    </div>
    <div class="btn-group btn-group-lg">
            <button type="submit" class="btn btn-primary btn-lg" name="savings_submit" onclick="javascript:getsavings();return false;">Check Places</button>
            <button type="reset" class="btn btn-danger btn-lg">Reset Form</button>
    </div>
</form>
<link rel="stylesheet" href="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.css' ?>" type="text/css" />
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.js' ?>"></script>
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_horoscope/script/savings.js' ?>">
</script>
<div class="mb-3"></div>
