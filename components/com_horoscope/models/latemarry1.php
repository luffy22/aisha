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
            exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m789 -g, -head", $output);
            //print_r($output);exit;

            $array                      = array();
            $asc                        = $this->getAscendant($result);
            $planets                    = $this->getPlanets($output);
            $planets                    = array_merge($asc,$planets);
            // ascendant chart data
            $seventh                    = $this->seventhHouse($planets);
            $twelfth                    = $this->twelfthHouse($planets);
            $second                     = $this->secondHouse($planets);
            $eleventh                   = $this->eleventhHouse($planets);
            
            // moon chart data
            $moon_asc                   = $this->getMoonChart($date, $time);
            $seventh_moon               = $this->seventhMoon($moon_asc);
            $twelfth_moon               = $this->twelfthMoon($moon_asc);
            $second_moon                = $this->secondMoon($moon_asc);
            $eleventh_moon              = $this->eleventhMoon($moon_asc);
            // navamsha chart data
            $nav_sign                   = $this->navamshaSign($planets);
            $seventh_nav                = $this->seventhNavamsha($nav_sign);
            $twelfth_nav                = $this->twelfthNavamsha($nav_sign);
            $second_nav                 = $this->secondNavamsha($nav_sign);
            $eleventh_nav               = $this->eleventhNavamsha($nav_sign);
            
            $seventh_late               = $this->checkLateChances($seventh,$seventh_moon, $seventh_nav, "7");
            $array                      = array_merge($array, $result, $seventh, $seventh_moon, $seventh_nav, 
                                                        $twelfth, $twelfth_moon, $twelfth_nav,
                                                        $second, $second_moon, $second_nav,
                                                        $eleventh, $eleventh_moon, $eleventh_nav);
            print_r($array);exit;
        }
    }
        public $data;
 
    public function addUser($details)
    {
        $result                 = $this->addUserDetails($details, "latemarry");
        if($result)
        {
            //echo "query inserted";exit;
            $app                = JFactory::getApplication();
            $link               = JURI::base().'latemarry?chart='.str_replace("horo","chart",$result);
            $app                ->redirect($link);
        }
    
    }
    public function getMoonChart($date, $time)
    {
        $array                  = array();
        $libPath                = JPATH_BASE.'/sweph/';
        $h_sys = 'P';
        $output = "";

            // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m789 -g, -head", $output);
        $asc                    = $output[1];
        $var                    = explode(",", $asc);
        $planet                 = trim($var[0]);
        $dist                   = $var[1];
        $asc_sign               = array("Ascendant"=>$dist);
        $planets                = $this->getPlanets($output);        
        $array                  = array_merge($array, $asc_sign, $planets);
        return $array;
    }
    public function navamshaSign($planets)
    {
        $data               = array();
        foreach($planets as $planet=>$dist)
        {
            $dist2              = $this->convertDecimalToDegree($dist, "details");
            $sign               = $this->calcDetails($dist);
            $navamsha           = $this->getNavamsha($planet, $sign, $dist2);
            $data               = array_merge($data,$navamsha);

        }
        return $data;
    }
    public function seventhHouse($data)
    {
        $asc                    = $this->calcDetails($data["Ascendant"]);

        $array                  = array();
        $planet                 = $this->checkPlanetsInHouse($data, 7);
        $aspect                 = $this->checkAspectsOnHouse($data, 7);
        $array                  = array_merge($array,$planet, $aspect);
        //print_r($array);exit;
        return $array;
    }
    public function seventhMoon($data)
    {
        //print_r($data);exit;
        $asc                    = $this->calcDetails($data["Ascendant"]);

        $array                  = array();
        $planet                 = $this->checkPlanetsInHouse($data, 7);
        $planet["moon_7"]       = $planet["house_7"];   // replacing key "house_7" with "moon_" to signify 7th from Moon Sign
        unset($planet["house_7"]);
        $aspect                 = $this->checkAspectsOnHouse($data, 7);
        $aspect["moon_7_as"]     = $aspect["aspect_7"];   // replacing key "house_7" with "moon_" to signify 7th from Moon Sign
        unset($aspect["aspect_7"]);
        $array                  = array_merge($array,$planet, $aspect);
        //print_r($array);exit;
        return $array;
    }
    public function seventhNavamsha($data)
    {
        //print_r($data);exit;
        $array                  = array();
        $placement              = array();
        $asc                    = $data['Ascendant_navamsha_sign'];
        $nav_sign               = $this->getHouseSign($asc, 7);  // seventh navamsha sign

        foreach($data as $planet=>$sign)
        {
            if($sign == $nav_sign)
            {
                $value          = str_replace("_navamsha_sign","", $planet);
                array_push($placement, $value);
            }
        }
        $nav_pl                 = array("nav7"=>$placement);
        $aspect                 = $this->checkAspects($data,$nav_sign);
        $nav_as                 = array("nav7_as"=>$aspect);
        //print_r($nav_as);exit;
        //print_r($nav_pl);exit;
        $array                  = array_merge($array,$nav_pl, $nav_as);
        //print_r($array);exit;
        return $array;
    }
     public function twelfthHouse($data)
    {
        //print_r($data);exit;
        $asc                    = $this->calcDetails($data["Ascendant"]);

        $array                  = array();
        $planet                 = $this->checkPlanetsInHouse($data, 12);
        $aspect                 = $this->checkAspectsOnHouse($data, 12);
        $array                  = array_merge($array,$planet, $aspect);
        //print_r($array);exit;
        return $array;
        
    }
    public function twelfthMoon($data)
    {
        //print_r($data);exit;
        $asc                    = $this->calcDetails($data["Ascendant"]);

        $array                  = array();
        $planet                 = $this->checkPlanetsInHouse($data, 12);
        $planet["moon_12"]      = $planet["house_12"];   // replacing key "house_7" with "moon_" to signify 7th from Moon Sign
        unset($planet["house_12"]);
        $aspect                 = $this->checkAspectsOnHouse($data, 12);
        $aspect["moon_12_as"]   = $aspect["aspect_12"];   // replacing key "house_7" with "moon_" to signify 7th from Moon Sign
        unset($aspect["aspect_12"]);
        $array                  = array_merge($array,$planet, $aspect);
        //print_r($array);exit;
        return $array;
    }
      public function twelfthNavamsha($data)
    {
        $array                  = array();
        $placement              = array();
        $asc                    = $data['Ascendant_navamsha_sign'];
        $nav_sign               = $this->getHouseSign($asc, 12);  // seventh navamsha sign
        foreach($data as $planet=>$sign)
        {
            if($sign == $nav_sign)
            {
                $value          = str_replace("_navamsha_sign","", $planet);
                array_push($placement, $value);
            }
        }
        $nav_pl                 = array("nav_12"=>$placement);
        $aspect                 = $this->checkAspects($data,$nav_sign);
        $nav_as                 = array("nav_12_as"=>$aspect);
        //print_r($nav_as);exit;
        //print_r($nav_pl);exit;
        $array                  = array_merge($array,$nav_pl, $nav_as);
        //print_r($array);exit;
        return $array;
        
    }
    public function secondHouse($data)
    {
        //print_r($data);exit;
        $asc                    = $this->calcDetails($data["Ascendant"]);

        $array                  = array();
        $planet                 = $this->checkPlanetsInHouse($data, 2);
        $aspect                 = $this->checkAspectsOnHouse($data, 2);
        $array                  = array_merge($array,$planet, $aspect);
        //print_r($array);exit;
        return $array;
        
    }
    public function secondMoon($data)
    {
        //print_r($data);exit;
        $asc                    = $this->calcDetails($data["Ascendant"]);

        $array                      = array();
        $planet                     = $this->checkPlanetsInHouse($data, 2);
        $planet["moon_2"]           = $planet["house_2"];   // replacing key "house_7" with "moon_" to signify 7th from Moon Sign
        unset($planet["house_2"]);
        $aspect                     = $this->checkAspectsOnHouse($data, 2);
        $aspect["moon_2_as"]        = $aspect["aspect_2"];   // replacing key "house_7" with "moon_" to signify 7th from Moon Sign
        unset($aspect["aspect_2"]);
        $array                      = array_merge($array,$planet, $aspect);
        //print_r($array);exit;
        return $array;
    }
    public function secondNavamsha($data)
    {
        $array                  = array();
        $placement              = array();
        $asc                    = $data['Ascendant_navamsha_sign'];
        $nav_sign               = $this->getHouseSign($asc, 2);  // seventh navamsha sign
        //echo $nav_sign;exit;
        foreach($data as $planet=>$sign)
        {
            if($sign == $nav_sign)
            {
                $value          = str_replace("_navamsha_sign","", $planet);
                array_push($placement, $value);
            }
        }
        $nav_pl                 = array("nav_2"=>$placement);
        $aspect                 = $this->checkAspects($data,$nav_sign);
        $nav_as                 = array("nav_2_as"=>$aspect);
        $array                  = array_merge($array,$nav_pl, $nav_as);
        //print_r($array);exit;
        return $array;
        
    }
    public function eleventhHouse($data)
    {
        //print_r($data);exit;
        $asc                    = $this->calcDetails($data["Ascendant"]);
        $array                  = array();
        $planet                 = $this->checkPlanetsInHouse($data, 11);
        $aspect                 = $this->checkAspectsOnHouse($data, 11);
        $array                  = array_merge($array,$planet, $aspect);
        //print_r($array);exit;
        return $array;
        
    }
    public function eleventhMoon($data)
    {
        //print_r($data);exit;
        $asc                    = $this->calcDetails($data["Ascendant"]);
        $array                  = array();
        $planet                 = $this->checkPlanetsInHouse($data, 11);
        $planet["moon_11"]       = $planet["house_11"];   // replacing key "house_7" with "moon_" to signify 7th from Moon Sign
        unset($planet["house_11"]);
        $aspect                 = $this->checkAspectsOnHouse($data, 11);
        $aspect["moon_11_as"]       = $aspect["aspect_11"];   // replacing key "house_7" with "moon_" to signify 7th from Moon Sign
        unset($aspect["aspect_11"]);
        $array                  = array_merge($array,$planet, $aspect);
        //print_r($array);exit;
        return $array;
    }
    public function eleventhNavamsha($data)
    {
        $array                  = array();
        $placement              = array();
        $asc                    = $data['Ascendant_navamsha_sign'];
        $nav_sign               = $this->getHouseSign($asc, 11);  // seventh navamsha sign
        foreach($data as $planet=>$sign)
        {
            if($sign == $nav_sign)
            {
                $value          = str_replace("_navamsha_sign","", $planet);
                array_push($placement, $value);
            }
        }
        $nav_pl                 = array("nav_11"=>$placement);
        $aspect                 = $this->checkAspects($data,$nav_sign);
        $nav_as                 = array("nav_11_as"=>$aspect);
        //print_r($nav_as);exit;
        //print_r($nav_pl);exit;
        $array                  = array_merge($array,$nav_pl, $nav_as);
        //print_r($array);exit;
        return $array;
        
    }
    public function checkAspects($data, $nav_sign)
    {
        $aspect                 = array();
        //print_r($data);exit;
        foreach($data as $planet=>$sign)
        {
            $planet         = str_replace("_navamsha_sign","",$planet);

            if($planet =="Sun"|| $planet =="Moon"|| $planet=="Mercury"||$planet =="Venus"||$planet=="Neptune"||$planet=="Uranus"||$planet=="Pluto")
            {
                $get_7th_sign   = $this->getHouseSign($sign, 7);
                if($get_7th_sign        == $nav_sign)
                {
                    array_push($aspect, $planet);
                }
                else
                {
                    continue;
                }
            }
            else if($planet == "Mars")
            {
                $get_4th_sign   = $this->getHouseSign($sign, 4);
                $get_7th_sign   = $this->getHouseSign($sign, 7);
                $get_8th_sign   = $this->getHouseSign($sign, 8);
                if($nav_sign        == $get_4th_sign || $nav_sign == $get_7th_sign || $nav_sign == $get_8th_sign)
                {
                    array_push($aspect, $planet);
                }
                else
                {
                    continue;
                }
            }
            else if($planet == "Jupiter" || $planet == "Rahu" || $planet == "Ketu")
            {
                $get_7th_sign   = $this->getHouseSign($sign, 7);
                $get_5th_sign   = $this->getHouseSign($sign, 5);
                $get_9th_sign   = $this->getHouseSign($sign, 9);
                if($nav_sign        == $get_7th_sign || $nav_sign == $get_5th_sign || $nav_sign == $get_9th_sign)
                {
                    array_push($aspect, $planet);
                }
                else
                {
                    continue;
                }
            }
            else if($planet == "Saturn")
            {
                $get_7th_sign   = $this->getHouseSign($sign, 7);
                $get_3rd_sign   = $this->getHouseSign($sign, 3);
                $get_10th_sign   = $this->getHouseSign($sign, 10);
                if($nav_sign        == $get_7th_sign || $nav_sign == $get_3rd_sign || $nav_sign == $get_10th_sign)
                {
                    array_push($aspect, $planet);
                }
                else
                {
                    continue;
                }
            }
            else
            {
                continue; // for ketu who has no aspects
            }
        }
        return $aspect;
    }
    public function checkLateChances($asc, $moon, $nav, $num)
    {  
       //print_r($moon);exit;
       $percent             = 25;
       $array               = array();
       if(count($asc['house_'.$num]) == "0" && count($asc['aspect_'.$num]) == "0")
       {
           $percent         = $percent-15;
       }
       else if(count($asc['house_'.$num]) !== "0" && count($asc['aspect_'.$num]) == "0")
       {
           $percent         = $percent-7;
       }
       else if(count($asc['house_7']) == "0" && count($asc['aspect_7']) !== "0")
       {
           $percent         = $percent-7;
       }
       else if(count($asc['house_7']) !== "0" && count($asc['aspect_7']) !== "0")
       {
           $percent         = $percent-0;
       }
       if(count($moon['moon_'.$num]) == "0" && count($moon['moon_'.$num."_as"]) == "0")
       {
           $percent         = $percent-5;
       }
       else if(count($moon['moon_'.$num]) !== "0" && count($asc['moon_'.$num."_as"]) == "0")
       {
           $percent         = $percent-2;
       }
       else if(count($moon['moon_'.$num]) == "0" && count($moon['moon_'].$num."_as") !== "0")
       {
           $percent         = $percent-2;
       }
       else if(count($moon['moon_'.$num]) !== "0" && count($moon['moon_'.$num."_as"]) !== "0")
       {
           $percent         = $percent-0;
       }
       else if(in_array("Saturn",$asc['aspect_7']) || in_array("Saturn", $asc['house_7']))
       {
           $percent         = $percent-0;
       }
       else if(in_array("Mars",$asc['aspect_7']) || in_array("Mars", $asc['house_7']))
       {
           $percent         = $percent-0;
       }
       else if(in_array("Jupiter", $asc['house_7']))
       {
           $percent         = $percent-0;
       }
       else if(in_array("Jupiter",$asc['aspect_7']))
       {
           $percent         = $percent-5;
       }
            
       else if(in_array("Venus",$asc['aspect_7']) || in_array("Venus", $asc['house_7']))
       {
           $percent         = $percent-10;
       }
        else if(in_array("Moon", $asc['house_7']))
       {
           $percent         = $percent-10;
       }
    }
}
