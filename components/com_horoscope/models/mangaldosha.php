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
        $asc_house                  = explode("_",$this->getAscHouse($newdata));
        $moon_house                 = explode("_",$this->getMoonHouse($newdata));
        $ven_house                  = explode("_",$this->getVenusHouse($newdata));
        $check_asc_dosha            = $this->checkDosha("asc",$asc_house[0],$asc_house[1]);
        $check_moon_dosha           = $this->checkDosha("moon",$moon_house[0], $moon_house[1]);
        $check_ven_dosha            = $this->checkDosha("ven",$ven_house[0],$ven_house[1]);
        $percent                    = $check_asc_dosha['percent']+$check_moon_dosha['percent']+$check_ven_dosha['percent'];
        $percent                    = round((100*$percent)/300,0);
        $check_co_tenants           = $this->checkCoTenants($newdata);
        print_r($check_co_tenants);exit;
        $array              = array_merge($array,$result,$house, $details);
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
    protected function getAscHouse($data)
    {
       $j = 1;$a=1;
       $asc_num         = $data['Ascendant_num'];
       $asc_nav_num     = $data['Ascendant_navamsha_num'];
       $mars_num        = $data['Mars_num'];
       $mars_nav_num    = $data['Mars_navamsha_num'];
       if($asc_num > $mars_num)
       {
           $mars_num     = $mars_num + 12;
       }
       for($i=$asc_num;$i <$mars_num;$i++)
       {
           $j++;       
       }
       if($asc_nav_num > $mars_nav_num)
       {
           $mars_nav_num     = $mars_nav_num + 12;
       }
       for($i=$asc_nav_num;$i <$mars_nav_num;$i++)
       {
           $a++;       
       }
       
       //echo $j;exit;
       return $j."_".$a;
       
    }
    protected function getMoonHouse($data)
    {
        $b = 1;$c=1;
      
        $moon_num        = $data['Moon_num'];
        $moon_nav_num    = $data['Moon_navamsha_num'];
        $mars_num        = $data['Mars_num'];
        $mars_nav_num    = $data['Mars_navamsha_num'];
        if($moon_num > $mars_num)
       {
           $mars_num     = $mars_num + 12;
       }
       for($i=$moon_num;$i <$mars_num;$i++)
       {
           $c++;       
       }
        if($moon_nav_num > $mars_nav_num)
        {
            $mars_nav_num     = $mars_nav_num + 12;
        }
        for($i=$moon_nav_num;$i <$mars_nav_num;$i++)
        {
            $b++;       
        }
        return $c."_".$b;
    }
    protected function getVenusHouse($data)
    {
        $b = 1;$c=1;
      
        $venus_num          = $data['Venus_num'];
        $venus_nav_num      = $data['Venus_navamsha_num'];
        $mars_num           = $data['Mars_num'];
        $mars_nav_num       = $data['Mars_navamsha_num'];
        if($venus_num > $mars_num)
       {
           $mars_num     = $mars_num + 12;
       }
       for($i=$venus_num;$i <$mars_num;$i++)
       {
           $c++;       
       }
       if($venus_nav_num > $mars_nav_num)
        {
            $mars_nav_num     = $mars_nav_num + 12;
        }
        for($i=$venus_nav_num;$i <$mars_nav_num;$i++)
        {
            $b++;       
        }
        return $c."_".$b;
    }
    protected function checkDosha($key, $house1, $house2)
    {
        if($house1 == "1"||$house1 == "2"||$house1=="4"||$house1 == "7"||$house1=="8"||$house1=="12")
        {
            $dosha1      = array($key."_dosha_asc"=>"yes");
            $percent1    = 50;
        }
        else
        {
            $dosha1      = array($key."_dosha_asc"=>"no");
            $percent1    = 0;
        }
        if($house2 == "1"||$house2 == "2"||$house2=="4"||$house2 == "7"||$house2=="8"||$house2=="12")
        {
            $dosha2      = array($key."_dosha_navamsha"=>"yes");
            $percent2    = 50;
        }
        else
        {
            $dosha2      = array($key."_dosha_navamsha"=>"no");
            $percent2     = 0;
        }
        $percent        = $percent1+$percent2;
        $percent        = array("percent"=>$percent);
        return array_merge($dosha1,$dosha2, $percent);
    }
    protected function checkCoTenants($data)
    {
        //print_r($data);exit;
        $mars_sign      = $data["Mars_sign"];
        $planets        = array("Sun","Moon","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu");
        $stack          = array();
        for($i=0;$i<count($planets);$i++)
        {
            if($data[$planets[$i]."_sign"]== $mars_sign)
            {
                array_push($stack,$planets[$i]);
            }
        }
        return $stack;
    }
}
?>
