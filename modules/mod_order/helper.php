<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
require_once(JPATH_BASE.'/geoip/autoload.php');
//echo JPATH_BASE;exit;
use GeoIp2\Database\Reader;
/**
 * Helper for mod_articles_archive
 *
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 * @since       1.5
 */
class ModOrderHelper
{
    public static function showOrder()
    {
        //$geoip              = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoIP/GeoLiteCity.dat");
        $reader = new Reader('/usr/local/share/GeoIP/GeoIP2-City.mmdb');  // local file
        //$reader             = new Reader('/home3/astroxou/usr/share/GeoIP2-City.mmdb'); // server file
        $ip               = '117.196.1.11';
        //$ip                 = '157.55.39.123';  // ip address
        //$ip                 = '180.215.160.173';
        //$ip                 = $_SERVER['REMOTE_ADDR'];   // ip address. uncomment on server
        $record             = $reader->city($ip);
        $info               = $record->country->isoCode;
        $country            = $record->country->name;
        $state              = $record->mostSpecificSubdivision->name;
        $state_code         = $record->mostSpecificSubdivision->isoCode;
        $city               = $record->city->name;
        $db                 = JFactory::getDbo();
        $query1             = $db->getQuery(true);
        $u_id               = '222';
        //echo $u_id;exit;
        $service1           = 'long';
        $service2           = 'short';
        $service3           = 'life';
        $service4           = 'yearly';
        $service5           = 'career';
        $service6           = 'marriage';
        $service7           = 'finance';
        $service8           = 'education';
        if($info == "US")
        {
            $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full','a.service_for_charge','a.avail_disc','a.disc_percent','a.on_home','a.text_before','a.img_for_text')))
                            ->from($db->quoteName('#__expert_charges','a'))
                            ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                    $db->quoteName('country').' = '.$db->quote('US'));

        }
        else if($info == 'IN'||$info=='NP')
        {
            $query1         ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full','a.service_for_charge','a.avail_disc','a.disc_percent','a.on_home','a.text_before','a.img_for_text')))
                            ->from($db->quoteName('#__expert_charges','a'))
                            ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                    $db->quoteName('country').' = '.$db->quote('IN'));
        }
        else if($info=='UK')
        {
            $query1         ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full','a.service_for_charge','a.avail_disc','a.disc_percent','a.on_home','a.text_before','a.img_for_text')))
                            ->from($db->quoteName('#__expert_charges','a'))
                            ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                    $db->quoteName('country').' = '.$db->quote('UK'));
        }
        else if($info=='NZ')
        {
            $query1         ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full','a.service_for_charge','a.avail_disc','a.disc_percent','a.on_home','a.text_before','a.img_for_text')))
                            ->from($db->quoteName('#__expert_charges','a'))
                            ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                    $db->quoteName('country').' = '.$db->quote('NZ'));
        }
        else if($info=='CA')
        {
            $query1         ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full','a.service_for_charge','a.avail_disc','a.disc_percent','a.on_home','a.text_before','a.img_for_text')))
                            ->from($db->quoteName('#__expert_charges','a'))
                            ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                    $db->quoteName('country').' = '.$db->quote('CA'));
        }
        else if($info=='SG')
        {
            $query1         ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full','a.service_for_charge','a.avail_disc','a.disc_percent','a.on_home','a.text_before','a.img_for_text')))
                            ->from($db->quoteName('#__expert_charges','a'))
                            ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                    $db->quoteName('country').' = '.$db->quote('SG'));
        }
        else if($info=='AU')
        {
            $query1         ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full','a.service_for_charge','a.avail_disc','a.disc_percent','a.on_home','a.text_before','a.img_for_text')))
                            ->from($db->quoteName('#__expert_charges','a'))
                            ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                    $db->quoteName('country').' = '.$db->quote('AU'));
        }
        else if($info=='FR'||$info=='DE'||$info=='IE'||$info=='NL'||$info=='CR'||$info=='BE'
                ||$info=='GR'||$info=='IT'||$info=='PT'||$info=='ES'||$info=='MT'||$info=='LV'||$info=='TR')
        {
            $query1         ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full','a.service_for_charge','a.avail_disc','a.disc_percent','a.on_home','a.text_before','a.img_for_text')))
                            ->from($db->quoteName('#__expert_charges','a'))
                            ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                    $db->quoteName('country').' = '.$db->quote('EU'));
        }
        else if($info =='RU')
        {
            $query1         ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full','a.service_for_charge','a.avail_disc','a.disc_percent','a.on_home','a.text_before','a.img_for_text')))
                            ->from($db->quoteName('#__expert_charges','a'))
                            ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                    $db->quoteName('country').' = '.$db->quote('RU'));
        }
         else
        {
            $query1         ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full','a.service_for_charge','a.avail_disc','a.disc_percent','a.on_home','a.text_before','a.img_for_text')))
                            ->from($db->quoteName('#__expert_charges','a'))
                            ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                    $db->quoteName('country').' = '.$db->quote('ROW'));
        }
        $db                 ->setQuery($query1);
        $country            = array("country_full"=>$country);
        $result1            = $db->loadAssocList();
        return $result1;
    }
}
