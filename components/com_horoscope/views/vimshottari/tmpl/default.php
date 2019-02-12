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
//$planet         = array("Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu");
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
</ul><div class="mb-3"></div>
<p class="lead">Dasha at time of birth: <?php echo ucfirst($this->data['main_dob_period']); ?></p>
<p class="lead">Balance of dasha: <?php echo $this->data['balance_of_dasha']; ?></p>
<?php
for($i=0;$i<82;$i++)
{
    echo $this->data[$i][''];
}
 unset($this->data); ?>
