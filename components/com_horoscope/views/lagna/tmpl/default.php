<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
echo $this->data;	
?>
<div class="mb-1"></div>
<h2>Calculate Horoscope</h2>
<form role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_horoscope&task=lagna.findlagna'); ?>">
    <div class="form-group" id="lagna_grp_1">
        <label for="inputName" class="control-label">Name:</label>
        <input type="text" name="lagna_fname" class="form-control" id="lagna_1" placeholder="Enter your name..." />
    </div>
    <div class="form-group">
        <label for="inputGender" class="control-label">Gender:</label>
         <input type="radio" name="lagna_gender" value="male" id="lagna_gender1"> Male
        <input type="radio" name="lagna_gender" value="female" id="lagna_gender2" checked> Female
    </div>
    <div class="form-group" id="lagna_grp_3">
        <label for="dob" class="control-label">Date Of Birth:</label>
        <input type="date" name="lagna_dob" id="datepicker" class="form-control" placeholder="25/03/1984" />
    </div>
    <div class="form-group">
        <label for="dob" class="control-label">Time Of Birth(24 Hour Format):</label><br/>
        <input type="time" name="lagna_tob" id="time" class="form-control" placeholder="18:30:00" />
    </div>
    <div class="form-group" id="lagna_grp_4">
        <label for="dob" class="control-label">Place Of Birth</label>
        <div class="ui-widget">
        <input type="text" id="lagna_pob" name="lagna_pob" class="form-control ui-autocomplete-input" placeholder="Enter text for list of places" />
        </div>
    </div>
    <input type="hidden" id="lagna_lat" name="lagna_lat"  />
    <input type="hidden" id="lagna_lon" name="lagna_lon"  />
    <input type="hidden" id="lagna_tmz" name="lagna_tmz"  />
    <div class="form-group">
        <label for="longitude" class="control-label">Longitude</label><br/>
        <input type="text" id="lagna_long_1" class="form-text1" name="lon_deg"  />
        <input type="text" id="lagna_long_2" class="form-text1" name="lon_min" />
        <select class="select2" id="lagna_long_direction" name="lon_dir">
            <option>E</option>
            <option>W</option>
        </select>
    </div>
    <div class="form-group">
        <label for="latitude" class="control-label">Latitude</label><br/>
        <input type="text" id="lagna_lat_1" class="form-text1" name="lat_deg"  />
        <input type="text" id="lagna_lat_2" class="form-text1" name="lat_min" />
        <select class="select2" id="lagna_lat_direction" name="lat_dir">
            <option>N</option>
            <option>S</option>
        </select>
        
    </div>
    <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg" name="lagnasubmit" onclick="javascript:getLagna();return false;">Get Horoscope</button>
             <button type="reset" class="btn btn-danger btn-lg">Reset Form</button>
    </div>
</form>
<div class="mb-1"></div>