<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('mangaldosha', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelArrangeLove extends HoroscopeModelLagna
{
    public $data;
 
    public function addUserDetails($details)
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
                                $db->quote($pob),$db->quote($lon),$db->quote($lat),$db->quote($tmz),$db->quote($now),$db->quote('lovemarry'));
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
            $link       = JURI::base().'lovemarry?chart='.str_replace("horo","chart",$uniq_id);
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
                $pob            = $user_data['pob'];
                $lat            = $user_data['lat'];
                $lon            = $user_data['lon'];
                $timezone       = $user_data['timezone'];
            }
            else
            {
                $lat            = $user_data['latitude'];
                $lon            = $user_data['longitude'];
                if($user_data['state'] == "" && $user_data['country'] == "")
                {
                    $pob    = $user_data['city'];
                }
                else if($user_data['state'] == "" && $user_data['country'] != "")
                {
                    $pob    = $user_data['city'].", ".$user_data['country'];
                }
                else
                {
                    $pob    = $user_data['city'].", ".$user_data['state'].", ".$user_data['country'];
                }
                $timezone   = $user_data['tmz_words'];
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
            //print_r($output);exit;

            # OUTPUT ARRAY
            # Planet Name, Planet Degree, Planet Speed per day
            $asc                        = $this->getAscendant($user_data);
            $planets                    = $this->getPlanets($output);
            $data                       = array_merge($asc,$planets);
            $checkLoveArranged          = $this->checkLoveOrArranged($data);
            $love                       = array_merge($user_data,$checkLoveArranged);
            return $love;
        }
    }
    protected function checkLoveOrArranged($data)
    {
        $own_sign                   = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $asc                        = $this->calcDetails($data['Ascendant']);
        $asc_lord                   = $own_sign[$asc];
        $fifth                      = $this->getHouseSign($asc, 5);
        $fifth_lord                 = $own_sign[$fifth];
        $seventh                    = $this->getHouseSign($asc, 7);
        $seventh_lord               = $own_sign[$seventh];
        $moon                       = $this->calcDetails($data['Moon']);
        $moon_house                 = $this->getHouseDistance($asc, $moon);
        $mars                       = $this->calcDetails($data['Mars']);
        $mars_house                 = $this->getHouseDistance($asc, $mars);
        $venus                      = $this->calcDetails($data['Venus']);
        $venus_house                = $this->getHouseDistance($asc, $venus);
        $venus_7                    = $this->getHouseSign($venus, 7);
        $rahu                       = $this->calcDetails($data['Rahu']);
        $rahu_house                 = $this->getHouseDistance($asc, $rahu);
        $fifth_lord_loc             = $this->calcDetails($data[$fifth_lord]);
        $seventh_lord_loc           = $this->calcDetails($data[$seventh_lord]);
        $asc_lord_loc               = $this->calcDetails($data[$asc_lord]);
        $fifth_lord_house           = $this->getHouseDistance($asc, $fifth_lord_loc);
        $seventh_lord_house         = $this->getHouseDistance($asc, $seventh_lord_loc);
        $asc_lord_house             = $this->getHouseDistance($asc, $asc_lord_loc);
        $fifth_aspect               = $this->checkAspectsOnHouse($data, $fifth_lord_house);
        $seventh_aspect             = $this->checkAspectsOnHouse($data, $seventh_lord_house);
        $asc_aspect                 = $this->checkAspectsOnHouse($data, $asc_lord_house);
        $fifth_aspect               = $fifth_aspect["aspect_".$fifth_lord_house];
        $seventh_aspect             = $seventh_aspect["aspect_".$seventh_lord_house];
        $asc_aspect                 = $asc_aspect["aspect_".$asc_lord_house];
        
        //echo $venus_7." ".$mars." ".$rahu;exit;
        $array                      = array();
        if($mars == $venus)
        {
            $mars_ven               = array("mars_ven" => "yes");
            $array                  = array_merge($array, $mars_ven);
        }
        else 
        {
            $mars_ven               = array("mars_ven" => "no");
            $array                  = array_merge($array, $mars_ven);
        }
        if($venus_7 == $mars)
        {
            $mars_ven_7             = array("mars_ven_7"    => "yes");
            $array                  = array_merge($array, $mars_ven_7);
        }
        else
        {
            $mars_ven_7             = array("mars_ven_7"    => "no");
            $array                  = array_merge($array, $mars_ven_7);
        }
         if($moon == $venus)
        {
            $moon_ven               = array("moon_ven" => "yes");
            $array                  = array_merge($array, $moon_ven);
        }
        else 
        {
            $moon_ven               = array("moon_ven" => "no");
            $array                  = array_merge($array, $moon_ven);
        }
        if($venus_7 == $moon)
        {
            $moon_ven_7             = array("moon_ven_7"    => "yes");
            $array                  = array_merge($array, $moon_ven_7);
        }
        else
        {
            $moon_ven_7             = array("moon_ven_7"    => "no");
            $array                  = array_merge($array, $moon_ven_7);
        }
        if($venus == $rahu)
        {
            $ven_rahu               = array("ven_rahu" => "yes");
            $array                  = array_merge($array, $ven_rahu);
        }
        else
        {
            $ven_rahu               = array("ven_rahu" => "no");
            $array                  = array_merge($array, $ven_rahu);
        }
        if($venus_7 == $rahu)
        {
            $rahu_ven_7             = array("rahu_ven_7"    => "yes");
            $array                  = array_merge($array, $rahu_ven_7);
        }
        else
        {
            $rahu_ven_7             = array("rahu_ven_7"    => "no");
            $array                  = array_merge($array, $rahu_ven_7);
        }
        if($fifth_lord_loc == $seventh_lord_loc)
        {
            $five_sev               = array("five_sev" => "yes");
            $array                  = array_merge($array, $five_sev);
        }
        else
        {
            $five_sev               = array("five_sev" => "no");
            $array                  = array_merge($array, $five_sev);
        }
        if($fifth_lord_house == "7" && $seventh_lord_house == "5")
        {
            $fifth_seventh        = array("fifth_seventh_exc" => "yes");
            $array                  = array_merge($array, $fifth_seventh);
        } 
        else
        {
            $fifth_seventh        = array("fifth_seventh_exc" => "no");
            $array                  = array_merge($array, $fifth_seventh);
        }
        if((in_array($seventh_lord, $fifth_aspect)) && (in_array($fifth_lord, $seventh_aspect)))
        {
            $fifth_seven_asp        = array("fifth_seventh_asp" => "yes");
            $array                  = array_merge($array, $fifth_seven_asp);
        } 
        else
        {
            $fifth_seven_asp        = array("fifth_seventh_asp" => "no");
            $array                  = array_merge($array, $fifth_seven_asp);
        }
        if($asc_lord_loc == $seventh_lord_loc)
        {
            $asc_sev                = array("asc_sev" => "yes");
            $array                  = array_merge($array, $asc_sev);
        }
        else
        {
            $asc_sev                = array("asc_sev" => "no");
            $array                  = array_merge($array, $asc_sev);
        }
        if($asc_lord_house == "7" && $seventh_lord_house == "1")
        {
            $asc_seventh        = array("asc_seventh_exc" => "yes");
            $array                  = array_merge($array, $asc_seventh);
        } 
        else
        {
            $asc_seventh        = array("asc_seventh_exc" => "no");
            $array                  = array_merge($array, $asc_seventh);
        }
        if((in_array($asc_lord, $seventh_aspect)) && (in_array($seventh_lord, $asc_aspect)))
        {
            $asc_seven_asp        = array("asc_seventh_asp" => "yes");
            $array                  = array_merge($array, $asc_seven_asp);
        } 
        else
        {
            $asc_seven_asp        = array("asc_seventh_asp" => "no");
            $array                  = array_merge($array, $asc_seven_asp);
        }
        return $array;
    }
}