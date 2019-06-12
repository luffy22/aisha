var c   = {};var ctx = {};
function get_canvas()
{
    var url     = window.location.href;
    if(url.includes("horoscope"))
    {
        c           =   document.getElementById("horo_canvas");
    }
    else if(url.includes("getasc"))
    {
        c           =   document.getElementById("asc_canvas");
    }
    else if(url.includes("getmoon"))
    {
        c           =   document.getElementById("moon_canvas");
    }
    else if(url.includes("getnavamsha"))
    {
        c           =   document.getElementById("navamsha_canvas");
    }
    ctx     =       c.getContext("2d");
    ctx.beginPath();
}
function draw_horoscope()
{
    get_canvas();
    ctx.rect(5,5,250,250);
    ctx.strokeStyle='black';
    ctx.lineWidth=1;
    ctx.stroke();
    
    // vishnu sthanas
    //ctx.beginPath();
    //ctx.rotate(45*Math.PI/180);
    //ctx.rect(97,-87,175,175);
    //ctx.strokeStyle='black';
    //ctx.lineWidth=1;
    //ctx.stroke();
    
    //ctx.rotate(315*Math.PI/180);
    //ctx.beginPath();
    //ctx.moveTo(5,5);
    //ctx.lineTo(255,255);
    //ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(255,5);
    ctx.lineTo(5,255);
    ctx.stroke();

   

     /*ctx.beginPath();
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
function getAsc()
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
function getMoon()
{
    var x = document.getElementById("moon_sign").getAttribute('value');
    if(x == "Aries"){ y = 1;} else if(x == "Taurus"){y = 2;}
    else if(x == "Gemini"){y = 3;} else if(x == "Cancer"){y = 4;}
    else if(x == "Leo"){y = 5;} else if(x == "Virgo"){y = 6;}
    else if(x == "Libra"){y = 7;} else if(x == "Scorpio"){y = 8;}
    else if(x == "Sagittarius"){y = 9;} else if(x == "Capricorn"){y = 10;}
    else if(x == "Aquarius"){y = 11;} else if(x == "Pisces"){y = 12;} else{y=1;}
    house_1(y);
}
function getNavamsha()
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
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='8px Arial';
    ctx.fillText(x,125,122);
    var y = calc_next_value(x);
    house_2(y);
}
function house_2(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText(x,65,62);
    var y = calc_next_value(x);
    house_3(y);
}
function house_3(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='8px';
    ctx.fillText(x,54,70);
    var y = calc_next_value(x);
    house_4(y);
}
function house_4(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='8px';
    ctx.fillText(x,118,132);
    var y = calc_next_value(x);
    house_5(y);
}
function house_5(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='8px';
    ctx.fillText(x,55,194);
    var y = calc_next_value(x);
    house_6(y);
}
function house_6(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='8px Arial';
    ctx.fillText(x,64,202);
    var y = calc_next_value(x);
    house_7(y);
}
function house_7(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='8px Arial';
    ctx.fillText(x,126,142);
    var y = calc_next_value(x);
    house_8(y);
}
function house_8(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='8px Arial';
    ctx.fillText(x,189,202);
    
    var y = calc_next_value(x);
    house_9(y);
}
function house_9(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='8px Arial';
    ctx.fillText(x,197,195);
    var y = calc_next_value(x);
    house_10(y);
}
function house_10(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='8px Arial';
    ctx.fillText(x,135,132);
    var y = calc_next_value(x);
    house_11(y);
}  
function house_11(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='8px Arial';
    ctx.fillText(x,197,70);
    var y = calc_next_value(x);
    house_12(y);
}
function house_12(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='8px Arial';
    ctx.fillText(x,189,62);
    house_1_planets();
}
function calc_next_value(x)
{
    if(x == "12"){y = 1;}else{y = x+1;}
    return y;
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
function get_planets(a,z)
{
    var sign        = z;
    var planets     = ["sun","moon","mars","mercury","jupiter","venus","saturn","rahu","ketu","uranus","neptune","pluto"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(sign == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);           
       }
    }
    var canvas      = "house_"+a+"_canvas";
    if(y.length > 0)        // check if there are any planets in house
    {
        return y;
    }
    else
    {
        return "0";
    }
}
function house_1_planets()
{
    var url     = window.location.href;
    if(url.includes("horoscope"))
    {
        var ascendant   = document.getElementById("ascendant_sign").getAttribute('value');
    }
    else if(url.includes("getasc"))
    {
        var ascendant   = document.getElementById("ascendant_sign").getAttribute('value');
    }
    else if(url.includes("getmoon"))
    {
        var ascendant   = document.getElementById("moon_sign").getAttribute('value');
    }
    else if(url.includes("getnavamsha"))
    {     
        var ascendant   = document.getElementById("ascendant_sign").getAttribute('value');
    }
    var planets     = ["sun","moon","mars","mercury","jupiter","venus","saturn","rahu","ketu","uranus","neptune","pluto"];
    
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(ascendant == document.getElementById(planets[i]+"_sign").getAttribute('value'))
       {
            x       = planets[i];
            y.push(x);        
       }
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_1_canvas(y);      // execute only if there are planets
    }
    var z  = get_next_sign(ascendant);

    house_2_planets(z);
}
function house_2_planets(z)
{
    var y   = get_planets(2, z);
    if(y== "0"){}else{house_2_canvas(y);}
    var z   = get_next_sign(z);
    house_3_planets(z);
}
function house_3_planets(z)
{
    var y   = get_planets(3, z);
    if(y== "0"){}else{house_3_canvas(y);}
    var z  = get_next_sign(z);
    house_4_planets(z);
}
function house_4_planets(z)
{
    var y   = get_planets(4, z);
    if(y== "0"){}else{house_4_canvas(y);}
    var z  = get_next_sign(z);
    house_5_planets(z);
}
function house_5_planets(z)
{
    var y   = get_planets(5, z);
    if(y== "0"){}else{house_5_canvas(y);}
    var z  = get_next_sign(z);
    house_6_planets(z);
}
function house_6_planets(z)
{
    var y   = get_planets(6, z);
    if(y== "0"){}else{house_6_canvas(y);}
    var z  = get_next_sign(z);
    house_7_planets(z);
}
function house_7_planets(z)
{
    var y   = get_planets(7, z);
    if(y== "0"){}else{house_7_canvas(y);}
    var z  = get_next_sign(z);
    house_8_planets(z);
}
function house_8_planets(z)
{
    var y   = get_planets(8, z);
    if(y== "0"){}else{house_8_canvas(y);}
    var z  = get_next_sign(z);
    house_9_planets(z);
}
function house_9_planets(z)
{
    var y    = get_planets(9, z);
    if(y== "0"){}else{house_9_canvas(y);}
    var z  = get_next_sign(z);
    house_10_planets(z);
}
function house_10_planets(z)
{
    var y   = get_planets(10, z);
    if(y== "0"){}else{house_10_canvas(y);}
    var z  = get_next_sign(z);
    house_11_planets(z);
}
function house_11_planets(z)
{
    var y   = get_planets(11, z);
    if(y== "0"){}else{house_11_canvas(y);}
    var z  = get_next_sign(z);
    house_12_planets(z);
}
function house_12_planets(z)
{
    var y   = get_planets(12, z);
    if(y== "0"){}else{house_12_canvas(y);}
}
function house_1_canvas(y)
{
    var len     = y.length;
    get_canvas();
    
    ctx.font='10px Arial';
    if(len=="1")
    { 
        ctx.fillText(y[0],117,66);
    }
    else if(len=="2")
    {
        ctx.fillText(y[0],117,56);
        ctx.fillText(y[1],117,66);
    }
    else if(len=="3")
    {
        ctx.fillText(y[0],117,56);
        ctx.fillText(y[1],117,66);
        ctx.fillText(y[2],117,76);
    }
    else if(len=="4")
    {
        ctx.fillText(y[0],117,56);
        ctx.fillText(y[1],117,66);
        ctx.fillText(y[2],117,76);
        ctx.fillText(y[3],117,86);
    }
    else if(len=="5")
    {
        ctx.fillText(y[0],117,56);
        ctx.fillText(y[1],117,66);
        ctx.fillText(y[2],117,76);
        ctx.fillText(y[3],117,86);
        ctx.fillText(y[4],102,96);
    }
     else if(len=="6")
    {
        ctx.fillText(y[0],117,56);
        ctx.fillText(y[1],117,66);
        ctx.fillText(y[2],117,76);
        ctx.fillText(y[3],117,86);
        ctx.fillText(y[4],117,96);
	ctx.fillText(y[5],117,106);
    }
    else if(len=="7")
    {
        ctx.fillText(y[0],117,46);
        ctx.fillText(y[1],117,56);
        ctx.fillText(y[2],117,66);
        ctx.fillText(y[3],117,76);
        ctx.fillText(y[4],117,86);
        ctx.fillText(y[5],117,96);
	ctx.fillText(y[6],117,106);
    }
    
    else if(len=="8")
    {
        ctx.fillText(y[0],117,36);
        ctx.fillText(y[1],117,46);
        ctx.fillText(y[2],117,56);
        ctx.fillText(y[3],117,66);
        ctx.fillText(y[4],117,76);
        ctx.fillText(y[5],117,86);
        ctx.fillText(y[6],117,96);
	ctx.fillText(y[7],117,106);
    }
    
}
function house_2_canvas(y)
{
    var len     = y.length;
    get_canvas();
    ctx.font='10px Arial';
    if(len=="1")
    { 
        ctx.fillText(y[0],55,35);
    }
    else if(len=="2")
    { 
        ctx.fillText(y[0],55,25);
        ctx.fillText(y[1],55,35);
    }
    else if(len=="3")
    { 
        ctx.fillText(y[0],55,25);
        ctx.fillText(y[1],55,35);
        ctx.fillText(y[2],55,45);
    }
    else if(len=="4")
    { 
        ctx.fillText(y[0],55,15);
        ctx.fillText(y[1],55,25);
        ctx.fillText(y[2],55,35);
        ctx.fillText(y[3],55,45);
    }
    else if(len=="5")
    { 
        ctx.fillText(y[0],25,15);
        ctx.fillText(y[1],55,15);
        ctx.fillText(y[2],55,25);
        ctx.fillText(y[3],55,35);
        ctx.fillText(y[4],55,45);
    }
    else if(len=="6")
    { 
        ctx.fillText(y[0],25,15);
        ctx.fillText(y[1],55,15);
        ctx.fillText(y[2],85,15);
        ctx.fillText(y[3],25,25);
        ctx.fillText(y[4],55,25);
        ctx.fillText(y[5],55,35);
    }
    else if(len=="7")
    { 
        ctx.fillText(y[0],25,15);
        ctx.fillText(y[1],55,15);
        ctx.fillText(y[2],85,15);
        ctx.fillText(y[3],25,25);
        ctx.fillText(y[4],55,25);
        ctx.fillText(y[5],55,35);
        ctx.fillText(y[6],55,45);
    }
    else if(len=="8")
    { 
        ctx.fillText(y[0],25,15);
        ctx.fillText(y[1],55,15);
        ctx.fillText(y[2],85,15);
        ctx.fillText(y[3],25,25);
        ctx.fillText(y[4],65,25);
        ctx.fillText(y[5],65,35);
        ctx.fillText(y[6],55,45);
        ctx.fillText(y[7],30,35);
    }
    
}
function house_3_canvas(y)
{
    var len     = y.length;
    get_canvas();
    ctx.font='10px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],7,60);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],7,60);
        ctx.fillText(y[1],7,70);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],7,50);
        ctx.fillText(y[1],7,60);
        ctx.fillText(y[2],7,70);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],7,50);
        ctx.fillText(y[1],7,60);
        ctx.fillText(y[2],7,70);
        ctx.fillText(y[3],7,80);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],7,50);
        ctx.fillText(y[1],7,60);
        ctx.fillText(y[2],7,70);
        ctx.fillText(y[3],7,80);
        ctx.fillText(y[4],7,90);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],7,50);
        ctx.fillText(y[1],7,60);
        ctx.fillText(y[2],7,70);
        ctx.fillText(y[3],7,80);
        ctx.fillText(y[4],7,90);
        ctx.fillText(y[5],7,100);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],7,50);
        ctx.fillText(y[1],7,60);
        ctx.fillText(y[2],7,70);
        ctx.fillText(y[3],7,80);
        ctx.fillText(y[4],7,90);
        ctx.fillText(y[5],7,100);
        ctx.fillText(y[6],7,40);
    }
}

function house_4_canvas(y)
{
    var len     = y.length;
    get_canvas();
    ctx.font='10px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],55,130);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],55,130);
        ctx.fillText(y[1],55,140);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],55,120);
        ctx.fillText(y[1],55,130);
        ctx.fillText(y[2],55,140);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],55,110);
        ctx.fillText(y[1],55,120);
        ctx.fillText(y[2],55,130);
        ctx.fillText(y[3],55,140);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],55,110);
        ctx.fillText(y[1],55,120);
        ctx.fillText(y[2],55,130);
        ctx.fillText(y[3],55,140);
        ctx.fillText(y[4],55,150);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],55,100);
        ctx.fillText(y[1],55,110);
        ctx.fillText(y[2],55,120);
        ctx.fillText(y[3],55,130);
        ctx.fillText(y[4],55,140);
        ctx.fillText(y[5],55,150);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],55,100);
        ctx.fillText(y[1],55,110);
        ctx.fillText(y[2],55,120);
        ctx.fillText(y[3],55,130);
        ctx.fillText(y[4],55,140);
        ctx.fillText(y[5],55,150);
        ctx.fillText(y[6],55,160);
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],55,100);
        ctx.fillText(y[1],55,110);
        ctx.fillText(y[2],55,120);
        ctx.fillText(y[3],55,130);
        ctx.fillText(y[4],55,140);
        ctx.fillText(y[5],55,150);
        ctx.fillText(y[6],55,160);
        ctx.fillText(y[7],55,170);
    }
}
function house_5_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='10px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],7,185);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],7,185);
        ctx.fillText(y[1],7,195);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],7,175);
        ctx.fillText(y[1],7,185);
        ctx.fillText(y[2],7,195);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],7,165);
        ctx.fillText(y[1],7,175);
        ctx.fillText(y[2],7,185);
        ctx.fillText(y[3],7,195);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],7,165);
        ctx.fillText(y[1],7,175);
        ctx.fillText(y[2],7,185);
        ctx.fillText(y[3],7,195);
        ctx.fillText(y[4],7,205);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],7,165);
        ctx.fillText(y[1],7,175);
        ctx.fillText(y[2],7,185);
        ctx.fillText(y[3],7,195);
        ctx.fillText(y[4],7,205);
        ctx.fillText(y[5],7,215);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],7,165);
        ctx.fillText(y[1],7,175);
        ctx.fillText(y[2],7,185);
        ctx.fillText(y[3],7,195);
        ctx.fillText(y[4],7,205);
        ctx.fillText(y[5],7,215);
        ctx.fillText(y[6],7,225);    
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],7,165);
        ctx.fillText(y[1],7,175);
        ctx.fillText(y[2],7,185);
        ctx.fillText(y[3],7,195);
        ctx.fillText(y[4],7,205);
        ctx.fillText(y[5],7,215);
        ctx.fillText(y[6],7,225);    
        ctx.fillText(y[7],7,155);
    }
}
function house_6_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='10px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],55,230);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],55,220);
        ctx.fillText(y[1],55,230);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],55,220);
        ctx.fillText(y[1],55,230);
        ctx.fillText(y[2],55,240);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],55,220);
        ctx.fillText(y[1],55,230);
        ctx.fillText(y[2],55,240);
        ctx.fillText(y[3],55,250);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],55,220);
        ctx.fillText(y[1],55,230);
        ctx.fillText(y[2],55,240);
        ctx.fillText(y[3],55,250);
        ctx.fillText(y[4],15,250);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],55,220);
        ctx.fillText(y[1],55,230);
        ctx.fillText(y[2],60,240);
        ctx.fillText(y[3],55,250);
        ctx.fillText(y[4],15,250);
        ctx.fillText(y[5],20,240);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],55,220);
        ctx.fillText(y[1],65,230);
        ctx.fillText(y[2],60,240);
        ctx.fillText(y[3],55,250);
        ctx.fillText(y[4],15,250);
        ctx.fillText(y[5],20,240);
        ctx.fillText(y[6],25,230);
    }
    else if(len == "8")
    {
        ctx.fillText(y[8],55,210);
        ctx.fillText(y[0],55,220);
        ctx.fillText(y[1],65,230);
        ctx.fillText(y[2],60,240);
        ctx.fillText(y[3],55,250);
        ctx.fillText(y[4],15,250);
        ctx.fillText(y[5],20,240);
        ctx.fillText(y[6],25,230);
        ctx.fillText(y[7],80,210);
    }
}
function house_7_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='10px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],110,180);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],110,180);
        ctx.fillText(y[1],110,190);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],110,180);
        ctx.fillText(y[1],110,190);
        ctx.fillText(y[2],110,200);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],110,170);
        ctx.fillText(y[1],110,180);
        ctx.fillText(y[2],110,190);
        ctx.fillText(y[3],110,200);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],110,160);
        ctx.fillText(y[1],110,170);
        ctx.fillText(y[2],110,180);
        ctx.fillText(y[3],110,190);
        ctx.fillText(y[4],110,200);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],110,160);
        ctx.fillText(y[1],110,170);
        ctx.fillText(y[2],110,180);
        ctx.fillText(y[3],110,190);
        ctx.fillText(y[4],110,200);
        ctx.fillText(y[5],110,210);
    }
     else if(len == "7")
    {
        ctx.fillText(y[0],110,160);
        ctx.fillText(y[1],110,170);
        ctx.fillText(y[2],110,180);
        ctx.fillText(y[3],110,190);
        ctx.fillText(y[4],110,200);
        ctx.fillText(y[5],110,210);
        ctx.fillText(y[6],110,220);
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],110,160);
        ctx.fillText(y[1],110,170);
        ctx.fillText(y[2],110,180);
        ctx.fillText(y[3],110,190);
        ctx.fillText(y[4],110,200);
        ctx.fillText(y[5],110,210);
        ctx.fillText(y[6],110,220);
        ctx.fillText(y[7],110,230);
    }
}
function house_8_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='10px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],180,230);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],180,230);
        ctx.fillText(y[1],180,240);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],180,220);
        ctx.fillText(y[1],180,230);
        ctx.fillText(y[2],180,240);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],180,220);
        ctx.fillText(y[1],180,230);
        ctx.fillText(y[2],180,240);
        ctx.fillText(y[3],180,250);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],180,210);
        ctx.fillText(y[1],180,220);
        ctx.fillText(y[2],180,230);
        ctx.fillText(y[3],180,240);
        ctx.fillText(y[4],180,250);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],180,210);
        ctx.fillText(y[1],180,220);
        ctx.fillText(y[2],180,230);
        ctx.fillText(y[3],180,240);
        ctx.fillText(y[4],185,250);
        ctx.fillText(y[5],150,250);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],180,210);
        ctx.fillText(y[1],180,220);
        ctx.fillText(y[2],180,230);
        ctx.fillText(y[3],180,240);
        ctx.fillText(y[4],185,250);
        ctx.fillText(y[5],150,250);
        ctx.fillText(y[6],215,250);
    }
     else if(len == "8")
    {
        ctx.fillText(y[0],180,210);
        ctx.fillText(y[1],180,220);
        ctx.fillText(y[2],180,230);
        ctx.fillText(y[3],190,240);
        ctx.fillText(y[4],185,250);
        ctx.fillText(y[5],150,250);
        ctx.fillText(y[6],215,250);
        ctx.fillText(y[7],160,250);
    }
}
function house_9_canvas(y)
{   
    var len     = y.length;
    get_canvas();

    ctx.font='10px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],210,195);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],210,195);
        ctx.fillText(y[1],210,205);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],210,195);
        ctx.fillText(y[1],210,205);
        ctx.fillText(y[2],215,215);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],210,185);
        ctx.fillText(y[1],210,195);
        ctx.fillText(y[2],210,205);
        ctx.fillText(y[3],215,215);
    }
     else if(len == "5")
    {
        ctx.fillText(y[0],210,185);
        ctx.fillText(y[1],210,195);
        ctx.fillText(y[2],210,205);
        ctx.fillText(y[3],215,215);
        ctx.fillText(y[4],225,225);
    }
     else if(len == "6")
    {
        ctx.fillText(y[0],215,175);
        ctx.fillText(y[1],210,185);
        ctx.fillText(y[2],210,195);
        ctx.fillText(y[3],210,205);
        ctx.fillText(y[4],215,215);
        ctx.fillText(y[5],225,225);
    }
     else if(len == "7")
    {
        ctx.fillText(y[0],215,175);
        ctx.fillText(y[1],210,185);
        ctx.fillText(y[2],210,195);
        ctx.fillText(y[3],210,205);
        ctx.fillText(y[4],215,215);
        ctx.fillText(y[5],225,225);
        ctx.fillText(y[6],225,165);
    }
     else if(len == "8")
    {
        ctx.fillText(y[0],215,175);
        ctx.fillText(y[1],210,185);
        ctx.fillText(y[2],210,195);
        ctx.fillText(y[3],210,205);
        ctx.fillText(y[4],215,215);
        ctx.fillText(y[5],225,225);
        ctx.fillText(y[6],225,165);
        ctx.fillText(y[7],240,195);
    }
}
function house_10_canvas(y)
{
    var len     = y.length;
    get_canvas();
    
    ctx.font='10px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],180,130);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],180,130);
        ctx.fillText(y[1],180,140);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],180,120);
        ctx.fillText(y[1],180,130);
        ctx.fillText(y[2],180,140);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],180,110);
        ctx.fillText(y[1],180,120);
        ctx.fillText(y[2],180,130);
        ctx.fillText(y[3],180,140);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],180,110);
        ctx.fillText(y[1],180,120);
        ctx.fillText(y[2],180,130);
        ctx.fillText(y[3],180,140);
        ctx.fillText(y[4],180,150);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],180,110);
        ctx.fillText(y[1],180,120);
        ctx.fillText(y[2],180,130);
        ctx.fillText(y[3],180,140);
        ctx.fillText(y[4],180,150);
        ctx.fillText(y[5],180,160);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],180,110);
        ctx.fillText(y[1],180,120);
        ctx.fillText(y[2],180,130);
        ctx.fillText(y[3],180,140);
        ctx.fillText(y[4],180,150);
        ctx.fillText(y[5],180,160);
        ctx.fillText(y[6],180,170);
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],180,110);
        ctx.fillText(y[1],180,120);
        ctx.fillText(y[2],180,130);
        ctx.fillText(y[3],180,140);
        ctx.fillText(y[4],180,150);
        ctx.fillText(y[5],180,160);
        ctx.fillText(y[6],180,170);
        ctx.fillText(y(7),180,100);
    }
}
function house_11_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='10px Arial';
    if(len=="1")
    { 
         ctx.fillText(y[0],215,80);
    }
    else if(len=="2")
    {
        ctx.fillText(y[0],215,70);
        ctx.fillText(y[1],215,80);
    }
    else if(len=="3")
    {
        ctx.fillText(y[0],215,60);
        ctx.fillText(y[1],215,70);
        ctx.fillText(y[2],215,80);
    }
    else if(len=="4")
    {
        ctx.fillText(y[0],215,60);
        ctx.fillText(y[1],215,70);
        ctx.fillText(y[2],215,80);
        ctx.fillText(y[3],215,90);
    }
     else if(len=="5")
    {
        ctx.fillText(y[0],225,50);
        ctx.fillText(y[1],215,60);
        ctx.fillText(y[2],215,70);
        ctx.fillText(y[3],215,80);
        ctx.fillText(y[4],215,90);
    }
    else if(len=="6")
    {
        ctx.fillText(y[0],225,40);
        ctx.fillText(y[1],225,50);
        ctx.fillText(y[2],215,60);
        ctx.fillText(y[3],215,70);
        ctx.fillText(y[4],215,80);
        ctx.fillText(y[5],215,90);
    }
    else if(len=="7")
    {
        ctx.fillText(y[0],225,40);
        ctx.fillText(y[1],225,50);
        ctx.fillText(y[2],215,60);
        ctx.fillText(y[3],215,70);
        ctx.fillText(y[4],215,80);
        ctx.fillText(y[5],215,90);
        ctx.fillText(y[6],225,100);
    }
    else if(len=="8")
    {
        ctx.fillText(y[0],235,30);
        ctx.fillText(y[1],225,40);
        ctx.fillText(y[2],225,50);
        ctx.fillText(y[3],215,60);
        ctx.fillText(y[4],215,70);
        ctx.fillText(y[5],215,80);
        ctx.fillText(y[6],215,90);
        ctx.fillText(y[7],225,100);
    }
}
function house_12_canvas(y)
{
    var len     = y.length;
    get_canvas();
    
    ctx.font='10px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],180,35);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],180,25);
        ctx.fillText(y[1],180,35);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],180,25);
        ctx.fillText(y[1],180,35);
        ctx.fillText(y[2],180,45);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],180,15);
        ctx.fillText(y[1],180,25);
        ctx.fillText(y[2],180,35);
        ctx.fillText(y[3],180,45);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],180,15);
        ctx.fillText(y[1],180,25);
        ctx.fillText(y[2],180,35);
        ctx.fillText(y[3],180,45);
        ctx.fillText(y[4],180,55);
    }
     else if(len == "6")
    {
        ctx.fillText(y[0],145,15);
        ctx.fillText(y[1],180,15);
        ctx.fillText(y[2],180,25);
        ctx.fillText(y[3],180,35);
        ctx.fillText(y[4],180,45);
        ctx.fillText(y[5],180,55);
    }
     else if(len == "7")
    {
        ctx.fillText(y[0],145,15);
        ctx.fillText(y[1],180,15);
        ctx.fillText(y[2],180,25);
        ctx.fillText(y[3],180,35);
        ctx.fillText(y[4],180,45);
        ctx.fillText(y[5],180,55);
        ctx.fillText(y[6],215,15);
    }
    first_house();
}
function first_house()
{
    ctx.beginPath();
    ctx.moveTo(5,5);
    ctx.lineTo(69,69);
    ctx.lineTo(6,131);
    ctx.fillStyle="#5D8FC7";
    ctx.fill();
    ctx.stroke();
    
    second_house();
}
function second_house()
{
    ctx.beginPath();
    ctx.moveTo(5,5);
    ctx.lineTo(69,69);
    ctx.lineTo(132,6);
    ctx.fillStyle="#5D8FC7";
    ctx.fill();
    ctx.stroke();
    
    fifth_house();
}
function fifth_house()
{
    ctx.beginPath();
    ctx.moveTo(5,131);
    ctx.lineTo(69,191);
    ctx.lineTo(5,255);
    //ctx.fillStyle="#5D8FC7";
    ctx.fill();
    ctx.stroke();
    
    sixth_house();
}
function sixth_house()
{
    ctx.beginPath();
    ctx.moveTo(69,191);
    ctx.lineTo(131,255);
    ctx.lineTo(5,255);
    ctx.fillStyle="#5D8FC7";
    ctx.fill();
    ctx.stroke();
    
    //sixth_house();
}