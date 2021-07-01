<html>
 <head>
     <title>Get Horoscope Details</title>
<!-- <style type="text/css">
#horo_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#horo_canvas{width:65%}}
</style>-->
</head>
<body>
<?php
$user =& JFactory::getUser();
if($user->id == "0")
{
?>
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <a href="<?php echo JUri::base().'register' ?>">Register</a> with us to save upto fifty horoscopes
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
}
?>
<?php 
//print_r($this->data);exit;
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
<div class="lead alert alert-dark">Horoscope</div>
<div class="row">
<div class="col-4"><a class="content_links" title="Main Chart" href="<?php echo Juri::base() ?>mainchart?chart=<?php echo $chart_id; ?>"><img src="images/mainchart.jpeg" width="75px" height="75px" alt="main"/><br/>Main Chart</a></div>
<div class="col-4"><a class="content_links" title="Ascendant Chart" href="<?php echo Juri::base() ?>getasc?chart=<?php echo $chart_id; ?>"><img src="images/horo.jpeg" alt="ascendant" width="75px" height="75px"/><br/>Ascendant Chart</a></div>
<div class="col-4"><a class="content_links" title="Moon Chart" href="<?php echo Juri::base() ?>getmoon?chart=<?php echo $chart_id; ?>"><img src="images/art_img/moon.png" alt="moon" width="75px" height="75px"/><br/>Moon Chart</a></div>
</div>
<div class="mb-3"></div>
<div class="row">
<div class="col-4"><a class="content_links" title="nakshatra finder" href="<?php echo Juri::base() ?>getnakshatra?chart=<?php echo $chart_id; ?>"><img src="images/nakshatra.jpeg" alt="nakshatra" width="75px" height="75px"/><br/>Nakshatra Finder </a></div>
<div class="col-4"><a class="content_links" title="Navamsha Chart" href="<?php echo Juri::base() ?>getnavamsha?chart=<?php echo $chart_id; ?>"><img src="images/navamsha.jpeg" alt="navamsha" width="75px" height="75px"/><br/>Navamsha Chart</a></div>
<div class="col-4"><a class="content_links" title="Vimhshottari Dasha" href="<?php echo Juri::base() ?>getvimshottari?chart=<?php echo $chart_id; ?>"><img src="images/vimshottari.jpeg" alt="vimshottari" width="75px" height="75px"/><br/>Vimshottari Dasha</a></div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Career</div>
<div class="row">
  <div class="col-4"><a class="content_links" title="career finder" href="<?php echo Juri::base() ?>careerfind?chart=<?php echo $chart_id; ?>"><img src="images/art_img/career.jpg" alt="career" width="75px" height="75px"/><br/>Career Finder</a></div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Finances</div>
<div class="row">
  <div class="col-4"><a class="content_links" title="where to invest" href="<?php echo Juri::base() ?>investwhere?chart=<?php echo $chart_id; ?>"><img src="images/money.jpg" alt="money" width="75px" height="75px"/><br/>Where To Invest</a></div>

</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Marriage</div>
<div class="row">
  <div class="col-4"><a class="content_links" title="Spouse Finder" href="<?php echo Juri::base() ?>findspouse?chart=<?php echo $chart_id; ?>"><img src="images/art_img/marriage.png" alt="marriage"  width="75px" height="75px"/><br/>Spouse Finder</a></div>
  <div class="col-4"><a class="content_links" title="Chances of Love Marriage" href="<?php echo Juri::base() ?>lovemarry?chart=<?php echo $chart_id; ?>"><img src="images/art_img/love.png" alt="love"  width="70px" height="70px"/><br/>Chances of Love Marriage</a></div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Divorce</div>
<div class="row">
    <div class="col-4"><a class="content_links" title="Mangal Dosha Calculator" href="<?php echo Juri::base() ?>mangaldosha?chart=<?php echo $chart_id; ?>"><img src="images/mars_dosha.png" alt="mdosha" width="75px" height="75px"/><br/>Mangal Dosha Calculator</a></div>
  <div class="col-4"><a class="content_links" title="Chances of Divorce" href="<?php echo Juri::base() ?>divorce?chart=<?php echo $chart_id; ?>"><img src="images/divorce_clipart.jpeg" alt="divorce" width="75px" height="75px"/><br/>Divorce Chances</a></div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Misc</div>
<div class="row">
    <div class="col-4"><a class="content_links" title="Astro Yogas" href="<?php echo Juri::base() ?>astroyogas?chart=<?php echo $chart_id; ?>"><img src="images/yogas.png" alt="yogas"  width="75px" height="75px"/><br/>Astro Yogas</a></div>
    <div class="col-4"><a class="content_links" title="4 Stages" href="<?php echo Juri::base() ?>fourstage?chart=<?php echo $chart_id; ?>"><img src="images/four.png" alt="yogas"  width="75px" height="75px"/><br/>Stages Of Life</a></div>

</div>
<div class="mb-3"></div>
