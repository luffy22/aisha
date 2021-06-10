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
        exec("swetest -edir$libPath -b1.1.$year -p0 -sid1 -eswe -fPls -g, -head", $output);        print_r($output);exit;
        $sun_transit        = $this->getTransitChange($output);
        
    }
    protected function getTransitChange($output)
    {
        $change             = array();
        
        foreach($output as $data)
        {
           echo $data;exit;
        }
    }
    
}