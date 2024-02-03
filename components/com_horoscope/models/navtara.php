<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('panchang', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelNavtara extends HoroscopeModelPanchang
{
    public function getNakshatras()
    {
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select('DISTINCT nakshatra');
        $query          ->from($db->quoteName('#__nakshatras'));
        $db             ->setQuery($query);
        $result          = $db->loadColumn();
        return $result;
        //$query          ->clear;
    }
    /*
     * Method to get the difference between birth-time nakshatra
     * and current nakshatra. Later getDiff is called to get difference 
     * which will determine the current navtara
     * @param dob_tob The date and time of particular place (Y-m-d H:i:s format)
     * @param tmz The timezone of particular place (example: 'Asia/Kolkata')
     * @param birth_nak The birth time nakshatra of an individual
     */
    public function getNavtara($dob_tob,$lat,$lon, $tmz, $birth_nak)
    {
		
        if($tmz == "none")
        {
                $tmz            = $this->getTimeZone($lat, $lon, "rohdes");
                setcookie ('tmz', $tmz, time() + 60 * 60 * 24 * 30, '/', '', 0);
        }
		//echo $lat." ".$lon." ".$tmz;exit;
        //print_r($tmz);exit;
        $libPath        = JPATH_BASE.'/sweph/';
        $date           = new DateTime($dob_tob);
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
        exec ("swetest -edir$libPath -b$day -ut$time -geopos$lon,$lat,$alt -sid1  -eswe -fPls -p1 -g, -head", $output);
        //print_r($output);exit;
        $data                   = explode(",",$output[0]);
        $planet                 = $data[0];
        $dist                   = number_format($data[1],2);
        $hr_24                  = number_format($data[2],2);        // distance covered in 24 hours
        //echo $hr_24;exit;
        //echo $dist;exit;
        $curr_nak_details       = $this->getAbsNakshatraDeg($planet,$dist);
        //print_r($curr_nak_details);exit;
        $curr_nak               = $curr_nak_details['nakshatra'];
        //echo $curr_nak." ".$dist;exit;
        $curr_nak_down          = $curr_nak_details['abs_down_deg'];  // absolute upper degree of nakshatra
        $curr_nak_up            = $curr_nak_details['abs_up_deg'];      // absolute lower degree of nakshatra
        //$change_time            = $this->getChangeTime($dist, $curr_nak_up, $hr_24);           // function to get change times
        $dist                   = $this->getNakshatraDist($birth_nak, $curr_nak);
        
        return $dist;
        
    }
   
    public function getNakshatraDist($birth_nak, $curr_nak)
    {
        //return $curr_nak;
        //$curr_nak       = "Chitra";
        $nakshatras     = $this->getNakshatras();
        $birth_key      = array_search($birth_nak, $nakshatras);
        $curr_key       = array_search($curr_nak, $nakshatras);
        $diff           = 0;
        if($birth_key > $curr_key)
        {
            $diff       = 27 - $birth_key;
            $diff       = $diff + $curr_key;
            $diff       = $diff + 1;
        }
        else
        {
            $diff       = $curr_key - $birth_key;
            $diff       = $diff + 1;
        }
        //echo $diff;exit;
        //return $diff;
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select('description');
        $query          ->from($db->quoteName('#__navtara'));
        $query          ->where($db->quoteName('val_1').' = '.$db->quote($diff).
                            ' OR '.$db->quoteName('val_2').' = '.$db->quote($diff).
                            ' OR '.$db->quoteName('val_3').' = '.$db->quote($diff));
        $db             ->setQuery($query);
        $result         = $db->loadAssoc();
        //print_r($result);
        $desc           = str_replace('nakshatra',$curr_nak,$result['description']);
        $result         = array("birth_nak"=>$birth_nak,"curr_nak"=>$curr_nak,
                                "description" => $desc);
        return json_encode($result);
    }
    
    /*
     * This function calculates the approx time 
     * when nakshatra changes
     * @param curr_dist The current distance nakshatra has travelled in decimals
     * @param nak_end The end distance in decimal after which another nakshatra starts
     * @param tot_dist The total distance Moon travels in 24 hours 
     */
    public function getChangeTime($curr_dist, $nak_end, $hr_24)
    {
        $dist_left      = $nak_end - $curr_dist;
        $dist_left      = number_format($dist_left, 2);
        
        echo $curr_dist." ".$nak_end." ".$hr_24;exit;
    }
}
?>
