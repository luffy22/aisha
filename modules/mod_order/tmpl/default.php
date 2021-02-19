<?php 
defined('_JEXEC') or die;
//print_r($order);exit;
$current        = JUri::current();
$menualias = JFactory::getApplication()->getMenu()->getActive()->alias;
$date       = new DateTime();
$date_mar   = new Datetime("03/15/2020");
$date_apr   = new DateTime("04/16/2020");
$date_oct   = new Datetime("10/21/2020");
$date_nov   = new DateTime("11/19/2020");
?>
<?php
    if($current  == JUri::base())
    {
        if($date > $date_mar && $date < $date_apr)
        {
?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img src="<?php echo JUri::base().'images/astro_bday.png' ?>" align="right"  /></div>
                <div class="col-8 pt-4 lead">Astro Isha turns 7 on April 4th. We are giving away 15% off on all <a href="<?php echo JUri::base(); ?>order-report">orders</a> and <a href="<?php echo JUri::base(); ?>ask-question">reports</a> until April 15th.</p></a></div>          
            </div>
<?php
        }
        else if($date > $date_oct && $date < $date_nov)
        {
?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img src="<?php echo JUri::base().'images/astro_diwali.png' ?>" align="right"  /></div>
                <div class="col-8 pt-4 lead">Diwali Bonanza. We are giving away 20% off on all <a href="<?php echo JUri::base(); ?>ask-question">orders</a> and <a href="<?php echo JUri::base(); ?>order-report">reports</a>.</div>          
            </div>
<?php
        }
        else
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
                    <div class="p-1 row alert alert-dark">
                        <div class="col-4"><img src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="right"  /></div>
                        <div class="col-8 pt-4"><a href="<?php echo JUri::base().'ask-question?uname=luffy22&ques=1&type='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode; ?>"><p class="lead"> <?php echo $order[$i]['text_before']." ".$amount."&nbsp;".$currency; ?> only                </p></a></div>          
                    </div>
    <?php
                    }
                    else
                    {
     ?>
                    <div class="p-1 row alert alert-dark">
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
                        $order[$i]['service_for_charge'] == "finance"||
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
    <div class="p-1 row alert alert-dark">

        <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="right"  /></div>
        <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[$i]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only
            </p></a></div>          
    </div>
    <?php
                    }
                    else
                    {
     ?>
    <div class="p-1 row alert alert-dark">

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
    }
    else if($menualias == "yearly")
    {
        $type       = $order[3]['service_for_charge'];
        $amount     = $order[3]['amount'];
        $discount   = round(($order[3]['amount']*$order[3]['disc_percent'])/100,2);
        $disc_price = $amount - $discount;
        $currency   = $order[3]['currency'];
        if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
        if($amount == $disc_price)
        {
?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[3]['img_for_text'] ?>" align="right"  /></div>
                <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[3]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only
                    </p></a></div>          
            </div>
<?php
        }
        else
        {
 ?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[3]['img_for_text'] ?>" align="right"  /></div>
                <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[3]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
                    <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only
                    </p></a></div>          
    </div>
<?php
        }
    }
    else if($menualias == "relationship" || $menualias == "findspouse" || $menualias == "divorce"
            || $menualias == "mangaldosha")
    {
        $type       = $order[5]['service_for_charge'];
        $amount     = $order[5]['amount'];
        $discount   = round(($order[5]['amount']*$order[5]['disc_percent'])/100,2);
        $disc_price = $amount - $discount;
        $currency   = $order[5]['currency'];
        if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
        if($amount == $disc_price)
        {
?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[5]['img_for_text'] ?>" align="right"  /></div>
                <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[5]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only
                    </p></a></div>          
            </div>
<?php
        }
        else
        {
 ?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[5]['img_for_text'] ?>" align="right"  /></div>
                <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[5]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
                    <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only
                    </p></a></div>          
    </div>
<?php
        }
    }
    else if($menualias == "career" || $menualias == "careerfind")
    {
        $type       = $order[4]['service_for_charge'];
        $amount     = $order[4]['amount'];
        $discount   = round(($order[4]['amount']*$order[4]['disc_percent'])/100,2);
        $disc_price = $amount - $discount;
        $currency   = $order[4]['currency'];
        if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
        if($amount == $disc_price)
        {
?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[4]['img_for_text'] ?>" align="right"  /></div>
                <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[4]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only
                    </p></a></div>          
            </div>
<?php
        }
        else
        {
 ?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[4]['img_for_text'] ?>" align="right"  /></div>
                <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[4]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
                    <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only
                    </p></a></div>          
    </div>
<?php
        }
    }
    else if($menualias == "horoscope" || $menualias == "mainchart" || $menualias == "astroyogas"
            || $menualias == "yogas" || $menualias == "planet-bhavas" || $menualias == "transits")
    {
        $type       = $order[2]['service_for_charge'];
        $amount     = $order[2]['amount'];
        $discount   = round(($order[2]['amount']*$order[2]['disc_percent'])/100,2);
        $disc_price = $amount - $discount;
        $currency   = $order[2]['currency'];
        if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
        if($amount == $disc_price)
        {
?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[2]['img_for_text'] ?>" align="right"  /></div>
                <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[2]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only
                    </p></a></div>          
            </div>
<?php
        }
        else
        {
 ?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[2]['img_for_text'] ?>" align="right"  /></div>
                <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[2]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
                    <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only
                    </p></a></div>          
    </div>
<?php
        }
    }
    else if($menualias == "ascendant" || $menualias == "nakshatra" ||
            $menualias == "planets" || $menualias == "signs" || $menualias == "house")
    {
        $type       = $order[0]['service_for_charge']."_ans";
        $amount     = $order[0]['amount'];
        $discount   = round(($order[0]['amount']*$order[0]['disc_percent'])/100,2);
        $disc_price = $amount - $discount;
        $currency   = $order[0]['currency'];
        if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
       if($amount == $disc_price)
        {
?>
        <div class="p-1 row alert alert-dark">
            <div class="col-4"><img src="<?php echo JUri::base().'images/'.$order[0]['img_for_text'] ?>" align="right"  /></div>
            <div class="col-8 pt-4"><a href="<?php echo JUri::base().'ask-question?uname=luffy22&ques=1&type='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode; ?>"><p class="lead"> <?php echo $order[0]['text_before']." ".$amount."&nbsp;".$currency; ?> only                </p></a></div>          
        </div>
<?php
        }
        else
        {
?>
        <div class="p-1 row alert alert-dark">
            <div class="col-4"><img src="<?php echo JUri::base().'images/'.$order[0]['img_for_text'] ?>" align="right"  /></div>
            <div class="col-8 pt-4"><a href="<?php echo JUri::base().'ask-question?uname=luffy22&ques=1&type='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode; ?>"><p class="lead"> <?php echo $order[0]['text_before']." <s>".$order[0]['amount']."&nbsp;".$currency."</s> "; ?>
            <br/><?php echo $disc_price." ".$currency; ?> only
        </p></a></div>          
        </div>
<?php
        }
    }
    else if($menualias == "featured" || $menualias == "finance" || $menualias == "investwhere")
    {
        $type       = $order[6]['service_for_charge'];
        $amount     = $order[6]['amount'];
        $discount   = round(($order[6]['amount']*$order[6]['disc_percent'])/100,2);
        $disc_price = $amount - $discount;
        $currency   = $order[6]['currency'];
        if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
        if($amount == $disc_price)
        {
?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[6]['img_for_text'] ?>" align="right"  /></div>
                <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[6]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only
                    </p></a></div>          
            </div>
<?php
        }
        else
        {
 ?>
            <div class="p-1 row alert alert-dark">
                <div class="col-4"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[6]['img_for_text'] ?>" align="right"  /></div>
                <div class="col-8 pt-4"><a href="<?php echo JUri::base().'order-report?report='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode ?>"><p class="lead"><?php echo $order[6]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
                    <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only
                    </p></a></div>          
    </div>
<?php
        }
    }
    else if($menualias == "ask-question" || $menualias == "order-report")
    {
        
    }
    else
    {
        $type       = $order[1]['service_for_charge']."_ans";
        $amount     = $order[1]['amount'];
        $discount   = round(($order[1]['amount']*$order[1]['disc_percent'])/100,2);
        $disc_price = $amount - $discount;
        $currency   = $order[1]['currency'];
        if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
        if($amount == $disc_price)
        {
?>
        <div class="p-1 row alert alert-dark">
            <div class="col-4"><img src="<?php echo JUri::base().'images/'.$order[1]['img_for_text'] ?>" align="right"  /></div>
            <div class="col-8 pt-4"><a href="<?php echo JUri::base().'ask-question?uname=luffy22&ques=1&type='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode; ?>"><p class="lead"> <?php echo $order[1]['text_before']." ".$amount."&nbsp;".$currency; ?> only</p></a></div>          
        </div>
<?php
        }
        else
        {
?>
        <div class="p-1 row alert alert-dark">
            <div class="col-4"><img src="<?php echo JUri::base().'images/'.$order[1]['img_for_text'] ?>" align="right"  /></div>
            <div class="col-8 pt-4"><a href="<?php echo JUri::base().'ask-question?uname=luffy22&ques=1&type='.$type.'&fees='.$disc_price.'_'.$currency.'&pay_mode='.$pay_mode; ?>"><p class="lead"> <?php echo $order[1]['text_before']." <s>".$order[1]['amount']."&nbsp;".$currency."</s> "; ?>
            <br/><?php echo $disc_price." ".$currency; ?> only
        </p></a></div>          
        </div>
<?php
        }
    }
?>
<div class="mb-3"></div>
