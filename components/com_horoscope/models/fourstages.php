<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('mangaldosha', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelFourStages extends HoroscopeModelLagna
{
    public $data;
 
    public function addUser($details)
    {
        $result         = $this->addUserDetails($details, "stages");
        //echo "calls";exit;
        if(!empty($result))
        {
            //echo "query inserted";exit;
            $app        = JFactory::getApplication();
            $link       = JURI::base().'fourstage?chart='.str_replace("horo","chart",$result);
            $app        ->redirect($link);
        }
    }
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $chart_id       = $jinput->get('chart', 'default_value', 'filter');
        $chart_id       = str_replace("chart","horo", $chart_id);
        $array          = array();
        $user_data      = $this->getUserData($chart_id);
        
        $user           = JFactory::getUser();
        $user_id        = $user->id;
        if(empty($user_data))
        {
            return;
        }
        else 
        {
            $fname          = $user_data['fname'];
            $gender         = $user_data['gender'];
            $chart          = $user_data['chart_type'];
            $dob_tob        = $user_data['dob_tob'];
            if(array_key_exists("timezone", $user_data))
            {    
                $pob            = $user_data['pob'];
                $lat            = $user_data['lat'];
                $lon            = $user_data['lon'];
                $timezone       = $user_data['timezone'];
            }
            else
            {
                $lat            = $user_data['latitude'];
                $lon            = $user_data['longitude'];
                if($user_data['state'] == "" && $user_data['country'] == "")
                {
                    $pob    = $user_data['city'];
                }
                else if($user_data['state'] == "" && $user_data['country'] != "")
                {
                    $pob    = $user_data['city'].", ".$user_data['country'];
                }
                else
                {
                    $pob    = $user_data['city'].", ".$user_data['state'].", ".$user_data['country'];
                }
                $timezone   = $user_data['tmz_words'];
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

            # OUTPUT ARRAY
            # Planet Name, Planet Degree, Planet Speed per day
            $asc                        = $this->getAscendant($user_data);
            $planets                    = $this->getPlanets($output);
            $planets                    = array_merge($asc,$planets);
            $data                       = array();
            foreach($planets as $key=>$planet)
            {
                $details                = $this->calcDetails($planet);
                $pl_details             = array($key => $details);
                $data                   = array_merge($data, $pl_details);
            }
            $asc                        = $planets['Ascendant'];
            $asc_sign                   = $this->calcDetails($asc);
            $stage1                     = $this->checkStage1($planets, $asc_sign);
            $stage2                     = $this->checkStage2($planets, $asc_sign);
            $stage3                     = $this->checkStage3($planets, $asc_sign);
            $stage4                     = $this->checkStage4($planets, $asc_sign);

            $array                      = array();
            $array                      = array_merge($array,$user_data, $data, $stage1, $stage2, $stage3, $stage4);
            return $array;
        }
    }
    // this function will check planets, aspects and strength on 1st house(childhood)
    protected function checkStage1($data, $sign)
    {
        $house                      = $this->checkPlanetsInHouse($data, 1);
        $asp                        = $this->checkAspectsOnHouse($data, 1);
       
        $house_strength             = $this->checkStrength($house,"house",$sign,"1");
        $asp_strength               = $this->checkStrength($asp,"aspect",$sign, "1");
        $array                      = array();
        $array                      = array_merge($array, $house_strength, $asp_strength);
        $strength                   = $this->getStrength($array,"1");
        return $strength;
    }
    // this function will check planets, aspects and strength on 1st house(childhood)
    protected function checkStage2($data, $sign)
    {
        $tenth_sign                 = $this->getHouseSign($sign, 10);

        $house                      = $this->checkPlanetsInHouse($data, 10);
        $asp                        = $this->checkAspectsOnHouse($data, 10);
        
        $house_strength             = $this->checkStrength($house,"house",$tenth_sign,"10");
        $asp_strength               = $this->checkStrength($asp,"aspect",$tenth_sign, "10");
        $array                      = array();
        $array                      = array_merge($array, $house_strength, $asp_strength);
        $strength                   = $this->getStrength($array,"10");
        return $strength;
    }
    // this function will check planets, aspects and strength on 7th house(middle age)
    protected function checkStage3($data, $asc_sign)
    {
        $seventh_sign               = $this->getHouseSign($asc_sign, 7);
        $house                      = $this->checkPlanetsInHouse($data, 7);
        $asp                        = $this->checkAspectsOnHouse($data, 7);
        
        $house_strength             = $this->checkStrength($house,"house",$seventh_sign,"7");
        $asp_strength               = $this->checkStrength($asp,"aspect",$seventh_sign, "7");
        $array                      = array();
        $array                      = array_merge($array, $house_strength, $asp_strength);
        $strength                   = $this->getStrength($array,"7");
        return $strength;
    }
    // this function will check planets, aspects and strength on 4th house(old age)
    protected function checkStage4($data, $asc_sign)
    {
        $fourth_sign                = $this->getHouseSign($asc_sign, 4);
        $house                      = $this->checkPlanetsInHouse($data, 4);
        $asp                        = $this->checkAspectsOnHouse($data, 4);
        
        $house_strength             = $this->checkStrength($house,"house",$fourth_sign,"4");
        $asp_strength               = $this->checkStrength($asp,"aspect",$fourth_sign, "4");
        $array                      = array();
        $array                      = array_merge($array, $house_strength, $asp_strength);
        $strength                   = $this->getStrength($array,"4");
        return $strength;
    }
    protected function checkStrength($data, $condition, $sign, $num)
    {
        //echo $condition." ".$sign." ".$num;exit;
        $count                      = count($data[$condition."_".$num]);
        $exal                       = array("Sun"=>"Aries", "Moon"=>"Taurus","Mars"=>"Capricorn",
                                            "Mercury"=>"Virgo","Jupiter"=>"Cancer","Venus"=>"Pisces",
                                            "Saturn"=>"Libra","Rahu"=>"Aquarius");
        $deb                        = array("Sun"=>"Libra","Moon"=>"Scorpio","Mars"=>"Cancer",
                                            "Mercury"=>"Pisces","Jupiter"=>"Capricorn","Venus"=>"Pisces",
                                            "Saturn"=>"Aries");
        $own                        = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $planet_array               = array();
        $good_pl        = array("Jupiter","Venus","Moon","Mercury");
        $bad_pl         = array("Sun", "Mars","Saturn","Rahu","Ketu","Pluto");
        $asp_pl                     = array($condition."_".$num => $count);
        $planet_array               = array_merge($planet_array, $asp_pl);
        if($condition == "house")
        {
            $planets                    = $data["house_".$num];
        }
        else if($condition == "aspect")
        {
            $planets                    = $data["aspect_".$num];
        }
        else
        {
            $planets                    = $data["house_".$num];
        }
        $i          = 1;
        foreach($planets as $planet)
        {
            if($sign == $exal[$planet] && in_array($planet, $good_pl))
            {
                $array              = array($condition."_".$num."_".$i => $planet,$condition."_condition_".$num."_".$i => "exalted", $condition."_status_".$num."_".$i => "very good");$i++;
                $planet_array       = array_merge($planet_array, $array);
            }
            else if($sign == $exal[$planet] && in_array($planet, $bad_pl))
            {
                $array              = array($condition."_".$num."_".$i => $planet,$condition."_condition_".$num."_".$i => "exalted", $condition."_status_".$num."_".$i => "bad");$i++;
                $planet_array       = array_merge($planet_array, $array);
            }
            else if($sign == $deb[$planet] && in_array($planet, $good_pl))
            {
                $array              = array($condition."_".$num."_".$i => $planet,$condition."_condition_".$num."_".$i => "debilitated",$condition."_status_".$num."_".$i => "good");$i++;
                $planet_array       = array_merge($planet_array, $array);
            }
            else if($sign == $deb[$planet] && in_array($planet, $bad_pl))
            {
                $array              = array($condition."_".$num."_".$i => $planet,$condition."_condition_".$num."_".$i => "debilitated",$condition."_status_".$num."_".$i => "very bad");$i++;
                $planet_array       = array_merge($planet_array, $array);
              }
            else if($own[$sign] == $planet && in_array($planet, $good_pl))
            {
                $array              = array($condition."_".$num."_".$i => $planet,$condition."_condition_".$num."_".$i => "own sign",$condition."_status_".$num."_".$i => "very good");$i++;
                $planet_array       = array_merge($planet_array, $array);
            }
            else if($own[$sign] == $planet && in_array($planet, $bad_pl))
            {
                $array              = array($condition."_".$num."_".$i => $planet,$condition."_condition_".$num."_".$i => "own sign",$condition."_status_".$num."_".$i => "neutral");$i++;
                $planet_array       = array_merge($planet_array, $array);
            }
            else 
            {
                if(in_array($planet, $good_pl))
                {
                    $array              = array($condition."_".$num."_".$i => $planet,$condition."_condition_".$num."_".$i => "none",$condition."_status_".$num."_".$i => "good");$i++;
                    $planet_array       = array_merge($planet_array, $array);
                }
                else if(in_array($planet, $bad_pl))
                {
                    $array              = array($condition."_".$num."_".$i => $planet,$condition."_condition_".$num."_".$i => "none",$condition."_status_".$num."_".$i => "bad");$i++;
                    $planet_array       = array_merge($planet_array, $array);
                }
                else
                {
                    $array              = array($condition."_".$num."_".$i => $planet,$condition."_condition_".$num."_".$i => "none",$condition."_status_".$num."_".$i => "neutral");$i++;
                    $planet_array       = array_merge($planet_array, $array);
                }
            }
        }
        return $planet_array;
        
    }
    protected function getStrength($data,$num)
    {
        //print_r($data);exit;
        $pl             = $data['house_'.$num];
        $asp            = $data['aspect_'.$num];
        $pl_status      = 0;
        $asp_status     = 0;
        $condition  = array();
        for($i=0;$i<$pl;$i++)
        {
            $j              = $i + 1;
            $status         = $data['house_status_'.$num."_".$j];
            if($status == "very good")
            {
                $pl_status  = $pl_status + 4;
            }
            else if($status == "good")
            {
                $pl_status  = $pl_status + 2;
            }
            else if($status == "bad")
            {
                $pl_status  = $pl_status - 2;
            }
             else if($status == "very bad")
            {
                $pl_status  = $pl_status - 4;
            }
            else if($status  == "neutral")
            {
                $pl_status  = $pl_status + 0;
            }
            unset($data['house_status_'.$num."_".$j]);
        }
         for($i=0;$i<$asp;$i++)
        {
            $j              = $i + 1;
            $status         = $data['aspect_status_'.$num."_".$j];
            if($status == "very good")
            {
                $asp_status  = $asp_status + 2;
            }
            else if($status == "good")
            {
                $asp_status  = $asp_status + 1;
            }
            else if($status == "bad")
            {
                $asp_status  = $asp_status - 1;
            }
             else if($status == "very bad")
            {
                $asp_status  = $asp_status - 2;
            }
            else if($status == "neutral")
            {
                $asp_status  = $asp_status + 0;
            }
            unset($data['aspect_status_'.$num."_".$j]);
        }
        $status     = $pl_status+$asp_status;
        if($status  <= -4)
        {
            $status     = "Very Bad Phase";
        }
        else if($status < 0 && $status > -4)
        {
            $status     = "Bad Phase";
        }
        else if($status >= 0 && $status < 4)
        {
            $status     = "Good Phase";
        }
        else if($status >= 4)
        {
            $status     = "Very Good Phase";
        }
        //print_r($status);exit;
        $status     = array("status_".$num => $status);
        $data           = array_merge($data, $status);
        return $data;
    }
}