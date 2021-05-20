<html>
 <head>
<style type="text/css">
#horo_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#horo_canvas{width:65%}}
#moon_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#moon_canvas{width:65%}}
#navamsha_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#navamsha_canvas{width:65%}}
</style>
</head>
<body onload="javascript:draw_horoscope();getAscendant();">
<?php $chart_id = $_GET['chart']; ?>
<div class="mb-3"></div>
<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
$document = JFactory::getDocument(); 
$document->setTitle(strtolower($this->data['fname']).' details');
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
    //echo $tmz;exit;
    
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
            <td id="fname" value="<?php echo $this->data['fname']; ?>"><?php echo $this->data['fname']; ?></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td id="gender" value="<?php echo $this->data['gender'] ?>"><?php echo ucfirst($this->data['gender']); ?></td>
        </tr>
        <tr>
            <th>Date Of Birth</th>
            <?php $date   = new DateTime($this->data['dob_tob'], new DateTimeZone($tmz)); ?>
            <td id="dob" value="<?php echo $date->format('d-m-Y'); ?>"><?php echo $date->format('dS F Y'); ?></td>
        </tr>
        <tr>
            <th>Time Of Birth</th>
            <td id="tob" value="<?php echo $date->format('h:i:s a'); ?>"><?php echo $date->format('h:i:s a'); ?></td>
        </tr>
        <tr>
            <th>Place Of Birth</th>
            <td id="pob" value="<?php echo $pob ?>"><?php echo $pob; ?></td>
        </tr>
        <tr>
            <th>Latitude</th>
            <td><?php echo $lat;  ?></td>
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
<ul class="nav nav-pills">
<li class="nav-item"><a class="nav-link active" href="#asc" data-toggle="tab">Ascendant</a></li>
<li class="nav-item"><a class="nav-link" href="#moon" data-toggle="tab">Moon</a></li>
<li class="nav-item"><a class="nav-link" href="#navamsha" data-toggle="tab">Navamsha</a></li>
</ul>
<div class="tab-content">
<div id="asc" class="tab-pane active">
<div class="mb-1"></div>
    <canvas id="horo_canvas" height="260">
        Your browser does not support the HTML5 canvas tag.
    </canvas>
<?php
if($this->data['chart_type'] == "north")
{
?>
        <div class="mb-3"></div>
<p class="lead">Ascendant Chart</p>
<?php
}
?>
</div>
<div id="moon" class="tab-pane">
<div class="mb-1"></div>
 <canvas id="moon_canvas" height="260">
        Your browser does not support the HTML5 canvas tag.
    </canvas>
<?php
if($this->data['chart_type'] == "north")
{
?>
    <div class="mb-3"></div>
<p class="lead">Moon Chart</p>
<?php
}
?>

</div>
<div id="navamsha" class="tab-pane">
<div class="mb-1"></div>
 <canvas id="navamsha_canvas" height="260">
        Your browser does not support the HTML5 canvas tag.
    </canvas>
<?php
if($this->data['chart_type'] == "north")
{
?>
    <div class="mb-3"></div>
<p class="lead">Navamsha Chart</p>
<?php
}
?>
</div>
</div>
<div class="mb-3"></div>
    <p class="float-sm-right">(R) signifies that planet is retrograde at time of birth</p>
    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <tr>
            <th>Planets</th>
            <th>Sign</th>
            <th>Sign Lord</th>
            <th>Distance</th>
            <th>Nakshatra</th>
            <th>Nakshatra Lord</th>
            <th>Navamsha Sign</th>
        </tr>
    <?php 
           for($i=0;$i<count($planets);$i++)
           {
                $sign           = $planets[$i]."_sign";
                $sign_lord      = $planets[$i]."_sign_lord";
                $dist           = $planets[$i]."_dist";
                $nakshatra      = $planets[$i]."_nakshatra";
                $nakshatra_lord = $planets[$i]."_nakshatra_lord";
                $navamsha_sign  = $planets[$i]."_navamsha_sign";
                
    ?>
        <tr>
            <td><?php echo $planets[$i];if($this->data[$i]['status']=='retro'){echo '(R)';}  // code would add (R) if planet is Retrograde; ?></td>
            <td id="<?php echo strtolower(trim($planets[$i])); ?>_sign" value="<?php echo $this->data[$i][$sign]; ?>"><?php echo $this->data[$i][$sign]; ?></td>
            <td><?php echo $this->data[$i][$sign_lord]; ?></td>
            <td><?php echo $this->data[$i][$dist]; ?></td>
            <td><?php echo $this->data[$i][$nakshatra]; ?></td>
            <td><?php echo $this->data[$i][$nakshatra_lord]; ?></td>
            <td id="<?php echo strtolower(trim($planets[$i])); ?>_navamsha_sign" value="<?php echo $this->data[$i][$navamsha_sign]; ?>"><?php echo $this->data[$i][$navamsha_sign]; ?></td>
        </tr>
    <?php
           }
    ?>
    </table>
    </div>
    <form>
        <input type="hidden" name="ascendant_sign" id="ascendant_sign" value="<?php echo $this->data[0]['Ascendant_sign'];  ?>" />
        <input type="hidden" name="moon_sign" id="moon_sign" value="<?php echo $this->data[2]['Moon_sign']; ?>" />
        <input type="hidden" name="navamsha_sign" id="navamsha_sign" value="<?php echo $this->data[0]['Ascendant_navamsha_sign']; ?>" />
    </form>
<?php
if($this->data['chart_type'] == "north")
{
?>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/asc_n.js' ?>">
</script>
<?php
}
else
{
?>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/asc_s.js' ?>">
</script>
<?php 
}
unset($this->data); ?>
</body>
</html>
