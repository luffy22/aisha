<html>
 <head>
<style type="text/css">
#asc_canvas{width: 100%;height: auto;}
</style>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/horoscope.js' ?>">
</script>
</head>
<body onload="javascript:draw_horoscope();getAscendant();">
<?php $chart_id = $_GET['chart']; ?>
<ul class="nav nav-pills">
  <li class="nav-item">
     <a class="nav-link" href="<?php echo JURi::base() ?>horoscope?chart=<?php echo $chart_id ?>">Horo Details</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active">Ascendant</a>
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
</ul><div class="mb-2"></div>
<div class="alert alert-info">
    <strong>Horoscope feature is in testing phase</strong></div><div class="mb-2"></div>
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
<canvas id="asc_canvas" height="220">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-2"></div>
<?php

if(strpos($title, "Females"))
{
    $title      = str_replace(" Ascendant Females", "", $title);
}
else
{
    $title      = str_replace(" Ascendant Males","", $title);
}
$text       = $this->data['introtext'];
?>
<div id="<?php echo $this->data['id']; ?>" class="accordion-id"></div>
<div class="breadcrumb lead alert-info"><?php echo "Your Ascendant is ".$title; ?></div>
<?php echo $text; 
for($i=0;$i<3;$i++)  // remove the last 3 elements from the array to avoid confusion
{ array_pop($this->data); } ?>
<form>
<?php
    foreach($this->data as $key=>$value)
    {
  
?>
    <input type="hidden" name="<?php echo strtolower(trim($key)); ?>_sign" id="<?php echo strtolower(trim($key)); ?>_sign" value="<?php echo $value; ?>" />
<?php
    }
?>
</form>