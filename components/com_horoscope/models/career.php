<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('mangaldosha', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelCareer extends HoroscopeModelMangalDosha
{
    public $data;
 
    public function addCareerDetails($details)
    {
        //print_r($details);exit;
        $fname          = $details['fname'];
        $gender         = $details['gender'];
        $dob            = $details['dob'];
        $tob            = $details['tob'];
        $pob            = $details['pob'];
        $lon            = $details['lon'];
        $lat            = $details['lat'];
        $tmz            = $details['tmz'];
        $chart          = $details['chart'];
        if($tmz == "none")
        {
            if(strpos($pob, "India") == "true"||strpos($pob,"india") == true)
            {
                $tmz     = "Asia/Kolkata";
            }
            else
            {
                $date           = new DateTime($dob." ".$tob);
                $timestamp      = $date->format('U');
                $tmz            = $this->getTimeZone($lat, $lon, "rohdes");
                if($tmz == "error")
                {
                    $tmz        = "UTC";        // if timezone not available use UTC(Universal Time Cooridnated)
                }
            }
            $newdate        = new DateTime($dob." ".$tob, new DateTimeZone($tmz));
            $dob_tob        = $newdate->format('Y-m-d H:i:s');
        }
        else
        {
            $date       = new DateTime($dob." ".$tob, new DateTimeZone($tmz));
            $dob_tob    = $date->format('Y-m-d H:i:s');
        }
        $uniq_id        = uniqid('horo_');
        
        $now            = date('Y-m-d H:i:s');
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $columns        = array('uniq_id','fname','gender','chart_type','dob_tob','pob','lon','lat','timezone','query_date','query_cause');
        $values         = array($db->quote($uniq_id),$db->quote($fname),$db->quote($gender),$db->quote($chart),$db->quote($dob_tob),
                                $db->quote($pob),$db->quote($lon),$db->quote($lat),$db->quote($tmz),$db->quote($now),$db->quote('careerfind'));
        $query          ->insert($db->quoteName('#__horo_query'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
        $db             ->setQuery($query);
        $result          = $db->query();
        if($result)
        {
            //echo "query inserted";exit;
            $app        = JFactory::getApplication();
            $link       = JURI::base().'careerfind?chart='.str_replace("horo","chart",$uniq_id);
            $app        ->redirect($link);
        }
    }
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $chart_id       = $jinput->get('chart', 'default_value', 'filter');
        $chart_id       = str_replace("chart","horo", $chart_id);
        $array          = array();
        $user_data      = $this->getUserData($chart_id);
        //print_r($user_data);exit;
        $fname          = $user_data['fname'];
        $gender         = $user_data['gender'];
        $dob_tob        = $user_data['dob_tob'];
        $pob            = $user_data['pob'];
        $lat            = $user_data['lat'];
        $lon            = $user_data['lon'];
        $timezone       = $user_data['timezone'];
        
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
        //print_r($output);exit;

        # OUTPUT ARRAY
        # Planet Name, Planet Degree, Planet Speed per day
        $asc                        = $this->getAscendant($user_data);
        $planets                    = $this->getPlanets($output);
        $data                       = array_merge($asc,$planets);
        $tenth_house                = $this->checkPlanetsInHouse($data, 10);
        $tenth_asp                  = $this->checkAspectsOnHouse($data, 10);
        $asc_sign                   = strtolower($this->calcDetails($data["Ascendant"]))."-asc";
        $tenth_sign                 = $this->getHouseSign($asc_sign, 10);
        $career_sign                = $this->checkCareerViaTenthSign($asc_sign); // check career via 10th sign of an ascendant
        $career_planets             = $this->checkCareerViaPlanets($tenth_house);  // check career via planets in 10th house
        $array                      = array_merge($array, $user_data, $career_sign,$career_planets);
        
        return $array;
    }
    protected function checkCareerViaTenthSign($sign)
    {
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $asc            = ucfirst(str_replace("-asc","",$sign));
        $query          ->select($db->quoteName('career_text'));
        $query          ->from($db->quoteName('#__career_finder'));
        $query          ->where($db->quoteName('asc_planet').'='.$db->quote($sign));
        $db             ->setQuery($query);
        $result         = $db->loadAssoc();
        $data           = array("asc"=>$asc, "10th_sign" => $result['career_text']);
        return $data;
    }
    protected function checkCareerViaPlanets($house)
    {
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $house_10       = $house['house_10'];
        $count          = array("house_count"=>count($house_10));
        $array          = array();
        $array          = array_merge($array, $count);
        $i              = 0;
        foreach($house_10 as $planet)
        {
            if(trim($planet) == "Pluto" || trim($planet) == "Uranus" || trim($planet) == "Neptune")
            {
               continue;
            }
            else
            {
                $query          ->select($db->quoteName('career_text'));
                $query          ->from($db->quoteName('#__career_finder'));
                $query          ->where($db->quoteName('asc_planet').'='.$db->quote($planet));
                $db             ->setQuery($query);
                $result         = $db->loadAssoc();
                $data           = array("planet_".$i=>$planet,$planet."_result" => $result['career_text']);
                $array          = array_merge($array, $data);$i++;
                $query          ->clear();
            }
        }
        return $array;
    }
    protected function checkAscendant($asc)
    {
        $sign                   = $this->calcDetails($asc);
        $array                  = array("asc_sign" => $sign);
        return $array;
    }
    
    
}
?>
