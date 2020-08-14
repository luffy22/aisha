var c   = {};var ctx = {};
function get_canvas()
{
    var url     = window.location.href;
    if(url.includes("mainchart"))
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
    get_canvas();ctx.rect(5,5,250,250);ctx.strokeStyle='black';
    ctx.lineWidth=1;ctx.stroke();
    
    ctx.rect(65,65,130,130);ctx.strokeStyle='black';
    ctx.lineWidth=1;ctx.stroke();
    
    draw_houses(65,5,65,65);draw_houses(5,65,65,65);draw_houses(65,195,5,195);
    draw_houses(65,195,65,255);draw_houses(65,195,5,195);draw_houses(195,5,195,65);
    draw_houses(255,65,195,65);draw_houses(195,195,195,255);draw_houses(255,195,195,195);
    draw_houses(130,5,130,65);draw_houses(130,195,130,255);draw_houses(5,130,65,130);
    draw_houses(195,130,255,130);
    
    assign_signs("1",67,15);assign_signs('2',132,15);assign_signs('3',197,15);
    assign_signs('4',197,75);assign_signs('5',197,140);assign_signs('6',197,205);
    assign_signs('7',132,205);assign_signs('8',67,205);assign_signs('9',7,205);
    assign_signs('10',7,140);assign_signs('11',7,75);assign_signs('12',7 ,15);
}    
function draw_houses(a,b,c,d)
{
    get_canvas();
    ctx.beginPath();
    ctx.moveTo(a,b);
    ctx.lineTo(c,d);
    ctx.stroke();
}    
function assign_signs(a,b,c)
{
    ctx.beginPath();
    ctx.font='8px Arial';
    ctx.fillText(a,b,c);
}
function getAscendant()
{
    var x       = document.getElementById("ascendant_sign").getAttribute('value');
    var url     = window.location.href;
    if(url.includes("mainchart"))
    {
        main_chart();
    }
    else if(url.includes("getasc"))
    {
        asc_chart();
    }
    assign_asc(x);
    set_planets();
}
function getMoon()
{
    var x = document.getElementById("moon_sign").getAttribute('value');
    get_canvas();
    assign_asc(x);
    asc_chart();
    set_planets();
}
function getNavamsha()
{
    var x = document.getElementById("ascendant_sign").getAttribute('value');
    get_canvas();
    assign_asc(x);
    asc_chart();
    set_planets();
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
function assign_asc(x)
{
    get_canvas();
    ctx.font='10px Arial';
    if(x == "Aries"){ ctx.fillText("Asc.",75,16);} else if(x == "Taurus"){ctx.fillText("Asc.",138,16);}
    else if(x == "Gemini"){ctx.fillText("Asc.",205,16);} else if(x == "Cancer"){ctx.fillText("Asc.",205,76);}
    else if(x == "Leo"){ctx.fillText("Asc.",205,140);} else if(x == "Virgo"){ctx.fillText("Asc.",205,205);}
    else if(x == "Libra"){ctx.fillText("Asc.",138,205);;} else if(x == "Scorpio"){ctx.fillText("Asc.",75,205);}
    else if(x == "Sagittarius"){ctx.fillText("Asc.",18,205);} else if(x == "Capricorn"){ctx.fillText("Asc.",18,140);}
    else if(x == "Aquarius"){ctx.fillText("Asc.",18,76);} else if(x == "Pisces"){ctx.fillText("Asc.",18,16);} else{y=1;}
}
function set_planets()
{
    assign_planets("Aries", 80, 40);assign_planets("Taurus",145,40);
    assign_planets("Gemini",210,40);assign_planets("Cancer",210,90);
    assign_planets("Leo",210,156);assign_planets("Virgo",210,230);
    assign_planets("Libra",145,230);assign_planets("Scorpio",80,230);
    assign_planets("Sagittarius",15,230);assign_planets("Capricorn",15,156);
    assign_planets("Aquarius",15,90);assign_planets("Pisces",15,40);
}
function assign_planets(x,a,b)
{
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets(x);
    var len         = y.length;
    if(y == "0"){}
    else
    {
        if(len=="1")
        { 
            ctx.fillText(y[0],a,b);
        }
        if(len=="2")
        { 
            ctx.fillText(y[0],a,b-8);
            ctx.fillText(y[1],a,b);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],a,b-8);
            ctx.fillText(y[1],a,b);
            ctx.fillText(y[2],a,b+8);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],a,b-8);
            ctx.fillText(y[1],a,b);
            ctx.fillText(y[2],a,b+8);
            ctx.fillText(y[3],a,b+16);
        }
        if(len=="5")
        { 
            ctx.fillText(y[0],a+25,b-16);
            ctx.fillText(y[1],a,b-8);
            ctx.fillText(y[2],a,b);
            ctx.fillText(y[3],a,b+8);
            ctx.fillText(y[4],a,b+16);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],a+25,b-20);
            ctx.fillText(y[1],a,b-15);
            ctx.fillText(y[2],a,b-8);
            ctx.fillText(y[3],a,b);
            ctx.fillText(y[4],a,b+8);
            ctx.fillText(y[5],a,b+16);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],a+25,b-20);
            ctx.fillText(y[1],a,b-15);
            ctx.fillText(y[2],a,b-8);
            ctx.fillText(y[3],a,b);
            ctx.fillText(y[4],a,b+8);
            ctx.fillText(y[5],a,b+16);
            ctx.fillText(y[6],a+15,b+20);
        }
    }
}
function main_chart()
{
    get_canvas();
    ctx.font    ='10px Arial';
    var fname   = document.getElementById("fname_sign").value('value');
    alert(fname);
    var n       = fname.search(" ");
    var d 		= fname.includes(" ");
    if(d == true)
    {
		var name    = "Name: "+ fname.substring(0, n);
	}
	else
	{
		var name    = "Name: "+ fname;
	}
    var gender  = "Gender: "+document.getElementById("gender").getAttribute('value');
    var dob     = "Date: "+document.getElementById("dob").getAttribute('value');
    var tob     = "Time: "+document.getElementById("tob").getAttribute('value');
    var pob     = "Place: "+document.getElementById("pob").getAttribute('value');
    var s       = pob.split(',')[0]
    ctx.fillText("Main Chart",100,80);
    ctx.fillText(name, 70, 95);
    ctx.fillText(gender, 70, 110);
    ctx.fillText(dob, 70, 125);
    ctx.fillText(tob,70,140);
    ctx.fillText(s,70,155);
}
function asc_chart()
{
    var url     = window.location.href;
    get_canvas();
    ctx.font    ='10px Arial';
    var fname   = document.getElementById("fname_sign").getAttribute('value');
    var n       = fname.search(" ");
    var d 		= fname.includes(" ");
    if(d == true)
    {
		var name    = "Name: "+ fname.substring(0, n);
	}
	else
	{
		var name    = "Name: "+ fname;
	}
    var gender  = "Gender: "+document.getElementById("gender_sign").getAttribute('value');
    var dob_tob = document.getElementById("dob_tob_sign").getAttribute('value');
    var dob     = "Date: "+dob_tob.substring(0,10);
    var tob     = "Time: "+dob_tob.substring(11,19);
    var pob     = "Place: "+document.getElementById("pob_sign").getAttribute('value');
    var s       = pob.split(',')[0];
    if(url.includes("getasc"))
    {
        ctx.fillText("Ascendant Chart",80,80);
    }
    else if(url.includes("getmoon"))
    {
        ctx.fillText("Moon Chart",80,80);
    }
    else if(url.includes("getnavamsha"))
    {
        ctx.fillText("Navamsha Chart",80,80);
    }
    ctx.fillText(name, 70, 95);
    ctx.fillText(gender, 70, 110);
    ctx.fillText(dob, 70, 125);
    ctx.fillText(tob,70,140);
    ctx.fillText(s,70,155);
}
