<html>
 <head>
     <title>Get Horoscope Details</title>
<!-- <style type="text/css">
#horo_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#horo_canvas{width:65%}}
</style>-->
</head>
<body onload="callMe();">
<?php
$document = JFactory::getDocument(); 
$str        = explode(" ",$this->data['fname']);
$document->setTitle(strtolower($str[0]).' late marriage chances');
//print_r($this->data);exit;
$percent        = 0;
$chart_id = $_GET['chart']; //echo $chart_id;exit;
$type       = $this->data['chart_type'];//echo $type;exit;
//print_r($this->data);exit;

if(array_key_exists("timezone", $this->data))
{
    if(substr($this->data['lat'],0,1) == "-")
    {
        $this->data['lat'] = str_replace("-","",$this->data['lat']);
        $lat    =  $this->data['lat']."&deg; S";
    }
    else
    {
        $lat    = $this->data['lat']."&deg; N"; 
    }
    if(substr($this->data['lon'],0,1) == "-")
    {
        $this->data['lon'] = str_replace("-","",$this->data['lon']);
        $lon    = $this->data['lon']."&deg; W";
    }
    else
    {
        $lon    = $this->data['lon']."&deg; E"; 
    }
    $tmz    = $this->data['timezone'];
    $pob    = $this->data['pob'];
}
else 
{
    if(substr($this->data['latitude'],0,1) == "-")
    {
        $this->data['latitude'] = str_replace("-","",$this->data['latitude']);
        $lat    =  $this->data['latitude']."&deg; S";
    }
    else
    {
        $lat    = $this->data['latitude']."&deg; N"; 
    }
    if(substr($this->data['longitude'],0,1) == "-")
    {
        $this->data['longitude'] = str_replace("-","",$this->data['longitude']);
        $lon    = $this->data['longitude']."&deg; W";
    }
    else
    {
        $lon    = $this->data['longitude']."&deg; E"; 
    }
    $tmz    = $this->data['tmz_words'];
    
    if($this->data['state'] == "" && $this->data['country'] == "")
    {
        $pob    = $this->data['city'];
    }
    else if($this->data['state'] == "" && $this->data['country'] != "")
    {
        $pob    = $this->data['city'].", ".$this->data['country'];
    }
    else
    {
        $pob    = $this->data['city'].", ".$this->data['state'].", ".$this->data['country'];
    }
}
?>
    
    <div class="mb-3"></div>
    <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>Name</th>
            <td id="fname" value="<?php echo $this->data['fname']; ?>"><?php echo $this->data['fname']; ?></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td id="gender" value="<?php echo $this->data['gender'] ?>"><?php echo ucfirst($this->data['gender']); ?></td>
        </tr>
        <tr>
            <th>Date Of Birth</th>
            <?php $date   = new DateTime($this->data['dob_tob'], new DateTimeZone($tmz)); ?>
            <td id="dob" value="<?php echo $date->format('d-m-Y'); ?>"><?php echo $date->format('dS F Y'); ?></td>
        </tr>
        <tr>
            <th>Time Of Birth</th>
            <td id="tob" value="<?php echo $date->format('h:i:s a'); ?>"><?php echo $date->format('h:i:s a'); ?></td>
        </tr>
        <tr>
            <th>Place Of Birth</th>
            <td id="pob" value="<?php echo $pob; ?>"><?php echo $pob; ?></td>
        </tr>
        <tr>
            <th>Latitude</th>
            <td><?php  echo $lat; ?></td>
        </tr>
        <tr>
            <th>Longitude</th>
            <td><?php  echo $lon; ?></td>
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
<div class="lead alert alert-dark">Chances Of Late Marriage</div>
<div class="row justify-content-center">
<div class="c100 big" id="late_checker">
    <span id="late_value"></span>
    <div class="slice">
        <div class="bar"></div>
        <div class="fill"></div>
    </div>
