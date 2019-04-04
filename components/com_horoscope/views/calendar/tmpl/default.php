<script type="text/javascript">
$(function () {
  $('.data-pop').popover({
    container: 'body'
  })
})
</script>
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
$key            = key($this->data);
?>
<body>
<?php
$date           = new DateTime(date($key));
$month          = $date->format('m');
$year           = $date->format('Y');
$first          = new DateTime(date('01-'.$month."-".$year));
$day_of_week    = $first->format('l');
$days_in_month  = $first->format('t');
$day_in_num     = $first->format('w');
?>
<table class="table table-bordered table-striped table-responsive">
<tr><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th>
<th>Thursday</th><th>Friday</th><th>Saturday</th></tr>
<?php
getTable($this->data, $day_of_week,$day_in_num, $days_in_month);
?>
</table>
<?php
function getTable($data,$day_of_week,$day_in_num, $days_in_month)
{
    $z = 1;getFirstDate($data,$day_in_num, $days_in_month);
}
function getFirstDate($data, $day_in_num, $days_in_month)
{
   for($i=0; $i< 7; $i++)
   {
       $z           = 1;
       $key         = key($data);
        if($i == $day_in_num && $day_in_num < 6)
        {
        ?>
        <td  class="data-pop" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">
            <h1 class="text-right"><?php  echo $z;?></h1><p class="text-left text-primary" title="tithi"><?php echo $data[$key] ?></p>
            <p class="text-left" title="sunrise"><img src="images/clipart/sunrise.png" width="20px" height="20px" />&nbsp;<?php $sunrise = new DateTime($data['sun_rise_2']); echo $sunrise->format('H:i:s'); ?></p><p class="text-left" title="sunset"><img src="images/clipart/sunset.png" width="20px" height="20px" title="sunset" /><?php $sunset  = new DateTime($data['sun_set_2']); echo $sunset->format('H:i:s'); ?></p>
        </td>
        <?php
        }
        else if($i == $day_in_num && $day_in_num == 6)
        {
        ?>
         <td data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">
             <h1 class="text-right"><?php  echo $z;?></h1><p class="text-left text-primary" title="tithi"><?php echo $data[$key] ?></p>
             <p class="text-left" title="sunrise"><img src="images/clipart/sunrise.png" width="20px" height="20px" width="20px" height="20px" />&nbsp;<?php $sunrise = new DateTime($data['sun_rise_2']); echo $sunrise->format('H:i:s'); ?></p><p class="text-left" title="sunset"><img src="images/clipart/sunset.png" title="sunset" /><?php $sunset  = new DateTime($data['sun_set_2']); echo $sunset->format('H:i:s'); ?></p>
         </td></tr><tr>
        <?php
        }
        else if($i > $day_in_num)
        {
            break;
        }
        else
        {
        ?>
         <td></td>
        <?php
        }
   }
    $z++;
    $day_in_num     = incrementDate($day_in_num);
    getDatesInWeek($data, $z, $day_in_num, $days_in_month);
   
}
function getDatesInWeek($data,$counter,$day, $month)
{
    $newdata       = processArray($data,$month);
    //print_r($newdata);exit;
    //echo $counter." ".$day." ".$month."<br/>";exit;
    for($i=0;$i<7;$i++)
    {
        while($counter <= $month)
        {
            if($day < 7)
            {
    ?>  
         <td class="data-pop" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">
             <h1 class="text-right"><?php echo $counter;$datacounter = $counter -1;$counter++;$day++; ?></h1><p class="text-left text-primary" title="tithi"><?php echo $newdata[$datacounter] ?></p>
             <p class="text-left" title="sunrise"><img src="images/clipart/sunrise.png" width="20px" height="20px" />&nbsp;<?php $sunrise = new DateTime($data['sun_rise_'.$counter]); echo $sunrise->format('H:i:s'); ?></p><p class="text-left" title="sunset"><img src="images/clipart/sunset.png" width="20px" height="20px" title="sunset" /><?php $sunset  = new DateTime($data['sun_set_'.$counter]); echo $sunset->format('H:i:s'); ?></p>
         </td>
    <?php
            }
            else if($day ==7)
            {
                $day    = 0;
    ?>
<tr><td class="data-pop" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">
                 <h1 class="text-right"><?php echo $counter;$datacounter = $counter - 1;$counter++;$day++; ?></h1><p class="text-left text-primary" title="tithi"><?php echo $newdata[$datacounter] ?></p>
                 <p class="text-left" title="sunrise"><img src="images/clipart/sunrise.png" width="20px" height="20px" />&nbsp;<?php $sunrise = new DateTime($data['sun_rise_'.$counter]); echo $sunrise->format('H:i:s'); ?></p><p class="text-left" title="sunset"><img src="images/clipart/sunset.png" width="20px" height="20px" title="sunset" /><?php $sunset  = new DateTime($data['sun_set_'.$counter]); echo $sunset->format('H:i:s'); ?></p>
             </td>
    <?php
            }
           
        }
        break;
    }
    
}
function incrementDate($day_in_num)
{
    if($day_in_num < 6)
    {
        $day_in_num = $day_in_num+1; 
    }
    else
    {
?>      
<?php         
        $day_in_num = 0;
        
    }
    return $day_in_num;
}
function processArray($data, $month)
{
    $newarray       = array();
    $i  = 1;
    foreach($data as $result)
    {
        if($i <= $month)
        {
            $newdata    = array($i => $result);
            $newarray   = array_merge($newarray, $newdata);
            $i++;
        }
        else
        {
            continue;
        }
    }
    return $newarray;
    //print_r($newarray);exit;
}
unset($this->data);
?>
<div class="mb-1"></div>
