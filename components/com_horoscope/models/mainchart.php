<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelMainChart extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $horo_id        = $jinput->get('chart', 'default_value', 'filter');
        $horo_id        = str_replace("chart","horo",$horo_id);
        $result         = $this->getUserData($horo_id);
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
            //echo $timezone;exit;
            $date           = new DateTime($dob_tob, new DateTimeZone($timezone));
            //echo $date->format('d-m-Y');exit;
            $timestamp      = strtotime($date->format('Y-m-d H:i:s'));       // date & time in unix timestamp;
            $offset         = $date->format('Z');       // time difference for timezone in unix timestamp
            /**
             * Converting birth date/time to UTC
             */
            $utcTimestamp = $timestamp - $offset;
            $date = date('d.m.Y', $utcTimestamp);
            $time = date('H:i:s', $utcTimestamp);
            //echo $date." ".$time;exit;
            $h_sys = 'P';
            $output = "";
            // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
            exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m789 -g, -head", $output);
            //print_r($output);exit;

            # OUTPUT ARRAY
            # Planet Name, Planet Degree, Planet Speed per day
            $asc            = $this->getAscendant($result);
            //print_r($asc);exit;
            $planets        = $this->getPlanets($output);
            $data           = array_merge($asc,$planets);
            $details        = $this->getDetails($data);
            //print_r($details);exit;
            $results         = array_merge($result, $details);
            return $results;
        }
        //var_dump($output);
    }
}