var c   = {};var ctx = {};
function get_canvas()
{
    c           =   document.getElementById("stage_canvas"); 
    ctx     =       c.getContext("2d"); ctx.beginPath();
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
    ctx.fillStyle = "#D3D3D3";
    ctx.fill();
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
    ctx.closePath();
}
function getAscendant()
{
    var x = document.getElementById("ascendant_sign").getAttribute('value');
    var y = getSignNum(x);
    house_1(y);
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
function placeValue(x, y, z)
{   get_canvas(); ctx.beginPath();ctx.fillStyle = "black"; ctx.font='8px Arial'; ctx.fillText(x,y,z);}
function house_1(y)
{   var x = y;placeValue(x, 125, 122);var y = calc_next_value(x);house_2(y); }
function house_2(y)
{   var x = y;placeValue(x, 65, 62); var y = calc_next_value(x);house_3(y);}
function house_3(y)
{   var x = y;placeValue(x, 54, 70); var y = calc_next_value(x);house_4(y);}
function house_4(y)
{    var x = y; placeValue(x, 118, 132);var y = calc_next_value(x);house_5(y);}
function house_5(y)
{   var x = y;placeValue(x, 55, 194);var y = calc_next_value(x); house_6(y); }
function house_6(y)
{   var x = y;placeValue(x, 63, 202);var y = calc_next_value(x); house_7(y); }
function house_7(y)
{   var x = y;placeValue(x, 126, 142); var y = calc_next_value(x);house_8(y); }
function house_8(y)
{   var x = y; placeValue(x, 188, 202);var y = calc_next_value(x);house_9(y); }
function house_9(y)
{   var x = y; placeValue(x, 197, 195);var y = calc_next_value(x);house_10(y); }
function house_10(y)
{   var x = y; placeValue(x, 135, 132);var y = calc_next_value(x);house_11(y); }  
function house_11(y)
{   var x = y; placeValue(x,197, 70); var y = calc_next_value(x); house_12(y); }
function house_12(y)
{    var x = y; placeValue(x, 189, 62);house_1_planets(); }
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
function get_planets(a,z)
{
    var sign        = z;
    var planets     = ["sun","moon","mars","mercury","jupiter","venus","saturn","rahu","ketu","uranus","neptune","pluto"];
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

    var ascendant   = document.getElementById("ascendant_sign").getAttribute('value');
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
        house_cent_canvas(1, y,117,66);      // execute only if there are planets
    }
    var z  = get_next_sign(ascendant);
    house_planets(2, z);
}
function house_planets(a, z)
{
    var num         = a;
    var y           = get_planets(num, z);
    if(y== "0"){}else
    {
        if(num == "2")
        {
            house_up_canvas(num,y,55,35);
        }
        else if(num == "3")
        {
            house_cent_canvas(num,y,7,60);
        }
        else if(num == "4")
        {
            house_cent_canvas(num,y,55,130);
        }
        else if(num == "5")
        {
            house_cent_canvas(num,y,7,190);
        }
        else if(num == "6")
        {
            house_down_canvas(num,y,55,230);
        }
        else if(num == "7")
        {
            house_cent_canvas(num,y,117,180);
        }
        else if(num == "8")
        {
            house_down_canvas(num,y,180,230);
        }
        else if(num == "9")
        {
            house_right_canvas(num,y,215,190);
        }
        else if(num == "10")
        {
            house_cent_canvas(num,y,180,130);
        }
        else if(num == "11")
        {
            house_right_canvas(num,y, 215,70);
        }
        else if(num == "12")
        {
            house_up_canvas(num,y,180,35);
        }
        
    }
    if(num < 12)
    {
        var z       = get_next_sign(z);
        num         = num+1;
        house_planets(num, z);
    }
}
function house_cent_canvas(a, y, b, c)
{
    //var y       = ["sun","moon","mars","mercury","jupiter","uranus","neptune"];
    var len     = y.length;var b = b; var c = c;
    get_canvas();ctx.font='10px Arial';
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
        ctx.fillText(y[0],b,c-10);
        ctx.fillText(y[1],b,c);
        ctx.fillText(y[2],b,c+10);
        ctx.fillText(y[3],b,c+20);
        ctx.fillText(y[4],b,c+30);
    }
     else if(len=="6")
    {
        ctx.fillText(y[0],b,c-20);
        ctx.fillText(y[1],b,c-10);
        ctx.fillText(y[2],b,c);
        ctx.fillText(y[3],b,c+10);
        ctx.fillText(y[4],b,c+20);
	ctx.fillText(y[5],b,c+30);
    }
    else if(len=="7")
    {
        ctx.fillText(y[0],b,c-30);
        ctx.fillText(y[1],b,c-20);
        ctx.fillText(y[2],b,c-10);
        ctx.fillText(y[3],b,c);
        ctx.fillText(y[4],b,c+10);
        ctx.fillText(y[5],b,c+20);
	ctx.fillText(y[6],b,c+30);
    }
    else if(len=="8")
    {
        ctx.fillText(y[7],b,c-40);
         ctx.fillText(y[0],b,c-30);
        ctx.fillText(y[1],b,c-20);
        ctx.fillText(y[2],b,c-10);
        ctx.fillText(y[3],b,c);
        ctx.fillText(y[4],b,c+10);
        ctx.fillText(y[5],b,c+20);
	ctx.fillText(y[6],b,c+30);
    }
}
function house_right_canvas(a,y, b, c)
{
    //var y       = ["sun","moon","mars","mercury","jupiter","uranus","neptune"];
    var len     = y.length;var b = b; var c = c;
    get_canvas();ctx.font='10px Arial';
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
}
function house_up_canvas(a,y, b, c)
{
    //var y       = ["sun","moon","mars","mercury","jupiter","uranus","neptune"];
    var len     = y.length;var b = b; var c = c;
    get_canvas();ctx.font='10px Arial';
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
}
function house_down_canvas(a,y,b,c)
{
    //var y       = ["sun","moon","mars","mercury","jupiter","uranus","neptune","pluto"];
    var len     = y.length;var b = b; var c = c;
    get_canvas();ctx.font='10px Arial';
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
}
