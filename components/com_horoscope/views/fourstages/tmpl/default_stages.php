<html>
 <head>
<style type="text/css">
#stage_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#stage_canvas{width:65%}}
</style>
</head>
<body onload="javascript:draw_horoscope();getAscendant();">
<?php $chart_id = $_GET['chart']; ?>
<div class="mb-3"></div>
<?php
defined('_JEXEC') or die();
//echo JPATH_COMPONENT.DS.'script/horoscope.js';exit;
//print_r($this->data);exit;
$document = JFactory::getDocument(); 
$document->setTitle(strtolower($this->data['fname']).' stages');
$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");

?>
<div class="mb-3"></div>
<canvas id="stage_canvas" height="260">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-2"></div>
<p>Blocks with grey background are quadrant houses symbolizing four stages of your life.</p>
 <form>
   <?php
        foreach($planets as $planet)
        {
   ?>
            <input type="hidden" name="<?php echo strtolower($planet)."_sign" ?>" id="<?php echo strtolower($planet)."_sign" ?>" value="<?php echo $this->data[$planet] ?>"/>
  <?php
        }
   ?>
</form>
<div class="lead alert alert-dark">Childhood</div>
<ul class="list-group">
    <li class="list-group-item"><strong>First House/Ascendant controls your Childhood.</strong></li>
        <?php
            $count_1        = $this->data['house_1'];
            $count_2        = $this->data['aspect_1'];
        ?>
    <li class="list-group-item"><strong>Placements: </strong>There 
        <?php
        if($count_1 == "0")
         {
             echo " are no planets ";
         }
         else
         {
            echo " is ";
            for($i=0; $i< $count_1;$i++) 
            {
                $j          = $i+1;
                $cond       = $this->data['house_condition_1_'.$j];
                $planet     = $this->data['house_1_'.$j];
                 if($i == "0" || $i+1 == $count_1)
                {
                    if($cond == "none")
                    {
                        echo " ".$planet;
                    }
                    else
                    {
                        echo " ".$cond." ".$planet." ";
                    }
                }
                else
                {
                    if($cond == "none")
                    {
                        echo ", ".$planet;
                    }
                    else
                    {
                        echo ", ".$cond." ".$planet;
                    }
                }
            }
         }
        ?>
        in your 1st house.
    </li>
    <li class="list-group-item"><strong>Aspects: </strong>There  
        <?php
        if($count_2 == "0")
         {
             echo " are no aspect ";
         } 
         else
         {
             echo " is aspect of";

            for($i=0; $i< $count_2;$i++) 
            {
                $j          = $i+1;
                $planet     = $this->data['aspect_1_'.$j];
                 if($i == "0") 
                {
                    
                    echo " ".$planet;
                   
                }
                else if($i == $count_2)
                {
                    echo $planet." ";
                }
                else
                {
                    echo ", ".$planet;     
                }
            }
         }
        ?>
        on your 1st house.
    </li>
<?php
        if($this->data['status_1'] == "Good Phase")
        {
?>
        <li class="list-group-item list-group-item-success">
            <i class="fas fa-smile"></i> Your childhood should generally be a happy affair.
        </li>
<?php
        }
        else if($this->data['status_1'] == "Very Good Phase")
        {
?>
            <li class="list-group-item list-group-item-success">
            <i class="fas fa-smile"></i> <i class="fas fa-thumbs-up"></i> Your childhood should be a very happy affair.
            </li>
<?php
        }
        else if($this->data['status_1'] == "Bad Phase")
        {
?>
            <li class="list-group-item list-group-item-danger">
            <i class="fas fa-frown"></i> Your childhood should be quite difficult.
            </li>
<?php
        }
        else if($this->data['status_1'] == "Very Bad Phase")
        {
?>
                <li class="list-group-item list-group-item-danger">
            <i class="fas fa-frown"></i> <i class="fas fa-thumbs-down"></i> Your childhood should be very difficult and full of problems.
                </li>
<?php
        }
