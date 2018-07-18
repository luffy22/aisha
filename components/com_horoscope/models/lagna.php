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
        // Assigning the variables
        $fname          = $user_details['fname'];
        $gender         = $user_details['gender'];
        $dob            = str_replace("/","-",$user_details['dob']);
        $year           = date("Y",strtotime($dob));
        $tob            = $user_details['tob'];
        $pob            = $user_details['pob'];
        $lon            = $user_details['lon'];
        $lat            = $user_details['lat'];
        $tmz            = $user_details['tmz'];
        $dst            = $user_details['dst'];
        $uniq_id        = uniqid('horo_');
        
        $now            = date('Y-m-d_H:i:s');
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $columns        = array('uniq_id','fname','gender','dob','tob','pob','lon','lat','timezone','dst','query_date');
        $values         = array($db->quote($uniq_id),$db->quote($fname),$db->quote($gender),$db->quote($dob),$db->quote($tob),
                                $db->quote($pob),$db->quote($lon),$db->quote($lat),$db->quote($tmz),$db->quote($dst),$db->quote($now));
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
        
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('fname','gender','dob','tob','pob','lon','lat','timezone','dst')));
        $query          ->from($db->quoteName('#__horo_query'));
        $query          ->where($db->quoteName('uniq_id').' = '.$db->quote($horo_id));
        $db             ->setQuery($query);
        $db->execute();
        $result         = $db->loadAssoc();
        $fname          = $result['fname'];
        $gender         = $result['gender'];
        $dob            = $result['dob'];
        $tob            = $result['tob'];
        //echo $tob;exit;
        $pob            = $result['pob'];
        $lat            = explode(":",$result['lat']);
        if($lat[2]=="N")
        {
            $lat        = $lat[0].".".$lat[1];
        }
        else if($lat[2]=="S")
        {
            $lat        = "-".$lat[0].".".$lat[1];
        }
        $lon            = explode(":",$result['lon']);
        if($lon[2]=="E")
        {
            $lon        = $lon[0].".".$lon[1];
        }
        else if($lon[2]=="W")
        {
            $lon        = "-".$lon[0].".".$lon[1];
        }
        
        $tmz            = explode(":",$result['timezone']);
        $tmz            = $tmz[0].".".(($tmz[1]*100)/60); 
        

        $birthDate = new DateTime($dob." ".$tob);
        //echo $birthDate->format('Y-m-d H:i:s'); exit;;
        //$timezone = +5.50; 

        /**
         * Converting birth date/time to UTC
         */
        $offset = $tmz * (60 * 60);
        $birthTimestamp = strtotime($birthDate->format('Y-m-d H:i:s'));
        $utcTimestamp = $birthTimestamp - $offset;
        //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';

        $date = date('d.m.Y', $utcTimestamp);
        $time = date('H:i:s', $utcTimestamp);
        
        $h_sys = 'P';
        $output = "";
