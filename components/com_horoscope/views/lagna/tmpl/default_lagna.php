<?php
defined('_JEXEC') or die();
//print_r($this->data);exit;
$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
?>
<div class="container-fluid">
    <table class="table table-bordered table-hover">
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
    <div class="mb-2"></div>
    <table class="table table-hover table-responsive">
        <tr class="bg-info">
            <th>Planets</th>
            <th>Sign</th>
            <th>Sign Lord</th>
            <th>Distance</th>
            <th>Nakshatra</th>
            <th>Nakshatra Lord</th>
            
        </tr>
    <?php 
           for($i=0;$i<count($planets);$i++)
           {
                $sign           = $planets[$i]."_sign";
                $sign_lord      = $planets[$i]."_sign_lord";
                $dist           = $planets[$i]."_dist";
                $nakshatra      = $planets[$i]."_nakshatra";
                $nakshatra_lord = $planets[$i]."_nakshatra_lord";
                
    ?>
        <tr>
            <td><?php echo $planets[$i];  ?></td>
            <td><?php echo $this->data[$i][$sign]; ?></td>
            <td><?php echo $this->data[$i][$sign_lord]; ?></td>
            <td><?php echo $this->data[$i][$dist]; ?></td>
            <td><?php echo $this->data[$i][$nakshatra]; ?></td>
            <td><?php echo $this->data[$i][$nakshatra_lord]; ?></td>
        </tr>
    <?php
           }
    ?>
    </table>
    <?php unset($this->data); ?>
</div>