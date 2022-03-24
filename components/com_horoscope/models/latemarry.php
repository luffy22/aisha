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


            $asc                        = $this->getAscendant($result);
            $planets                    = $this->getPlanets($output);
            $planets                    = array_merge($asc,$planets);
            //print_r($planets);exit;
           
            //print_r($data);exit;
            $nav_sign                   = $this->navamshaSign($planets);
            $seventh                    = $this->seventhHouse($planets);
            $seventh_nav                = $this->seventhNavamsha($nav_sign);
            $twelfth                    = $this->twelfthHouse($planets);
            $twelfth_nav                = $this->twelfthNavamsha($nav_sign);
            $second                     = $this->secondHouse($planets);
            $second_nav                 = $this->secondNavamsha($nav_sign);
            $eleventh                   = $this->eleventhHouse($planets);
            $eleventh_nav               = $this->eleventhNavamsha($nav_sign);
            //return $all_details;
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
        //print_r($data);exit;
        $array                  = array();
        $planet                 = $this->checkPlanetsInHouse($data, 7);
        $aspect                 = $this->checkAspectsOnHouse($data, 7);
        $array                  = array_merge($array,$planet, $aspect);
        //print_r($array);exit;
        return $array;
    }
    public function seventhNavamsha($data)
    {
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
        $nav_pl                 = array("seventh_nav_pl"=>$placement);
        $aspect                 = $this->checkAspects($data,$nav_sign);
        $nav_as                 = array("seventh_nav_as"=>$aspect);
        //print_r($nav_as);exit;
        //print_r($nav_pl);exit;
        
    }
     public function twelfthHouse($data)
    {
        //print_r($data);exit;
        $array                  = array();
        $planet                 = $this->checkPlanetsInHouse($data, 12);
        $aspect                 = $this->checkAspectsOnHouse($data, 12);
        $array                  = array_merge($array,$planet, $aspect);
        return $array;
        
    }
      public function twelfthNavamsha($data)
    {
        $placement              = array();
        $planets                = array();
        $aspects                = array();
        $asc                    = $data['Ascendant_navamsha_sign'];
        $nav_sign               = $this->getHouseSign($asc, 12);    // 12th navamsha sign
        foreach($data as $planet=>$sign)
        {
            if($sign == $nav_sign)
            {
                $value          = str_replace("_navamsha_sign","", $planet);
                array_push($placement, $value);
            }
        }
        $array                  = array("twelfth_nav_pl"=>$placement);
        return $array;
        
    }
    public function secondHouse($data)
    {
        //print_r($data);exit;
        $array                  = array();
        $planet                 = $this->checkPlanetsInHouse($data, 2);
        $aspect                 = $this->checkAspectsOnHouse($data, 2);
        $array                  = array_merge($array,$planet, $aspect);
        return $array;
        
    }
    public function secondNavamsha($data)
    {
        $placement              = array();
        $planets                = array();
        $aspects                = array();
        $asc                    = $data['Ascendant_navamsha_sign'];
        $nav_sign               = $this->getHouseSign($asc, 2);     // second navamsha sign
        
        foreach($data as $planet=>$sign)
        {
            if($sign == $seventh_nav)
            {
                $value          = str_replace("_navamsha_sign","", $planet);
                array_push($placement, $value);
            }
        }
        $array                  = array("second_nav_pl"=>$placement);
        $aspect                 = $this->checkAspects($data,$nav_sign);
        $nav_as                 = array("second_nav_as"=>$aspect);
        print_r($nav_as);exit;
        
    }
    public function eleventhHouse($data)
    {
        //print_r($data);exit;
        $array                  = array();
        $planet                 = $this->checkPlanetsInHouse($data, 11);
        $aspect                 = $this->checkAspectsOnHouse($data, 11);
        $array                  = array_merge($array,$planet, $aspect);
        return $array;
        
    }
    public function eleventhNavamsha($data)
    {
        $placement              = array();
        $planets                = array();
        $aspects                = array();
        $asc                    = $data['Ascendant_navamsha_sign'];
        $nav_sign               = $this->getHouseSign($asc, 11);        // eleventh navamsha sign
        foreach($data as $planet=>$sign)
        {
            if($sign == $nav_sign)
            {
                $value          = str_replace("_navamsha_sign","", $planet);
                array_push($placement, $value);
            }
        }
        $array                  = array("eleventh_nav_pl"=>$placement);
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
}
