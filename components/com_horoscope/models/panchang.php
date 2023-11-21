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
        $this->getPanchang($today, $tmz);
        //return array("date"=>$date->format('dS F Y'),"day_today"=>$date->format('l'),
                      //$sunrise, $moonrise);
    }
    public function getPanchang($today, $tmz)
    {
        $date           = new DateTime($today);
        $today          = $date->format('d.m.Y');
        $libPath        = JPATH_BASE.'/sweph/';
        putenv("PATH=$libPath");
        $h_sys = 'P';
        $output = "";
        $tithi_array    = array();
        // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        //swetest -p6 -DD -b1.12.1900 -n100 -s5 -fPTZ -head
        exec ("swetest -edir$libPath -p1 -d0 -b$today -n3 -fl -head", $output);
        //print_r($output);exit;
        //$tithi          = $this->getTithiToday($today,$tmz, $output);
        $tithi_today    = $this->getTithi($today, $output);
        return $tithi_today;
    }
    
    public function getCurrTithi($date_time, $lat,$lon,$tmz)
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $date           = new DateTime($date_time);
        $date           ->setTimeZone(new DateTimeZone($tmz));
        //echo $time;exit;
       
        $alt            = '0';
        //print_r($date);exit;
       
        //echo $timestamp." ".$offset;exit;
        // $tmz            = $tmz[0].".".(($tmz[1]*100)/60); 
        /**
         * Converting birth date/time to UTC
         */

        $day 			= $date->format('d.m.Y');
        $time 			= $date->format('H:i:s');
        //echo $day." ".$time;exit;
        $output = "";
        // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        //exec ("swetest -edir$libPath -b$day -ut$time -geopos$lon,$lat,$alt -sid1  -eswe -fPls -p1 -g, -head", $output);
        exec ("swetest -edir$libPath -p1 -d0 -b$day -ut$time -geopos$lon,$lat,$alt -n1 -fl -head", $output);
        //print_r($output);exit;
        $tithi_today    = $this->getTithi($day, $output);
        return $tithi_today;
    }
    public function getTithiToday($today,$tmz,$output)
    {
        //print_r($output);exit;
        $array      = array();
        $i          = 1;
        foreach($output as $result)
        {
            $tithi          = trim($result);
            $first          = substr(trim($tithi), 0, 1);
            if($first == "-")
            {
                $tithi          = 180 + $tithi;
                $tithi_dec      = array("paksha_".$i => "krishna", "tithi_".$i => $tithi);
                $array          = array_merge($array, $tithi_dec);
            }
            else
            {
                $tithi_dec      = array("paksha_".$i => "shukla", "tithi_".$i => $tithi);
                $array          = array_merge($array, $tithi_dec);
            }
            $i++;
        }
        //print_r($array);exit;
        $tithi_1        = number_format((float)$array['tithi_1'],2);
        $tithi_2        = number_format((float)$array['tithi_2'],2);
        $tithi_3        = number_format((float)$array['tithi_3'],2);
        //echo $tithi_1." ".$tithi_2." ".$tithi_3;exit;
        $tithi_abs          = number_format((float)$array['tithi_1'],0);
        //echo $tithi_abs;exit;
        while($tithi_abs % 12 !== 0)
        {
            $tithi_abs++;
        } 
        //echo $tithi_abs;exit;
        // below if, else check if tithi till next day 12 am changes or not
        // if it doesn't change than assign tithi for next to next(3rd day) 
        if($tithi_abs > $tithi_1 && $tithi_abs < $tithi_2)
        {
            $tithi_diff         = $tithi_2 - $tithi_1; //echo $tithi_diff;exit;
            $tithi_abs_diff     = $tithi_abs - $tithi_1;//echo $tithi_abs_diff;exit;
            $tithi_change       = ($tithi_abs_diff*24)/$tithi_diff;
        }
        else
        {
             //echo "absolute value bigger than tithi 2";exit;
             $tithi_diff        = $tithi_3 - $tithi_2;//echo $tithi_diff;exit;
             $tithi_abs_diff    = $tithi_abs - $tithi_2;//echo $tithi_abs_diff;exit;
             $tithi_change      = ($tithi_abs_diff*24)/$tithi_diff;
        }
        //echo $tithi_change;exit;
        $tithi_change           = explode(":",$this->convertDecimalToTime($tithi_change));
        //print_r($tithi_change);exit;
        date_default_timezone_set('UTC');       // set default timezone to universal time
        $date1                   = new DateTime($today);
        $date1                  ->setTimezone(new DateTimeZone($tmz));
        $date1                   ->add(new DateInterval('PT'.$tithi_change[0].'H'.$tithi_change[1]."M".$tithi_change[2]."S"));
        echo $date1->format('Y-m-d H:i:s');exit;
        
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