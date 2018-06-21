<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');

class HoroscopeModelNavamsha extends HoroscopeModelLagna
{
    public function getData()
    {
        $jinput     = JFactory::getApplication()->input;
        $navamsha   = $jinput->get('chart', 'default_value', 'filter');
        $navamsha   = str_replace("chart","horo", $navamsha);
        
        $db         = JFactory::getDbo();
        $query      = $db->getQuery(true);
        

        $query      ->select($db->quoteName(array('fname','gender','dob','tob','pob','lon','lat','timezone','dst')));
        $query      ->from($db->quoteName('#__horo_query'));
        $query      ->where($db->quoteName('uniq_id') . ' = '. $db->quote($navamsha));
        $db         ->setQuery($query);
        $result     = $db->loadAssoc();
        
        $fname          = $result['fname'];
        $gender         = $result['gender'];
        $dob            = $result['dob'];
        $tob            = $result['tob'];
        $pob            = $result['pob'];
        $lat            = $result['lat'];
        $lon            = $result['lon'];
        $tmz            = $result['timezone'];
        $dst            = $result['dst'];
        
        // fetches the Indian standard time and Indian Date for the given time and birth
        $getGMT         = explode("_",$this->getGMTTime($dob, $tob, $tmz, $dst));
        $gmt_date       = $getGMT[0];
        $gmt_time       = $getGMT[1];

        /* 
        *  @param fullname, gender, date of birth, time of birth, 
        *  @param longitude, latitude, timezone and
        *  @param timezone in hours:minutes:seconds format
        */ 
        $data  = array(
                        "fname"=>$fname,"gender"=>$gender,"dob"=>$dob,
                        "tob"=>$tob,"pob"=>$pob,"lon"=>$lon,"lat"=>$lat,"tmz"=>$tmz,
                        "dst"=>$dst,"gmt_date"=>$gmt_date,"gmt_time"=>$gmt_time
                    );
        //print_r($data);exit;
       $horo                = $this->getWesternHoro($data);
       //$ayanamsha          
    }
    public function applyAyanamsha($data)
    {
     //echo "ayanamsha correction";exit;
        //print_r($data);exit;
        $grahas                 = array();
        $year                   = substr($dob,0,4);       // get the year from dob. For example 2001

        $db                     = JFactory::getDbo();
        $query                  = $db->getQuery(true);
        $query                  ->select($db->quoteName('ayanamsha'));
        $query                  ->from($db->quoteName('#__lahiri_ayanamsha'));
        $query                  ->where($db->quoteName('year').'='.$db->quote($year));
        $query                  ->setLimit('1');
        $db                     ->setQuery($query);
        $corr                   = $db->loadAssoc();     // the ayanamsha correction
        //print_r($corr);exit;
        $corr                   = explode(":",$corr['ayanamsha']);
        //print_r($corr);exit;
        foreach($data as $key=>$planets)
        {
            $planet         = explode(":", $planets);
            
             // below line gets the ayanamsha(Indian) value after 
            // subtracting ayanamsha correction from western value
            $ayan_val       = $this->subDegMinSec($planet[0], $planet[1], $planet[2], $corr[0], $corr[1],$corr[2]);
            $sign           = $this->calcDetails($ayan_val);
            $sign_det           = array($key."_sign"=>$sign);
            $dist           = $this->calcDistance($ayan_val);
            $dist_det           = array($key."_dist"=>$dist);
            
            //echo $key." ".$sign." ".$dist."<br/>";
            $details        = $this->getPlanetaryDetails($key, $sign, $dist);
            $graha[]          = array_merge($sign_det,$dist_det,$details);
        }
        
        return $graha;
    }
}