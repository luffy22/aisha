<?php
defined('_JEXEC') or die;
//print_r($this->order);exit;
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
<p class="text-right"><a href="<?php echo JUri::base(); ?>getorder?order=<?php echo $this->order->UniqueID ?>&ref=<?php echo $this->order->email; ?>"><i class="fas fa-shopping-cart"></i> Your Orders</a></p>
<div class="mb-3"></div>
    <div class="lead alert alert-dark">Order Details</div>
   <ul class="list-group">
    <li class="list-group-item">Order ID: <?php echo $this->order->UniqueID; ?></li>
    <li class="list-group-item">
      <?php
            if(isset($refemail) && $refemail==$this->order->email)
            {
      ?>
                Name: <?php echo $this->order->name; ?>
     <?php
            }
            else
            {
                echo "Name: Hidden To Protect Customer Privacy";
            }
            $date   = new DateTime(); $date->setTimestamp($this->order->dob_tob);
     ?>
    </li>
    <li class="list-group-item">Gender: <?php echo $this->order->gender; ?></li>
    <li class="list-group-item">Date Of Birth: <?php echo $date->format('dS F Y'); ?></li>
    <li class="list-group-item">Time Of Birth: <?php echo $date->format('h:i:s a');?></li>
    <li class="list-group-item">Place Of Birth: <?php echo $this->order->pob; ?></li>
    <li class="list-group-item">Answer Type: <?php if($this->order->order_type=="short_ans"){echo "Short Answer";}else if($this->order->order_type=="short"){echo "Short Answer";}else{echo "Detailed Report";} ?></li>
  </ul>
<div class="mb-4"></div>
<?php
foreach($this->ques as $ques)
{
?>
    <div class="lead alert alert-dark">Topic: <?php echo $ques->ques_topic; ?></div>
    <div class="lead">Question: <?php echo $ques->ques_ask; ?></div>
         <p><?php echo $ques->ques_details; ?></p>
    <div class="mb-3"></div>
        <div class="lead alert alert-dark">Answer: </div>
        <p><?php if(empty($ques->ques_answer)){echo "Not Yet Answered"; }else{echo $ques->ques_answer;} ?></p>
<div class="mb-4"></div>
<?php
}
if($this->order->order_type == "long_ans")
{
?>
<div class="lead alert alert-dark">Summary: </div>
    <p><?php if(empty($this->summary)){echo "Not yet summarized"; }else{echo $this->summary->summary_txt;} ?></p>
<?php
}
?>
<div class="mb-4"></div>
<?php
unset($this->order);
?>

