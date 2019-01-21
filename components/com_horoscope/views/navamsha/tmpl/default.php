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
$a = 0;
?>
<html>
 <head>
<style type="text/css">
#navamsha_canvas{width: 100%;height: auto;}
</style>
 </head>
 <body onload="javascript:draw_horoscope();getNavamsha();">
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
    <a class="nav-link" href="<?php echo JURi::base() ?>getnakshatra?chart=<?php echo $chart_id ?>">Nakshatra</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active">Navamsha</a>
  </li>
</ul><div class="mb-2"></div>
<canvas id="navamsha_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-2"></div>
<p class="float-sm-right">Vargottama planet gives good results in its <a href="<?php echo JURi::base() ?>main/336-vimshottari-dasha" target="_blank">Vimshottari Dasha</a> Period</p>
<table class="table table-bordered table-striped">
    <tr>
        <th>Planet</th>
        <th>Sign</th>
        <th>Navamsha</th>
        <th>Vargottama</th>
    </tr>
<?php 
   foreach($this->data as $key => $data)
    {
        
        if(($a % 2) == 0)
        {
            $new_key1   = $key;
            $new_val1   = $data;
?>
    <tr>
        <td><?php echo $new_key1; ?></td>
        <td><?php echo $new_val1; ?></td>
        
<?php
        }
        else if((($a % 2) == 1))
        {
            $new_key2   = $key;
            $new_val2   = $data;
?>
        
        <td id="<?php echo strtolower($new_key1) ?>_sign" value="<?php echo $new_val2; ?>"><?php echo $new_val2; ?></td>
<?php 
        $new_key2    = str_replace("_navamsha_sign","",$new_key2);
        if(($new_key2 == $new_key1)&&($new_val2 == $new_val1))
        {
?>
        <td><?php echo "Yes"; ?></td>
<?php
        }
        else{
?>
         <td><?php echo "No"; ?></td>
        <?php
        }
        ?>
    </tr>
<?php
        }
        $a++;
    }
?>
</table>
<?php unset($this->data); ?>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/horoscope.js' ?>">
</script>
 </body>