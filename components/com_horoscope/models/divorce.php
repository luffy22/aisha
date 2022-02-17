<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('mangaldosha', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelDivorce extends HoroscopeModelMangalDosha
{
    public $data;
 
    public function addDivorceDetails($details)
    {
        //print_r($details);exit;
        $result         = $this->addUserDetails($details, "divorce");
        if($result)
        {
            //echo "query inserted";exit;
            $app        = JFactory::getApplication();
            $link       = JURI::base().'divorce?chart='.str_replace("horo","chart",$result);
            $app        ->redirect($link);
        }
    }
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $chart_id       = $jinput->get('chart', 'default_value', 'filter');
        $chart_id       = str_replace("chart","horo", $chart_id);
        
        $user_data      = $this->getUserData($chart_id);
        if(empty($user_data))
        {
            return;
        }
        else
        {
            $dob_tob        = $user_data['dob_tob'];
            if(array_key_exists("timezone", $user_data))
            {     
                $timezone       = $user_data['timezone'];
            }
            else
            {
                $timezone   = $user_data['tmz_words'];
            }


            $date           = new DateTime($dob_tob, new DateTimeZone($timezone));
            //print_r($date);exit;
            $timestamp      = strtotime($date->format('Y-m-d H:i:s'));       // date & time in unix timestamp;
            $offset         = $date->format('Z');       // time difference for timezone in unix timestamp
            //echo $timestamp." ".$offset;exit;
            // $tmz            = $tmz[0].".".(($tmz[1]*100)/60); 
            /**
             * Converting birth date/time to UTC
             */
            $utcTimestamp = $timestamp - $offset;

            //echo $utcTimestamp;exit;
            //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';

            $date = date('d.m.Y', $utcTimestamp);
            $time = date('H:i:s', $utcTimestamp);
            //echo $date." ".$time;exit;
            $h_sys = 'P';
            $output = "";

            exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m789 -g, -head", $output);
            //print_r($output);exit;

            # OUTPUT ARRAY
            # Planet Name, Planet Degree, Planet Speed per day
            $asc            = $this->getAscendant($user_data);
            $planets        = $this->getPlanets($output);
            $data           = array_merge($asc,$planets);
            //print_r($data);exit;
            //$details        = $this->getDetails($data);
            //print_r($details);exit;
            $newdata        = array();
            foreach($data as $key=>$distance)
            {
                // this loop gets the horoscope sign of Ascendant, Moon & Jupiter or Venus
                $dist                   = str_replace(":r","",$distance);
                $dist2                  = $this->convertDecimalToDegree(str_replace(":r","",$distance),"details");
                $sign                   = $this->calcDetails($dist);
                $sign_num               = array($key."_num"=>$this->getSignNum($sign));
                $getsign                = array($key."_sign"=>$sign);
                $navamsha               = $this->getNavamsha($key, $sign, $dist2);
                $navamsha_sign_num      = array($key."_navamsha_num"=>$this->getSignNum($navamsha[$key.'_navamsha_sign']));
                $newdata                = array_merge($newdata,$getsign,$sign_num,$navamsha, $navamsha_sign_num);
            }
            //print_r($newdata);exit;
            $asc_house                  = $this->getHouse("Ascendant",$newdata);
            $moon_house                 = $this->getHouse("Moon",$newdata);
            $ven_house                  = $this->getHouse("Venus",$newdata);
            $nav_house                  = $this->getHouse("Ascendant_navamsha",$newdata);
            unset($newdata);
            $check_asc_dosha            = $this->checkDosha("asc",$asc_house);
            $check_moon_dosha           = $this->checkDosha("moon",$moon_house);
            $check_ven_dosha            = $this->checkDosha("ven",$ven_house);
            $check_nav_dosha            = $this->checkDosha("nav",$nav_house); 
            $percent                    = $check_asc_dosha['asc_percent']+$check_moon_dosha['moon_percent']+$check_ven_dosha['ven_percent']+$check_nav_dosha['nav_percent'];
            $percent                    = array("mangaldosha"=>$percent);
            $asc_divorce                = $this->checkAscendant($data['Ascendant']);
            $asc_house                  = $this->checkPlanetsInHouse($data, 1);
            $asc_asp                    = $this->checkAspectsOnHouse($data, 1);
            $seventh_house              = $this->checkPlanetsInHouse($data, 7);
            $seventh_asp                = $this->checkAspectsOnHouse($data, 7);
            $eight_house                = $this->checkPlanetsInHouse($data, 8);
            $eight_asp                  = $this->checkAspectsOnHouse($data, 8);
            $twelfth_house              = $this->checkPlanetsInHouse($data,12);
            $twelfth_asp                = $this->checkAspectsOnHouse($data, 12);
            $array                      = array();
            $array                      = array_merge($array,$user_data,$percent, $asc_divorce,
                                                        $asc_house, $asc_asp,
                                                        $seventh_house,$seventh_asp,
                                                        $eight_house,$eight_asp,
                                                        $twelfth_house, $twelfth_asp);
            return $array;
        }
    }
    protected function checkAscendant($asc)
    {
        $sign                   = $this->calcDetails($asc);
        $array                  = array("asc_sign" => $sign);
        return $array;
    }
    
    
}
?>
