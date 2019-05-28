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
    
    ctx.rect(65,65,130,130);
    ctx.strokeStyle='black';
    ctx.lineWidth=1;
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(65,5);
    ctx.lineTo(65,65);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(5,65);
    ctx.lineTo(65,65);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(65,195);
    ctx.lineTo(5,195);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(65,195);
    ctx.lineTo(65,255);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(65,195);
    ctx.lineTo(5,195);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(195,5);
    ctx.lineTo(195,65);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(255,65);
    ctx.lineTo(195,65);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(195,195);
    ctx.lineTo(195,255);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(255,195);
    ctx.lineTo(195,195);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(130,5);
    ctx.lineTo(130,65);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(130,195);
    ctx.lineTo(130,255);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(5,130);
    ctx.lineTo(65,130);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(195,130);
    ctx.lineTo(255,130);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('3',197,15);
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('4',197,75);
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('5',197,140);
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('6',197,205);
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('12',7 ,15);
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('11',7,75);
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('10',7,140);
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('9',7,205);
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('2',132,15);
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('7',132,205);
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('1',67,15);
    
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText('8',67,205);
    
}
function getAscendant()
{
    var x = document.getElementById("ascendant_sign").getAttribute('value');
    get_canvas();
    ctx.font='10px Arial';
    if(x == "Aries"){ ctx.fillText("Asc.",75,16);} else if(x == "Taurus"){ctx.fillText("Asc.",138,16);}
    else if(x == "Gemini"){ctx.fillText("Asc.",205,16);} else if(x == "Cancer"){ctx.fillText("Asc.",205,76);}
    else if(x == "Leo"){ctx.fillText("Asc.",205,140);} else if(x == "Virgo"){ctx.fillText("Asc.",205,205);}
    else if(x == "Libra"){ctx.fillText("Asc.",138,205);;} else if(x == "Scorpio"){ctx.fillText("Asc.",75,205);}
    else if(x == "Sagittarius"){ctx.fillText("Asc.",18,205);} else if(x == "Capricorn"){ctx.fillText("Asc.",18,140);}
    else if(x == "Aquarius"){ctx.fillText("Asc.",18,76);} else if(x == "Pisces"){ctx.fillText("Asc.",18,16);} else{y=1;}
    aries_planets();
}
function getMoon()
{
    var x = document.getElementById("moon_sign").getAttribute('value');
    get_canvas();
    ctx.font='10px Arial';
    if(x == "Aries"){ ctx.fillText("Asc.",75,16);} else if(x == "Taurus"){ctx.fillText("Asc.",138,16);}
    else if(x == "Gemini"){ctx.fillText("Asc.",205,16);} else if(x == "Cancer"){ctx.fillText("Asc.",205,76);}
    else if(x == "Leo"){ctx.fillText("Asc.",205,140);} else if(x == "Virgo"){ctx.fillText("Asc.",205,205);}
    else if(x == "Libra"){ctx.fillText("Asc.",138,205);;} else if(x == "Scorpio"){ctx.fillText("Asc.",75,205);}
    else if(x == "Sagittarius"){ctx.fillText("Asc.",18,205);} else if(x == "Capricorn"){ctx.fillText("Asc.",18,140);}
    else if(x == "Aquarius"){ctx.fillText("Asc.",18,76);} else if(x == "Pisces"){ctx.fillText("Asc.",18,16);} else{y=1;}
    aries_planets(); 
}
function getNavamsha()
{
    var x = document.getElementById("ascendant_sign").getAttribute('value');
    get_canvas();
    ctx.font='10px Arial';
    if(x == "Aries"){ ctx.fillText("Asc.",75,16);} else if(x == "Taurus"){ctx.fillText("Asc.",138,16);}
    else if(x == "Gemini"){ctx.fillText("Asc.",205,16);} else if(x == "Cancer"){ctx.fillText("Asc.",205,76);}
    else if(x == "Leo"){ctx.fillText("Asc.",205,140);} else if(x == "Virgo"){ctx.fillText("Asc.",205,205);}
    else if(x == "Libra"){ctx.fillText("Asc.",138,205);;} else if(x == "Scorpio"){ctx.fillText("Asc.",75,205);}
    else if(x == "Sagittarius"){ctx.fillText("Asc.",18,205);} else if(x == "Capricorn"){ctx.fillText("Asc.",18,140);}
    else if(x == "Aquarius"){ctx.fillText("Asc.",18,76);} else if(x == "Pisces"){ctx.fillText("Asc.",18,16);} else{y=1;}
    aries_planets(); 
}
function get_planets(sign)
{
    var sign        = sign;
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
    if(y.length > 0)        // check if there are any planets in house
    {
        return y;
    }
    else
    {
        return "0";
    }
}
function aries_planets()
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Aries");
    var len         = y.length;
    if(y == "0"){}
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],80,40);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],80,32);
            ctx.fillText(y[1],80,40);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],80,32);
            ctx.fillText(y[1],80,40);
            ctx.fillText(y[2],80,48);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],80,32);
            ctx.fillText(y[1],80,40);
            ctx.fillText(y[2],80,48);
            ctx.fillText(y[3],80,56);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],105,24);
            ctx.fillText(y[1],80,32);
            ctx.fillText(y[2],80,40);
            ctx.fillText(y[3],80,48);
            ctx.fillText(y[4],80,56);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],105,24);
            ctx.fillText(y[1],67,32);
            ctx.fillText(y[2],95,32);
            ctx.fillText(y[3],67,48);
            ctx.fillText(y[4],95,48);
            ctx.fillText(y[5],80,56);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],105,24);
            ctx.fillText(y[1],67,32);
            ctx.fillText(y[2],95,32);
            ctx.fillText(y[3],67,48);
            ctx.fillText(y[4],95,48);
            ctx.fillText(y[5],67,56);
            ctx.fillText(y[6],95,56);
        }
    }
    taurus_planets();
}
function taurus_planets()
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Taurus");
    var len         = y.length;
    if(y == "0"){ }
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],145,40);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],145,32);
            ctx.fillText(y[1],145,40);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],145,32);
            ctx.fillText(y[1],145,40);
            ctx.fillText(y[2],145,48);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],145,32);
            ctx.fillText(y[1],145,40);
            ctx.fillText(y[2],145,48);
            ctx.fillText(y[3],145,56);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],170,24);
            ctx.fillText(y[1],145,32);
            ctx.fillText(y[2],145,40);
            ctx.fillText(y[3],145,48);
            ctx.fillText(y[4],145,56);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],170,24);
            ctx.fillText(y[1],145,32);
            ctx.fillText(y[2],135,40);
            ctx.fillText(y[3],170,40);
            ctx.fillText(y[4],145,48);
            ctx.fillText(y[5],145,56);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],170,24);
            ctx.fillText(y[1],145,32);
            ctx.fillText(y[2],135,40);
            ctx.fillText(y[3],170,40);
            ctx.fillText(y[4],135,48);
            ctx.fillText(y[5],170,48);
            ctx.fillText(y[6],170,56);
        }
    }
    gemini_planets();
}
function gemini_planets()
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Gemini");
    var len         = y.length;
    if(y == "0"){ }
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],210,40);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],210,32);
            ctx.fillText(y[1],210,40);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],210,32);
            ctx.fillText(y[1],210,40);
            ctx.fillText(y[2],145,48);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],210,32);
            ctx.fillText(y[1],210,40);
            ctx.fillText(y[2],210,48);
            ctx.fillText(y[3],210,56);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],225,24);
            ctx.fillText(y[1],210,32);
            ctx.fillText(y[2],210,40);
            ctx.fillText(y[3],210,48);
            ctx.fillText(y[4],210,56);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],225,24);
            ctx.fillText(y[1],210,32);
            ctx.fillText(y[2],190,40);
            ctx.fillText(y[3],225,40);
            ctx.fillText(y[4],190,48);
            ctx.fillText(y[5],225,56);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],225,24);
            ctx.fillText(y[1],210,32);
            ctx.fillText(y[2],190,40);
            ctx.fillText(y[3],225,40);
            ctx.fillText(y[4],190,48);
            ctx.fillText(y[5],225,48);
            ctx.fillText(y[5],210,56);
        }
    }
    cancer_planets();
}
function cancer_planets()
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Cancer");
    var len         = y.length;
    if(y == "0"){ }
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],210,90);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],210,90);
            ctx.fillText(y[1],210,98);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],210,90);
            ctx.fillText(y[1],210,98);
            ctx.fillText(y[2],210,106);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],210,90);
            ctx.fillText(y[1],210,98);
            ctx.fillText(y[2],210,106);
            ctx.fillText(y[3],210,114);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],210,90);
            ctx.fillText(y[1],210,98);
            ctx.fillText(y[2],210,106);
            ctx.fillText(y[3],210,114);
            ctx.fillText(y[4],210,122);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],225,82);
            ctx.fillText(y[1],210,90);
            ctx.fillText(y[2],210,98);
            ctx.fillText(y[3],210,106);
            ctx.fillText(y[4],210,114);
            ctx.fillText(y[5],210,122);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],225,82);
            ctx.fillText(y[1],210,90);
            ctx.fillText(y[2],205,98);
            ctx.fillText(y[3],235,98);
            ctx.fillText(y[4],210,106);
            ctx.fillText(y[5],210,114);
            ctx.fillText(y[6],210,122);
        }
    }
    leo_planets();
}
function leo_planets()
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Leo");
    var len         = y.length;
    if(y == "0"){ }
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],210,156);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],210,156);
            ctx.fillText(y[1],210,164);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],210,156);
            ctx.fillText(y[1],210,164);
            ctx.fillText(y[2],210,172);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],210,156);
            ctx.fillText(y[1],210,164);
            ctx.fillText(y[2],210,172);
            ctx.fillText(y[3],210,180);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],210,156);
            ctx.fillText(y[1],210,164);
            ctx.fillText(y[2],210,172);
            ctx.fillText(y[3],210,180);
            ctx.fillText(y[4],210,188);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],210,148);
            ctx.fillText(y[1],210,156);
            ctx.fillText(y[2],210,164);
            ctx.fillText(y[3],210,172);
            ctx.fillText(y[4],210,180);
            ctx.fillText(y[5],210,188);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],210,148);
            ctx.fillText(y[1],210,156);
            ctx.fillText(y[2],210,164);
            ctx.fillText(y[3],210,172);
            ctx.fillText(y[4],210,180);
            ctx.fillText(y[5],210,188);
            ctx.fillText(y[6],225,140);
        }
    }
    virgo_planets();
}
function virgo_planets()
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Virgo");
    var len         = y.length;
    if(y == "0"){ }
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],210,230);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],210,222);
            ctx.fillText(y[1],210,230);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],210,214);
            ctx.fillText(y[1],210,222);
            ctx.fillText(y[2],210,230);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],210,214);
            ctx.fillText(y[1],210,222);
            ctx.fillText(y[2],210,230);
            ctx.fillText(y[3],210,238);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],210,214);
            ctx.fillText(y[1],210,222);
            ctx.fillText(y[2],210,230);
            ctx.fillText(y[3],210,238);
            ctx.fillText(y[4],210,246);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],225,208);
            ctx.fillText(y[1],210,214);
            ctx.fillText(y[2],210,222);
            ctx.fillText(y[3],210,230);
            ctx.fillText(y[4],210,238);
            ctx.fillText(y[5],210,246);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],225,208);
            ctx.fillText(y[1],225,214);
            ctx.fillText(y[2],210,222);
            ctx.fillText(y[3],210,230);
            ctx.fillText(y[4],210,238);
            ctx.fillText(y[5],210,246);
            ctx.fillText(y[6],190,214);
        }
    }
    libra_planets();
}
function libra_planets()
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Libra");
    var len         = y.length;
    if(y == "0"){ }
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],145,230);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],145,222);
            ctx.fillText(y[1],145,230);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],145,214);
            ctx.fillText(y[1],145,222);
            ctx.fillText(y[2],145,230);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],145,214);
            ctx.fillText(y[1],145,222);
            ctx.fillText(y[2],145,230);
            ctx.fillText(y[3],145,238);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],145,214);
            ctx.fillText(y[1],145,222);
            ctx.fillText(y[2],145,230);
            ctx.fillText(y[3],145,238);
            ctx.fillText(y[4],145,246);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],160,208);
            ctx.fillText(y[1],145,214);
            ctx.fillText(y[2],145,222);
            ctx.fillText(y[3],145,230);
            ctx.fillText(y[4],145,238);
            ctx.fillText(y[5],145,246);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],160,208);
            ctx.fillText(y[1],145,214);
            ctx.fillText(y[2],135,222);
            ctx.fillText(y[3],145,230);
            ctx.fillText(y[4],145,238);
            ctx.fillText(y[5],145,246);
            ctx.fillText(y[6],190,222);
        }
    }
    scorpio_planets();
}
function scorpio_planets()
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Scorpio");
    var len         = y.length;
    if(y == "0"){ }
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],80,230);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],80,222);
            ctx.fillText(y[1],80,230);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],80,214);
            ctx.fillText(y[1],80,222);
            ctx.fillText(y[2],80,230);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],80,214);
            ctx.fillText(y[1],80,222);
            ctx.fillText(y[2],80,230);
            ctx.fillText(y[3],80,238);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],80,214);
            ctx.fillText(y[1],80,222);
            ctx.fillText(y[2],80,230);
            ctx.fillText(y[3],80,238);
            ctx.fillText(y[4],80,246);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],100,208);
            ctx.fillText(y[1],80,214);
            ctx.fillText(y[2],80,222);
            ctx.fillText(y[3],80,230);
            ctx.fillText(y[4],80,238);
            ctx.fillText(y[5],80,246);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],100,208);
            ctx.fillText(y[1],80,214);
            ctx.fillText(y[2],70,222);
            ctx.fillText(y[3],80,230);
            ctx.fillText(y[4],80,238);
            ctx.fillText(y[5],80,246);
            ctx.fillText(y[6],95,222);
        }
    }
    sag_planets();
}
function sag_planets()
{
      get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Sagittarius");
    var len         = y.length;
    if(y == "0"){ }
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],15,230);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],15,222);
            ctx.fillText(y[1],15,230);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],15,214);
            ctx.fillText(y[1],15,222);
            ctx.fillText(y[2],15,230);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],15,214);
            ctx.fillText(y[1],15,222);
            ctx.fillText(y[2],15,230);
            ctx.fillText(y[3],15,238);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],15,214);
            ctx.fillText(y[1],15,222);
            ctx.fillText(y[2],15,230);
            ctx.fillText(y[3],15,238);
            ctx.fillText(y[4],15,246);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],25,208);
            ctx.fillText(y[1],15,214);
            ctx.fillText(y[2],15,222);
            ctx.fillText(y[3],15,230);
            ctx.fillText(y[4],15,238);
            ctx.fillText(y[5],15,246);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],25,208);
            ctx.fillText(y[1],15,214);
            ctx.fillText(y[2],10,222);
            ctx.fillText(y[3],15,230);
            ctx.fillText(y[4],15,238);
            ctx.fillText(y[5],15,246);
            ctx.fillText(y[6],35,222);
        }
    }
    cap_planets();
}
function cap_planets()
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Capricorn");
    var len         = y.length;
    if(y == "0"){ }
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],15,156);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],15,156);
            ctx.fillText(y[1],15,164);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],15,156);
            ctx.fillText(y[1],15,164);
            ctx.fillText(y[2],15,172);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],15,156);
            ctx.fillText(y[1],15,164);
            ctx.fillText(y[2],15,172);
            ctx.fillText(y[3],15,180);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],15,156);
            ctx.fillText(y[1],15,164);
            ctx.fillText(y[2],15,172);
            ctx.fillText(y[3],15,180);
            ctx.fillText(y[4],15,188);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],15,148);
            ctx.fillText(y[1],15,156);
            ctx.fillText(y[2],15,164);
            ctx.fillText(y[3],15,172);
            ctx.fillText(y[4],15,180);
            ctx.fillText(y[5],15,188);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],15,148);
            ctx.fillText(y[1],15,156);
            ctx.fillText(y[2],15,164);
            ctx.fillText(y[3],15,172);
            ctx.fillText(y[4],15,180);
            ctx.fillText(y[5],15,188);
            ctx.fillText(y[6],30,140);
        }
    }
    aqua_planets();
}
function aqua_planets()
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Aquarius");
    var len         = y.length;
    if(y == "0"){ }
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],15,90);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],15,90);
            ctx.fillText(y[1],15,98);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],15,90);
            ctx.fillText(y[1],15,98);
            ctx.fillText(y[2],15,106);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],15,90);
            ctx.fillText(y[1],15,98);
            ctx.fillText(y[2],15,106);
            ctx.fillText(y[3],15,114);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],15,90);
            ctx.fillText(y[1],15,98);
            ctx.fillText(y[2],15,106);
            ctx.fillText(y[3],15,114);
            ctx.fillText(y[4],15,122);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],35,82);
            ctx.fillText(y[1],15,90);
            ctx.fillText(y[2],15,98);
            ctx.fillText(y[3],15,106);
            ctx.fillText(y[4],15,114);
            ctx.fillText(y[5],15,122);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],35,82);
            ctx.fillText(y[1],15,90);
            ctx.fillText(y[2],10,98);
            ctx.fillText(y[3],35,98);
            ctx.fillText(y[4],15,106);
            ctx.fillText(y[5],15,114);
            ctx.fillText(y[6],15,122);
        }
    }
    pisces_planets();
}
function pisces_planets()
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets("Pisces");
    var len         = y.length;
    if(y == "0"){ }
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],15,40);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],15,32);
            ctx.fillText(y[1],15,40);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],15,32);
            ctx.fillText(y[1],15,40);
            ctx.fillText(y[2],15,48);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],15,32);
            ctx.fillText(y[1],15,40);
            ctx.fillText(y[2],15,48);
            ctx.fillText(y[3],15,56);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],35,24);
            ctx.fillText(y[1],15,32);
            ctx.fillText(y[2],15,40);
            ctx.fillText(y[3],15,48);
            ctx.fillText(y[4],15,56);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],35,24);
            ctx.fillText(y[1],15,32);
            ctx.fillText(y[2],15,40);
            ctx.fillText(y[3],15,48);
            ctx.fillText(y[4],15,56);
            ctx.fillText(y[5],15,64);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],35,24);
            ctx.fillText(y[1],15,32);
            ctx.fillText(y[2],10,40);
            ctx.fillText(y[3],40,40);
            ctx.fillText(y[4],10,48);
            ctx.fillText(y[5],40,48);
            ctx.fillText(y[5],15,56);
        }
    }
}