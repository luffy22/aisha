var c   = {};var ctx = {};
function get_canvas(canvas)
{
    c           = document.getElementById(canvas);
    ctx         = c.getContext("2d"); ctx.beginPath();
    
    ctx.rect(5,5,250,250);ctx.strokeStyle='black';
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
function fetch_canvas(canvas)
{
    c           = document.getElementById(canvas);
    ctx         = c.getContext("2d"); ctx.beginPath();
}
function draw_horoscope()
{
    var canvas      = ["horo_canvas","nav_canvas","dash_canvas",
                        "hora_canvas","drek_canvas","chatur_canvas",
                        "sapt_canvas","dwad_canvas","shod_canvas",
                        "vim_canvas","chatvim_canvas","saptvim_canvas",
                        "trim_canvas","khed_canvas","aksh_canvas","shast_canvas"];
    for(var i=0;i<canvas.length;i++)
    {
        get_canvas(canvas[i]); 
    }
}    
function draw_houses(a,b,c,d)
{
    ctx.beginPath();ctx.moveTo(a,b);ctx.lineTo(c,d);ctx.stroke();
}    
function assign_signs(a,b,c)
{
    ctx.beginPath();ctx.font='8px Arial';ctx.fillText(a,b,c);
}
function getAscHouse()
{
    var val             = ["_lagna","_navamsha_sign","_dash",
                            "_hora","_drekan","_chatur",
                            "_sapt","_dwad","_shod",
                            "_vim","_cvim","_saptvim",
                            "_trim","_khed","_aksh","_shasht"]
    for(var i=0;i<val.length;i++)
    {
        var asc         = "ascendant"+val[i];
        var x           = document.getElementById(asc).getAttribute('value');
        assign_asc(i, x); 
        set_planets(i)
    }
    //main_chart("1");
    //assign_asc("1",x);
    //set_planets("1");
}
/*function getMoon()
{
    var x = document.getElementById("moon_sign").getAttribute('value');
    get_canvas();
    assign_asc("2",x);
    main_chart("2");
    set_planets("2");
}
function getNavamsha()
{
    var x = document.getElementById("ascendant_navamsha_sign").getAttribute('value');
    get_canvas();
    assign_asc("3",x);
    main_chart("3");
    set_planets("3");
}*/
function get_planets(chart,sign)
{
    var charts      = ["_lagna","_navamsha_sign","_dash","_hora","_drekan","_chatur",
                            "_sapt","_dwad","_shod","_vim","_cvim","_saptvim",
                            "_trim","_khed","_aksh","_shasht"];
    var planets     = ["sun","moon","mars","mercury","jupiter","venus","saturn","rahu","ketu","uranus","neptune","pluto"];
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       var pl       = planets[i]+charts[chart];
       var pl_sign  = document.getElementById(pl).getAttribute('value')
       if(sign == pl_sign)
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
function assign_asc(a, x)
{
    var canvas      = ["horo_canvas","nav_canvas","dash_canvas",
                        "hora_canvas","drek_canvas","chatur_canvas",
                        "sapt_canvas","dwad_canvas","shod_canvas",
                        "vim_canvas","chatvim_canvas","saptvim_canvas",
                        "trim_canvas","khed_canvas","aksh_canvas","shast_canvas"];
    fetch_canvas(canvas[a]);
    ctx.font='10px Arial';
    if(x == "Aries"){ ctx.fillText("Asc.",75,16);} else if(x == "Taurus"){ctx.fillText("Asc.",138,16);}
    else if(x == "Gemini"){ctx.fillText("Asc.",205,16);} else if(x == "Cancer"){ctx.fillText("Asc.",205,76);}
    else if(x == "Leo"){ctx.fillText("Asc.",205,140);} else if(x == "Virgo"){ctx.fillText("Asc.",205,205);}
    else if(x == "Libra"){ctx.fillText("Asc.",138,205);;} else if(x == "Scorpio"){ctx.fillText("Asc.",75,205);}
    else if(x == "Sagittarius"){ctx.fillText("Asc.",18,205);} else if(x == "Capricorn"){ctx.fillText("Asc.",18,140);}
    else if(x == "Aquarius"){ctx.fillText("Asc.",18,76);} else if(x == "Pisces"){ctx.fillText("Asc.",18,16);} else{y=1;}
}
function set_planets(a)
{
    assign_planets(a,"Aries", 80, 40);assign_planets(a,"Taurus",145,40);
    assign_planets(a,"Gemini",210,40);assign_planets(a,"Cancer",210,90);
    assign_planets(a,"Leo",210,156);assign_planets(a,"Virgo",210,230);
    assign_planets(a,"Libra",145,230);assign_planets(a,"Scorpio",80,230);
    assign_planets(a,"Sagittarius",15,230);assign_planets(a,"Capricorn",15,156);
    assign_planets(a,"Aquarius",15,90);assign_planets(a,"Pisces",15,40);
}
function assign_planets(chart,sign,a,b)
{
    var canvas      = ["horo_canvas","nav_canvas","dash_canvas",
                        "hora_canvas","drek_canvas","chatur_canvas",
                        "sapt_canvas","dwad_canvas","shod_canvas",
                        "vim_canvas","chatvim_canvas","saptvim_canvas",
                        "trim_canvas","khed_canvas","aksh_canvas","shast_canvas"];
    fetch_canvas(canvas[chart]);
    ctx.font='10px Arial';
    var y           = get_planets(chart, sign);
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
            ctx.fillText(y[0],a,b);
            ctx.fillText(y[1],a,b+10);
        }
        if(len=="3")
        { 
            ctx.fillText(y[0],a,b);
            ctx.fillText(y[1],a,b+10);
            ctx.fillText(y[2],a,b+20);
        }
        if(len=="4")
        { 
            ctx.fillText(y[0],a,b-10);
            ctx.fillText(y[1],a,b);
            ctx.fillText(y[2],a,b+10);
            ctx.fillText(y[3],a,b+20);
        }
        if(len=="5")
        { 
           ctx.fillText(y[0],a+10,b-15);
            ctx.fillText(y[1],a-10,b-5);
            ctx.fillText(y[2],a-10,b+5);
            ctx.fillText(y[3],a-10,b+15);
            ctx.fillText(y[4],a-10,b+25);
        }
        if(len=="6")
        { 
            ctx.fillText(y[0],a+10,b-15);
            ctx.fillText(y[1],a-10,b-5);
            ctx.fillText(y[2],a-10,b+5);
            ctx.fillText(y[3],a-10,b+15);
            ctx.fillText(y[4],a-10,b+25);
            ctx.fillText(y[5],a-10,b+35);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],a+10,b-17);
            ctx.fillText(y[1],a-12,b-5);
            ctx.fillText(y[2],a-12,b+5);
            ctx.fillText(y[3],a-12,b+15);
            ctx.fillText(y[4],a-12,b+25);
            ctx.fillText(y[5],a-12,b+35);
            ctx.fillText(y[6],a+20,b-5);
        }
         if(len=="8")
        { 
            ctx.fillText(y[0],a+20,b-15);
            ctx.fillText(y[1],a-12,b-5);
            ctx.fillText(y[2],a-12,b+5);
            ctx.fillText(y[3],a-12,b+15);
            ctx.fillText(y[4],a-12,b+25);
            ctx.fillText(y[5],a-12,b+35);
            ctx.fillText(y[6],a+20,b-5);
            ctx.fillText(y[7],a+20,b+5);
        }
    }
}
function main_chart(a)
{
    get_canvas();
    if(a == "1")
    {
        var ctx     = ctx1;
    }
    else if(a=="2")
    {
        var ctx     = ctx2;
    }
    else if(a=="3")
    {
        var ctx     = ctx3;
    }
    ctx.font    ='10px Arial';
    var fname   = document.getElementById("fname").getAttribute('value');
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
    var s       = pob.split(',')[0];
    if(a == "1")
    {
        ctx.fillText("Main Chart",100,80);
    }
    else if(a == "2")
    {
        ctx.fillText("Moon Chart",100,80);
    }
    else if(a == "3")
    {
        ctx.fillText("Navamsha Chart",100,80);
    }
    ctx.fillText(name, 70, 95);
    ctx.fillText(gender, 70, 110);
    ctx.fillText(dob, 70, 125);
    ctx.fillText(tob,70,140);
    ctx.fillText(s,70,155);
}
getAscHouse();
