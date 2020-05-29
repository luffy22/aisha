$(function() 
{
   var result       = "";
   $("#loc_state").autocomplete({
      source: 
       function(request, response) {
        $.ajax({
          url: "ajaxcalls/autocomplete1.php",
          dataType: "json",
	  contentType: "application/json; charset=utf-8",
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
            var state           = response.item.state;
            document.getElementById("loc_state").value    = state;
      },
      open: function() {
        $('#loc_state').removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         $(".ui-autocomplete").css("z-index", 1000);
      },
      close: function() {
        $('#loc_state').removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }   
    });
});
$(function() 
{
   var result       = "";
   $("#loc_country").autocomplete({
      source: 
       function(request, response) {
        $.ajax({
          url: "ajaxcalls/autocomplete2.php",
          dataType: "json",
          contentType: "application/json; charset=utf-8",
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
            var country           = response.item.country;
            document.getElementById("loc_country").value    = country;
      },
      open: function() {
        $('#loc_country').removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         $(".ui-autocomplete").css("z-index", 1000);
      },
      close: function() {
        $('#loc_country').removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }   
    });
});
