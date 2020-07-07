<html>
 <head>
     <title>Where To Invest</title>
</head>
<body>
<?php 
$chart_id = $_GET['chart']; 
//print_r($this->data);exit;
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Birth Details</div>
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
        <td><?php echo $date->format('h:i:s a'); ?></td>
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
<p class="lead">Kindly Note: This software does not consider current transits of planets. Only birth-time chart is analyzed. Do not 
invest all your money in one place. We also advise you to do long-term investments only.</p>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Banks</div>
<div class="mb-3"></div>
<?php
$lord_2             = $this->data['lord_pl_2'];
if($this->data['total_pl_2'] > 0)
{
    $pl_strength_2      = $this->data['pl_strength_2']/$this->data['total_pl_2'];
}
 else 
{
    $pl_strength_2      = "zero";
}
if($this->data['total_asp_2'] > 0)
{
    $asp_strength_2     = $this->data['asp_strength_2']/$this->data['total_asp_2'];
}
 else 
{
    $asp_strength_2     = "zero";
}
if($pl_strength_2 == "zero")
{
    $total_strength         = $lord_2 + 0+$asp_strength_2;
}
else if($asp_strength_2 == "zero")
{
    $total_strength         = $lord_2+$pl_strength_2+0;
}
else 
{
    $total_strength         = $lord_2+$pl_strength_2+$asp_strength_2;
}
//echo $total_strength;exit;
?>
<div class="row">
<div class="col-md-3 col-sm-3 col-xs-4">
<?php
if($total_strength >= 4)
{
?>
<img src="images/bank_yes.jpg" class="rounded float-left img-fluid" alt="bank" />
<?php
}
else
{
?>
<img src="images/bank_no.jpg" class="rounded float-left img-fluid" alt="bank" />
<?php
}
?>
</div>
<div class="col-md-9 col-sm-9 col-xs-8">
<ul class="list-group">
    <li class="list-group-item">2nd house deals with savings in banks and various financial schemes. Generally the safest option among 
        all places for investment are banks.</li>
<?php 
    if($lord_2 > 3) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 2nd house lord has strength.</li>
<?php
    }
     else if($lord_2 >= 2 && $lord_2 <= 3) 
    {
?>
    <li class="list-group-item"><i class="far fa-check-circle"></i> 2nd house lord is decent.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 2nd house lord is weak.</li>
<?php
   }
    if($pl_strength_2 >= 2.5) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 2nd house has favorable placements.</li>
<?php
    }
    else if(is_string($pl_strength_2))
    {
?>
    <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> 2nd house has no placements.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 2nd house has bad placements.</li>
<?php
   }
     if($asp_strength_2 >= 2.5) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 2nd house has favorable aspects.</li>
<?php
    }
    else if(is_string ($asp_strength_2))
    {

?>
    <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> 2nd house has no aspects.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 2nd house has bad aspects.</li>
<?php
   }
   if($total_strength >= 4)
{
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> <strong>According to horoscope bank is a safe place of investment for you.</strong></li>
<?php
}
else
{
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> <strong>According to horoscope bank isn't the best place of investment for you.</strong></li>
<?php
}
?>
</ul>
</div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Land and Real Estate</div>
<?php
$lord_4             = $this->data['lord_pl_4'];
if($this->data['total_pl_4'] > 0)
{
    $pl_strength_4      = $this->data['pl_strength_4']/$this->data['total_pl_4'];
}
 else 
{
    $pl_strength_4      = "zero";
}

if($this->data['total_asp_4'] > 0)
{
    $asp_strength_4     = $this->data['asp_strength_4']/$this->data['total_asp_4'];
}
 else 
{
    $asp_strength_4     = "zero";
}
if($pl_strength_4 == "zero")
{
    $total_strength         = $lord_4 + 0+$asp_strength_4;
}
else if($asp_strength_4 == "zero")
{
    $total_strength         = $lord_4+$pl_strength_4+0;
}
else 
{
    $total_strength         = $lord_4+$pl_strength_4+$asp_strength_4;
}
//echo $total_strength;exit;
//echo $lord_4." ".$pl_strength_4." ".$asp_strength_4;exit;
?>
<div class="row">
<div class="col-md-3 col-sm-3 col-xs-4">
<?php
if($total_strength >= 4)
{
?>
<img src="images/home_yes.jpg" class="rounded float-left img-fluid" alt="home" />
<?php
}
else
{
?>
<img src="images/home_no.jpg" class="rounded float-left img-fluid" alt="home" />
<?php
}
?>
</div>
<div class="col-md-9 col-sm-9 col-xs-8">
<ul class="list-group">
<li class="list-group-item">4th house deals with home, land property and real estate. Land maybe an 
immovable asset but is a wonderful investment for long term.</li>
<?php 
    if($lord_4 > 3) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 4th house lord has strength.</li>
