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
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('navtara', 'horoscopeModel');
/**
 * Helper for mod_articles_archive
 *
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 * @since       1.5
 */
class ModNavtaraHelper extends HoroscopeModelNavtara
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
        $nakshatra      = $_POST['nakshatra'];
        $navtara        = self::getCurrNavtara($nakshatra);
        return $navtara;
        
    }
    public static function getNakshatraList()
    {
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select('DISTINCT nakshatra');
        $query          ->from($db->quoteName('#__nakshatras'));
        $db             ->setQuery($query);
        $result          = $db->loadColumn();
        $query->clear();
        return $result;
    }
    /*
     * Method to get the navtara
     * @param nakshatra The birth time nakshatra of the individual
     */
    public static function getCurrNavtara($nakshatra)
    {
        $dob_tob        = date('Y-m-d H:i:s');
        $tmz            = 'Asia/kolkata';
       
        $class          = new HoroscopeModelNavtara();
        $sign           = $class->getNavtara($dob_tob, $tmz, $nakshatra);
        return $sign;
    }
}
