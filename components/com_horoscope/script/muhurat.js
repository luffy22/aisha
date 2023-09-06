$(function() {
$("#muhurat_picker").datepicker({yearRange: "1900:2050",changeMonth: true,
  changeYear: true, dateFormat: "yy-mm-dd"});
});
{ $("#loc_form").hide(); }
function showLocationForm()
{
    $("#loc_form").show();
    $("#default_loc").hide();
}
function hideLocationForm()
{
    $("#loc_form").hide();
    $("#default_loc").show();
}
$(function() 
{

   var result       = "";
   $("#muhurat_loc").autocomplete({
      source: 
       function(request, response) {
        $.ajax({
          url: "ajaxcalls/autocomplete_loc.php",
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
            document.getElementById("muhurat_lat").value = lat;
            document.getElementById("muhurat_lon").value = lon;
            document.getElementById("muhurat_tmz").value = tmz;
        },
      open: function() {
        $('#muhurat_loc').removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         $(".ui-autocomplete").css("z-index", 1000);
      },
      close: function() {
        $('#muhurat_loc').removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
   })
   
});
