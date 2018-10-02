<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
$gender = $this->data['gender'];if($gender == "male"){$planet = "Venus";}else if($gender == "female"){$planet = "Jupiter";}
$text_1 = $this->data['0']['spouse_text'];
$text_2 = $this->data['1']['spouse_text'];
$house  = $this->data['house'];if($house < 7){$house_7 = (int)$house + 6;}else{$house_7 = (int)$house-6;}
$text_2 = str_replace("planet", $planet, $text_2); 
if($house=="1"){$house = $house."st";}else if($house=="2"){$house = $house."nd";}else if($house=="3"){$house= $house."rd";}else{$house= $house."th";}
if($house_7=="1"){$house_7 = $house_7."st";}else if($house_7=="2"){$house_7 = $house_7."nd";}else if($house_7=="3"){$house_7= $house_7."rd";}else{$house_7= $house_7."th";}
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
<div class="mb-2"></div>
<div class="alert alert-info">
<p class="lead strong">For <?php echo $gender.'s' ?> position of <?php echo $planet ?> is used to know more about future spouse.</p></div>
<ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link" id="pills-1st-tab" data-toggle="pill" href="#pills-1st" role="tab" aria-controls="pills-1st" aria-selected="true">1st House</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-7th-tab" data-toggle="pill" href="#pills-7th" role="tab" aria-controls="pills-7th" aria-selected="false">7th House</a>
  </li>
</ul>
<div class="tab-content">
  <div class="tab-pane show active" id="pills-1st" role="tabpanel" aria-labelledby="pills-1st-tab">
    <p class="lead strong"><?php echo $planet ?> is located in your <?php echo trim($house) ?> house counted from Ascendant(1st House).</p>
    <div class="mb-2"></div>  
    <?php echo str_replace("planet", $planet, $text_1); ?></div>
    <div class="tab-pane" id="pills-7th" role="tabpanel" aria-labelledby="pills-7th-tab">
        <div class="lead strong">Counted from 7th House, <?php echo $planet ?> is located in your <?php echo trim($house_7) ?> house.</div>
        <div class="mb-2"></div>  
        <?php echo str_replace("future spouse can be found","counted from 7th House, future spouse can be found", $text_2); ?></div>
</div>