?>
</ul><div class="mb-3"></div>
<div class="lead alert alert-dark">Youth</div>
<ul class="list-group">
    <li class="list-group-item"><strong>Tenth House controls your Youth.</strong></li>
    <li class="list-group-item"><strong>Placements: </strong>
        <?php
            $count_10        = $this->data['house_10'];
            $asp_10         = $this->data['aspect_10']
        ?>
        There 
        <?php
        if($count_10 == "0")
        {
            echo " are no planets ";
        }
        else
        {
            echo " is ";
            for($i=0; $i< $count_10;$i++) 
            {
                
                $j          = $i+1;
                $condition  = $this->data['house_condition_10_'.$j];
                $planet     = $this->data['house_10_'.$j];
                 if($i == "0" || $i+1 > $count_10)
                {
                    if($condition == "none")
                    {
                        echo " ".$planet;
                    }
                    else
                    {
                        echo " ".$condition." ".$planet." ";
                    }
                }
                else
                {
                    if($condition == "none")
                    {
                        echo ", ".$planet;
                    }
                    else
                    {
                        echo ", ".$condition." ".$planet;
                    }
                }
            }
        }
        ?>
        in your 10th house.
    </li>
    <li class="list-group-item"><strong>Aspects:</strong> There 
        <?php
        if($asp_10 == "0")
        {
            echo " are no aspects ";
        }
        else
        {
            echo " is aspect of ";
            for($i=0; $i< $asp_10;$i++) 
            {
                $j          = $i+1;
                $planet     = $this->data['aspect_10_'.$j];
                 if($i == "0" || $i+1 > $asp_10)
                {
                    
                    echo $planet;
                   
                }
                else
                {
                    echo ", ".$planet;     
                }
            }
        }
    ?>
        on your 10th house.
    </li>
    <?php
        if($this->data['status_10'] == "Good Phase")
        {
?>
        <li class="list-group-item list-group-item-success">
            <i class="fas fa-smile"></i> Your youth years should generally be a happy affair.
        </li>
<?php
        }
        else if($this->data['status_10'] == "Very Good Phase")
        {
?>
            <li class="list-group-item list-group-item-success">
            <i class="fas fa-smile"></i> <i class="fas fa-thumbs-up"></i> Your youth years should be a very happy affair.
            </li>
<?php
        }
        else if($this->data['status_10'] == "Bad Phase")
        {
?>
            <li class="list-group-item list-group-item-danger">
            <i class="fas fa-frown"></i> Your youth years should be quite difficult.
            </li>
<?php
        }
        else if($this->data['status_10'] == "Very Bad Phase")
        {
?>
                <li class="list-group-item list-group-item-danger">
            <i class="fas fa-frown"></i> <i class="fas fa-thumbs-down"></i> Your youth years should be very difficult and full of problems.
                </li>
<?php
        }
?>
</ul><div class="mb-3"></div>
<div class="lead alert alert-dark">Middle-Age</div>
<ul class="list-group">
   <li class="list-group-item"><strong>Seventh House controls your Middle-Life.</strong></li>
  <li class="list-group-item">
        <?php
            $count_7        = $this->data['house_7'];
            $asp_7          = $this->data['aspect_7'];
        ?>
      <strong>Placements: </strong>There 
        <?php
        if($count_7 == "0")
        {
            echo " are no planets ";
        }
        else
        {
            echo " is ";
            for($i=0; $i< $count_7;$i++) 
            {
                $j          = $i+1;
                $condition  = $this->data['house_condition_7_'.$j];
                $planet     = $this->data['house_7_'.$j];
                 if($i == "0" || $i+1 > $count_7)
                {

                    if($condition == "none")
                    {
                        echo $planet;
                    }
                    else
                    {
                        echo $condition." ".$planet;
                    }
                }
                else
                {
                    if($condition == "none")
                    {
                        echo ", ".$planet;
                    }
                    else
                    {
                        echo ", ".$condition." ".$planet;
                    }
                }
            }
        }
?>
        in your 7th house.
    </li>
    <li class="list-group-item"><strong>Aspects:</strong> There 
        <?php
        if($asp_7 == "0")
        {
            echo " are no aspects ";
        }
        else
        {
            echo " is aspect of ";
            for($i=0; $i< $asp_7;$i++) 
            {
                $j          = $i+1;
                $planet     = $this->data['aspect_7_'.$j];
                if($i == "0" || $i+1 > $asp_7)
                {
                    
                    echo $planet;
                   
                }
                else
                {
                    echo ", ".$planet;     
                }
            }
        }
