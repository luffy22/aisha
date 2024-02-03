<?php
defined('_JEXEC') or die;
//print_r($this->order);exit;
//print_r($this->pagination);exit;
?>
<div class="lead alert alert-dark">Your Orders</div>
   <p class="d-flex justify-content-end">
        <?php echo $this->pagination->getPagesCounter(); ?>
    </p>
<?php
foreach($this->order as $result)
{
    $date   = new DateTime(); $date->setTimestamp($result->dob_tob);
    $dateasked = new DateTime($result->ques_ask_date);
?>
<ul class="list-group">
	<li class="list-group-item list-group-item-primary">
		<?php
			if($result->order_type == "long_ans" || $result->order_type == "short_ans")
			{
		?>
		<a class="btn btn-link" href="<?php echo JUri::base().'getanswer?order='.$result->UniqueID.'&ref='.$result->email; ?>"><i class="bi bi-eye-fill"></i> View Order</a></li>
		<?php
		}
		else if($result->order_type == "life" || $result->order_type == "marriage" || 
				$result->order_type == "career" || $result->order_type == "sadesati" || 
				$result->order_type == "yearly" || $result->order_type == "education")
		{
		?>
		<a class="btn btn-link" href="<?php echo JUri::base().'read-report?order='.$result->UniqueID.'&ref='.$result->email; ?>"><i class="bi bi-eye-fill"></i> View Order</a></li>
		<?php
		}
		else
		{
		?>
		<a class="btn btn-link" href="<?php echo JUri::base().'getanswer?order='.$result->UniqueID.'&ref='.$result->email; ?>"><i class="bi bi-eye-fill"></i> View Order</a></li>
		<?php
		}
		?>
    <li class="list-group-item">Order Id: <?php echo $result->UniqueID; ?></li>
    <li class="list-group-item">Name: <?php echo $result->name; ?></li>
    <li class="list-group-item">Order Type: <?php if($result->order_type=='short_ans' || $result->order_type == 'short'){echo "Short Answer";}
    else if($result->order_type == "long_ans"){echo "Detailed Report";}
    else if($result->order_type == "life"){echo "Life Report";} 
    else if($result->order_type == "marriage"){echo "Marriage Report"; }
    else if($result->order_type == "education"){echo "Education Report";} 
    else if($result->order_type == "career"){echo "Career Report"; }
    else if($result->order_type == "yearly"){echo "Yearly Report"; }
    else if($result->order_type == "sadesati"){echo "Sade-Sati Report"; }
    else{echo "Detailed Report"; }?></li>
    <?php
			if($result->order_type == "long_ans" || $result->order_type == "short_ans" 
				|| $result->order_type == "short")
			{
    ?>
    <li class="list-group-item">Number of Ques: <?php echo $result->no_of_ques ?></li>
    <?php
		}
    ?>
     <li class="list-group-item">Question asked on: <?php echo $dateasked->format('dS F Y'); ?></li>
</ul><div class="mb-3"></div>
<?php
}
?>
<div class="mb-4"></div>
    <p class="d-flex justify-content-end">
        <?php echo $this->pagination->getPagesCounter(); ?>
    </p>
    <p class="d-flex justify-content-start">
    <?php echo $this->pagination->getPagesLinks(); ?>
    </p>
<?php
unset($this->order);unset($this->pagination);
?>

