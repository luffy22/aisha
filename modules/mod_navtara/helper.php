<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

//defined('_JEXEC') or die;
require_once(JPATH_BASE.'/geoip/autoload.php');
//echo JPATH_BASE;exit;
use GeoIp2\Database\Reader;
use Joomla\CMS\MVC\Model\ListModel;

/**
 * Helper for mod_articles_archive
 *
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 * @since       1.5
 */
class ModNavtaraHelper extends HoroscopeModelNakshatra
{
    public static function getIPAjax()
    {
		
        $reader = new Reader('/usr/local/share/GeoIP/GeoIP2-City.mmdb');  // local file
        //$reader             = new Reader('/home3/astroxou/usr/share/GeoIP2-City.mmdb'); // server file
        //$ip               = '117.196.1.11';
        $ip                 = '157.55.39.123';  // ip address
        //$ip                 = '180.215.160.173';
        //$ip                 = $_SERVER['REMOTE_ADDR'];   // ip address. uncomment on server
        $record             = $reader->city($ip);
        $info               = $record->country->isoCode;
        $country            = $record->country->name;
        $state              = $record->mostSpecificSubdivision->name;
        $state_code         = $record->mostSpecificSubdivision->isoCode;
        $city               = $record->city->name;
        return $city." ".$state." ".$country;
    }
    public static function getForecastAjax()
    {
        $nakshatras     = self::getNakshatra();
        $nakshatra      = $_POST['nakshatra'];
        $key            = array_search($nakshatra, $nakshatras);
        
    }
    public static function getNakshatra()
    {
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select('DISTINCT nakshatra');
        $query          ->from($db->quoteName('#__nakshatras'));
        $db             ->setQuery($query);
        $result          = $db->loadColumn();
        return $result;
        //$query          ->clear;
    }
    public static function getCurrentNakshatra()
    {
        ///$current        = $this->get
        /*$libPath        = JPATH_BASE.'/sweph/';
        $dob_tob        = date('Y-m-d H:i:s');
        $timezone       = 'Asia/kolkata';
        $date           = new DateTime($dob_tob, new DateTimeZone($timezone));
        //print_r($date);exit;
        $timestamp      = strtotime($date->format('Y-m-d H:i:s'));       // date & time in unix timestamp;
        $offset         = $date->format('Z');       // time difference for timezone in unix timestamp
        //echo $timestamp." ".$offset;exit;
        // $tmz            = $tmz[0].".".(($tmz[1]*100)/60); 
        /**
         * Converting birth date/time to UTC
         */
        //$utcTimestamp = $timestamp - $offset;

        //echo $utcTimestamp;exit;
        //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';

        /*$date = date('d.m.Y', $utcTimestamp);
        $time = date('H:i:s', $utcTimestamp);
        //echo $date." ".$time;exit;
        $h_sys = 'P';
        $output = "";

        exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p1 -g, -head", $output);
        
        print_r($output);exit;*/
    }
}
