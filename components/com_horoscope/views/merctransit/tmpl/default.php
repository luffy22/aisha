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
//date_default_timezone_set("UTC");
//$dasha_order         = array("ketu","venus","sun","moon","rahu","mars","jupiter","saturn","mercury");
//$a = 0;
$counter        = 0;
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Mars Tranist</div>
<?php
for($i = 0; $i<(count($this->data)/3);$i++)
{
    //echo $this->data["date_".$i];exit;
    $date   = new DateTime(str_replace(".","-",$this->data['date_'.$i])." ".$this->data['time_'.$i], new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
    echo $date->format('d-m-Y')."  ";
    echo $date->format('h:i:s a')." ";
    echo $this->data['sign_'.$i]."<br/>";
}
unset($this->data);
?>
