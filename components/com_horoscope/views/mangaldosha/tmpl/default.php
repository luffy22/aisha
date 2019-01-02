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
<h3>Enter Your Birth Details</h3>
<form role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_horoscope&task=mdosha.mdosha'); ?>">
    <div class="form-group" id="lagna_grp_1">
        <label for="inputName" class="control-label">Name:</label>
        <input type="text" name="mdosha_fname" class="form-control" id="mdosha_name" placeholder="Enter your name..." required />
    </div>
    <div class="form-group">
        <label for="inputGender" class="control-label">Gender:</label>
         <input type="radio" name="mdosha_gender" value="male" id="mdosha_gender1"> Male
        <input type="radio" name="mdosha_gender" value="female" id="mdosha_gender2" checked> Female
    </div>
    <div class="form-group" id="lagna_grp_3">
        <label for="dob" class="control-label">Date Of Birth:</label>
        <input type="date" name="mdosha_dob" id="datepicker" class="form-control" placeholder="25/03/1984" />
    </div>
    <div class="form-group">
        <label for="dob" class="control-label">Time Of Birth(24 Hour Format):</label><br/>
        <input type="time" name="mdosha_tob" id="time" class="form-control" placeholder="18:30:00" />
    </div>
    <div class="form-group" id="lagna_grp_4">
        <label for="dob" class="control-label">Place Of Birth</label>
        <div class="ui-widget">
        <input type="text" id="mdosha_pob" name="mdosha_pob" class="form-control ui-autocomplete-input" placeholder="Enter text for list of places" />
        </div>
    </div>
    <input type="hidden" id="mdosha_lat" name="mdosha_lat"  />
    <input type="hidden" id="mdosha_lon" name="mdosha_lon"  />
    <input type="hidden" id="mdosha_tmz" name="mdosha_tmz"  />
    <div class="form-group">
        <label for="longitude" class="control-label">Longitude</label><br/>
        <input type="text" id="mdosha_long_1" class="form-text1" name="mdosha_deg"  />
        <input type="text" id="mdosha_long_2" class="form-text1" name="mdosha_min" />
        <select class="select2" id="mdosha_long_direction" name="mdosha_dir">
            <option>E</option>
            <option>W</option>
        </select>
    </div>
    <div class="form-group">
        <label for="latitude" class="control-label">Latitude</label><br/>
        <input type="text" id="mdosha_lat_1" class="form-text1" name="mdosha_deg"  />
        <input type="text" id="mdosha_lat_2" class="form-text1" name="mdosha_min" />
        <select class="select2" id="mdosha_lat_direction" name="mdosha_dir">
            <option>N</option>
            <option>S</option>
        </select>
        
    </div>
    <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg" name="mdosha_submit" onclick="javascript:getLagna();return false;">Check Mangal Dosha</button>
            <button type="reset" class="btn btn-danger btn-lg">Reset Form</button>
    </div>
</form>
<div class="mb-1"></div>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/findspouse.js' ?>">
</script>
