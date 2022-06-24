<?php
defined('_JEXEC') or die;
class PlgContentAskExpert extends JPlugin
{

    function onContentAfterDisplay($context, &$article, &$params, $limitstart)
    {
        //$info       = $this->getExpertInfo($context, $article, $params);
        $info       = $this->getInfo();
        $view       = $this->getView();
        $data       = $this->getData($view, $article, $context);
        $query      = $this->getQueryData($info, $data);
        $path               = JPluginHelper::getLayoutPath('content', 'askexpert');
        //return $query;
        //print_r($data);exit;
        return $data;
    }
    public function getView()
    {
        $app                = JFactory::getApplication();
        $view               = $app->input->get('view');
        return $view;
    }
    public function getInfo()
    {
        //include_once "/home/astroxou/php/Net/GeoIP/GeoIP.php";
        //$geoip              = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoIP/GeoLiteCity.dat");
        $ip                         = '117.196.1.11';
        //$ip                         = '157.55.39.123';  // ip address
        //$ip                 = $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server

        $info                       = geoip_country_code_by_name($ip);
        $country                    = geoip_country_name_by_name($ip);

        //$location           = $geoip->lookupLocation($ip);
        //$info               = $location->countryCode;
        //$country            = $location->countryName;
        $country_code       = array("IN","US","UK","NZ","AU","SG","CA","RU");
        if($info=='FR'||$info=='DE'||$info=='IE'||$info=='NL'||$info=='CR'||$info=='BE'
                ||$info=='GR'||$info=='IT'||$info=='PT'||$info=='ES'||$info=='MT'||$info=='LV'||$info=='TR')
        {
            $info       = "EU";
        }
        else if($info=="IN"||$info=="NP"||$info=="LK")
        {
            $info       = "IN";
        }
        else if(!in_array($info, $country_code))
        {
            $info       = "ROW";
        }
        else
        {
            $info       = $info;
        }
        $data           = array("country"=>$country,"code"=>$info);
        return $data;
    }
    public function getData($view, $article, $context)
    {
        if(($context === 'com_content.article')&&($view=='article'))
        {
            $user           = $article->created_by;
            $db             = JFactory::getDbo();
            $query          = $db->getQuery(true);
            $query          ->select($db->quoteName(array('a.id','a.name','a.username','b.img_name','b.img_new_name',
                                                           'c.city','c.country','c.membership','c.info','c.profile_status','c.max_no_ques','c.phone_or_report')));
            $query          ->from($db->quoteName('#__users','a'));
            $query          ->join('RIGHT', $db->quoteName('#__user_img','b'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('b.user_id') . ')');
            $query          ->join('RIGHT', $db->quoteName('#__user_astrologer','c'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('c.UserId') . ')');
            $query          ->where($db->quoteName('a.id').' = '.$db->quote($user));
            $db             ->setQuery($query);
            $db->execute();
            $result         = $db->loadObject();
            //$u_id           = $result->id;
            return $result;
        }

    }
    public function getQueryData($info, $data)
    {
        //print_r($info);exit;
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $u_id           = $data->id;
        $country        = $info['country'];     // full country name. For eg. United Kingdom
        $code           = $info['code'];        // country code IN for India
        //echo $u_id;exit;
        $service1           = 'long';
        $service2           = 'short';
        
        $query              ->select($db->quoteName(array('a.country','a.amount','a.disc_percent','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($code).' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($code));
        $db                 ->setQuery($query);
        //print_r($result);exit;
        $country            = array("country_full"=>$country);
        $result             = $db->loadObjectList();
        //print_r($result1);exit;
        $details            = array_merge($result,$country);
        return $details;
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
