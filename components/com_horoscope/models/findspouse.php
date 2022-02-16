<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelFindSpouse extends HoroscopeModelLagna
{
    public $data;
 
    public function findspouse($details)
    {
        $result          = $this->addUserDetails($details, "fspouse");

        if(!empty($result))
        {
            //echo "query inserted";exit;
            $app        = JFactory::getApplication();
            $link       = JURI::base().'findspouse?chart='.str_replace("horo","chart",$result);
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
        if(empty($result))
        {
            return;
        }
        else
        {
            $fname          = $result['fname'];
            $gender         = $result['gender'];
            $chart          = $result['chart_type'];
            $dob_tob        = $result['dob_tob'];
            if(array_key_exists("timezone", $result))
            {      

                $pob            = $result['pob'];
                $lat            = $result['lat'];
                $lon            = $result['lon'];
                $timezone       = $result['timezone'];
            }
            else
            {
                $lat            = $result['latitude'];
                $lon            = $result['longitude'];
                if($result['state'] == "" && $result['country'] == "")
                {
                    $pob    = $result['city'];
                }
                else if($result['state'] == "" && $result['country'] != "")
                {
                    $pob    = $result['city'].", ".$result['country'];
                }
                else
                {
                    $pob    = $result['city'].", ".$result['state'].", ".$result['country'];
                }
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
            if($gender == "female")
            {
                // More about command line options: https://www.astro.com/cgi/swetest.cgi?arg=-h&p=0
                exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p15 -g, -head", $output);
            }
            else
            {
                exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p13 -g, -head", $output);
            }
            //print_r($output);exit;

            # OUTPUT ARRAY
            # Planet Name, Planet Degree, Planet Speed per day
            $asc            = $this->getAscendant($result);
            $planets        = $this->getPlanets($output);
            $data           = array_merge($asc,$planets);
            //print_r($data);exit;
            //$details        = $this->getDetails($data);
            $newdata        = array();
            foreach($data as $key=>$distance)
            {
                // this loop gets the horoscope sign of Ascendant, Moon & Jupiter or Venus
                $dist           = str_replace(":r","",$distance);
                $sign           = $this->calcDetails($dist);
                $sign_num       = array($key."_num"=>$this->getSignNum($sign));
                $getsign        = array($key."_sign"=>$sign);
                $newdata        = array_merge($newdata,$getsign,$sign_num);
            }
            $jup_ven_house      = $this->getHouse($gender, $newdata);
            $house              = array("house"=>$jup_ven_house);
            $details         = $this->getSpouseDetails($jup_ven_house);

            $array              = array();
            $array              = array_merge($array,$result,$house, $details);
            return $array;
        }
    }
    protected function getSignNum($sign)
    {
        switch($sign)
        {
            case "Aries":
            return "1";break;
            case "Taurus":
            return "2";break;
            case "Gemini":
            return "3";break;
            case "Cancer":
            return "4";break;
            case "Leo":
            return "5";break;
            case "Virgo":
            return "6";break;
            case "Libra":
            return "7";break;
            case "Scorpio":
            return "8";break;
            case "Sagittarius":
            return "9";break;
            case "Capricorn":
            return "10";break;
            case "Aquarius":
            return "11";break;
            case "Pisces":
            return "12";break;
            default:
            return "1";break;
        }
   
    }
    protected function getHouse($gender, $data)
    {
       $j = 1;
       if($gender == "female")
       {
           $asc_num     = $data['Ascendant_num'];
           $jup_num     = $data['Jupiter_num'];
           if($asc_num > $jup_num)
           {
               $jup_num     = $jup_num + 12;
           }
           for($i=$asc_num;$i <$jup_num;$i++)
           {
               $j++;       
           }
       }
       else
       {
           $asc_num     = $data['Ascendant_num'];
           $ven_num     = $data['Venus_num'];
           if($asc_num > $ven_num)
           {
               $ven_num     = $ven_num + 12;
           }
           for($i=$asc_num;$i <$ven_num;$i++)
           {
               $j++;       
           }
       }
       //echo $j;exit;
       return $j;
       
    }
    protected function getSpouseDetails($house)
    {
                
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName('spouse_text'));
        $query          ->from($db->quoteName('#__find_spouse'));
        $query          ->where($db->quoteName('spouse_id').' = '.$db->quote($house));
        $db             ->setQuery($query);
        $db->execute();
        $result         = $db->loadAssoc();
        return $result;
    }
}
?>
