<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelMuhurat extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        
        $dtz = new DateTimeZone("Asia/Kolkata"); //Your timezone
        $date = new DateTime(date("Y-m-d H:i:s"), $dtz);
        //echo $date->format('d.m.Y H:i:s');exit;        
       
        $date           = $date->format('d.m.Y');
        $long           = "72.57";
        $lat            = "23.02";
        //$date = date('d.m.Y', $utcTimestamp);
        //$time = date('H:i:s', $utcTimestamp);
        
        $h_sys = 'P';
        $output = "";
        //echo $utcTimestamp;exit;
        //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';
        exec ("swetest -b$date -topo[$long,$lat,0] -rise  -hindu -p0 -head", $output);
        print_r($output);exit;

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
        $data               = array_merge($data, $get_dasha,$get_remain_dasha);
        return $data;
        
    }

}