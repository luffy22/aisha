<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelCalendar extends HoroscopeModelLagna
{
    public function getData()
    {
        $jinput         = JFactory::getApplication()->input;
        $date           = $jinput->get('date', 'default_value', 'filter');
        if($date == "default_value")
        {
            $date       = date("Y-m-d");
        }
        
        $date           = new DateTime($date);
        $days_in_month  = $date->format('t');       // getting the total number of days in current month. for eg 31 for March
        $month_num      = $date->format('m');       // month in number format. example 01 for January 
        $curr_year      = $date->format('Y');
        $getCalendar    = $this->getCalendar($days_in_month,$month_num, $curr_year);
        print_r($getCalendar);exit;
    }
    public function getCalendar($days, $month, $year)
    {
        $libPath = JPATH_BASE.'/sweph/';
        putenv("PATH=$libPath");
        $h_sys = 'P';
        $output = "";
        // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        exec ("swetest -edir$libPath -p1 -d0 -b1.$month.$year -n$days -fPTl -head", $output);
        $date           = "01-".$month."-".$year;
        $tithi          = $this->getTithi($date, $output);
        print_r($tithi);exit;
    }
    public function getTithi($date, $output)
    {
        $date           = new DateTime($date);
        $array          = array();
        foreach($output as $result)
        {
            $dist        = str_replace("Moo-Sun", " ", $result);
            $today       = $date->format('d.m.Y');
            $tithi       = str_replace($today,"",trim($dist));
            $date        ->add(new DateInterval('P1D'));
            $first              = substr(trim($tithi), 0, 1);
            if($first           == "-")
            {
                $tithi          = 180 + $tithi;
                $tithi_in_num   = (int)$tithi;
                $tithi_in_words = $this->getTithiWords("krishna",$tithi_in_num);
                $tithi          = array($today => $tithi_in_words);
                $array          = array_merge($array, $tithi);
            }
            else
            {
                $tithi_in_num   = (int)$tithi;
                $tithi_in_words     = $this->getTithiWords("shukla",$tithi_in_num);
                $tithi          = array($today => $tithi_in_words);
                $array          = array_merge($array, $tithi);
            }
            
        }
        return $array;
    }
    public function getTithiWords($moon_status, $tithi)
    {
        //echo $tithi;exit;
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
}
