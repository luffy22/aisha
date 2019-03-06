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
            //include_once "/home/astroxou/php/Net/GeoIP/GeoIP.php";
            //$geoip              = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoIP/GeoLiteCity.dat");
            //$ip                         = '117.196.1.11';
            $ip                         = '157.55.39.123';  // ip address
            //$ip                 = $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server
          
            $info                       = geoip_country_code_by_name($ip);
            $country                    = geoip_country_name_by_name($ip);
            //$location           = $geoip->lookupLocation($ip);
            //$info               = $location->countryCode;
            //$country            = $location->countryName;
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
                $service1        = 'long_ans_fees';
                $service2        = 'short_ans_fees';
               
                if($info == "US")
                {
                    $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('US').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('US'));

                }
                else if($info == 'IN'||$info=='NP')
                {
                     $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('IN').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('IN'));
                }
                else if($info=='UK')
                {
                   $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('UK').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('UK'));
                }
                else if($info=='NZ')
                {
                     $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('NZ').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('NZ'));
                }
                else if($info=='CA')
                {
                    $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('CA').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('CA'));
                }
                else if($info=='SG')
                {
                    $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('SG').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('SG'));
                }
                else if($info=='AU')
                {
                    $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('AU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('AU'));
                }
                else if($info=='FR'||$info=='DE'||$info=='IE'||$info=='NL'||$info=='CR'||$info=='BE'
                        ||$info=='GR'||$info=='IT'||$info=='PT'||$info=='ES'||$info=='MT'||$info=='LV'||$info=='TR')
                {
                    $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('EU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('EU'));
                }
                else if($info =='RU')
                {
                    $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('RU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('RU'));
                }
                 else
                {
                    $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('ROW').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('ROW'));
                }
                $db                 ->setQuery($query1);
                $country            = array("country_full"=>$country);
                $result1            = $db->loadAssocList();
                //print_r($result1);exit;
                $details            = array_merge($result1,$country);
                $content            = "<div class='card border-primary mb-3'>";
                $content            .= "<div class='card-body'>";
                $content            .= "<h3><a title='Click to get more info' href='#' data-toggle='modal' data-target='#astroinfo'><img src='".JURi::base()."images/profiles/".$result->img_new_name."' height='50px' width='50px' title='".$result->img_name."' />".$result->name."</a></h3>";
                $content           .= "<div class='modal fade' id='astroinfo' tabindex='-1' role='dialog' aria-hidden='true' aria-labelledby='astrolabel'>";
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
                    $content        .= "<p class='lead'>Get Online Consultation</p>";
                    $content        .= "<form name='askexpert' method='post' enctype='application/x-www-form-urlencoded' action='".JRoute::_('?option=com_astrologin&task=astroask.askExpert')."'>";
                    $content        .= "<input type='hidden' value='".$result->username."' name='expert_uname' />";
                    $content        .=  "<div class='form-group'>";
                    $content        .= "<label for='ques_type'>Answer Type:</label> ";
                    $content        .= "<input type='radio' id='ques_type1' name='ques_type' value='long_ans'  onchange='javascript:changefees();' /> Detailed Report";
                    $content        .= "&nbsp;&nbsp;&nbsp;<input type='radio' id='ques_type2' name='ques_type' checked value='short_ans' onchange='javascript:changefees();' /> Short Answer";
                    $content        .= "</div>";
                    $content        .=  "<div class='form-group'>";
                    $content        .= "<label for='max_ques'>Number Of Questions:</label> ";
                    $content        .= "<select class='select2' name='expert_max_ques' id='max_ques' onchange='javascript:changefees();'>";
                    for($i=1;$i<=$result->max_no_ques;$i++)
                    {
                        $content    .= "<option value='".$i."'>".$i."</option>";
                    }
                    $content        .= "</select>";
                    $content        .= "</div>";         
                    $content        .= "<input type='hidden' name='long_ans_fees' id='long_ans_fees' value='".$details[0]['amount']."' />";
                    $content        .= "<input type='hidden' name='short_ans_fees' id='short_ans_fees' value='".$details[1]['amount']."' />";
                    $content        .= "<input type='hidden' name='expert_fees' id='expert_fees' value='".$details[0]['amount']."' />";
                    $content        .= "<input type='hidden' name='expert_curr_code' id='expert_curr_code' value='".$details[0]['curr_code']."' />";
                    $content        .= "<input type='hidden' name='expert_currency' id='expert_currency' value='".$details[0]['currency']."' />";
                    $content        .= "<input type='hidden' name='expert_curr_full' id='expert_curr_full' value='".$details[0]['curr_full']."' />";
                    $content        .= "<input type='hidden' name='expert_final_fees' id='expert_final_fees' value='".$details[0]['amount']."' />";
                    $content        .= "<div class='form-group'><label>Fees:</label> <div id='fees_id'>".$details[1]['amount']."&nbsp;".$details[1]['curr_code']."(".$details[1]['currency'].'-'.$details[1]['curr_full'].')'."</div></div>";
                    $content        .= "<div class='form-group'>";
                    $content        .= "<label for='expert_choice' class='control-label'>Payment Type: </label>";
                    if($details[0]['currency'] == 'INR')
                    {
                        $content            .= "&nbsp;<input type='radio' name='expert_choice' id='expert_choice1' value='ccavenue' /> <i class='fa fa-credit-card'></i> Credit/Debit Card/Netbanking
                                                <input type='radio' name='expert_choice' id='expert_choice4' value='paytm'  checked />  <img src='".JURi::base()."images/paytm.png' />";
       
                    }
                    else
                    {
                        $content            .= "&nbsp;<input type='radio' name='expert_choice' id='expert_choice7' value='paypal' checked /> <i class='fab fa-paypal'></i> Paypal";

                    }
                    $content                .= "</div>";
                    $content                .= "<div class='form-group'><button type='submit' class='btn btn-primary' name='expert_submit'><i class='fa fa-globe'></i> Ask</button></div>";
                    $content                .= "</form>";
                }
                $content            .= "</div></div>";
                return $content;
            }
	}
}
