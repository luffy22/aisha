<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
//$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
$chart_id = $_GET['chart'];
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
}
 else {
?>
<p>There is <?php echo $this->data['mangaldosha']; ?><span>&#37;</span> Mangal Dosha in your chart. Divorce is less likely due to Mangal Dosha.</p>
<?php    
}
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Planets in the 7th House</div>
<link rel="stylesheet" href="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/circle.css' ?>" type="text/css" />
<?php unset($this->data); ?>
