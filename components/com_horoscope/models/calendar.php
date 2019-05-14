<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('muhurat', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelCalendar extends HoroscopeModelMuhurat
{
    public function getData()
    {
        $jinput         = JFactory::getApplication()->input;
        $date           = $jinput->get('date', 'default_value', 'filter');
        $array          = array();
        if($date == "default_value")
        {
            $date       = date("Y-m-d");
        }
        if(!isset($_COOKIE["loc"]) && !isset($_COOKIE["lat"]) &&
           !isset($_COOKIE["lon"]) && !isset($_COOKIE["tmz"])) {
            $loc            = "Ujjain, India";
            $timezone       = "Asia/Kolkata";
            $lon            = "75.78";  $lat            = "23.17";  $alt    = 0;
        } else {
           $loc         = $_COOKIE["loc"];
           $lat         = $_COOKIE["lat"];
           $lon         = $_COOKIE["lon"];
           $timezone    = $_COOKIE["tmz"];
           $alt         = 0;
        }
        $date               = new DateTime($date);
        $days_in_month      = $date->format('t');       // getting the total number of days in current month. for eg 31 for March
        $month_num          = $date->format('m');       // month in number format. example 01 for January 
        $curr_year          = $date->format('Y');
        $getCalendar        = $this->getCalendar($days_in_month,$month_num, $curr_year);
        $sunrise_sunset     = $this->getSunTimings(date('01-'.$month_num.'-'.$curr_year), $timezone, $lat, $lon, $alt, $days_in_month+1);
        $get_muhurat        = $this->getCalendarMuhurat($sunrise_sunset);
        $array              = array_merge($array, $getCalendar);
        $array              = array_merge($array,$sunrise_sunset);
        $array              = array_merge($array, $get_muhurat);
        
        //print_r($array);exit;
        return $array;
    }
    public function getCalendar($days, $month, $year)
    {
        $libPath = JPATH_BASE.'/sweph/';
        putenv("PATH=$libPath");
        $h_sys = 'P';
        $output = "";
        // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        exec ("swetest -edir$libPath -p1 -d0 -b1.$month.$year -n$days -fl -head", $output);
        $date           = "01-".$month."-".$year;
        $tithi          = $this->getTithi($date, $output);
        return $tithi;
    }
    public function getTithi($date, $output)
    {
        //print_r($date);exit;
        $date           = new DateTime($date);
        $array          = array();
        foreach($output as $result)
        {
            $date1       = $date->format('d-m-Y');
            $tithi       = trim($result);
            $first              = substr(trim($tithi), 0, 1);
            if($first           == "-")
            {
                $tithi          = 180 + $tithi;
                $tithi_in_num   = (int)$tithi;
                $tithi_in_words = $this->getTithiWords("krishna",$tithi_in_num);
                $vedic_month    = $this->getVedicMonth($date);
                $tithi          = array($date1 => $tithi_in_words,$date1."_paksh"=>"Krishna");
                $array          = array_merge($array, $tithi);
            }
            else
            {
                $tithi_in_num   = (int)$tithi;
                $tithi_in_words     = $this->getTithiWords("shukla",$tithi_in_num);
                $vedic_month    = $this->getVedicMonth($date);
                $tithi          = array($date1 => $tithi_in_words, $date1."_paksh"=>"Shukla");
                $array          = array_merge($array, $tithi);
            }
            $date        ->add(new DateInterval('P1D'));
        }
        exit;
        //return $array;
    }
    public function getTithiWords($moon_status, $tithi)
    {
        //echo $tithi." ".$moon_status;exit;
        if($tithi >= 168 && $tithi < 180 && $moon_status == "krishna")
        {
            return "Amavasya";
        }
        else if($tithi >= 168 && $tithi < 180 && $moon_status == "shukla")
        {
            return "Purnima";
        }
        else if($tithi >= 0 && $tithi < 12 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Prathama";
        }
        else if($tithi >= 12 && $tithi < 24 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Dvitiya";
        }
        else if($tithi >= 24 && $tithi < 36 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Tritiya";
        }
        else if($tithi >= 36 && $tithi < 48 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Chaturthi";
        }
        else if($tithi >= 48 && $tithi < 60 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Panchami";
        }
        else if($tithi >= 60 && $tithi < 72 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Shasti";
        }
        else if($tithi >= 72 && $tithi < 84 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Saptami";
        }
        else if($tithi >= 84 && $tithi < 96 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Ashtami";
        }
        else if($tithi >= 96 && $tithi < 108 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Navami";
        }
        else if($tithi >= 108 && $tithi < 120 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Dashami";
        }
        else if($tithi >= 120 && $tithi < 132 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Ekadashi";
        }
        else if($tithi >= 132 && $tithi < 144 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Dwadashi";
        }
        else if($tithi >= 144 && $tithi < 156 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Trayodashi";
        }
        else if($tithi >= 156 && $tithi < 168 && ($moon_status == "krishna"|| $moon_status=="shukla"))
        {
            return "Chaturdashi";
        }
    }
    public function getCalendarMuhurat($rise_set_times)
    {
        $count              = count($rise_set_times)/2;
        $muhurat            = array();
        for($i=2;$i<= $count;$i++)
        {
            $j                  = $i+1;
            $k                  = $i-1;
            $rise               = new DateTime($rise_set_times['sun_rise_'.$i]);//echo $rise."<br/>";
            $day_of_week        = $rise->format('l');
            $set                = new DateTime($rise_set_times['sun_set_'.$i]);//echo $set."<br/>";
            $day_interval       = $set->getTimestamp() - $rise->getTimestamp();//echo $day_interval;exit;
            $day_prahar         = $this->getPrahar($rise_set_times['sun_rise_'.$i],$day_interval,"day");
            $result             = $this->getMuhuratTables($day_of_week);
            //print_r($result);exit;
            $rahu               = $result[0]['prahar_num'];//echo $rahu."<br/>";
            $yama               = $result[1]['prahar_num'];//echo $yama."<br/>";
            $guli               = $result[2]['prahar_num'];//echo $guli."<br/>";exit;
            $rahu_kalam         = array("rahu_start_".$k    =>  $day_prahar["day_prahar_start_".$rahu],
                                        "rahu_end_".$k      =>  $day_prahar["day_prahar_end_".$rahu]);
            //print_r($rahu_kalam);exit;
            $yama_kalam         = array("yama_start_".$k    =>  $day_prahar["day_prahar_start_".$yama],
                                        "yama_end_".$k      =>  $day_prahar["day_prahar_end_".$yama]);
            //print_r($yama_kalam);exit;
            $guli_kalam         = array("guli_start_".$k    =>  $day_prahar["day_prahar_start_".$guli],
                                      "guli_end_".$k        =>  $day_prahar["day_prahar_end_".$guli]);
            $muhurat            = array_merge($muhurat, $rahu_kalam, $yama_kalam, $guli_kalam);
            
        }
        //print_r($muhurat);exit;
        return $muhurat;
    }
    public function getVedicMonth($date)
    {
        $month              = $date->format('F');
        $months             = array("January","February","March","April","May","June",
                                    "July","August","September","October","November","December");
        $key                = array_search($month, $months);
        $curr_month         = $months[$key];
        $prev_month         = $months[$key-1];
        $next_month         = $months[$key+1];

        
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);     
        $query              ->select($db->quoteName(array('month','sun_sign')));
        $query              ->from($db->quoteName('#__hindu_calender'));
        $query              ->where($db->quoteName('greg_upper_month').' = '.$db->quote($prev_month).' OR '.
                                    $db->quoteName('greg_lower_month').' = '.$db->quote($prev_month).' OR '.
                                    $db->quoteName('greg_lower_month').' = '.$db->quote($curr_month).' OR '.
                                    $db->quoteName('greg_upper_month').' = '.$db->quote($next_month).' OR '.
                                    $db->quoteName('greg_lower_month').' = '.$db->quote($next_month));
        $db                 ->setQuery($query);
        $db->execute();
        $result             = $db->loadAssocList();
        print_r($result);exit;
    }
}
