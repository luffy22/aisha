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
$id         = $this->data['id'];
$title      = $this->data['title'];
$text       = $this->data['introtext'];
?>
<?php $chart_id = $_GET['chart']; ?>
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
    <a class="nav-link active">Nakshatra</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo JURi::base() ?>getnavamsha?chart=<?php echo $chart_id ?>">Navamsha</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="<?php echo JURi::base() ?>getvimshottari?chart=<?php echo $chart_id ?>">Vimshottari</a>
  </li>
</ul><div class="mb-2"></div>
<div id="<?php echo $this->data['id']; ?>" class="accordion-id"></div>
<div class="lead alert alert-dark"><?php echo "You are born with Moon in ".$title ?></div>
<div class="mb-2"></div>
<?php echo $text; ?>
<?php unset($this->data); ?>
