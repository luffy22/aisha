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
    ctx.font='8px';
    ctx.fillText('3',197,15);
    
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText('4',197,75);
    
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText('5',197,140);
    
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText('6',197,205);
    
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText('12',7 ,15);
    
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText('11',7,75);
    
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText('10',7,140);
    
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText('9',7,205);
    
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText('2',132,15);
    
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText('7',132,205);
    
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText('1',67,15);
    
    ctx.beginPath();
    ctx.font='8px';
    ctx.fillText('8',67,205);
    
}
