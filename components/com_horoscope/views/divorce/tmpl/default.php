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
//echo $this->data;	
?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
    <strong><i class="fas fa-exclamation-triangle"></i> If your location isn't available or if timezone error shows contact us on admin@astroisha.com. We would fix the issue asap.</strong>
</div>
<div class="mb-3"></div>
<h3>Enter Your Birth Details</h3>
<form role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_horoscope&task=divorce.checkchances'); ?>">
    <div class="form-group" id="lagna_grp_1">
        <label for="inputName" class="control-label">Name:</label>
        <input type="text" name="divorce_fname" class="form-control" id="divorce_name" placeholder="Enter your name..." required />
    </div>
    <div class="form-group">
        <label for="inputGender" class="control-label">Gender:</label>
         <input type="radio" name="divorce_gender" value="male" id="divorce_gender1"> Male
        <input type="radio" name="divorce_gender" value="female" id="divorce_gender2" checked> Female
    </div>
    <div class="form-group" id="lagna_grp_3">
        <label for="dob" class="control-label">Date Of Birth:</label>
     <?php 
        if(isMobileDevice()){
            //Your content or code for mobile devices goes here
    ?>    
        <input type="date" name="divorce_dob" class="form-control" placeholder="25/03/1984" />
    <?php
        }
        else
        {
    ?>
        <input type="date" id="datepicker" name="divorce_dob" class="form-control" placeholder="25/03/1984" />
    <?php
        }
    ?>
    </div>
    <div class="form-group">
        <label for="dob" class="control-label">Time Of Birth(24 Hour Format):</label><br/>
        <input type="time" name="divorce_tob" id="time" class="form-control" placeholder="18:30:00" />
    </div>
    <div class="form-group" id="lagna_grp_4">
        <label for="dob" class="control-label">Place Of Birth</label>
        <div class="ui-widget">
        <input type="text" id="divorce_pob" name="divorce_pob" class="form-control ui-autocomplete-input" placeholder="Enter text for list of places" />
        </div>
    </div>
    <input type="hidden" id="divorce_lat" name="divorce_lat"  />
    <input type="hidden" id="divorce_lon" name="divorce_lon"  />
    <input type="hidden" id="divorce_tmz" name="divorce_tmz"  />
    <div class="form-group">
        <label for="longitude" class="control-label">Longitude</label><br/>
        <input type="text" id="divorce_long_1" class="form-text1" name="divorce_lon_deg"  />
        <input type="text" id="divorce_long_2" class="form-text1" name="divorce_lon_min" />
        <select class="select2" id="divorce_long_direction" name="divorce_lon_dir">
            <option>E</option>
            <option>W</option>
        </select>
    </div>
    <div class="form-group">
        <label for="latitude" class="control-label">Latitude</label><br/>
        <input type="text" id="divorce_lat_1" class="form-text1" name="divorce_lat_deg"  />
        <input type="text" id="divorce_lat_2" class="form-text1" name="divorce_lat_min" />
        <select class="select2" id="divorce_lat_direction" name="divorce_lat_dir">
            <option>N</option>
            <option>S</option>
        </select>
        
    </div>
    <div class="btn btn-group btn-group-lg">
            <button type="submit" class="btn btn-primary btn-lg" name="divorce_submit" onclick="javascript:getLagna();return false;">Check Dosha</button>
            <button type="reset" class="btn btn-danger btn-lg">Reset Form</button>
    </div>
</form>
<div class="mb-1"></div>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/divorce.js' ?>">
</script>
