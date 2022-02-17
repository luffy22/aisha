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
        $result         = $this->addUserDetails($details, "careerfind");
        if(!empty($result))
        {
            //echo "query inserted";exit;
            $app        = JFactory::getApplication();
            $link       = JURI::base().'careerfind?chart='.str_replace("horo","chart",$result);
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
        if(empty($user_data))
        {
            return;
        }
        else
        {
            $fname          = $user_data['fname'];
            $gender         = $user_data['gender'];
            $chart          = $user_data['chart_type'];
            $dob_tob        = $user_data['dob_tob'];

            if(array_key_exists("timezone", $user_data))
            {    

                $timezone       = $user_data['timezone'];
            }
            else
            {
                $timezone   = $user_data['tmz_words'];
            }

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
            $asc_sign1                  = $this->calcDetails($data["Ascendant"]);
            $tenth_sign                 = $this->getHouseSign($asc_sign1, 10);
            $career_sign                = $this->checkCareerViaTenthSign($asc_sign); // check career via 10th sign of an ascendant
            $career_planets             = $this->checkCareerViaPlanets($tenth_house);  // check career via planets in 10th house
            $array                      = array_merge($array, $user_data, $career_sign,$career_planets);
            //print_r($array);exit;
            return $array;
        }
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
