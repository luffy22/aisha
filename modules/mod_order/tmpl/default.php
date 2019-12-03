<?php 
defined('_JEXEC') or die;
//print_r($order);exit;
?>
<?php
    if(JUri::current()  == JUri::base())
    {  
        for($i=0;$i< count($order);$i++)
        {
            if($order[$i]['on_home'] == "yes" && ($order[$i]['service_for_charge'] == "long"||
                    $order[$i]['service_for_charge'] == "short"))
            {
                $type       = substr($order[$i]['service_for_charge'],-5);
                $discount   = round(($order[$i]['amount']*$order[$i]['disc_percent'])/100,2);
                $disc_price = $order[$i]['amount'] - $discount;
                $currency   = $order[$i]['currency'];
                if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
?>
<div class="p-3 row alert alert-dark">
    
    <div class="col-4"><img src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="right"  /></div>
    <div class="col-8"><br/><a href="<?php echo JUri::base().'ask-question?uname=luffy22&ques=1&type='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode; ?>"><p class="lead"> <?php echo $order[$i]['text_before']." <s>".$order[$i]['amount']."&nbsp;".$order[$i]['curr_code']."</s> "; ?>
            <br/><?php echo $disc_price." ".$order[$i]['curr_code']; ?> only
        </p></a></div>          
</div>
<?php
            }
            else if($order[$i]['on_home'] == "yes" && ($order[$i]['service_for_charge'] == "life"||
                    $order[$i]['service_for_charge'] == "marriage" ||
                    $order[$i]['service_for_charge'] == "career" ||
                    $order[$i]['service_for_charge'] == "sade-sati"||
                    $order[$i]['service_for_charge'] == "yearly"))
            {
                $type       = $order[$i]['service_for_charge'];
                $discount   = round(($order[$i]['amount']*$order[$i]['disc_percent'])/100,2);
                $disc_price = $order[$i]['amount'] - $discount;
                $currency   = $order[$i]['currency'];
                if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
?>
<div class="p-3 row alert alert-dark">
    
    <div class="col-4"><img src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="right"  /></div>
    <div class="col-8"><br/><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"> <?php echo $order[$i]['text_before']." <s>".$order[$i]['amount']."&nbsp;".$order[$i]['curr_code']."</s> "; ?>
            <br/><?php echo $disc_price." ".$order[$i]['curr_code']; ?> only
        </p></a></div>          
</div>
<?php
            }
             
        }
    }
?>
<div class="mb-3"></div>