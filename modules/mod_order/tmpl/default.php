<?php 
defined('_JEXEC') or die;
//print_r($order);exit;
$current        = JUri::current();
$year = date("Y"); 
$menualias = JFactory::getApplication()->getMenu()->getActive()->alias;
$date       = new DateTime();
$date_mar   = new Datetime("03/11/".$year);
$date_apr   = new DateTime("04/10/".$year);
$date_oct   = new Datetime("09/26/".$year);
$date_nov   = new DateTime("10/10/".$year);
?>

<?php
    if($current  == JUri::base())
    {
        if($date > $date_mar && $date < $date_apr)
        {
?>          <div class="jumbotron jumbotron-fluid bg-light p-3">
                        <p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/astro_bday.png' ?>" align="left" hspace="10"  />Birthday Discount. We are giving away 20% off on all orders.</p>
                        <a class="btn btn-primary" href="#" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
            </div>
            
<?php
        }
        else if($date > $date_oct && $date < $date_nov)
        {
?>
            <div class="jumbotron jumbotron-fluid bg-light p-3">
                        <p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/astro_diwali.png' ?>" align="left" hspace="10"  />Diwali Bonanza. We are giving away 20% off on all orders</p>
                        <a class="btn btn-primary" href="#" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
            </div>
<?php
        }
        else
        {
            //print_r($order);exit;
            for($i=0;$i< count($order);$i++)
            {
                if($order[$i]['on_home'] == "yes" && ($order[$i]['service_for_charge'] == "long"||
                        $order[$i]['service_for_charge'] == "short"))
                {
                    $type       = $order[$i]['service_for_charge'];
                    $amount     = $order[$i]['amount'];
                    $discount   = round(($order[$i]['amount']*$order[$i]['disc_percent'])/100,2);
                    $disc_price = $order[$i]['amount'] - $discount;
                    $currency   = $order[$i]['currency'];
                    if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
                    if($amount == $disc_price)
                    {
    ?>  
                    <div class="jumbotron jumbotron-fluid bg-light p-3">
                        <p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[$i]['text_before']." ".$amount."&nbsp;".$currency; ?> only</p>
                        <a class="btn btn-primary" href="<?php echo JUri::base().$type.'-ans' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
                    </div>
    <?php
                    }
                    else
                    {
     ?>
                    <div class="jumbotron jumbotron-fluid bg-light p-3">
                        <p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[$i]['text_before']." <s>".$order[$i]['amount']."&nbsp;".$currency."</s> "; ?>
                        <br/><?php echo $disc_price." ".$currency; ?> only</p>
                        <a class="btn btn-primary" href="<?php echo JUri::base().$type.'-ans' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
                    </div>
                    <?php            
                    }
                }
                else if($order[$i]['on_home'] == "yes" && ($order[$i]['service_for_charge'] == "life"||
                        $order[$i]['service_for_charge'] == "marriage" ||
                        $order[$i]['service_for_charge'] == "career" ||
                        $order[$i]['service_for_charge'] == "finance"||
                        $order[$i]['service_for_charge'] == "education"||
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
        <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[$i]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[$i]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
	</div>
    <?php
                    }
                    else
                    {
     ?>
        <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[$i]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[$i]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
                <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[$i]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
	</div>
    <?php
                    }
                }

            }
        }
    }
    else if($menualias == "yearly")
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
            <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[4]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[4]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[3]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
            </div>
<?php
        }
        else
        {
 ?>
            <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[4]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[4]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
                    <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[4]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>		
            </div>
<?php
        }
    }
    else if($menualias == "relationship" || $menualias == "findspouse" || $menualias == "divorce"
            || $menualias == "mangaldosha" || $menualias == "latemarry")
    {
        $type       = $order[5]['service_for_charge'];
        $amount     = $order[5]['amount'];
        $discount   = round(($order[5]['amount']*$order[5]['disc_percent'])/100,2);
        $disc_price = $amount - $discount;
        $currency   = $order[5]['currency'];
        if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
        if($amount == $disc_price)
        {
?>           <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[5]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[5]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[5]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
            </div>
            
<?php
        }
        else
        {
 ?>
            <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[5]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[5]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
                    <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[5]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
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
            <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[4]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[4]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[4]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
            </div>
<?php
        }
        else
        {
 ?>
            <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[4]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[4]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
                    <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[4]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
            </div>
<?php
        }
    }
    else if($menualias == "study")
    {
		//print_r($order);exit;
        $type       = $order[7]['service_for_charge'];
        $amount     = $order[7]['amount'];
        $discount   = round(($order[7]['amount']*$order[4]['disc_percent'])/100,2);
        $disc_price = $amount - $discount;
        $currency   = $order[7]['currency'];
        if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
        if($amount == $disc_price)
        {
?>
            <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[7]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[7]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[7]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
            </div>
<?php
        }
        else
        {
 ?>
            <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[7]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[7]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
                    <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[7]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
            </div>
<?php
        }
    }
    else if($menualias == "horoscope" || $menualias == "mainchart" || $menualias == "astroyogas"
            || $menualias == "yogas" || $menualias == "planet-bhavas" || $menualias == "transits"||$menualias == "ascendant" || $menualias == "nakshatra" ||
            $menualias == "planets")
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
            <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[2]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[2]['text_before']." ".number_format((float)$amount,2)."&nbsp;".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[2]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
            </div>
