<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelMuhurat extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;        
        $date           = date('Y-m-d');
        $location       = $jinput->get('location', 'default_value', 'filter');
        $location       = explode("_",$location);
        $timezone       = "Asia/Kolkata";
        //$sun_times      = $this->getSunTimings($date, $timezone);
        //print_r($sun_times);exit;
        $moon_times     = $this->getMoonTimings($date,$timezone);
        //print_r($moon_times);exit;
        
    }
    public function getSunTimings($date, $timezone)
    {
        $dtz            = new DateTimeZone($timezone); //Your timezone
        $date           = new DateTime($date, $dtz);
        $date->sub(new DateInterval('P1D'));
        //echo $date->format('d.m.Y H:i:s');exit;        
       
        $date           = $date->format('d.m.Y');
        $lon            = "72.57";
        $lat            = "23.02";
        //$date = date('d.m.Y', $utcTimestamp);
        //$time = date('H:i:s', $utcTimestamp);
        
        $h_sys = 'P';
        $output = "";
        //echo $utcTimestamp;exit;
        //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';
        exec ("swetest -b$date -geopos$lon,$lat,0 -rise -hindu -p0 -n12 -head", $output);
        $timings        = $output;$i = 0;
        $sun            = array();
        foreach($timings as $result)
        {
            if($i == 0){$i++;continue;}
            else{
                    
                $result      = $this->convertToLocal("sun",$i, $result, $timezone);
                $sun         = array_merge($sun, $result);$i++;
            }
            
        }
        print_r($sun);exit;
        //$result             = $this->convertToLocal($sun,str_replace(".","-",$date), $timezone);
        
    }
    public function getMoonTimings($date, $timezone)
    {
        $dtz            = new DateTimeZone($timezone); //Your timezone
        $date           = new DateTime($date, $dtz);
        $date->sub(new DateInterval('P1D'));
        //echo $date->format('d.m.Y H:i:s');exit;        
       
        $date           = $date->format('d.m.Y');
        $lon            = "72.57";
        $lat            = "23.02";
        //$date = date('d.m.Y', $utcTimestamp);
        //$time = date('H:i:s', $utcTimestamp);
        
        $h_sys = 'P';
        $output = "";
        //echo $utcTimestamp;exit;
        //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';
        exec ("swetest -b$date -geopos$lon,$lat,0 -rise -hindu -p1 -n12 -head", $output);
        //print_r($output);exit;
        $timings        = $output;$i = 0;
        $moon           = array();
        foreach($timings as $result)
        {
            if($i == 0){$i++;continue;}
            else{
               $result      = $this->convertToLocal("moon",$i, $result, $timezone);
                $moon         = array_merge($moon, $result);$i++;
            } 
        }
        print_r($moon);exit;
    }
    public function convertToLocal($planet,$num, $times, $timezone)
    {
        date_default_timezone_set('UTC');
        $split              = explode("rise",$times);
        $split              = explode("set",$split[1]);
        $rise               = str_replace(".","-",$split[0]);$set            = str_replace(".","-",$split[1]);
        $rise               = str_replace(' ','',$rise);$set             = str_replace(' ','',$set);
        $rise               = substr(trim($rise),0,-2);$set             = substr(trim($set),0,-2);
        //echo $rise." ".$set;exit;
        $timezone           = new DateTimeZone($timezone);
        $date               = new DateTime($rise);
        $date1              = new DateTime($set);
        $date               ->setTimezone($timezone);
        $date1              ->setTimezone($timezone);
        $array              = array($planet."_rise_".$num=>$date->format('d-m-Y H:i:s'),$planet."_set_date_".$num=>$date1->format('d-m-Y H:i:s'));
        return $array;
    }
}