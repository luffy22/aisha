<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
//$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
$chart_id = $_GET['chart'];
$percent            = 0;
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Career Finder</div>
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

<div class="mb-3"></div>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/career.js' ?>">
</script>
<?php unset($this->data); ?>
</body>
