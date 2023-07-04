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
//print_r($this->order);
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
<?php
if($this->details->order_type=="life")
{
?>
<div class="container"><div class="row">
<div class="col-4 text-left"><a href="<?php echo Juri::base().'readsadesati?order='.$order.'&ref='.$refemail; ?>"><i class="fas fa-arrow-left"></i> Previous</a></div>
<div class="col-4 text-center"><a href="<?php echo Juri::base().'read-report?order='.$order.'&ref='.$refemail; ?>"><i class="fas fa-home"></i> Report Home</a></div>
</div></div>
<?php
}
else
{
?>
<div class="container"><div class="row">
<div class="col-4 text-left"><a href="<?php echo Juri::base().'read-report?order='.$order.'&ref='.$refemail; ?>"><i class="bi bi-house-fill fs-2"></i> Report Home</a></div>
</div></div>  
<?php    
}
$count 	= count($this->order);
for($i=0;$i<$count;$i++)
{
?>
<div class="mb-4"></div>
<div class="lead alert alert-dark">Question <?php echo $i+1; ?></div>
<p><strong>Topic: </strong><?php echo ucfirst($this->order[$i]->query_about); ?></p>
<p><strong>Background: </strong><?php echo ucfirst($this->order[$i]->query_explain); ?></p>
<div class="lead alert alert-dark">Answer</div>
<?php
if(empty($this->order[$i]->query_answer))
{
    echo "Not yet answered<br/><br/>";
}
else
{
    echo $this->order[$i]->query_answer;
}

?>
<div clas="mb-4"></div>
<?php
}
unset($this->order);unset($this->details);
?>

