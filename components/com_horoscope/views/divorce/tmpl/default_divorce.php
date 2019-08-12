<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
//$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
$chart_id = $_GET['chart'];
$percent            = 0;
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
<body onload="callMe();">
<div class="lead alert alert-dark">Chances of divorce in your horoscope.</div>
<div class="row justify-content-center">
<div class="c100 big" id="percent_checker">
    <span id="percent_value"></span>
    <div class="slice">
        <div class="bar"></div>
        <div class="fill"></div>
    </div>
</div></div>
<p>Note: Current planetary transits and planetary periods are not considered. This software isn't 100% accurate. But a rough idea is possible.</p>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Percentage of Mangal Dosha</div>
<p>Mangal Dosha can lead to divorce. Mars in a problematic location increases anger and frustration. No 
marriage in today's world can survive with constant fights.</p>
<?php
 if(((int)$this->data['mangaldosha']) > 50)
 {
?>
<p>There is <?php echo $this->data['mangaldosha']; ?><span>&#37;</span> Mangal Dosha in your chart.</p>
<?php
}
else if(((int)$this->data['mangaldosha']) == 50)
 {
?>
<p>There is <?php echo $this->data['mangaldosha']; ?><span>&#37;</span> Mangal Dosha in your chart.</p>
<?php
}
 else {
?>
<p>There is nominal <?php echo $this->data['mangaldosha']; ?><span>&#37;</span> Mangal Dosha in your chart.</p>
<?php   
}
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Ascendant in your chart</div>
<p>Chances of divorce rise in certain ascendant and with bad planets influencing ascendant.</p>
<p>Your ascendant is <?php echo $this->data['asc_sign']; ?>.</p>
<p>
    There is 
<?php
    $count  = count($this->data['house_1']);
    if($count == "0")
    {
        echo " no planet ";
    }
    else
    {
        //echo $count;exit;
        for($i = 0; $i < $count;$i++)
        {
           if($i < $count-1)
           {
               echo $this->data['house_1'][$i].", ";
           }
           else
           {
               echo $this->data['house_1'][$i]." ";
           }
        }
    }
?>
    in your 1st house(ascendant). 
</p>
<div class="mb-3"></div>
<p>
    There 
<?php
    $count  = count($this->data['aspect_1']);
    if($count == "0")
    {
        echo " are no aspect ";
    }
    else
    {
        echo " is aspect of ";
        for($i = 0; $i < $count;$i++)
        {
           if($i < $count-1)
           {
               echo $this->data['aspect_1'][$i].", ";
           }
           else
           {
               echo $this->data['aspect_1'][$i]." ";
           }
        }
    }
?>
    on your 1st house(ascendant). 
</p>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Influence on the 7th House</div>
<p>7th house is the house of marriage. One of the leading factors of divorce is bad 
condition of 7th house.</p>
<p>
    There is 
<?php
    $count  = count($this->data['house_7']);
    if($count == "0")
    {
        echo " no planet ";
    }
    else
    {
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
    }
?>
    in your 7th house. 
</p>

<div class="mb-3"></div>
<p>
    There 
<?php
    $count  = count($this->data['aspect_7']);
    if($count == "0")
    {
        echo " are no aspect ";
    }
    else
    {
        echo " is aspect of ";
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
    }
?>
    on your 7th house. 
</p>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Influence on the 8th House</div>
<p>Biggest factor for divorce is the 8th house which deals with divorce and court cases. 
</p>
<p>
    There  
<?php
    $count  = count($this->data['house_8']);
    if($count == "0")
    {
        echo " no planets ";
    }
    else
    {
        echo " is ";
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
    }
?>
    in your 8th house. 
</p>
<div class="mb-3"></div>
<p>
    There  
<?php
    $count  = count($this->data['aspect_8']);
    //echo $count;exit;
    if($count == "0")
    {
        echo " is no aspect ";
    }
    else
    {
        echo " is aspect of ";
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
    }
?>
    on your 8th house. 
</p>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Influence on the 12th House</div>
<p>12th house rules over sex and bedroom pleasures. Divorce rate today has 
gone up due to partners complaining of insufficient romance and sex in marriage life.</p>
<p>
    There is 
