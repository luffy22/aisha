$(function() {
$("#edit_dob").datepicker({yearRange: "1900:2070",changeMonth: true,
  changeYear: true, dateFormat: "yy-mm-dd"});
});

$(function() 
{
   var result       = "";
   $( "#edit_loc" ).autocomplete({
      source: 
       function(request, response) {
        $.ajax({
          url: "ajaxcalls/autocomplete3.php",
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
            var loc_id           = response.item.id;
            document.getElementById("edit_loc_id").value = loc_id;   
      },
      open: function() {
        $('#edit_loc').removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         $(".ui-autocomplete").css("z-index", 1000);
      },
      close: function() {
        $('#edit_loc').removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }   
    });
});