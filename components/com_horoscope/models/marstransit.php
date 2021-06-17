<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelMarsTransit extends HoroscopeModelLagna
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
        //exec ("swetest -edir$libPath -b1.1.2021 -sid1 -eswe -fPls -p0 -n$day -head", $output);
        exec("swetest -edir$libPath -b1.1.$year -p4 -n$day -sid1 -eswe -fTPls, -head", $output); 
        $mars_transit        = $this->getTransitChange($output);
        return $mars_transit;
        //print_r($output);exit;
        
    }
    protected function getTransitChange($output)
    {
        $change             = array();
        $i                  = 0;
        $y                  = 0;
        $array              = array();
        $round_last			= "";
		//print_r($output[15]);exit;
        foreach($output as $data)
        {
           $sun                 = trim($data);
           $sun                 = explode(" ",$sun);
           //print_r($sun);exit;
           $date                = $sun[0];
           $planet              = $sun[1];
           $deg                 = $sun[15];if(empty($deg)){$deg = $sun[14];}
           $dist                = $sun[18];if(empty($dist)){$dist = $sun[17];}
           $round               = round($deg);
           
           //echo $date." ".$planet." ".$deg." ".$round." ".$dist."<br/>";
           //echo $round."<br/>";
           if($round % 30 == "0" && $round_last != $round)
           {
			   $round_last 		= $round;
               if($round == "0"){$round = $round + 360;$deg = $deg + 360;}
               if($round > $deg)
               {
                    //echo $date." ".$planet." ".$deg." ".$round." ".$dist."<br/>";
                    $sun1        = trim($output[$i+1]);
                    $sun1        = explode(" ",$sun1);
                    $date1       = $sun1[0];
                    $planet1     = $sun1[1];
                    $deg1        = $sun1[15];if(empty($deg1)){$deg1 = $sun1[14];}
                    $dist1       = $sun1[18];if(empty($dist1)){$dist1 = $sun1[17];}
                    //echo $date1." ".$planet1." ".$deg1." higher ".$dist1."<br/><br/>";
                    $details     = $this->calculateChange($date, $round, $deg, $dist, $y);
                    $array      = array_merge($array, $details);
                }
                else
                {
                    //echo $date." ".$planet." ".$deg." ".$round." ".$dist."<br/>";
                    $sun1        = trim($output[$i-1]);
                    $sun1        = explode(" ",$sun1);
                    $date1       = $sun1[0];
                    $planet1     = $sun1[1];
                    $deg1        = $sun1[15];if(empty($deg1)){$deg1 = $sun1[14];}
                    $dist1       = $sun1[18];if(empty($dist1)){$dist1 = $sun1[17];}
                    //echo $date1." ".$planet1." ".$deg1." lower ".$dist1."<br/><br/>";
                    $details     = $this->calculateChange($date1,$round, $deg1, $dist1, $y);
                    $array      = array_merge($array, $details);
                }
                $y++;
           }
           $i++;
           
        }
        //exit;
        return $array;
        
    }
    protected function calculateChange($date,$round, $deg, $dist, $y)
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
        $get_sign           = $this->getNextSign($deg);
        $hr_min_sec         = array("date_".$y=>$date,"sign_".$y=>$get_sign,"time_".$y=>$hr[0].":".$min[0].":".$get_sec);
        return $hr_min_sec;
    }
    protected function getNextSign($deg)
    {
        $deg                = round($deg, 2);
        //echo $deg."<br/>";
        if($deg >= 0 && $deg < 30)
        {
            $sign           = "Taurus";
        }
        else if($deg >= 30 && $deg < 60)
        {
            $sign           = "Gemini";
        }
        else if($deg >= 60 && $deg < 90)
        {
            $sign           = "Cancer";
        }
        else if($deg >= 90 && $deg < 120)
        {
            $sign           = "Leo";
        }
        else if($deg >= 120 && $deg < 150)
        {
            $sign           = "Virgo";
        }
        else if($deg >= 150 && $deg < 180)
        {
            $sign           = "Libra";
        }
        else if($deg >= 180 && $deg < 210)
        {
            $sign           = "Scorpio";
        }
        else if($deg >= 210 && $deg < 240)
        {
            $sign           = "Sagittarius";
        }
        else if($deg >= 240 && $deg < 270)
        {
            $sign           = "Capricorn";
        }
        else if($deg >= 270 && $deg < 300)
        {
            $sign           = "Aquarius";
        }
        else if($deg >= 300 && $deg < 330)
        {
            $sign           = "Pisces";
        }
        else if($deg >= 330 && $deg < 360)
        {
            $sign           = "Aries";
        }
        return $sign;
    }
    
}