<?php
    $count  = count($this->data['house_12']);
    if($count == "0")
    {
        echo " no planets ";
    }
    else
    {
        for($i = 0; $i < $count;$i++)
        {
           if($i < $count-1)
           {
               echo $this->data['house_12'][$i].", ";
           }
          else
           {
               echo $this->data['house_12'][$i]." ";
           }
        }
    }
?>
    in your 12th house. 
</p>
<div class="mb-3"></div>
<p>
    There is 
<?php
    $count  = count($this->data['aspect_12']);
    if($count == "0")
    {
        echo " no aspects ";
    }
    else
    {
        echo " aspect of ";
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
    }
?>
    on your 12th house. 
</p>
<?php 
    // mangal dosha- 15%
    if(((int)$this->data['mangaldosha']) > 50)
    {
        $percent            = $percent+15;
    }
    else if(((int)$this->data['mangaldosha']) == 50)
    {
        $percent            = $percent+10;
    }
    else
    {
        $percent            = $percent+0;
    }
    // ascendant= percent 15%
    if($this->data['asc_sign'] == "Aries"|| $this->data['asc_sign'] == "Libra"||
       $this->data['asc_sign'] == "Cancer")
    {
        $percent            = $percent+10;

    }
    if(in_array("Mars", $this->data['house_1']) || in_array("Rahu", $this->data['house_1'])
            ||in_array("Ketu", $this->data['house_1'])||in_array("Saturn", $this->data['house_1']))
    {
        $percent            = $percent+10;
    }
    if(in_array("Mars", $this->data['aspect_1']) || in_array("Rahu", $this->data['aspect_1'])
            ||in_array("Ketu", $this->data['aspect_1'])||in_array("Saturn", $this->data['aspect_1']))
    {
        $percent            = $percent+10;
    }
    if(in_array("Jupiter", $this->data['house_1'])|| in_array("Jupiter", $this->data['aspect_1']))
    {
        $percent            = $percent - 10;
    }
    // house 7 20% divorce chances
    if(in_array("Mars", $this->data['house_7']))
    {
        $percent            = $percent+10;
    }
    else if(in_array("Ketu", $this->data['house_7']) || in_array("Rahu", $this->data['house_7']))
    {
        $percent            = $percent+10;
    }
    else
    {
        $percent            = $percent+0;
    }
    // house 8 40% divorce chance
    if(in_array("Mars", $this->data['house_8'])|| in_array("Mars",$this->data['aspect_8']))
    {
        $percent            = $percent+10;
    }
    if(in_array("Venus", $this->data['house_8']))
    {
        $percent            = $percent+10;
    }
    if(in_array("Rahu", $this->data['house_8'])|| in_array("Rahu", $this->data['aspect_8']))
    {
        $percent            = $percent+10;
    }
    if(in_array("Ketu", $this->data['house_8']))
    {
        $percent            = $percent+10;
    }
    if(in_array("Sun", $this->data['house_8'])|| in_array("Sun", $this->data['aspect_8']))
    {
        $percent            = $percent+5;
    }
     if(in_array("Saturn", $this->data['house_8'])|| in_array("Saturn", $this->data['aspect_8']))
    {
        $percent            = $percent +5;
    }
    if(in_array("Jupiter", $this->data['house_8'])|| in_array("Jupiter", $this->data['aspect_8']))
    {
        $percent            = $percent - 10;
    }
     // 12th house 10% divorce rate
    if(in_array("Sun", $this->data['house_12']) && in_array("Venus", $this->data['house_12']))
    {
        $percent            = $percent+10;
    }
    if(in_array("Rahu", $this->data['house_12']) || in_array("Rahu",$this->data['aspect_12']))
    {
        $percent            = $percent+10;
    }
    if(in_array("Saturn", $this->data['house_12']) || in_array("Saturn",$this->data['aspect_12']))
    {
        $percent            = $percent+10;
    }
    if(in_array("Mars", $this->data['house_12']) && in_array("Venus",$this->data['house_12']))
    {
        $percent            = $percent+5;
    }
?>  
<form>
    <input type="hidden" value="<?php echo $percent; ?>" id="divorce_rate" />
</form>
<div class="mb-3"></div>
<link rel="stylesheet" href="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/circle.css' ?>" type="text/css" />
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/divorce.js' ?>">
</script>
<?php unset($this->data); ?>
</body>