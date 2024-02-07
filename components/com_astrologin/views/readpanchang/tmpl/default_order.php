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
<?php
}
$text 			= array("Main Chart","Moon Chart","Navamsha Chart","Dashamsha Chart",
						"Birth Tithi","Birth Nakshatra","Moon Sign","Yoga At Birth Time","Karan At Birth Time");
//print_r($this->order);exit;
//print_r($this->details);exit;
?>
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
                                                  else if($this->details->order_type=="detailed"){echo "Detailed Answer"; }
                                                  else{echo "Detailed Report";} ?></li>
  </ul>
<div class="mb-4"></div>
<div class="d-flex justify-content-between">
<div>
	<i class="bi bi-arrow-left-circle-fill"></i> Prev
</div>
<div>
	<a href="<?php echo Juri::base().'read-report?order='.$order.'&ref='.$refemail; ?>"><i class="bi bi-house-door-fill"></i> Report Home</a>
</div>
<div>
	<a href="<?php echo Juri::base().'readplanet?order='.$order.'&ref='.$refemail; ?>">Next <i class="bi bi-arrow-right-circle-fill"></i></a>
</div>
</div>
<div class="mb-4"></div>
<?php
if(array_key_exists("order_full_text",$this->order))
{

	// For old orders before introduction of different segments(Prior to 2024)
	if(empty($this->order['order_full_text']))
	{
		echo "Not yet answered<br/><br/>";
	}
	else
	{
		echo $this->order['order_full_text'];
	}
}
else
{
?>
<ul class="list-group">
<?php 
	for($i=0,$j=0;$i<count($this->order),$j<count($text);$i++,$j++)
	{
?>
		<li class="list-group-item"><a href="<?php echo Juri::base().'read-report?order='.$order.'&view='.$this->order[$i]; ?>">
		<?php echo $text[$j]; ?></a>
		</li>
<?php
	}
?>
</ul>

<?php	
}
?>
<div class="mb-4"></div>
<?php
unset($this->order);unset($this->details);unset($text);
?>

