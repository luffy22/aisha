<?php
defined('_JEXEC') or die;
//print_r($this->order);exit;
?>
<div class="lead alert alert-dark">Your Orders</div>
<?php
foreach($this->order as $result)
{
    $date   = new DateTime(); $date->setTimestamp($result->dob_tob);
    $dateasked = new DateTime($result->ques_ask_date);
?>
<ul class="list-group">
	<li class="list-group-item"><a class="btn btn-primary" href="<?php echo JUri::base().'getanswer?order='.$result->UniqueID.'&ref='.$result->email; ?>">View Order</a></li>
    <li class="list-group-item">Order Id: <?php echo $result->UniqueID; ?></li>
    <li class="list-group-item">Name: <?php echo $result->name; ?></li>
    <li class="list-group-item">Order Type: <?php if($result->order_type=='short_ans'){echo "Short Answer";}else{echo "Detailed Report";} ?></li>
    <li class="list-group-item">Number of Ques: <?php echo $result->no_of_ques ?></li>
     <li class="list-group-item">Question asked on: <?php echo $dateasked->format('dS F Y'); ?></li>
</ul><div class="mb-3"></div>
<?php
}
?>
<div class="mb-4"></div>
<?php
unset($this->order);
?>