?>
        on your 7th house.
    </li>
    <?php
        if($this->data['status_7'] == "Good Phase")
        {
?>
        <li class="list-group-item list-group-item-success">
            <i class="fas fa-smile"></i> Your mid-life should generally be a happy affair.
        </li>
<?php
        }
        else if($this->data['status_7'] == "Very Good Phase")
        {
?>
            <li class="list-group-item list-group-item-success">
            <i class="fas fa-smile"></i> <i class="fas fa-thumbs-up"></i> Your mid-life should be a very happy affair.
            </li>
<?php
        }
        else if($this->data['status_7'] == "Bad Phase")
        {
?>
            <li class="list-group-item list-group-item-danger">
            <i class="fas fa-frown"></i> Your mid-life should be quite difficult.
            </li>
<?php
        }
        else if($this->data['status_7'] == "Very Bad Phase")
        {
?>
                <li class="list-group-item list-group-item-danger">
            <i class="fas fa-frown"></i> <i class="fas fa-thumbs-down"></i> Your mid-life should be very difficult and full of problems.
                </li>
<?php
        }
?>
</ul><div class="mb-3"></div>
<div class="lead alert alert-dark">Old Age</div>
<ul class="list-group">
    <li class="list-group-item"><strong>Fourth House controls your Old Age.</strong></li>
    <li class="list-group-item">
    <?php
        $count_4        = $this->data['house_4'];
        $asp_4          = $this->data['aspect_4'];
    ?>
        <strong>Placements: </strong>There
        <?php
        if($count_4 == "0")
        {
            echo " are no planets ";
        }
        else
        {
            echo " is ";
            for($i=0; $i< $count_4;$i++) 
            {
                $j          = $i+1;
                $condition  = $this->data['house_condition_4_'.$j];
                $planet     = $this->data['house_4_'.$j];
                 if($i == "0" || $i+1 > $count_4)
                {
                    if($condition == "none")
                    {
                        echo $planet;
                    }
                    else
                    {
                        echo $condition." ".$planet." ";
                    }
                }
                else
                {
                    if($condition == "none")
                    {
                        echo ", ".$planet;
                    }
                    else
                    {
                        echo ", ".$condition." ".$planet;
                    }
                }
            }
        }
        ?>
        in your 4th house.
    </li>
    <li class="list-group-item"><strong>Aspects:</strong> There 
        <?php
        if($asp_4 == "0")
        {
            echo " are no aspects ";
        }
        else
        {
            echo " is aspect of ";
            for($i=0; $i< $asp_4;$i++) 
            {
                $j          = $i+1;
                $planet     = $this->data['aspect_4_'.$j];
                 if($i == "0" || $i+1 > $asp_4)
                {
                    
                    echo $planet;
                   
                }
                else
                {
                    echo ", ".$planet;     
                }
            }
        }
        ?>
        on your 4th house.
    </li>
    <?php
        if($this->data['status_4'] == "Good Phase")
        {
?>
        <li class="list-group-item list-group-item-success">
            <i class="fas fa-smile"></i> Your old age should generally be a happy affair.
        </li>
<?php
        }
        else if($this->data['status_4'] == "Very Good Phase")
        {
?>
            <li class="list-group-item list-group-item-success">
            <i class="fas fa-smile"></i> <i class="fas fa-thumbs-up"></i> Your old age should be a very happy affair.
            </li>
<?php
        }
        else if($this->data['status_4'] == "Bad Phase")
        {
?>
            <li class="list-group-item list-group-item-danger">
            <i class="fas fa-frown"></i> Your old age should be quite difficult.
            </li>
<?php
        }
        else if($this->data['status_4'] == "Very Bad Phase")
        {
?>
                <li class="list-group-item list-group-item-danger">
            <i class="fas fa-frown"></i> <i class="fas fa-thumbs-down"></i> Your old age should be very difficult and full of problems.             </li>
<?php
        }
?>
</ul>
<?php
if($this->data['chart_type'] == "north")
{
?>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/stage_n.js' ?>">
</script>
<?php
}
else
{
?>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/stage_s.js' ?>">
</script>
<?php 
}
unset($this->data); ?>
</body>
</html>