<?php
    }
    else if($lord_4 >= 2 && $lord_4 <= 3) 
    {
?>
    <li class="list-group-item"><i class="far fa-check-circle"></i> 4th house lord is decent.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 4th house lord is weak.</li>
<?php
   }
    if($pl_strength_4 >= 2.5) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 4th house has favorable placements.</li>
<?php
    }
    else if(is_string($pl_strength_4))
    {
?>
    <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> 4th house has no placements.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 4th house has bad placements.</li>
<?php
   }
     if($asp_strength_4 >= 2.5) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 4th house has favorable aspects.</li>
<?php
    }
    else if(is_string($asp_strength_4))
    {

?>
    <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> 4th house has no aspects.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 4th house has bad aspects.</li>
<?php
   }
   if($total_strength >= 4)
{
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> <strong>According to horoscope investing in land and real estate is good for you.</strong></li>
<?php
}
else
{
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> <strong>According to horoscope it is best if you avoid heavy investment in land and real estate.</strong></li>
<?php
}
?>
</ul>
</div></div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Stock Markets</div>
<?php
$lord_5             = $this->data['lord_pl_5'];
if($this->data['total_pl_5'] > 0)
{
    $pl_strength_5      = $this->data['pl_strength_5']/$this->data['total_pl_5'];
}
 else 
{
    $pl_strength_5      = "zero";
}
if($this->data['total_asp_5'] > 0)
{
    $asp_strength_5     = $this->data['asp_strength_5']/$this->data['total_asp_5'];
}
 else 
{
    $asp_strength_5     = "zero";
}
if($pl_strength_5 == "zero")
{
    $total_strength         = $lord_5 + 0+$asp_strength_5;
}
else if($asp_strength_5 == "zero")
{
    $total_strength         = $lord_5+$pl_strength_5+0;
}
else 
{
    $total_strength         = $lord_5+$pl_strength_5+$asp_strength_5;
}
//echo $total_strength;exit;
//echo $lord_5." ".$pl_strength_5." ".$asp_strength_5;exit;
?>
<div class="row">
<div class="col-md-3 col-sm-3 col-xs-4">
<?php
if($total_strength >= 4)
{
?>
<img src="images/stock_yes.jpg" class="rounded float-left img-fluid" alt="stock" />
<?php
}
else
{
?>
<img src="images/stock_no.jpg" class="rounded float-left img-fluid" alt="stock" />
<?php
}
?>
</div>
<div class="col-md-9 col-sm-9 col-xs-8">
<ul class="list-group">
    <li class="list-group-item">5th house deals with stock markets. Investing in stock markets is generally 
    favorable especially in open economies where capitalism flourishes. </li>
<?php 
    if($lord_5 > 3) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 5th house lord has strength.</li>
<?php
    }
    else if($lord_5 >= 2 && $lord_5 <= 3) 
    {
?>
    <li class="list-group-item"><i class="far fa-check-circle"></i> 5th house lord is decent.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 5th house lord is weak.</li>
<?php
   }
    if($pl_strength_5 >= 2.5) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 5th house has favorable placements.</li>
<?php
    }
    else if(is_string($pl_strength_5))
    {
?>
    <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> 5th house has no placements.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 5th house has bad placements.</li>
<?php
   }
     if($asp_strength_5 >= 2.5) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 5th house has favorable aspects.</li>
<?php
    }
    else if(is_string ($asp_strength_5))
    {

?>
    <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> 5th house has no aspects.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 5th house has bad aspects.</li>
<?php
   }
    if($total_strength >= 4)
{
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> <strong>According to horoscope investing in stock markets is good for you.</strong></li>
<?php
}
else
{
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> <strong>According to horoscope it is best if you avoid too much investment in stock markets.</strong></li>
<?php
}
?>
</ul>
</div></div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Hidden Wealth</div>
<?php
$lord_8             = $this->data['lord_pl_8'];
if($this->data['total_pl_8'] > 0)
{
    $pl_strength_8      = $this->data['pl_strength_8']/$this->data['total_pl_8'];
}
 else 
{
    $pl_strength_8      = "zero";
}
if($this->data['total_asp_8'] > 0)
{
    $asp_strength_8    = $this->data['asp_strength_8']/$this->data['total_asp_8'];
}
 else 
{
    $asp_strength_8     = "zero";
}
if($pl_strength_8 == "zero")
{
    $total_strength         = $lord_8 + 0+$asp_strength_8;
}
else if($asp_strength_5 == "zero")
{
    $total_strength         = $lord_8+$pl_strength_8+0;
}
else 
{
    $total_strength         = $lord_8+$pl_strength_8+$asp_strength_8;
}
//echo $total_strength;exit;
//echo $lord_5." ".$pl_strength_5." ".$asp_strength_5;exit;
?>
<div class="row">
<div class="col-md-3 col-sm-3 col-xs-4">
<?php
if($total_strength >= 4)
{
?>
<img src="images/treasure_yes.jpg" class="rounded float-left img-fluid" alt="treasure" />
<?php
}
else
{
?>
<img src="images/treasure_no.jpg" class="rounded float-left img-fluid" alt="treasure" />
<?php
}
?>
</div>
<div class="col-md-9 col-sm-9 col-xs-8">    
<ul class="list-group">
    <li class="list-group-item">8th house deals hidden wealth and inheritance. Normally it signifies tax-saver bonds, mutual funds  
    and other types of schemes which are exempt from taxation. It can also represent treasures and wealth hidden from public view.</li>
