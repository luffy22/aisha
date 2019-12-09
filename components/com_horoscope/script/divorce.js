$(function() {
$("#divorce_dob").datepicker({yearRange: "1900:2050",changeMonth: true,
  changeYear: true, dateFormat: "yy-mm-dd"});
});
$(function() 
{
   var result       = "";
   $( "#divorce_pob" ).autocomplete({
      source: 
       function(request, response) {
        $.ajax({
          url: "ajaxcalls/autocomplete.php",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
          response(data);
          
          }
        
        });
      },
      minLength: 3,
      select: function(request, response)
      {
            var lat           = response.item.lat;
            var lon           = response.item.lon;
            var tmz           = response.item.tmz;
            document.getElementById("divorce_lat").value = lat;
            document.getElementById("divorce_lon").value = lon;
            var lat_dir       = lat.substring(0,1);
            var lat_deg       = lat.split(".")[0];
            var lat_min       = lat.split(".")[1].substr(0,2);
            var lon_dir       = lon.substring(0,1);
            var lon_deg       = lon.split(".")[0];
            var lon_min       = lon.split(".")[1].substr(0,2);
            document.getElementById("divorce_tmz").value = tmz;
            
            if(lon_dir == "-")
            {
                document.getElementById("divorce_long_direction").value = "W";
                document.getElementById("divorce_long_1").value = lon_deg.slice(1);
                document.getElementById("divorce_long_2").value = lon_min;
            }
            else
            {
                document.getElementById("divorce_long_direction").value = "E";
                document.getElementById("divorce_long_1").value = lon_deg;
                document.getElementById("divorce_long_2").value = lon_min;
            }
                
            if(lat_dir == "-")
            {
                document.getElementById("divorce_lat_direction").value = "S";
                document.getElementById("divorce_lat_1").value = lat_deg.slice(1);
                document.getElementById("divorce_lat_2").value = lat_min;
            }
            else
            {
                document.getElementById("divorce_lat_direction").value = "N";
                document.getElementById("divorce_lat_1").value = lat_deg;
                document.getElementById("divorce_lat_2").value = lat_min;
            }
      },
      open: function() {
        $('#divorce_pob').removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         $(".ui-autocomplete").css("z-index", 1000);
      },
      close: function() {
        $('#divorce_pob').removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }   
    });
});
function callMe()
{
    //alert("calls");
    var percent     = document.getElementById("divorce_rate").value;
    var element = document.getElementById("percent_checker");
    element.classList.add("p"+percent);
    document.getElementById("percent_value").innerHTML = percent+"%";

}