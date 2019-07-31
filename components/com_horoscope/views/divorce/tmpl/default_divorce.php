<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
//$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
$chart_id = $_GET['chart'];
$percent            = 0;
if(isset($_GET['back']) && $_GET['back'] =='mdosha')
{
?>
<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link" href="<?php echo JURi::base() ?>horoscope?chart=<?php echo $chart_id ?>" title="navigate to horoscope main page"><i class="fas fa-home"></i> Horo</a>
  </li>
  </ul>
<?php
}
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Chances of divorce in your chart</div>
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
                    $date   = new DateTime($this->data['dob_tob'], new DateTimeZone($this->data['timezone']));
                    echo $date->format('dS F Y'); ?></td>
    </tr>
    <tr>
            <th>Time Of Birth</th>
            <td><?php echo $date->format('H:i:s'); ?></td>
    </tr>
    <tr>
            <th>Place Of Birth</th>
            <td><?php echo $this->data['pob']; ?></td>
    </tr>
    <tr>
        <th>Latitude</th>
        <td><?php 
            if(substr($this->data['lat'],0,1) == "-")
            {
                $this->data['lat'] = str_replace("-","",$this->data['lat']);
                echo $this->data['lat']."&deg; S";
            }
            else
            {
                echo $this->data['lat']."&deg; N"; 
            }
            ?>
        </td>
    </tr>
    <tr>
        <th>Longitude</th>
        <td>
            <?php
            if(substr($this->data['lon'],0,1) == "-")
            {
                $this->data['lon'] = str_replace("-","",$this->data['lon']);
                echo $this->data['lon']."&deg; W";
            }
            else
            {
                echo $this->data['lon']."&deg; E"; 
            }
            ?>
        </td>
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
<div class="lead alert alert-dark">Percentage of Mangal Dosha</div>
<p>Mangal Dosha can lead to divorce. Mars in a problematic location increases anger and frustration. No 
marriage in today's world can survive with constant fights.</p>
<?php
 if(((int)$this->data['mangaldosha']) > 50)
 {
?>
<p>There is <?php echo $this->data['mangaldosha']; ?><span>&#37;</span> Mangal Dosha in your chart. This could spell trouble in your married life.</p>
<?php
    $percent        = $percent+20;
}
else if(((int)$this->data['mangaldosha']) == 50)
 {
?>
<p>There is <?php echo $this->data['mangaldosha']; ?><span>&#37;</span> Mangal Dosha in your chart. Some problems are possible in marriage due to Mangal Dosha.</p>
<?php
    $percent        = $percent+10;
}
 else {
?>
<p>There is nominal <?php echo $this->data['mangaldosha']; ?><span>&#37;</span> Mangal Dosha in your chart. Divorce is less likely due to Mangal Dosha.</p>
<?php   
    $percent          = $percent+0;
}
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Planets in the 7th House</div>
<p>Chances of problems in marriage rise if malefic planets like Mars, Saturn, Rahu or Ketu occupy 7th house. Sun can cause ego problems with marriage partner in 7th house. 
    Mercury can lead to arguments but couple stays together. Moon, Jupiter and Venus in 7th house generally suggest good relation with spouse.</p>
<p>
    There is 
<?php
    $count  = count($this->data['house_7']);
    //echo $count;exit;
    for($i = 0; $i < $count;$i++)
    {
       if($i < $count-1)
       {
           echo $this->data['house_7'][$i].", ";
       }
       else
       {
           echo $this->data['house_7'][$i]." ";
       }
    }
?>
    in your 7th house. 
