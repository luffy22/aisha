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
    ctx.font='33% Arial';
    ctx.fillText(x,74,73);
    var y = calc_next_value(x);
    house_2(y);
}
function house_2(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.beginPath();
    ctx.font='33%';
    ctx.fillText(x,40,39);
    var y = calc_next_value(x);
    house_3(y);
}
function house_3(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='33%';
    ctx.fillText(x,34,45);
    var y = calc_next_value(x);
    house_4(y);
}
function house_4(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='33%';
    ctx.fillText(x,68,79);
    var y = calc_next_value(x);
    house_5(y);
}
function house_5(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='33%';
    ctx.fillText(x,33,115);
    var y = calc_next_value(x);
    house_6(y);
}
function house_6(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='33% Arial';
    ctx.fillText(x,38,122);
    var y = calc_next_value(x);
    house_7(y);
}
function house_7(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='33% Arial';
    ctx.fillText(x,75,85);
    var y = calc_next_value(x);
    house_8(y);
}
function house_8(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='33% Arial';
    ctx.fillText(x,112,122);
    
    var y = calc_next_value(x);
    house_9(y);
}
function house_9(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='33% Arial';
    ctx.fillText(x,118,116);
    var y = calc_next_value(x);
    house_10(y);
}
function house_10(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='33% Arial';
    ctx.fillText(x,82,79);
    var y = calc_next_value(x);
    house_11(y);
}  
function house_11(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='33% Arial';
    ctx.fillText(x,117,44);
    var y = calc_next_value(x);
    house_12(y);
}
function house_12(y)
{
    var x = y;
    get_canvas();       // get the canvas in 2d
    ctx.font='33% Arial';
    ctx.fillText(x,110,38);
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
    
    ctx.font='38% verdana';
    if(len=="1")
    { 
        ctx.fillText(y[0],68,42);
    }
    else if(len=="2")
    {
        ctx.fillText(y[0],65,35);
        ctx.fillText(y[1],65,42);
    }
    else if(len=="3")
    {
        ctx.fillText(y[0],65,35);
        ctx.fillText(y[1],58,42);
        ctx.fillText(y[2],65,49);
    }
    else if(len=="4")
    {
        ctx.fillText(y[0],65,35);
        ctx.fillText(y[1],65,42);
        ctx.fillText(y[2],65,48);
        ctx.fillText(y[3],65,56);
    }
    else if(len=="5")
    {
        ctx.fillText(y[0],65,24);
        ctx.fillText(y[1],65,30);
        ctx.fillText(y[2],65,36);
        ctx.fillText(y[3],65,42);
        ctx.fillText(y[4],65,48);
    }
     else if(len=="6")
    {
        ctx.fillText(y[0],65,24);
        ctx.fillText(y[1],65,30);
        ctx.fillText(y[2],65,36);
        ctx.fillText(y[3],65,42);
        ctx.fillText(y[4],65,48);
        ctx.fillText(y[5],65,54);
    }
    else if(len=="7")
    {
        ctx.fillText(y[0],65,24);
        ctx.fillText(y[1],65,30);
        ctx.fillText(y[2],65,36);
        ctx.fillText(y[3],65,42);
        ctx.fillText(y[4],65,48);
        ctx.fillText(y[5],65,54);
        ctx.fillText(y[6],65,60);
    }
    
    else if(len=="8")
    {
        ctx.fillText(y[0],65,24);
        ctx.fillText(y[1],65,30);
        ctx.fillText(y[2],65,36);
        ctx.fillText(y[3],52,42);
        ctx.fillText(y[4],75,42);
        ctx.fillText(y[5],52,48);
        ctx.fillText(y[6],75,48);
        ctx.fillText(y[7],65,54);
    }
    else if(len=="9")
    {
        ctx.fillText(y[0],65,24);
        ctx.fillText(y[1],65,30);
        ctx.fillText(y[2],65,36);
        ctx.fillText(y[3],52,42);
        ctx.fillText(y[4],75,42);
        ctx.fillText(y[5],52,48);
        ctx.fillText(y[6],75,48);
        ctx.fillText(y[7],65,54);
        ctx.fillText(y[8],65,60);
    }
}
function house_2_canvas(y)
{
    var len     = y.length;
    get_canvas();
    ctx.font='38% verdana';
    if(len=="1")
    { 
        ctx.fillText(y[0],30,22);
    }
    else if(len=="2")
    { 
        ctx.fillText(y[0],30,15);
        ctx.fillText(y[1],30,21);
    }
    else if(len=="3")
    { 
        ctx.fillText(y[0],30,15);
        ctx.fillText(y[1],30,21);
        ctx.fillText(y[2],30,27);
    }
    else if(len=="4")
    { 
        ctx.fillText(y[0],15,12);
        ctx.fillText(y[1],35,12);
        ctx.fillText(y[2],35,18);
        ctx.fillText(y[3],35,24);
    }
    else if(len=="5")
    { 
        ctx.fillText(y[0],15,12);
        ctx.fillText(y[1],35,12);
        ctx.fillText(y[2],35,18);
        ctx.fillText(y[3],35,24);
        ctx.fillText(y[4],35,30);
    }
    else if(len=="6")
    { 
    
    }
    else if(len=="7")
    { 
    
    }
    else if(len=="8")
    { 
    
    }
    else if(len=="9")
    { 
    
    }
}
function house_3_canvas(y)
{
    var len     = y.length;
    get_canvas();
    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],7,42);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],7,35);
        ctx.fillText(y[1],7,42);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],7,35);
        ctx.fillText(y[1],7,42);
        ctx.fillText(y[2],7,49);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],7,35);
        ctx.fillText(y[1],7,42);
        ctx.fillText(y[2],7,49);
        ctx.fillText(y[3],7,55);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],7,35);
        ctx.fillText(y[1],7,42);
        ctx.fillText(y[2],7,49);
        ctx.fillText(y[3],7,55);
        ctx.fillText(y[4],7,61);
    }
}

