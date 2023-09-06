<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelVimshottari extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $navamsha       = $jinput->get('chart', 'default_value', 'filter');
        $navamsha       = str_replace("chart","horo", $navamsha);
        
        $result         = $this->getUserData($navamsha);
        if(empty($result))
        {
            return;
        }
        else
        {
            $dob_tob        = $result['dob_tob'];
            if(array_key_exists("timezone", $result))
            {    
                $timezone       = $result['timezone'];
            }
            else
            {
                $timezone   = $result['tmz_words'];
            }

            $date           = new DateTime($dob_tob, new DateTimeZone($timezone));

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
            //echo $date." ".$time;exit;
            $h_sys = 'P';
            $output = "";
            //echo $utcTimestamp;exit;
            //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';

            exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m -g, -head", $output);
            //print_r($output);exit;

            # OUTPUT ARRAY
            # Planet Name, Planet Degree, Planet Speed per day
            //$asc            = $this->getAscendant($result);
            $planets        = $this->getPlanets($output);
            $data           = array();
            foreach($planets as $planet=>$dist)
            {
                $dist2          = $this->convertDecimalToDegree($dist, "details");
                $sign           = $this->calcDetails($dist);
                $navamsha       = $this->getNavamsha($planet,$sign,$dist2);
                $dist           = array($planet."_dist"=>$dist2);
                $details        = array($planet."_sign"=>$sign);
                $data           = array_merge($data, $dist, $details, $navamsha);
            }
            //print_r($data);exit;
            $moon_sign          = $data['Moon_sign'];                  
            $moon_dist          = $data['Moon_dist'];
            $moon_nakshatra     = $this->getNakshatra($moon_sign, $moon_dist);
            $nakshatra_deg      = $this->getNakshatraDeg($moon_sign, $moon_nakshatra, $moon_dist);
            $get_dasha          = $this->getDashaPeriod($dob_tob, $nakshatra_deg);
            $period_id          = $get_dasha['dob_period_id'];$dasha_end    = $get_dasha['dob_sub_end'];
            //$get_current        = $this->getCurrentPeriod($period_id, $dasha_end);
            $get_remain_dasha   = array("get_remain_dasha"=>$this->getRemainDasha($period_id, $dasha_end));
            $data               = array_merge($result,$data, $get_dasha,$get_remain_dasha);
            return $data;
        }
        
    }
    protected function getNakshatra($moon_sign, $moon_dist)
    {
        //echo $moon_sign."&nbsp;".$moon_dist;exit;
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName('nakshatra'));
        $query          ->from($db->quoteName('#__nakshatras'));
        $query          ->where($db->quoteName('sign').'='.$db->quote($moon_sign).' AND '.
                                $db->quote($moon_dist).' BETWEEN '.
                                $db->quoteName('down_deg').' AND '.
                                $db->quoteName('up_deg'));
        $db             ->setQuery($query);
        $result         = $db->loadAssoc();
        return $result['nakshatra'];
        
    }
    /*
     * This method returns the distance covered and left to be covered.
     * @param sign The astrological sign in which moon is located
     * @param nakshatra The actual nakshatra in which moon is located
     * @param degree The degree in nakshatra where moon is located
     */
    protected function getNakshatraDeg($sign, $nakshatra, $deg)
    {
        //echo $moon_sign."&nbsp;".$moon_dist;exit;
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName(array('sign','nakshatra_lord','down_deg','up_deg')));
        $query              ->from($db->quoteName('#__nakshatras'));
        $query              ->where($db->quoteName('nakshatra').'='.$db->quote($nakshatra));
        $db                 ->setQuery($query);
        $result             = $db->loadAssocList();
        $nakshatra_lord     = $result[0]['nakshatra_lord'];
        //print_r($result);exit;
        //echo $sign." ".$nakshatra." ".$deg;exit;
        $deg                = explode(".",$deg);
        $count              = count($result);
        if($count > 1)
        {
            $sign1          = $result[0]['sign'];
            $down_deg1      = explode(".",$result[0]['down_deg']);
            $up_deg1        = explode(".",$result[0]['up_deg']);//echo $up_deg1;exit;
            $sign2          = $result[1]['sign'];
            $down_deg2      = explode(".",$result[1]['down_deg']);
            $up_deg2        = explode(".",$result[1]['up_deg']);

            if($sign == $sign1)
            {
                $down_diff  = $this->subDegMinSec($deg[0], $deg[1], 0, $down_deg1[0], $down_deg1[1], 0);
                $up_diff1   = explode(":",$this->subDegMinSec($up_deg1[0], ($up_deg1[1]+1), 0, $deg[0], $deg[1], 0));
                $up_diff2   = explode(":",$this->subDegMinSec($up_deg2[0], ($up_deg2[1]+1), 0, $down_deg2[0], $down_deg2[1], 0));
                $up_diff    = $this->addDegMinSec($up_diff1[0],$up_diff1[1], 0, $up_diff2[0], $up_diff2[1], 0);
            }
            else
            {
                $down_diff1 = explode(":",$this->subDegMinSec($deg[0], $deg[1], 0, $down_deg2[0], $down_deg2[1], 0));
                $down_diff2 = explode(":",$this->subDegMinSec($up_deg1[0], ($up_deg1[1]+1), 0, $down_deg1[0], $down_deg1[1],0));
                $down_diff  = $this->addDegMinSec($down_diff1[0], $down_diff1[1], 0, $down_diff2[0], $down_diff2[1], 0);
                $up_diff    = $this->subDegMinSec($up_deg2[0], ($up_deg2[1]+1), 0, $deg[0], $deg[1], 0);
            }
        }
        else 
        {
            $sign           = $result[0]['sign'];
            $down_deg       = explode(".",$result[0]['down_deg']);
            $up_deg         = explode(".",$result[0]['up_deg']);
            $down_diff      = $this->subDegMinSec($deg[0], $deg[1], 0, $down_deg[0], $down_deg[1], 0);
            $up_diff        = $this->subDegMinSec($up_deg[0], ($up_deg[1]+1), 0, $deg[0], $deg[1], 0);

        }
       return array("nakshatra_lord"=>$nakshatra_lord,"down_diff"=>$down_diff, "up_diff"=>$up_diff);
        
    }
    protected function getDashaPeriod($date_time, $details)
    {
        //print_r($details);exit;
        $array              = array();
        $dasha              = array("Ketu"=>7,"Venus"=>20,"Sun"=>6,"Moon"=>10,
                                    "Mars"=>7,"Rahu"=>18,"Jupiter"=>16,
                                    "Saturn"=>19,"Mercury"=>17);        // total years of dasha for planets
        $nakshatra_lord     = $details['nakshatra_lord'];       // get the lord of nakshatra where moon is located
        $dasha_years        = $dasha[$nakshatra_lord];      // get the total years dasha would last
        
        $up_deg             = explode(":",$details['up_diff']);
        $down_deg           = explode(":",$details['down_diff']);
        $up_deg_min         = ($up_deg[0]*60)+$up_deg[1];
        $remainder          = $up_deg_min/800;
        $year               = $remainder*$dasha_years;
        $month              = explode(".",$year);
        $year               = $month[0];
        $month              = ("0.".$month[1])*12;
        $day                = explode(".",$month);
        $month              = $day[0];
        $day                = ("0.".$day[1])*30;
        $day                = explode(".",$day);
        $day                = $day[0];
        $balance            = array("balance_of_dasha" => $year." Years ".$month." Months ".$day." Days");
        $array              = array_merge($array, $balance);
        //echo $year." Years ".$month." Months ".$day." Days";exit;
        $dasha              = new DateTime($date_time);
        $dasha              ->add(new DateInterval('P'.$year.'Y'.$month.'M'.$day.'D'));
        
        $dob                = new DateTime($date_time);
        // database connection
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              = "SELECT vim_id, main_period, sub_period, year_months_days FROM jv_horo_vimshottari where main_period = '".strtolower($nakshatra_lord)."' ORDER BY vim_id DESC";
        $db                 ->setQuery($query);
        $result             = $db->loadAssocList();
        //print_r($result);exit;
        foreach($result as $data)
        {
            $period         = $data['year_months_days'];
            $end            = $dasha->format('Y-m-d');
            $dasha          ->sub(new DateInterval($period));
            $start          = $dasha->format('Y-m-d');
            if($dob < $dasha)
            {
                continue; 
            }
            else
            {
                $dob_dasha      = array("dob_period_id"=>$data['vim_id'],"main_dob_period"=>$data['main_period'],"sub_dob_period"=>$data['sub_period'],
                                        "dob_sub_start"=>$dob->format('Y-m-d'), "dob_sub_end"=>$end);
                $array          = array_merge($array, $dob_dasha);
                return $array;exit;
            }
            
        }
        
    }
    /*protected function getCurrentPeriod($id, $dasha_end)
    {
        $current            = new DateTime();
        
        $dasha              = new DateTime($dasha_end);
        $array              = array();
        $array                  = array();
        $db                     = JFactory::getDbo();  // Get db connection
        $query                  = $db->getQuery(true);
        $new_array              = array();
        $query                  = "SELECT main_period, sub_period, year_months_days FROM jv_horo_vimshottari WHERE vim_id > '".$id."' UNION "
                . "                 SELECT main_period, sub_period, year_months_days FROM jv_horo_vimshottari WHERE  vim_id < '".$id."'";
        $db                 ->setQuery($query);
        $result             = $db->loadAssocList();
        //print_r($result);exit;
        foreach($result as $data)
        {
            $start          = $dasha->format('d-m-Y');
            $dasha          ->add(new DateInterval($data['year_months_days']));
            $end            = $dasha->format('d-m-Y');
            if($dasha < $current)
            {
                continue;
            }
            else
            {
                $current_dasha  = array("current_main"=>$data['main_period'],"current_sub"=>$data['sub_period'],
                                        "start_current"=>$start,"end_current"=>$end);
                $array          = array_merge($array, $current_dasha);
                return $array;exit;
            }
        }
        
    }*/
    protected function getRemainDasha($period_id, $dasha_end)
    {
        $dasha                  = new DateTime($dasha_end);
        unset($array);
        $array                  = array();
        $db                     = JFactory::getDbo();  // Get db connection
        $query                  = $db->getQuery(true);
        $new_array              = array();
        $query                  = "SELECT main_period, sub_period, year_months_days FROM jv_horo_vimshottari WHERE vim_id > '".$period_id."' UNION "
                . "                 SELECT main_period, sub_period, year_months_days FROM jv_horo_vimshottari WHERE  vim_id < '".$period_id."'";
        $db                 ->setQuery($query);
        $result             = $db->loadAssocList();
        return $result;
        /*$i                  = 0;
        //print_r($result);exit;
        foreach($result as $data)
        {            
            $period         = $data['year_months_days'];
            $start          = $dasha->format('d-m-Y');
            $dasha          ->add(new DateInterval($period));
            $end            = $dasha->format('d-m-Y');
                        
            $dob_dasha      = array("main_period_".$i=>$data['main_period'],"sub_period_".$i=>$data['sub_period'],
                                        "sub_start_".$i=>$start, "sub_end_".$i=>$end);
            $array          = array_merge($array, $dob_dasha);
            $i++;
            
        }
       
      return $array;*/
    }
}
