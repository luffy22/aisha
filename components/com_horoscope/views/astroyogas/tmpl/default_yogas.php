<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
//$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
$chart_id = $_GET['chart'];
$count       = count($this->data['nbry_yoga']);
$name       = explode(' ', $this->data['fname']);
$document = JFactory::getDocument(); 
$document->setTitle(strtolower($name[0]).' astro yogas');
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Astro Yogas in your chart</div>
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
<div class="lead alert alert-dark">Main Good Yogas</div>
<ul class="list-group">
    <li class="list-group-item"><strong>Budh-Aditya Yoga: </strong><?php echo $this->data['budh_aditya']; ?></li>
    <li class="list-group-item"><strong>Neech-Bhang Raj Yoga: </strong><?php if($count == "0"){echo "No"; }else{ for($i=0;$i<$count;$i++){ echo "<br/>".$this->data['nbry_yoga'][$i]; } } ?></li>
    <li class="list-group-item"><strong>Vimala Yoga: </strong><?php echo $this->data['vimala'] ?></li>
    <li class="list-group-item"><strong>Sarala Yoga: </strong><?php echo $this->data['sarala']; ?></li>
    <li class="list-group-item"><strong>Harsha Yoga: </strong><?php echo $this->data['harsha']; ?></li>
    <li class="list-group-item"><strong>Parivartana Yoga: </strong><?php for($i=0;$i<3;$i++){echo $this->data['parivartana_yoga_'.$i]."<br/>"; } ?></li>
    <li class="list-group-item"><strong>Chandra-Mangal Yoga: </strong><?php echo $this->data['chandra_mangal']; ?></li>
    <li class="list-group-item"><strong>Gaja-Kesari Yoga: </strong><?php echo $this->data['gaja_kesari']; ?></li>
    <li class="list-group-item"><strong>Sasha Yoga: </strong><?php echo $this->data['sasha_yoga']; ?></li>
    <li class="list-group-item"><strong>Hansa Yoga: </strong><?php echo $this->data['hansa_yoga']; ?></li>
    <li class="list-group-item"><strong>Ruchaka Yoga: </strong><?php echo $this->data['ruchak_yoga']; ?></li>
    <li class="list-group-item"><strong>Malavya Yoga: </strong><?php echo $this->data['malavya_yoga']; ?></li>
    <li class="list-group-item"><strong>Bhadra Yoga: </strong><?php echo $this->data['bhadra_yoga']; ?></li>
</ul><div class="mb-3"></div>
<div class="lead alert alert-dark">Main Bad Yogas</div>
<ul class="list-group">
    <li class="list-group-item"><strong>Visha Yoga: </strong><?php echo $this->data['vish_yoga']; ?></li>
    <li class="list-group-item"><strong>Vipra-Chandal Yoga: </strong><?php echo $this->data['vipra_chandal']; ?></li>
    <li class="list-group-item"><strong>Kaal-Sarpa Yoga: </strong><?php echo $this->data['kaal_sarpa']; ?></li>
    <li class="list-group-item"><strong>Shrapit Yoga: </strong><?php echo $this->data['shrapit_yoga']; ?></li>
    <li class="list-group-item"><strong>Grahan Yoga: </strong><?php echo $this->data['grahan_yoga']; ?></li>
    <li class="list-group-item"><strong>Shani-Surya Yuti: </strong><?php echo $this->data['pitru_dosha']; ?></li>
    <li class="list-group-item"><strong>Kemdruma Yoga: </strong><?php echo $this->data['kemdruma_yoga']; ?></li>
</ul>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Other Yogas</div>
<ul class="list-group">
    <li class="list-group-item"><strong>Sunapha Yoga: </strong><?php echo $this->data['sunapha_yoga']; ?></li>
    <li class="list-group-item"><strong>Anapha Yoga: </strong><?php echo $this->data['anapha_yoga']; ?></li>
    <li class="list-group-item"><strong>Dhurdhura Yoga: </strong><?php echo $this->data['dhurdhura_yoga']; ?></li>
    <li class="list-group-item"><strong>Adhi Yoga: </strong><?php echo $this->data['adhi_yoga']; ?></li>
    <li class="list-group-item"><strong>Chatusagara Yoga: </strong><?php echo $this->data['chatusagara_yoga']; ?></li>
    <li class="list-group-item"><strong>Rajlakshana Yoga: </strong><?php echo $this->data['rajlakshana_yoga']; ?></li>
    <li class="list-group-item"><strong>Sakata Yoga; </strong><?php echo $this->data['sakata_yoga']; ?></li>
    <li class="list-group-item"><strong>Amala Yoga: </strong><?php echo $this->data['amala_yoga']; ?></li>
    <li class="list-group-item"><strong>Parvata Yoga: </strong><?php echo $this->data['parvata_yoga']; ?></li>
    <li class="list-group-item"><strong>Kahala Yoga: </strong><?php echo $this->data['kahala_yoga']; ?></li>
    <li class="list-group-item"><strong>Vesi Yoga: </strong><?php echo $this->data['vesi_yoga']; ?></li>
    <li class="list-group-item"><strong>Obyachari Yoga: </strong><?php echo $this->data['obya_yoga']; ?></li>
    <li class="list-group-item"><strong>Mahabhagya Yoga: </strong><?php echo $this->data['mahabhagya_yoga']; ?></li>
    <li class="list-group-item"><strong>Laxmi Yoga: </strong><?php echo $this->data['laxmi_yoga']; ?></li>
    <li class="list-group-item"><strong>Gauri Yoga: </strong><?php echo $this->data['gauri_yoga']; ?></li>
    <li class="list-group-item"><strong>Chapa Yoga: </strong><?php echo $this->data['chapa_yoga']; ?></li>
    <li class="list-group-item"><strong>Sreenatha Yoga: </strong><?php echo $this->data['sreenatha_yoga']; ?></li>
    <li class="list-group-item"><strong>Mallika Yoga: </strong><?php echo $this->data['malika_yoga']; ?></li>
    <li class="list-group-item"><strong>Sankha Yoga: </strong><?php echo $this->data['sankha_yoga']; ?></li>
    <li class="list-group-item"><strong>Daridra Yoga: </strong><?php echo $this->data['daridra_yoga']; ?></li>
    <li class="list-group-item"><strong>Bheri Yoga: </strong><?php echo $this->data['bheri_yoga']; ?></li>
    <li class="list-group-item"><strong>Mridanga Yoga: </strong><?php echo $this->data['mridanga_yoga']; ?></li>
    <li class="list-group-item"><strong>Gaja Yoga: </strong><?php echo $this->data['gaja_yoga']; ?></li>
    <li class="list-group-item"><strong>Kalnidhi Yoga: </strong><?php echo $this->data['kalnidhi_yoga']; ?></li>
    <li class="list-group-item"><strong>Amsavatara Yoga: </strong><?php echo $this->data['amsavatara_yoga']; ?></li>
    <li class="list-group-item"><strong>Kusuma Yoga: </strong><?php echo $this->data['kusuma_yoga']; ?></li>
</ul>
<div class="mb-3"></div>
<?php unset($this->data); ?>