</p>
<?php
    if(in_array("Sun", $this->data['house_7']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Moon", $this->data['house_7']))
    {
        $percent = $percent+0;
    }
    if(in_array("Mars", $this->data['house_7']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Mercury", $this->data['house_7']))
    {
        $percent = $percent+0;
    }
    if(in_array("Jupiter", $this->data['house_7']))
    {
        $percent = $percent+0;
    }
    if(in_array("Venus", $this->data['house_7']))
    {
        $percent = $percent+0;
    }
    if(in_array("Saturn", $this->data['house_7']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Rahu", $this->data['house_7']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Ketu", $this->data['house_7']))
    {
        $percent = $percent+2.5;
    }
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Aspects on the 7th House</div>
<p>Aspects on the 7th house can increase or decrease problems with marriage partner. Aspect of 
benefic planets like Moon, Jupiter and Venus mean there is more understanding and less fights. Aspect of planets like 
Sun, Mars, Saturn, Rahu or Ketu increase problems in marriage life. </p>
<p>
    There is aspect of 
<?php
    $count  = count($this->data['aspect_7']);
    //echo $count;exit;
    for($i = 0; $i < $count;$i++)
    {
       if($i < $count-1)
       {
           echo $this->data['aspect_7'][$i].", ";
       }
       else
       {
           echo $this->data['aspect_7'][$i]." ";
       }
    }
?>
    on your 7th house. 
</p>
<?php
    if(in_array("Sun", $this->data['aspect_7']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Moon", $this->data['aspect_7']))
    {
        $percent = $percent-2.5;
    }
    if(in_array("Mars", $this->data['aspect_7']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Mercury", $this->data['aspect_7']))
    {
        $percent = $percent-2.5;
    }
    if(in_array("Jupiter", $this->data['aspect_7']))
    {
        $percent = $percent-2.5;
    }
    if(in_array("Venus", $this->data['aspect_7']))
    {
        $percent = $percent-2.5;
    }
    if(in_array("Saturn", $this->data['aspect_7']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Rahu", $this->data['aspect_7']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Ketu", $this->data['aspect_7']))
    {
        $percent = $percent+2.5;
    }
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Planets in the 8th House</div>
<p>Biggest factor for divorce is the 8th house which deals with divorce and court cases. 
Having planets like Mars, Venus, Rahu or Ketu spells trouble in marriage life. Planets like Sun, Moon, Jupiter, 
Mercury and Saturn resist divorce unless its absolutely necessary or other planets influence them.</p>
<p>
    There is 
<?php
    $count  = count($this->data['house_8']);
    //echo $count;exit;
    for($i = 0; $i < $count;$i++)
    {
       if($i < $count-1)
       {
           echo $this->data['house_8'][$i].", ";
       }
       else
       {
           echo $this->data['house_8'][$i]." ";
       }
    }
?>
    in your 8th house. 
</p>
<?php
    if(in_array("Sun", $this->data['house_8']))
    {
        $percent = $percent+0;
    }
    if(in_array("Moon", $this->data['house_8']))
    {
        $percent = $percent+0;
    }
    if(in_array("Mars", $this->data['house_8']))
    {
        $percent = $percent+5;
    }
    if(in_array("Mercury", $this->data['house_8']))
    {
        $percent = $percent+0;
    }
    if(in_array("Jupiter", $this->data['house_8']))
    {
        $percent = $percent+0;
    }
    if(in_array("Venus", $this->data['house_8']))
    {
        $percent = $percent+5;
    }
    if(in_array("Saturn", $this->data['house_8']))
    {
        $percent = $percent+0;
    }
    if(in_array("Rahu", $this->data['house_8']))
    {
        $percent = $percent+5;
    }
    if(in_array("Ketu", $this->data['house_8']))
    {
        $percent = $percent+5;
    }

?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Aspects on the 8th House</div>
<p>Aspects on the 8th house especially of certain planets can greatly increase chances of divorce. Aspect of Jupiter and Venus. Aspect of planets 
like Rahu, Mars or Saturn can increase chances of divorce multi-fold.</p>
<p>
    There is aspect of 
<?php
    $count  = count($this->data['aspect_8']);
    //echo $count;exit;
    for($i = 0; $i < $count;$i++)
    {
       if($i < $count-1)
       {
           echo $this->data['aspect_8'][$i].", ";
       }
       else
       {
           echo $this->data['aspect_8'][$i]." ";
       }
    }
?>
    on your 8th house. 
</p>
<?php
    if(in_array("Sun", $this->data['aspect_8']))
    {
        $percent = $percent+5;
    }
    if(in_array("Moon", $this->data['aspect_8']))
    {
        $percent = $percent+0;
    }
    if(in_array("Mars", $this->data['aspect_8']))
    {
        $percent = $percent+5;
    }
    if(in_array("Mercury", $this->data['aspect_8']))
    {
        $percent = $percent+0;
    }
    if(in_array("Jupiter", $this->data['aspect_8']))
    {
        $percent = $percent-5;
    }
    if(in_array("Venus", $this->data['aspect_8']))
    {
        $percent = $percent+0;
    }
    if(in_array("Saturn", $this->data['aspect_8']))
    {
        $percent = $percent+5;
    }
    if(in_array("Rahu", $this->data['aspect_8']))
    {
        $percent = $percent+5;
    }
    if(in_array("Ketu", $this->data['aspect_8']))
    {
        $percent = $percent+0;
    }
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Planets in the 12th House</div>
<p>12th house rules over sex and bedroom pleasures. Divorce today have 
gone up due to partners complaining of insufficient romance and sex in marriage life. Venus is the planet of 
romance and sex. Placement of Venus or 7th house lord in 12th house with malefics like 
Sun, Mars, Saturn, Rahu or Ketu spells troubles for sex and romance in marriage life.</p>
<p>
    There is 
<?php
    $count  = count($this->data['house_12']);
    for($i = 0; $i < $count;$i++)
    {
       if($i < $count-1)
       {
           echo $this->data['house_12'][$i].", ";
       }
       else if($i > $count-1)
       {
           echo " no planet ";
       }
       else
       {
           echo $this->data['house_12'][$i]." ";
       }
    }
?>
    in your 12th house. 
</p>
<?php
    if(in_array("Sun", $this->data['house_12']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Moon", $this->data['house_12']))
    {
        $percent = $percent+0;
    }
    if(in_array("Mars", $this->data['house_12']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Mercury", $this->data['house_12']))
    {
        $percent = $percent+0;
    }
    if(in_array("Jupiter", $this->data['house_12']))
    {
        $percent = $percent+0;
    }
    if(in_array("Venus", $this->data['house_12']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Saturn", $this->data['house_12']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Rahu", $this->data['house_12']))
    {
        $percent = $percent+0;
    }
    if(in_array("Ketu", $this->data['house_12']))
    {
        $percent = $percent+0;
    }
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Aspects on the 12th House</div>
<p>Aspects on the 12th house can increase or decrease romance and sex in married life. Aspect of Venus is 
desirable. Rest all planets either delay or lessen romance and sex in married life.</p>
<p>
    There is aspect of 
<?php
    $count  = count($this->data['aspect_12']);
    //echo $count;exit;
    for($i = 0; $i < $count;$i++)
    {
       if($i < $count-1)
       {
           echo $this->data['aspect_12'][$i].", ";
       }
       else
       {
           echo $this->data['aspect_12'][$i]." ";
       }
    }
?>
    on your 12th house. 
</p>
<?php
    if(in_array("Sun", $this->data['aspect_12']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Moon", $this->data['aspect_12']))
    {
        $percent = $percent+0;
    }
    if(in_array("Mars", $this->data['aspect_12']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Mercury", $this->data['aspect_12']))
    {
        $percent = $percent+0;
    }
    if(in_array("Jupiter", $this->data['aspect_12']))
    {
        $percent = $percent+0;
    }
    if(in_array("Venus", $this->data['aspect_12']))
    {
        $percent = $percent-2.5;
    }
    if(in_array("Saturn", $this->data['aspect_12']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Rahu", $this->data['aspect_12']))
    {
        $percent = $percent+2.5;
    }
    if(in_array("Ketu", $this->data['aspect_12']))
    {
        $percent = $percent+2.5;
    }
?>
<div class="mb-3"></div>
<link rel="stylesheet" href="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/circle.css' ?>" type="text/css" />
<?php unset($this->data); ?>
