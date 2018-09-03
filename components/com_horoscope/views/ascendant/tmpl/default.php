<html>
 <head>
<style type="text/css">
#asc_canvas{width: 100%;height: auto;}
</style>
<script type="text/javascript">
function draw_horoscope()
{
    //alert("calls");
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    // horoscope boundary
    ctx.beginPath();
    ctx.rect(5,5,145,145);
    ctx.strokeStyle='black';
    ctx.lineWidth=1;
    ctx.stroke();

    // vishnu sthanas
    ctx.beginPath();
    ctx.rotate(45*Math.PI/180);
    ctx.rect(60,-50,101,101);
    ctx.strokeStyle='black';
    ctx.lineWidth=1;
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(8,0);
    ctx.lineTo(212,0);
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(109,-102);
    ctx.lineTo(109,102);
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
    var x = document.getElementById("Ascendant_sign").getAttribute('value');
    if(x == "Aries"){ y = 1;} else if(x == "Taurus"){y = 2;}
    else if(x == "Gemini"){y = 3;} else if(x == "Cancer"){y = 4;}
    else if(x == "Leo"){y = 5;} else if(x == "Virgo"){y = 6;}
    else if(x == "Libra"){y = 7;} else if(x == "Scorpio"){y = 8;}
    else if(x == "Sagittarius"){y = 9;} else if(x == "Capricorn"){y = 10;}
    else if(x == "Aquarius"){y = 11;} else if(x == "Pisces"){y = 12;} else{y=1;}
    house_1(y);
}
function calc_next_value(x)
{
    if(x == "12"){y = 1;}else{y = x+1;}
    return y;
}
function house_1(y)
{
    //alert(y);
    var x = y;
    //alert("calls");
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();

    ctx.font='33% Arial';
    ctx.fillText(x,74,73);
    var y = calc_next_value(x);
    house_2(y);
}
function house_2(y)
{
    var x = y;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33%';
    ctx.fillText(x,40,38);
    var y = calc_next_value(x);
    house_3(y);
}
function house_3(y)
{
    var x = y;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33%';
    ctx.fillText(x,33,45);
    var y = calc_next_value(x);
    house_4(y);
}
function house_4(y)
{
    var x = y;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33%';
    ctx.fillText(x,68,79);
    var y = calc_next_value(x);
    house_5(y);
}
function house_5(y)
{
    var x = y;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33%';
    ctx.fillText(x,33,115);
    var y = calc_next_value(x);
    house_6(y);
}
function house_6(y)
{
    var x = y;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,38,122);
    var y = calc_next_value(x);
    house_7(y);
}
function house_7(y)
{
    var x = y;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,75,85);
    var y = calc_next_value(x);
    house_8(y);
}
function house_8(y)
{
    var x = y;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,112,122);
    
    var y = calc_next_value(x);
    house_9(y);
}
function house_9(y)
{
    var x = y;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,118,116);
    var y = calc_next_value(x);
    house_10(y);
}
function house_10(y)
{
    var x = y;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,82,79);
    var y = calc_next_value(x);
    house_11(y);
}  
function house_11(y)
{
    var x = y;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,117,44);
    var y = calc_next_value(x);
    house_12(y);
}
function house_12(y)
{
    var x = y;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='33% Arial';
    ctx.fillText(x,110,38);
    house_1_planets();
}
function get_next_sign(z)
{
    var signs       = ["Aries","Taurus","Gemini","Cancer","Leo","Virgo","Libra","Scorpio","Sagittarius","Capricorn","Aquarius","Pisces"];
    var y;
    for(var i=0; i<signs.length;i++)
    {
        if(signs[i] == z)
        {
            y  = signs[i+1];
            if(z == "Pisces")
            {
                y = signs[0];
            }
            continue;
        }
    }
    return y;
}

