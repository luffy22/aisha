<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
$percent        =  (int)$this->data['asc_percent']+(int)$this->data['moon_percent']+
                    (int)$this->data['ven_percent']+(int)$this->data['nav_percent'];
//$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
?>
<div class="lead alert alert-dark"><strong>Mangal Dosha Calculator</strong></div>
    
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
			$date   = new DateTime($this->data['dob_tob'], new DateTimeZone($this->data['timezone']));
			echo $date->format('dS F Y'); ?></td>
	</tr>
	<tr>
		<th>Time Of Birth</th>
		<td><?php echo $date->format('H:i:s'); ?></td>
	</tr>
	<tr>
		<th>Place Of Birth</th>
		<td><?php echo $this->data['pob']; ?></td>
	</tr>
	<tr>
		<th>Latitude</th>
		<td><?php echo $this->data['lat']; ?></td>
	</tr>
	<tr>
		<th>Longitude</th>
		<td><?php echo $this->data['lon']; ?></td>
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
<div class="lead alert alert-dark">How is Mangal Dosha Formed?</div>
<p>Mangal Dosha is formed when Mars is placed in 1<sup>st</sup> House, 2<sup>nd</sup> House, 4<sup>th</sup> House, 
7<sup>th</sup> House, 8<sup>th</sup> House or 12<sup>th</sup> House from Ascendant, Moon or Venus in main chart. Navamsha 
chart is used to judge marriage of a person. So placement of Mars 
in navamsha chart is also equally important in judging Mangal Dosha.</p>
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
    &nbsp;which is mild. Some care is advised in marriage. 
<?php
}
else if($percent == "50")
{
?>
    &nbsp;which is moderate. Some care, compromise and understanding are required for marriage to last. 
<?php
}
else if($percent == "75")
{
?>
    &nbsp;which is above average. Marriage requires a lot of care, concern, compromise and understanding. 
    If you are not careful than things could turn bad in marriage.
<?php
}
else if($percent == "100")
{
?>
    &nbsp;which is a lot. Marriage requires a lot of care, concern, compromise and understanding. 
    If you are not careful than things could turn bad in marriage.
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
<?php unset($this->data); ?>