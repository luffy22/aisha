<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelSunTransit extends HoroscopeModelLagna
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
        exec("swetest -edir$libPath -b1.1.$year -p0 -n$day -sid1 -eswe -fPls, -head", $output); 
        $sun_transit        = $this->getTransitChange($output);
        //print_r($output);exit;
    }
    protected function getTransitChange($output)
    {
        $change             = array();
        $i                  = 0;
        $signs              = array("0","30","60","90","120","150","180",
                                    "210","240","270","300","330","360");
        $array              = array();
        foreach($output as $data)
        {
           $sun                 = trim($data);
           $sun                 = explode(" ",$sun);
           $planet              = $sun[0];
           $deg                 = $sun[14];
           $dist                = $sun[17];
           $round               = round($deg);
           echo $planet." ".$deg." ".$dist."<br/>";
           //echo $round."<br/>";
           //if(in_array($round, $signs))
           //{
               //echo $deg." ".$dist."<br/>";
               /*$abs_deg         = round($deg);
               $diff            = $abs_deg - $deg;
               $get_dist        = (1440*round($diff,2))/round($dist,2);
               $get_dist        = round($get_dist, 2);
               $get_hr          = ($get_dist*1)/60;
               $hr              = explode(".",$get_hr);
               $min             = ".".$hr[1];
               $get_min         = ($min*60)/1;
               $min             = explode(".",$get_min);
               $sec             = ".".$min[1];
               $get_sec         = ($sec*60)/1;
               $get_sec         = round($get_sec);
               $hr_min_sec      = array("date"=>$i+1,"hr"=>$hr[0],"min"=>$min[0],"sec"=>$get_sec);
               $array           = array_merge($array, $hr_min_sec);
               //print_r($array);exit;*/
           //}
           //$i++;
           
        }
        exit;
    }
    
}