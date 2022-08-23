var c   = {};var ctx = {};
function get_canvas(canvas)
{
    c           = document.getElementById(canvas);
    ctx         = c.getContext("2d"); ctx.beginPath();
    
    // outer square
    ctx.rect(5,5,250,250);ctx.strokeStyle='black';
    ctx.lineWidth=1;ctx.stroke();
    
    // vishnu sthanas
    ctx.beginPath();ctx.rotate(45*Math.PI/180);ctx.rect(97,-87,175,175);
    ctx.strokeStyle='black';ctx.lineWidth=1;ctx.stroke();
    
    // left top to right bottom
    ctx.rotate(315*Math.PI/180);ctx.beginPath();
    ctx.moveTo(5,5);ctx.lineTo(255,255);ctx.stroke();
    
    // right top to left bottom 
    ctx.beginPath();ctx.moveTo(255,5);
    ctx.lineTo(5,255);ctx.stroke();ctx.closePath();
    
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
function getAscHouse()
{
    //alert(chart);
    var val             = ["_lagna","_navamsha_sign","_dash",
                            "_hora","_drekan","_chatur",
                            "_sapt","_dwad","_shod",
                            "_vim","_cvim","_saptvim",
                            "_trim","_khed","_aksh","_shasht"]
    for(var i=0;i<val.length;i++)
    {
        var asc         = "ascendant"+val[i];
        assignSign(asc,i); 
    }
}

function assignSign(asc,num)
{
    //alert(num);
    var x       = document.getElementById(asc).getAttribute('value');
    var y       = getSignNum(x);
    house_1(num,y);
}
function getSignNum(x)
{
    if(x == "Aries"){ y = 1;} else if(x == "Taurus"){y = 2;}
    else if(x == "Gemini"){y = 3;} else if(x == "Cancer"){y = 4;}
    else if(x == "Leo"){y = 5;} else if(x == "Virgo"){y = 6;}
    else if(x == "Libra"){y = 7;} else if(x == "Scorpio"){y = 8;}
    else if(x == "Sagittarius"){y = 9;} else if(x == "Capricorn"){y = 10;}
    else if(x == "Aquarius"){y = 11;} else if(x == "Pisces"){y = 12;} else{y=1;}
    return y;
}
// places sign number in correct block eg. 10 for Capricorn, 1 for Aries
function placeValue(a, x, y, z)
{   
    var canvas      = ["horo_canvas","nav_canvas","dash_canvas",
                        "hora_canvas","drek_canvas","chatur_canvas",
                        "sapt_canvas","dwad_canvas","shod_canvas",
                        "vim_canvas","chatvim_canvas","saptvim_canvas",
                        "trim_canvas","khed_canvas","aksh_canvas","shast_canvas"];
    c           = document.getElementById(canvas[a]);
    ctx         = c.getContext("2d"); ctx.beginPath();
    ctx.font='8px Arial';ctx.fillText(x,y,z);
    
}
function house_1(a,y)
{   var x = y;placeValue(a, x, 125, 122);var y = calc_next_value(x);house_2(a, y); }
function house_2(a, y)
{   var x = y;placeValue(a, x, 65, 62); var y = calc_next_value(x);house_3(a, y);}
function house_3(a,y)
{   var x = y;placeValue(a,x, 54, 70); var y = calc_next_value(x);house_4(a,y);}
function house_4(a,y)
{    var x = y; placeValue(a,x, 118, 132);var y = calc_next_value(x);house_5(a,y);}
function house_5(a,y)
{   var x = y;placeValue(a,x, 55, 194);var y = calc_next_value(x); house_6(a,y); }
function house_6(a,y)
{   var x = y;placeValue(a,x, 63, 202);var y = calc_next_value(x); house_7(a,y); }
function house_7(a,y)
{   var x = y;placeValue(a,x, 126, 142); var y = calc_next_value(x);house_8(a,y); }
function house_8(a,y)
{   var x = y; placeValue(a,x, 188, 202);var y = calc_next_value(x);house_9(a,y); }
function house_9(a,y)
{   var x = y; placeValue(a,x, 197, 195);var y = calc_next_value(x);house_10(a,y); }
function house_10(a,y)
{   var x = y; placeValue(a,x, 135, 132);var y = calc_next_value(x);house_11(a,y); }  
function house_11(a,y)
{   var x = y; placeValue(a,x,197, 70); var y = calc_next_value(x); house_12(a,y); }
function house_12(a,y)
{   var x = y; placeValue(a,x, 189, 62);house_1_planets(a); }
function calc_next_value(x)
{    if(x == "12"){y = 1;}else{y = x+1;}return y; }
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
    }return y;
}
function get_planets(chart,num,z)
{
    var sign        = z;
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
    var canvas      = "house_"+chart+"_canvas";
    if(y.length > 0)        // check if there are any planets in house
    {
        return y;
    }
    else
    {
        return "0";
    }
}
function house_1_planets(chart)
{
   var charts           = ["_lagna","_navamsha_sign","_dash","_hora","_drekan","_chatur",
                            "_sapt","_dwad","_shod","_vim","_cvim","_saptvim",
                            "_trim","_khed","_aksh","_shasht"];
                    
    var planets         = ["sun","moon","mars","mercury","jupiter","venus","saturn","rahu","ketu","uranus","neptune","pluto"];
    var asc             = "ascendant"+charts[chart];
    var asc_sign        = document.getElementById(asc).getAttribute('value');
    var x;var y=[];
    for(var i=0;i<planets.length; i++)
    {
       var pl           = planets[i]+charts[chart]; // planet
       var pl_sign      = document.getElementById(pl).getAttribute('value');
       if(asc_sign == pl_sign)
       {
            x       = planets[i];
            y.push(x);
       }
       
    }
    if(y.length > 0)        // check if there are any planets in house
    {
        house_cent_canvas(chart, 1, y,117,66);      // execute only if there are planets
    }
    
    var z  = get_next_sign(asc_sign);
    house_planets(chart, 2, z);y = [];
    
}
function house_planets(chart,num, z)
{
    var y           = get_planets(chart, num, z);
    if(y== "0"){}else
    {
        if(num == "2")
        {
            house_up_canvas(chart,num,y,55,35);
        }
        else if(num == "3")
        {
            house_cent_canvas(chart,num,y,7,60);
        }
        else if(num == "4")
        {
            house_cent_canvas(chart,num,y,55,130);
        }
        else if(num == "5")
        {
            house_cent_canvas(chart, num,y,7,190);
        }
        else if(num == "6")
        {
            house_down_canvas(chart, num,y,55,230);
        }
        else if(num == "7")
        {
            house_cent_canvas(chart,num,y,117,180);
        }
        else if(num == "8")
        {
            house_down_canvas(chart,num,y,180,230);
        }
        else if(num == "9")
        {
            house_right_canvas(chart,num,y,215,190);
        }
        else if(num == "10")
        {
            house_cent_canvas(chart,num,y,180,130);
        }
        else if(num == "11")
        {
            house_right_canvas(chart,num,y, 215,70);
        }
        else if(num == "12")
        {
            house_up_canvas(chart,num,y,180,35);
        }
        
    }
    if(num < 12)
    {
        var z       = get_next_sign(z);
        num         = num+1;
        house_planets(chart, num, z);
    }
}
function house_cent_canvas(chart, a, y, x, z)
{
    var canvas      = ["horo_canvas","nav_canvas","dash_canvas",
                        "hora_canvas","drek_canvas","chatur_canvas",
                        "sapt_canvas","dwad_canvas","shod_canvas",
                        "vim_canvas","chatvim_canvas","saptvim_canvas",
                        "trim_canvas","khed_canvas","aksh_canvas","shast_canvas"];
    var len         = y.length;
    c           = document.getElementById(canvas[chart]);
    ctx         = c.getContext("2d"); ctx.beginPath();
    ctx.font='10px Arial';
    if(len=="1")
    { 
        ctx.fillText(y[0],x,z);
    }
    else if(len=="2")
    {
        ctx.fillText(y[0],x,z+10);;
        ctx.fillText(y[1],x,z);
    }
    else if(len=="3")
    {
        ctx.fillText(y[0],x,z-10);
        ctx.fillText(y[1],x,z);
        ctx.fillText(y[2],x,z+10);
    }
    else if(len=="4")
    {
        ctx.fillText(y[0],x,z-10);
        ctx.fillText(y[1],x,z);
        ctx.fillText(y[2],x,z+10);
        ctx.fillText(y[3],x,z+20);
    }
    else if(len=="5")
    {
        ctx.fillText(y[0],x,z-10);
        ctx.fillText(y[1],x,z);
        ctx.fillText(y[2],x,z+10);
        ctx.fillText(y[3],x,z+20);
        ctx.fillText(y[4],x,z+30);
    }
     else if(len=="6")
    {
        ctx.fillText(y[0],x,z-20);
        ctx.fillText(y[1],x,z-10);
        ctx.fillText(y[2],x,z);
        ctx.fillText(y[3],x,z+10);
        ctx.fillText(y[4],x,z+20);
	ctx.fillText(y[5],x,z+30);
    }
    else if(len=="7")
    {
        ctx.fillText(y[0],x,z-30);
        ctx.fillText(y[1],x,z-20);
        ctx.fillText(y[2],x,z-10);
        ctx.fillText(y[3],x,z);
        ctx.fillText(y[4],x,z+10);
        ctx.fillText(y[5],x,z+20);
	ctx.fillText(y[6],x,z+30);
    }
    else if(len=="8")
    {
        ctx.fillText(y[7],x,z-40);
        ctx.fillText(y[0],x,z-30);
        ctx.fillText(y[1],x,z-20);
        ctx.fillText(y[2],x,z-10);
        ctx.fillText(y[3],x,z);
        ctx.fillText(y[4],x,z+10);
        ctx.fillText(y[5],x,z+20);
	ctx.fillText(y[6],x,z+30);
    }
    else if(len=="9")
    {
        ctx.fillText(y[7],x,z-40);
        ctx.fillText(y[0],x,z-30);
        ctx.fillText(y[1],x,z-20);
        ctx.fillText(y[2],x,z-10);
        ctx.fillText(y[3],x,z);
        ctx.fillText(y[4],x,z+10);
        ctx.fillText(y[5],x,z+20);
	ctx.fillText(y[6],x,z+30);
        ctx.fillText(y[8],x,z+40);
    }
    else if(len=="10")
    {
        ctx.fillText(y[7],x,z-40);
        ctx.fillText(y[0],x,z-30);
        ctx.fillText(y[1],x,z-20);
        ctx.fillText(y[2],x,z-10);
        ctx.fillText(y[3],x,z);
        ctx.fillText(y[4],x,z+10);
        ctx.fillText(y[5],x,z+27);
	ctx.fillText(y[6],x,z+35);
        ctx.fillText(y[8],x,z+42);
        ctx.fillText(y[9],x,z+49)
    }
}
function house_right_canvas(chart,a,y, b, c)
{
    var canvas      = ["horo_canvas","nav_canvas","dash_canvas",
                        "hora_canvas","drek_canvas","chatur_canvas",
                        "sapt_canvas","dwad_canvas","shod_canvas",
                        "vim_canvas","chatvim_canvas","saptvim_canvas",
                        "trim_canvas","khed_canvas","aksh_canvas","shast_canvas"];
    var len         = y.length;
    var can         = document.getElementById(canvas[chart]);
    ctx             = can.getContext("2d"); ctx.beginPath();
    ctx.font='10px Arial';
    if(len=="1")
    { 
        ctx.fillText(y[0],b,c);
    }
    else if(len=="2")
    {
        ctx.fillText(y[0],b,c+10);;
        ctx.fillText(y[1],b,c);
    }
    else if(len=="3")
    {
        ctx.fillText(y[0],b,c-10);
        ctx.fillText(y[1],b,c);
        ctx.fillText(y[2],b,c+10);
    }
    else if(len=="4")
    {
        ctx.fillText(y[0],b,c-10);
        ctx.fillText(y[1],b,c);
        ctx.fillText(y[2],b,c+10);
        ctx.fillText(y[3],b,c+20);
    }
    else if(len=="5")
    {
        ctx.fillText(y[0],b+12,c-30);
        ctx.fillText(y[1],b+7,c-20);
        ctx.fillText(y[2],b,c-10);
        ctx.fillText(y[3],b,c);
        ctx.fillText(y[4],b,c+10);
    }
     else if(len=="6")
    {
        ctx.fillText(y[0],b+18,c-30);
        ctx.fillText(y[1],b+10,c-20);
        ctx.fillText(y[2],b,c-10);
        ctx.fillText(y[3],b,c);
        ctx.fillText(y[4],b,c+10);
	ctx.fillText(y[5],b+4,c+20);
    }
    else if(len=="7")
    {
        ctx.fillText(y[0],b+18,c-40);
        ctx.fillText(y[1],b+10,c-30);
        ctx.fillText(y[2],b,c-20);
        ctx.fillText(y[3],b,c-10);
        ctx.fillText(y[4],b,c);
	ctx.fillText(y[5],b+4,c+10);
	ctx.fillText(y[6],b+4,c+20);
    }
    else if(len=="8")
    {
        ctx.fillText(y[0],b+18,c-40);
        ctx.fillText(y[1],b+10,c-30);
        ctx.fillText(y[2],b,c-20);
        ctx.fillText(y[3],b,c-10);
        ctx.fillText(y[4],b,c);
	ctx.fillText(y[5],b+4,c+10);
	ctx.fillText(y[6],b+4,c+20);
	ctx.fillText(y[7],b+30,c+30);
    }
    else if(len=="9")
    {
        ctx.fillText(y[7],b,c-40);
        ctx.fillText(y[0],b,c-30);
        ctx.fillText(y[1],b,c-20);
        ctx.fillText(y[2],b,c-10);
        ctx.fillText(y[3],b,c);
        ctx.fillText(y[4],b,c+10);
        ctx.fillText(y[5],b,c+20);
	ctx.fillText(y[6],b,c+30);
        ctx.fillText(y[8],b,c+40);
    }
    else if(len=="10")
    {
        ctx.fillText(y[7],b,c-40);
        ctx.fillText(y[0],b,c-30);
        ctx.fillText(y[1],b,c-20);
        ctx.fillText(y[2],b,c-10);
        ctx.fillText(y[3],b,c);
        ctx.fillText(y[4],b,c+10);
        ctx.fillText(y[5],b,c+27);
	ctx.fillText(y[6],b,c+35);
        ctx.fillText(y[8],b,c+42);
        ctx.fillText(y[9],b,c+49)
    }
}
function house_up_canvas(chart,a,y, b, c)
{
    var canvas      = ["horo_canvas","nav_canvas","dash_canvas",
                        "hora_canvas","drek_canvas","chatur_canvas",
                        "sapt_canvas","dwad_canvas","shod_canvas",
                        "vim_canvas","chatvim_canvas","saptvim_canvas",
                        "trim_canvas","khed_canvas","aksh_canvas","shast_canvas"];
    var len         = y.length;
    var can         = document.getElementById(canvas[chart]);
    ctx             = can.getContext("2d"); ctx.beginPath();
    ctx.font='10px Arial';
    if(len=="1")
    { 
        ctx.fillText(y[0],b,c);
    }
    else if(len=="2")
    {
        ctx.fillText(y[0],b,c-10);;
        ctx.fillText(y[1],b,c);
    }
    else if(len=="3")
    {
        ctx.fillText(y[0],b,c-10);
        ctx.fillText(y[1],b,c);
        ctx.fillText(y[2],b,c+10);
    }
    else if(len=="4")
    {
        ctx.fillText(y[0],b+7,c-20);
        ctx.fillText(y[1],b,c-10);
        ctx.fillText(y[2],b,c);
        ctx.fillText(y[3],b,c+10);
    }
    else if(len=="5")
    {
        ctx.fillText(y[0],b-25,c-20);
        ctx.fillText(y[1],b+20,c-20);
        ctx.fillText(y[2],b,c-10);
        ctx.fillText(y[3],b,c);
        ctx.fillText(y[4],b,c+10);
    }
     else if(len=="6")
    {
        ctx.fillText(y[0],b-25,c-20);
        ctx.fillText(y[1],b+25,c-20);
        ctx.fillText(y[2],b-20,c-10);
        ctx.fillText(y[3],b+20,c-10);
        ctx.fillText(y[4],b,c);
        ctx.fillText(y[5],b,c+10);
    }
    else if(len=="7")
    {
        ctx.fillText(y[0],b-25,c-20);
        ctx.fillText(y[1],b+25,c-20);
        ctx.fillText(y[2],b-20,c-10);
        ctx.fillText(y[3],b+20,c-10);
        ctx.fillText(y[4],b-15,c);
        ctx.fillText(y[5],b+15,c);
	ctx.fillText(y[6],b,c+10);
    }
    else if(len=="8")
    {
        ctx.fillText(y[0],b-25,c-20);
        ctx.fillText(y[1],b+25,c-20);
        ctx.fillText(y[2],b-20,c-10);
        ctx.fillText(y[3],b+20,c-10);
        ctx.fillText(y[4],b-15,c);
        ctx.fillText(y[5],b+15,c);
	ctx.fillText(y[6],b,c+10);
	ctx.fillText(y[7],b,c+20);
    }
    else if(len=="9")
    {
        ctx.fillText(y[7],b,c-40);
        ctx.fillText(y[0],b,c-30);
        ctx.fillText(y[1],b,c-20);
        ctx.fillText(y[2],b,c-10);
        ctx.fillText(y[3],b,c);
        ctx.fillText(y[4],b,c+10);
        ctx.fillText(y[5],b,c+20);
	ctx.fillText(y[6],b,c+30);
        ctx.fillText(y[8],b,c+40);
    }
    else if(len=="10")
    {
        ctx.fillText(y[7],b,c-40);
        ctx.fillText(y[0],b,c-30);
        ctx.fillText(y[1],b,c-20);
        ctx.fillText(y[2],b,c-10);
        ctx.fillText(y[3],b,c);
        ctx.fillText(y[4],b,c+10);
        ctx.fillText(y[5],b,c+27);
	ctx.fillText(y[6],b,c+35);
        ctx.fillText(y[8],b,c+42);
        ctx.fillText(y[9],b,c+49)
    }
}
function house_down_canvas(chart,a,y,b,c)
{
    var canvas      = ["horo_canvas","nav_canvas","dash_canvas",
                        "hora_canvas","drek_canvas","chatur_canvas",
                        "sapt_canvas","dwad_canvas","shod_canvas",
                        "vim_canvas","chatvim_canvas","saptvim_canvas",
                        "trim_canvas","khed_canvas","aksh_canvas","shast_canvas"];
    var len         = y.length;
    var can         = document.getElementById(canvas[chart]);
    ctx             = can.getContext("2d"); ctx.beginPath();
    ctx.font='10px Arial';
    if(len=="1")
    { 
        ctx.fillText(y[0],b,c);
    }
    else if(len=="2")
    {
        ctx.fillText(y[0],b,c-10);;
        ctx.fillText(y[1],b,c);
    }
    else if(len=="3")
    {
        ctx.fillText(y[0],b,c-10);
        ctx.fillText(y[1],b,c);
        ctx.fillText(y[2],b,c+10);
    }
    else if(len=="4")
    {
        ctx.fillText(y[0],b,c-10);
        ctx.fillText(y[1],b,c);
        ctx.fillText(y[2],b,c+10);
        ctx.fillText(y[3],b,c+20);
    }
    else if(len=="5")
    {
        ctx.fillText(y[0],b,c-10);
        ctx.fillText(y[1],b,c);
        ctx.fillText(y[2],b,c+10);
        ctx.fillText(y[3],b-25,c+20);
        ctx.fillText(y[4],b+15,c+20);
    }
     else if(len=="6")
    {
        ctx.fillText(y[0],b,c-20);
        ctx.fillText(y[1],b,c-10);
        ctx.fillText(y[2],b,c);
        ctx.fillText(y[3],b,c+10);
        ctx.fillText(y[4],b-25,c+20);
        ctx.fillText(y[5],b+15,c+20);
    }
    else if(len=="7")
    {
        ctx.fillText(y[0],b,c-20);
        ctx.fillText(y[1],b,c-10);
        ctx.fillText(y[2],b,c);
        ctx.fillText(y[3],b-25,c+10);
        ctx.fillText(y[4],b+15,c+10);
        ctx.fillText(y[5],b-25,c+20);
	ctx.fillText(y[6],b+15,c+20);
    }
    else if(len=="8")
    {
        ctx.fillText(y[0],b,c-20);
        ctx.fillText(y[1],b,c-10);
        ctx.fillText(y[2],b,c);
        ctx.fillText(y[3],b-25,c+10);
        ctx.fillText(y[4],b+15,c+10);
        ctx.fillText(y[5],b-40,c+20);
	ctx.fillText(y[6],b,c+20);
	ctx.fillText(y[7],b+45,c+20);
    }
    else if(len=="9")
    {
        ctx.fillText(y[7],b,c-40);
        ctx.fillText(y[0],b,c-30);
        ctx.fillText(y[1],b,c-20);
        ctx.fillText(y[2],b,c-10);
        ctx.fillText(y[3],b,c);
        ctx.fillText(y[4],b,c+10);
        ctx.fillText(y[5],b,c+20);
	ctx.fillText(y[6],b,c+30);
        ctx.fillText(y[8],b,c+40);
    }
    else if(len=="10")
    {
        ctx.fillText(y[7],b,c-40);
        ctx.fillText(y[0],b,c-30);
        ctx.fillText(y[1],b,c-20);
        ctx.fillText(y[2],b,c-10);
        ctx.fillText(y[3],b,c);
        ctx.fillText(y[4],b,c+10);
        ctx.fillText(y[5],b,c+27);
	ctx.fillText(y[6],b,c+35);
        ctx.fillText(y[8],b,c+42);
        ctx.fillText(y[9],b,c+49)
    }
}
getAscHouse();
/*getNavamsha();getDashamsha();getHora();getDrek();getChatur();
getShast();getSapt();getDwad();getShod();getVim();getSaptvim();
getChatvim();getTrim();getKhed();getAksh();*/