function openNav() {
  document.getElementById("sidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("sidenav").style.width = "0";
}
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// Dropdown menu is closed & opened using this function.

$(document).ready(function()
  {
      //var id = $('.accordion-id').attr('id');
      $('#topcontent-1, #top-1, #top-2, #topcontent-2, #payments-accordion, #payments-accordion1').accordion({
            heightStyle : "content",
            collapsible : true,
        });
    });
$(document).ready(function()
  {
      //var id = $('.accordion-id').attr('id');
      $('#about-us, #paid_dash, #vimshottari, #free_dash, #dashboard_free, #ques_accordion').accordion({
            heightStyle : "content",
            collapsible : true
        });
    });

/*     
 *     var location = window.location.protocol + "//" + window.location.host;
*/
$(function() 
{
   var result       = "";
   $( "#lagna_pob" ).add("#pob_profile").autocomplete({
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
            document.getElementById("lagna_lat").value = lat;
            document.getElementById("lagna_lon").value = lon;
            var lat_dir       = lat.substring(0,1);
            var lat_deg       = lat.split(".")[0];
            var lat_min       = lat.split(".")[1].substr(0,2);
            var lon_dir       = lon.substring(0,1);
            var lon_deg       = lon.split(".")[0];
            var lon_min       = lon.split(".")[1].substr(0,2);
            document.getElementById("lagna_tmz").value = tmz;
            
            if(lon_dir == "-")
            {
                document.getElementById("lagna_long_direction").value = "W";
                document.getElementById("lagna_long_1").value = lon_deg.slice(1);
                document.getElementById("lagna_long_2").value = lon_min;
            }
            else
            {
                document.getElementById("lagna_long_direction").value = "E";
                document.getElementById("lagna_long_1").value = lon_deg;
                document.getElementById("lagna_long_2").value = lon_min;
            }
                
            if(lat_dir == "-")
            {
                document.getElementById("lagna_lat_direction").value = "S";
                document.getElementById("lagna_lat_1").value = lat_deg.slice(1);
                document.getElementById("lagna_lat_2").value = lat_min;
            }
            else
            {
                document.getElementById("lagna_lat_direction").value = "N";
                document.getElementById("lagna_lat_1").value = lat_deg;
                document.getElementById("lagna_lat_2").value = lat_min;
            }
      },
      open: function() {
        $('#lagna_pob').add("#pob_profile").add("#mdosha_pob").removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         $(".ui-autocomplete").css("z-index", 1000);
      },
      close: function() {
        $('#lagna_pob').add("#pob_profile").add("#mdosha_pob").removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }   
    });
});
 /*success: function(data) {
           
            
            alert(result);
          }*/

 $(function() {
    $( "#oppos-rashi" ).accordion({
      heightStyle: "content",
      collapsible: true
    });
  });
  
  $(document).ready(function()
  {
      var id = $('.accordion-id').attr('id');
      $('#accordion-'+id).accordion({
            heightStyle: "content",
            collapsible: true,
        });
    });
 $(document).ready(function()
  {
      var id = $('.lagna_find').attr('id');
      $('#accordion-'+id).accordion({
            heightStyle: "content",
            collapsible: true,
            active      : false
        });
    });
    
