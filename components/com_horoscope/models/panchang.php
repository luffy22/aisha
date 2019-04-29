<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('calendar', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelPanchang extends HoroscopeModelCalendar
{
    public function getData()
    {
        $today      = date('d-m-Y');
        $tmz        = "Asia/Kolkata";
        $lon        = "75.78";$lat      = "23.17";  $alt    = 0;
        $date       = new DateTime($today, new DateTimeZone($tmz));
        $sunrise    = $this->getSunTimings($date->format('Y-m-d'), $tmz,$lat,$lon,$alt, 2);
        $moonrise   = $this->getMoonTimings($date->format('Y-m-d'), $tmz, $lat, $lon, $alt, 2);
        $this->getPanchang();
        //return array("date"=>$date->format('dS F Y'),"day_today"=>$date->format('l'),
                      //$sunrise, $moonrise);
    }
    public function getPanchang()
    {
        $date           = new DateTime("now");
        $today          = $date->format('d.m.Y');
        $libPath        = JPATH_BASE.'/sweph/';
        putenv("PATH=$libPath");
        $h_sys = 'P';
        $output = "";
        $tithi_array    = array();
        // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        exec ("swetest -edir$libPath -p1 -d0 -b$today -n2 -fPTl -head", $output);
        $tithi          = $this->getTithiToday($date, $output);
    }
    
    public function getTithiToday($date, $output)
    {
        $array      = array();
        $i          = 1;
        foreach($output as $result)
        {
            $today       = $date->format('d.m.Y');
            $dist        = str_replace("Moo-Sun", " ", $result);
            $tithi       = str_replace($today,"",trim($dist));
            $first       = substr(trim($tithi), 0, 1);
            $date        ->add(new DateInterval('P1D'));
            if($first == "-")
            {
                $tithi  = 180 + $tithi;
                $tithi_doc  = array("paksha_".$i => "krishna", "tithi_".$i => $tithi);
                $array      = array_merge($array, $tithi_doc);
            }
            else
            {
                $tithi  = (int)$tithi;
                $tithi_doc  = array("paksha_".$i => "shukla", "tithi_".$i => $tithi);
                $array      = array_merge($array, $tithi_doc);
            }
            $i++;
        }
       
    }
}