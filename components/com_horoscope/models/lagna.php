    <?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
require_once JPATH_COMPONENT.'/controller.php';
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
        $now            = date('Y-m-d_H:i:s');
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $columns        = array('fname','gender','dob','tob','pob','lon','lat','timezone','dst','query_date');
        $values         = array($db->quote($fname),$db->quote($gender),$db->quote($dob),$db->quote($tob),
                                $db->quote($pob),$db->quote($lon),$db->quote($lat),$db->quote($tmz),$db->quote($dst),$db->quote($now));
        $query    ->insert($db->quoteName('#__horo_query'))
                    ->columns($db->quoteName($columns))
                    ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
        $db             ->setQuery($query);
        $result          = $db->query();
        
        // fetches the Indian standard time and Indian Date for the given time and birth
        $ind_det       = explode("_",$this->getISTTime($dob, $tob, $tmz, $dst));
        $ind_date       = $ind_det[0];
        $ind_time       = $ind_det[1];
        $ind_str        = strtotime($ind_time);
        if($year <= 2000)
        {
            $gmt        = '17:30:00';
            $gmt_str    = strtotime($gmt);
        }
        else
        {
            $gmt        = '00:00:00';
            $gmt_str    = strtotime($gmt);
        }
        $datetime1      = date_create(str_replace("/","-",$dob));
        $datetime2      = date_create($ind_date);
        $interval = date_diff($datetime1, $datetime2);
        $ind_sign       = $interval->format('%R:%a');
        if($ind_str>$gmt_str)
        {
            $diff       = "+".$this->getAddSubTime($dob,$ind_str,$gmt_str,"-");

        }
        else if($ind_str<$gmt_str)
        {
            $diff       = "-".$this->getAddSubTime($dob,$gmt_str,$ind_str,"-");
        }

        /* 
        *  @param fullname, gender, date of birth, time of birth, 
        *  @param longitude, latitude, timezone and
        *  @param timezone in hours:minutes:seconds format
        */ 
        $data  = array(
                        "fname"=>$fname,"gender"=>$gender,"dob"=>$dob,
                        "tob"=>$tob,"pob"=>$pob,"lon"=>$lon,"lat"=>$lat,"tmz"=>$tmz,
                        "tmz_hr"=>$gmt,"time_diff"=>$diff,"dst"=>$dst, 
                        "ind_date"=>$ind_date,"ind_time"=>$ind_time
                    );
        //print_r($data);exit;
        if($year <= 2000)
        {
            $this->data     = $this->getBudh($data);
        }
        else
        {
            $this->data     = $this->getRaman2050($data);
        }
        return $this->data;
    }
    /*
     * Get The Indian Standard Time from foreign time
     * @param dob  Date Of Birth
     * @param tob Time Of Birth
     * @param tmz  Default Time Zone of the place
     * @param dst If any daylight saving time is to be applied
     */
    public function getISTTime($dob,$tob,$tmz, $dst)
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
        
        $ist        = '+05:30';
        $ist_sign   = substr($ist,0, 1);
        $ist_val    = substr($ist.":00",1);
        $ist_str    = strtotime($ist_val);
        $ist_val    = explode(":", $ist_val);
        if($tmz_sign == '-')
        {
            $min        = $tmz_val[1] +$ist_val[1];
            $hr         = $tmz_val[0] + $ist_val[0];
            if($min >= 60)
            {
                $min    = $min - 60;
                $hr     = $hr + 1;
            }
            $date       ->add(new DateInterval('PT'.$hr.'H'.$min.'M0S'));
        }
        else if($tmz_sign == '+' && $tmz !== $ist && $ist_str < $tmz_str)
        {
            // timezeon is positive, timezone is not equal to indian time and indian time is less then timezone time
            if($tmz_val[1] >= $ist_val[1])
            {
                $min    = $tmz_val[1]   - $ist_val[1];
                $hr     = $tmz_val[0]   - $ist_val[0];
            }
            else
            {
                $min    = ($tmz_val[1]+60)  - $ist_val[1];
                $hr     = ($tmz_val[0] -1 ) - $ist_val[0];
            }
            $date       ->sub(new DateInterval('PT'.$hr.'H'.$min.'M0S'));
        }
        else if($tmz_sign == '+' && $tmz !== $ist && $ist_str > $tmz_str)
        {
            // timezone is positive, timezone is not equal to indian time and indian time is greater then timezone time
            if($ist_val[1] >= $tmz_val[1])
            {
                $min    = $ist_val[1]   - $tmz_val[1];
                $hr     = $ist_val[0]   - $tmz_val[0];
            }
            else
            {
                $min    = ($ist_val[1]+60)  - $tmz_val[1];
                $hr     = ($ist_val[0] -1 ) - $tmz_val[0];
            }
            $date       ->sub(new DateInterval('PT'.$hr.'H'.$min.'M0S'));
        }
        else if ($tmz_sign == '+' && $tmz == $ist && $ist_str == $tmz_str)
        {
            $date       ->sub(new DateInterval('PT0H0M0S'));
        }
        $date           ->sub(new DateInterval('PT'.$dst[0].'H'.$dst[1].'M'.$dst[2].'S'));
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
    // getting the differential transit when only hours and 
    // minutes are specified. Return value in Degree, Hours and Minute Format.
    public function getDiffTransit($hr,$min ,$intval, $intval2)
    {
        $transit    = ($hr*60*4)+($min*4);
        $intval     = $intval;
        $intval2    = $intval2;
        $transit    = round((($transit*$intval2)/$intval),2);
        $value      = $this->convertDecimalToDegree($transit);
        return $value;
    }
    // This one is for values which are already described in seconds
    // without converting values into seconds
    public function getDiffTransit2($val1, $val2, $intval)
    {
        $transit    = abs((($val1*$val2)/$intval));
        $value      = $this->convertDecimalToDegree($transit);
        return $value;
    }
    // converting decimal to degree for example 12.22 = 12 deg 22 min 30 sec
    public function convertDecimalToDegree($decimal)
    {
        $deg        = round(($decimal/(60*4)),4);
        $real_deg   = explode(".",$deg);
        $min        = abs(($deg-$real_deg[0])*60);
        $real_min   = explode(".", $min);
        $sec        = abs(($deg-$real_deg[0]-($real_min[0]/60))*3600);
        $real_sec   = explode(".", $sec);
        return $real_deg[0].":".$real_min[0].":".$real_sec[0];
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
    // divinding degree, minute and second by divisor
    public function divideDegMinSec($deg,$min,$sec,$divisor)
    {
        $new_deg        = intval($deg/$divisor);
        $deg_mod        = $deg%$divisor;
        $new_min        = $min+($deg_mod*60);
        $new_min        = intval($new_min/$divisor);
        $min_mod        = $min%$divisor;
        $sec            = $sec+($min_mod*60);
        $new_sec        = intval($sec/$divisor);
        
        $value          = $this->convertDegMinSec($new_deg, $new_min, $new_sec);
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
        $details        = explode(":", $planet);
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
    // Method to get the sidereal Time
    public function getSiderealTime($data)
    {
        //print_r($data);exit;
        $lon            = explode(":", $data['lon']);
        $dob            = explode("-",$data['dob']);
        $monthNum       = $dob[1];  // The month in number format (ex. 06 for June)
        $year           = $dob[0];
        $monthName      = date("F", mktime(0, 0, 0, $monthNum, 10));		// month in word format (ex. June/July/August)
        $leap           = date("L", mktime(0,0,$dob[2], $monthNum, $year));
        
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $query          -> select($db->quoteName('Sidereal'));
        $query          -> from($db->quoteName('#__lahiri_1'));
        $query          -> where($db->quoteName('Month').'='.$db->quote($monthName).'AND'.
                                 $db->quoteName('Date')."=".$db->quote($dob[2]));
        $db             ->setQuery($query);
        $count          = count($db->loadResult());
        $row            =$db->loadAssoc();
        //echo $row['Sidereal'];exit;
        if($count>0)
        {
            $get_sidetime_year      = strtotime($row['Sidereal']);
            $query      ->clear();
            if(($monthName == "January" || $monthName == "February")&&($leap=="1"))
            {
                $query      ->select($db->quoteName('corr_time'));
                $query      ->from($db->quoteName('#__lahiri_2'));
                $query      ->where($db->quoteName('Year').'='.$db->quote($dob[0]).' AND '.
                                    $db->quote('leap').'='.'leap');
            }
            else
            {
                $query      ->select($db->quoteName('corr_time'));
                $query      ->from($db->quoteName('#__lahiri_2'));
                $query      ->where($db->quoteName('Year').'='.$db->quote($dob[0]));
                //$query_sideyear			= mysqli_query($con, "SELECT corr_time FROM jv_sidereal_2 WHERE Year='".$dob_split[0]."'");
            }
            $db                 ->setQuery($query);
            unset($count);
            $count              = count($db->loadResult());
            
            $time_diff          = $db->loadAssoc();
            $correction         = $time_diff['corr_time'];      // correction time diff using sidereal_2 table
            $corr_diff          = substr($correction, 0,1);     // the positive/negative sign
            $corr_time		= substr($correction,1);        // the time diff in mm:ss format
            $corr_time          = strtotime("00:".$corr_time);        // corr_time string_to_time    
            $sid_time           = strtotime($this->getAddSubTime($data['dob'],$get_sidetime_year ,$corr_time,$corr_diff));
            //echo date('G:i:s',$sid_time);exit;
            $query              ->clear();
            $query              = "select corr_sign, st_correction FROM jv_sidereal_3 WHERE longitude >= '".($lon[0].'.'.$lon[1])."'
                                    order by abs(longitude - '".($lon[0].'.'.$lon[1])."') limit 1";
            $db                 ->setQuery($query);
            unset($count);
            $count              = count($db->loadResult());
            $sid_corr           = $db->loadAssoc();     // sidereal correction in seconds
            $corr_time          = str_replace(".",":",$sid_corr['st_correction']);
            $sign               = $sid_corr['corr_sign'];
            $corr_time          = strtotime("00:".$corr_time);
            $sidereal           = $this->getAddSubTime($data['dob'],$sid_time,$corr_time,$sign);           
        }
       return $sidereal;
    }
    public function getLmt($data)
    {
        //print_r($data);exit;
        $lon        = explode(":", $data['lon']);
        $lat        = explode(":", $data['lat']);
        $gmt        = substr($data['tmz'],1);
        $dob        = $data['dob'];
        $tob        = strtotime($data['tob']);
        
        $gmt        = explode(":",$gmt);
       
        $gmt_meridian       = $gmt[0] + number_format(($gmt[1]/60),2);
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
            //$new_diff	= gmdate('H:i:s', $new_diff);
            $diff           = strtotime(gmdate("G:i:s",$new_diff));     // gmdate is used for value below 24 hr
            $date           = strtotime($this->getAddSubTime($dob,$tob,$diff,"-"));
        }
        else
        {
            $new_diff	= $loc_lon_sec	- $std_lon_sec;
            //$new_diff	= gmdate('H:i:s', $new_diff);
            $diff           = strtotime(gmdate("G:i:s",$new_diff));     // gmdate is used for value below 24 hr
            $date           = strtotime($this->getAddSubTime($dob,$tob,$diff,"+"));
        }
        //echo $new_diff;exit;
        $dateObject		= new DateTime($dob);		// Datetime object with user date of birth
        $dateObject		->setTimeStamp($date);		// time of birth for user
        $tob_format		= $dateObject->format('g:i a');
        $noon_time          = strtotime('12:00:00');
        if(strpos($tob_format, "am"))
        {
            // if lmt is am then subtract that time from 12 at noon
            $date           = $this->getAddSubTime($dob,$noon_time,$date,"-");
        }
        else
        {
            $date           = $dateObject->format('G:i:s');
        }
        //echo $date;exit;
        $dateObject         = (strtotime($date));
        $lmt                = explode(":",$date);
        $lmt_hr             = $lmt[0];
        $lmt_min            = $lmt[1];
        $lmt_sec            = $lmt[2];
        //$lmt                = $lmt_hr*3600+$lmt_min*60+$lmt_sec;
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query                  ->select($db->quoteName('min'));
        $query                  ->from($db->quoteName('#__sidereal_4'));
        $query                  ->where($db->quoteName('hour').'='.$db->quote($lmt_hr));
        $db                     ->setQuery($query);
        $result                 = $db->loadAssoc();
        $count                  = count($result);
        //echo $count;exit;
        //echo $result['min'];exit;
        $min                    = strtotime("00:".$result['min']);
        $lmt                    = strtotime($this->getAddSubTime($dob,$dateObject,$min,"+"));
        $query                  ->clear();
        $query                  ->select($db->quoteName('diff'));
        $query                  ->from($db->quoteName('#__sidereal_5'));
        $query                  ->where($db->quoteName('min').'>='.$db->quote($lmt_min));
        $db                     ->setQuery($query);
        unset($result);
        $result                 = $db->loadAssoc();
        $diff                   = "00:".$result['diff'];
        $sec                    = strtotime($diff);
        $date                   = strtotime($this->getAddSubTime($dob,$lmt,$sec,"+"));
        $date                   = date('g:i:s',$lmt);
        return $date;
        
    }
    public function calculatelagna($data)
    {
        //print_r($data);exit;    
        $lat            = explode(":",$data['lat']);
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
        return $lagna;
    }
    protected function getMoonData($data)
    {
        //print_r($data);exit;
        $dob        = $data['ind_date'];
        $year       = date("Y", strtotime($dob));
        $db         = JFactory::getDbo();
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('yob','moon')));
        $query          ->from($db->quoteName('#__raman_moon2000'));
        $query          ->where($db->quoteName('yob').'<='.$db->quote($dob));
        $query          ->order($db->quoteName('yob').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $row            = $db->loadAssoc();
        $down_yob       = $row['yob'];
        
        $down_moon      = explode(".",$row['moon']);
        //echo $down_moon[0].":".$down_moon[1];exit;
        $query          ->clear();
        $query          ->select($db->quoteName(array('yob','moon')));
        $query          ->from($db->quoteName('#__raman_moon2000'));
        $query          ->where($db->quoteName('yob').'>'.$db->quote($dob));
        $query          ->order($db->quoteName('yob').' asc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);  
        $row1                = $db->loadAssoc();
        $up_yob             = $row1['yob'];
        $up_moon            = explode(".",$row1['moon']);
        //echo $down_yob.":".$up_yob;exit;
        $datetime1          = new DateTime($down_yob);
        $datetime2          = new DateTime($up_yob);
        $datetime3          = new DateTime($data['ind_date']);
        $interval           = $datetime1->diff($datetime2);
        $interval2          = $datetime1->diff($datetime3);
        $intval             = (int)$interval->format('%a');
        $intval2            = (int)$interval2->format('%a');
        //echo $intval;exit;
        //echo $up_moon[0].":".$up_moon[1]." vs ".$down_moon[0].":".$down_moon[1];exit;
        if($up_moon[0]<$down_moon[0])
        {
            $up_moon[0]         = $up_moon[0]+360;
            $diff               = explode(":",$this->subDegMinSec($up_moon[0],$up_moon[1],0,$down_moon[0],$down_moon[1],0));
        }
        else
        {
            $diff               = explode(":",$this->subDegMinSec($up_moon[0],$up_moon[1],0,$down_moon[0],$down_moon[1],0));
        }
        //echo $diff[0].":".$diff[1].":".$diff[2];exit;
        $day_transit        = explode(":",$this->divideDegMinSec($diff[0], $diff[1], $diff[2], $intval));
        if($intval2==0)
        {
            //echo $day_transit[0].":".$day_transit[1].":".$day_transit[2];exit;
            $total_transit      = explode(":",$down_moon[0].":".$down_moon[1].":00");
        }
        else
        {
            $total_transit      = explode(":",$this->addDegMinSec($down_moon[0], $down_moon[1], 0, $day_transit[0], $day_transit[1], $day_transit[2]));
        }
        //echo $total_transit[0].":".$total_transit[1].":".$total_transit[2];exit;
        $day_transit        = $day_transit[0]*60*4+$day_transit[1]*4;
        unset($sign);   // unset variable to reset it

        $time_diff          = substr($data['time_diff'],1);
        $sign               = substr($data['time_diff'],0,1);
        $time_diff          = explode(":",$time_diff);
        $time_diff          = $time_diff[0]*3600+$time_diff[1]*60+$time_diff[2];
        $intval             = 24*3600;
        $hr_transit         = explode(":",$this->getDiffTransit2($day_transit, $time_diff, $intval));
        //echo $hr_transit[0].":".$hr_transit[1].":".$hr_transit[2];exit;
        if($sign == "+")
        {
            $actual_transit    = explode(":",$this->addDegMinSec($total_transit[0], $total_transit[1], $total_transit[2], $hr_transit[0], $hr_transit[1], $hr_transit[2]));
        }
        else if($sign == "-")
        {
            $actual_transit    = explode(":",$this->subDegMinSec($total_transit[0], $total_transit[1], $total_transit[2], $hr_transit[0], $hr_transit[1], $hr_transit[2]));
        }
        //echo $actual_transit[0].":".$actual_transit[1].":".$actual_transit[2];exit;
        //$actual_transit         = round($actual_transit/(4*60),2);
        $date1  = null;
        unset($date1);
        $query                  ->clear();
        $query                  ->select($db->quoteName('ayanamsha'))
                                ->from($db->quoteName('#__lahiri_ayanamsha'))
                                ->where($db->quoteName('year').'<='.$db->quote($year))
                                ->order($db->quoteName('year').' desc')
                                ->setLimit('1');
        $db->setQuery($query);
        $result                 = $db->loadAssoc();
       
        $ayanamsha              = explode(":",$result['ayanamsha']);
     
        if($actual_transit[0]<$ayanamsha[0])
        {
            $actual_transit[0]  = $actual_transit[0]+360;
        }
        $moon               = $this->subDegMinSec($actual_transit[0], $actual_transit[1], $actual_transit[2], $ayanamsha[0], $ayanamsha[1], 0);
        $moon_sign          = $this->calcDetails($moon);
        $moon_distance      = $this->calcDistance($moon);
        $moon_details       = $this->getPlanetaryDetails("moon",$moon_sign,$moon_distance);
        $moon               = array("moon"=>$moon,"moon_sign"=>$moon_sign,
                                    "moon_distance"=>$moon_distance);
        $moon               = array_merge($moon, $moon_details);
        return $moon;
    }
    protected function calculate7Planets($data)
    {
        //print_r($data);exit;
        $dob        = $data['ind_date'];
        $year       = date("Y", strtotime($data['ind_date']));

        $seven_planets     = array();
        $planets    = array("full_year","surya","mangal","guru","shukra","shani","rahu");
        $count          = count($planets);
        // getting lower value
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName($planets));
        $query          ->from($db->quoteName('#__raman_planets2000'));
        $query          ->where($db->quoteName('full_year').'<='.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result1        = $db->loadAssoc();
        $down_year      = $result1['full_year'];
        //print_r($result1);
        $query          ->clear();
        $query          ->select($db->quoteName($planets));
        $query          ->from($db->quoteName('#__raman_planets2000'));
        $query          ->where($db->quoteName('full_year').'>'.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' asc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result2        = $db->loadAssoc();
        $up_year        = $result2['full_year'];
        //print_r($result2);exit;
        //echo $up_deg.":".$down_deg;exit;
        $datetime1          = new DateTime($down_year);          // lower value of year
        $datetime2          = new DateTime($up_year);           // upper value of year
        $datetime3          = new DateTime($data['ind_date']);       // exact dob
        $interval           = $datetime1->diff($datetime2);     // get difference
        $intval             = (int)$interval->format('%a');     // format in int example 2
        $interval1          = $datetime1->diff($datetime3);
        $intval2            = (int)$interval1->format('%a'); 
        for($i=1;$i<$count;$i++)
        {
            $planet         = $planets[$i];         // planet eg. sun, moon etc
            $down_deg       = $result1[$planet];        // lower value of planet
            $up_deg         = $result2[$planet];        // upper value of planet
            $down_val       = explode(".",$down_deg);
            $up_val         = explode(".",$up_deg);
            // checks if difference between lower and upper value is greater then 300.
            // In other words if lower value is in pisces sign(360) and upper value is aries sign(0)
            if($up_deg<$down_deg && intval($up_deg-$down_deg)>300)      
            {
                $up_val[0]      = $up_val[0]+360;      // adds 360 degree to upper value if it is aries sign and lower value in pisces sign 
                $diff           = explode(":",$this->subDegMinSec($up_val[0],$up_val[1],0,$down_val[0],$down_val[1],0));
            }
            else
            {
                $diff           = explode(":",$this->subDegMinSec($up_val[0],$up_val[1],0,$down_val[0],$down_val[1],0));
            }
            //echo $diff[0].":".$diff[1].":".$diff[2];exit;
            $day_transit        = explode(":",$this->divideDegMinSec($diff[0], $diff[1], $diff[2], $intval));       // one day transit
            $diff               = $diff[0]*60*4+$diff[1]*4;
            //echo $day_transit[0].":".$day_transit[2].":".$day_transit[2];exit;
            if($intval2!==0)
            {
                $dob_transit        = explode(":",$this->getDiffTransit2($diff,$intval2, $intval));
                $dob_transit        = explode(":",$this->addDegMinSec($down_val[0], $down_val[1], 0, $dob_transit[0], $dob_transit[1], $dob_transit[2]));
            }
            else
            {
                $dob_transit        = explode(":",$down_val[0].":".$down_val[1].":00");
            }
            //echo $dob_transit[0].":".$dob_transit[1].":".$dob_transit[2];exit;
            $time_diff          = substr($data['time_diff'],1);
            $sign               = substr($data['time_diff'],0,1);
            $time_diff          = explode(":",$time_diff);
            $time_diff          = $time_diff[0]*3600+$time_diff[1]*60+$time_diff[2];
            $intval_sec         = 24*3600;
            $day_transit        = $day_transit[0]*60*4+$day_transit[1]*4;
            $hr_transit         = explode(":",$this->getDiffTransit2($day_transit, $time_diff, $intval_sec));
            //echo $hr_transit[0].":".$hr_transit[1].":".$hr_transit[2];exit;
            if($sign == "+")
            {
                $actual_transit    = explode(":",$this->addDegMinSec($dob_transit[0], $dob_transit[1], $dob_transit[2], $hr_transit[0], $hr_transit[1], $hr_transit[2]));
            }
            else if($sign == "-")
            {
                $actual_transit    = explode(":",$this->subDegMinSec($dob_transit[0], $dob_transit[1], $dob_transit[2], $hr_transit[0], $hr_transit[1], $hr_transit[2]));
            }
            //echo $actual_transit[0].":".$actual_transit[1].":".$actual_transit[2];exit;
            $date1  = null;
            unset($date1);
            $query                  ->clear();
            $query                  ->select($db->quoteName('ayanamsha'))
                                    ->from($db->quoteName('#__lahiri_ayanamsha'))
                                    ->where($db->quoteName('year').'<='.$db->quote($year))
                                    ->order($db->quoteName('year').' desc')
                                    ->setLimit('1');
            $db->setQuery($query);
            $result                 = $db->loadAssoc();
            $ayanamsha              = explode(":",$result['ayanamsha'].":00");
            if($actual_transit[0]<$ayanamsha[0])
            {
                $actual_transit[0]  = $actual_transit[0]+360;
            }
            $value                  = $this->subDegMinSec($actual_transit[0], $actual_transit[1], $actual_transit[2], $ayanamsha[0], $ayanamsha[1], $ayanamsha[2]);
             
            unset($result);
            $value_sign             = $this->calcDetails($value);
            $value_distance         = $this->calcDistance($value);
            $planet_details         = $this->getPlanetaryDetails($planet,$value_sign,$value_distance);
            
            if($up_deg<$down_deg && !(intval($up_deg-$down_deg)>300))
            {
                $result                 = array($planet=>$value.":r",$planet."_sign"=>$value_sign,
                                                $planet."_distance"=>$value_distance);
                $result                 = array_merge($result,$planet_details);
            }
            else
            {
                $result                 = array($planet=>$value,$planet."_sign"=>$value_sign,
                                                $planet."_distance"=>$value_distance);
                $result                 = array_merge($result,$planet_details);
            }
            
            $seven_planets                     = array_merge($seven_planets, $result);
          }
        return $seven_planets   ;
    }
    // function calculates value of Budh and also Ketu
    protected function getBudh($data)
    {
        $lagna              = $this->calculatelagna($data);
        $moon               = $this->getMoonData($data);
        $planets            = $this->calculate7Planets($data);
        $dob                = $data['ind_date'];
        $year               = date("Y", strtotime($data['ind_date']));
        $rahu               = explode(":",$planets['rahu']);
        $ketu               = $rahu[0]+180;
        if($ketu >= 360)
        {
            $ketu   = $ketu-360;
        }
        $ketu           = $ketu.":".$rahu[1].":".$rahu[2];
        $ketu_distance  = $this->calcDistance($ketu);
        $ketu_sign      = $this->calcDetails($ketu);
        $ketu_details   = $this->getPlanetaryDetails("ketu",$ketu_sign, $ketu_distance);
        $ketu           = array("ketu"=>$ketu.":r","ketu_sign"=>$ketu_sign,
                                    "ketu_distance"=>$ketu_distance);
        $ketu           = array_merge($ketu,$ketu_details);
        
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array("budh", "budh_5","full_year")));
        $query          ->from($db->quoteName('#__raman_planets2000'));
        $query          ->where($db->quoteName('full_year').'<='.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result         = $db->loadAssoc();
        $down_year      = $result['full_year'];
        $down_budh      = $result['budh'];
        $down_budh5     = $result['budh_5'];
        unset($result);
        $query          ->clear();
        $query          ->select($db->quoteName(array("budh", "budh_5","full_year")));
        $query          ->from($db->quoteName('#__raman_planets2000'));
        $query          ->where($db->quoteName('full_year').'>'.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' asc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result         = $db->loadAssoc();
        $up_year      = $result['full_year'];
        $up_budh      = $result['budh'];
        $up_budh5     = $result['budh_5'];
        //echo $down_year.":".$up_year;exit;
        $datetime1          = new DateTime($data['ind_date']);          // lower value of year
        $datetime2          = new DateTime($down_year);           // upper value of year
        $datetime3          = new DateTime($up_year);       // exact dob
        $interval1          = $datetime1->diff($datetime2);     // get difference
        $intval1            = (int)$interval1->format('%a');     // format in int example 2
        $interval2          = $datetime1->diff($datetime3);
        $intval2            = (int)$interval2->format('%a');
        //echo $intval1.":".$intval2;exit;
        if($intval1 >$intval2 && $down_budh5 !== "0")
        {
            $down_deg           = $down_budh5;
            $up_deg             = $up_budh;
            $intval             = 5;
        }
        else if($intval1 >$intval2 && $down_budh5 !== "0")
        {
            $down_deg           = $down_budh;
            $up_deg             = $down_budh5;
            $intval             = 5;
        }
        else
        {
            $down_deg           = $down_budh;
            $up_deg             = $up_budh;
            $intval             = 10;
        }
        //echo $up_val." : ".$down_val;exit;
        if($up_deg<$down_deg && intval($up_deg-$down_deg)>300)
        {
            $up_val         = $up_deg+360.00;
            $up_val         = explode(".",$up_val);
            $down_val       = explode(".",$down_deg);
            $diff           = explode(":",$this->subDegMinSec($up_val[0],$up_val[1],0,$down_val[0],$down_val[1],0));
        }
        else
        {
            $up_val         = explode(".",$up_deg);
            $down_val       = explode(".",$down_deg);
            $diff           = explode(":",$this->subDegMinSec($up_val[0],$up_val[1],0,$down_val[0],$down_val[1],0));
        }
        $day_transit        = explode(":",$this->divideDegMinSec($diff[0], $diff[1], $diff[2], $intval));       // one day transit
        $diff               = $diff[0]*60*4+$diff[1]*4;
        //echo $day_transit[0].":".$day_transit[2].":".$day_transit[2];exit;
        if($intval1==0)
        {
            $dob_transit        = explode(":",$down_val[0].":".$down_val[1].":00");
        }
        else
        {
            $dob_transit        = explode(":",$this->getDiffTransit2($diff,$intval1, $intval));
            $dob_transit        = explode(":",$this->addDegMinSec($down_val[0], $down_val[1], 0, $dob_transit[0], $dob_transit[1], $dob_transit[2]));
        }
        //echo $dob_transit[0].":".$dob_transit[1].":".$dob_transit[2];exit;
        $time_diff          = substr($data['time_diff'],1);
        $sign               = substr($data['time_diff'],0,1);
        $time_diff          = explode(":",$time_diff);
        $time_diff          = $time_diff[0]*3600+$time_diff[1]*60+$time_diff[2];
        $intval_sec         = 24*3600;
        $day_transit        = $day_transit[0]*60*4+$day_transit[1]*4;
        $hr_transit         = explode(":",$this->getDiffTransit2($day_transit, $time_diff, $intval_sec));
        //echo $hr_transit[0].":".$hr_transit[1].":".$hr_transit[2];exit;
        if($sign == "+")
        {
            $actual_transit    = explode(":",$this->addDegMinSec($dob_transit[0], $dob_transit[1], $dob_transit[2], $hr_transit[0], $hr_transit[1], $hr_transit[2]));
        }
        else if($sign == "-")
        {
            $actual_transit    = explode(":",$this->subDegMinSec($dob_transit[0], $dob_transit[1], $dob_transit[2], $hr_transit[0], $hr_transit[1], $hr_transit[2]));
        }
        //echo $actual_transit[0].":".$actual_transit[1].":".$actual_transit[2];exit;
        $date1  = null;
        unset($date1);
        $query                  ->clear();
        $query                  ->select($db->quoteName('ayanamsha'))
                                ->from($db->quoteName('#__lahiri_ayanamsha'))
                                ->where($db->quoteName('year').'<='.$db->quote($year))
                                ->order($db->quoteName('year').' desc')
                                ->setLimit('1');
        $db->setQuery($query);
        $result                 = $db->loadAssoc();
        $ayanamsha              = explode(":",$result['ayanamsha'].":00");
        //echo "<br/>".$ayanamsha[0].":".$ayanamsha[1].":".$ayanamsha[2];exit;
        if($actual_transit[0]<$ayanamsha[0])
        {
            $actual_transit[0]  = $actual_transit[0]+360;
        }
        $value                  = $this->subDegMinSec($actual_transit[0], $actual_transit[1], $actual_transit[2], $ayanamsha[0], $ayanamsha[1], $ayanamsha[2]);
        unset($result);
        
        if($up_deg<$down_deg && !(intval($up_deg-$down_deg)>300))
        {
            $budh                   = $value.":r";
        }
        else
        {
            $budh                   = $value;
        }
        $budh_distance              = $this->calcDistance($budh);
        $budh_sign                  = $this->calcDetails($budh);
        $budh_details               = $this->getPlanetaryDetails("budh",$budh_sign, $budh_distance);
        $budh                   = array("budh"=>$budh,"budh_distance"=>$budh_distance,
                                        "budh_sign"=>$budh_sign);
        $budh                   = array_merge($budh,$budh_details);
        $data                   = array_merge($data,$lagna,$moon,$planets,$ketu,$budh);
        return $data;
    }
    protected function getRaman2050($data)
    {
        $lagna          = $this->calculatelagna($data);
        $dob            = $data['ind_date'];
        $tob            = strtotime($data['tob']);
        $tob            = explode(":",date('G:i:s', $tob));

        $planets        = array("full_year","moon","surya","budh","shukra","mangal","guru","shani","rahu");
        $count          = count($planets);
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName($planets));
        $query          ->from($db->quoteName('#__raman_2050planets'));
        $query          ->where($db->quoteName('full_year').'='.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result1        = $db->loadAssoc();
        
        $query          ->clear();
        $query          ->select($db->quoteName($planets));
        $query          ->from($db->quoteName('#__raman_2050planets'));
        $query          ->where($db->quoteName('full_year').'>'.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' asc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result2        = $db->loadAssoc();
        //print_r($result1);exit;
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
            //$sign               = $planet."_sign";$distance=$planet."_distance";
            $sign               = $this->calcDetails($distance);
            $sign_det           = array($planet."_sign"=>$sign);
            $dist               = $this->calcDistance($distance);
            $dist_det           = array($planet."_distance"=>$dist);
            $details            = $this->getPlanetaryDetails($planet,$sign,$dist);
            $graha              = array_merge($graha,$sign_det,$dist_det,$details);
            
            if($i==8)
            {
                $distance       = str_replace(":",".",$distance);
                $ketu           = $distance+180;
                if($ketu>360)
                {
                    $ketu       = $ketu-360;
                }
                $sign               = $this->calcDetails(str_replace(".", ":", $ketu));
                $sign_det           = array("ketu_sign"=>$sign);
                $distance           = $this->calcDistance(str_replace(".", ":", $ketu));
                $distance_det       = array("ketu_distance"=>$distance);
                $details            = $this->getPlanetaryDetails("ketu",$sign,$distance);
                $ketu               = array("ketu"=>str_replace(".",":",$ketu));
                $ketu               = array_merge($ketu,$sign_det,$distance_det,$details);
                $graha              = array_merge($graha, $ketu);
            }  
            
            $data           = array_merge($data, $lagna, $graha);
                       
        }   
        return $data;
    }
    protected function getRaman2050_Moon($data)
    {
        $dob            = $data['ind_date'];
        $tob            = strtotime($data['tob']);
        $tob            = explode(":",date('G:i:s', $tob));
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName('moon'));
        $query          ->from($db->quoteName('#__raman_2050planets'));
        $query          ->where($db->quoteName('full_year').'='.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result1        = $db->loadAssoc();
        
        $query          ->clear();
        $query          ->select($db->quoteName('moon'));
        $query          ->from($db->quoteName('#__raman_2050planets'));
        $query          ->where($db->quoteName('full_year').'>'.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' asc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result2        = $db->loadAssoc();
        
        $down_deg       = explode(".",$result1['moon']);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
        $up_deg         = explode(".",$result2['moon']);
        (double)$down_deg       = ((double)$down_deg[0]*30+$down_deg[1]).".".$down_deg[2];
        (double)$up_deg         = ((double)$up_deg[0]*30+$up_deg[1]).".".$up_deg[2];
        $down_val               = explode(".",$down_deg);
        $up_val                 = explode(".", $up_deg);
        //echo "Moon ".$up_deg." : ".$down_deg;exit;
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

        if($result5['min'] < 10)
        {
            $diff   = $result5['degree'].'.0'.$result5['min'];
        }
        $distance       = ($down_deg + $diff)-30.00;
        $dist           = explode(".",$distance);
        $distance       = $this->convertDegMinSec($dist[0], $dist[1], 0);
        $graha          = array("moon"=>$distance);

        $sign               = $this->calcDetails($distance);
        $sign_det           = array("moon_sign"=>$sign);
        $dist               = $this->calcDistance($distance);
        $dist_det           = array("moon_distance"=>$dist);
        $details            = $this->getPlanetaryDetails("moon",$sign,$dist);
        $graha              = array_merge($graha,$sign_det,$dist_det,$details);
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
    public function getAscendant($details)
    {
        //print_r($details);exit;
        $gender             = $details['gender'];
        $lagna              = $this->calculatelagna($details);
        $sign               = $lagna['lagna_sign'];
        $id                 = $this->getAscendantId($gender,$sign);
        $db                 = JFactory::getDbo();
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName(array('id','introtext')));
        $query              ->from($db->quoteName('#__content'));
        $query              ->where($db->quoteName('id').'='.$db->quote($id)); 
        $db                 ->setQuery($query);
        $result             = $db->loadAssoc();
        
        $data           = array_merge($details,$lagna,$result);
        return $data;
    }
    public function getMoon($user_details)
    {
        $fname          = $user_details['fname'];
        $gender         = $user_details['gender'];
        $dob            = $user_details['dob'];
        $year           = date("Y",strtotime($dob));
        $tob            = $user_details['tob'];
        $pob            = $user_details['pob'];
        $lon            = $user_details['lon'];
        $lat            = $user_details['lat'];
        $tmz            = $user_details['tmz'];
        $dst            = $user_details['dst'];
       
        // fetches the Indian standard time and Indian Date for the given time and birth
        $ind_det       = explode("_",$this->getISTTime($dob, $tob, $tmz, $dst));
        $ind_date       = $ind_det[0];
        $ind_time       = $ind_det[1];
        $ind_str        = strtotime($ind_time);
        if($year <= 2000)
        {
            $gmt        = '17:30:00';
            $gmt_str    = strtotime($gmt);
        }
        else
        {
            $gmt        = '00:00:00';
            $gmt_str    = strtotime($gmt);
        }
        $datetime1      = date_create(str_replace("/","-",$dob));
        $datetime2      = date_create($ind_date);
        $interval = date_diff($datetime1, $datetime2);
        $ind_sign       = $interval->format('%R:%a');
        if($ind_str>$gmt_str)
        {
            $diff       = "+".$this->getAddSubTime($dob,$ind_str,$gmt_str,"-");

        }
        else if($ind_str<$gmt_str)
        {
            $diff       = "-".$this->getAddSubTime($dob,$gmt_str,$ind_str,"-");
        }

        /* 
        *  @param fullname, gender, date of birth, time of birth, 
        *  @param longitude, latitude, timezone and
        *  @param timezone in hours:minutes:seconds format
        */ 
        $data  = array(
                        "fname"=>$fname,"gender"=>$gender,"dob"=>$dob,
                        "tob"=>$tob,"pob"=>$pob,"lon"=>$lon,"lat"=>$lat,"tmz"=>$tmz,
                        "tmz_hr"=>$gmt,"time_diff"=>$diff,"dst"=>$dst, 
                        "ind_date"=>$ind_date,"ind_time"=>$ind_time
                    );
        
        if($year<=2000)
        {
            $moon           = $this->getMoonData($data);
        }
        else
        {
            $moon           = $this->getRaman2050_Moon($data);
        }
        $sign           = $moon['moon_sign']." Sign";
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('id','introtext')));
        $query          ->from($db->quoteName('#__content'));
        $query          ->where($db->quoteName('title').'LIKE'.$db->quote('%'.$sign.'%')); 
        $db             ->setQuery($query);
        $result         = $db->loadAssoc();
        $data           = array_merge($user_details,$moon,$result);
        return $data;
    }
    public function getNakshatra($user_details)
    {
        $fname          = $user_details['fname'];
        $gender         = $user_details['gender'];
        $dob            = $user_details['dob'];
        $year           = date("Y",strtotime($dob));
        $tob            = $user_details['tob'];
        $pob            = $user_details['pob'];
        $lon            = $user_details['lon'];
        $lat            = $user_details['lat'];
        $tmz            = $user_details['tmz'];
        $dst            = $user_details['dst'];
       
        // fetches the Indian standard time and Indian Date for the given time and birth
        $ind_det       = explode("_",$this->getISTTime($dob, $tob, $tmz, $dst));
        $ind_date       = $ind_det[0];
        $ind_time       = $ind_det[1];
        $ind_str        = strtotime($ind_time);
        if($year <= 2000)
        {
            $gmt        = '17:30:00';
            $gmt_str    = strtotime($gmt);
        }
        else
        {
            $gmt        = '00:00:00';
            $gmt_str    = strtotime($gmt);
        }
        $datetime1      = date_create(str_replace("/","-",$dob));
        $datetime2      = date_create($ind_date);
        $interval = date_diff($datetime1, $datetime2);
        $ind_sign       = $interval->format('%R:%a');
        if($ind_str>$gmt_str)
        {
            $diff       = "+".$this->getAddSubTime($dob,$ind_str,$gmt_str,"-");

        }
        else if($ind_str<$gmt_str)
        {
            $diff       = "-".$this->getAddSubTime($dob,$gmt_str,$ind_str,"-");
        }

        /* 
        *  @param fullname, gender, date of birth, time of birth, 
        *  @param longitude, latitude, timezone and
        *  @param timezone in hours:minutes:seconds format
        */ 
        $data  = array(
                        "fname"=>$fname,"gender"=>$gender,"dob"=>$dob,
                        "tob"=>$tob,"pob"=>$pob,"lon"=>$lon,"lat"=>$lat,"tmz"=>$tmz,
                        "tmz_hr"=>$gmt,"time_diff"=>$diff,"dst"=>$dst, 
                        "ind_date"=>$ind_date,"ind_time"=>$ind_time
                    );
        
        if($year<=2000)
        {
            $moon           = $this->getMoonData($data);
        }
        else
        {
            $moon           = $this->getRaman2050_Moon($data);
        }
        $sign           = $moon['moon_sign'];
        $distance       = $moon['moon_distance'];
        $moon_info      = $this->getPlanetaryDetails("moon", $sign, $distance);
        $nakshatra      = $moon_info['moon_nakshatra'];
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->clear();unset($result);
        $query          ->select($db->quoteName(array('id','introtext')));
        $query          ->from($db->quoteName('#__content'));
        $query          ->where($db->quoteName('title').'LIKE'.$db->quote($nakshatra.'%')); 
        $db             ->setQuery($query);
        $result         = $db->loadAssoc();
        $nakshatra      = array("nakshatra"=>$nakshatra);
        $data           = array_merge($user_details,$moon, $result);
        return $data;
    }
    
}
?>
