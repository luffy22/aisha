<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelMangalDosha extends HoroscopeModelLagna
{
    public $data;
 
    public function mangalDosha($details)
    {
        $fname          = $details['fname'];
        $gender         = $details['gender'];
        $dob            = $details['dob'];
        $tob            = $details['tob'];
        $pob            = $details['pob'];
        $lon            = $details['lon'];
        $lat            = $details['lat'];
        $tmz            = $details['tmz'];
        if($tmz == "none")
        {
            $date           = new DateTime($dob." ".$tob);
            $timestamp      = $date->format('U');
            $tmz            = $this->getTimeZone($lat, $lon, "rohdes");
            if($tmz == "error")
            {
                $tmz        = "UTC";        // if timezone not available use UTC(Universal Time Cooridnated)
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
        $columns        = array('uniq_id','fname','gender','dob_tob','pob','lon','lat','timezone','query_date','query_cause');
        $values         = array($db->quote($uniq_id),$db->quote($fname),$db->quote($gender),$db->quote($dob_tob),
                                $db->quote($pob),$db->quote($lon),$db->quote($lat),$db->quote($tmz),$db->quote($now),$db->quote('mdosha'));
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
            $link       = JURI::base().'mangaldosha?chart='.str_replace("horo","chart",$uniq_id);
            $app        ->redirect($link);
        }
    }
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $chart_id       = $jinput->get('chart', 'default_value', 'filter');
        $chart_id       = str_replace("chart","horo", $chart_id);
        
        $result         = $this->getUserData($chart_id);
        
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
        $asc            = $this->getAscendant($result);
        $planets        = $this->getPlanets($output);
        $data           = array_merge($asc,$planets);
        //print_r($data);exit;
        //$details        = $this->getDetails($data);
        $newdata        = array();
        foreach($data as $key=>$distance)
        {
            // this loop gets the horoscope sign of Ascendant, Moon & Jupiter or Venus
            $dist                   = str_replace(":r","",$distance);
            $dist2                  = $this->convertDecimalToDegree(str_replace(":r","",$distance),"details");
            $sign                   = $this->calcDetails($dist);
            $sign_num               = array($key."_num"=>$this->getSignNum($sign));
            $getsign                = array($key."_sign"=>$sign);
            $navamsha               = $this->getNavamsha($key, $sign, $dist2);
            $navamsha_sign_num      = array($key."_navamsha_num"=>$this->getSignNum($navamsha[$key.'_navamsha_sign']));
            $newdata                = array_merge($newdata,$getsign,$sign_num,$navamsha, $navamsha_sign_num);
        }
        //print_r($newdata);exit;
        $asc_house                  = $this->getHouse("Ascendant",$newdata);
        $moon_house                 = $this->getHouse("Moon",$newdata);
        $ven_house                  = $this->getHouse("Venus",$newdata);
        $nav_house                  = $this->getHouse("Ascendant_navamsha",$newdata);
        
        $check_asc_dosha            = $this->checkDosha("asc",$asc_house);
        $check_moon_dosha           = $this->checkDosha("moon",$moon_house);
        $check_ven_dosha            = $this->checkDosha("ven",$ven_house);
        $check_nav_dosha            = $this->checkDosha("nav",$nav_house);   
        //$percent                    = $check_asc_dosha['percent']+$check_moon_dosha['percent']+$check_ven_dosha['percent']+$check_nav_dosha['percent'];
        //echo $percent;exit;
        $check_co_tenants           = $this->checkCoTenants($newdata);
        //print_r($check_co_tenants);exit;
        $check_aspects              = $this->checkAspects($newdata);
        
        $array                      = array();
        $array                      = array_merge($array,$result,$check_asc_dosha,$check_moon_dosha,$check_ven_dosha,$check_nav_dosha, $check_co_tenants, $check_aspects);
        return $array;
    }
    protected function getSignNum($sign)
    {
        switch($sign)
        {
            case "Aries":
            return "1";break;
            case "Taurus":
            return "2";break;
            case "Gemini":
            return "3";break;
            case "Cancer":
            return "4";break;
            case "Leo":
            return "5";break;
            case "Virgo":
            return "6";break;
            case "Libra":
            return "7";break;
            case "Scorpio":
            return "8";break;
            case "Sagittarius":
            return "9";break;
            case "Capricorn":
            return "10";break;
            case "Aquarius":
            return "11";break;
            case "Pisces":
            return "12";break;
            default:
            return "1";break;
        }
   
    }
    protected function getHouse($key, $data)
    {
       $j = 1;
       $asc_num         = $data[$key.'_num'];
       if($key == "Ascendant_navamsha")
       $mars_num        = $data['Mars_navamsha_num'];
       else
       $mars_num        = $data['Mars_num'];
       
       if($asc_num > $mars_num)
       {
           $mars_num     = $mars_num + 12;
       }
       for($i=$asc_num;$i <$mars_num;$i++)
       {
           $j++;       
       }   
       //echo $j;exit;
       return $j;
    }
    protected function checkDosha($key, $house)
    {
        if($house == "1"||$house == "2"||$house=="4"||$house == "7"||$house=="8"||$house=="12")
        {
            $dosha      = array($key."_dosha"=>"yes");
            $percent    = 25;
        }
        else
        {
            $dosha      = array($key."_dosha"=>"no");
            $percent    = 0;
        }
        $percent        = array($key."_percent"=>$percent);
        return array_merge($dosha,$percent);
    }
    protected function checkCoTenants($data)
    {
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $mars_sign      = $data["Mars_sign"];
        $planets        = array("Sun","Moon","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu");
        $stack          = array();
        $count          = array();
        $j       = 0;
        for($i=0;$i<count($planets);$i++)
        {
            
            if($data[$planets[$i]."_sign"]== $mars_sign)
            {
                $planet         = strtolower($planets[$i]);
                $query          ->select($db->quoteName(array('result')));
                $query          ->from($db->quoteName('#__planet_cotenant'));
                $query          ->where($db->quoteName('mars').' = '.$db->quote('yes').' AND'.
                                        $db->quoteName($planet).' = '.$db->quote('yes'));
                $db             ->setQuery($query);
                $result         = $db->loadAssoc();
                $details        = array("coplanet_".$j => $planets[$i], "coplanet_".$j."_details" => $result['result']);
                $stack          = array_merge($stack,$details);
                $j++;
            }
            $count              = array("coten_count"=>$j);
            $stack              = array_merge($stack,$count);
        }
        return $stack;
    }
    protected function checkAspects($data)
    {
        //print_r($data);exit;
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $mars_num       = $data["Mars_num"];
        $planets        = array("Sun","Moon","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu");
        $stack          = array();
        $count          = array();
        $j       = 0;
        for($i=0;$i<count($planets);$i++)
        {
            if($data[$planets[$i]."_num"]== $mars_num || str_replace("_sign","",$data[$planets[$i]."_sign"]) == "Ketu")
            {
                continue;           // checks if planet is in same sign as mars 
            }
            else
            {
                if($planets[$i]=="Sun"||$planets[$i]=="Moon"||$planets[$i]=="Mercury"||$planets[$i]=="Venus")
                {
                    if($data[$planets[$i]."_num"] < 6)
                    {
                        $aspect         = $data[$planets[$i]."_num"] + 6;
                    }
                    else 
                    {
                        $aspect         = $data[$planets[$i]."_num"] - 6;
                    }
                    if($aspect == $mars_num)
                    {
                        $planet_same    = strtolower($planets[$i]);
                        $query 		->clear();
                        $query          ->select($db->quoteName('result'));
                        $query          ->from($db->quoteName('#__planet_aspects'));
                        $query          ->where($db->quoteName('planet').' = '.$db->quote('mars').' AND'.
                                                $db->quoteName('planet_aspecting').' = '.$db->quote($planet_same));
                        $db             ->setQuery($query);
                        $result         = $db->loadAssoc();
                        //print_r($result);exit;
                        $details        = array("aspect_".$j => $planets[$i], "aspect_".$j."_details" => $result['result']);
                        $stack          = array_merge($stack,$details);
                        $j++;
                    }
                }
                else if($planets[$i]=="Jupiter"||$planets[$i]=="Rahu")
                {
                    if($data[$planets[$i]."_num"] < 6)
                    {
                        $aspect1         = $data[$planets[$i]."_num"] + 6;
                    }
                    else 
                    {
                        $aspect1         = $data[$planets[$i]."_num"] - 6;
                    }
                    $aspect2             = $data[$planets[$i]."_num"] + 4;
                    if($aspect2 > 12)
                    {
                        $aspect2         = $aspect2 - 12;
                    }
                    $aspect3            = $data[$planets[$i]."_num"]  + 8;
                    if($aspect3  > 12)
                    {
                        $aspect3        = $aspect3  - 12;
                    }
                    if($aspect1 == $mars_num ||$aspect2 == $mars_num ||$aspect3 == $mars_num)
                    {
                        $planet_same    = strtolower($planets[$i]);
                        $query 		->clear();
                        $query          ->select($db->quoteName(array('result')));
                        $query          ->from($db->quoteName('#__planet_aspects'));
                        $query          ->where($db->quoteName('planet').' = '.$db->quote('mars').' AND'.
                                                $db->quoteName('planet_aspecting').' = '.$db->quote($planet_same));
                        $db             ->setQuery($query);
                        $result         = $db->loadAssoc();
                        $details        = array("aspect_".$j => $planets[$i], "aspect_".$j."_details" => $result['result']);
                        $stack          = array_merge($stack,$details);
                        $j++;
                    }
                }
                else if($planets[$i]=="Saturn")
                {
                    if($data[$planets[$i]."_num"] < 6)
                    {
                        $aspect1         = $data[$planets[$i]."_num"] + 6;
                    }
                    else 
                    {
                        $aspect1         = $data[$planets[$i]."_num"] - 6;
                    }
                    $aspect2            = $data[$planets[$i]."_num"] + 2;
                    if($aspect2 > 12)
                    {
                        $aspect2         = $aspect2 - 12;
                    }
                    $aspect3            = $data[$planets[$i]."_num"] + 9;
                    if($aspect3 > 12)
                    {
                        $aspect3         = $aspect3 - 12;
                    }
                    if($aspect1 == $mars_num ||$aspect2 == $mars_num ||$aspect3 == $mars_num)
                    {
			$query 		->clear();
                        $planet_same    = strtolower($planets[$i]);
                        $query          ->select($db->quoteName(array('result')));
                        $query          ->from($db->quoteName('#__planet_aspects'));
                        $query          ->where($db->quoteName('planet').' = '.$db->quote('mars').' AND'.
                                                $db->quoteName('planet_aspecting').' = '.$db->quote($planet_same));
                        $db             ->setQuery($query);
                        $result         = $db->loadAssoc();
                        $details        = array("aspect_".$j => $planets[$i], "aspect_".$j."_details" => $result['result']);
                        $stack          = array_merge($stack,$details);
                        $j++;
                    }
                }
            }
        }
        $count              = array("asp_count"=>$j);
        $stack              = array_merge($stack,$count);
        return $stack;
    }
}
?>
