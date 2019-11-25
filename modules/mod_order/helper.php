<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_articles_archive
 *
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 * @since       1.5
 */
class ModOrderHelper
{
    public function showOrder()
    {
        $ip                         = '117.196.1.11';
        //$ip                         = '157.55.39.123';  // ip address
        //$ip                 = $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server

        $info                       = geoip_country_code_by_name($ip);
        $country                    = geoip_country_name_by_name($ip);
        //$location           = $geoip->lookupLocation($ip);
        //$info               = $location->countryCode;
        //$country            = $location->countryName;
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
        $result1            = $db->loadObjectList();
        return $result1;
    }
}
