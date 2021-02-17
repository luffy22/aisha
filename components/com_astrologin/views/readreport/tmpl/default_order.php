<?php
defined('_JEXEC') or die;
if(isset($_GET['order']))
{
    $order      = $_GET['order'];
}
if(isset($_GET['ref']))
{
    $refemail   = $_GET['ref'];
}
if(isset($_GET['payment']) && $_GET['payment']=="success")
{
?>
<div class="progress" style="height:25px">
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Choose</div>
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Details</div>
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Question(s)</div>
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Pay</div>
</div>
<div class="mb-3"></div>
<?php
}
else if(isset($_GET['payment']) && $_GET['payment']=="fail")
{
?>
<div class="progress" style="height:25px">
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Choose</div>
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Details</div>
  <div class="progress-bar bg-success" style="width:25%;height:25px" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Question(s)</div>
  <div class="progress-bar bg-danger" style="width:25%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Pay</div>
</div>
<div class="mb-3"></div>
<?php
}
//print_r($this->order);
//print_r($this->details);exit;
?>
<p class="text-right"><a href="<?php echo JUri::base(); ?>getorder?order=<?php echo $this->details->UniqueID ?>&ref=<?php echo $this->details->email; ?>"><i class="fas fa-shopping-cart"></i> Your Orders</a></p>
<div class="mb-3"></div>
    <div class="lead alert alert-dark">Order Details</div>
   <ul class="list-group">
    <li class="list-group-item">Order ID: <?php echo $this->details->UniqueID; ?></li>
    <li class="list-group-item">
      <?php
            if(isset($refemail) && $refemail==$this->details->email)
            {
      ?>
                Name: <?php echo $this->details->name; ?>
     <?php
            }
            else
            {
                echo "Name: Hidden To Protect Customer Privacy";
            }
            $date   = new DateTime(); $date->setTimestamp($this->details->dob_tob);
     ?>
    </li>
    <li class="list-group-item">Gender: <?php echo $this->details->gender; ?></li>
    <li class="list-group-item">Date Of Birth: <?php echo $date->format('dS F Y'); ?></li>
    <li class="list-group-item">Time Of Birth: <?php echo $date->format('h:i:s a');?></li>
    <li class="list-group-item">Place Of Birth: <?php echo $this->details->pob; ?></li>
    <li class="list-group-item">Order Type: <?php if($this->details->order_type=="career"){echo "Career Report";}
                                                  else if($this->details->order_type=="marriage"){echo "Marriage Report";}
                                                  else if($this->details->order_type=="life"){echo "Life Report"; }
                                                  else if($this->details->order_type=="yearly"){echo "Yearly Report"; }
                                                  else if($this->details->order_type=="sadesati"){echo "Sade-Sati Report"; }
                                                  else if($this->details->order_type=="detailed"){echo "Detailed Answer"; }
                                                  else{echo "Detailed Report";} ?></li>
  </ul>
<div class="mb-4"></div>
<div class="lead alert alert-dark">Full Report</div>
<div clas="mb-4"></div>
<?php
if($this->details->order_type=="life")
{
?>
<ul class="list-group">
    <li class="list-group-item"><a href="<?php echo Juri::base().'readchart?order='.$order.'&ref='.$refemail; ?>">Charts and Panchang</a></li>
    <li class="list-group-item"><a href="<?php echo Juri::base().'readplanet?order='.$order.'&ref='.$refemail; ?>">Analysis of 9 planets</a></li>
    <li class="list-group-item"><a href="<?php echo Juri::base().'readhouses?order='.$order.'&ref='.$refemail; ?>">Analysis of 12 houses</a></li>
    <li class="list-group-item"><a href="<?php echo Juri::base().'readdasha?order='.$order.'&ref='.$refemail; ?>">Analysis of Vimshottari Dasha</a></li>
    <li class="list-group-item"><a href="<?php echo Juri::base().'readyogas?order='.$order.'&ref='.$refemail; ?>">Astro Yogas in your horoscope</a></li>
    <li class="list-group-item"><a href="<?php echo Juri::base().'readforecast?order='.$order.'&ref='.$refemail; ?>">Basic Forecast</a></li>
    <li class="list-group-item"><a href="<?php echo Juri::base().'readsadesati?order='.$order.'&ref='.$refemail; ?>">Sade-Sati Effects</a></li>
    <li class="list-group-item"><a href="<?php echo Juri::base().'astroqueries?order='.$order.'&ref='.$refemail; ?>">Answer to Queries</a></li>
</ul>
<?php
}
else if($this->details->order_type=="marriage")
{
?>
<ul class="list-group">
    <li class="list-group-item"><a href="<?php echo Juri::base().'marriagereport?order='.$order.'&ref='.$refemail; ?>">Marriage Report</a></li>
    <li class="list-group-item"><a href="<?php echo Juri::base().'astroqueries?order='.$order.'&ref='.$refemail; ?>">Query Answer</a></li>
</ul>
<?php
}
else if($this->details->order_type=="career")
{
?>
<ul class="list-group">
    <li class="list-group-item"><a href="<?php echo Juri::base().'careerreport?order='.$order.'&ref='.$refemail; ?>">Career Report</a></li>
    <li class="list-group-item"><a href="<?php echo Juri::base().'astroqueries?order='.$order.'&ref='.$refemail; ?>">Query Answer</a></li>
</ul>
<?php
}
else if($this->details->order_type=="finance")
{
?>
<ul class="list-group">
    <li class="list-group-item"><a href="<?php echo Juri::base().'financereport?order='.$order.'&ref='.$refemail; ?>">Financial Report</a></li>
    <li class="list-group-item"><a href="<?php echo Juri::base().'astroqueries?order='.$order.'&ref='.$refemail; ?>">Query Answer</a></li>
</ul>
<?php
}
else if($this->details->order_type=="yearly")
{
?>
<ul class="list-group">
    <li class="list-group-item"><a href="<?php echo Juri::base().'yearlyreport?order='.$order.'&ref='.$refemail; ?>">Yearly Report</a></li>
    <li class="list-group-item"><a href="<?php echo Juri::base().'astroqueries?order='.$order.'&ref='.$refemail; ?>">Query Answer</a></li>
</ul>
<?php
}
else
{
    echo "Not yet answered";    
}
?>
<div clas="mb-4"></div>
<?php
unset($this->order);unset($this->details);
?>

