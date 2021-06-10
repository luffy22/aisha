<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
//print_r($this->data);exit;
$dob_start              = new DateTime($this->data['dob_sub_start']);
$dob_end                = new DateTime($this->data['dob_sub_end']);
$main                   = $this->data['main_dob_period'];
//$dasha_order         = array("ketu","venus","sun","moon","rahu","mars","jupiter","saturn","mercury");
//$a = 0;
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
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <a href="<?php echo JUri::base().'register' ?>">Register</a> with us to save horoscope permanently
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
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
<ul class="list-group">
    <li class="list-group-item"><strong>Balance of dasha</strong><br/>
    <?php echo $this->data['balance_of_dasha']; ?></li>
    <li class="list-group-item"><strong>Main Period(Dasha) at time of birth</strong><br/>
    <?php echo ucfirst($this->data['main_dob_period']); ?></li>
    <li class="list-group-item"><strong>Sub Period(Antardasha) at time of birth</strong><br/>
    <?php echo ucfirst($this->data['sub_dob_period']); ?></li>
</ul>
<div class="mb-3"></div>
<div class="lead alert alert-dark"><?php echo ucfirst($this->data['main_dob_period']) ?> Dasha</div>
<?php 
    $planet     = ucfirst($this->data['main_dob_period']);
    if($this->data[$planet."_sign"] == $this->data[$planet."_navamsha_sign"])
    {
?>
        <p class="lead">&nbsp;&nbsp;<?php echo $planet ?> is vargottama in your chart. This dasha would be a golden time for you.</p>
<?php
    }
?>
<div class="table-responsive">
<table class="table table-bordered table-striped">
    <tr><th>Age</th><th>Main Period</th><th>Sub Period</th>
        <th>Start Date</th><th>End Date</th></tr>
    <?php   $year_from = $dob_start->diff($dob_start);  $year_to        = $dob_start->diff($dob_end); ?>
    <tr>
        <td><?php echo $year_from->y ?> to <?php echo $year_to->y; ?></td>
        <td><?php echo ucfirst($this->data['main_dob_period']) ?></td>
        <td><?php echo ucfirst($this->data['sub_dob_period']); ?></td>
        <td><?php echo $dob_start->format('dS F Y'); ?></td>
        <td><?php echo $dob_end->format('dS F Y');?></td></tr>
<?php
foreach($this->data['get_remain_dasha'] as $dasha)
{    
    $period         = $dasha['year_months_days'];
    $year_from      = $dob_end->diff($dob_start);
    $start          = $dob_end->format('dS F Y');
    $dob_end        ->add(new DateInterval($period));
    $year_to        = $dob_start->diff($dob_end); 
    $end            = $dob_end->format('dS F Y');
    if($dasha['main_period'] == $main)
    {
?>
    <tr>
        <td><?php echo $year_from->y ?> to <?php echo $year_to->y; ?></td>
        <td><?php echo ucfirst($dasha['main_period']); ?></td>
        <td><?php echo ucfirst($dasha['sub_period']); ?></td>
        <td><?php echo $start; ?></td>
        <td><?php echo $end; ?></td>
    </tr>
<?php
    }
    else
    {
?>
</table>
</div>
<div class="mb-3"></div>
<?php
    unset($main);
    $main               = $dasha['main_period'];
?>
<div class="lead alert alert-dark"><?php echo ucfirst($dasha['main_period']) ?> Dasha</div>
<?php 
$planet     = ucfirst($dasha['main_period']);
    if($this->data[$planet."_sign"] == $this->data[$planet."_navamsha_sign"])
    {
?>
        <p class="lead">&nbsp;&nbsp;<?php echo $planet ?> is vargottama in your chart. This dasha would be golden time for you.</p>
<?php
    }
?>
<div class="table-responsive">
<table class="table table-bordered table-striped">
    <tr><th>Age</th><th>Main Period</th><th>Sub Period</th>
        <th>Start Date</th><th>End Date</th></tr>
    <tr>
        <td><?php echo $year_from->y ?> to <?php echo $year_to->y; ?></td>
        <td><?php echo ucfirst($dasha['main_period']); ?></td>
        <td><?php echo ucfirst($dasha['sub_period']); ?></td>
        <td><?php echo $start; ?></td>
        <td><?php echo $end; ?></td>
    </tr>
<?php
    }
}
?>
</table>
</div>
<div class="mb-3"></div>
<?php
unset($this->data);
?>
