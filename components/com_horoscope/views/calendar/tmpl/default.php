<script type="text/javascript">
$(function () {
  $('.data-pop').popover({
    container: 'body'
  })
})
$(document).ready(function(){
  $(".data-pop").click(function(){
    var td_id       = document.getElementsByClassName('data-pop')[0].id;
    $(this).toggleClass("bg-success");
  });
});
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
$month          = $date->format('m');$month_in_words        = $date->format('F');
$year           = $date->format('Y');
$first          = new DateTime(date('01-'.$month."-".$year));
$day_of_week    = $first->format('l');
$days_in_month  = $first->format('t');
$day_in_num     = $first->format('w');
?>
<p>Note: Click on date for muhurat. Click again to remove selection. Default location is Ujjain.</p>
<div class="lead alert alert-dark"><?php echo $month_in_words." ".$year; ?></div>
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
            $sunrise        = new DateTime($data['sun_rise_2']); 
            $sunset         = new DateTime($data['sun_set_2']);
            $rahu_start     = new DateTime($data['rahu_start_1']);
            $rahu_end       = new DateTime($data['rahu_end_1']);
            $yama_start     = new DateTime($data['yama_start_1']);
            $yama_end       = new DateTime($data['yama_end_1']);
            $guli_start     = new DateTime($data['guli_start_1']);
            $guli_end       = new DateTime($data['guli_end_1']);
        ?>
        <td id="td_1" class="data-pop" data-toggle="popover" title="Muhurat for <?php echo $sunrise->format('jS F Y'); ?>" data-content="<?php echo "Rahu Kaal: ".$rahu_start->format('h:i:s a')."-".$rahu_end->format('h:i:s a')."\n"; 
                                                                                                                                      echo "Yama Kaal: ".$yama_start->format('h:i:s a')."-".$yama_end->format('h:i:s a')."\n";
                                                                                                                                      echo "Guli Kaal: ".$guli_start->format('h:i:s a')."-".$guli_end->format('h:i:s a')."\n"; ?>">
            <h1 class="text-right"><?php  echo $z;?></h1><p class="text-left text-danger" title="tithi"><?php echo $data[$key] ?></p>
            <p class="text-left" title="sunrise"><img src="images/clipart/sunrise.png" width="20px" height="20px" />&nbsp;<?php echo $sunrise->format('H:i:s'); ?></p><p class="text-left" title="sunset"><img src="images/clipart/sunset.png" width="20px" height="20px" title="sunset" /><?php echo $sunset->format('H:i:s'); ?></p>
        </td>
        <?php
        }
        else if($i == $day_in_num && $day_in_num == 6)
        {
            $sunrise = new DateTime($data['sun_rise_2']); 
            $sunset  = new DateTime($data['sun_set_2']);
            $rahu_start     = new DateTime($data['rahu_start_1']);
            $rahu_end       = new DateTime($data['rahu_end_1']);
            $yama_start     = new DateTime($data['yama_start_1']);
            $yama_end       = new DateTime($data['yama_end_1']);
            $guli_start     = new DateTime($data['guli_start_1']);
            $guli_end       = new DateTime($data['guli_end_1']);
        ?>
         <td id="td_1" class="data-pop" data-toggle="popover" title="Muhurat for <?php echo $sunrise->format('jS F Y'); ?>" data-content="<?php echo "Rahu Kaal: ".$rahu_start->format('h:i:s a')."-".$rahu_end->format('h:i:s a')."\n"; 
                                                                                                                                      echo "Yama Kaal: ".$yama_start->format('h:i:s a')."-".$yama_end->format('h:i:s a')."\n";
                                                                                                                                      echo "Guli Kaal: ".$guli_start->format('h:i:s a')."-".$guli_end->format('h:i:s a')."\n"; ?>">
            <h1 class="text-right"><?php  echo $z;?></h1><p class="text-left text-danger" title="tithi"><?php echo $data[$key] ?></p>
            <p class="text-left" title="sunrise"><img src="images/clipart/sunrise.png" width="20px" height="20px" />&nbsp;<?php echo $sunrise->format('H:i:s'); ?></p><p class="text-left" title="sunset"><img src="images/clipart/sunset.png" width="20px" height="20px" title="sunset" /><?php echo $sunset->format('H:i:s'); ?></p>
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
    unset($data);
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
                $counter1       = $counter+1;
                $sunrise        = new DateTime($data['sun_rise_'.$counter1]);
                $sunset         = new DateTime($data['sun_set_'.$counter1]);
                $rahu_start     = new DateTime($data['rahu_start_'.$counter]);
                $rahu_end       = new DateTime($data['rahu_end_'.$counter]);
                $yama_start     = new DateTime($data['yama_start_'.$counter]);
                $yama_end       = new DateTime($data['yama_end_'.$counter]);
                $guli_start     = new DateTime($data['guli_start_'.$counter]);
                $guli_end       = new DateTime($data['guli_end_'.$counter]);
        ?>
         <td id="td_<?php echo trim($counter); ?>"  class="data-pop" data-toggle="popover" title="Muhurat for <?php echo $sunrise->format('jS F Y'); ?>" data-content="<?php echo "Rahu Kaal: ".$rahu_start->format('h:i:s a')."-".$rahu_end->format('h:i:s a')."\n"; 
                                                                                                                                      echo "Yama Kaal: ".$yama_start->format('h:i:s a')."-".$yama_end->format('h:i:s a')."\n";
                                                                                                                                      echo "Guli Kaal: ".$guli_start->format('h:i:s a')."-".$guli_end->format('h:i:s a')."\n"; ?>">
         <h1 class="text-right"><?php echo $counter;$datacounter = $counter -1;$counter++;$day++; ?></h1><p class="text-left text-danger" title="tithi"><?php echo $newdata[$datacounter] ?></p>
             <p class="text-left" title="sunrise"><img src="images/clipart/sunrise.png" width="20px" height="20px" />&nbsp;<?php echo $sunrise->format('H:i:s'); ?></p><p class="text-left" title="sunset"><img src="images/clipart/sunset.png" width="20px" height="20px" title="sunset" /><?php echo $sunset->format('H:i:s'); ?></p>
         </td>
    <?php
            }
            else if($day ==7)
            {
                $day    = 0;
                $counter1       = $counter+1;
                $sunrise = new DateTime($data['sun_rise_'.$counter1]);
                $sunset  = new DateTime($data['sun_set_'.$counter1]);
                $rahu_start     = new DateTime($data['rahu_start_'.$counter]);
                $rahu_end       = new DateTime($data['rahu_end_'.$counter]);
                $yama_start     = new DateTime($data['yama_start_'.$counter]);
                $yama_end       = new DateTime($data['yama_end_'.$counter]);
                $guli_start     = new DateTime($data['guli_start_'.$counter]);
                $guli_end       = new DateTime($data['guli_end_'.$counter]);
        ?>
         <tr><td id="td_<?php echo trim($counter); ?>" class="data-pop" data-toggle="popover" title="Muhurat for <?php echo $sunrise->format('jS F Y'); ?>" data-content="<?php echo "Rahu Kaal: ".$rahu_start->format('h:i:s a')."-".$rahu_end->format('h:i:s a')."\n"; 
                                                                                                                                      echo "Yama Kaal: ".$yama_start->format('h:i:s a')."-".$yama_end->format('h:i:s a')."\n";
                                                                                                                                      echo "Guli Kaal: ".$guli_start->format('h:i:s a')."-".$guli_end->format('h:i:s a')."\n"; ?>">
                 <h1 class="text-right"><?php echo $counter;$datacounter = $counter - 1;$counter++;$day++; ?></h1><p class="text-left text-danger" title="tithi"><?php echo $newdata[$datacounter] ?></p>
                 <p class="text-left" title="sunrise"><img src="images/clipart/sunrise.png" width="20px" height="20px" />&nbsp;<?php $sunrise = new DateTime($data['sun_rise_'.$counter]); echo $sunrise->format('H:i:s'); ?></p><p class="text-left" title="sunset"><img src="images/clipart/sunset.png" width="20px" height="20px" title="sunset" /><?php $sunset  = new DateTime($data['sun_set_'.$counter]); echo $sunset->format('H:i:s'); ?></p>
             </td>
    <?php
            }
           
        }
        break;
        unset($data);
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
