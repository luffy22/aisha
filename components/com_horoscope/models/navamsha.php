<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelNavamsha extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $navamsha       = $jinput->get('chart', 'default_value', 'filter');
        $navamsha       = str_replace("chart","horo", $navamsha);
        
        $result         = $this->getUserData($navamsha);
        if(empty($result))
        {
            return;
        }
        else
        {
            $fname          = $result['fname'];
            $gender         = $result['gender'];
            $chart          = $result['chart_type'];
            $dob_tob        = $result['dob_tob'];

            if(array_key_exists("timezone", $result))
            {      
                $pob            = $result['pob'];
                $lat            = $result['lat'];
                $lon            = $result['lon'];
                $timezone       = $result['timezone'];
            }
            else
            {
                $lat            = $result['latitude'];
                $lon            = $result['longitude'];
                if($result['state'] == "" && $result['country'] == "")
                {
                    $pob    = $result['city'];
                }
                else if($result['state'] == "" && $result['country'] != "")
                {
                    $pob    = $result['city'].", ".$result['country'];
                }
                else
                {
                    $pob    = $result['city'].", ".$result['state'].", ".$result['country'];
                }
                $timezone   = $result['tmz_words'];
            }

            $date           = new DateTime($dob_tob, new DateTimeZone($timezone));
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
            //echo $date." ".$time;exit;
            $h_sys = 'P';
            $output = "";
            //echo $utcTimestamp;exit;
            //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';
            //exit;
            exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m789 -g, -head", $output);
            //print_r($output);exit;

            # OUTPUT ARRAY
            # Planet Name, Planet Degree, Planet Speed per day
            //$asc            = $this->getAscendant($result);
            $planets        = $this->getPlanets($output);
            $asc            = $this->getAscendant($result);
            $planets        = array_merge($asc, $planets);
            //print_r($planets);exit;
            $data           = array();
            foreach($planets as $planet=>$dist)
            {
                $dist2          = $this->convertDecimalToDegree($dist, "details");
                $sign           = $this->calcDetails($dist);
                $details        = array($planet=>$sign);
                $navamsha       = $this->getNavamsha($planet, $sign, $dist2);
                $data           = array_merge($data,$details,$navamsha);

            }
            $nav_data           = array("nav_data"=>$data, "main"=>$result);
            $nav_data               = array_merge($result, $nav_data);
            //print_r($nav_data);exit;
            return $nav_data;
        }
    }
   
    
    
}