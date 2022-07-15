<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelShodashvarga extends HoroscopeModelLagna
{
    public $data;
 
    public function addUser($details)
    {
        //print_r($details);exit;
        $result         = $this->addUserDetails($details, "shodasha");
        if(!empty($result))
        {
            //echo "query inserted";exit;
            $app        = JFactory::getApplication();
            $link       = JURI::base().'shodasha?chart='.str_replace("horo","chart",$result);
            $app        ->redirect($link);
        }
    }
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $chart_id       = $jinput->get('chart', 'default_value', 'filter');
        $chart_id       = str_replace("chart","horo", $chart_id);
        
        $result         = $this->getUserData($chart_id);
 
        $user           = JFactory::getUser();
        $user_id        = $user->id;
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

            //echo $utcTimestamp;exit;
            //echo date('Y-m-d H:i:s', $utcTimestamp); echo '<br>';

            $date = date('d.m.Y', $utcTimestamp);
            $time = date('H:i:s', $utcTimestamp);
            //echo $date." ".$time;exit;
            $h_sys = 'P';
            $output = "";

            exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m789 -g, -head", $output);
            //print_r($output);exit;
            
            $planets        = $this->getPlanets($output);
            $asc            = $this->getAscendant($result);
            $planets        = array_merge($asc, $planets);
            //print_r($planets);exit;
            $data           = array();
            foreach($planets as $planet=>$dist)
            {
                $dist2          = $this->convertDecimalToDegree($dist, "details");
                //$dist1          = $this->convertDecimalToDegree($dist, "");
                $sign           = $this->calcDetails($dist);
                $details        = array($planet=>$sign);
                //$dashamsha      = $this->getDashamsha($planet, $sign, $dist2);
                //$hora           = $this->getHora($planet,$sign, $dist2);
                //$drekana        = $this->getDrekana($planet, $sign, $dist2);
                //$chatur         = $this->getChatur($planet, $sign, $dist2);
                $sapt           = $this->getSapt($planet, $sign, $dist);
                $data           = array_merge($data,$sapt);

            }
            print_r($data);exit;
            $nav_data           = array("main"=>$result,"shodas"=>$data);
            //$nav_data               = array_merge($result, $nav_data);
            //print_r($nav_data);exit;
        }
        
    }
    protected function getDashamsha($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        $chart                  = 'dashamsha';
        $db                     = JFactory::getDbo();
        $query                  = $db->getQuery(true);
        $query                  ->select('shodas_sign');
        $query                  ->from($db->quoteName('#__shodasha'));
        $query                  ->where($db->quote($dist).' BETWEEN '.
                                        $db->quoteName('low_deg').' AND '.
                                        $db->quoteName('up_deg').' AND '.
                                        $db->quoteName('moon_sign').' = '.$db->quote($sign).' AND '.
                                        $db->quoteName('chart_type').' = '.$db->quote($chart)); 
        $db                     ->setQuery($query);
        $result                 = $db->loadAssoc();
        //print_r($result);exit;
        $array                  = array($planet."_dashamsha" => $result['shodas_sign']);
        return $array; 
    }
    protected function getHora($planet,$sign,$dist)
    {

        //echo $planet." ".$sign." ".$dist;exit;
        $even_signs	= array("Taurus","Cancer","Virgo",
                                "Scorpio","Capricorn","Pisces");
        if(in_array($sign, $even_signs))
        {
            if($dist >= 0 && $dist <=15)
            {
                $array      = array($planet."_hora"=>"Moon");
            }
            else
            {
                $array      = array($planet."_hora"=>"Sun");     
            }
        }
        else
        {
            if($dist >= 0 && $dist <=15)
            {
                $array      = array($planet."_hora"=>"Sun");
            }
            else
            {
                $array      = array($planet."_hora"=>"Moon");     
            }
        }
        
        return $array;
    }
    protected function getDrekana($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        $chart                  = 'drekana';
        $db                     = JFactory::getDbo();
        $query                  = $db->getQuery(true);
        $query                  ->select('shodas_sign');
        $query                  ->from($db->quoteName('#__shodasha'));
        $query                  ->where($db->quote($dist).' BETWEEN '.
                                        $db->quoteName('low_deg').' AND '.
                                        $db->quoteName('up_deg').' AND '.
                                        $db->quoteName('moon_sign').' = '.$db->quote($sign).' AND '.
                                        $db->quoteName('chart_type').' = '.$db->quote($chart)); 
        $db                     ->setQuery($query);
        $result                 = $db->loadAssoc();
        //print_r($result);exit;
        $array                  = array($planet."_drekan" => $result['shodas_sign']);
        return $array; 
    }
    protected function getChatur($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        $chart                  = 'chaturamsha';
        $db                     = JFactory::getDbo();
        $query                  = $db->getQuery(true);
        $query                  ->select('shodas_sign');
        $query                  ->from($db->quoteName('#__shodasha'));
        $query                  ->where($db->quote($dist).' BETWEEN '.
                                        $db->quoteName('low_deg').' AND '.
                                        $db->quoteName('up_deg').' AND '.
                                        $db->quoteName('moon_sign').' = '.$db->quote($sign).' AND '.
                                        $db->quoteName('chart_type').' = '.$db->quote($chart)); 
        $db                     ->setQuery($query);
        $result                 = $db->loadAssoc();
        //print_r($result);exit;
        $array                  = array($planet."_chaturamsha" => $result['shodas_sign']);
        return $array; 
    }
    protected function getSapt($planet,$sign,$dist)
    {
        $dist                   = explode(".",$dist);
        $dist1                  = $dist[0] % 30;  // remaining value when divided by 30 eg. 295%30 = 25
        $dist                   = number_format($dist1.".".$dist[1],4);
        echo $dist;exit;
        
    }
}
?>
