$(function() {
$("#horo_dob").datepicker({yearRange: "1900:2050",changeMonth: true,
  changeYear: true, dateFormat: "yy-mm-dd"});
});

$(function() 
{
   var result       = "";
   $( "#horo_pob" ).autocomplete({
      source: 
       function(request, response) {
        $.ajax({
          url: "ajaxcalls/autocomplete4.php",
          contentType: "application/x-www-form-urlencoded;charset=utf-8",
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
            var lat             = response.item.lat;
            var lon             = response.item.lon;
            var pl_id           = response.item.pl_id;
            document.getElementById("horo_pl_id").value  = pl_id;
            var lat_dir         = lat.substring(0,1);
            var lat_deg         = lat.split(".")[0];
            var lat_min         = lat.split(".")[1].substr(0,2);
            var lon_dir         = lon.substring(0,1);
            var lon_deg         = lon.split(".")[0];
            var lon_min         = lon.split(".")[1].substr(0,2);
            
            if(lon_dir == "-")
            {
                document.getElementById("horo_long_direction").value = "W";
                document.getElementById("horo_long_1").value = lon_deg.slice(1);
                document.getElementById("horo_long_2").value = lon_min;
            }
            else
            {
                document.getElementById("horo_long_direction").value = "E";
                document.getElementById("horo_long_1").value = lon_deg;
                document.getElementById("horo_long_2").value = lon_min;
            }
                
            if(lat_dir == "-")
            {
                document.getElementById("horo_lat_direction").value = "S";
                document.getElementById("horo_lat_1").value = lat_deg.slice(1);
                document.getElementById("horo_lat_2").value = lat_min;
            }
            else
            {
                document.getElementById("horo_lat_direction").value = "N";
                document.getElementById("horo_lat_1").value = lat_deg;
                document.getElementById("horo_lat_2").value = lat_min;
            }
      },
      open: function() {
        $('#horo_pob').removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         $(".ui-autocomplete").css("z-index", 1000);
      },
      close: function() {
        $('#horo_pob').removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }   
    });
});
