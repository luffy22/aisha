<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
$percent        =  (int)$this->data['asc_percent']+(int)$this->data['moon_percent']+
                    (int)$this->data['ven_percent']+(int)$this->data['nav_percent'];
//$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
$chart_id = $_GET['chart'];
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
<div class="lead alert alert-dark">Is there Mangal Dosha in your chart?</div>
<table class="table table-bordered table-striped">
    <tr>
        <td>From Ascendant in Main Chart</td>
        <td><?php echo ucfirst($this->data['asc_dosha']); ?></td>
    </tr>
    <tr>
        <td>From Moon in Main Chart</td>
        <td><?php echo ucfirst($this->data['moon_dosha']); ?></td>
    </tr>
    <tr>
        <td>From Venus in Main Chart</td>
        <td><?php echo ucfirst($this->data['ven_dosha']); ?></td>
    </tr>
    <tr>
        <td>From Ascendant in Navamsha Chart</td>
        <td><?php echo ucfirst($this->data['nav_dosha']); ?></td>
    </tr>
</table>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Percentage of Mangal Dosha in your chart</div>
<div class="row justify-content-center">
<div class="c100 p<?php echo $percent; ?> big">
    <span><?php echo $percent; ?>%</span>
    <div class="slice">
        <div class="bar"></div>
        <div class="fill"></div>
    </div>
</div></div>
<div class="mb-3"></div>
<p>There is <?php echo $percent; ?><span>&#37;</span> Mangal Dosha in your chart
<?php
if($percent == "0")
{
?>
    .&nbsp;You can rest easy. Marriage doesn't suffer due to Mangal Dosha in your case.
<?php
}
else if($percent == "25")
{
?>
    &nbsp;which is mild. Mars won't cause any problems in your married life.  
<?php
}
else if($percent == "50")
{
?>
    &nbsp;which is moderate. Some care and compromise should avoid any troubles in marriage due to Mars. 
<?php
}
else if($percent == "75")
{
?>
    &nbsp;which is above average. Mars could cause problems in married life. Its essential to 
    control temper around spouse or else results could be disastrous. 
<?php
}
else if($percent == "100")
{
?>
    &nbsp;which is a lot. Mars could cause serious problems in married life. Anger, ego and 
    hatred need to be kept in check in marriage or else results could be disastrous. Also important is patience, calmness and compromise 
    to make marriage work.
<?php
}
?>
</p>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Co-tenants of Mars</div>
<?php 
if($this->data['coten_count'] > 0)
{
?>
<p>Co-tenants who occupy same sign as Mars can greatly increase or decrease effects of 
Mangal Dosha in a horoscope. Below are the co-tenants of Mars in your horoscope: </p>
<?php
}
else
{
?>
<p>There are no planets which occupy same house as Mars in your Main Chart</p>
<?php
}
for($i=0;$i<$this->data['coten_count'];$i++)
{
?>
<p><strong><?php echo $this->data['coplanet_'.$i] ?>: </strong>
<?php echo $this->data['coplanet_'.$i.'_details'] ?></p>
<?php
}
?>
<p><strong>Note: Only co-tenancy of 9 planets in traditional Vedic Astrology are analyzed.</strong></p>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Aspects on Mars</div>
<?php
if($this->data['asp_count'] > 0)
{
?>
<p>Aspects on Mars can also increase or decrease effects of Mangal Dosha in a horoscope. 
    Below are 
<?php 
if($this->data['asp_count'] > 1) 
  {echo "planets";}
else
    {echo "planet";} ?>&nbsp;which cast an aspect on your Mars: </p>
<?php
}
else
{
?>
<p>There are no planets aspecting Mars in your Main Chart.</p>
<?php
}
for($i=0;$i<$this->data['asp_count'];$i++)
{
?>
<p><strong><?php echo $this->data['aspect_'.$i] ?>: </strong>
<?php echo $this->data['aspect_'.$i.'_details'] ?></p>
<?php
}
?>
<p><strong>Note: Only aspects of 9 planets in traditional Vedic Astrology are analyzed.</strong></p>
<div class="mb-3"></div>
<link rel="stylesheet" href="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/circle.css' ?>" type="text/css" />
<?php unset($this->data); ?>
