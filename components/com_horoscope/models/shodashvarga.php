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
            $data           = array();
            foreach($planets as $planet=>$dist)
            {
                $dist2          = $this->convertDecimalToDegree($dist, "details");
                //$dist1          = $this->convertDecimalToDegree($dist, "");
                $sign           = $this->calcDetails($dist);
                $lagna          = array($planet."_lagna"=>$sign);
                $nav            = $this->getNavamsha($planet,$sign,$dist2);
                $das            = $this->getDashamsha($planet, $sign, $dist2);
                $hora           = $this->getHora($planet,$sign, $dist2);
                $drekana        = $this->getDrekana($planet, $sign, $dist2);
                $chatur         = $this->getChatur($planet, $sign, $dist2);
                $sapt           = $this->getSapt($planet, $sign, $dist);
                $dwad           = $this->getDwadamsha($planet, $sign, $dist2);
                $shod           = $this->getShodamsha($planet, $sign, $dist);
                $vim            = $this->getVimsamsa($planet, $sign, $dist2);
                $chaturvim      = $this->getChaturvim($planet, $sign, $dist2);
                $saptvim        = $this->getSaptVim($planet,$sign,$dist);
                $trimsamsa      = $this->getTrimsamsa($planet,$sign,$dist2);
                $khed           = $this->getKhedamsa($planet,$sign,$dist2);
                $akshved        = $this->getAkshved($planet,$sign,$dist2);
                $shast          = $this->getShastiamsa($planet,$sign,$dist2);
                $data           = array_merge($data,$lagna,$nav,$das,
                                              $hora, $drekana,$chatur,$sapt,
                                               $dwad,$shod,$vim,$chaturvim,$saptvim,
                                             $trimsamsa,$khed,$akshved,$shast);

            }
            //print_r($data);exit;
            $nav_data           = array("main"=>$result, "shodas"=>$data);
            //$nav_data               = array_merge($result, $nav_data);
            return $nav_data;
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
        $array                  = array($planet."_dash" => $result['shodas_sign']);
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
                $array      = array($planet."_hora"=>"Cancer");
            }
            else
            {
                $array      = array($planet."_hora"=>"Leo");     
            }
        }
        else
        {
            if($dist >= 0 && $dist <=15)
            {
                $array      = array($planet."_hora"=>"Leo");
            }
            else
            {
                $array      = array($planet."_hora"=>"Cancer");     
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
        $array                  = array($planet."_chatur" => $result['shodas_sign']);
        return $array; 
    }
    protected function getSapt($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        $chart                  = 'saptamsha';
        $dist                   = explode(".",(float)$dist);
        $dist1                  = $dist[0] % 30;  // remaining value when divided by 30 eg. 295%30 = 25
        $dist                   = number_format($dist1.".".$dist[1],4);  // just add the value after decimal point on right side
        //echo $dist;exit;
        $db                     = JFactory::getDbo();
        $query                  = $db->getQuery(true);
        $query                  ->select('shodas_sign');
        $query                  ->from($db->quoteName('#__shodasha1'));
        $query                  ->where($db->quote($dist).' BETWEEN '.
                                        $db->quoteName('low_deg').' AND '.
                                        $db->quoteName('up_deg').' AND '.
                                        $db->quoteName('moon_sign').' = '.$db->quote($sign).' AND '.
                                        $db->quoteName('chart_type').' = '.$db->quote($chart)); 
        $db                     ->setQuery($query);
        $result                 = $db->loadAssoc();
        //print_r($result);exit;
        $array                  = array($planet."_sapt" => $result['shodas_sign']);
        return $array;
    }
    protected function getDwadamsha($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        $chart                  = 'dwadamsha';
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
        $array                  = array($planet."_dwad" => $result['shodas_sign']);
        return $array; 
    }
    protected function getShodamsha($planet,$sign,$dist)
    {
        $chart                  = 'shodamsha';
        $dist                   = explode(".",(float)$dist);
        $dist1                  = $dist[0] % 30;  // remaining value when divided by 30 eg. 295%30 = 25
        $dist                   = number_format($dist1.".".$dist[1],4);  // just add the value after decimal point on right side
        //echo $planet." ".$sign." ".$dist." ".$dist2."<br/>";
        $db                     = JFactory::getDbo();
        $query                  = $db->getQuery(true);
        $query                  ->select('shodas_sign');
        $query                  ->from($db->quoteName('#__shodasha1'));
        $query                  ->where($db->quote($dist).' BETWEEN '.
                                        $db->quoteName('low_deg').' AND '.
                                        $db->quoteName('up_deg').' AND '.
                                        $db->quoteName('moon_sign').' = '.$db->quote($sign).' AND '.
                                        $db->quoteName('chart_type').' = '.$db->quote($chart)); 
        $db                     ->setQuery($query);
        $result                 = $db->loadAssoc();
        //print_r($result);exit;
        $array                  = array($planet."_shod" => $result['shodas_sign']);
        return $array;
    }
    protected function getVimsamsa($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist."<br/>";
        $chart                  = 'vimsamsa';
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
        $array                  = array($planet."_vim" => $result['shodas_sign']);
        return $array; 
    }
    protected function getChaturVim($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        //echo $planet." ".$sign." ".$dist."<br/>";
        $chart                  = 'chaturvim';
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
        $array                  = array($planet."_cvim" => $result['shodas_sign']);
        return $array; 
    }
    protected function getSaptVim($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        $chart                  = 'saptvim';
        $dist                   = explode(".",(float)$dist);
        $dist1                  = $dist[0] % 30;  // remaining value when divided by 30 eg. 295%30 = 25
        $dist                   = number_format($dist1.".".$dist[1],4);  // just add the value after decimal point on right side
        //echo $planet." ".$sign." ".$dist." ".$dist2."<br/>";exit;
        $db                     = JFactory::getDbo();
        $query                  = $db->getQuery(true);
        $query                  ->select('shodas_sign');
        $query                  ->from($db->quoteName('#__shodasha1'));
        $query                  ->where($db->quote($dist).' BETWEEN '.
                                        $db->quoteName('low_deg').' AND '.
                                        $db->quoteName('up_deg').' AND '.
                                        $db->quoteName('moon_sign').' = '.$db->quote($sign).' AND '.
                                        $db->quoteName('chart_type').' = '.$db->quote($chart)); 
        $db                     ->setQuery($query);
        $result                 = $db->loadAssoc();
        //print_r($result);exit;
        $array                  = array($planet."_saptvim" => $result['shodas_sign']);
        return $array;
    }
    protected function getTrimsamsa($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        //echo $planet." ".$sign." ".$dist."<br/>";
        $chart                  = 'trimsamsa';
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
        $array                  = array($planet."_trim" => $result['shodas_sign']);
        return $array; 
    }
    protected function getKhedamsa($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        //echo $planet." ".$sign." ".$dist."<br/>";
        $chart                  = 'khedamsa';
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
        $array                  = array($planet."_khed" => $result['shodas_sign']);
        return $array; 
    }
    protected function getAkshved($planet,$sign,$dist)
    {
        //echo $planet." ".$sign." ".$dist;exit;
        //echo $planet." ".$sign." ".$dist."<br/>";
        $chart                  = 'akshaved';
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
        $array                  = array($planet."_aksh" => $result['shodas_sign']);
        return $array; 
    }
    protected function getShastiamsa($planet,$sign,$dist)
    {
        if($planet == "Sun")
        {
            //echo $planet." ".$sign." ".$dist;exit;
        }
        $signs              = array("Aries","Taurus","Gemini","Cancer","Leo","Virgo","Libra",
                                    "Scorpio","Sagittarius","Capricorn","Aquarius","Pisces");
        $find               = array_search($sign,$signs);
        //echo $find;exit;
        $dist               = explode(".",$dist);
        $add_dist           = $this->addDegMinSec($dist[0], $dist[1], 0, $dist[0], $dist[1], 0);
        $add_dist           = explode(":",$add_dist);
        $multiply_dist      = $add_dist[0]%12;
        if($planet == "Sun")
        {
            //echo $multiply_dist;exit;
        }
        if($multiply_dist == "0")
        {
            $sign           = $signs[$find];
        }
        else
    {
            $multiply_dist  = $multiply_dist+0;  // one needs to be added here in manual calculation. But since its array counting begins at zero
            //echo $multiply_dist;exit;
            $find           = $find + $multiply_dist;

            if($find > 11)
            {
                $find       = $find - 12;  // if value exceeds 11 than 12 is subtracted to start index at 0
            }
            $sign           = $signs[$find];
            
        }
     
        $array              = array($planet."_shasht"=>$sign);
        //print_r($array);exit;
       return $array;
    }
}
?>
