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
        $this->getPanchang($sunrise);
        //return array("date"=>$date->format('dS F Y'),"day_today"=>$date->format('l'),
                      //$sunrise, $moonrise);
    }
    public function getPanchang($sunrise)
    {
        $date           = new DateTime(date('29-04-2019'));
        $today          = $date->format('d.m.Y');
        $libPath        = JPATH_BASE.'/sweph/';
        putenv("PATH=$libPath");
        $h_sys = 'P';
        $output = "";
        $tithi_array    = array();
        // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        //swetest -p6 -DD -b1.12.1900 -n100 -s5 -fPTZ -head
        exec ("swetest -edir$libPath -p1 -d0 -b$today -n2 -fPTl -head", $output);
        //print_r($output);exit;
        $tithi          = $this->getTithiToday($date, $output, $sunrise);
    }
    
    public function getTithiToday($date, $output, $sunrise)
    {
        $rise1      = new DateTime($sunrise['sun_rise_1']); 
        $rise1_dec  = $this->convertTimeToDecimal($rise1->format('H:i:s'));
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
                $tithi  = 360 + $tithi;
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
        //print_r($array);exit;
        $tithi_lower        = number_format((float)$array['tithi_1'],2);
        $tithi_upper        = number_format((float)$array['tithi_2'],2);
        $tithi_abs          = round($tithi_lower, 0);
        while($tithi_abs % 15 !== 0)
        {
            $tithi_abs++;
            $tithi_abs_diff     = $tithi_abs - $tithi_lower;      // this is difference between lower tithi & change of tithi(90,105,120 etc)
        } 
        //echo $tithi_abs_diff;exit;
        if($tithi_upper <  $tithi_lower)
        {
            $tithi_upper    = $tithi_upper + 360;
        }
        $tithi_diff         = $tithi_upper - $tithi_lower;
        $tithi_diff         = number_format((float)$tithi_diff,2);
        //echo $tithi_abs_diff." ".$rise1_dec." ".$tithi_diff;exit;
        $tithi_change       = ($tithi_abs_diff*24)/$tithi_diff;
        $tithi_change       = $this->convertDecimalToTime($tithi_change);
        echo $tithi_change;exit;
        
    }
    public function convertDecimalToTime($dec)
    {
         // Converts decimal format to DMS ( Degrees / minutes / seconds ) 
        $vars = explode(".",$dec);
        $deg = $vars[0]%24;
        $tempma = "0.".$vars[1];

        $tempma = $tempma * 3600;
        $min = floor($tempma / 60);
        $sec = round($tempma - ($min*60),0);
        return $deg.":".$min.":".$sec;
    }
    public function convertTimeToDecimal($time)
    {
        $hms = explode(":", $time);
        $time   = $hms[0] + ($hms[1]/60) + ($hms[2]/3600);
        $time   = round($time,2);
        return $time;
    }

}