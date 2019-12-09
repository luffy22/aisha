<?php 
defined('_JEXEC') or die;
///print_r($order);exit;
?>
<?php
    if(JUri::current()  == JUri::base())
    {  
        for($i=0;$i< count($order);$i++)
        {
            if($order[$i]['on_home'] == "yes" && ($order[$i]['service_for_charge'] == "long"||
                    $order[$i]['service_for_charge'] == "short"))
            {
                $type       = $order[$i]['service_for_charge'].'_ans';
                $amount     = $order[$i]['amount'];
                $discount   = round(($order[$i]['amount']*$order[$i]['disc_percent'])/100,2);
                $disc_price = $order[$i]['amount'] - $discount;
                $currency   = $order[$i]['currency'];
                if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
                if($amount == $disc_price)
                {
?>
                <div class="p-3 row alert alert-dark">
                    <div class="col-4"><img src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="right"  /></div>
                    <div class="col-8 pt-5"><a href="<?php echo JUri::base().'ask-question?uname=luffy22&ques=1&type='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode; ?>"><p class="lead"> <?php echo $order[$i]['text_before']." ".$amount."&nbsp;".$currency; ?> only                </p></a></div>          
                </div>
<?php
                }
                else
                {
 ?>
                <div class="p-3 row alert alert-dark">
                    <div class="col-4"><img src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="right"  /></div>
                    <div class="col-8 pt-4"><a href="<?php echo JUri::base().'ask-question?uname=luffy22&ques=1&type='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode; ?>"><p class="lead"> <?php echo $order[$i]['text_before']." <s>".$order[$i]['amount']."&nbsp;".$currency."</s> "; ?>
                    <br/><?php echo $disc_price." ".$currency; ?> only
                </p></a></div>          
                </div>
 <?php            
                }
            }
            else if($order[$i]['on_home'] == "yes" && ($order[$i]['service_for_charge'] == "life"||
                    $order[$i]['service_for_charge'] == "marriage" ||
                    $order[$i]['service_for_charge'] == "career" ||
                    $order[$i]['service_for_charge'] == "sade-sati"||
                    $order[$i]['service_for_charge'] == "yearly"))
            {
                $type       = $order[$i]['service_for_charge'];
                $amount     = $order[$i]['amount'];
                $discount   = round(($order[$i]['amount']*$order[$i]['disc_percent'])/100,2);
                $disc_price = $amount - $discount;
                $currency   = $order[$i]['currency'];
                if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
                if($amount == $disc_price)
                {
?>
<div class="p-3 row alert alert-dark">
    
    <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="right"  /></div>
    <div class="col-8 pt-5"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[$i]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only
        </p></a></div>          
</div>
<?php
                }
                else
                {
 ?>
<div class="p-3 row alert alert-dark">
    
    <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="right"  /></div>
    <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[$i]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
            <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only
        </p></a></div>          
</div>
<?php
                }
            }
             
        }
    }
?>
<div class="mb-3"></div>