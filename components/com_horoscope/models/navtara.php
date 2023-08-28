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
    public function getNavtara($dob_tob, $tmz, $birth_nak)
    {
        //print_r($tmz);exit;
        $libPath        = JPATH_BASE.'/sweph/';
        $date           = new DateTime($dob_tob);
        $date           ->setTimeZone(new DateTimeZone($tmz));
        //echo $date->format('d-m-Y H:i:s');exit;
        $lat            = '23.02';
        $lon            = '72.57';
        //print_r($date);exit;
        $timestamp      = strtotime($date->format('Y-m-d H:i:s'));       // date & time in unix timestamp;
        $offset         = $date->format('Z');       // time difference for timezone in unix timestamp
            //echo $timestamp." ".$offset;exit;
            // $tmz            = $tmz[0].".".(($tmz[1]*100)/60); 
            /**
             * Converting birth date/time to UTC
             */
        $utcTimestamp = $timestamp - $offset;
         
        $date = date('d.m.Y', $utcTimestamp);
        $time = date('H:i:s', $utcTimestamp);
        
        $output = "";
        // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
        exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p1 -g, -head", $output);
        //print_r($output);exit;
        $data                   = explode(",",$output[0]);
        $planet                 = $data[0];
        $dist                   = number_format($data[1],2);
        //echo $dist;exit;
        $curr_nak_details       = $this->getNakshatraDeg($planet,$dist);
        $curr_nak               = $curr_nak_details['nakshatra'];
        $curr_nak_down          = $curr_nak_details['abs_down_deg'];  // absolute upper degree of nakshatra
        $curr_nak_up            = $curr_nak_details['abs_up_deg'];      // absolute lower degree of nakshatra
        $dist           = $this->getNakshatraDist($birth_nak, $curr_nak);
        return $dist;
        
    }
   
    public function getNakshatraDist($birth_nak, $curr_nak)
    {
        //return $curr_nak;
        //$curr_nak       = "Shravana";
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
        $desc           = str_replace('nakshatra',$curr_nak,$result['description']);
        $result         = array("birth_nak"=>$birth_nak,"curr_nak"=>$curr_nak,
                                "description" => $desc);
        return json_encode($result);
    }
    
    
}
?>
