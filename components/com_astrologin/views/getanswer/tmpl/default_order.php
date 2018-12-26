
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
 //print_r($this->order);exit;
?>
<div class="mb-2"></div>
<div class="card card-outline-info">
    <div class="card-header"><strong>Get Answer For Order</strong></div>
   <ul class="list-group list-group-flush">
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
     ?>
    </li>
    <li class="list-group-item">
      <?php
            if(isset($refemail) && $refemail==$this->order->email)
            {
      ?>
                Email: <?php echo $this->order->email; ?>
     <?php
            }
            else
            {
                echo "Email: Hidden To Protect Customer Privacy";
            }
            $date   = new DateTime(); $date->setTimestamp($this->order->dob_tob);
     ?>
    </li>
    <li class="list-group-item">Gender: <?php echo $this->order->gender; ?></li>
    <li class="list-group-item">Date Of Birth: <?php echo $date->format('d-m-Y'); ?></li>
    <li class="list-group-item">Time Of Birth: <?php echo $date->format('h:i:s a');?></li>
    <li class="list-group-item">Place Of Birth: <?php echo $this->order->pob; ?></li>
    <li class="list-group-item">Answer Type: <?php if($this->order->order_type=="short_ans"){echo "Short Answer";}else{echo "Detailed Report";} ?></li>
  </ul>
</div>
<div class="mb-2"></div>
<?php
foreach($this->ques as $ques)
{
?>
<div class="card card-outline-info">
    <div class="card-header">Topic: <?php echo $ques->ques_topic; ?></div>
    <div class="card-block">
        <div class="card-title">Question: <?php echo $ques->ques_ask; ?></div>
        <p class="card-text"><?php echo $ques->ques_details; ?></p>
        <div class="card-header"><strong>Answer: </strong></div>
        <div class="mb-2"></div>
        <p class="card-text"><?php if(empty($ques->ques_answer)){echo "Not Yet Answered"; }else{echo $ques->ques_answer;} ?></p>
    </div>
</div>
<?php
}
?>
<div class="mb-2"></div>
