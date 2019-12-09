<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
if(isset($_GET['redirect']) && $_GET['redirect'] == "horoscope")
{
    $redirect = "horoscope";
}
if(isset($_GET['redirect']) && $_GET['redirect'] == "findspouse")
{
    $redirect = "findspouse";
}
if(isset($_GET['redirect']) && $_GET['redirect'] == "mangaldosha")
{
    $redirect = "mangaldosha";
}
if(isset($_GET['redirect']) && $_GET['redirect'] == "divorce")
{
    $redirect = "divorce";
}
if(isset($_GET['redirect']) && $_GET['redirect'] == "careerfind")
{
    $redirect = "careerfind";
}
if(isset($_GET['redirect']) && $_GET['redirect'] == "astroyogas")
{
    $redirect = "astroyogas";
}
?>
<h3 class="lead alert alert-dark">Add Location</h3>
<form role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_astrologin&task=addlocation.addDetails'); ?>">
    <input type="hidden" name="loc_redirect" id="loc_redirect" value="<?php echo Juri::base().$redirect ?>" />
    <div class="form-group" id="lagna_grp_4">
        <label for="dob" class="control-label">City/Town</label>
        <div class="ui-widget">
            <input type="text" id="loc_city" name="loc_city" class="form-control" placeholder="Enter name of city/town" required />
        </div>
    </div>
    <div class="form-group" id="lagna_grp_4">
        <label for="dob" class="control-label">State/County</label>
        <div class="ui-widget">
        <input type="text" id="loc_state" name="loc_state" class="form-control" placeholder="Enter state/county name" />
        </div>
    </div>
    <div class="form-group" id="lagna_grp_4">
        <label for="dob" class="control-label">Country</label>
        <div class="ui-widget">
        <input type="text" id="loc_country" name="loc_country" class="form-control" placeholder="Enter name of country" required />
        </div>
    </div>
    <div class="form-group">
        <label for="longitude" class="control-label">Latitude</label><br/>
        <input type="text" id="loc_lat" class="form-control" name="loc_lat" placeholder="40.71.N for New York"  />
    </div>
    <div class="form-group">
        <label for="latitude" class="control-label">Longitude</label><br/>
        <input type="text" id="loc_lon" class="form-control" name="loc_lon" placeholder="74.00.W for New York"  />
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg" name="loc_submit"><i class="fas fa-plus"></i> Add</button>
    </div>
</form>
<link rel="stylesheet" href="<?php echo JUri::base().'components'.DS.'com_astrologin'.DS.'script/jquery-ui.min.css' ?>" type="text/css" />
<script type="text/javascript" src="<?php echo JUri::base().'components'.DS.'com_astrologin'.DS.'script/jquery-ui.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo JUri::base().'components'.DS.'com_astrologin'.DS.'script/autocomplete.js' ?>"></script>
