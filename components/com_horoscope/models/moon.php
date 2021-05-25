<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelMoon extends HoroscopeModelLagna
{
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $chart_id       = $jinput->get('chart', 'default_value', 'filter');
        $chart_id       = str_replace("chart","horo", $chart_id);
        $result         = array();
        $userdata       = $this->getUserData($chart_id);
        
        if(empty($userdata))
        {
            return;
        }
        else
        {
            $user           = JFactory::getUser();
            $user_id        = $user->id;
            $fname          = $userdata['fname'];
            $gender         = $userdata['gender'];
            $chart          = $userdata['chart_type'];
            $dob_tob        = $userdata['dob_tob'];
            if(array_key_exists("timezone", $userdata))
            {  
                $pob            = $userdata['pob'];
                $lat            = $userdata['lat'];
                $lon            = $userdata['lon'];
                $timezone       = $userdata['timezone'];
            }
            else
            {
                $lat            = $userdata['latitude'];
                $lon            = $userdata['longitude'];
                if($userdata['state'] == "" && $userdata['country'] == "")
                {
                    $pob    = $userdata['city'];
                }
                else if($userdata['state'] == "" && $userdata['country'] != "")
                {
                    $pob    = $userdata['city'].", ".$userdata['country'];
                }
                else
                {
                    $pob    = $userdata['city'].", ".$userdata['state'].", ".$userdata['country'];
                }
                $timezone   = $userdata['tmz_words'];
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

            $output = "";
            // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
            exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p1042536789m -g, -head", $output);
            //print_r($output);exit;
            $data         = array();
            $planets        = $this->getPlanets($output);
            //print_r($planets);exit;
            foreach($planets as $planet=>$dist)
            {
                //echo $planet;exit;
                $sign           = $this->calcDetails($dist);
                $details        = array($planet=>$sign);
                $result         = array_merge($result, $details);
            }
            //print_r($result);exit;
            $planet             = key($result);
            $moon_sign          = $result[$planet];
            $moon_details       = $this->getArticle($moon_sign, $planet);
            $result             = array_merge($userdata,$result, $moon_details);
            //print_r($result);exit;
            return $result;
        }
       //$ayanamsha           = $this->applyAyanamsha($dob, $horo); 
       //return $horo;
    }
      
  
    
}
?>
