<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelNakshatra extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $chart_id       = $jinput->get('chart', 'default_value', 'filter');
        $chart_id       = str_replace("chart","horo", $chart_id);
        
        
        $result         = $this->getUserData($chart_id);
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
        $nakshatra      = $details[$planet.'_nakshatra'];
        $newdata        = array_merge($newdata,$result,$this->getArticle($nakshatra, "Nakshatra"));
        return $newdata;
    }
       
    protected function getMoonData($data)
    {
        //print_r($data);exit;
        //$lagna          = $this->calculatelagna($data);
        $dob            = $data['gmt_date'];
        $tob            = explode(":",$data['gmt_time']);
        
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName('moon'));
        $query          ->from($db->quoteName('#__ephemeris'));
        $query          ->where($db->quoteName('full_year').'='.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result1        = $db->loadAssoc();
        $result1        = $this->convertPlanets($result1);
        //print_r($result1);exit;
        
        $query          ->clear();
        $query          ->select($db->quoteName('moon'));
        $query          ->from($db->quoteName('#__ephemeris'));
        $query          ->where($db->quoteName('full_year').'>'.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' asc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result2        = $db->loadAssoc();
        $result2        = $this->convertPlanets($result2);
        
        $down_deg       = explode(".",$result1['moon']);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
        $up_deg         = explode(".",$result2['moon']);

        (double)$down_deg       = ((double)$down_deg[0]*30+$down_deg[1]).".".$down_deg[2];
        (double)$up_deg         = ((double)$up_deg[0]*30+$up_deg[1]).".".$up_deg[2];
        $down_val               = explode(".",$down_deg);
        $up_val                 = explode(".", $up_deg);

        //echo $planet."  ".$up_deg." : ".$down_deg."<br/>";exit;
        if($up_deg < $down_deg)
        {
            $diff               = explode(":", $this->subDegMinSec($down_val[0], $down_val[1], 0, $up_val[0], $up_val[1], 0));
        }
        else
        {
            $diff               = explode(":", $this->subDegMinSec($up_val[0], $up_val[1], 0, $down_val[0], $down_val[1], 0));
        }
        $deg                = $diff[0];
        $min                = $diff[1];
        if($min < 10)
        {
            $min            = "0".$min;
        }

        $query          ->clear();
        $query          ->select($db->quoteName(array("value")));
        $query          ->from($db->quoteName('#__raman_log'));
        $query          ->where($db->quoteName('degree').'='.$db->quote($deg).'AND'.
                                $db->quoteName('min')."=".$db->quote($min));
        $db             ->setQuery($query);
        $result3         = $db->loadAssoc();

        $tob_deg        = $tob[0];
        $tob_min        = $tob[1];
        $query          ->clear();
        $query          ->select($db->quoteName(array("value")));
        $query          ->from($db->quoteName('#__raman_log'));
        $query          ->where($db->quoteName('degree').'='.$db->quote($tob_deg).'AND'.
                                $db->quoteName('min')."=".$db->quote($tob_min));
        $db             ->setQuery($query);
        $result4        = $db->loadAssoc();

        $value1         = $result3["value"];
        $value2         = $result4["value"];

        $result         = number_format(($value1 + $value2),4);

        $query          ->clear();
        $query          ->select($db->quoteName(array('degree','min')));
        $query          ->from($db->quoteName('#__raman_log'));
        $query          ->where($db->quoteName('value').'<='.$db->quote($result));
        $query          ->order($db->quoteName('value').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result5        = $db->loadAssoc();
        $diff           = $result5["degree"].".".$result5["min"];

        
        if($result5['min'] < 10)
        {
            $diff   = $result5['degree'].'.0'.$result5['min'];
        }
        $distance       = ($down_deg + $diff)-30.00;
        $dist           = explode(".",$distance);
        $distance       = $this->convertDegMinSec($dist[0], $dist[1], 0);
        $graha          = array('moon'=>$distance);
        $moon                = $this->getAyanamshaCorrection($dob, $graha);
        $sign           = $moon[0]['moon_nakshatra'];
        
       //$data                    = array_merge($data, $grahas);
       //return $data;
        $text           = $this->getArticle($sign,"Nakshatra");
        return $text;
    }
    
}
?>