function house_1_planets()
{
    var moon_sign   = document.getElementById("Ascendant_sign").getAttribute('value');
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(moon_sign == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);        
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_1_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(moon_sign);
    house_2_planets(z);
}
function house_2_planets(z)
{
    //alert(z);
    var sign_2   = z;
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign_2 == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);           
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_2_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(sign_2);
    house_3_planets(z);
}
function house_3_planets(z)
{
    //alert(z);
    var sign_3      = z
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign_3 == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_3_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(sign_3);
    house_4_planets(z);
}
function house_4_planets(z)
{
    var sign_4   = z;
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign_4 == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_4_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(sign_4);
    house_5_planets(z);
}
function house_5_planets(z)
{
    var sign_5   = z;
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign_5 == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_5_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(sign_5);
    house_6_planets(z);
}
function house_6_planets(z)
{
    var sign_6   = z;
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign_6 == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_6_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(sign_6);
    house_7_planets(z);
}
function house_7_planets(z)
{
    var sign_7   = z;
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign_7 == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);
       }

    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_7_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(sign_7);
    house_8_planets(z);
}
function house_8_planets(z)
{
    var sign_8   = z;
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign_8 == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_8_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(sign_8);
    house_9_planets(z);
}
function house_9_planets(z)
{
    var sign_9   = z;
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign_9 == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_9_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(sign_9);
    house_10_planets(z);
}
function house_10_planets(z)
{
    var sign_10   = z;
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign_10 == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_10_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(sign_10);
    house_11_planets(z);
}
function house_11_planets(z)
{
    var sign_11   = z;
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign_11 == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_11_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(sign_11);
    house_12_planets(z);
}
function house_12_planets(z)
{
    var sign_12   = z;
    var planets     = ["Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Uranus","Neptune","Pluto","Rahu","Ketu"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign_12 == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_12_canvas(y);      // execute only if there are planets
    }
}
function house_1_canvas(y)
{
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='38% verdana';
    if(len=="1")
    { 
        ctx.fillText(y[0],65,35);
    }
    else if(len=="2")
    {
        ctx.fillText(y[0],65,25);
        ctx.fillText(y[0],65,30);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],65,25);
        ctx.fillText(y[1],65,30);
        ctx.fillText(y[2],65,35);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],68,23);
        ctx.fillText(y[1],68,30);
        ctx.fillText(y[2],68,37);
        ctx.fillText(y[3],68,44);
    }
}
function house_2_canvas(y)
{
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();

    ctx.font='38% verdana';
    ctx.fillText(y[0],35,12);
}
function house_3_canvas(y)
{
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='38% verdana';
    ctx.fillText(y[0],7,32);
}

function house_4_canvas(y)
{
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();
    ctx.font='38% verdana';
    ctx.fillText(y[0],36,72);
}
function house_5_canvas(y)
{
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();

    ctx.font='38% verdana';
    ctx.fillText(y[0],36,72);
}
function house_6_canvas(y)
{
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();

    ctx.font='38% verdana';
    ctx.fillText(y[0],30,128);
}
function house_7_canvas(y)
{
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();

    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],65,95);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],65,95);
        ctx.fillText(y[1],65,102);
    }
}
function house_8_canvas(y)
{
    //alert(y);
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();

    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],105,128);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],105,128);
        ctx.fillText(y[1],105,135);
    }
}
function house_9_canvas(y)
{   
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();

    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],125,120);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],125,120);
        ctx.fillText(y[1],125,125);
    }
}
function house_10_canvas(y)
{
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();

    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],100,62);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],100,62);
        ctx.fillText(y[1],100,69);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],100,62);
        ctx.fillText(y[1],100,67);
        ctx.fillText(y[2],100,72);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],100,62);
        ctx.fillText(y[1],100,70);
        ctx.fillText(y[2],100,78);
        ctx.fillText(y[3],100,86);
    }
    
}
function house_11_canvas(y)
{
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();

    ctx.font='38% verdana';
    ctx.fillText(y[0],135,25);
}
function house_12_canvas(y)
{
    var len     = y.length;
    var c=document.getElementById("asc_canvas");
    var ctx =c.getContext("2d");
    ctx.beginPath();

    ctx.font='38% verdana';
    ctx.fillText(y[0],105,20);
}
</script>
</head>
<body onload="javascript:draw_horoscope();getAscendant();">
<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
//print_r($this->data);exit;
$id         = $this->data['id'];
$title      = $this->data['title'];
$text       = $this->data['introtext'];
?>
<canvas id="asc_canvas">
Your browser does not support the HTML5 canvas tag.
</canvas><div class="mb-2"></div>
<?php

if(strpos($title, "Females"))
{
    $title      = str_replace(" Ascendant Females", "", $title);
}
else
{
    $title      = str_replace(" Ascendant Males","", $title);
}
$text       = $this->data['introtext'];
?>
<div id="<?php echo $this->data['id']; ?>" class="accordion-id"></div>
<h3><?php echo "Your Ascendant is ".$title; ?></h3>
<?php echo $text; 
for($i=0;$i<3;$i++)  // remove the last 3 elements from the array to avoid confusion
{ array_pop($this->data); } ?>
<form>
<?php
    foreach($this->data as $key=>$value)
    {
  
?>
    <input type="hidden" name="<?php echo trim($key); ?>_sign" id="<?php echo trim($key); ?>_sign" value="<?php echo $value; ?>" />
<?php
    }
?>
</form>