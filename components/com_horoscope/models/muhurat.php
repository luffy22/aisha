<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelMuhurat extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;        
        $date           = date('Y-m-d');
        $location       = $jinput->get('location', 'default_value', 'filter');
        $location       = explode("_",$location);
        $timezone       = "Asia/Kolkata";
        $sun_times      = $this->getSunTimings($date, $timezone);
        $muhurat        = $this->getMuhurat($sun_times);
        $chogadiya      = $this->getChogadiya($sun_times);
        $moon_times     = $this->getMoonTimings($date,$timezone);
        //print_r($moon_times);exit;
        
    }
    public function getSunTimings($date, $timezone)
    {
        $dtz            = new DateTimeZone($timezone); //Your timezone
        $date           = new DateTime($date, $dtz);
        $date->sub(new DateInterval('P1D'));
        //echo $date->format('d.m.Y H:i:s');exit;        
        $date           = $date->format('d.m.Y');
        $lon            = "72.57";
        $lat            = "23.02";
        $h_sys = 'P';
        $output = "";
        //echo $utcTimestamp;exit;
        //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';
        exec ("swetest -b$date -geopos$lon,$lat,0 -rise -hindu -p0 -n12 -head", $output);
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
    public function getMoonTimings($date, $timezone)
    {
        $dtz            = new DateTimeZone($timezone); //Your timezone
        $date           = new DateTime($date, $dtz);
        $date->sub(new DateInterval('P1D'));
        //echo $date->format('d.m.Y H:i:s');exit;        
        $date           = $date->format('d.m.Y');
        $lon            = "72.57";
        $lat            = "23.02";
        $h_sys = 'P';
        $output = "";
        exec ("swetest -b$date -geopos$lon,$lat,0 -rise -hindu -p1 -n12 -head", $output);
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
        print_r($moon);exit;
    }
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
    /*
     * Get the Muhurat times for the particular day
     * @param datetime Date and Time for sunrise and sunset
     * @return array Array with Muhurat times for particular day.
     */
    public function getMuhurat($times)
    {
        $muhurat            = array();
        //print_r($times);exit;
        for($i=1;$i<13;$i++)
        {
            if($i==1 || $i==12)
            {
                continue;
            }
            else
            {
                $j                  = $i+1;
                $rise               = new DateTime($times['sun_rise_'.$i]);//echo $rise."<br/>";
                $day_of_week        = $rise->format('l');
                $set                = new DateTime($times['sun_set_'.$i]);//echo $set."<br/>";
                $rise_next          = new DateTime($times['sun_rise_'.$j]);//echo $rise_next."<br/><br/>";exit;
                $day_interval       = $set->getTimestamp() - $rise->getTimestamp();//echo $day_interval;exit;
                $night_interval     = $rise_next->getTimestamp() - $set->getTimeStamp();
                $day_prahar         = $this->getPrahar($times['sun_rise_'.$i],$day_interval,"day");
                $night_prahar       = $this->getPrahar($times['sun_set_'.$i],$night_interval,"night");
                $result             = $this->getMuhuratTables($day_of_week);
                //print_r($result);exit;
                $rahu               = $result[0]['prahar_num'];//echo $rahu_kalam."<br/>";
                $yama               = $result[1]['prahar_num'];//echo $yama_ghanta."<br/>";
                $guli               = $result[2]['prahar_num'];//echo $guli_kalam."<br/>";exit;
                $rahu_kalam         = array("rahu_kalam_start_".$i=>$day_prahar["day_prahar_start_".$rahu],
                                            "rahu_kalam_end_".$i=>$day_prahar["day_prahar_end_".$rahu]);
                $yama_kalam         = array("yama_kalam_start".$i=>$day_prahar["day_prahar_start_".$yama],
                                            "yama_kalam_end".$i=>$day_prahar["day_prahar_end_".$yama]);
                $guli_kalam         = array("guli_kalam_start".$i=>$day_prahar["day_prahar_start_".$guli],
                                            "guli_kalam_end".$i=>$day_prahar["day_prahar_end_".$guli]);
                $abhijit_kalam      = $this->getAbhijitKalam($i,$times['sun_rise_'.$i],$day_interval);
                $muhurat            = array_merge($muhurat,$rahu_kalam,$yama_kalam,$guli_kalam,$abhijit_kalam);
                //print_r($night_prahar);exit;
                //echo $night_interval;exit;
            }
        }
        return $muhurat;
    }
    /*
     * Get the Muhurat times for the particular day
     * @param datetime Date and Time for sunrise and sunset
     * @return array Array with Muhurat times for particular day.
     */
    public function getChogadiya($times)
    {
        $chogadiya                  = array();
        //print_r($times);exit;
        for($i=1;$i<13;$i++)
        {
            if($i==1 || $i==12)
            {
                continue;
            }
            else
            {
                $j                  = $i+1;
                $rise               = new DateTime($times['sun_rise_'.$i]);//echo $rise."<br/>";
                $day_of_week        = $rise->format('l');
                $set                = new DateTime($times['sun_set_'.$i]);//echo $set."<br/>";
                $rise_next          = new DateTime($times['sun_rise_'.$j]);//echo $rise_next."<br/><br/>";exit;
                $day_interval       = $set->getTimestamp() - $rise->getTimestamp();//echo $day_interval;exit;
                $night_interval     = $rise_next->getTimestamp() - $set->getTimeStamp();
                $day_prahar         = $this->getPrahar($times['sun_rise_'.$i],$day_interval,"day");
                //print_r($day_prahar);exit;
                $night_prahar       = $this->getPrahar($times['sun_set_'.$i],$night_interval,"night");
                $day_chogad         = $this->getChogadiyaTables($day_of_week,"day");
                //print_r($day_chogad);exit;
                $night_chogad       = $this->getChogadiyaTables($day_or_week,"night");
                for($k=1;$k<9;$k++)
                {
                    $m              = $k-1;
                    $chogad_day     = array("day_chogad_".$i."_chogadiya_".$k => $day_chogad[$m]['chogadiya'],
                                            "day_chogad_".$i."_start_".$k => $day_prahar["day_prahar_start_".$k],
                                            "day_chogad_".$i."_end_".$k => $day_prahar['day_prahar_end_'.$k]);
                    $chogad_night   = array("night_chogad_".$i."_chogadiya_".$k => $night_chogad[$m]['chogadiya'],
                                            "night_chogad_".$i."_start_".$k => $night_prahar["night_prahar_start_".$k],
                                            "night_chogad_".$i."_end_".$k => $night_prahar['night_prahar_end_'.$k]);
                    $chogadiya      = array_merge($chogadiya,$chogad_day,$chogad_night);
                    //print_r($chogadiya);exit;
                }
                print_r($chogadiya);exit;
            }
        }
        print_r($chogadiya);exit;
    }
    public function getPrahar($date, $interval,$day_night)
    {
        $prahar                     = array();      // total number for prahar
        $date                       = new DateTime($date);
        $prahar_sec                 = explode(".",round(($interval/8),2)); // total seconds divided by 8 as there are 8 prahars in a day
        for($i=1;$i<9;$i++)
        {
            $start                  = $date->format('Y-m-d H:i:s');
            $date                   ->add(new DateInterval('PT'.$prahar_sec[0].'S'));
            $end                    = $date->format('Y-m-d H:i:s');
            $prahar_period          = array($day_night."_prahar_start_".$i => $start,$day_night."_prahar_end_".$i =>$end);
            $prahar                 = array_merge($prahar, $prahar_period);
        }
        return $prahar;
    }
    public function getAbhijitKalam($num,$date, $interval)
    {
        $muhurat                    = explode(".",round(($interval/15),2));
        $date                       = new DateTime($date);
        $abhijit                    = array();
        for($i=1;$i<16;$i++)
        {
            if($i == 8)
            {
                $start              = $date->format('Y-m-d H:i:s');
                $date               ->add(new DateInterval('PT'.$muhurat[0].'S'));
                $end                    = $date->format('Y-m-d H:i:s');
                $period            = array("abhijit_start_".$num=>$start,"abhijit_end_".$num=>$end);
                $abhijit            = array_merge($abhijit, $period);
            }
            else
            {
                $date               ->add(new DateInterval('PT'.$muhurat[0].'S'));
            }
        }
        return $abhijit;
    }
    public function getMuhuratTables($day_of_week)
    {
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        
        $query              ->select($db->quoteName('prahar_num'));
        $query              ->from($db->quoteName('#__horo_muhurat'));
        $query              ->where($db->quoteName('day').'='.$db->quote($day_of_week));
        $db                 ->setQuery($query);
        $result             = $db->loadAssocList();
        return $result;
    }
    public function getChogadiyaTables($day_of_week,$day_or_night)
    {
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName(array('chogadiya','prahar_num')));
        $query              ->from($db->quoteName('#__horo_chogadiya'));
        $query              ->where($db->quoteName('day_of_week').' = '.$db->quote($day_of_week).' AND '.
                                    $db->quoteName('day_or_night').' = '.$db->quote($day_or_night));
        $db                 ->setQuery($query);
        $result             = $db->loadAssocList();
        return $result;
    }
}