<html>
 <head>
<style type="text/css">
#asc_canvas{width: 100%;height: auto;}@media (min-width: 768px) {#asc_canvas{width:65%}}
</style>
</head>
<body onload="javascript:draw_horoscope();getAscendant();">
<?php $chart_id = $_GET['chart']; ?>
<div class="mb-3"></div>
<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
$document = JFactory::getDocument(); 
$document->setTitle(strtolower($this->data['fname']).' ascendant chart');
//print_r($this->data);exit;
$id         = $this->data['id'];
$title      = $this->data['title'];
$text       = $this->data['introtext'];
?>
<canvas id="asc_canvas" height="260">
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
<div class="lead alert alert-dark"><?php echo "Your ascendant is ".$title; ?></div>
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
<?php
if($this->data['chart_type'] == "north")
{
?>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/horoscope_n.js' ?>">
</script>
<?php
}
else
{
?>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/horoscope_s.js' ?>">
</script>
<?php 
}
unset($this->data); 
?>
</body>