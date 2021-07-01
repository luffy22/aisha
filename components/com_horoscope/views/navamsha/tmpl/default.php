<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
$document = JFactory::getDocument(); 
$document->setTitle('Navamsha Chart');
//print_r($this->data);exit;
//$chart          = $this->data['chart'];
$a = 0;
?>
<html>
 <head>
<style type="text/css">
#navamsha_canvas{width: 100%;height: auto;}@media (min-width: 768px) {#navamsha_canvas{width:65%}}
</style>
 </head>
 <body onload="javascript:draw_horoscope();getNavamsha();">
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
</div>
 <?php 
    $chart_id = $_GET['chart']; 
    //print_r($this->data);exit;
    if(array_key_exists("timezone", $this->data))
    {
        if(substr($this->data['lat'],0,1) == "-")
        {
            $this->data['lat'] = str_replace("-","",$this->data['lat']);
            $lat    =  $this->data['lat']."&deg; S";
        }
        else
        {
            $lat    = $this->data['lat']."&deg; N"; 
        }
        if(substr($this->data['lon'],0,1) == "-")
        {
            $this->data['lon'] = str_replace("-","",$this->data['lon']);
            $lon    = $this->data['lon']."&deg; W";
        }
        else
        {
            $lon    = $this->data['lon']."&deg; E"; 
        }
        $tmz    = $this->data['timezone'];
        $pob    = $this->data['pob'];
    }
    else 
    {
        if(substr($this->data['latitude'],0,1) == "-")
        {
            $this->data['latitude'] = str_replace("-","",$this->data['latitude']);
            $lat    =  $this->data['latitude']."&deg; S";
        }
        else
        {
            $lat    = $this->data['latitude']."&deg; N"; 
        }
        if(substr($this->data['longitude'],0,1) == "-")
        {
            $this->data['longitude'] = str_replace("-","",$this->data['longitude']);
            $lon    = $this->data['longitude']."&deg; W";
        }
        else
        {
            $lon    = $this->data['longitude']."&deg; E"; 
        }
        $tmz    = $this->data['tmz_words'];

        if($this->data['state'] == "" && $this->data['country'] == "")
        {
            $pob    = $this->data['city'];
        }
        else if($this->data['state'] == "" && $this->data['country'] != "")
        {
            $pob    = $this->data['city'].", ".$this->data['country'];
        }
        else
        {
            $pob    = $this->data['city'].", ".$this->data['state'].", ".$this->data['country'];
        }
    }
?>
<div class="mb-3"></div>
<table class="table table-bordered table-hover table-striped">
    <tr>
        <th>Name</th>
        <td><?php echo $this->data['fname']; ?></td>
    </tr>
    <tr>
        <th>Gender</th>
        <td><?php echo ucfirst($this->data['gender']); ?></td>
    </tr>
    <tr>
        <th>Date Of Birth</th>
        <td><?php 
                $date   = new DateTime($this->data['dob_tob'], new DateTimeZone($tmz));
                echo $date->format('dS F Y'); ?></td>
    </tr>
    <tr>
        <th>Time Of Birth</th>
        <td><?php echo $date->format('h:i:s a'); ?></td>
    </tr>
    <tr>
        <th>Place Of Birth</th>
        <td><?php echo $pob; ?></td>
    </tr>
    <tr>
        <th>Latitude</th>
        <td><?php echo $lat; ?></td>
    </tr>
    <tr>
        <th>Longitude</th>
        <td><?php echo $lon; ?></td>
    </tr>
    <tr>
            <th>Timezone</th>
            <td><?php echo "GMT".$date->format('P'); ?></td>
    </tr>
    <tr>
    <th>Apply DST</th>
    <td><?php if($date->format('I') == '1')
                { echo "Yes"; }
              else
              { echo "No"; } ?></td>
    </tr>
</table>
<div class="mb-3"></div>
<canvas id="navamsha_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<p class="float-sm-right">Vargottama planet gives good results in its <a href="<?php echo JURi::base() ?>getvimshottari?chart=<?php echo $chart_id ?>" title="Vimsottari Dasha">Vimshottari Dasha</a> Period</p>
<div class="table-responsive">
<table class="table table-bordered table-striped">
    <tr>
        <th>Planet</th>
        <th>Sign</th>
        <th>Navamsha</th>
        <th>Vargottama</th>
    </tr>
<?php 
   foreach($this->data['nav_data'] as $key => $data)
    {
        if(($a % 2) == 0)
        {
            $new_key1   = $key;
            $new_val1   = $data;
?>
    <tr>
        <td><?php echo $new_key1; ?></td>
        <td><?php echo $new_val1; ?></td>
        
<?php
        }
        else if((($a % 2) == 1))
        {
            $new_key2   = $key;
            $new_val2   = $data;
?>
        
        <td id="<?php echo strtolower($new_key1) ?>_sign" value="<?php echo $new_val2; ?>"><?php echo $new_val2; ?></td>
<?php 
        $new_key2    = str_replace("_navamsha_sign","",$new_key2);
        if($new_key1 == "Ascendant"||$new_key1=="Uranus"||
                $new_key1=="Neptune"||$new_key1=="Pluto")
        {
?>
        <td>-</td>
<?php            
        }
        else if(($new_key2 == $new_key1)&&($new_val2 == $new_val1))
        {
?>
        <td><?php echo "Yes"; ?></td>
<?php
        }
        else{
?>
         <td><?php echo "No"; ?></td>
        <?php
        }
        ?>
    </tr>
<?php
        }
        $a++;
    }
?>
</table>
</div>
<form>
<?php
    foreach($this->data['main'] as $key=>$value)
    {
  
?>
    <input type="hidden" name="<?php echo strtolower(trim($key)); ?>_sign" id="<?php echo strtolower(trim($key)); ?>_sign" value="<?php echo $value; ?>" />
<?php
    }
?>
</form>
<?php
if($this->data['main']['chart_type'] == "north")
{
?>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/horoscope_n.js' ?>">
</script>
<?php
}
else
{
?>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/horoscope_s.js' ?>">
</script>
<?php 
}
unset($this->data); ?>
 </body>