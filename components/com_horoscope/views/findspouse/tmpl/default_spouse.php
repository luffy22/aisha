<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
$gender = $this->data['gender'];if($gender == "male"){$planet = "Venus";}else if($gender == "female"){$planet = "Jupiter";}
if($gender == "male"){$spouse = "wife";}else if($gender == "female"){$spouse = "husband";}
$text = $this->data['spouse_text'];
$house  = $this->data['house'];
 if($house=="1"){$house = $house."st";}else if($house=="2"){$house = $house."nd";}else if($house=="3"){$house= $house."rd";}else{$house= $house."th";}
?>
<div class="lead alert alert-dark"><strong>How & Where To find Spouse</strong></div>
<div class="container">
    
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
    <p class="lead">For <?php echo $gender.'s' ?> position of <?php echo $planet ?> is used to know more about future <?php echo $spouse ?>. <?php echo $planet ?> is located in your <?php echo trim($house) ?> house counted from Ascendant(1st House).</p>
    <div class="mb-3"></div>  
    <?php echo str_replace("planet", $planet, $text); ?>
<div class="mb-2"></div>
    <p class="lead strong">Portfolio's associated with <?php echo trim($house); ?> house are the deciding factor for your future <?php echo $spouse ?> to choose you over others.</p>
</div>