<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelAscendant extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $asc            = $jinput->get('chart', 'default_value', 'filter');
        $asc            = str_replace("chart","horo", $asc);
       
        $result         = $this->getUserData($asc);
        //print_r($result);exit;
        
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
        //print_r($output);exit;
        $planets            = $this->calcPlanets($result);
        $asc_sign           = $this->calcDetails($ascendant[1]);
        //print_r($planets);exit;
        $asc_details        = $this->getArticle($asc_sign, $gender,$planets);
        $all_details        = array_merge($result, $planets, $asc_details);
        return $all_details;
    }
    protected function calcPlanets($result)
    {
        //print_r($result);exit;
        $libPath        = JPATH_BASE.'/sweph/';

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

        //echo $utcTimestamp;exit;
        //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';

        $date = date('d.m.Y', $utcTimestamp);
        $time = date('H:i:s', $utcTimestamp);
        //echo $date." ".$time;exit;
        $h_sys = 'P';
        $output = "";
        
        exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m789 -g, -head", $output);
        //$output         = array_unshift($output, $ascendant);
        $asc            = $this->getAscendant($result);
        $planets        = $this->getPlanets($output);
        $data           = array_merge($asc, $planets);
        foreach($data as $planet=>$dist)
        {
            $sign       = $this->calcDetails($dist);
            $details    = array($planet =>$sign);
            $data       = array_merge($data, $details);
        }
        return $data;
    }
    
    
}