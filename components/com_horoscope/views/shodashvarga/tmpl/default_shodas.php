<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
//echo $this->data['main']['timezone'];exit;
//$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
$chart_id = $_GET['chart'];
?>
<head>
<style type="text/css">
#horo_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#horo_canvas{width:65%}}
#nav_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#nav_canvas{width:65%}}
#dash_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#dash_canvas{width:65%}}
#hora_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#hora_canvas{width:65%}}
#drek_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#drek_canvas{width:65%}}
#chatur_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#chatur_canvas{width:65%}}
#sapt_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#sapt_canvas{width:65%}}
#dwad_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#dwad_canvas{width:65%}}
#shod_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#shod_canvas{width:65%}}
#vim_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#vim_canvas{width:65%}}
#chatvim_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#chatvim_canvas{width:65%}}
#saptvim_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#saptvim_canvas{width:65%}}
#trim_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#trim_canvas{width:65%}}
#khed_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#khed_canvas{width:65%}}
#aksh_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#aksh_canvas{width:65%}}
#shast_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#shast_canvas{width:65%}}
</style>
</head>
<body onload="javascript:draw_horoscope();">
<?php
if(array_key_exists("timezone", $this->data['main']))
{  
    //echo "calls";exit;
    if(substr($this->data['main']['lat'],0,1) == "-")
    {
        $this->data['main']['lat'] = str_replace("-","",$this->data['main']['lat']);
        $lat    =  $this->data['main']['lat']."&deg; S";
    }
    else
    {
        $lat    = $this->data['main']['lat']."&deg; N"; 
    }
    if(substr($this->data['main']['lon'],0,1) == "-")
    {
        $this->data['main']['lon'] = str_replace("-","",$this->data['main']['lon']);
        $lon    = $this->data['main']['lon']."&deg; W";
    }
    else
    {
        $lon    = $this->data['main']['lon']."&deg; E"; 
    }
    $tmz    = $this->data['main']['timezone'];
    $pob    = $this->data['main']['pob'];
}
else 
{
    if(substr($this->data['main']['latitude'],0,1) == "-")
    {
        $this->data['main']['latitude'] = str_replace("-","",$this->data['main']['latitude']);
        $lat    =  $this->data['main']['latitude']."&deg; S";
    }
    else
    {
        $lat    = $this->data['main']['latitude']."&deg; N"; 
    }
    if(substr($this->data['main']['longitude'],0,1) == "-")
    {
        $this->data['main']['longitude'] = str_replace("-","",$this->data['main']['longitude']);
        $lon    = $this->data['main']['longitude']."&deg; W";
    }
    else
    {
        $lon    = $this->data['main']['longitude']."&deg; E"; 
    }
    $tmz    = $this->data['main']['tmz_words'];
    
    if($this->data['main']['state'] == "" && $this->data['main']['country'] == "")
    {
        $pob    = $this->data['main']['city'];
    }
    else if($this->data['main']['state'] == "" && $this->data['main']['country'] != "")
    {
        $pob    = $this->data['main']['city'].", ".$this->data['main']['country'];
    }
    else
    {
        $pob    = $this->data['main']['city'].", ".$this->data['main']['state'].", ".$this->data['main']['country'];
    }
}
?>
<table class="table table-bordered table-hover table-striped">

	<tr>
		<th>Name</th>
		<td><?php echo $this->data['main']['fname']; ?></td>
	</tr>
	<tr>
		<th>Gender</th>
		<td><?php echo ucfirst($this->data['main']['gender']); ?></td>
	</tr>
	<tr>
		<th>Date Of Birth</th>
		<td><?php 
			$date   = new DateTime($this->data['main']['dob_tob'], new DateTimeZone($tmz));
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
<div class="lead alert alert-dark">Lagna/Ascendant D-1 Chart</div>
<canvas id="horo_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Navamsha D-9 Chart</div>
<canvas id="nav_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Dashamsha D-10 Chart</div>
<canvas id="dash_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Hora D-2 Chart</div>
<canvas id="hora_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Drekkana D-3 Chart</div>
<canvas id="drek_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Chaturthamsa D-4 Chart</div>
<canvas id="chatur_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Saptamsha D-7 Chart</div>
<canvas id="sapt_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Dwadamsha D-12 Chart</div>
<canvas id="dwad_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Shodasamsa D-16 Chart</div>
<canvas id="shod_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Vimsamsa D-20 Chart</div>
<canvas id="vim_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">ChaturVimsamsa D-24 Chart</div>
<canvas id="chatvim_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">SaptaVimsamsa D-27 Chart</div>
<canvas id="saptvim_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Trimsamsa D-30 Chart</div>
<canvas id="trim_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Khavedamsa D-40 Chart</div>
<canvas id="khed_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Akshavvedamsa D-45 Chart</div>
<canvas id="aksh_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<div class="lead alert alert-dark">Shastiamsa D-60 Chart</div>
<canvas id="shast_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-3"></div>
<form>
<?php 

for($i =0;$i<13;$i++)  // 16 divisional charts
{
    $array              = array("Ascendant","Sun","Moon","Mars",
                                "Mercury","Jupiter","Venus",
                                "Saturn","Rahu","Ketu",
                                "Uranus","Neptune","Pluto");
    for($k =0;$k <16;$k++)  // 13 planets
    {
         $shodas         = array("_lagna","_navamsha_sign","_dash",
                                    "_hora","_drekan","_chatur",
                                    "_sapt","_dwad","_shod",
                                    "_vim","_cvim","_saptvim",
                                    "_trim","_khed","_aksh","_shasht");
         $name          = $array[$i].$shodas[$k];
         $value         = $this->data['shodas'][$name];
?>
    <input type="hidden" name="<?php echo $name;   ?>" id="<?php echo strtolower($name); ?>" value="<?php echo $value; ?>" />
<?php
    }
}
?>
</form>
<div class="mb-3"></div>
<?php
if($this->data['main']['chart_type'] == "north")
{
?>
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_horoscope/script/shodas_n.js' ?>">
</script>
<?php
}
else
{
?>
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_horoscope/script/shodas_s.js' ?>">
</script>
<?php 
}
unset($this->data); ?>
</body>