<?php 
    if($lord_8 > 3) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 8th house lord has strength.</li>
<?php
    }
    else if($lord_8 >= 2 && $lord_8 <= 3) 
    {
?>
    <li class="list-group-item"><i class="far fa-check-circle"></i> 8th house lord is decent.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 8th house lord is weak.</li>
<?php
   }
    if($pl_strength_8 >= 2.5) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 8th house has favorable placements.</li>
<?php
    }
    else if(is_string($pl_strength_8))
    {
?>
    <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> 8th house has no placements.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 8th house has bad placements.</li>
<?php
   }
     if($asp_strength_8 >= 2.5) 
    {
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> 8th house has favorable aspects.</li>
<?php
    }
    else if(is_string ($asp_strength_8))
    {

?>
    <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> 8th house has no aspects.</li>
<?php
    }
 else 
     {
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> 8th house has bad aspects.</li>
<?php
   }
 if($total_strength >= 4)
{
?>
    <li class="list-group-item list-group-item-success"><i class="far fa-check-circle"></i> <strong>According to horoscope keeping hidden assets is good for you.</strong></li>
<?php
}
else
{
?>
    <li class="list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> <strong>According to horoscope it is best if you avoid too much money as hidden asset.</strong></li>
<?php
}
?>
</ul>
</div></div>
<div class="mb-3"></div>
<?php
    $sun_2_conn         = $this->data['gold_sun'];
    $mars_2_conn        = $this->data['gold_mars'];
    $jup_2_conn         = $this->data['gold_jup'];
    $sun_strength       = $this->data['sun_gold_strength'];
    $jup_strength       = $this->data['jup_gold_strength'];
    $mars_strength      = $this->data['mars_gold_strength'];
    $total              = $sun_2_conn + $mars_2_conn + $jup_2_conn +
                          $sun_strength + $mars_strength + $jup_strength;
    //echo $total;exit;
?>
<div class="lead alert alert-dark">Gold</div>
<div class="row">
<div class="col-md-3 col-sm-3 col-xs-4">
<?php
    if($total >= 10)
    {
?>
<img src="images/gold_yes.jpg" class="rounded float-left img-fluid" alt="gold" />
<?php
    }
    else
    {
?>
<img src="images/gold_no.jpg" class="rounded float-left img-fluid" alt="gold" />
<?php
    }
?>
</div>
<div class="col-md-9 col-sm-9 col-xs-8">
<ul class="list-group">
    <?php
        if($sun_2_conn > 2)
        {
    ?>
    <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> Strong Sun influences 2nd house.</li>
        <?php
        }
        else if($sun_2_conn <= 2 && $sun_2_conn != 0)
        {
    ?>
    <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> Weak Sun influences 2nd house.</li>
        <?php
        }
        else
        {
?>
    <li class="list-group-item list-group-item"><i class="far fa-times-circle"></i> Sun does not influence 2nd house.</li>
  <?php
        }
        if($mars_2_conn > 2)
        {
    ?>
    <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> Strong Mars influences 2nd house.</li>
        <?php
        }
        else if($mars_2_conn <= 2 && $mars_2_conn != 0)
        {
    ?>
    <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> Weak Mars influences 2nd house.</li>
        <?php
        }
        else
        {
?>
    <li class="list-group-item list-group-item"><i class="far fa-times-circle"></i> Mars does not influence 2nd house.</li>
  <?php
        }
        if($jup_2_conn > 2)
        {
    ?>
    <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> Strong Jupiter influences 2nd house.</li>
        <?php
        }
        else if($jup_2_conn <= 2 && $jup_2_conn != 0)
        {
    ?>
    <li class="list-group-item list-group-item list-group"><i class="far fa-check-circle"></i> Weak Jupiter influences 2nd house.</li>
        <?php
        }
        else
        {
?>
    <li class="list-group-item list-group-item"><i class="far fa-times-circle"></i> Jupiter does not influence 2nd house.</li>
  <?php
        }
        if($sun_strength == "4")
        {
        ?>
        <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> Sun is strong in horoscope.</li>
        <?php
        }
        else if($sun_strength == "2")
        {
        ?>
        <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> Sun is decent in horoscope.</li>
        <?php
        }
        else
        {
        ?>
        <li class="list-group-item list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> Sun is weak in horoscope.</li>
        <?php
        }
        if($mars_strength == "4")
        {
        ?>
        <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> Mars is strong in horoscope.</li>
        <?php
        }
        else if($mars_strength == "2")
        {
        ?>
        <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> Mars is decent in horoscope.</li>
        <?php
        }
        else
        {
        ?>
        <li class="list-group-item list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> Mars is weak in horoscope.</li>
        <?php
        }
        if($jup_strength == "4")
        {
        ?>
        <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> Jupiter is strong in horoscope.</li>
        <?php
        }
        else if($jup_strength == "2")
        {
        ?>
        <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> Jupiter is decent in horoscope.</li>
        <?php
        }
        else
        {
        ?>
        <li class="list-group-item list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> Jupiter is weak in horoscope.</li>
        <?php
        }
