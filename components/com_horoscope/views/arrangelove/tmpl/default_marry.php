<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
//$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
$chart_id = $_GET['chart'];

$name       = explode(' ', $this->data['fname']);
$document = JFactory::getDocument(); 
$document->setTitle(strtolower($name[0]).' love marriage');
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
        <td><?php echo $this->data['fname']; ?></td>
    </tr>
    <tr>
        <th>Gender</th>
        <td><?php echo ucfirst($this->data['gender']); ?></td>
    </tr>
    <tr>
        <th>Date Of Birth</th>
        <td><?php 
                $date   = new DateTime($this->data['dob_tob'], new DateTimeZone($tmz));
                echo $date->format('dS F Y'); ?></td>
    </tr>
    <tr>
        <th>Time Of Birth</th>
        <td><?php echo $date->format('h:i:s a'); ?></td>
    </tr>
    <tr>
        <th>Place Of Birth</th>
        <td><?php echo $pob; ?></td>
    </tr>
    <tr>
        <th>Latitude</th>
        <td><?php echo $lat; ?></td>
    </tr>
    <tr>
        <th>Longitude</th>
        <td><?php echo $lon; ?></td>
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
<div class="lead alert alert-dark">Possibility Of Love Marriage</div>
<p><strong>Note: </strong>Most marriages today are done with approval of bride and groom. We recommend 
you do not get too excited or too upset if your horoscope does not match the criteria provided.</p>
<div class="mb-3"></div>
<ul class="list-group">
    <li class="list-group-item"><strong>Venus-Moon association: </strong>Moon is the planet of emotions and Venus 
        is the planet of love and romance. When there is any association between Moon and Venus than there is 
        strong emotional desire to spend life with lover.</li>
    <?php
if($this->data['moon_ven'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> Moon and Venus are in same house. There are high chances of love marriage in your life.</strong></li>
<?php
}
if($this->data['moon_ven_7'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> Moon and Venus aspect each other in your chart. There are good chances of love marriage in your life.</strong></li>
<?php
}
 if($this->data['moon_ven'] == "no" && $this->data['moon_ven_7'] == "no")
{    
?>
    <li class="list-group-item list-group-item-danger"><strong><i class="fas fa-times-circle"></i> Moon and Venus are not associated in your chart.</strong></li>
<?php
}
?>
</ul>
<div class="mb-3"></div>
<ul class="list-group">
    <li class="list-group-item"><strong>Mars-Venus association: </strong>Association of Mars and Venus in horoscope often suggests 
    love marriage due to physical desires. If there is any association of Venus and Mars 
    than chances of love marriage increase.</li>
<?php
if($this->data['mars_ven'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> Mars and Venus are in same house. There are high chances of love marriage in your life.</strong></li>
<?php
}
if($this->data['mars_ven_7'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> Mars and Venus aspect each other in your chart. There are good chances of love marriage in your life.</strong></li>
<?php
}
 if($this->data['mars_ven'] == "no" && $this->data['mars_ven_7'] == "no")
{    
?>
    <li class="list-group-item list-group-item-danger"><strong><i class="fas fa-times-circle"></i> Mars and Venus are not associated in your chart.</strong></li>
<?php
}
?>
</ul>
<div class="mb-3"></div>
<ul class="list-group">
    <li class="list-group-item"><strong>Venus-Rahu association: </strong>Association of Venus and Rahu also suggests love marriage. Love marriage 
    is often done under impulsive desires or love for taboo activities.</li>
<?php
if($this->data['ven_rahu'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> Venus and Rahu are in same house. There are high chances of love marriage in your life.</strong></li>
<?php
}
if($this->data['rahu_ven_7'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> Venus and Rahu aspect each other in your chart. There are chances of love marriage in your life.</strong></li>
<?php
}
if($this->data['ven_rahu'] == "no" && $this->data['rahu_ven_7'] == "no")
{    
?>
    <li class="list-group-item list-group-item-danger"><strong><i class="fas fa-times-circle"></i> Venus and Rahu are not associated in your chart.</strong></li>
<?php
}
?>
</ul>
<div class="mb-3"></div>
<ul class="list-group">    
    <li class="list-group-item"><strong>Fifth House-Seventh House Association: </strong>Fifth house is the house of romance. Seventh house is the 
    house of marriage. When fifth house and seventh house or their respective lords are 
    associated in anyway there are high chances of love marriage.</li>
<?php
if($this->data['five_sev'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> Fifth house lord and seventh house lord are in the same sign. There are high chances of love marriage in your life.</strong></li>
<?php
}
if($this->data['fifth_seventh_exc'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> There is <a href="https://www.astroisha.com/yogas/83-payo" target="_blank" title="Parivartan Yog">Parivartan Yog</a>(Exchange of Houses) between fifth house lord and seventh house lord. There are high chances of love marriage in your life.</strong></li>
<?php
}
if($this->data['fifth_seventh_asp'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> Fifth house lord and seventh house lord aspect each other. There are chances of love marriage in your life.</strong></li>
<?php
}
if($this->data['five_sev'] == "no" && $this->data['fifth_seventh_exc'] == "no" 
    && $this->data['fifth_seventh_asp'] == "no")
{    
?>
    <li class="list-group-item list-group-item-danger"><strong><i class="fas fa-times-circle"></i> There is no association between fifth house and seventh house in your chart.</strong></li>
<?php
}
?>
</ul>
<div class="mb-3"></div>
<ul class="list-group">
    <li class="list-group-item"><strong>First House-Seventh House association: </strong>First house(ascendant) describes the person himself/herself. Seventh house describes marriage partner. When 
there is association between first house and seventh house than native generally chooses 
marriage partner himself/herself.</li>
<?php
if($this->data['asc_sev'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> First house(ascendant) lord and seventh house lord are in the same sign. You would give preference to your own choice as marriage partner.</strong></li>
<?php
}
if($this->data['asc_seventh_exc'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> There is Parivartan Yog(Exchange of Houses) between first house(ascendant) lord and seventh house lord. There are chances of love marriage in your life.</strong></li>
<?php
}

if($this->data['asc_seventh_asp'] == "yes")
{    
?>
    <li class="list-group-item list-group-item-success"><strong><i class="fas fa-check-circle"></i> First house(ascendant) lord and seventh house lord aspect each other. There are good chances of love marriage in your life.</strong></li>
<?php
}
if($this->data['asc_sev'] == "no" && $this->data['asc_seventh_exc'] == "no" 
    && $this->data['asc_seventh_asp'] == "no")
{    
?>
    <li class="list-group-item list-group-item-danger"><strong><i class="fas fa-times-circle"></i> There is no association between first house and seventh house in your chart.</strong></li>
<?php
}
?>
</ul><div class="mb-3"></div>
<?php unset($this->data); ?>
