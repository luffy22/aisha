<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
require_once JPATH_COMPONENT.'/controller.php';
//require_once JPATH;

$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelLagna extends JModelItem
{
    public $data;
    public function getLagna($user_details)
    {
        //print_r($user_details);exit;
        // Assigning the variables
        $fname          = $user_details['fname'];
        $gender         = $user_details['gender'];
        $chart          = $user_details['chart'];
        $dob            = $user_details['dob'];
        $tob            = $user_details['tob'];
        $pob            = $user_details['pob'];
        $lon            = $user_details['lon'];
        $lat            = $user_details['lat'];
        $tmz            = $user_details['tmz'];
        
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
        $columns        = array('uniq_id','fname','gender','chart_type','dob_tob','pob','lon','lat','timezone','query_date');
        $values         = array($db->quote($uniq_id),$db->quote($fname),$db->quote($gender),$db->quote($chart),$db->quote($dob_tob),
                                $db->quote($pob),$db->quote($lon),$db->quote($lat),$db->quote($tmz),$db->quote($now));
        $query          ->insert($db->quoteName('#__horo_query'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
        $db             ->setQuery($query);
        $result          = $db->query();
        if($result)
        {
            $app        = JFactory::getApplication();
            $link       = JURI::base().'horoscope?chart='.str_replace("horo","chart",$uniq_id);
            $app        ->redirect($link);
        }
    }
    public function getAscendant($data)
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $fname          = $data['fname'];
        $gender         = $data['gender'];
        $dob_tob        = $data['dob_tob'];
        $pob            = $data['pob'];
        $lat            = $data['lat'];
        $lon            = $data['lon'];
        $timezone       = $data['timezone'];
        
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
// More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -house$lon,$lat,$h_sys -fPls -p -g, -head", $output);
        //print_r($output);exit;
        $val            = explode(",",$output[12]);
        $key            = trim($val[0]);
        $value          = $val[1];
        $asc            = array($key=>$value);
        //print_r($asc);exit;
        return $asc;
    }
    protected function getTimeZone($lat, $lon, $username)
    {
       	//error checking
	if (!is_numeric($lat)) { custom_die('A numeric latitude is required.'); }
	if (!is_numeric($lon)) { custom_die('A numeric longitude is required.'); }
	if (!$username) { custom_die('A GeoNames user account is required. You can get one here: http://www.geonames.org/login'); }

	//connect to web service
	$url = 'http://api.geonames.org/timezone?lat='.$lat.'&lng='.$lon.'&style=full&username='.urlencode($username);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$xml = curl_exec($ch);
	curl_close($ch);
	if (!$xml) { $GLOBALS['error'] = 'The GeoNames service did not return any data: '.$url; return false; }

	//parse XML response
	$data = new SimpleXMLElement($xml);
	//echo '<pre>'.print_r($data,true).'</pre>'; exit;
	$timezone = trim(strip_tags($data->timezone->timezoneId));
        
	if ($timezone) { return $timezone; }
	else { return "error"; }

    }
    protected function getUserData($horo_id)
    {
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('fname','gender','chart_type','dob_tob','pob','lon','lat','timezone')));
        $query          ->from($db->quoteName('#__horo_query'));
        $query          ->where($db->quoteName('uniq_id').' = '.$db->quote($horo_id));
        $db             ->setQuery($query);
        $db->execute();
        $result         = $db->loadAssoc();
        return $result;
    }
    public function getPlanets($data)
    {
        //print_r($data);exit;
        $graha_12               = array("Sun","Moon","Mercury","Venus","Mars","Jupiter","Saturn","Uranus","Neptune","Pluto","mean Node");
        $planets                = array();
        for($i=0;$i<count($data);$i++)
        {
            $planet             = $data[$i];
            $var                = explode(",", $planet);
            $planet             = trim($var[0]);
            $dist               = $var[1];
            
            if(in_array($planet, $graha_12))
            {
                if(strpos($var[2],"-"))
                {
                    if($planet == "mean Node")
                    {
                        $planet     = str_replace("mean Node","Rahu", $planet);
                        $ketu           = (double)$dist+180.00;
                        if($ketu>359)
                        {
                            $ketu       = (double)$ketu-360.00;
                        }
                        $ketu           = $ketu.":r";
                        $ketu               = array("Ketu"=>$ketu);
                       
                    }
                    $dist           = $dist.":r";
                    $details        = array($planet => $dist);
                    if($planet == "Rahu")
                    {
                        $details    = array_merge($details, $ketu);
                    }
                }
                else
                {
                    $details        = array($planet => $dist);
                }
                $planets        = array_merge($planets, $details);
            }
        }
        return $planets;
    }
    /*
     * Get The Greenwich Mean Time from given time
     * @param dob  Date Of Birth
     * @param tob Time Of Birth
     * @param tmz  Default Time Zone of the place
     * @param dst If any daylight saving time is to be applied
     * @return datetime The datetime in YYYY-mm-dd_hh:mm:ss format
     */
    public function getGMTTime($dob,$tob,$tmz, $dst)
    {

        //echo $dob." : ".$tob." : ".$tmz." : ".$dst;exit;
        $dst        = explode(":", $dst);
        $tmz_sign   = substr($tmz,0 ,1);
        $tmz_val    = substr($tmz.":00",1);
        
        $tmz_str    = strtotime($tmz_val);
        $tmz_val    = explode(":", $tmz_val);
        $dob        = str_replace("/","-",$dob);
       
        $dob        = $dob." ".$tob;
        $date       = new DateTime();
        $date       ->setTimestamp(strtotime($dob));
        if($tmz_str == "-")
        {
            //$date       ->add(new DateInterval('PT'.$hr.'H'.$min.'M0S'));
            $date       ->add(new DateInterval('PT'.$tmz_val[0].'H'.$tmz_val[1].'M'.$tmz_val[2].'S'));
        }
        else
        {
            $date       ->sub(new DateInterval('PT'.$tmz_val[0].'H'.$tmz_val[1].'M'.$tmz_val[2].'S'));
        }
        return $date->format('Y-m-d_H:i:s');
    }
    /* 
     * Converts the decimal version to degree, mins & sec for planetary transits
     * @param string The decimal version of planetary transit
     * @param string usage Check what's the purpose of query
     * @return string Planetary transit in degree:minute:second format
    */
    public function convertDecimalToDegree($dec, $usage)
    {
         // Converts decimal format to DMS ( Degrees / minutes / seconds ) 
        $vars = explode(".",$dec);
        $deg = $vars[0]%30;
        $tempma = "0.".$vars[1];

        $tempma = $tempma * 3600;
        $min = floor($tempma / 60);
        $sec = number_format($tempma - ($min*60),0);
        
        if($usage == "details")
        {
            if($min < 10){(int)$min  = "0".$min;}
            return $deg.".".$min;
        }
        else
        {
            return $deg."&deg;".$min."'".$sec."''";
        }
    }
        // adding degree, minutes seconds
    public function addDegMinSec($deg1,$min1,$sec1,$deg2,$min2,$sec2)
    {
        $deg        = $deg1+$deg2;
        $min        = $min1+$min2;
        $sec        = $sec1+$sec2;
        $value      = $this->convertDegMinSec($deg,$min,$sec);
        return $value;
    }
    // subtracting degree minutes seconds
    public function subDegMinSec($deg1,$min1,$sec1,$deg2,$min2,$sec2)
    {
        while($sec2>$sec1)
        {
            $min1       = $min1-1;
            $sec1       = $sec1+60;
        }
        while($min2>$min1)
        {
            $deg1       = $deg1-1;
            $min1       = $min1+60;
        }
        if($deg2 > $deg1)
        $deg            = $deg2 - $deg1;
        else
        $deg            = $deg1 - $deg2;
        $min            = $min1-$min2;
        $sec            = $sec1-$sec2;
        $value          = $deg.":".$min.":".$sec;
        return $value;
    }
    // function checks seconds, minutes and degrees 
    // seconds and mins less then 60 and adding to degrees
    public function convertDegMinSec($deg,$min,$sec)
    {
        while($sec>=60)
        {
            $sec    = $sec-60;
            $min    = $min+1; 
        }
        while($min>=60)
        {
            $min    = $min-60;
            $deg    = $deg+1;
        }
        
        return $deg.":".$min.":".$sec;
    }
    public function convertDegMinToSec($deg,$min)
    {
        $sec        = ($deg*60*4)+($min*4);
        return $sec;
    }
    // Get planet sign
    public function calcDetails($planet)
    {
        $details        = explode(".", $planet);
        $sign_num       = intval($details[0]/30);
        switch($sign_num)
        {
            case 0:
            return "Aries";break;
            case 1:
            return "Taurus";break;
            case 2:
            return "Gemini";break;
            case 3:
            return "Cancer";break;
            case 4:
            return "Leo";break;
            case 5:
            return "Virgo";break;
            case 6:
            return "Libra";break;
            case 7:
            return "Scorpio";break;
            case 8:
            return "Sagittarius";break;
            case 9:
            return "Capricorn";break;
            case 10:
            return "Aquarius";break;
            case 11:
            return "Pisces";break;
            default:
            return "Aries";break;
        }
    }
    // method to get planet details
    // planetary lord, nakshatra, nakshatra lord
    public function getPlanetaryDetails($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('sign_lord','nakshatra','nakshatra_lord')));
        $query          ->from($db->quoteName('#__nakshatras'));
        $query          ->where($db->quoteName('sign').'='.$db->quote($sign).' AND '.
                                $db->quote($dist).' BETWEEN '.
                                $db->quoteName('down_deg').' AND '.
                                $db->quoteName('up_deg'));
        $db             ->setQuery($query);
        $result         = $db->loadAssoc();
        $data           = array($planet."_sign_lord"=>$result['sign_lord'],
                                $planet."_nakshatra"=>$result['nakshatra'],
                                $planet."_nakshatra_lord"=>$result['nakshatra_lord']);
        
        return $data;
    }
    protected function getNavamsha($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        $db                     = JFactory::getDbo();
        $query                  = $db->getQuery(true);
        $query                  ->select($db->quoteName('navamsha_sign'));
        $query                  ->from($db->quoteName('#__navamsha'));
        $query                  ->where($db->quoteName('sign').'='.$db->quote($sign).' AND '.
                                        $db->quote($dist).' BETWEEN '.
                                        $db->quoteName('low_deg').' AND '.
                                        $db->quoteName('up_deg')); 
        $db                     ->setQuery($query);
        $result                 = $db->loadAssoc();
        
        $navamsha_sign      = $result['navamsha_sign'];
        $navamsha           = array($planet."_navamsha_sign"=>$navamsha_sign);
        return $navamsha;
    }
    protected function getDetails($data)
    {
        //print_r($data);exit;
        
        //print_r($data);exit;
        foreach($data as $key=>$distance)
        {
            if(strpos($distance,":r"))
            {
                $status     = array("status"=>"retro");
            }
            else
            {
                $status     = array("status"=>"normal");
            }
            $sign           = $this->calcDetails($distance);
            $sign_det       = array($key."_sign"=>$sign);
            $dist           = $this->convertDecimalToDegree(str_replace(":r","",$distance),"none");        // This is for getting actual distance of planetary transits
            $dist2          = $this->convertDecimalToDegree(str_replace(":r","",$distance),"details");       // This is for getting nakshatra details
            $dist_det           = array($key."_dist"=>$dist);
            
            //echo $key." ".$sign." ".$dist." ".$dist2."<br/>";
            $details        = $this->getPlanetaryDetails($key, $sign, $dist2);
            $navamsha       = $this->getNavamsha($key, $sign, $dist2);
            $graha[]          = array_merge($sign_det,$dist_det,$navamsha, $status,$details);
        }
        return $graha;
    }

    public function getArticle($title, $type)
    {
        $type               = trim($type);
        //echo $title." ".$type;exit;
        $db                 = JFactory::getDbo();
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName(array('id','title','introtext')));
        $query              ->from($db->quoteName('#__content'));
        if($type=="Moon")
        {
            $query              ->where($db->quoteName('title').'='.$db->quote($title." Sign"));
        }
        else if($type=="Nakshatra")
        {
            $query              ->where($db->quoteName('title').'='.$db->quote($title." Nakshatra")); 
        }
        else if($type=="male")
        {
            $query              ->where($db->quoteName('title').'='.$db->quote($title." Ascendant Males")); 
        }
        else if($type=="female")
        {
            $query              ->where($db->quoteName('title').'='.$db->quote($title." Ascendant Females")); 
        }
        $db                 ->setQuery($query);
        $result             = $db->loadAssoc();

        return $result;
    }
    /*
     * Get sunrise and sunset timings
     * @param date The date for which sunrise and sunset need to be found
     * @param timezone The timezone for location whose sunrise and sunset need to be found
     * @param num The number of days for which sunrise and sunset need to be found
     * @return array The array with sunrise and sunset values
     */
    public function getSunTimings($date, $timezone,$lat,$lon,$alt, $num)
    {
        $dtz            = new DateTimeZone($timezone); //Your timezone
        $date           = new DateTime($date, $dtz);
        $date           ->sub(new DateInterval('P1D'));
        //echo $date->format('d.m.Y H:i:s');exit;        
        $date           = $date->format('d.m.Y');
        $h_sys = 'P';
        $output = "";
        //echo $utcTimestamp;exit;
        //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';
        exec ("swetest -b$date -geopos$lon,$lat,$alt -rise -hindu -p0 -n$num -head", $output);
        $timings        = $output;$i = 0;
        $sun            = array();
        foreach($timings as $result)
        {
            if($i == 0){$i++;continue;}
            else{
                    
                $result      = $this->convertToLocal("sun",$i, $result, $timezone);
                $sun         = array_merge($sun, $result);$i++;
            } 
        }
        return $sun;
    }
    /*
     * Get moonrise and moonset timings
     * @param date The date for which moonrise and moonset need to be found
     * @param timezone The timezone for location whose moonrise and moonset need to be found
     * @param num The number of days for which moonrise and moonset need to be found
     * @return array The array with moonrise and moonset values
     */
    public function getMoonTimings($date, $timezone,$lat,$lon,$alt, $num)
    {
        $dtz            = new DateTimeZone($timezone); //Your timezone
        $date           = new DateTime($date, $dtz);
        $date->sub(new DateInterval('P1D'));
        //echo $date->format('d.m.Y H:i:s');exit;        
        $date           = $date->format('d.m.Y');
        $h_sys = 'P';
        $output = "";
        exec ("swetest -b$date -geopos$lon,$lat,$alt -rise -hindu -p1 -n$num -head", $output);
        //print_r($output);exit;
        $timings        = $output;$i = 0;
        $moon           = array();
        foreach($timings as $result)
        {
            if($i == 0){$i++;continue;}
            else{
               $result      = $this->convertToLocal("moon",$i, $result, $timezone);
                $moon         = array_merge($moon, $result);$i++;
            } 
        }
        return $moon;
    }
    /*
     * Function converts UTC time output of sunrise, moonrise, sunset, moonset to local time
     * @param planet Name of planet whose rise and set times need to be calculated
     * @param num Number allows to sort dates. example: date_1, date_2, date_3
     * @param times The date and time of rise and set
     * @param timezone The timezone of the location
     * @return array Array with localized time returned  
     */
     public function convertToLocal($planet,$num, $times, $timezone)
    {
        date_default_timezone_set('UTC');
        $split              = explode("rise",$times);
        $split              = explode("set",$split[1]);
        $rise               = str_replace(".","-",$split[0]);$set            = str_replace(".","-",$split[1]);
        $rise               = str_replace(' ','',$rise);$set             = str_replace(' ','',$set);
        $rise               = substr(trim($rise),0,-2);$set             = substr(trim($set),0,-2);
        //echo $rise." ".$set;exit;
        $timezone           = new DateTimeZone($timezone);
        $date               = new DateTime($rise);
        $date1              = new DateTime($set);
        $date               ->setTimezone($timezone);
        $date1              ->setTimezone($timezone);
        $array              = array($planet."_rise_".$num=>$date->format('d-m-Y H:i:s'),$planet."_set_".$num=>$date1->format('d-m-Y H:i:s'));
        return $array;
    }
    protected function checkPlanetsInHouse($data, $num)
    {
        //print_r($data);exit;
        $asc                    = $this->calcDetails($data["Ascendant"]);
        $house_7                = $this->getHouseSign($asc, $num);
        $planets                = array("Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Neptune","Uranus","Pluto");
        $planets_in_house       = array(); 
        for($i = 1; $i< 13;$i++)
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

        $planets                = array("Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu","Neptune","Uranus","Pluto"); 
        foreach($planets as $planet)
        {
            $planet_sign        = $this->calcDetails($data[$planet]);
            if($planet =="Sun"|| $planet =="Moon"|| $planet=="Mercury"||$planet =="Venus"||$planet=="Neptune"||$planet=="Uranus"||$planet=="Pluto")
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
            else if($planet == "Mars")
            {
                $get_4th_sign   = $this->getHouseSign($planet_sign, 4);
                $get_7th_sign   = $this->getHouseSign($planet_sign, 7);
                $get_8th_sign   = $this->getHouseSign($planet_sign, 8);
                if($sign        == $get_4th_sign || $sign == $get_7th_sign || $sign == $get_8th_sign)
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
    public function getHouseDistance($asc, $planet)
    {
        $signs              = array("Aries"=>1,"Taurus"=>2,"Gemini"=>3,"Cancer"=>4,
                                    "Leo"=>5,"Virgo"=>6,"Libra"=>7,"Scorpio"=>8,
                                    "Sagittarius"=>9,"Capricorn"=>10,"Aquarius"=>11,"Pisces"=>12);
        $asc                = $signs[$asc];
        $planet             = $signs[$planet];
        if($asc > $planet)
        {
           $planet     = $planet + 12;
        }
        for($i=$asc;$i <= $planet;$i++)
        {
           $j++;       
        }   
        return $j;
    }    
}
?>