</div></div>
<p><strong>Note: </strong>Main Chart, Moon Chart and Navamsha Chart are analyzed to check 
possibility of late marriage.</p>
<div class="lead alert alert-dark">Analysis Of 7th House</div>
<p>7th house is known as marriage house. Bad influences on 7th house often lead to late marriage. Sometimes 
even good influences on 7th house can delay marriage. Below are the placements and aspects on 7th house 
in Main Chart, Moon Chart and Navamsha Chart. Sometimes bad 7th house leads to early divorce.</p>
  <div class="mb-3"></div>
  <table class="table table-bordered table-hover">
    <tr>
      <th>7th House</th><th>Placements</th><th>Aspects</th><th>Possibility Of Late Marriage</th>       
    </tr>
    <tr>
        <td>Main Chart</td>
        <td>
        <?php 
            $count  = count($this->data['house_7']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
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
        </td>
        <td>
         <?php 
            $count  = count($this->data['aspect_7']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
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
        </td>
        <td>
                
        </td>
    </tr>
    <tr>
        <td>Moon Chart</td>
        <td>
            <?php 
            $count  = count($this->data['moon7']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['moon7'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['moon7'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            <?php 
            $count  = count($this->data['moon7_as']);
            if($count == "0")
            {
                echo "No Aspects";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['moon7_as'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['moon7_as'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            
        </td>
    </tr>
    <tr>
        <td>Navamsha Chart</td>
        <td>
            <?php 
            $count  = count($this->data['nav7']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['nav7'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['nav7'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            <?php 
            $count  = count($this->data['nav7_as']);
            if($count == "0")
            {
                echo "No Aspects";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['nav7_as'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['nav7_as'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            
        </td>
    </tr>
  </table>
  <div class="lead alert alert-dark">Analysis Of 12th House</div>
<p>12th house deals with sex life. A bad 12th house means one cannot enjoy proper sex in life. A bad 12th house is 
one of the foremost reasons for late marriage, no marriage or early divorce.</p>
  <div class="mb-3"></div>
  <table class="table table-bordered table-hover">
    <tr>
      <th>12th House</th><th>Placements</th><th>Aspects</th><th>Possibility Of Late Marriage</th>       
    </tr>
    <tr>
        <td>Main Chart</td>
        <td>
        <?php 
            $count  = count($this->data['house_12']);
            if($count == "0")
            {
                echo "No Planets";
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
        </td>
        <td>
         <?php 
            $count  = count($this->data['aspect_12']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
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
        </td>
        <td>
            
        </td>
    </tr>
    <tr>
        <td>Moon Chart</td>
        <td>
            <?php 
            $count  = count($this->data['moon12']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['moon12'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['moon12'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            <?php 
            $count  = count($this->data['moon12_as']);
            if($count == "0")
            {
                echo "No Aspects";

            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['moon12_as'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['moon12_as'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td>Navamsha Chart</td>
        <td>
            <?php 
            $count  = count($this->data['nav12']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['nav12'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['nav12'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            <?php 
            $count  = count($this->data['nav12_as']);
            if($count == "0")
            {
                echo "No Aspects";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['nav12_as'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['nav12_as'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>

        </td>
    </tr>
  </table>  
   <div class="lead alert alert-dark">Analysis Of 2nd House</div>
<p>2nd house deals with family life. A bad 2nd house doesn't allow person to marry and start his own family.</p>
  <div class="mb-3"></div>
  <table class="table table-bordered table-hover">
    <tr>
      <th>2th House</th><th>Placements</th><th>Aspects</th><th>Possibility Of Late Marriage</th>       
    </tr>
    <tr>
        <td>Main Chart</td>
        <td>
        <?php 
            $count  = count($this->data['house_2']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['house_2'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['house_2'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
         <?php 
            $count  = count($this->data['aspect_2']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['aspect_2'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['aspect_2'][$i]." ";
                   }
                }
            }
        ?>         
        </td>
        <td>
           
        </td>
    </tr>
    <tr>
        <td>Moon Chart</td>
        <td>
            <?php 
            $count  = count($this->data['moon2']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['moon2'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['moon2'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            <?php 
            $count  = count($this->data['moon2_as']);
            if($count == "0")
            {
                echo "No Aspects";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['moon2_as'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['moon2_as'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>

        </td>
    </tr>
    <tr>
        <td>Navamsha Chart</td>
        <td>
            <?php 
            $count  = count($this->data['nav2']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['nav2'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['nav2'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            <?php 
            $count  = count($this->data['nav2_as']);
            if($count == "0")
            {
                echo "No Aspects";

            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['nav2_as'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['nav2_as'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            
        </td>
    </tr>
  </table>
   <div class="lead alert alert-dark">Analysis Of 11th House</div>
<p>11th house is the house of gains, friendship and social contacts. Sometimes a bad 11th house doesn't allow native to 
 gain a spouse or enjoy socializing with others due to single status.</p>
  <div class="mb-3"></div>
    <div class="mb-3"></div>
  <table class="table table-bordered table-hover">
    <tr>
      <th>11th House</th><th>Placements</th><th>Aspects</th><th>Possibility Of Late Marriage</th>       
    </tr>
    <tr>
        <td>Main Chart</td>
        <td>
        <?php 
            $count  = count($this->data['house_11']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['house_11'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['house_11'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
         <?php 
            $count  = count($this->data['aspect_11']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['aspect_11'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['aspect_11'][$i]." ";
                   }
                }
            }
        ?>         
        </td>
        <td>
            
        </td>
    </tr>
    <tr>
        <td>Moon Chart</td>
        <td>
            <?php 
            $count  = count($this->data['moon11']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['moon11'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['moon11'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            <?php 
            $count  = count($this->data['moon11_as']);
            if($count == "0")
            {
                echo "No Aspects";

            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['moon11_as'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['moon11_as'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
           
        </td>
    </tr>
    <tr>
        <td>Navamsha Chart</td>
        <td>
            <?php 
            $count  = count($this->data['nav11']);
            if($count == "0")
            {
                echo "No Planets";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['nav11'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['nav11'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            <?php 
            $count  = count($this->data['nav11_as']);
            if($count == "0")
            {
                echo "No Aspects";
            }
            else
            {
                for($i = 0; $i < $count;$i++)
                {
                   if($i < $count-1)
                   {
                       echo $this->data['nav11_as'][$i].", ";
                   }
                  else
                   {
                       echo $this->data['nav11_as'][$i]." ";
                   }
                }
            }
        ?>      
        </td>
        <td>
            
        </td>
    </tr>
  </table>
<?php echo "<br/>".$percent; ?>
<form>
    <input type="hidden" value="<?php echo $percent; ?>" id="late_rate" />
</form>
<div class="mb-3"></div>
<link rel="stylesheet" href="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/circle.css' ?>" type="text/css" />
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/latemarry.js' ?>">
</script>
<?php unset($this->data); ?>
</body>