if($total >= 10)
    {
?>
        <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> <strong>Investment in gold is favorable for you.</strong></li>
<?php
    }
    else
    {
?>
        <li class="list-group-item list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> <strong>Its best if you avoid too much investment in gold.</strong></li>
<?php
    }
?>
</ul>
</div></div>
<div class="mb-3"></div>
<?php
    $moon_2_conn        = $this->data['silver_moon'];
    $jup_2_conn         = $this->data['silver_jup'];
    $moon_strength      = $this->data['moon_sil_strength'];
    $jup_strength       = $this->data['jup_sil_strength'];
    $total              =  $moon_2_conn + $jup_2_conn + 
                            $moon_strength + $jup_strength;
?>
<div class="lead alert alert-dark">Silver</div>
<div class="row">
<div class="col-md-3 col-sm-3 col-xs-4">
<?php
if($total >= 6)
{
?>
<img src="images/silver_yes.jpg" class="rounded float-left img-fluid" alt="silver" />
<?php
}
else
{
?>
<img src="images/silver_no.jpg" class="rounded float-left img-fluid" alt="silver" />
<?php
}    
?>
</div>
<div class="col-md-9 col-sm-9 col-xs-8">
<ul class="list-group">
    <?php
        if($moon_2_conn > 2)
        {
    ?>
    <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> Moon has strong influences 2nd house.</li>
        <?php
        }
        else if($moon_2_conn <= 2 && $moon_2_conn != 0)
        {
    ?>
    <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> Moon has weak influence on 2nd house.</li>
        <?php
        }
        else
        {
?>
    <li class="list-group-item list-group-item"><i class="far fa-times-circle"></i> Moon does not influence 2nd house.</li>
  <?php
        }
        if($jup_2_conn > 2)
        {
    ?>
    <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> Jupiter has strong influences 2nd house.</li>
        <?php
        }
        else if($jup_2_conn <= 2 && $jup_2_conn != 0)
        {
    ?>
    <li class="list-group-item list-group-item list-group"><i class="far fa-check-circle"></i> Jupiter has weakinfluences 2nd house.</li>
        <?php
        }
        else
        {
?>
    <li class="list-group-item list-group-item"><i class="far fa-times-circle"></i> Jupiter does not influence 2nd house.</li>
  <?php
        }
        if($moon_strength == "4")
        {
        ?>
        <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> Moon is strong in horoscope.</li>
        <?php
        }
        else if($moon_strength == "2")
        {
        ?>
        <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> Moon is decent in horoscope.</li>
        <?php
        }
        else
        {
        ?>
        <li class="list-group-item list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> Moon is weak in horoscope.</li>
        <?php
        }
        if($jup_strength == "4")
        {
        ?>
        <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> Jupiter is strong in horoscope.</li>
        <?php
        }
        else if($jup_strength == "2")
        {
        ?>
        <li class="list-group-item list-group-item"><i class="far fa-check-circle"></i> Jupiter is decent in horoscope.</li>
        <?php
        }
        else
        {
        ?>
        <li class="list-group-item list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> Jupiter is weak in horoscope.</li>
        <?php
        }
     if($total >= 6)
    {
?>
        <li class="list-group-item list-group-item list-group-item-success"><i class="far fa-check-circle"></i> <strong>Investment in silver is favorable for you.</strong></li>
<?php
    }
    else
    {
?>
        <li class="list-group-item list-group-item list-group-item-danger"><i class="far fa-times-circle"></i> <strong>Its best if you avoid too much investment in silver.</strong></li>
<?php
    }
?>
</ul>
</div></div>
<div class="mb-3"></div>
<?php
unset($this->data);
?>
