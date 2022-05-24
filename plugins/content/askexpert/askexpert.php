<?php
defined('_JEXEC') or die;
class PlgContentAskExpert extends JPlugin
{

	function onContentAfterDisplay($context, &$article, &$params, $limitstart)
	{
            $info       = $this->getExpertInfo($context, $article, $params);
            return $info;
	}
	public function getExpertInfo($context, $article, $params)
	{
            $app                = JFactory::getApplication();
            $view               = $app->input->get('view');
            $path               = JPluginHelper::getLayoutPath('content', 'askexpert');
            $content            = "";
            include_once "/home/astroxou/php/Net/GeoIP/GeoIP.php";
            $geoip              = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoIP/GeoLiteCity.dat");
            //$ip                         = '117.196.1.11';
            //$ip                         = '157.55.39.123';  // ip address
            $ip                 = $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server
            
            //$info                       = geoip_country_code_by_name($ip);
            //$country                    = geoip_country_name_by_name($ip);
            $location           = $geoip->lookupLocation($ip);
            $info               = $location->countryCode;
            $country            = $location->countryName;
            //echo $info;exit;
            if(($context === 'com_content.article')&&($view=='article'))
            {
                $text           = $article->introtext;
                $user           = $article->created_by;
                
                $db             = JFactory::getDbo();
                $query          = $db->getQuery(true);
                $query1          = $db->getQuery(true);
                $query          ->select($db->quoteName(array('a.id','a.name','a.username','b.img_name','b.img_new_name',
                                                               'c.city','c.country','c.membership','c.info','c.profile_status','c.max_no_ques','c.phone_or_report')));
                $query          ->from($db->quoteName('#__users','a'));
                $query          ->join('RIGHT', $db->quoteName('#__user_img','b'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('b.user_id') . ')');
                $query          ->join('RIGHT', $db->quoteName('#__user_astrologer','c'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('c.UserId') . ')');
                $query          ->where($db->quoteName('a.id').' = '.$db->quote($user));
                $db             ->setQuery($query);
                $db->execute();
                $result         = $db->loadObject();
                $u_id           = $result->id;
                //echo $u_id;exit;
               $service1           = 'long';
        $service2           = 'short';
        $country_code       = array("IN","US","UK","NZ","AU","SG","CA","RU");
        if($info=='FR'||$info=='DE'||$info=='IE'||$info=='NL'||$info=='CR'||$info=='BE'
                ||$info=='GR'||$info=='IT'||$info=='PT'||$info=='ES'||$info=='MT'||$info=='LV'||$info=='TR')
        {
            $info       = "EU";
        }
        else if($info=="IN")
        {
            $info       = "IN";
        }
        else if(!in_array($info, $country_code))
        {
            $info       = "ROW";
        }

        $query1          ->select($db->quoteName(array('a.country','a.amount','a.disc_percent','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($info).' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($info));
        $db                 ->setQuery($query1);
        //print_r($result);exit;
        $country            = array("country_full"=>$country);
        $result1            = $db->loadAssocList();
        //print_r($result1);exit;
        $details            = array_merge($result1,$country);
        $fees                       = $details[1]['amount'];
        $disc                       = number_format((float)($fees*$details[1]['disc_percent'])/100,2);
        $disc_fees                  = $fees-$disc;
        //print_r($details);exit;
        $content            .=  "<div class='card border-primary mb-3'>";
        $content            .= "<div class='card-body'>";
        $content            .= "<div class='lead text-center'>Get Online Consultation</div>";
        $content            .= "<h3><a title='Click to get more info' href='#' data-toggle='modal' data-target='#astroinfo'><img src='".JURi::base()."images/profiles/".$result->img_new_name."' height='50px' width='50px' title='".$result->img_name."' />".$result->name."</a></h3>";
        $content            .= "<div class='modal fade' id='astroinfo' tabindex='-1' role='dialog' aria-hidden='true' aria-labelledby='astrolabel'>";
        $content            .= "<div class='modal-dialog' role='document'>";
        $content            .= "<div class='modal-content'>";
        $content            .= "<div class='modal-header'><h5 class='modal-title' id='astrolabel'>Expert Info</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span></button></div>";
        $content            .= "<div class='modal-body'>";
        $content            .= "<img src='".JURi::base().'images/profiles/'.$result->img_new_name."' height='50px' width='50px' title='".$result->img_name."' />".$result->name;
        $content            .= "<p>Location: ".$result->city.", ".$result->country."</p>";
        $content            .= "<p>".$result->info."</p>";
        $content            .= "</div>";
        $content            .= "<div class='modal-footer'>
                                <button type='button' class='btn btn-secondary btn-danger' data-dismiss='modal'>Close</button></div>";
        $content            .= "</div></div></div>";
        if($result->profile_status=="visible"&&$result->membership=="Paid")
        {
            $content        .= "<form name='askexpert' method='post' enctype='application/x-www-form-urlencoded' action='".JRoute::_('?option=com_astrologin&task=astroask.askExpert')."'>";
            $content        .= "<input type='hidden' value='".$result->username."' name='expert_uname' />";
            $content        .=  "<div class='form-group'>";
            $content        .= "<label for='ques_type'>Answer Type:</label> ";
            $content        .= "<div class='form-check'>";
            $content        .= "<input class='form-check-input' type='radio' id='ques_type1' name='ques_type' value='long_ans'  onchange='javascript:changefees();' />";
            $content        .= " <label class='form-check-label' for='ques_type1'>Detailed Report</label>";
            $content        .= "</div>";
            $content        .= "<div class='form-check'>";
            $content        .= "<input class='form-check-input' type='radio' id='ques_type2' name='ques_type' checked value='short_ans' onchange='javascript:changefees();' />";
             $content        .= "<label class='form-check-label' for='ques_type2'>Short Answer</label>";
            $content        .= "</div></div>";
            $content        .=  "<div class='form-group'>";
            $content        .= "<label for='max_ques'>Number Of Questions:</label> ";
            $content        .= "<select class='select2' name='expert_max_ques' id='max_ques' onchange='javascript:changefees();'>";
            for($i=1;$i<=$result->max_no_ques;$i++)
            {
                $content    .= "<option value='".$i."'>".$i."</option>";
            }
            $fees           = $details[1]['amount'];
            $disc           = $details[1]['disc_percent'];

            $content        .= "</select>";
            $content        .= "</div>";         
            $content        .= "<input type='hidden' name='long_ans_fees' id='long_ans_fees' value='".$details[0]['amount']."' />";
            $content        .= "<input type='hidden' name='short_ans_fees' id='short_ans_fees' value='".$details[1]['amount']."' />";
            $content        .= "<input type='hidden' name='ques_long_disc' id='long_ans_disc' value='".$details[0]['disc_percent']."' />";
            $content        .= "<input type='hidden' name='ques_short_disc' id='short_ans_disc' value='".$details[1]['disc_percent']."' />";
            $content        .= "<input type='hidden' name='expert_fees' id='expert_fees' value='".$details[1]['amount']."' />";
            $content        .= "<input type='hidden' name='expert_curr_code' id='expert_curr_code' value='".$details[1]['curr_code']."' />";
            $content        .= "<input type='hidden' name='expert_currency' id='expert_currency' value='".$details[1]['currency']."' />";
            $content        .= "<input type='hidden' name='expert_curr_full' id='expert_curr_full' value='".$details[1]['curr_full']."' />";
            $content        .= "<input type='hidden' name='expert_final_fees' id='expert_final_fees' value='".$disc_fees."' />";
            $content        .= "<div class='form-group'><label>Fees:</label> <div id='fees_id'>".$disc_fees."&nbsp;".$details[1]['curr_code']."(".$details[1]['currency'].'-'.$details[1]['curr_full'].')'."</div></div>";
            $content        .= "<div class='form-group'>";
            $content        .= "<label for='expert_choice' class='control-label'>Payment Type: </label>";
            if($details[0]['currency'] == 'INR')
            {
				$content            .= "<div class='form-check'>";
				$content            .= "<input class='form-check-input' type='radio' name='expert_choice' id='expert_choice1' value='razorpay' checked />";
				$content            .= "<label class='form-check-label' for='expert_choice1'><i class='fa fa-credit-card'></i> Credit/Debit Card/Netbanking</label>";
				$content            .= "</div>";
				$content            .= "<div class='form-check'>";
				$content            .= "<input class='form-check-input' type='radio' name='expert_choice' id='expert_choice4' value='paytm' />";
				$content            .= "<label class='form-check-label' for='expert_choice4'><img src='".JURi::base()."images/paytm.png' /> UPI</label>";
				$content            .= "</div>";
				 
                
            }
            else
            {
                $content            .= "<div class='form-check'>";
                $content            .= "&nbsp;<input class='form-check-input' type='radio' name='expert_choice' id='expert_choice7' value='paypal' checked />";
                $content            .= "<label class='form-check-label' for='expert_choice7'><i class='fab fa-paypal'></i> Paypal</label>";
                $content            .= "</div>";

            }
            $content                .= "</div>";
            $content                .= "<div class='form-group'><button type='submit' class='btn btn-primary' name='expert_submit'><i class='fa fa-globe'></i> Ask</button></div>";
            $content                .= "</form>";
            $content                .= "</div></div>";
        }
        return $content;
    }
    }
}
?>
<script>
function changefees()
{
    var long_ans            = document.getElementById("long_ans_fees").value;
    var short_ans           = document.getElementById("short_ans_fees").value;
    var disc_long           = document.getElementById("long_ans_disc").value;
    var disc_short          = document.getElementById("short_ans_disc").value;
    if(document.getElementById("ques_type1").checked)
    {
        var fees            = long_ans;
        var disc            = parseFloat((long_ans*disc_long)/100).toFixed(2);
        var disc_fees       = long_ans - disc;
    }
    else if(document.getElementById("ques_type2").checked)
    {
        var fees            = short_ans;
        var disc            = parseFloat((short_ans*disc_short)/100).toFixed(2);
        var disc_fees       = short_ans - disc;
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
    if(fees == disc_fees)
    {
        var new_fees        = parseFloat(fees)*parseFloat(no_of_ques);
        document.getElementById("fees_id").innerHTML    = new_fees+"&nbsp;"+curr_code+" only"
        document.getElementById("expert_final_fees").value    = new_fees.toFixed(2);
    }
    else
    {
        var fees            = parseFloat(fees)*parseFloat(no_of_ques);
        var new_fees        = parseFloat(disc_fees)*parseFloat(no_of_ques);
        document.getElementById("fees_id").innerHTML    = "<s>"+fees+"&nbsp;"+curr_code+"</s>"+"<br/>"+new_fees+"&nbsp;"+curr_code+" only"
        document.getElementById("expert_final_fees").value    = new_fees.toFixed(2);
    }
}
</script>
