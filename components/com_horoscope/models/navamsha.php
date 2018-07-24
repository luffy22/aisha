<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelNavamsha extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $navamsha       = $jinput->get('chart', 'default_value', 'filter');
        $navamsha       = str_replace("chart","horo", $navamsha);
        
        $result         = $this->getUserData($navamsha);
        
        $fname          = $result['fname'];
        $gender         = $result['gender'];
        $dob            = $result['dob'];
        $tob            = $result['tob'];
        $pob            = $result['pob'];
        $lat            = explode(":",$result['lat']);
        if($lat[2]=="N")
        {
            $lat        = $lat[0].".".$lat[1];
        }
        else if($lat[2]=="S")
        {
            $lat        = "-".$lat[0].".".$lat[1];
        }
        $lon            = explode(":",$result['lon']);
        if($lon[2]=="E")
        {
            $lon        = $lon[0].".".$lon[1];
        }
        else if($lon[2]=="W")
        {
            $lon        = "-".$lon[0].".".$lon[1];
        }
        
        $tmz            = explode(":",$result['timezone']);
        $tmz            = $tmz[0].".".(($tmz[1]*100)/60); 
        

        $birthDate = new DateTime($dob." ".$tob);

         //echo $birthDate->format('Y-m-d H:i:s'); exit;;
        //$timezone = +5.50; 

        /**
         * Converting birth date/time to UTC
         */
        $offset = $tmz * (60 * 60);
        $birthTimestamp = strtotime($birthDate->format('Y-m-d H:i:s'));
        $utcTimestamp = $birthTimestamp - $offset;
        //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';

        $date = date('d.m.Y', $utcTimestamp);
        $time = date('H:i:s', $utcTimestamp);
        
        $h_sys = 'P';
        $output = "";
        // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -house$lon,$lat,$h_sys -fPls -p0142536m789 -g, -head", $output);
        $planets        = $this->getPlanets($output);
        print_r($planets);exit;
    }
   
    
    
}