function house_4_canvas(y)
{
    var len     = y.length;
    get_canvas();
    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],36,78);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],36,72);
        ctx.fillText(y[1],36,78);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],36,62);
        ctx.fillText(y[1],36,67);
        ctx.fillText(y[2],36,72);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],36,62);
        ctx.fillText(y[1],36,67);
        ctx.fillText(y[2],36,72);
        ctx.fillText(y[3],36,78);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],36,62);
        ctx.fillText(y[1],36,67);
        ctx.fillText(y[2],36,72);
        ctx.fillText(y[3],36,78);
        ctx.fillText(y[4],36,84);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],36,62);
        ctx.fillText(y[1],36,67);
        ctx.fillText(y[2],36,72);
        ctx.fillText(y[3],36,78);
        ctx.fillText(y[4],36,84);
        ctx.fillText(y[5],36,90);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],36,62);
        ctx.fillText(y[1],36,67);
        ctx.fillText(y[2],36,72);
        ctx.fillText(y[3],36,78);
        ctx.fillText(y[4],36,84);
        ctx.fillText(y[5],36,90);
        ctx.fillText(y[6],36,96);
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],36,62);
        ctx.fillText(y[1],36,67);
        ctx.fillText(y[2],36,72);
        ctx.fillText(y[3],36,78);
        ctx.fillText(y[4],36,84);
        ctx.fillText(y[5],36,90);
        ctx.fillText(y[6],36,96);
        ctx.fillText(y[7],36,102);
    }
}
function house_5_canvas(y)
{
    
    var len     = y.length;
    get_canvas();

    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],7,72);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],7,112);
        ctx.fillText(y[1],7,119);
    }
}
function house_6_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],30,137);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],30,130);
        ctx.fillText(y[1],30,137);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],30,128);
        ctx.fillText(y[1],30,134);
        ctx.fillText(y[2],30,140);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],30,128);
        ctx.fillText(y[1],30,134);
        ctx.fillText(y[2],30,140);
        ctx.fillText(y[3],30,148);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],30,128);
        ctx.fillText(y[1],30,134);
        ctx.fillText(y[2],18,140);
        ctx.fillText(y[3],40,140);
        ctx.fillText(y[4],30,148);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],30,128);
        ctx.fillText(y[1],30,134);
        ctx.fillText(y[2],18,140);
        ctx.fillText(y[3],40,140);
        ctx.fillText(y[4],12,148);
        ctx.fillText(y[5],36,148);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],30,128);
        ctx.fillText(y[1],30,134);
        ctx.fillText(y[2],18,140);
        ctx.fillText(y[3],40,140);
        ctx.fillText(y[4],12,148);
        ctx.fillText(y[5],32,148);
        ctx.fillText(y[6],52,148);
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],30,128);
        ctx.fillText(y[1],30,134);
        ctx.fillText(y[2],18,140);
        ctx.fillText(y[3],40,140);
        ctx.fillText(y[4],12,148);
        ctx.fillText(y[5],32,148);
        ctx.fillText(y[6],52,148);
        ctx.fillText(y[7],50,134);
    }
}
function house_7_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],65,110);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],68,110);
        ctx.fillText(y[1],65,116);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],68,97);
        ctx.fillText(y[1],68,104);
        ctx.fillText(y[2],68,111);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],68,97);
        ctx.fillText(y[1],68,104);
        ctx.fillText(y[2],68,111);
        ctx.fillText(y[3],68,119);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],68,97);
        ctx.fillText(y[1],68,104);
        ctx.fillText(y[2],68,111);
        ctx.fillText(y[3],68,119);
        ctx.fillText(y[4],68,126);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],68,97);
        ctx.fillText(y[1],68,104);
        ctx.fillText(y[2],68,111);
        ctx.fillText(y[3],68,119);
        ctx.fillText(y[4],68,126);
        ctx.fillText(y[5],68,132);
    }
     else if(len == "7")
    {
        ctx.fillText(y[0],68,97);
        ctx.fillText(y[1],68,104);
        ctx.fillText(y[2],48,111);
        ctx.fillText(y[3],68,111);
        ctx.fillText(y[4],48,126);
        ctx.fillText(y[5],68,126);
        ctx.fillText(y[6],68,132);
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],68,97);
        ctx.fillText(y[1],68,104);
        ctx.fillText(y[2],48,111);
        ctx.fillText(y[3],68,111);
        ctx.fillText(y[4],48,126);
        ctx.fillText(y[5],68,126);
        ctx.fillText(y[6],68,132);
        ctx.fillText(y[7],68,139);
    }
}
function house_8_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],105,137);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],105,130);
        ctx.fillText(y[1],105,137);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],105,130);
        ctx.fillText(y[1],105,136);
        ctx.fillText(y[2],105,142);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],105,130);
        ctx.fillText(y[1],105,136);
        ctx.fillText(y[2],105,142);
        ctx.fillText(y[3],105,148);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],105,130);
        ctx.fillText(y[1],105,136);
        ctx.fillText(y[2],105,142);
        ctx.fillText(y[3],105,148);
        ctx.fillText(y[4], 85,148);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],105,130);
        ctx.fillText(y[1],105,136);
        ctx.fillText(y[2],105,142);
        ctx.fillText(y[3],105,148);
        ctx.fillText(y[4], 85,148);
        ctx.fillText(y[5], 125,148);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],105,130);
        ctx.fillText(y[1],105,136);
        ctx.fillText(y[2],105,142);
        ctx.fillText(y[3],85,142);
        ctx.fillText(y[4],105,148);
        ctx.fillText(y[5],85,148);
        ctx.fillText(y[6],125,148);
    }
     else if(len == "8")
    {
        ctx.fillText(y[0],105,130);
        ctx.fillText(y[1],105,136);
        ctx.fillText(y[2],105,142);
        ctx.fillText(y[3],85,142);
        ctx.fillText(y[4],105,148);
        ctx.fillText(y[5],85,148);
        ctx.fillText(y[6],125,148);
        ctx.fillText(y[7],130,142);
    }
}
function house_9_canvas(y)
{   
    var len     = y.length;
    get_canvas();

    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],125,115);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],125,115);
        ctx.fillText(y[1],125,122);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],125,105);
        ctx.fillText(y[1],125,112);
        ctx.fillText(y[2],127,122);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],135,95);
        ctx.fillText(y[1],125,122);
        ctx.fillText(y[2],127,127);
        ctx.fillText(y[3],133,133);
    }
     else if(len == "5")
    {
        ctx.fillText(y[0],135,95);
        ctx.fillText(y[1],125,122);
        ctx.fillText(y[2],127,127);
        ctx.fillText(y[3],133,133);
        ctx.fillText(y[4],133,102);
    }
     else if(len == "6")
    {
        ctx.fillText(y[0],135,95);
        ctx.fillText(y[1],125,122);
        ctx.fillText(y[2],127,127);
        ctx.fillText(y[3],133,133);
        ctx.fillText(y[4],133,102);
        ctx.fillText(y[5],131,109);
    }
     else if(len == "7")
    {
        ctx.fillText(y[0],135,95);
        ctx.fillText(y[1],125,122);
        ctx.fillText(y[2],127,127);
        ctx.fillText(y[3],133,133);
        ctx.fillText(y[4],133,102);
        ctx.fillText(y[5],131,109);
        ctx.fillText(y[6],125,115);
    }
}
function house_10_canvas(y)
{
    var len     = y.length;
    get_canvas();
    
    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],100,72);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],100,72);
        ctx.fillText(y[1],100,79);
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
    else if(len == "5")
    {
        ctx.fillText(y[0],100,62);
        ctx.fillText(y[1],100,70);
        ctx.fillText(y[2],100,78);
        ctx.fillText(y[3],100,84);
        ctx.fillText(y[4],100,90);
    }
    else if(len == "6")
    {
        ctx.fillText(y[0],100,62);
        ctx.fillText(y[1],100,70);
        ctx.fillText(y[2],100,78);
        ctx.fillText(y[3],100,84);
        ctx.fillText(y[4],100,90);
        ctx.fillText(y[5],100,96);
    }
    else if(len == "7")
    {
        ctx.fillText(y[0],100,62);
        ctx.fillText(y[1],100,70);
        ctx.fillText(y[2],100,78);
        ctx.fillText(y[3],100,84);
        ctx.fillText(y[4],100,90);
        ctx.fillText(y[5],100,96);
        ctx.fillText(y[6],100,102);
    }
    else if(len == "8")
    {
        ctx.fillText(y[0],100,62);
        ctx.fillText(y[1],100,70);
        ctx.fillText(y[2],100,78);
        ctx.fillText(y[3],100,84);
        ctx.fillText(y[4],100,90);
        ctx.fillText(y[5],100,96);
        ctx.fillText(y[6],100,102);
        ctx.fillText(y[7],102,54);
    }
    
}
function house_11_canvas(y)
{
    var len     = y.length;
    get_canvas();

    ctx.font='38% verdana';
    if(len=="1")
    { 
         ctx.fillText(y[0],125,40);
    }
    else if(len=="2")
    {
        ctx.fillText(y[0],125,40);
        ctx.fillText(y[1],125,48);
    }
    else if(len=="3")
    {
        ctx.fillText(y[0],125,35);
        ctx.fillText(y[1],125,42);
        ctx.fillText(y[2],125,49);
    }
    else if(len=="4")
    {
        ctx.fillText(y[0],125,32);
        ctx.fillText(y[1],125,40);
        ctx.fillText(y[2],125,48);
        ctx.fillText(y[3],127,56);
    }
     else if(len=="5")
    {
        ctx.fillText(y[0],130,26);
        ctx.fillText(y[1],125,32);
        ctx.fillText(y[2],125,38);
        ctx.fillText(y[3],125,44);
        ctx.fillText(y[4],130,50);
    }
    else if(len=="6")
    {
        ctx.fillText(y[0],130,26);
        ctx.fillText(y[1],125,32);
        ctx.fillText(y[2],125,38);
        ctx.fillText(y[3],125,44);
        ctx.fillText(y[4],125,50);
        ctx.fillText(y[5],127,56);
    }
    else if(len=="7")
    {
        ctx.fillText(y[0],130,26);
        ctx.fillText(y[1],125,32);
        ctx.fillText(y[2],125,38);
        ctx.fillText(y[3],125,44);
        ctx.fillText(y[4],125,50);
        ctx.fillText(y[5],127,56);
        ctx.fillText(y[6],132,62);
    }
    else if(len=="8")
    {
        ctx.fillText(y[0],130,26);
        ctx.fillText(y[1],125,32);
        ctx.fillText(y[2],125,38);
        ctx.fillText(y[3],125,44);
        ctx.fillText(y[4],125,50);
        ctx.fillText(y[5],127,56);
        ctx.fillText(y[6],132,62);
        ctx.fillText(y[7],138,68);
    }
   
}
function house_12_canvas(y)
{
    var len     = y.length;
    get_canvas();
    
    ctx.font='38% verdana';
    if(len == "1")
    {
        ctx.fillText(y[0],105,26);
    }
    else if(len == "2")
    {
        ctx.fillText(y[0],105,20);
        ctx.fillText(y[1],105,26);
    }
    else if(len == "3")
    {
        ctx.fillText(y[0],105,14);
        ctx.fillText(y[1],105,20);
        ctx.fillText(y[2],105,26);
    }
    else if(len == "4")
    {
        ctx.fillText(y[0],85,14);
        ctx.fillText(y[1],105,20);
        ctx.fillText(y[2],105,26);
        ctx.fillText(y[3],105,14);
    }
    else if(len == "5")
    {
        ctx.fillText(y[0],85,14);
        ctx.fillText(y[1],105,14);
        ctx.fillText(y[2],90,20);
        ctx.fillText(y[3],110,20);
        ctx.fillText(y[4],105,26);
    }
     else if(len == "6")
    {
        ctx.fillText(y[0],85,14);
        ctx.fillText(y[1],105,14);
        ctx.fillText(y[2],90,20);
        ctx.fillText(y[3],110,20);
        ctx.fillText(y[4],105,26);
        ctx.fillText(y[5],105,32);
    }
     else if(len == "7")
    {
        ctx.fillText(y[0],85,14);
        ctx.fillText(y[1],105,14);
        ctx.fillText(y[2],90,20);
        ctx.fillText(y[3],110,20);
        ctx.fillText(y[4],105,26);
        ctx.fillText(y[5],105,32);
        ctx.fillText(y[6],130,14);
    }
}
