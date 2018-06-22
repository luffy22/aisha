<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');

class HoroscopeModelMoon extends HoroscopeModelLagna
{
    public function getData()
    {
        $jinput         = JFactory::getApplication()->input;
        $chart_id       = $jinput->get('chart', 'default_value', 'filter');
        $chart_id       = str_replace("chart","horo", $chart_id);
        
        $db         = JFactory::getDbo();
        $query      = $db->getQuery(true);
        

        $query      ->select($db->quoteName(array('fname','gender','dob','tob','pob','lon','lat','timezone','dst')));
        $query      ->from($db->quoteName('#__horo_query'));
        $query      ->where($db->quoteName('uniq_id') . ' = '. $db->quote($chart_id));
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
       $horo                = $this->getMoonData($data);
       //$ayanamsha           = $this->applyAyanamsha($dob, $horo); 
    }
      
    protected function getMoonData($data)
    {
        //print_r($data);exit;
        //$lagna          = $this->calculatelagna($data);
        $dob            = $data['gmt_date'];
        $tob            = explode(":",$data['gmt_time']);
        
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName('moon'));
        $query          ->from($db->quoteName('#__ephemeris'));
        $query          ->where($db->quoteName('full_year').'='.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result1        = $db->loadAssoc();
        $result1        = $this->convertPlanets($result1);
        //print_r($result1);exit;
        
        $query          ->clear();
        $query          ->select($db->quoteName('moon'));
        $query          ->from($db->quoteName('#__ephemeris'));
        $query          ->where($db->quoteName('full_year').'>'.$db->quote($dob));
        $query          ->order($db->quoteName('full_year').' asc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result2        = $db->loadAssoc();
        $result2        = $this->convertPlanets($result2);
        
        $down_deg       = explode(".",$result1['moon']);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
        $up_deg         = explode(".",$result2['moon']);

        (double)$down_deg       = ((double)$down_deg[0]*30+$down_deg[1]).".".$down_deg[2];
        (double)$up_deg         = ((double)$up_deg[0]*30+$up_deg[1]).".".$up_deg[2];
        $down_val               = explode(".",$down_deg);
        $up_val                 = explode(".", $up_deg);

        //echo $planet."  ".$up_deg." : ".$down_deg."<br/>";exit;
        if($up_deg < $down_deg)
        {
            $diff               = explode(":", $this->subDegMinSec($down_val[0], $down_val[1], 0, $up_val[0], $up_val[1], 0));
        }
        else
        {
            $diff               = explode(":", $this->subDegMinSec($up_val[0], $up_val[1], 0, $down_val[0], $down_val[1], 0));
        }
        $deg                = $diff[0];
        $min                = $diff[1];
        if($min < 10)
        {
            $min            = "0".$min;
        }

        $query          ->clear();
        $query          ->select($db->quoteName(array("value")));
        $query          ->from($db->quoteName('#__raman_log'));
        $query          ->where($db->quoteName('degree').'='.$db->quote($deg).'AND'.
                                $db->quoteName('min')."=".$db->quote($min));
        $db             ->setQuery($query);
        $result3         = $db->loadAssoc();

        $tob_deg        = $tob[0];
        $tob_min        = $tob[1];
        $query          ->clear();
        $query          ->select($db->quoteName(array("value")));
        $query          ->from($db->quoteName('#__raman_log'));
        $query          ->where($db->quoteName('degree').'='.$db->quote($tob_deg).'AND'.
                                $db->quoteName('min')."=".$db->quote($tob_min));
        $db             ->setQuery($query);
        $result4        = $db->loadAssoc();

        $value1         = $result3["value"];
        $value2         = $result4["value"];

        $result         = number_format(($value1 + $value2),4);

        $query          ->clear();
        $query          ->select($db->quoteName(array('degree','min')));
        $query          ->from($db->quoteName('#__raman_log'));
        $query          ->where($db->quoteName('value').'<='.$db->quote($result));
        $query          ->order($db->quoteName('value').' desc');
        $query          ->setLimit('1');
        $db             ->setQuery($query);
        $result5        = $db->loadAssoc();
        $diff           = $result5["degree"].".".$result5["min"];

        
        if($result5['min'] < 10)
        {
            $diff   = $result5['degree'].'.0'.$result5['min'];
        }
        $distance       = ($down_deg + $diff)-30.00;
        $dist           = explode(".",$distance);
        $distance       = $this->convertDegMinSec($dist[0], $dist[1], 0);
        $graha          = array('moon'=>$distance);
        $moon                = $this->getAyanamshaCorrection($dob, $graha);
        print_r($moon);exit;
       //$data                    = array_merge($data, $grahas);
       //return $data;
    }
    
}
?>
