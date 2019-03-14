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
        if(!isset($_COOKIE[$cookie_loc])) {
            $location   = $_COOKIE[$cookie_loc];
            echo $location;exit;
        }
        $timezone       = "Asia/Kolkata";
        $lon            = "72.57";  $lat            = "23.02";  $alt    = 0;
        $sun_times      = $this->getSunTimings($date, $timezone,$lat,$lon,$alt,3);
        //print_r($sun_times);exit;
        $moon_times     = $this->getMoonTimings($date,$timezone,$lat,$lon,$alt,3);
        //print_r($moon_times);exit;
        $muhurat        = $this->getMuhurat($sun_times);
        //print_r($muhurat);exit;
        $chogadiya      = $this->getChogadiya($sun_times);
        //print_r($chogadiya);exit;
        $hora           = $this->getHora($sun_times);//print_r($hora);exit;
        $all_data       = array();
        $all_data       = array_merge($all_data,$sun_times,$moon_times,$muhurat,$chogadiya,$hora);
        return $all_data;
        
    }
    
    /*
     * Get the Muhurat times for the particular day
     * @param datetime Date and Time for sunrise and sunset
     * @return array Array with Muhurat times for particular day.
     */
    public function getMuhurat($rise_set_times)
    {
        //print_r($rise_set_times);exit;
        $muhurat            = array();
        $i                  = 2;
        $j                  = $i+1;
        $rise               = new DateTime($rise_set_times['sun_rise_'.$i]);//echo $rise."<br/>";
        $day_of_week        = $rise->format('l');
        //echo $day_of_week;exit;
        $set                = new DateTime($rise_set_times['sun_set_'.$i]);//echo $set."<br/>";
        $rise_next          = new DateTime($rise_set_times['sun_rise_'.$j]);//echo $rise_next."<br/><br/>";exit;
        $day_interval       = $set->getTimestamp() - $rise->getTimestamp();//echo $day_interval;exit;
        $night_interval     = $rise_next->getTimestamp() - $set->getTimeStamp();
        $day_prahar         = $this->getPrahar($rise_set_times['sun_rise_'.$i],$day_interval,"day");
        //print_r($day_prahar);exit;
        $night_prahar       = $this->getPrahar($rise_set_times['sun_set_'.$i],$night_interval,"night");
        //print_r($night_prahar);exit;
        $result             = $this->getMuhuratTables($day_of_week);
        //print_r($result);exit;
        $rahu               = $result[0]['prahar_num'];//echo $rahu."<br/>";
        $yama               = $result[1]['prahar_num'];//echo $yama."<br/>";
        $guli               = $result[2]['prahar_num'];//echo $guli."<br/>";exit;
        $rahu_kalam         = array("rahu_kalam_start"  =>  $day_prahar["day_prahar_start_".$rahu],
                                    "rahu_kalam_end"    =>  $day_prahar["day_prahar_end_".$rahu]);
        ///print_r($rahu_kalam);exit;
        $yama_kalam         = array("yama_kalam_start"  =>  $day_prahar["day_prahar_start_".$yama],
                                    "yama_kalam_end"    =>  $day_prahar["day_prahar_end_".$yama]);
        //print_r($yama_kalam);exit;
        $guli_kalam         = array("guli_kalam_start"  =>  $day_prahar["day_prahar_start_".$guli],
                                    "guli_kalam_end"    =>  $day_prahar["day_prahar_end_".$guli]);
        //print_r($guli_kalam);exit;
        $abhijit_kalam      = $this->getAbhijitKalam($times['sun_rise_'.$i],$day_interval);
        //print_r($abhijit_kalam);exit;
        $muhurat            = array_merge($muhurat,$rahu_kalam,$yama_kalam,$guli_kalam,$abhijit_kalam);
        return $muhurat;        
    }
    /*
     * Get the Muhurat times for the particular day
     * @param datetime Date and Time for sunrise and sunset
     * @return array Array with Muhurat times for particular day.
     */
    public function getMuhurat2($loc_details)
    {
        //print_r($loc_details);exit;
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;        
        $date           = date('Y-m-d');
        $location       = $loc_details['location'];
        $lat            = $loc_details['lat'];
        $lon            = $loc_details['lon'];
        $tmz            = $loc_details['tmz'];
        
        setcookie($cookie_loc, $location, time() + (86400 * 7), "/"); // 86400 = 1 day
        setcookie($cookie_lat, $lat, time() + (86400 * 7), "/"); // 86400 = 1 day
        setcookie($cookie_lon, $lon, time() + (86400 * 7), "/"); // 86400 = 1 day
        setcookie($cookie_tmz, $tmz, time() + (86400 * 7), "/"); // 86400 = 1 day
        echo $cookie_loc;exit;
        if($tmz == "none")
        {
            $timestamp      = $date->format('U');
            $tmz            = $this->getTimeZone($lat, $lon, "rohdes");
            if($tmz == "error")
            {
                $tmz        = "UTC";        // if timezone not available use UTC(Universal Time Cooridnated)
            }
            $date        = new DateTime($date, new DateTimeZone($tmz));         
        }
        else
        {
            $date       = new DateTime($date, new DateTimeZone($tmz));
        }
        $query_date     = date('Y-m-d H:i:s');
        $query_date     = new DateTime($query_date, new DateTimeZone('Asia/Kolkata'));
        $query_date     = $query_date->format('d-m-Y H:i:s');
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $columns        = array('location','query_date');
        $values         = array($db->quote($location),$db->quote($query_date));
        $query          ->insert($db->quoteName('#__panchang_query'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
        $db             ->setQuery($query);
        $result          = $db->query();
        $app            = JFactory::getApplication();
        $link           = JURI::base().'index.php?option=com_horoscope&view=muhurat';
        $app        ->redirect($link);
 
    }
    /*
     * Get the Muhurat times for the particular day
     * @param datetime Date and Time for sunrise and sunset
     * @return array Array with Muhurat times for particular day.
     */
    public function getChogadiya($times)
    {
        //print_r($times);exit;
        $chogadiya                  = array();
        $i                          = 2;
        $j                          = $i+1;
        $rise                       = new DateTime($times['sun_rise_'.$i]);//echo $rise."<br/>";
        $day_of_week                = $rise->format('l');
        $set                        = new DateTime($times['sun_set_'.$i]);//echo $set."<br/>";
        $rise_next                  = new DateTime($times['sun_rise_'.$j]);//echo $rise_next."<br/><br/>";exit;
        $day_interval               = $set->getTimestamp() - $rise->getTimestamp();//echo $day_interval;exit;
        $night_interval             = $rise_next->getTimestamp() - $set->getTimeStamp();
        $day_prahar                 = $this->getPrahar($times['sun_rise_'.$i],$day_interval,"day");
        //print_r($day_prahar);exit;
        $day_chogad                 = $this->getChogadiyaTables($day_of_week,"day");
          //print_r($day_chogad);exit;
        $night_prahar               = $this->getPrahar($times['sun_set_'.$i],$night_interval,"night");
        //print_r($night_prahar);exit;
        $night_chogad               = $this->getChogadiyaTables($day_of_week,"night");
        //print_r($night_chogad);exit;
        for($k=0;$k<8;$k++)
        {
            $m                      = $k+1;
            $chogad_day             = array("day_chogad_".$m    => $day_chogad[$k]['chogadiya'],
                                            "day_chogad_start_".$m    => $day_prahar["day_prahar_start_".$m],
                                            "day_chogad_end_".$m    => $day_prahar['day_prahar_end_'.$m]);
            $chogad_night           = array("night_chogad_".$m    => $night_chogad[$k]['chogadiya'],
                                            "night_chogad_start_".$m    => $night_prahar["night_prahar_start_".$m],
                                            "night_chogad_end_".$m    => $night_prahar['night_prahar_end_'.$m]);
            $chogadiya              = array_merge($chogadiya,$chogad_day,$chogad_night);
            //print_r($chogadiya);exit;
        }
        return $chogadiya;
    }
    /*
     * Get the Muhurat times for the particular day
     * @param datetime Date and Time for sunrise and sunset
     * @return array Array with Muhurat times for particular day.
     */
    public function getHora($times)
    {
        //print_r($times);exit;
        $hora                       = array();
        $i                          = 2;
        $j                          = $i+1;
        $rise                       = new DateTime($times['sun_rise_'.$i]);//echo $rise."<br/>";
        $day_of_week                = $rise->format('l');
        $set                        = new DateTime($times['sun_set_'.$i]);//echo $set."<br/>";
        $rise_next                  = new DateTime($times['sun_rise_'.$j]);//echo $rise_next."<br/><br/>";exit;
        $day_interval               = $set->getTimestamp() - $rise->getTimestamp();//echo $day_interval;exit;
        $night_interval             = $rise_next->getTimestamp() - $set->getTimeStamp();
        $day_prahar                 = $this->getHoraIntval($times['sun_rise_'.$i],$day_interval,"day");
        //print_r($day_prahar);exit;
        $day_hora                   = $this->getHoraTables($day_of_week,"day");
        //print_r($day_hora);exit;
        $night_prahar               = $this->getHoraIntval($times['sun_set_'.$i],$night_interval,"night");
        $night_hora                 = $this->getHoraTables($day_of_week,"night");
        for($k=0;$k<12;$k++)
        {
            $m                      = $k+1;
            $hora_day             = array("day_hora_".$m    => $day_hora[$k]['hora_for_day'],
                                            "day_hora_start_".$m    => $day_prahar["day_hora_start_".$m],
                                            "day_hora_end_".$m    => $day_prahar['day_hora_end_'.$m]);
            $hora_night           = array("night_hora_".$m    => $night_hora[$k]['hora_for_day'],
                                            "night_hora_start_".$m    => $night_prahar["night_hora_start_".$m],
                                            "night_hora_end_".$m    => $night_prahar['night_hora_end_'.$m]);
            $hora                   = array_merge($hora,$hora_day,$hora_night);
            //print_r($chogadiya);exit;
        }
        return $hora;
        
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
     public function getHoraIntval($date, $interval,$day_night)
    {
        $hora_intval                = array();      // total number for prahar
        $date                       = new DateTime($date);
        $prahar_sec                 = explode(".",round(($interval/12),2)); // total seconds divided by 8 as there are 8 prahars in a day
        for($i=1;$i<13;$i++)
        {
            $start                  = $date->format('Y-m-d H:i:s');
            $date                   ->add(new DateInterval('PT'.$prahar_sec[0].'S'));
            $end                    = $date->format('Y-m-d H:i:s');
            $prahar_period          = array($day_night."_hora_start_".$i => $start,$day_night."_hora_end_".$i =>$end);
            $hora_intval            = array_merge($hora_intval, $prahar_period);
        }
        return $hora_intval;
    }
    public function getAbhijitKalam($date, $interval)
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
                $period             = array("abhijit_start"=>$start,"abhijit_end"=>$end);
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
        //echo $day_of_week;exit;
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
    public function getHoraTables($day_of_week,$day_or_night)
    {
         //echo $day_of_week;exit;
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName(array('hora_for_day','hora_num')));
        $query              ->from($db->quoteName('#__hora'));
        $query              ->where($db->quoteName('day_of_week').' = '.$db->quote($day_of_week).' AND '.
                                    $db->quoteName('day_or_night').' = '.$db->quote($day_or_night));
        $db                 ->setQuery($query);
        $result             = $db->loadAssocList();
        return $result;
    }
}