<?php
        }
        else
        {
 ?>
            <div class="jumbotron jumbotron-fluid bg-light p-3">
		<p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[2]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[2]['text_before']." <s>".number_format((float)$amount,2)."&nbsp;".$currency."</s> "; ?>
                    <br/><?php echo number_format((float)$disc_price,2)." ".$currency; ?> only</p>
		<a class="btn btn-primary" href="<?php echo JUri::base().$order[2]['service_for_charge'].'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
            </div>        
<?php
        }
    }
    else if($menualias == "signs" || $menualias == "house")
    {
        $type       = $order[0]['service_for_charge'];
        $amount     = $order[0]['amount'];
        $discount   = round(($order[0]['amount']*$order[0]['disc_percent'])/100,2);
        $disc_price = $amount - $discount;
        $currency   = $order[0]['currency'];
        if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
       if($amount == $disc_price)
        {
?>
            <div class="jumbotron jumbotron-fluid bg-light p-3">
                <p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[0]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[0]['text_before']." ".$amount."&nbsp;".$currency; ?> only</p>
                <a class="btn btn-primary" href="<?php echo JUri::base().$type.'-ans' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
            </div>
<?php
        }
        else
        {
?>          <div class="jumbotron jumbotron-fluid bg-light p-3">
                <p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[0]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[0]['text_before']." <s>".$order[0]['amount']."&nbsp;".$currency."</s> "; ?>
                <br/><?php echo $disc_price." ".$currency; ?> only</p>
                <a class="btn btn-primary" href="<?php echo JUri::base().$type.'-ans' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
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
            <div class="jumbotron jumbotron-fluid bg-light p-3">
                <p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[6]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[6]['text_before']." ".$amount."&nbsp;".$currency; ?> only</p>
                <a class="btn btn-primary" href="<?php echo JUri::base().$type.'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
            </div>
<?php
        }
        else
        {
 ?>
            <div class="jumbotron jumbotron-fluid bg-light p-3">
                <p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[6]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[6]['text_before']." <s>".$order[6]['amount']."&nbsp;".$currency."</s> "; ?>
                <br/><?php echo $disc_price." ".$currency; ?> only</p>
                <a class="btn btn-primary" href="<?php echo JUri::base().$type.'-report' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
            </div>
<?php
        }
    }
    else if($menualias == "ask-question" || $menualias == "order-report" || $menualias =="marriage-report" || $menualias == "life-report" ||
            $menualias == "career-report" || $menualias == "finance-report" || $menualias == "long-ans" || $menualias == "short-ans")
    {
        
    }
    else
    {
        $type       = $order[1]['service_for_charge'];
        $amount     = $order[1]['amount'];
        $discount   = round(($order[1]['amount']*$order[1]['disc_percent'])/100,2);
        $disc_price = $amount - $discount;
        $currency   = $order[1]['currency'];
        if($currency == "INR"){$pay_mode = "paytm";}else{$pay_mode = "paypal";}
        if($amount == $disc_price)
        {
?>
            <div class="jumbotron jumbotron-fluid bg-light p-3">
                <p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[1]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[1]['text_before']." ".$amount."&nbsp;".$currency; ?> only</p>
                <a class="btn btn-primary" href="<?php echo JUri::base().$type.'-ans' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
            </div>
<?php
        }
        else
        {
?>
            <div class="jumbotron jumbotron-fluid bg-light p-3">
                <p class="h2"><img class="img-fluid" src="<?php echo JUri::base().'images/'.$order[1]['img_for_text'] ?>" align="left" hspace="10"  /><?php echo $order[1]['text_before']." <s>".$order[1]['amount']."&nbsp;".$currency."</s> "; ?>
                <br/><?php echo $disc_price." ".$currency; ?> only</p>
                <a class="btn btn-primary" href="<?php echo JUri::base().$type.'-ans' ?>" role="button"><i class="bi bi-card-text"></i> Learn More</a>
		
            </div>
<?php
        }
    }
?>
<div class="mb-3"></div>
