<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('suntransit', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelMarsTransit extends HoroscopeModelSunTransit
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $year           = $jinput->get('year', 'default_value', 'filter');
       
         if($year == "default_value")
         {
            $year       = date('Y');
         }
         
         if($year % 4 == "0")
         {
             $day       = '366';
         }
         else
         {
             $day       = '365';
         }
        $location       = array("location"=>$loc);
        putenv("PATH=$libPath");
        $h_sys = 'P';
        $output = "";
        // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        //swetest -p6 -DD -b1.12.1900 -n100 -s5 -fPTZ -head
        //exec("swetest -edir$libPath -b1.1.2021 -eswe -sid1 -g -fPTls -p0 -n365, -head", $output);
        exec("swetest -edir$libPath -b1.1.$year -p4 -n$day -sid1 -eswe -fTPls, -head", $output); 
        $mars_transit        = $this->getTransitChange($output, $year);
        return $mars_transit;
        //print_r($output);exit;
        
    }
    protected function getTransitChange($output, $year)
    {
        $change             = array();
        $i                  = 0;
        $y                  = 0;
        $array              = array();
        $round_last			= "";
        //print_r($output[303]);exit;
        foreach($output as $data)
        {
           $sun                 = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $data)));
           $sun                 = explode(" ",$sun);
           //print_r($sun);exit;
           $date                = $sun[0];
           $planet              = $sun[1];
           $deg                 = $sun[2];
           $dist                = $sun[3];
           $round               = round($deg);
           $floor               = floor($deg);
           //echo $date." ".$planet." ".$deg." ".$round." ".$dist."<br/>";
           //echo $round."<br/>";
           if($dist < 0)
           {
               if($floor%30=="0" && $deg+$dist < $floor && $deg > $floor)
               {
                   //echo $date." ".$planet." ".$deg." ".$floor." ".$dist;exit;
                    $details     = $this->calculateChange2($date, $floor, $deg, $dist, $y);
                    $array      = array_merge($array, $details);
                    $y++;
               }
           }
           else
           {
               //echo "calls2";exit;
                if($round % 30 =="0" && $deg+$dist > $round && $deg < $round && $round_last != $round)
                {
                    $round_last         = $round;
                    $details     = $this->calculateChange($date, $round, $deg, $dist, $y, $tmz);
                    $array      = array_merge($array, $details);
                    $y++;
                }
                else if($round % 30 == "0" && $deg+$dist > $round && $deg > $round && $round_last != $round)
                {
                    $round_last         = $round;
                    //echo $date." ".$planet." ".$deg." ".$round." ".$dist."<br/>";
                    $sun1        = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $output[$i-1])));
                    $sun1        = explode(" ",$sun1);
                    //print_r($sun1);exit;
                    $date1       = $sun1[0];
                    $planet1     = $sun1[1];
                    $deg1        = $sun1[2];
                    $dist1       = $sun1[3];
                    //echo $date1." ".$planet1." ".$deg1." lower ".$dist1."<br/><br/>";
                    $details     = $this->calculateChange($date1,$round, $deg1, $dist1, $y, $tmz);
                    $array      = array_merge($array, $details);
                    $y++;
                }
                
           }
           $i++;
            
        }
        $curr_sign          = array("curr_sign" =>$this->getCurrTransit($year));
        $array              = array_merge($array, $curr_sign);
       return $array;
        
    }
    protected function calculateChange($date,$round, $deg, $dist, $y, $tmz)
    {
        $diff               = $round - $deg;
        $get_dist           = (1440*round($diff,2))/round($dist,2);
        $get_dist           = round($get_dist, 2);
        $get_hr             = ($get_dist*1)/60;
        $hr                 = explode(".",$get_hr);
        $min                = ".".$hr[1];
        $get_min            = ($min*60)/1;
        $min                = explode(".",$get_min);
        $sec                = ".".$min[1];
        $get_sec            = ($sec*60)/1;
        $get_sec            = round($get_sec);
        $get_sign           = $this->getSign($deg,"next");
        if($tmz == "")
        {
            $date           = new DateTime(str_replace(".","-",$date)." ".$hr[0].":".$min[0].":".$get_sec, new DateTimeZone('UTC'));
            $date           ->setTimezone(new DateTimeZone('Asia/Kolkata'));
        }
        else
        {
            $date           = new DateTime(str_replace(".","-",$date)." ".$hr[0].":".$min[0].":".$get_sec, new DateTimeZone('UTC'));
            $date           ->setTimezone(new DateTimeZone($tmz));
        }
        $hr_min_sec         = array("date_".$y=>$date->format('dS F Y'),"sign_".$y=>$get_sign,"time_".$y => $date->format('h:i a'),"day_".$y=>$date->format('l'));
        return $hr_min_sec;
    }
    protected function calculateChange2($date,$round, $deg, $dist, $y)
    {
        //echo $deg." ".$round." ".$dist;exit;
        $diff               = $round- $deg;
        //echo $diff;exit;
        $get_dist           = (1440*round($diff,2))/round($dist,2);
        $get_dist           = round($get_dist, 2);
        $get_hr             = ($get_dist*1)/60;

        $hr                 = explode(".",$get_hr);
        $min                = ".".$hr[1];
        $get_min            = ($min*60)/1;
        $min                = explode(".",$get_min);
        $sec                = ".".$min[1];
        $get_sec            = ($sec*60)/1;
        $get_sec            = round($get_sec);
        $get_sign           = $this->getSign($deg,"prev");
         if($tmz == "")
        {
            $date           = new DateTime(str_replace(".","-",$date)." ".$hr[0].":".$min[0].":".$get_sec, new DateTimeZone('UTC'));
            $date           ->setTimezone(new DateTimeZone('Asia/Kolkata'));
        }
        else
        {
            $date           = new DateTime(str_replace(".","-",$date)." ".$hr[0].":".$min[0].":".$get_sec, new DateTimeZone('UTC'));
            $date           ->setTimezone(new DateTimeZone($tmz));
        }
        $hr_min_sec         = array("date_".$y=>$date->format('dS F Y'),"sign_".$y=>$get_sign,"time_".$y => $date->format('h:i a'),"day_".$y=>$date->format('l'));
        return $hr_min_sec;
    }
    protected function getCurrTransit($year)
    {
        //echo $year;exit;
        $libPath        = JPATH_BASE.'/sweph/';
        
        $date               = date('d.m.Y');
        $time               = date('H:i:s');
        $curr_year          = date('Y');
        if($year == $curr_year)
        {
            $h_sys              = 'P';
            $output             = "";
            // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
            exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPl -p4 -g, -head", $output);
            $sun                = trim(preg_replace('/\s\s+/', '', str_replace("\n", "", $output[0])));
            $sun                = explode(", ",$sun);
            $curr_deg           = $sun[1];
            $get_sign           = $this->getCurrSign($curr_deg);
            return $get_sign;
        }
        else
        {
            return "null";
        }
    }
    protected function getSign($deg, $oper)
    {
        //echo $deg."<br/>";
        if($deg >= 0 && $deg < 30)
        {
            if($oper == "next")
            {
                $sign           = "Taurus";
            }
            else
            {
                $sign           = "Pisces";
            }
        }
        else if($deg >= 30 && $deg < 60)
        {
            if($oper == "next")
            {
                $sign           = "Gemini";
            }
            else
            {
                $sign           = "Aries";
            }
        }
        else if($deg >= 60 && $deg < 90)
        {
            if($oper == "next")
            {
                $sign           = "Cancer";
            }
            else
            {
                $sign           = "Taurus";
            }
        }
        else if($deg >= 90 && $deg < 120)
        {
            if($oper == "next")
            {
                $sign           = "Leo";
            }
            else
            {
                $sign           = "Gemini";
            }
        }
        else if($deg >= 120 && $deg < 150)
        {
            if($oper == "next")
            {
                $sign           = "Virgo";
            }
            else
            {
                $sign           = "Cancer";
            }
        }
        else if($deg >= 150 && $deg < 180)
        {
            if($oper == "next")
            {
                $sign           = "Libra";
            }
            else
            {
                $sign           = "Leo";
            }
        }
        else if($deg >= 180 && $deg < 210)
        {
            if($oper == "next")
            {
                $sign           = "Scorpio";
            }
            else
            {
                $sign           = "Virgo";
            }
        }
        else if($deg >= 210 && $deg < 240)
        {
            if($oper == "next")
            {
                $sign           = "Sagittarius";
            }
            else
            {
                $sign           = "Libra";
            }
        }
        else if($deg >= 240 && $deg < 270)
        {
            if($oper == "next")
            {
                $sign           = "Capricorn";
            }
            else
            {
                $sign           = "Scorpio";
            }
        }
        else if($deg >= 270 && $deg < 300)
        {
            if($oper == "next")
            {
                $sign           = "Aquarius";
            }
            else
            {
                $sign           = "Sagittarius";
            }
        }
        else if($deg >= 300 && $deg < 330)
        {
            if($oper == "next")
            {
                $sign           = "Pisces";
            }
            else
            {
                $sign           = "Capricorn";
            }
        }
        else if($deg >= 330 && $deg < 360)
        {
            if($oper == "next")
            {
                $sign           = "Aries";
            }
            else
            {
                $sign           = "Aquarius";
            }
        }
        return $sign;
    }
    
}
