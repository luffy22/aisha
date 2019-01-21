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
    ctx.beginPath();
    ctx.rotate(45*Math.PI/180);
    ctx.rect(97,-87,175,175);
    ctx.strokeStyle='black';
    ctx.lineWidth=1;
    ctx.stroke();
    
    ctx.rotate(315*Math.PI/180);
    ctx.beginPath();
    ctx.moveTo(5,5);
    ctx.lineTo(255,255);
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(255,5);
    ctx.lineTo(5,255);
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
    //house_1_planets();
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
    
    ctx.font='8px Arial';
    if(len=="1")
    { 
        ctx.fillText(y[0],102,56);
    }
    else if(len=="2")
    {
        ctx.fillText(y[0],102,48);
        ctx.fillText(y[1],102,56);
    }
    else if(len=="3")
    {
        ctx.fillText(y[0],102,40);
        ctx.fillText(y[1],102,48);
        ctx.fillText(y[2],102,56);
    }
    else if(len=="4")
    {
        ctx.fillText(y[0],102,40);
        ctx.fillText(y[1],102,48);
        ctx.fillText(y[2],102,56);
        ctx.fillText(y[3],102,64);
    }
    else if(len=="5")
    {
        ctx.fillText(y[0],102,32);
        ctx.fillText(y[1],102,40);
        ctx.fillText(y[2],102,48);
        ctx.fillText(y[3],102,56);
        ctx.fillText(y[4],102,64);
    }
     else if(len=="6")
    {
        ctx.fillText(y[0],102,24);
        ctx.fillText(y[1],102,32);
        ctx.fillText(y[2],102,40);
        ctx.fillText(y[3],102,48);
        ctx.fillText(y[4],102,56);
        ctx.fillText(y[5],102,64);
    }
    else if(len=="7")
    {
        ctx.fillText(y[0],102,24);
        ctx.fillText(y[1],102,32);
        ctx.fillText(y[2],102,40);
        ctx.fillText(y[3],102,48);
        ctx.fillText(y[4],102,56);
        ctx.fillText(y[5],102,64);
        ctx.fillText(y[6],102,72);
    }
    
    else if(len=="8")
    {
        ctx.fillText(y[0],102,24);
        ctx.fillText(y[1],102,32);
        ctx.fillText(y[2],102,40);
        ctx.fillText(y[3],102,48);
        ctx.fillText(y[4],102,56);
        ctx.fillText(y[5],102,64);
        ctx.fillText(y[6],102,72);
        ctx.fillText(y[7],102,80);
    }
    
}
function house_2_canvas(y)
{
    var len     = y.length;
    get_canvas();
    ctx.font='8px Arial';
    if(len=="1")
    { 
        ctx.fillText(y[0],45,32);
    }
    else if(len=="2")
    { 
        ctx.fillText(y[0],45,24);
        ctx.fillText(y[1],45,32);
    }
    else if(len=="3")
    { 
        ctx.fillText(y[0],45,16);
        ctx.fillText(y[1],45,24);
        ctx.fillText(y[2],45,32);
    }
    else if(len=="4")
    { 
        ctx.fillText(y[0],45,16);
        ctx.fillText(y[1],45,24);
        ctx.fillText(y[2],45,32);
        ctx.fillText(y[3],45,40);
    }
    else if(len=="5")
    { 
        ctx.fillText(y[0],18,12);
        ctx.fillText(y[1],50,12);
        ctx.fillText(y[2],25,20);
        ctx.fillText(y[3],60,20);
        ctx.fillText(y[4],50,28);
    }
    else if(len=="6")
    { 
        ctx.fillText(y[0],18,12);
        ctx.fillText(y[1],50,12);
        ctx.fillText(y[2],25,20);
        ctx.fillText(y[3],60,20);
        ctx.fillText(y[4],45,28);
        ctx.fillText(y[5],45,36);
    }
    else if(len=="7")
    { 
        ctx.fillText(y[0],18,12);
        ctx.fillText(y[1],50,12);
        ctx.fillText(y[2],25,20);
        ctx.fillText(y[3],60,20);
        ctx.fillText(y[4],45,28);
        ctx.fillText(y[5],45,36);
        ctx.fillText(y[6],45,44);
    }
    else if(len=="8")
    { 
        ctx.fillText(y[0],18,12);
        ctx.fillText(y[1],50,12);
        ctx.fillText(y[2],25,20);
        ctx.fillText(y[3],60,20);
        ctx.fillText(y[4],45,28);
        ctx.fillText(y[5],45,36);
        ctx.fillText(y[6],45,44);
        ctx.fillText(y[7],80,12);
    }
    
}
function house_3_canvas(y)
{
    var len     = y.length;
    get_canvas();
    ctx.font='8px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],7,56);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],7,44);
        ctx.fillText(y[1],7,56);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],7,44);
        ctx.fillText(y[1],7,56);
        ctx.fillText(y[2],7,64);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],7,44);
        ctx.fillText(y[1],7,56);
        ctx.fillText(y[2],7,64);
        ctx.fillText(y[3],7,72);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],7,44);
        ctx.fillText(y[1],7,56);
        ctx.fillText(y[2],7,64);
        ctx.fillText(y[3],7,72);
        ctx.fillText(y[4],7,80);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],7,36);
        ctx.fillText(y[1],7,44);
        ctx.fillText(y[2],7,56);
        ctx.fillText(y[3],7,64);
        ctx.fillText(y[4],7,72);
        ctx.fillText(y[5],7,80);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],7,28);
        ctx.fillText(y[1],7,36);
        ctx.fillText(y[2],7,44);
        ctx.fillText(y[3],7,56);
        ctx.fillText(y[4],7,64);
        ctx.fillText(y[5],7,72);
        ctx.fillText(y[6],7,80);
    }
}

