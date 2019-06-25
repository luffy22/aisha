<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
class AstrologinModelAstroReport extends JModelItem
{
    function getData()
    {
        //include_once "/home/astroxou/php/Net/GeoIP/GeoIP.php";
        //$geoip                          = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoIP/GeoLiteCity.dat");
        $ip                           = '117.196.1.11';
        //$ip                             = '157.55.39.123';  // ip address
        //$ip                       	= $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server
        $info                         = geoip_country_code_by_name($ip);
        $country                      = geoip_country_name_by_name($ip);
        
        //$location               	= $geoip->lookupLocation($ip);
        //$info                   	= $location->countryCode;
        //$country                	= $location->countryName;
        $u_id           = '222';
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query1          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.id','a.name','a.username','b.img_name','b.img_new_name',
                                                       'c.city','c.country','c.membership','c.info','c.profile_status','c.max_no_ques','c.phone_or_report')));
        $query          ->from($db->quoteName('#__users','a'));
        $query          ->join('RIGHT', $db->quoteName('#__user_img','b'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('b.user_id') . ')');
        $query          ->join('RIGHT', $db->quoteName('#__user_astrologer','c'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('c.UserId') . ')');
        $query          ->where($db->quoteName('a.id').' = '.$db->quote($u_id));
        $db             ->setQuery($query);
        $db->execute();
        $result         = $db->loadAssoc();
        $service1       = 'yearly';
        $service2       = 'life';
        $service3       = 'career';
        $service4       = 'marriage';
        
        if($info == "US")
        {
             $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('US').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('US').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('US').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
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
                                            $db->quoteName('country').' = '.$db->quote('IN').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('IN').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
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
                                            $db->quoteName('country').' = '.$db->quote('UK').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('UK').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
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
                                            $db->quoteName('country').' = '.$db->quote('NZ').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('NZ').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
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
                            $db->quoteName('country').' = '.$db->quote('CA').' OR '.
                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                            $db->quoteName('country').' = '.$db->quote('CA').' OR '.
                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
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
                                            $db->quoteName('country').' = '.$db->quote('SG').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('SG').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('SG'));
        }
        else if($info=='AU')
        {
            $query1         ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('AU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('AU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('AU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
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
                                            $db->quoteName('country').' = '.$db->quote('EU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('EU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('EU'));
        }
        else if($info =='RU')
        {
            $query1         ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('RU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('RU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('RU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
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
                                            $db->quoteName('country').' = '.$db->quote('ROW').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('ROW').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('ROW'));
        }
        $db                 ->setQuery($query1);
        $result1            = $db->loadAssocList();
        $country            = array("country_full"=>$country);
        $details            = array_merge($result1,$country);
        $full_details       = array_merge($result,$details);
        return $full_details;
    }
}