$(function() 
{

   var result       = "";
   $("#ques_pob").autocomplete({
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
     
      open: function() {
        $('#ques_pob').removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         $(".ui-autocomplete").css("z-index", 1000);
      },
      close: function() {
        $('#ques_pob').removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
   })
   
});
$(function() 
{
   var result       = "";
   $("#astro_city").autocomplete({
      source: 
       function(request, response) {
        $.ajax({
          url: "ajaxcalls/autocomplete1.php",
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
            var state           = response.item.state;
            var country         = response.item.country;
            document.getElementById("astro_state").value    = state;
            document.getElementById("astro_country").value  = country;
      },
      open: function() {
        $('#astro_city').removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         $(".ui-autocomplete").css("z-index", 1000);
      },
      close: function() {
        $('#astro_city').removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }   
    });
});
$(function() {
$("#ques_dob, #datepicker").datepicker({yearRange: "1900:2050",changeMonth: true,
  changeYear: true, dateFormat: "yy-mm-dd"});
});

function addSubscriptionFees()
{
  var newamount;
  if(document.getElementById("yearly_subscribe").checked == true)
    {
        newamount         = parseFloat(document.getElementById("pay_amount").value)+parseFloat(document.getElementById("pay_subscribe").value);
        document.getElementById("amount_label").innerHTML       = parseFloat(newamount).toFixed(2)+" "+
        document.getElementById("pay_currccode").value+" ("+document.getElementById("pay_currency").value+"-"+document.getElementById("pay_currfull").value+")";  
    }
    else
    {
        document.getElementById("amount_label").innerHTML       = document.getElementById("pay_amount").value+" "+
        document.getElementById("pay_currccode").value+" ("+document.getElementById("pay_currency").value+"-"+document.getElementById("pay_currfull").value+")"; 
   }
  
}
function changefees()
{
    var long_ans        = document.getElementById("long_ans_fees").value;
    var short_ans        = document.getElementById("short_ans_fees").value;
    if(document.getElementById("ques_type1").checked)
    {
        var fees        = long_ans;
    }
    else if(document.getElementById("ques_type2").checked)
    {
        var fees        = short_ans;
    }
    else
    {
        var fees        = document.getElementById("expert_fees").value;
    }
    var no_of_ques      = document.getElementById("max_ques").value;
    var curr_code       = document.getElementById("expert_curr_code").value;
    var currency        = document.getElementById("expert_currency").value;
    var curr_full       = document.getElementById("expert_curr_full").value;
    var new_fees        = parseFloat(fees)*parseFloat(no_of_ques);
    document.getElementById("fees_id").innerHTML    = new_fees+"<html>&nbsp;</html>"+curr_code+"("+currency+"-"+curr_full+")"
    document.getElementById("expert_final_fees").value    = new_fees.toFixed(2);
}
function changefees2()
{

    var long_ans        = document.getElementById("long_ans_fees").value;
    var short_ans        = document.getElementById("short_ans_fees").value;
    if(document.getElementById("ques_type1").checked)
    {
        var fees        = long_ans;
    }
    else if(document.getElementById("ques_type2").checked)
    {
        var fees        = short_ans;
    }
    else
    {
        var fees        = document.getElementById("expert_fees").value;
    }
    var no_of_ques      = document.getElementById("select_ques").value;
    var curr_code       = document.getElementById("expert_curr_code").value;
    var currency        = document.getElementById("expert_currency").value;
    var curr_full       = document.getElementById("expert_curr_full").value;
    var new_fees        = parseFloat(fees)*parseFloat(no_of_ques);
    document.getElementById("fees_id").innerHTML    = new_fees+"<html>&nbsp;</html>"+curr_code+"("+currency+"-"+curr_full+")"
    document.getElementById("expert_final_fees").value    = new_fees.toFixed(2);
}
function getExpertDetails(country)
{
    var expert      = document.getElementById("select_expert").value;
    var location    = country;

    $("#expert_alert").show();
    document.getElementById("expert_alert").innerHTML = "";
    document.getElementById("modal_body").innerHTML  = "";
    if(expert == "default_select")
    {
        $("#info_expert,#choose_ques,#order_type,#fees_type,#pay_id,#btn_grp").css("display", "none");
        document.getElementById("expert_alert").innerHTML   = "<span style='color:red'>Kindly Select An Expert From Options.</span>";
        setTimeout(function() {
        $("#expert_alert").hide('blind', {}, 500)
        }, 4000);
    }
    else
    {
        $("#ajax_load").css("display", "block");
        document.getElementById("select_ques").innerHTML        = "";
        document.getElementById("order_type").innerHTML         = "";
        document.getElementById("fees_id").innerHTML            = "";
        document.getElementById("payment_type").innerHTML            = "";
        document.getElementById("expert_fees").value                = "";
        document.getElementById("expert_curr_code").value           = "";
        document.getElementById("expert_currency").value            = "";
        document.getElementById("expert_curr_full").value           = "";
        document.getElementById("expert_uname").value               = "";
        document.getElementById("expert_final_fees").value          = "";
        var request = $.ajax({
            url: "ajaxcalls/getInfo.php",
            type: "POST",
            data: {expert : expert, locate: location},
            cache: false  
        });
        request.done(function(msg){
              $("#ajax_load").css("display", "none");
              $("#info_expert,#choose_ques,#order_type,#fees_type,#pay_id,#btn_grp").css("display", "block");
            var obj         = jQuery.parseJSON(msg);
            document.getElementById("expert_uname").value       = obj.uname;
            for(var i=1; i<=obj.max_no_ques;i++)
            {
                document.getElementById("select_ques").innerHTML += "<option value ='"+i+"'>"+i+"</option>";
            }
            if(obj.phone_or_report == "phone")
            {
                 document.getElementById("order_type").innerHTML       += "<label for='phone_or_report'>Order Type: </label> <i class='fa fa-phone'></i> Phone";
                 document.getElementById("order_type").innerHTML       += "<input type='hidden' name='expert_order_type' id='expert_order_type' value='phone' />";
            }
            else if(obj.phone_or_report == "report")
            {
                document.getElementById("order_type").innerHTML       += "<label for='phone_or_report'>Order Type: </label> <i class='fa fa-file-pdf-o'></i> Report";
                document.getElementById("order_type").innerHTML       += "<input type='hidden' name='expert_order_type' id='expert_order_type' value='report' />";
            }
            else if(obj.phone_or_report == "both")
            {
                document.getElementById("order_type").innerHTML        += "<label>Order Type: </label>";
                document.getElementById("order_type").innerHTML        += " <input type='radio' name='expert_order_type' id='expert_order_type' value='phone' /> <i class='fa fa-phone'></i> Phone";
                document.getElementById("order_type").innerHTML        += " <input type='radio' name='expert_order_type' id='expert_order_type' value='report' checked /> <i class='fa fa-file-pdf-o'></i> Report";
            }
            else
            {
                document.getElementById("order_type").innerHTML         += "<label for='phone_or_report'>Order Type: </label> <i class='fa fa-file-pdf-o'></i> Report";
                document.getElementById("order_type").innerHTML         += "<input type='hidden' name='expert_order_type' id='expert_order_type' value='report' />";
            }
            document.getElementById("modal_body").innerHTML             += "<img src= 'https://"+window.location.hostname+'/images/profiles/'+obj.img_new_name+"' height='50px' width='50px' title='Click To Get More Information' />"+obj.name;  
            document.getElementById("modal_body").innerHTML             += "<p>Location: "+obj.city+", "+obj.country+"</p>"
            document.getElementById("modal_body").innerHTML             += "<p>"+obj.info+"</p>";
            document.getElementById("fees_id").innerHTML                = obj.amount+"&nbsp;"+obj.curr_code+"("+obj.currency+"-"+obj.curr_full+")";
            document.getElementById("expert_fees").value                = obj.amount;
            document.getElementById("expert_curr_code").value           = obj.curr_code;
            document.getElementById("expert_currency").value            = obj.currency;
            document.getElementById("expert_curr_full").value           = obj.curr_full
            document.getElementById("expert_final_fees").value          = obj.amount;
            if(obj.currency == "INR")
            {
                document.getElementById("payment_type").innerHTML               += "<input type='radio' name='expert_choice' id='expert_choice1' value='ccavenue' checked /> <i class='fa fa-credit-card'></i> Credit/Debit Card/Netbanking";
                document.getElementById("payment_type").innerHTML               += "&nbsp;<input type='radio' name='expert_choice' id='expert_choice2' value='cheque' /> Cheque";
                document.getElementById("payment_type").innerHTML               += "&nbsp;<input type='radio' name='expert_choice' id='expert_choice3' value='direct' /> Direct Transfer";
                document.getElementById("payment_type").innerHTML               += "&nbsp;<input type='radio' name='expert_choice' id='expert_choice4' value='paytm' />  <img src= 'https://"+window.location.hostname+"/images/paytm.png' />";
                document.getElementById("payment_type").innerHTML               +=  "&nbsp;<input type='radio' name='expert_choice' id='expert_choice5' value='bhim' /> <img src= 'https://"+window.location.hostname+"/images/bhim.png' /> Bhim App";
                document.getElementById("payment_type").innerHTML               +=  "&nbsp;<input type='radio' name='expert_choice' id='expert_choice6' value='phonepe' /> <img src= 'https://"+window.location.hostname+"/images/phonepe.png' /> PhonePe";
            }
            else
            {
                document.getElementById("payment_type").innerHTML               +=  "<input type='radio' name='expert_choice' id='expert_choice7' value='paypal' checked /> <i class='fa fa-paypal'></i> Paypal";
                document.getElementById("payment_type").innerHTML               += "&nbsp;<input type='radio' name='expert_choice' id='expert_choice9' value='paypalme' /> <img src= 'https://"+window.location.hostname+"/images/paypal.png' /> PaypalMe";
                document.getElementById("payment_type").innerHTML               += "&nbsp;<input type='radio' name='expert_choice' id='expert_choice8' value='directint' /> Direct Transfer";
            }   
            
        });
        request.fail(function(jqXHR, textStatus) {
            alert( "Request failed: " + textStatus );
        });
    }
}
