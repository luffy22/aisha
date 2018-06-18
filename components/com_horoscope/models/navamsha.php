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
       print_r($horo);exit;
    }
    
}