function house_4_canvas(y)
{
    var len     = y.length;
    get_canvas();
    ctx.font='8px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],50,110);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],50,102);
        ctx.fillText(y[1],50,110);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],50,102);
        ctx.fillText(y[1],50,110);
        ctx.fillText(y[2],50,118);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],50,102);
        ctx.fillText(y[1],50,110);
        ctx.fillText(y[2],50,118);
        ctx.fillText(y[3],50,124);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],50,102);
        ctx.fillText(y[1],50,110);
        ctx.fillText(y[2],50,118);
        ctx.fillText(y[3],50,124);
        ctx.fillText(y[4],50,132);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],50,94);
        ctx.fillText(y[1],50,102);
        ctx.fillText(y[2],50,110);
        ctx.fillText(y[3],50,118);
        ctx.fillText(y[4],50,124);
        ctx.fillText(y[5],50,132);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],50,86);
        ctx.fillText(y[1],50,94);
        ctx.fillText(y[2],50,102);
        ctx.fillText(y[3],50,110);
        ctx.fillText(y[4],50,118);
        ctx.fillText(y[5],50,124);
        ctx.fillText(y[6],50,132);
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],50,86);
        ctx.fillText(y[1],50,94);
        ctx.fillText(y[2],50,102);
        ctx.fillText(y[3],50,110);
        ctx.fillText(y[4],50,118);
        ctx.fillText(y[5],50,124);
        ctx.fillText(y[6],50,132);
        ctx.fillText(y[7],50,140);
    }
}
function house_5_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='8px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],7,164);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],7,164);
        ctx.fillText(y[1],7,172);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],7,156);
        ctx.fillText(y[1],7,164);
        ctx.fillText(y[2],7,172);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],7,148);
        ctx.fillText(y[1],7,156);
        ctx.fillText(y[2],7,164);
        ctx.fillText(y[3],7,172);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],7,140);
        ctx.fillText(y[1],7,148);
        ctx.fillText(y[2],7,156);
        ctx.fillText(y[3],7,164);
        ctx.fillText(y[4],7,172);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],7,140);
        ctx.fillText(y[1],7,148);
        ctx.fillText(y[2],7,156);
        ctx.fillText(y[3],7,164);
        ctx.fillText(y[4],7,172);
        ctx.fillText(y[5],7,180);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],7,132);
        ctx.fillText(y[1],7,140);
        ctx.fillText(y[2],7,148);
        ctx.fillText(y[3],7,156);
        ctx.fillText(y[4],7,164);
        ctx.fillText(y[5],7,172);
        ctx.fillText(y[6],7,180);    
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],7,132);
        ctx.fillText(y[1],7,140);
        ctx.fillText(y[2],7,148);
        ctx.fillText(y[3],7,156);
        ctx.fillText(y[4],7,164);
        ctx.fillText(y[5],7,172);
        ctx.fillText(y[6],7,180); 
        ctx.fillText(y[7],7,188);
    }
}
function house_6_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='8px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],45,192);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],45,184);
        ctx.fillText(y[1],45,192);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],45,176);
        ctx.fillText(y[1],45,184);
        ctx.fillText(y[2],45,192);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],45,176);
        ctx.fillText(y[1],45,184);
        ctx.fillText(y[2],45,192);
        ctx.fillText(y[3],45,200);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],45,176);
        ctx.fillText(y[1],45,184);
        ctx.fillText(y[2],45,192);
        ctx.fillText(y[3],45,200);
        ctx.fillText(y[4],45,208);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],45,176);
        ctx.fillText(y[1],45,184);
        ctx.fillText(y[2],45,192);
        ctx.fillText(y[3],45,200);
        ctx.fillText(y[4],15,210);
        ctx.fillText(y[5],55,210);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],45,176);
        ctx.fillText(y[1],45,184);
        ctx.fillText(y[2],45,192);
        ctx.fillText(y[3],25,200);
        ctx.fillText(y[4],15,210);
        ctx.fillText(y[5],55,210);
        ctx.fillText(y[6],60,200);
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],45,176);
        ctx.fillText(y[1],45,184);
        ctx.fillText(y[2],45,192);
        ctx.fillText(y[3],25,200);
        ctx.fillText(y[4],15,210);
        ctx.fillText(y[5],55,210);
        ctx.fillText(y[6],60,200);
        ctx.fillText(y[7],80,210);
    }
}
function house_7_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='8px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],102,156);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],102,148);
        ctx.fillText(y[1],102,156);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],102,140);
        ctx.fillText(y[1],102,148);
        ctx.fillText(y[2],102,156);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],102,132);
        ctx.fillText(y[1],102,140);
        ctx.fillText(y[2],102,148);
        ctx.fillText(y[3],102,156);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],102,132);
        ctx.fillText(y[1],102,140);
        ctx.fillText(y[2],102,148);
        ctx.fillText(y[3],102,156);
        ctx.fillText(y[4],102,164);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],102,124);
        ctx.fillText(y[1],102,132);
        ctx.fillText(y[2],102,140);
        ctx.fillText(y[3],102,148);
        ctx.fillText(y[4],102,156);
        ctx.fillText(y[5],102,164);
    }
     else if(len == "7")
    {
        ctx.fillText(y[0],102,124);
        ctx.fillText(y[1],102,132);
        ctx.fillText(y[2],102,140);
        ctx.fillText(y[3],102,148);
        ctx.fillText(y[4],102,156);
        ctx.fillText(y[5],102,164);
        ctx.fillText(y[6],102,172);
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],102,124);
        ctx.fillText(y[1],102,132);
        ctx.fillText(y[2],102,140);
        ctx.fillText(y[3],102,148);
        ctx.fillText(y[4],102,156);
        ctx.fillText(y[5],102,164);
        ctx.fillText(y[6],102,172);
        ctx.fillText(y[7],102,180);
    }
}
function house_8_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='8px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],155,192);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],155,184);
        ctx.fillText(y[1],155,192);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],155,184);
        ctx.fillText(y[1],155,192);
        ctx.fillText(y[2],155,200);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],155,176);
        ctx.fillText(y[1],155,184);
        ctx.fillText(y[2],155,192);
        ctx.fillText(y[3],155,200);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],155,176);
        ctx.fillText(y[1],155,184);
        ctx.fillText(y[2],155,192);
        ctx.fillText(y[3],155,200);
        ctx.fillText(y[4],155,208);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],155,176);
        ctx.fillText(y[1],155,184);
        ctx.fillText(y[2],155,192);
        ctx.fillText(y[3],155,200);
        ctx.fillText(y[4],155,210);
        ctx.fillText(y[5],122,210);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],155,176);
        ctx.fillText(y[1],155,184);
        ctx.fillText(y[2],155,192);
        ctx.fillText(y[3],155,200);
        ctx.fillText(y[4],155,210);
        ctx.fillText(y[5],122,210);
        ctx.fillText(y[6],185,210);
    }
     else if(len == "8")
    {
        ctx.fillText(y[0],155,176);
        ctx.fillText(y[1],155,184);
        ctx.fillText(y[2],155,192);
        ctx.fillText(y[3],132,200);
        ctx.fillText(y[4],155,210);
        ctx.fillText(y[5],122,210);
        ctx.fillText(y[6],185,210);
        ctx.fillText(y[7],170,200);
    }
}
function house_9_canvas(y)
{   
    var len     = y.length;
    get_canvas();

    ctx.font='8px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],175,165);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],175,165);
        ctx.fillText(y[1],178,173);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],177,153);
        ctx.fillText(y[1],175,165);
        ctx.fillText(y[2],178,173);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],183,145);
        ctx.fillText(y[1],177,153);
        ctx.fillText(y[2],175,165);
        ctx.fillText(y[3],178,173);
    }
     else if(len == "5")
    {
        ctx.fillText(y[0],193,137);
        ctx.fillText(y[1],183,145);
        ctx.fillText(y[2],177,153);
        ctx.fillText(y[3],175,165);
        ctx.fillText(y[4],178,173);
    }
     else if(len == "6")
    {
        ctx.fillText(y[0],193,137);
        ctx.fillText(y[1],183,145);
        ctx.fillText(y[2],177,153);
        ctx.fillText(y[3],175,165);
        ctx.fillText(y[4],178,173);
        ctx.fillText(y[5],185,180);
    }
     else if(len == "7")
    {
        ctx.fillText(y[0],193,137);
        ctx.fillText(y[1],183,145);
        ctx.fillText(y[2],177,153);
        ctx.fillText(y[3],175,165);
        ctx.fillText(y[4],178,173);
        ctx.fillText(y[5],185,180);
        ctx.fillText(y[6],192,188);
    }
     else if(len == "8")
    {
        ctx.fillText(y[0],193,137);
        ctx.fillText(y[1],183,145);
        ctx.fillText(y[2],177,153);
        ctx.fillText(y[3],175,165);
        ctx.fillText(y[4],178,173);
        ctx.fillText(y[5],185,180);
        ctx.fillText(y[6],192,188);
        ctx.fillText(y[7],198,196);
    }
}
function house_10_canvas(y)
{
    var len     = y.length;
    get_canvas();
    
    ctx.font='8px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],150,110);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],155,110);
        ctx.fillText(y[1],155,118);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],155,102);
        ctx.fillText(y[1],155,110);
        ctx.fillText(y[2],155,118);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],155,102);
        ctx.fillText(y[1],155,110);
        ctx.fillText(y[2],155,118);
        ctx.fillText(y[3],155,126);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],155,102);
        ctx.fillText(y[1],155,110);
        ctx.fillText(y[2],155,118);
        ctx.fillText(y[3],155,124);
        ctx.fillText(y[4],155,132);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],155,102);
        ctx.fillText(y[1],155,110);
        ctx.fillText(y[2],155,118);
        ctx.fillText(y[3],155,124);
        ctx.fillText(y[4],155,132);
        ctx.fillText(y[5],155,94);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],155,102);
        ctx.fillText(y[1],155,110);
        ctx.fillText(y[2],155,118);
        ctx.fillText(y[3],155,124);
        ctx.fillText(y[4],155,132);
        ctx.fillText(y[5],155,94);
        ctx.fillText(y[6],155,86);
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],155,102);
        ctx.fillText(y[1],155,110);
        ctx.fillText(y[2],155,118);
        ctx.fillText(y[3],155,124);
        ctx.fillText(y[4],155,132);
        ctx.fillText(y[5],155,94);
        ctx.fillText(y[6],155,86);
        ctx.fillText(y(7),155,78);
    }
}
function house_11_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='8px Arial';
    if(len=="1")
    { 
         ctx.fillText(y[0],175,60);
    }
    else if(len=="2")
    {
        ctx.fillText(y[0],175,60);
        ctx.fillText(y[1],175,68);
    }
    else if(len=="3")
    {
        ctx.fillText(y[0],175,52);
        ctx.fillText(y[1],175,60);
        ctx.fillText(y[2],175,68);
    }
    else if(len=="4")
    {
        ctx.fillText(y[0],175,52);
        ctx.fillText(y[1],175,60);
        ctx.fillText(y[2],175,68);
        ctx.fillText(y[3],182,76);
    }
     else if(len=="5")
    {
        ctx.fillText(y[0],182,44);
        ctx.fillText(y[1],175,52);
        ctx.fillText(y[2],175,60);
        ctx.fillText(y[3],175,68);
        ctx.fillText(y[4],182,76);
    }
    else if(len=="6")
    {
        ctx.fillText(y[0],182,44);
        ctx.fillText(y[1],175,52);
        ctx.fillText(y[2],175,60);
        ctx.fillText(y[3],175,68);
        ctx.fillText(y[4],182,76);
        ctx.fillText(y[5],190,36);
    }
    else if(len=="7")
    {
        ctx.fillText(y[0],182,44);
        ctx.fillText(y[1],175,52);
        ctx.fillText(y[2],175,60);
        ctx.fillText(y[3],175,68);
        ctx.fillText(y[4],182,76);
        ctx.fillText(y[5],190,36);
        ctx.fillText(y[6],194,84);
    }
    else if(len=="8")
    {
        ctx.fillText(y[0],182,44);
        ctx.fillText(y[1],175,52);
        ctx.fillText(y[2],175,60);
        ctx.fillText(y[3],175,68);
        ctx.fillText(y[4],182,76);
        ctx.fillText(y[5],190,36);
        ctx.fillText(y[6],194,84);
        ctx.fillText(y[7],194,36);
    }
}
function house_12_canvas(y)
{
    var len     = y.length;
    get_canvas();
    
    ctx.font='8px Arial';
    if(len == "1")
    {
        ctx.fillText(y[0],150,32);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],150,32);
        ctx.fillText(y[1],150,40);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],150,24);
        ctx.fillText(y[1],150,32);
        ctx.fillText(y[2],150,40);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],150,16);
        ctx.fillText(y[1],150,24);
        ctx.fillText(y[2],150,32);
        ctx.fillText(y[3],150,40);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],150,16);
        ctx.fillText(y[1],150,24);
        ctx.fillText(y[2],150,32);
        ctx.fillText(y[3],150,40);
        ctx.fillText(y[4],120,16);
    }
     else if(len == "6")
    {
        ctx.fillText(y[0],150,16);
        ctx.fillText(y[1],150,24);
        ctx.fillText(y[2],150,32);
        ctx.fillText(y[3],150,40);
        ctx.fillText(y[4],120,16);
        ctx.fillText(y[5],180,16);
    }
     else if(len == "7")
    {
        ctx.fillText(y[0],150,16);
        ctx.fillText(y[1],130,24);
        ctx.fillText(y[2],150,32);
        ctx.fillText(y[3],150,40);
        ctx.fillText(y[4],120,16);
        ctx.fillText(y[5],180,16);
        ctx.fillText(y[6],165,24);
    }
}
