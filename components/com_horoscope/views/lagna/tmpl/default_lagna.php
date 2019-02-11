<html>
 <head>
<style type="text/css">
#horo_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#horo_canvas{width:65%}}
</style>
</head>
<body onload="javascript:draw_horoscope();getAscendant()">
<?php $chart_id = $_GET['chart']; ?>
<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link active">Horo Details</a>
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
    <a class="nav-link" href="<?php echo JURi::base() ?>getnavamsha?chart=<?php echo $chart_id ?>">Navamsha</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="<?php echo JURi::base() ?>getvimshottari?chart=<?php echo $chart_id ?>">Vimshottari</a>
  </li>
</ul><div class="mb-2"></div>
<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
?>

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
            <td><?php echo $this->data['lat']; ?></td>
        </tr>
        <tr>
            <th>Longitude</th>
            <td><?php echo $this->data['lon']; ?></td>
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
    
<canvas id="horo_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-2"></div>
    <p class="float-sm-right">(R) signifies that planet is retrograde at time of birth</p>
    <table class="table table-bordered table-striped table-responsive">
        <tr>
            <th>Planets</th>
            <th>Sign</th>
            <th>Sign Lord</th>
            <th>Distance</th>
            <th>Nakshatra</th>
            <th>Nakshatra Lord</th>
            <th>Navamsha Sign</th>
        </tr>
    <?php 
           for($i=0;$i<count($planets);$i++)
           {
                $sign           = $planets[$i]."_sign";
                $sign_lord      = $planets[$i]."_sign_lord";
                $dist           = $planets[$i]."_dist";
                $nakshatra      = $planets[$i]."_nakshatra";
                $nakshatra_lord = $planets[$i]."_nakshatra_lord";
                $navamsha_sign  = $planets[$i]."_navamsha_sign";
                
    ?>
        <tr>
            <td><?php echo $planets[$i];if($this->data[$i]['status']=='retro'){echo '(R)';}  // code would add (R) if planet is Retrograde; ?></td>
            <td id="<?php echo strtolower(trim($planets[$i])); ?>_sign" value="<?php echo $this->data[$i][$sign]; ?>"><?php echo $this->data[$i][$sign]; ?></td>
            <td><?php echo $this->data[$i][$sign_lord]; ?></td>
            <td><?php echo $this->data[$i][$dist]; ?></td>
            <td><?php echo $this->data[$i][$nakshatra]; ?></td>
            <td><?php echo $this->data[$i][$nakshatra_lord]; ?></td>
            <td><?php echo $this->data[$i][$navamsha_sign]; ?></td>
        </tr>
    <?php
           }
    ?>
    </table>
<?php unset($this->data); ?>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/horoscope.js' ?>">
</script>
</body>
</html>