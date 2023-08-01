<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('panchang', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelNavtara extends HoroscopeModelPanchang
{
    public function getNakshatras()
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
    /*
     * Method to get the difference between birth-time nakshatra
     * and current nakshatra. Later getDiff is called to get difference 
     * which will determine the current navtara
     * @param dob_tob The date and time of particular place (Y-m-d H:i:s format)
     * @param tmz The timezone of particular place (example: 'Asia/Kolkata')
     * @param birth_nak The birth time nakshatra of an individual
     */
    public function getNavtara($dob_tob, $tmz, $birth_nak)
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $date           = new DateTime($dob_tob, new DateTimeZone($tmz));
        //print_r($date);exit;
        $timestamp      = strtotime($date->format('Y-m-d H:i:s'));       // date & time in unix timestamp;
        $offset         = $date->format('Z');       // time difference for timezone in unix timestamp
            //echo $timestamp." ".$offset;exit;
            // $tmz            = $tmz[0].".".(($tmz[1]*100)/60); 
            /**
             * Converting birth date/time to UTC
             */
        $utcTimestamp = $timestamp - $offset;
         
        $date = date('d.m.Y', $utcTimestamp);
        $time = date('H:i:s', $utcTimestamp);


        $output = "";
        // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p1 -g, -head", $output);
        $data           = explode(",",$output[0]);
        $planet         = $data[0];
        $dist           = $data[1];
        $sign           = $this->calcDetails($dist);
        $dist2          = $this->convertDecimalToDegree($dist,"details");  
        $newdata        = array();
        $details        = $this->getPlanetaryDetails($planet, $sign, $dist2);
        $curr_nak       = $details[$planet.'_nakshatra'];  // current nakshatra
        return $curr_nak;
        $dist           = $this->getNakshatraDist($birth_nak, $curr_nak);
        
    }
    public function getNakshatraDist($birth_nak, $curr_nak)
    {
        $naksatras      = $this->getNakshatras();
        
    }
    
    
}
?>
