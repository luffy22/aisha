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
            $tmz            = $this->getTimeZone($lat, $lon, $timestamp);
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
        $columns        = array('uniq_id','fname','gender','dob_tob','pob','lon','lat','timezone','query_date');
        $values         = array($db->quote($uniq_id),$db->quote($fname),$db->quote($gender),$db->quote($dob_tob),
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
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $horo_id        = $jinput->get('chart', 'default_value', 'filter');
        $horo_id        = str_replace("chart","horo",$horo_id);
        
        $result         = $this->getUserData($horo_id);
        //print_r($result);exit;
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
        // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m789 -g, -head", $output);
        //print_r($output);exit;

        # OUTPUT ARRAY
        # Planet Name, Planet Degree, Planet Speed per day
        $asc            = $this->getAscendant($result);
        $planets        = $this->getPlanets($output);
        $data           = array_merge($asc,$planets);
        $details        = $this->getDetails($data);
        //print_r($details);exit;
        $results         = array_merge($result, $details);
        return $results;
        //var_dump($output);
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
    protected function getTimeZone($lat, $lon, $timestamp)
    {
        $url = "https://maps.googleapis.com/maps/api/timezone/json?location=$lat,$lon&timestamp=$timestamp&key=AIzaSyDhhAMyimT-tgWJM6w8Aa7awXb73NrYsVA";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $responseJson = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($responseJson);
        //var_dump($response);
        $tmz_in_words   =  $response->timeZoneId;
        return $tmz_in_words;
    }
    protected function getUserData($horo_id)
    {
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('fname','gender','dob_tob','pob','lon','lat','timezone')));
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
        $sec = round($tempma - ($min*60),0);
        
        if($usage == "details")
        {
            if($min < 10){$min  = "0".$min;}
            return $deg.".".$min;
        }
        else
        {
            return $deg."&deg;".$min."'".$sec."''";
        }
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
   
    
}
?>