// More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        exec ("swetest -edir$libPath -b$date -ut$time -p0123456789DAmt -sid1 -eswe -house$lon,$lat,$h_sys -fPls -g, -head", $output);


        # OUTPUT ARRAY
        # Planet Name, Planet Degree, Planet Speed per day
        $planets        = $this->getPlanets($output);
        $results         = array_merge($result, $planets);
        return $results;
        //var_dump($output);
    }
    
    public function getPlanets($data)
    {
        //print_r($data);exit;
        $graha_12               = array("Sun","Moon","Mercury","Venus","Mars","Jupiter","Saturn","Uranus","Neptune","Pluto","mean Node","Ascendant");
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
                        $ketu           = $dist+180;
                        if($ketu>359)
                        {
                            $ketu       = $ketu-360;
                        }
                        $ketu               = array("Ketu"=>$ketu.":r");
                       
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
        $planet_details             = $this->getDetails($planets);
        return $planet_details;
    }
    /*
     * Get The Greenwich Mean Time from given time
     * @param dob  Date Of Birth
     * @param tob Time Of Birth
     * @param tmz  Default Time Zone of the place
     * @param dst If any daylight saving time is to be applied
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
       
    // converting decimal to degree for example 12.22 = 12 deg 22 min 30 sec
    public function convertDecimalToDegree($dec)
    {
         // Converts decimal format to DMS ( Degrees / minutes / seconds ) 
        $vars = explode(".",$dec);
        $deg = $vars[0]%30;
        $tempma = "0.".$vars[1];

        $tempma = $tempma * 3600;
        $min = floor($tempma / 60);
        $sec = round($tempma - ($min*60),0);

        return $deg."&deg;".$min."'".$sec."''";
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
        $deg            = ($deg1+360)-$deg2;
        else
        $deg            = $deg1 - $deg2;
        $min            = $min1-$min2;
        $sec            = $sec1-$sec2;
        $value          = $deg.":".$min.":".$sec;
        return $value;
    }
    
    public function getAddSubTime($date,$val1,$val2,$sign)
    {

        $val2           = explode(":",date('G:i:s',$val2));
        $date           = new DateTime($date);
        $date           ->setTimestamp($val1);
        if($sign=="-")
        {
            $date           ->sub(new DateInterval('PT'.$val2[0].'H'.$val2[1].'M'.$val2[2].'S'));
        }
        else if($sign=="+")
        {
            $date           ->add(new DateInterval('PT'.$val2[0].'H'.$val2[1].'M'.$val2[2].'S'));
        }
        return $date->format('H:i:s');
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
    // Calculate Distance travelled in sign
    public function calcDistance($planet)
    {
        
        $details        = explode(":", $planet);
        $sign_num       = intval($details[0]%30);
        return $sign_num."&deg;".$details[1]."'";
    }
    // method to get planet details
    // planetary lord, nakshatra, nakshatra lord
    public function getPlanetaryDetails($planet,$sign,$distance)
    {
        $distance      = str_replace("&deg;",".",$distance);
        $distance      = str_replace("'","",$distance);

        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('sign_lord','nakshatra','nakshatra_lord')));
        $query          ->from($db->quoteName('#__nakshatras'));
        $query          ->where($db->quoteName('sign').'='.$db->quote($sign).' AND '.
                                $db->quote($distance).' BETWEEN '.
                                $db->quoteName('down_deg').' AND '.
                                $db->quoteName('up_deg'));
        $db             ->setQuery($query);
        $result         = $db->loadAssoc();
        $data           = array($planet."_sign_lord"=>$result['sign_lord'],
                                $planet."_nakshatra"=>$result['nakshatra'],
                                $planet."_nakshatra_lord"=>$result['nakshatra_lord']);
        return $data;
    }
    // Method to get the sidereal Time. New method converts time to gmt as sidereal time is for gmt 00:00:00 hrs
    public function getSiderealTime($data)
    {
        print_r($data);exit;
        $lon                = explode(":", $data['lon']);
        $dob                = $data['dob'];
        $gmt_time           = explode(':',$data['gmt_time']);

        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              -> select($db->quoteName('sid_time'));
        $query              -> from($db->quoteName('#__ephemeris'));
        $query              -> where($db->quoteName('full_year').'='.$db->quote($dob));
        $db                 ->setQuery($query);
        $count              = count($db->loadResult());
        $sidereal_12am      =$db->loadAssoc();
        //print_r($sidereal_12am);exit;
        $date               = new DateTime($dob);
        $date               ->setTime('00','00','00');
        $date1              = new DateTime($dob);
        $date1              ->setTime($gmt_time[0],$gmt_time[1],$gmt_time[2]);
        
        $interval           = $date->diff($date1);
        $interval           = explode(":", $interval->format('%H:%i'));
        $diff_hr            = $interval[0];$diff_min    = $interval[1];
        
        $query              ->clear();
        $query              ->select($db->quoteName('min'));
        $query              ->from($db->quoteName('#__sidereal_4'));
        $query              ->where($db->quoteName('hour').'='.$db->quote($diff_hr));
        $db                 ->setQuery($query);
        $result             = $db->loadAssoc();
        $diff               = explode(":",$result['min']);
        
        $date1               ->add(new DateInterval('PT'.$diff[0].'M'.$diff[1].'S'));
        //echo $date1->format('Y-m-d H:i:s');exit;
        $query                  ->clear();
        $query                  ->select($db->quoteName('diff'));
        $query                  ->from($db->quoteName('#__sidereal_5'));
        $query                  ->where($db->quoteName('min').'>='.$db->quote($diff_min));
        $db                     ->setQuery($query);
        unset($result);
        $result                 = $db->loadAssoc();
        $diff                   = explode(":",$result['diff']);
        $date1                  ->add(new DateInterval('PT'.$diff[1].'S'));
        print_r($date1);exit;
        return $date1;
    }
    public function getLmt($data)
    {
        //print_r($data);exit;
        $lon        = explode(":", $data['lon']);        // longitude
        $lat        = explode(":", $data['lat']);       // latititude
        $tmz        = substr($data['tmz'],1);           // timezone to calculate
        $dob        = $data['dob'];
        $tob        = explode(":",$data['tob']);
        $tmz        = explode(":",$tmz);
        $date       = new DateTime($dob);
        $date       ->setTime($tob[0],$tob[1],$tob[2]);
        
        // Next 5 lines get the prime meridian for place
        // For example 82:30 for India. 
        $gmt_meridian       = $tmz[0] + number_format(($tmz[1]/60),2);
        $gmt_meridian       = $gmt_meridian*15;
        $gmt_meridian1      = intval($gmt_meridian);
        $gmt_meridian2      = ($gmt_meridian - $gmt_meridian1)*60;
        $gmt_meridian       = $gmt_meridian1.":".$gmt_meridian2;
        
        $std_meridian       = explode(":",$gmt_meridian);
        
        $std_lon_sec	= $this->convertDegMinToSec($std_meridian[0], $std_meridian[1]);		// convert minutes into seconds & multiply by 4 then add to seconds multiplied by 4
        $loc_lon_sec	= $this->convertDegMinToSec($lon[0],$lon[1]);			// convert minutes into seconds & multiply by 4 then add to seconds multiplied by 4
        if($std_lon_sec > $loc_lon_sec)
        {
            $new_diff	= $std_lon_sec - $loc_lon_sec;
            $date       ->sub(new DateInterval('PT'.$new_diff.'S'));
        }
        else
        {
            $new_diff	= $loc_lon_sec	- $std_lon_sec;
            $date       ->add(new DateInterval('PT'.$new_diff.'S'));
        }
        return $date;
        
    }
    protected function convertPlanets($data)
    {
       //print_r($data);exit;
       $key        = array_keys($data);
       $planets    = array();
       for($i=0;$i<count($data);$i++)
       {
           $value           = $data[$key[$i]];
           if(strpos($value, "AR"))
           {
               $value       = "1.".str_replace("AR",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else if(strpos($value, "TA"))
           {
               $value       = "2.".str_replace("TA",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else if(strpos($value, "GE"))
           {
               $value       = "3.".str_replace("GE",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else if(strpos($value, "CN"))
           {
               $value       = "4.".str_replace("CN",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else if(strpos($value, "LE"))
           {
               $value       = "5.".str_replace("LE",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else if(strpos($value, "VI"))
           {
               $value       = "6.".str_replace("VI",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else if(strpos($value, "LI"))
           {
               $value       = "7.".str_replace("LI",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else if(strpos($value, "SC"))
           {
               $value       = "8.".str_replace("SC",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else if(strpos($value, "SG"))
           {
               $value       = "9.".str_replace("SG",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else if(strpos($value, "CP"))
           {
               $value       = "10.".str_replace("CP",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else if(strpos($value, "AQ"))
           {
               $value       = "11.".str_replace("AQ",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else if(strpos($value, "PI"))
           {
               $value       = "12.".str_replace("PI",".",$value);
               $val         = array($key[$i] => $value);
               $planets     = array_merge($planets, $val);
           }
           else
           {
               //echo "Something went wrong. Please contact admin@astroisha.com";
           }
       }
      return $planets;
    }
    public function calculatelagna($data)
    {
        $sid_time       = $this->justcall();
        /*$lat            = explode(":",$data['lat']);
        $dir            = $lat[2];
        $lat            = $lat[0].'.'.$lat[1];
        $dst            = strtotime($data['dst']);
        //echo $this->getSiderealTime($data)."<br/>";
        //echo $this->getLmt($data);exit;
        $sidtime        = strtotime($this->getSiderealTime($data));
       	$lmt            = strtotime($this->getLmt($data));
        $dob            = $data['dob'];
        
        $doy            = explode("-",$dob);
        $tob            = strtotime($data['tob']);
        
        $date           = new DateTime($dob);
        $date           ->setTimestamp($tob);
        $tob_format     = $date->format('g:i a');
        if(strpos($tob_format,"pm"))
        {
            $dateObject = $this->getAddSubTime($dob,$sidtime,$lmt,"+");
        }
        else
        {
            $dateObject = $this->getAddSubTime($dob,$sidtime,$lmt,"-");
        }
        $dateObject     = $this->getAddSubTime($dob, strtotime($dateObject), $dst, "-");
        //echo $dateObject;exit;
        if($dir == "S")
        {
            $noon           = strtotime('12:00:00');
            $date           = strtotime($dateObject);
            $dateObject     = $this->getAddSubTime($dob, $date, $noon, "+");
        }
        else
        {
            $dateObject     = $dateObject;
        }
        //echo $dateObject;exit;
        $dat_hr         = explode(":",$dateObject);
        $corr_sid_hr    = $dat_hr[0];
        $corr_sid_min   = $dat_hr[1];
        $corr_sid_sec   = $dat_hr[2];
        
        if($corr_sid_min%4 =="0")
        {
            $up_min     = $corr_sid_min+4;
            $down_min   = $corr_sid_min;
        }
        else
        {
            $up_min     = ceil($corr_sid_min/4)*4;
            $down_min   = floor($corr_sid_min/4)*4;
        }
        if($up_min=="60")
        {
            $corr_sid_hr    = $corr_sid_hr+1;
            $up_min         = $up_min-60;
        }
        //echo $up_min.":".$down_min;exit;
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('lagna_sign','lagna_degree','lagna_min')));
        $query          ->from($db->quoteName('#__lahiri_7'));
        $query          ->where($db->quoteName('latitude').'<='.$db->quote($lat).
                                'AND'.$db->quoteName('hour').'='.$db->quote($corr_sid_hr).'AND'.
                                 $db->quoteName('minute').'='.$db->quote($up_min));
        $query          ->order($db->quoteName('latitude').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
       
        $up_lagna       = $db->loadAssoc();
        $up_sign        = $up_lagna['lagna_sign'];
        $up_deg         = $up_lagna['lagna_degree'];
        $up_min         = $up_lagna['lagna_min'];
        //echo $up_sign.":".$up_deg.":".$up_min."<br/>";
        $query          ->clear();
        $query          ->select($db->quoteName(array('lagna_sign','lagna_degree','lagna_min','hour','minute')));
        $query          ->from($db->quoteName('#__lahiri_7'));
        $query          ->where($db->quoteName('latitude').'<='.$db->quote($lat).
                                'AND'.$db->quoteName('hour').'='.$db->quote($corr_sid_hr).'AND'.
                                 $db->quoteName('minute').'='.$db->quote($down_min));
        $query          ->order($db->quoteName('latitude').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $down_lagna     = $db->loadAssoc();
        $down_sign      = $down_lagna['lagna_sign'];
        $down_deg       = $down_lagna['lagna_degree'];
        $down_min       = $down_lagna['lagna_min'];
        $down_hr        = $down_lagna['hour'];
        $down_min       = $down_lagna['minute'];
        //echo $down_sign.":".$down_deg.":".$down_min;exit;
        // Difference between upper value and lower value of lagna
        $diff1                  = ((($up_sign*30*60)+($up_deg*60)+$up_min)-(($down_sign*30*60)+($down_deg*60)+$down_min));
        //echo $diff1;exit;
        $diff2                  = ((($corr_sid_hr*3600)+($corr_sid_min*60)+($corr_sid_sec))-(($down_hr*3600)+($down_min*60)));
        //echo $diff2;exit;
        // Exact degree, minutes, seconds at sidereal time in decimal
        $diff                   = round((($diff1*$diff2)/240),2);
        $diff                   = explode(":",$this->convertDecimalToDegree($diff));
        $diff                   = explode(":",$this->addDegMinSec($down_deg,$down_min,0,$diff[0],$diff[1],$diff[2]));
        //$diff                   = $this->convertSignDegMinSec($down_sign,$diff[0],$diff[1],$diff[2]);
        
       //echo $lagna_acc_sign.":".$lagna_acc_deg.":".$lagna_acc_min.":".$lagna_acc_sec;exit;
        $year                   = $doy[0];

        $query                  ->clear();
        $query                  = "SELECT correction FROM jv_lahiri_5 WHERE Year='".$year."'";
        $db                     ->setQuery($query);
        $count                  = count($db->loadResult());
        
        $get_ayanamsha          = $db->loadAssoc();
        $ayanamsha_corr		= explode(":", $get_ayanamsha['correction']);
        $sign                   = substr($get_ayanamsha['correction'],0, 1);
        $diff[0]                = ($down_sign*30)+$diff[0];
        //echo $diff[0];exit;
        
        if($sign=="-")
        {
            $lagna              = $this->subDegMinSec($diff[0],$diff[1],$diff[2],$ayanamsha_corr[0],$ayanamsha_corr[1],0);
        }
        else
        {
            $lagna              = $this->addDegMinSec($diff[0],$diff[1],$diff[2],$ayanamsha_corr[0],$ayanamsha_corr[1],0);
        }
        //echo $lagna_acc_sign." ".$lagna_acc_deg." ".$lagna_acc_min." ".$lagna_acc_sec;exit;
        //echo $lagna;exit;
        $lagna_sign         = explode(":",$lagna);
        //$data            = array("name"=>$this->fname,"gender"=>$this->gender,
        if($dir == "S")
        {
            $lagna_sign[0]              = $lagna_sign[0]+180;
            if($lagna_sign[0]>360)
            {
                $lagna_sign[0]          = $lagna_sign[0]-360;
            }
            $lagna              = $lagna_sign[0].":".$lagna_sign[1].":".$lagna_sign[2];
        } 
        else
        {
            if($lagna_sign[0]>360)
            {
                $lagna_sign[0]          = $lagna_sign[0]-360;
            }
            $lagna              = $lagna_sign[0].":".$lagna_sign[1].":".$lagna_sign[2];
        }
        $lagna_sign         = $this->calcDetails($lagna);
        $lagna_distance     = $this->calcDistance($lagna);
        $lagna_details      = $this->getPlanetaryDetails("lagna",$lagna_sign,$lagna_distance);
        $lagna              = array("lagna"=>$lagna,"lagna_sign"=>$lagna_sign,
                                    "lagna_distance"=>$lagna_distance);
        $lagna              = array_merge($lagna, $lagna_details);
        return $lagna;*/
    }
    
    protected function getWesternHoro($data)
    {
        //print_r($data);exit;
        //$lagna          = $this->calculatelagna($data);
        $dob            = $data['gmt_date'];
        $tob            = explode(":",$data['gmt_time']);
        
        $grahas         = array();
        $planets        = array("full_year","sun","moon","mercury","venus","mars","jupiter","saturn","rahu","uranus","neptune","pluto");
        $count          = count($planets);
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName($planets));
        $query          ->from($db->quoteName('#__ephemeris'));
        $query          ->where($db->quoteName('full_year').'='.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result1        = $db->loadAssoc();
        $result1        = $this->convertPlanets($result1);
        
        $query          ->clear();
        $query          ->select($db->quoteName($planets));
        $query          ->from($db->quoteName('#__ephemeris'));
        $query          ->where($db->quoteName('full_year').'>'.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' asc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result2        = $db->loadAssoc();
        $result2        = $this->convertPlanets($result2);
        //print_r($result2);exit;
        for($i=1;$i<$count;$i++)
        {
            $planet         = $planets[$i];
            $down_deg       = explode(".",$result1[$planet]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
            $up_deg         = explode(".",$result2[$planet]);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
            (double)$down_deg       = ((double)$down_deg[0]*30+$down_deg[1]).".".$down_deg[2];
            (double)$up_deg         = ((double)$up_deg[0]*30+$up_deg[1]).".".$up_deg[2];
            $down_val               = explode(".",$down_deg);
            $up_val                 = explode(".", $up_deg);
         
            //echo $planet."  ".$up_deg." : ".$down_deg."<br/>";exit;
            if($up_deg < $down_deg)
            {
                $diff               = explode(":", $this->subDegMinSec($down_val[0], $down_val[1], 0, $up_val[0], $up_val[1], 0));
            }
            else
            {
                $diff               = explode(":", $this->subDegMinSec($up_val[0], $up_val[1], 0, $down_val[0], $down_val[1], 0));
            }
            $deg                = $diff[0];
            $min                = $diff[1];
            if($min < 10)
            {
                $min            = "0".$min;
            }
            
            $query          ->clear();
            $query          ->select($db->quoteName(array("value")));
            $query          ->from($db->quoteName('#__raman_log'));
            $query          ->where($db->quoteName('degree').'='.$db->quote($deg).'AND'.
                                    $db->quoteName('min')."=".$db->quote($min));
            $db             ->setQuery($query);
            $result3         = $db->loadAssoc();
            
            $tob_deg        = $tob[0];
            $tob_min        = $tob[1];
            $query          ->clear();
            $query          ->select($db->quoteName(array("value")));
            $query          ->from($db->quoteName('#__raman_log'));
            $query          ->where($db->quoteName('degree').'='.$db->quote($tob_deg).'AND'.
                                    $db->quoteName('min')."=".$db->quote($tob_min));
            $db             ->setQuery($query);
            $result4        = $db->loadAssoc();
            
            $value1         = $result3["value"];
            $value2         = $result4["value"];
            
            $result         = number_format(($value1 + $value2),4);
            
            $query          ->clear();
            $query          ->select($db->quoteName(array('degree','min')));
            $query          ->from($db->quoteName('#__raman_log'));
            $query          ->where($db->quoteName('value').'<='.$db->quote($result));
            $query          ->order($db->quoteName('value').' desc');
            $query          ->setLimit('1');
            $db             ->setQuery($query);
            $result5        = $db->loadAssoc();
            $diff           = $result5["degree"].".".$result5["min"];
            
            if($up_deg < $down_deg)
            {
                if($result5['min'] < 10)
                {
                    $diff   = $result5['degree'].'.0'.$result5['min'];
                }
                $distance       = ($down_deg - $diff)-30.00;
                $dist           = explode(".",$distance);
                $distance       = $this->convertDegMinSec($dist[0], $dist[1], 0);
                $graha          = array($planet=>$distance.":r");
            }
            else
            {
                if($result5['min'] < 10)
                {
                    $diff   = $result5['degree'].'.0'.$result5['min'];
                }
                $distance       = ($down_deg + $diff)-30.00;
                $dist           = explode(".",$distance);
                $distance       = $this->convertDegMinSec($dist[0], $dist[1], 0);
                $graha          = array($planet=>$distance);
            }
                                  
            if($i==8)
            {
                $distance       = str_replace(":",".",$distance);
                $ketu           = $distance+180;
                if($ketu>360)
                {
                    $ketu       = $ketu-360;
                }
                $ketu               = array("ketu"=>str_replace(".",":",$ketu.":r"));
                $graha              = array_merge($graha, $ketu);
            }  
            
            $grahas             = array_merge($grahas, $graha);                 
        }   
       //$grahas                 = $this->getAyanamshaCorrection($dob, $grahas);
       return $grahas;       
       //$data                    = array_merge($data, $grahas);
       //return $data;
    }
    protected function getDetails($data)
    {
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
            $dist           = $this->convertDecimalToDegree(str_replace(":r","",$distance));
            $dist_det           = array($key."_dist"=>$dist);
            
            //echo $key." ".$sign." ".$dist."<br/>";
            $details        = $this->getPlanetaryDetails($key, $sign, $dist);
            $graha[]          = array_merge($sign_det,$dist_det,$status,$details);
        }
        return $graha;
    }

    public function getAscendantId($gender,$sign)
    {
        if($sign=="Aries"&&$gender=="female")
        {
           $id      =   103;
        }
        else if($sign=="Aries"&&$gender=="male")
        {
            $id     =   102;
        }
        else if($sign=="Taurus"&&$gender=="female")
        {
            $id     =   104;
        }
        else if($sign=="Taurus"&&$gender=="male")
        {
            $id     =   105;
        }
        else if($sign=="Gemini"&&$gender=="female")
        {
            $id     =   106;
        }
        else if($sign=="Gemini"&&$gender=="male")
        {
            $id     =   107;
        }
        else if($sign=="Cancer"&&$gender=="female")
        {
            $id     =   108;
        }
        else if($sign=="Cancer"&&$gender=="male")
        {
            $id     =   109;
        }
        else if($sign=="Leo"&&$gender=="female")
        {
            $id     =   110;
        }
        else if($sign=="Leo"&&$gender=="male")
        {
            $id     =   111;
        }
        else if($sign=="Virgo"&&$gender=="female")
        {
            $id     =   114;
        }
        else if($sign=="Virgo"&&$gender=="male")
        {
            $id     =   115;
        }
        else if($sign=="Libra"&&$gender=="female")
        {
            $id     =   116;
        }
        else if($sign=="Libra"&&$gender=="male")
        {
            $id     =   117;
        }
        else if($sign=="Scorpio"&&$gender=="female")
        {
            $id     =   118;
        }
        else if($sign=="Scorpio"&&$gender=="male")
        {
            $id     =   119;
        }
        else if($sign=="Sagittarius"&&$gender=="female")
        {
            $id     =   120;
        }
        else if($sign=="Sagittarius"&&$gender=="male")
        {
            $id     =   121;
        }
        else if($sign=="Capricorn"&&$gender=="female")
        {
            $id     =   123;
        }
        else if($sign=="Capricorn"&&$gender=="male")
        {
            $id     =   124;
        }
        else if($sign=="Aquarius"&&$gender=="female")
        {
            $id     =   125;
        }
        else if($sign=="Aquarius"&&$gender=="male")
        {
            $id     =   126;
        }
        else if($sign=="Pisces"&&$gender=="female")
        {
            $id     =   127;
        }
        else if($sign=="Pisces"&&$gender=="male")
        {
            $id     =   128;
        }
        return $id;
    }
    public function getArticle($title, $type)
    {
        $type               = trim($type);
        //print_r($details);exit;
        $gender             = $details['gender'];
        $lagna              = $this->calculatelagna($details);
        $sign               = $lagna['lagna_sign'];
        $id                 = $this->getAscendantId($gender,$sign);
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
        $db                 ->setQuery($query);
        $result             = $db->loadAssoc();
        
        return $result;
    }
   
    
}
?>
