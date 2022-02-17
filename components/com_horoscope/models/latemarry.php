<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelLateMarry extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $asc            = $jinput->get('chart', 'default_value', 'filter');
        $asc            = str_replace("chart","horo", $asc);
       
        $result         = $this->getUserData($asc);
        //print_r($result);exit;
        if(empty($result))
        {
            return;
        }
        else
        {
            $dob_tob        = $result['dob_tob'];
            if(array_key_exists("timezone", $result))
            {        
                $lat            = $result['lat'];
                $lon            = $result['lon'];
                $timezone       = $result['timezone'];
            }
            else
            {
                $lat            = $result['latitude'];
                $lon            = $result['longitude'];
                $timezone   = $result['tmz_words'];
            }
            //echo $timezone;exit;
            $date           = new DateTime($dob_tob, new DateTimeZone($timezone));
            //print_r($date);exit;
            $timestamp      = strtotime($date->format('Y-m-d H:i:s'));       // date & time in unix timestamp;
            $offset         = $date->format('Z');       // time difference for timezone in unix timestamp
            //echo $timestamp." ".$offset;exit;
            // $tmz            = $tmz[0].".".(($tmz[1]*100)/60); 
            /**
             * Converting birth date/time to UTC
             */
            $utcTimestamp = $timestamp - $offset;

            //echo $utcTimestamp;exit;
            //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';
            //echo $lon." ".$lat;exit;
            $date = date('d.m.Y', $utcTimestamp);
            $time = date('H:i:s', $utcTimestamp);
            //echo $date." ".$time;exit;
            $h_sys = 'P';
            $output = "";

            // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
            exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -house$lon,$lat,$h_sys -p -fPls -g, -head", $output);
            //$planets        = $this->getPlanets($output);
            $ascendant          = explode(",",$output[12]);
            print_r($output);exit;
            
            //return $all_details;
        }
    }
        public $data;
 
    public function addUser($details)
    {
        $result         = $this->addUserDetails($details, "latemarry");
        if($result)
        {
            //echo "query inserted";exit;
            $app        = JFactory::getApplication();
            $link       = JURI::base().'latemarry?chart='.str_replace("horo","chart",$result);
            $app        ->redirect($link);
        }
    
    }
}
