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
    public static function getLocation()
    {
		
        if(!isset($_COOKIE["location"]) && !isset($_COOKIE["lat"]) &&
           !isset($_COOKIE["lon"]) && !isset($_COOKIE["tmz"])) {
			   //echo "calls1";exit;
            $loc            = "Ujjain, India";
            $tmz       		= "Asia/Kolkata";
            $lon            = "75.78";  $lat            = "23.17";  $alt    = 0;
        } else {
			//echo "calls2";exit;
           $loc         = $_COOKIE["location"];
           $lat         = $_COOKIE["lat"];
           $lon         = $_COOKIE["lon"];
           $tmz    		= $_COOKIE["tmz"];
           if($tmz == ""|| $tmz == "none")
           {
			   $tmz 	= "UTC";
		   }
           $alt         = 0;
        }
        $location 		= array("loc"=>$loc,"lat" => $lat, "lon"=>$lon,
								"tmz"=>$tmz,"alt"=>$alt);
		return $location;
        
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
        $loc				= self::getLocation();
        $dob_tob        = date('Y-m-d H:i:s');
        $lat            = $loc['lat'];
        $lon            = $loc['lon'];
        $tmz            = $loc['tmz'];
		
        $class          = new HoroscopeModelNavtara();
        $sign           = $class->getNavtara($dob_tob,$lat, $lon,$tmz, $nakshatra);
        return $sign;
    }
}
