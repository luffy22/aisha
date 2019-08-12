var c1   = {};var ctx1 = {};var c2   = {};var ctx2 = {};var c3   = {};var ctx3 = {};
function get_canvas()
{
    c1          =   document.getElementById("horo_canvas");
    ctx1     =       c1.getContext("2d"); ctx1.beginPath();
    c2          =   document.getElementById("moon_canvas");
    ctx2        =   c2.getContext("2d"); ctx2.beginPath();
    c3          =   document.getElementById("navamsha_canvas");
    ctx3        =   c3.getContext("2d"); ctx3.beginPath();
}
function draw_horoscope()
{
    get_canvas();ctx1.rect(5,5,250,250);ctx1.strokeStyle='black';
    ctx1.lineWidth=1;ctx1.stroke();
    ctx1.rect(65,65,130,130);ctx1.strokeStyle='black';
    ctx1.lineWidth=1;ctx1.stroke();
    
    get_canvas();ctx2.rect(5,5,250,250);ctx2.strokeStyle='black';
    ctx2.lineWidth=1;ctx2.stroke();
    ctx2.rect(65,65,130,130);ctx2.strokeStyle='black';
    ctx2.lineWidth=1;ctx2.stroke();
    
    get_canvas();ctx3.rect(5,5,250,250);ctx3.strokeStyle='black';
    ctx3.lineWidth=1;ctx3.stroke();
    ctx3.rect(65,65,130,130);ctx3.strokeStyle='black';
    ctx3.lineWidth=1;ctx3.stroke();
    
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
    ctx1.beginPath();ctx2.beginPath();ctx3.beginPath();
    ctx1.moveTo(a,b);ctx2.moveTo(a,b);ctx3.moveTo(a,b);
    ctx1.lineTo(c,d);ctx2.lineTo(c,d);ctx3.lineTo(c,d);
    ctx1.stroke();ctx2.stroke();ctx3.stroke();
}    
function assign_signs(a,b,c)
{
    ctx1.beginPath();ctx2.beginPath();ctx3.beginPath();
    ctx1.font='8px Arial';ctx2.font='8px Arial';ctx3.font='8px Arial';
    ctx1.fillText(a,b,c);ctx2.fillText(a,b,c);ctx3.fillText(a,b,c);
}
function getAscendant()
{
    var x       = document.getElementById("ascendant_sign").getAttribute('value');
    main_chart("1");
    assign_asc("1",x);
    set_planets("1");
}
function getMoon()
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
}
function get_planets(a,sign)
{
    var sign        = sign;
    var planets     = ["sun","moon","mars","mercury","jupiter","venus","saturn","rahu","ketu","uranus","neptune","pluto"];
    //alert(document.getElementById("sun_sign").getAttribute('value'));
    //var name = planets[0];
    //alert(name);
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       if(a == "3")
       {
            if(sign == document.getElementById(planets[i]+"_navamsha_sign").getAttribute('value'))
            {
                 x       = planets[i];
                 y.push(x);           
            }
        }
        else
        {
            if(sign == document.getElementById(planets[i]+"_sign").getAttribute('value'))
            {
                 x       = planets[i];
                 y.push(x);           
            }
            
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
    get_canvas();
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
function assign_planets(chart,x,a,b)
{
    if(chart == "1")
    {
        var ctx     = ctx1;
    }
    else if(chart=="2")
    {
        var ctx     = ctx2;
    }
    else if(chart=="3")
    {
        var ctx     = ctx3;
    }
    get_canvas();
    ctx.font='10px Arial';
    var y           = get_planets(chart, x);
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
            ctx.fillText(y[0],a+25,b-16);
            ctx.fillText(y[1],a-25,b-8);
            ctx.fillText(y[2],a+15,b-8);
            ctx.fillText(y[3],a,b);
            ctx.fillText(y[4],a,b+8);
            ctx.fillText(y[5],a,b+16);
        }
        if(len=="7")
        { 
            ctx.fillText(y[0],a+25,b-16);
            ctx.fillText(y[1],a-25,b-8);
            ctx.fillText(y[2],a+15,b-8);
            ctx.fillText(y[3],a,b);
            ctx.fillText(y[4],a,b+8);
            ctx.fillText(y[5],a-25,b+16);
            ctx.fillText(y[6],a+15,b+16);
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
    var name    = "Name: "+document.getElementById("fname").getAttribute('value');
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
getMoon();
getNavamsha();