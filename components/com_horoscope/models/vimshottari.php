<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelVimshottari extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $navamsha       = $jinput->get('chart', 'default_value', 'filter');
        $navamsha       = str_replace("chart","horo", $navamsha);
        
        $result         = $this->getUserData($navamsha);
        
        $fname          = $result['fname'];
        $gender         = $result['gender'];
        $dob_tob        = $result['dob_tob'];
        $pob            = $result['pob'];
        $lat            = $result['lat'];
        $lon            = $result['lon'];
        $timezone       = $result['timezone'];
        
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

        exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m789 -g, -head", $output);
        //print_r($output);exit;

        # OUTPUT ARRAY
        # Planet Name, Planet Degree, Planet Speed per day
        //$asc            = $this->getAscendant($result);
        $planets        = $this->getPlanets($output);
        $data           = array();
        foreach($planets as $planet=>$dist)
        {
            $dist2          = $this->convertDecimalToDegree($dist, "details");
            $sign           = $this->calcDetails($dist);
            $dist           = array($planet."_dist"=>$dist2);
            $details        = array($planet=>$sign);
            $data           = array_merge($data, $dist, $details);
        }
        //print_r($data);exit;
        $moon_sign          = $data['Moon'];                  
        $moon_dist          = $data['Moon_dist'];
        $moon_nakshatra     = $this->getNakshatra($moon_sign, $moon_dist);
        $nakshatra_deg      = $this->getNakshatraDeg($moon_sign, $moon_nakshatra);
        
    }
    protected function getNakshatra($moon_sign, $moon_dist)
    {
        //echo $moon_sign."&nbsp;".$moon_dist;exit;
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName('nakshatra'));
        $query          ->from($db->quoteName('#__nakshatras'));
        $query          ->where($db->quoteName('sign').'='.$db->quote($moon_sign).' AND '.
                                $db->quote($moon_dist).' BETWEEN '.
                                $db->quoteName('down_deg').' AND '.
                                $db->quoteName('up_deg'));
        $db             ->setQuery($query);
        $result         = $db->loadAssoc();
        return $result['nakshatra'];
        
    }
    protected function getNakshatraDeg($sign, $nakshatra)
    {
        //echo $moon_sign."&nbsp;".$moon_dist;exit;
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName(array('sign','down_deg','up_deg')));
        $query              ->from($db->quoteName('#__nakshatras'));
        $query              ->where($db->quoteName('nakshatra').'='.$db->quote($nakshatra));
        $db                 ->setQuery($query);
        $result             = $db->loadAssocList();
        $count              = count($result);
        print_r($count);exit;
        
        
        
    }
}