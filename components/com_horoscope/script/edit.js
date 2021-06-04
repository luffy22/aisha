$(function() {
$("#edit_dob").datepicker({yearRange: "1900:2050",changeMonth: true,
  changeYear: true, dateFormat: "yy-mm-dd"});
});

$(function() 
{
   var result       = "";
   $( "#edit_pob" ).autocomplete({
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
            document.getElementById("edit_pl_id").value  = pl_id;
           
      },
      open: function() {
        $('#edit_pob').removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         $(".ui-autocomplete").css("z-index", 1000);
      },
      close: function() {
        $('#edit_pob').removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }   
    });
});
