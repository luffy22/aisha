<?php
require_once(JPATH_BASE.'/geoip/autoload.php');
//echo JPATH_BASE;exit;
use GeoIp2\Database\Reader;
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('panchang', 'horoscopeModel');
class modTithiHelper extends HoroscopeModelPanchang
{
    /**
     * Retrieves the hello message
     *
     * @param array $params An object containing the module parameters
     * @access public
     */    
    public static function getLocation()
    {
        if(!isset($_COOKIE["location"]) && !isset($_COOKIE["lat"]) &&
           !isset($_COOKIE["lon"]) && !isset($_COOKIE["tmz"])) 
        {
			   //echo "calls1";exit;
            $loc            = "Ujjain, India";
            $tmz            = "Asia/Kolkata";
            $lon            = "75.78";  $lat            = "23.17";  $alt    = 0;
        } 
        else 
        {
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
   /* public static function getForecastAjax()
    {
        $tithi        = self::getCurrTithi();
        return $tithi;
        
    }*/
    public static function getTithiCurr()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        putenv("PATH=$libPath");
        $h_sys = 'P';
        $output = "";
        
        $loc            = self::getLocation();
        $date_time      = date('Y-m-d H:i:s');
        $lat            = $loc['lat'];
        $lon            = $loc['lon'];
        $tmz            = $loc['tmz'];
		
        $class          = new HoroscopeModelPanchang();
        $tithi          = $class->getCurrTithi($date_time,$lat,$lon,$tmz);
        print_r($tithi);exit;
    }
}

?>
