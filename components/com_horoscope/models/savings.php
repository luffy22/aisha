<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('mangaldosha', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelSavings extends HoroscopeModelLagna
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
                                $db->quote($pob),$db->quote($lon),$db->quote($lat),$db->quote($tmz),$db->quote($now),$db->quote('savings'));
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
            $link       = JURI::base().'investwhere?chart='.str_replace("horo","chart",$uniq_id);
            $app        ->redirect($link);
        }
    }
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $iinput         = JFactory::getApplication()->input;
        $chart_id       = $iinput->get('chart', 'default_value', 'filter');
        $chart_id       = str_replace("chart","horo", $chart_id);
        $array          = array();
        $user_data      = $this->getUserData($chart_id);
        
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
 
        exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m -g, -head", $output);
        //print_r($output);exit;

        # OUTPUT ARRAY
        # Planet Name, Planet Degree, Planet Speed per day
        $asc                        = $this->getAscendant($user_data);
        $planets                    = $this->getPlanets($output);
        $planets                    = array_merge($asc,$planets);
        $asc_sign                   = $this->calcDetails($planets['Ascendant']);

        //$check_bank                 = $this->checkBanks($asc_sign, $planets);
        //$check_land                 = $this->checkProperty($asc_sign, $planets);
        $check_stock                = $this->checkStocks($asc_sign, $planets);
        
        $data                       = array();
        foreach($planets as $key => $planet)
        {
            $planet_sign            = $this->calcDetails($planet);
            $array                  = array($key => $planet_sign);
            $data                   = array_merge($data, $array);
        }
        print_r($planets);exit;
    }
    protected function removeRetro($planet)
    {
        // This functions removes :r at end of planet for example 29.17:r which suggests
        // planet is retrograde.
        $planet         = str_replace(":r","",$planet);
        return $planet;
    }
    protected function getSignLord($sign)
    {
        $own_sign                   = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        return $own_sign[$sign];
    }
    protected function checkStrength($sign, $planet)
    {
        //echo $planet." ".$sign;exit;
        $own_sign                   = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $deb_sign                   = array("Libra"=>"Sun","Scorpio"=>"Moon","Cancer"=>"Mars",
                                            "Pisces"=>"Mercury","Capricorn"=>"Jupiter",
                                            "Virgo"=>"Venus","Aries"=>"Saturn");
        $exal_sign                  = array("Libra"=>"Saturn","Cancer"=>"Jupiter","Taurus"=>"Moon",
                                            "Pisces"=>"Venus","Capricorn"=>"Mars","Virgo"=>"Mercury","Aries"=>"Sun");
        
        if($planet == $own_sign[$sign] || $planet == $exal_sign[$sign])
        {
            $val                    = "strong";
        }
        else if($planet == $deb_sign[$sign])
        {
            $val                    = "weak";
        }
        else
        {
            $val                    = "neutral";
        }
        return $val;
    }
    protected function planetGoodOrBad($planet)
    {
        $good                       = array("Jupiter","Venus","Moon","Mercury");
        $bad                        = array("Saturn","Mars","Rahu", "Ketu","Sun");
        
        if(in_array($planet, $good))
        {
            $val                    = "good";
        }
        else if(in_array($planet, $bad))
        {
            $val                    = "bad";
        }
        else 
        {
            $val                    = "neutral";
        }
        return $val;
    }
    protected function checkStrengthOfLord($asc, $sign,$data,$num)
    {
        $sign_lord                  = $this->getSignLord($sign);
        $lord_pl                    = $this->calcDetails($data[$sign_lord]);            // check sign where planetary lord is placed
        $lord_strength              = $this->checkStrength($lord_pl, $sign_lord); // check strength of planetary lord
        $lord_pl_dist               = $this->getHouseDistance($asc, $lord_pl);  // get distance of planetary lord from ascendant

        if($lord_strength == "strong" && ($lord_pl_dist == "9"|| $lord_pl_dist == "2" ||
            $lord_pl_dist == "5" || $lord_pl_dist == "1" || $lord_pl_dist == "4"||
            $lord_pl_dist == "10"|| $lord_pl_dist == "7" || $lord_pl_dist == "11"))
        {
            $invest                 = array("lord_pl_".$num => "good");
        }
        else if($lord_strength == "neutral" && ($lord_pl_dist == "9"|| $lord_pl_dist == "2" ||
            $lord_pl_dist == "5" || $lord_pl_dist == "1" || $lord_pl_dist == "4"||
            $lord_pl_dist == "10"|| $lord_pl_dist == "7" || $lord_pl_dist == "11"))
        {
            $invest                 = array("lord_pl_".$num => "safe");
        }
        else if($lord_strength == "weak" && ($lord_pl_dist == "9"|| $lord_pl_dist == "2" ||
            $lord_pl_dist == "5" || $lord_pl_dist == "1" || $lord_pl_dist == "4"||
            $lord_pl_dist == "10"|| $lord_pl_dist == "7" || $lord_pl_dist == "11"))
        {
            $invest                 = array("lord_pl_".$num => "caution");
        }
        else if($lord_strength == "strong" && ($lord_pl_dist !== "9"|| $lord_pl_dist !== "2" ||
            $lord_pl_dist !== "5" || $lord_pl_dist !== "1" || $lord_pl_dist !== "4"||
            $lord_pl_dist !== "10"|| $lord_pl_dist !== "7" || $lord_pl_dist == "11"))
        {
            $invest                 = array("lord_pl_".$num => "caution");
        }
         else if($lord_strength == "neutral" && ($lord_pl_dist !== "9"|| $lord_pl_dist !== "2" ||
            $lord_pl_dist !== "5" || $lord_pl_dist !== "1" || $lord_pl_dist !== "4"||
            $lord_pl_dist !== "10"|| $lord_pl_dist !== "7" || $lord_pl_dist == "11"))
        {
            $invest                 = array("lord_pl_".$num => "caution");
        }
         else 
        {
            $invest                 = array("lord_pl_".$num => "risky");
        }
        return $invest;
    }
    // recursive function to check strength of planet
    protected function checkPlStrength($sign, $planets, $num)
    {
         $i                          = 0;
         $count                     = count($planets);
        foreach($planets as $planet)
        {
            if($count > 0)
            {
                $strength           = $this->checkStrength($sign, $planet);
                $good_bad           = $this->planetGoodOrBad($planet);
                if($strength == "strong" && $good_bad == "good")
                {
                    $i              = $i + 4;
                }
                else if($strength == "strong" && $good_bad == "bad")
                {
                    $i              = $i + 2;
                }
                else if($strength == "neutral" && $good_bad == "good")
                {
                    $i              = $i + 3;
                }
                else if($strength == "neutral" && good_bad == "bad")
                {
                    $i              = $i + 1;
                }
                else if($strength == "bad" && $good_bad == "good")
                {
                    $i              = $i + 2;
                }
                else if($strength == "bad" && good_bad == "bad")
                {
                    $i              = $i + 0;
                }
            }
            else
            {
                $i                   = $i + 0;
            }
        }
        return array("pl_strength_".$num => $i,"total_pl_".$num => $count);
    }
     protected function checkAspStrength($sign, $aspects, $num)
    {
        $i                      = 0;
        $count                  = count($aspects);
        foreach($aspects as $aspect)
        {
            if($count > 0)
            {
                $strength           = $this->checkStrength($sign, $aspect);
                $good_bad           = $this->planetGoodOrBad($aspect);
                if($strength == "strong" && $good_bad == "good")
                {
                    $i              = $i + 4;
                }
                else if($strength == "strong" && $good_bad == "bad")
                {
                    $i              = $i + 2;
                }
                else if($strength == "neutral" && $good_bad == "good")
                {
                    $i              = $i + 3;
                }
                else if($strength == "neutral" && good_bad == "bad")
                {
                    $i              = $i + 1;
                }
                else if($strength == "bad" && $good_bad == "good")
                {
                    $i              = $i + 2;
                }
                else if($strength == "bad" && good_bad == "bad")
                {
                    $i              = $i + 0;
                }
            }
            else
            {
                $i                   = $i + 0;
            }
        }
        return array("asp_strength_".$num => $i,"total_asp_".$num => $count);
    }
    protected function checkBanks($asc, $data)
    {
        $sign                       = $this->getHouseSign($asc, "2");
        $array                      = array();
        $lord_strength              = $this->checkStrengthOfLord($asc, $sign, $data, "2");
        $planets                    = $this->checkPlanetsInHouse($data, "2");
        $aspects                    = $this->checkAspectsOnHouse($data, "2");
        $planets                    = $planets['house_2'];
        $aspects                    = $aspects['aspect_2'];

        $pl_strength                = $this->checkPlStrength($sign, $planets,"2");
        $asp_strength               = $this->checkAspStrength($sign, $aspects, "2");
        $array                      = array_merge($array, $lord_strength, $pl_strength, $asp_strength);
        //print_r($array);exit;
    
    }
    protected function checkProperty($asc, $data)
    {
        $sign                       = $this->getHouseSign($asc, "4");
        $array                      = array();
        $lord_strength              = $this->checkStrengthOfLord($asc, $sign, $data, "4");
        $planets                    = $this->checkPlanetsInHouse($data, "4");
        $aspects                    = $this->checkAspectsOnHouse($data, "4");
        $planets                    = $planets['house_4'];
        $aspects                    = $aspects['aspect_4'];

        $pl_strength                = $this->checkPlStrength($sign, $planets,"4");
        $asp_strength               = $this->checkAspStrength($sign, $aspects, "4");
        $array                      = array_merge($array, $lord_strength, $pl_strength, $asp_strength);
        //print_r($array);exit;
    }
    protected function checkStocks($asc, $data)
    {
        $sign                       = $this->getHouseSign($asc, "5");
        $array                      = array();
        $lord_strength              = $this->checkStrengthOfLord($asc, $sign, $data, "5");
        $planets                    = $this->checkPlanetsInHouse($data, "5");
        $aspects                    = $this->checkAspectsOnHouse($data, "5");
        $planets                    = $planets['house_5'];
        $aspects                    = $aspects['aspect_5'];

        $pl_strength                = $this->checkPlStrength($sign, $planets,"5");
        $asp_strength               = $this->checkAspStrength($sign, $aspects, "5");
        $array                      = array_merge($array, $lord_strength, $pl_strength, $asp_strength);
        print_r($array);exit;
    }
}