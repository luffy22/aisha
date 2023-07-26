function openNav() {
  document.getElementById("sidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("sidenav").style.width = "0";
}
function changeText()
{
	//var txt 		= "Yay... Change text works.";
	//document.getElementById("demo").innerHTML = txt;
	 $.ajax({
          url: 'index.php?option=com_ajax&module=navtara&method=getIP&format=raw',
          type: "post",
          success: function(data) {
          document.getElementById("demo").innerHTML = data;
          
          }
        
        });
      
}
