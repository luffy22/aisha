<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library

use Joomla\CMS\MVC\Model\ListModel;
class AstrologinModelLife extends ListModel
{
    public function getData()
    {
        //include_once "/home/astroxou/php/Net/GeoIP/GeoIP.php";
        //$geoip                          = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoIP/GeoLiteCity.dat");
        $ip                           = '117.196.1.11';
        //$ip                             = '140.120.6.207';
        //$ip                             = '157.55.39.123';  // ip address
        //$ip 							= '1.10.128.129';  // thai address
        //$ip 							= '175.157.193.156'; // srilanka ip address
        //$ip                             = $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server
        $info                         = geoip_country_code_by_name($ip);
        $country                      = geoip_country_name_by_name($ip);
        //echo $country;exit;
        //$location               	= $geoip->lookupLocation($ip);
        //$info                   	= $location->countryCode;
        //$country                	= $location->countryName;
        $u_id           = '222';
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.id','a.name','a.username','b.img_name','b.img_new_name',
                                                       'c.city','c.country','c.membership','c.info','c.profile_status','c.max_no_ques','c.phone_or_report')));
        $query          ->from($db->quoteName('#__users','a'));
        $query          ->join('RIGHT', $db->quoteName('#__user_img','b'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('b.user_id') . ')');
        $query          ->join('RIGHT', $db->quoteName('#__user_astrologer','c'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('c.UserId') . ')');
        $query          ->where($db->quoteName('a.id').' = '.$db->quote($u_id));
        $db             ->setQuery($query);
        $db->execute();
        $result         = $db->loadAssoc();
        //print_r($result);exit;
        $result1        = $this->getCurrencyDetails($info, $u_id);
        //print_r($result1);exit;        
        $country            = array("country_full"=>$country);
        
        $details            = array_merge($result1,$country);
        $full_details       = array_merge($result,$details);
        return $full_details;
    }
    public function getCurrencyDetails($info, $u_id)
    {
		
        $service			= 'life';
        $country_code       = array("IN","US","UK","NZ","AU","SG","CA","RU","TH");
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
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.country','a.amount','a.disc_percent','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($info));
        $db                 ->setQuery($query);
        $result             = $db->loadAssocList();
        return $result;
    }
  }  
?>
