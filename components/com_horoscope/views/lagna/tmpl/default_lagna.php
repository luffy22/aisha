<html>
 <head>
<style type="text/css">
#horo_canvas{width: 100%;height: auto;}
</style>
<script type="text/javascript">
function draw_horoscope()
{
    //alert("calls");
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    // horoscope boundary
    ctx.beginPath();
    ctx.rect(5,5,120,120);
    ctx.strokeStyle='black';
    ctx.lineWidth=1;
    ctx.stroke();

    // vishnu sthanas
    ctx.beginPath();
    ctx.rotate(45*Math.PI/180);
    ctx.rect(51,-41,83,83);
    ctx.strokeStyle='black';
    ctx.lineWidth=1;
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(8,0);
    ctx.lineTo(177,0);
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(92,-84);
    ctx.lineTo(92,84);
    ctx.stroke();

    /*ctx.beginPath();
    ctx.moveTo(51,-43);
    ctx.lineTo(51,0);
    ctx.lineTo(8,0);
    ctx.fillStyle="#FF0000";
    ctx.fill();
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(93,-85);
    ctx.lineTo(92,-41);
    ctx.lineTo(50,-41);
    ctx.fillStyle="#3498DB";
    ctx.fill();
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(134,-41);
    ctx.lineTo(92,-41);
    ctx.lineTo(92,-85);
    ctx.fillStyle="#148F77";
    ctx.fill();
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(134,-41);
    ctx.lineTo(134,0);
    ctx.lineTo(176,0);
    ctx.fillStyle="#F4D03F";
    ctx.fill();
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(134,41);
    ctx.lineTo(134,0);
    ctx.lineTo(176,0);
    ctx.fillStyle="#FF0000";
    ctx.fill();
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(92,84);
    ctx.lineTo(92,42);
    ctx.lineTo(134,41);
    ctx.fillStyle="#3498DB";
    ctx.fill();
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(92,84);
    ctx.lineTo(92,42);
    ctx.lineTo(51,42);
    ctx.fillStyle="#148F77";
    ctx.fill();
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(51,43);
    ctx.lineTo(51,0);
    ctx.lineTo(7,0);
    ctx.fillStyle="#F4D03F";
    ctx.fill();
    ctx.stroke();

    ctx.beginPath();
    ctx.rect(51,-41,41,42);
    ctx.lineWidth=1;
    ctx.fillStyle="#E5E8E8";
    ctx.fill();
    ctx.stroke();

    ctx.beginPath();
    ctx.rect(92,-41,42,42);
    ctx.lineWidth=1;
    ctx.fillStyle="#E5E8E8";
    ctx.fill();
    ctx.stroke();

    ctx.beginPath();
    ctx.rect(92,1,42,41);
    ctx.lineWidth=1;
    ctx.fillStyle="#E5E8E8";
    ctx.fill();
    ctx.stroke();

    ctx.beginPath();
    ctx.rect(51,1,41,41);
    ctx.lineWidth=1;
    ctx.fillStyle="#E5E8E8";
    ctx.fill();
    ctx.stroke();*/
    ctx.rotate(315*Math.PI/180);
    ctx.closePath();
}
function getAscendant()
{
    var x = document.getElementById("ascendant_sign").getAttribute('value');
    if(x == "Aries"){ y = 1;} else if(x == "Taurus"){y = 2;}
    else if(x == "Gemini"){y = 3;} else if(x == "Cancer"){y = 4;}
    else if(x == "Leo"){y = 5;} else if(x == "Virgo"){y = 6;}
    else if(x == "Libra"){y = 7;} else if(x == "Scorpio"){y = 8;}
    else if(x == "Sagittarius"){y = 9;} else if(x == "Capricorn"){y = 10;}
    else if(x == "Aquarius"){y = 11;} else if(x == "Pisces"){y = 12;} else{y=1;}
    house_1(y);
}
function house_1(y)
{
    //alert(z);
    var x = y;
    //alert("calls");
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();

    ctx.font='33% Arial';
    ctx.fillText(x,62,62);
    var y = calc_next_value(x);
    house_2(y);
}
function house_2(y)
{
    var x = y;
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33%';
    ctx.fillText(x,35,32);
    var y = calc_next_value(x);
    house_3(y);
}
function house_3(y)
{
    var x = y;
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33%';
    ctx.fillText(x,27,38);
    var y = calc_next_value(x);
    house_4(y);
}
function house_4(y)
{
    var x = y;
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33%';
    ctx.fillText(x,59,67);
    var y = calc_next_value(x);
    house_5(y);
}
function house_5(y)
{
    var x = y;
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33%';
    ctx.fillText(x,28,97);
    var y = calc_next_value(x);
    house_6(y);
}
function house_6(y)
{
    var x = y;
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,34,102);
    var y = calc_next_value(x);
    house_7(y);
}
function house_7(y)
{
    var x = y;
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,63,72);
    var y = calc_next_value(x);
    house_8(y);
}
function house_8(y)
{
    var x = y;
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,93,102);
    
    var y = calc_next_value(x);
    house_9(y);
}
function house_9(y)
{
    var x = y;
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,98,97);
    var y = calc_next_value(x);
    house_10(y);
}
function house_10(y)
{
    var x = y;
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,68,67);
    var y = calc_next_value(x);
    house_11(y);
}  
function house_11(y)
{
    var x = y;
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,97,38);
    var y = calc_next_value(x);
    house_12(y);
}
function house_12(y)
{
    var x = y;
    var c=document.getElementById("horo_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,91,32);
    house_1_planets();
}
function calc_next_value(x)
{
    if(x == "12"){y = 1;}else{y = x+1;}
    return y;
}
    var ascendant   = document.getElementById("ascendant_sign").getAttribute('value');
    var sun         = document.getElementById("sun_sign").getAttribute('value');
    var moon        = document.getElementById("moon_sign").getAttribute('value');
    var mars        = document.getElementById("mars_sign").getAttribute('value');
    var mercury     = document.getElementById("mercury_sign").getAttribute('value');
    var jupiter     = document.getElementById("jupiter_sign").getAttribute('value');
    var venus       = document.getElementById("venus_sign").getAttribute("value");
    var saturn      = document.getElementById("saturn_sign").getAttribute('value');
    var rahu        = document.getElementById("rahu_sign").getAttribute('value');
    var ketu        = document.getElementById("ketu_sign").getAttribute('value');
    var uranus      = document.getElementById("uranus_sign").getAttribute('value');
    var neptune     = document.getElementById("neptune_sign").getAttribute('value');
    var pluto       = document.getElementById("pluto_sign").getAttribute('value');
    
    
    
function house_1_planets()
{
    var ascendant   = document.getElementById("ascendant_sign").getAttribute('value');
    var planets     = ["sun","moon","mars","mercury","jupiter","venus","saturn","rahu","ketu","uranus","neptune","pluto"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    var name = planets[0];
   alert(name);
}
</script>
</head>
<body onload="javascript:draw_horoscope();getAscendant()">
<?php
defined('_JEXEC') or die();
//print_r($this->data);exit;
$planets        = array("Ascendant","Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Uranus","Neptune","Pluto");
?>
<div class="container-fluid">
    <table class="table table-bordered table-hover">
        <tr>
            <th>Name</th>
            <td><?php echo $this->data['fname']; ?></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td><?php echo ucfirst($this->data['gender']); ?></td>
        </tr>
        <tr>
            <th>Date Of Birth</th>
            <td><?php 
                $date   = new DateTime($this->data['dob_tob'], new DateTimeZone($this->data['timezone']));
                echo $date->format('dS F Y'); ?></td>
        </tr>
        <tr>
            <th>Time Of Birth</th>
            <td><?php echo $date->format('H:i:s'); ?></td>
        </tr>
        <tr>
            <th>Place Of Birth</th>
            <td><?php echo $this->data['pob']; ?></td>
        </tr>
        <tr>
            <th>Latitude</th>
            <td><?php echo $this->data['lat']; ?></td>
        </tr>
        <tr>
            <th>Longitude</th>
            <td><?php echo $this->data['lon']; ?></td>
        </tr>
        <tr>
            <th>Timezone</th>
            <td><?php echo "GMT".$date->format('P'); ?></td>
        </tr>
        <tr>
        <th>Apply DST</th>
        <td><?php if($date->format('I') == '1')
                    { echo "Yes"; }
                  else
                  { echo "No"; } ?></td>
        </tr>
    </table>
<canvas id="horo_canvas">
Your browser does not support the HTML5 canvas tag.
</canvas>
    <div class="mb-2"></div>
    
    <table class="table table-hover table-responsive">
        <tr class="bg-info">
            <th>Planets</th>
            <th>Sign</th>
            <th>Sign Lord</th>
            <th>Distance</th>
            <th>Nakshatra</th>
            <th>Nakshatra Lord</th>
            
        </tr>
    <?php 
           for($i=0;$i<count($planets);$i++)
           {
                $sign           = $planets[$i]."_sign";
                $sign_lord      = $planets[$i]."_sign_lord";
                $dist           = $planets[$i]."_dist";
                $nakshatra      = $planets[$i]."_nakshatra";
                $nakshatra_lord = $planets[$i]."_nakshatra_lord";
                
    ?>
        <tr>
            <td><?php echo $planets[$i];  ?></td>
            <td id="<?php echo strtolower(trim($planets[$i])); ?>_sign" value="<?php echo $this->data[$i][$sign]; ?>"><?php echo $this->data[$i][$sign]; ?></td>
            <td><?php echo $this->data[$i][$sign_lord]; ?></td>
            <td><?php echo $this->data[$i][$dist]; ?></td>
            <td><?php echo $this->data[$i][$nakshatra]; ?></td>
            <td><?php echo $this->data[$i][$nakshatra_lord]; ?></td>
        </tr>
    <?php
           }
    ?>
    </table>
    <?php unset($this->data); ?>
</div>
</html>