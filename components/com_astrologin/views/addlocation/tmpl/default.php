<!--<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><i class="fas fa-exclamation-circle"></i> Adding Location Closed!</strong> Use the nearest location available.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>-->
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Kindly Note!</strong> Do not add a location if it is already available. If there are concerns with location accuracy 
  send them to our <a href="mailto:consult@stroisha.com">contact email</a> 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
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
if(isset($_GET['redirect']) && $_GET['redirect'] == "fourstage")
{
    $redirect = "fourstage";
}
if(isset($_GET['redirect']) && $_GET['redirect'] == "investwhere")
{
    $redirect = "investwhere";
}
if(isset($_GET['redirect']) && $_GET['redirect'] == "horologin")
{
    $redirect = "charts";
}
if(isset($_GET['redirect']) && $_GET['redirect'] == "latemarry")
{
    $redirect = "latemarry";
}
?>
<h3 class="lead alert alert-dark">Add Location</h3>
<form role="form" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_astrologin&task=addlocation.addDetails'); ?>">
    <input type="hidden" name="loc_redirect" id="loc_redirect" value="<?php echo Juri::base().$redirect ?>" />
    <div class="mb-3" id="lagna_grp_4">
        <label for="dob" class="control-label">City/Town</label>
        <div class="ui-widget">
            <input type="text" id="loc_city" name="loc_city" class="form-control" placeholder="Enter name of city/town" required />
        </div>
    </div>
    <div class="mb-3" id="lagna_grp_4">
        <label for="dob" class="control-label">State/County</label>
        <div class="ui-widget">
        <input type="text" id="loc_state" name="loc_state" class="form-control" placeholder="Enter state/county name" />
        </div>
    </div>
    <div class="mb-3" id="lagna_grp_4">
        <label for="dob" class="control-label">Country</label>
        <div class="ui-widget">
        <input type="text" id="loc_country" name="loc_country" class="form-control" placeholder="Enter name of country" required />
        </div>
    </div>
    <div class="mb-3">
        <label for="latitude" class="control-label">Latitude</label><br/>
        <input type="text" id="loc_lat_1" class="form-text1" name="lat_deg" maxlength="2" placeholder="deg" />
        <input type="text" id="loc_lat_2" class="form-text1" name="lat_min" maxlength="2" placeholder="min" />
        <select class="select2" id="lagna_lat_direction" name="lat_dir">
            <option>N</option>
            <option>S</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="longitude" class="control-label">Longitude</label><br/>
        <input type="text" id="loc_lon_1" class="form-text1" name="lon_deg" maxlength="3" placeholder="deg" />
        <input type="text" id="loc_lon_2" class="form-text1" name="lon_min" maxlength="2" placeholder="min" />
        <select class="select2" id="lagna_lon_direction" name="lon_dir">
            <option>E</option>
            <option>W</option>
        </select>
    </div>
    <input type="hidden" id="ip_addr" name="ip_addr" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
    <div class="mb-3">
        <button type="submit" class="btn btn-primary btn-lg" name="loc_submit"><i class="fas fa-plus"></i> Add</button>
    </div>
</form>
<div class="mb-3"></div>
<link rel="stylesheet" href="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.css' ?>" type="text/css" />
<script type="text/javascript" src="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo JUri::base().'components/com_astrologin/script/autocomplete.js' ?>"></script>
