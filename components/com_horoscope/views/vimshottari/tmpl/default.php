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
$chart_id = $_GET['chart']; ?>
<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link" href="<?php echo JURi::base() ?>horoscope?chart=<?php echo $chart_id ?>">Horo Details</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo JURi::base() ?>getasc?chart=<?php echo $chart_id ?>">Ascendant</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo JURi::base() ?>getmoon?chart=<?php echo $chart_id ?>">Moon Sign</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo JURi::base() ?>getnakshatra?chart=<?php echo $chart_id ?>">Nakshatra</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo JURi::base() ?>getnavamsha?chart=<?php echo $chart_id ?>">Navamsha</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active">Vimshottari</a>
  </li>
</ul>
<div class="mb-3"></div>
<table class="table table-striped table-hover">
    <tr><th>Balance of dasha:</th><td><?php echo $this->data['balance_of_dasha']; ?></td></tr>
    <tr><th>Main Period(Dasha) at time of birth:</th><td><?php echo ucfirst($this->data['main_dob_period']); ?></td></tr>
    <tr><th>Sub Period(Antardasha) at time of birth</th><td><?php echo ucfirst($this->data['sub_dob_period']); ?></td></tr>
</table>
<div class="mb-3"></div>
<div id="vimshottari">
<h3><?php echo ucfirst($this->data['main_dob_period']) ?> Dasha</h3>
<div>
<table class="table table-bordered table-striped">
    <tr><th>Main Period</th><th>Sub Period</th>
        <th>Start Date</th><th>End Date</th></tr>
    <tr>
        <td><?php echo ucfirst($this->data['main_dob_period']) ?></td>
        <td><?php echo ucfirst($this->data['sub_dob_period']); ?></td>
        <td><?php echo $dob_start->format('dS F Y'); ?></td>
        <td><?php echo $dob_end->format('dS F Y'); ?></td></tr>
<?php
foreach($this->data['get_remain_dasha'] as $dasha)
{    
    $period         = $dasha['year_months_days'];
    $start          = $dob_end->format('dS F Y');
    $dob_end        ->add(new DateInterval($period));
    $end            = $dob_end->format('dS F Y');
    if($dasha['main_period'] == $main)
    {
?>
    <tr>
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
<?php
        unset($main);
        $main               = $dasha['main_period'];
?>
<h3><?php echo ucfirst($dasha['main_period']) ?> Dasha</h3>
<div>
<table class="table table-bordered table-striped">
    <tr><th>Main Period</th><th>Sub Period</th>
        <th>Start Date</th><th>End Date</th></tr>
    <tr>
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
</div></div>
<div class="mb-3"></div>
<?php
unset($this->data);
?>
