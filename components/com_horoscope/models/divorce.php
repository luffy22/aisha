<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('mangaldosha', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelDivorce extends HoroscopeModelMangalDosha
{
    public $data;
 
    public function addDivorceDetails($details)
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
                                $db->quote($pob),$db->quote($lon),$db->quote($lat),$db->quote($tmz),$db->quote($now),$db->quote('divorce'));
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
            $link       = JURI::base().'divorce?chart='.str_replace("horo","chart",$uniq_id);
            $app        ->redirect($link);
        }
    }
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $chart_id       = $jinput->get('chart', 'default_value', 'filter');
        $chart_id       = str_replace("chart","horo", $chart_id);
        
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
        $asc            = $this->getAscendant($user_data);
        $planets        = $this->getPlanets($output);
        $data           = array_merge($asc,$planets);
        //print_r($data);exit;
        //$details        = $this->getDetails($data);
        //print_r($details);exit;
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
        unset($newdata);
        $check_asc_dosha            = $this->checkDosha("asc",$asc_house);
        $check_moon_dosha           = $this->checkDosha("moon",$moon_house);
        $check_ven_dosha            = $this->checkDosha("ven",$ven_house);
        $check_nav_dosha            = $this->checkDosha("nav",$nav_house); 
        $percent                    = $check_asc_dosha['asc_percent']+$check_moon_dosha['moon_percent']+$check_ven_dosha['ven_percent']+$check_nav_dosha['nav_percent'];
        $percent                    = array("mangaldosha"=>$percent);
        $asc_divorce                = $this->checkAscendant($data['Ascendant']);
        $seventh_house              = $this->checkPlanetsInHouse($data, 7);
        $seventh_asp                = $this->checkAspectsOnHouse($data, 7);
        $eight_house                = $this->checkPlanetsInHouse($data, 8);
        $eight_asp                  = $this->checkAspectsOnHouse($data, 8);
        $twelfth_house              = $this->checkPlanetsInHouse($data,12);
        $twelfth_asp                = $this->checkAspectsOnHouse($data, 12);
        $array                      = array();
        $array                      = array_merge($array,$user_data,$percent,
                                                    $seventh_house,$seventh_asp,
                                                    $eight_house,$eight_asp,
                                                    $twelfth_house, $twelfth_asp);
        return $array;
       
    }
    protected function checkAscendant($asc)
    {
        $sign                   = $this->calcDetails($asc);
        $array                  = array("asc_sign" => $sign);
        return $array;
    }
    protected function checkPlanetsInHouse($data, $num)
    {
        //print_r($data);exit;
        $asc                    = $this->calcDetails($data["Ascendant"]);
        $house_7                = $this->getHouseSign($asc, $num);
        $planets                = array("Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu");
        $planets_in_house       = array(); 
        for($i = 1; $i< 10;$i++)
        { 
            $j              = $i-1;
            $planet         = $planets[$j];
            $planet_sign    = $this->calcDetails($data[$planet]);
            if($house_7 == $planet_sign)
            {
                $planet     = $planets[$j];
                //print_r($effect);exit;
                array_push($planets_in_house, $planet);
            }
            else
            {
                continue;
            }
        }
       return array("house_".$num => $planets_in_house);
    }
    protected function checkAspectsOnHouse($data, $num)
    {
        $aspect                 = array();
        $asc                    = $this->calcDetails($data["Ascendant"]);
        $sign                   = $this->getHouseSign($asc, $num);
        $planets                = array("Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu"); 
        foreach($planets as $planet)
        {
            $planet_sign        = $this->calcDetails($data[$planet]);
            if($planet =="Sun"|| $planet =="Moon"|| $planet=="Mercury"||$planet =="Venus")
            {
                $get_7th_sign   = $this->getHouseSign($planet_sign, 7);
                if($sign        == $get_7th_sign)
                {
                    array_push($aspect, $planet);
                }
                else
                {
                    continue;
                }
            }
            else if($planet == "Jupiter" || $planet == "Rahu")
            {
                $get_7th_sign   = $this->getHouseSign($planet_sign, 7);
                $get_5th_sign   = $this->getHouseSign($planet_sign, 5);
                $get_9th_sign   = $this->getHouseSign($planet_sign, 9);
                if($sign        == $get_7th_sign || $sign == $get_5th_sign || $sign == $get_9th_sign)
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
                $get_7th_sign   = $this->getHouseSign($planet_sign, 7);
                $get_3rd_sign   = $this->getHouseSign($planet_sign, 3);
                $get_10th_sign   = $this->getHouseSign($planet_sign, 10);
                if($sign        == $get_7th_sign || $sign == $get_3rd_sign || $sign == $get_10th_sign)
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
        return array("aspect_".$num =>$aspect);
    }
    protected function getHouseSign($asc, $num)
    {
        $signs              = array("Aries","Taurus","Gemini","Cancer",
                                    "Leo","Virgo","Libra","Scorpio",
                                    "Sagittarius","Capricorn","Aquarius","Pisces");
       $key                 = array_keys($signs, $asc);
       $key                 = $key[0];
       if($key+$num <= 12)
       {
           $house           =   $key+$num;
       }
       else
       {
           $house             = ($key + $num)-12;
           
       }
       return $signs[$house-1];
    }
}
?>
