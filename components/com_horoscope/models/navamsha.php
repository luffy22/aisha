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
       $navamsha           = $this->getNavamsha($data, $horo); 
    }
    public function calcDistance($planet)
    {
        
        $details        = explode(":", $planet);
        $sign_num       = intval($details[0]%30);
        return $sign_num.".".$details[1];
    }
    
    public function getNavamsha($data, $horo)
    {
        $dob        = $data['dob'];
        $ayanamsha          = $this->getAyanamshaCorrection($dob, $horo);
        //print_r($ayanamsha);exit;
        /*for($i=0;$i<count($alldata);$i++)
        {
            $values      = array_values($alldata[$i]);
            $array       = array_merge($array, $key=>$values);
        }
        print_r($array);exit;*/
        
        $planet         = array("sun","moon","mercury","venus","mars","jupiter",
                                "saturn","rahu","ketu","uranus","neptune","pluto");
        $array          = array();
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        for($i=0;$i<count($horo);$i++)
        {
            $query      ->clear();
            $key        = array_keys($ayanamsha[$i]);
            $val        = array_values($ayanamsha[$i]);
            $sign       = $val[0];$dist     = $val[1];
            
            $query          ->select($db->quoteName('navamsha_sign'));
            $query          ->from($db->quoteName('#__navamsha'));
            $query          ->where($db->quoteName('sign').'='.$db->quote($sign).' AND '.
                                $db->quote($dist).' BETWEEN '.
                                $db->quoteName('low_deg').' AND '.
                                $db->quoteName('up_deg')); 
            $db             ->setQuery($query);
            $result         = $db->loadAssoc();
            $planet         = array(str_replace("_sign","",$key[0])."_nav_sign"=>$result['navamsha_sign']);
            $array          = array_merge($array,$planet);
            //print_r($array);exit;
        }
       print_r($array);exit;
    }
}