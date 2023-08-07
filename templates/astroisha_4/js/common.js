function openNav() {
  document.getElementById("sidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("sidenav").style.width = "0";
}
function getIPLocation()
{
    //var txt 		= "Yay... Change text works.";
    //document.getElementById("demo").innerHTML = txt;
     $.ajax({
            url: 'index.php?option=com_ajax&module=navtara&method=getIP&format=raw',
            type: "post",
            success: function(data) {
            document.getElementById("navtara").innerHTML = data;
      }

    });
      
}
function getForecast()
{
    var nakshatra   = document.getElementById("nakshatra_sel").value;

    $.ajax({
            url: 'index.php?option=com_ajax&module=navtara&method=getForecast&format=raw',
            type: "post",
            data: {'nakshatra': nakshatra},
            success: function(data) {
            const obj = JSON.parse(data);
            document.getElementById("navtara_form").style.display = 'none';
            $('#navtara_form').hide();
            document.getElementById("birth_nak").innerHTML = "<strong>Birth Time Nakshatra</strong>: "+ obj.birth_nak;
            document.getElementById("curr_nak").innerHTML = "<strong>Current Nakshatra Transit: </strong>"+obj.curr_nak;
            document.getElementById("demo").innerHTML = obj.description;
        }
    });
}
