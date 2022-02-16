<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('mangaldosha', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelAstroYogas extends HoroscopeModelLagna
{
    public $data;
 
    public function addYogaDetails($details)
    {
        
        $result          = $this->addUserDetails($details, "astroyogas");
        if(!empty($result))
        {
            //echo "query inserted";exit;
            $app        = JFactory::getApplication();
            $link       = JURI::base().'astroyogas?chart='.str_replace("horo","chart",$result);
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
        //print_r($user_data);exit;
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
            //print_r($planets);exit;
            $data                       = array();
            foreach($planets as $key => $planet)
            {
                $planet_sign            = $this->calcDetails($planet);
                $array                  = array($key => $planet_sign);
                $data                   = array_merge($data, $array);
            }
            //print_r($data);exit;
            $checkVish                  = $this->checkVishYoga($planets['Moon'],$planets['Saturn']);
            $checkBudhAditya            = $this->checkBudhAditya($planets['Sun'],$planets['Mercury']);
            $checkVipraChandal          = $this->checkVipraChandal($data['Jupiter'],$data['Rahu']);
            $checkShrapit               = $this->checkShrapit($data['Saturn'],$data['Rahu'],$data['Ketu']);
            $checkGrahan                = $this->checkGrahan($data['Sun'],$data['Moon'],$data['Rahu'],$data['Ketu']);
            $checkPitru                 = $this->checkPitru($planets['Sun'],$planets['Saturn']);
            $checkKaalSarpa             = $this->checkKaalSarpa($data);
            $checkNBRY                  = $this->checkNBRY($data);
            $checkVRY                   = $this->checkVRY($data);
            $checkAngaraka              = $this->checkAngaraka($data['Mars'],$data['Rahu']);
            $checkParivartana           = $this->checkParivartana($data);
            $checkChandraMangal         = $this->checkChandraMangal($planets['Moon'],$planets['Mars']);
            $checkGajaKesari            = $this->checkGajaKesari($planets['Moon'], $planets['Jupiter']);
            $checkSasha                 = $this->checkSashaYoga($data['Ascendant'],$data['Moon'],$data['Saturn']);
            $checkHansa                 = $this->checkHansaYoga($data['Ascendant'],$data['Moon'],$data['Jupiter']);
            $checkRuchaka               = $this->checkRuchakaYoga($data['Ascendant'], $data['Moon'], $data['Mars']);
            $checkMalavya               = $this->checkMalavyaYoga($data['Ascendant'], $data['Moon'], $data['Venus']);
            $checkBhadra                = $this->checkBhadraYoga($data['Ascendant'], $data['Moon'], $data['Mercury']);
            $checkSunapha               = $this->checkSunapha($data);
            $checkAnapha                = $this->checkAnapha($data);
            $checkDhurdura              = $this->checkDhurdura($data);
            $checkKemdruma              = $this->checkKemdruma($data);
            $checkAdhiYoga              = $this->checkAdhiYoga($data['Moon'],$data['Mercury'],$data['Jupiter'],$data['Venus']);
            $checkChatusagara           = $this->checkChatusagara($data);
            $checkVasumati              = $this->checkVasumati($data);
            $checkRajlakshana           = $this->checkRajlakshana($data['Ascendant'],$data["Moon"],$data['Mercury'],$data['Jupiter'],$data['Venus']);
            $checkSakata                = $this->checkSakata($data['Moon'],$data['Jupiter']);
            $checkAmala                 = $this->checkAmala($data['Ascendant'],$data['Moon'],$data['Mercury'],$data['Jupiter'],$data['Venus']);
            $checkParvata               = $this->checkParvata($data);
            $checkKahala                = $this->checkKahala($data);
            $checkVesi                  = $this->checkVesi($data);
            $checkObyachari             = $this->checkObyachari($data);
            $checkMahabhagya            = $this->checkMahabhagyaYoga($user_data, $data);
            $checkLaxmi                 = $this->checkLaxmi($data);
            $checkGauri                 = $this->checkGauri($planets);
            $checkChapa                 = $this->checkChapa($data);
            $checkSreenatha             = $this->checkSreenatha($data['Ascendant'], $data['Mercury']);
            $checkMallika               = $this->checkMallika($data);
            $checkSankha                = $this->checkSankha($data);

            $checkDaridra               = $this->checkDaridra($data);
            $checkBheri                 = $this->checkBheri($data);
            $checkMridanga              = $this->checkMridanga($planets);
            $checkGaja                  = $this->checkGaja($planets);
            $checkKalnidhi              = $this->checkKalnidhi($data['Ascendant'],$data['Mercury'],$data['Jupiter'],$data['Venus']);
            $checkAmsavatara            = $this->checkAmsavatara($data);
            $checkKusuma                = $this->checkKusuma($data);
            $checkKurma                 = $this->checkKurma($planets);
            $checkDevendra              = $this->checkDevendra($data);

            $array                      = array_merge($array, $user_data, $checkVish, $checkBudhAditya,
                                            $checkVipraChandal, $checkShrapit, $checkGrahan, $checkPitru,
                                            $checkKaalSarpa,$checkNBRY, $checkAngaraka,$checkVRY, $checkParivartana, 
                                            $checkChandraMangal,$checkGajaKesari,$checkSasha,$checkHansa,
                                            $checkRuchaka,$checkMalavya,$checkBhadra,$checkSunapha,$checkAnapha,
                                            $checkDhurdura,$checkKemdruma,$checkAdhiYoga, $checkChatusagara,$checkVasumati,
                                            $checkRajlakshana,$checkSakata,$checkAmala,$checkParvata,$checkKahala,
                                            $checkVesi,$checkObyachari, $checkMahabhagya,$checkLaxmi, $checkGauri,
                                            $checkChapa,$checkSreenatha,$checkMallika,$checkSankha,$checkDaridra,
                                            $checkBheri,$checkMridanga,$checkGaja,$checkKalnidhi,
                                            $checkAmsavatara,$checkKusuma,$checkKurma,$checkDevendra);
            //print_r($array);exit;
            return $array;
        }
    }
    protected function removeRetro($planet)
    {
        // This functions removes :r at end of planet for example 29.17:r which suggests
        // planet is retrograde.
        $planet         = str_replace(":r","",$planet);
        return $planet;
    }
    protected function checkVishYoga($moon, $sat)
    {
        $moon_sign                  = $this->calcDetails($moon);
        $sat_sign                   = $this->calcDetails($sat);
        $diff                       = $sat - $moon;
        if($moon_sign == $sat_sign)
        {
            if((int)$diff <= 12)
            {
                $array              = array("vish_yoga" => "There is a strong <a href='https://www.astroisha.com/yogas/74-visha-yoga' title='vish yoga' >Vish Yoga</a> formed in your horoscope.");
            }
            else
            {
                $array              = array("vish_yoga" => "There is <a href='https://www.astroisha.com/yogas/74-visha-yoga' title='vish yoga' >Vish Yoga</a> formed in your horoscope.");
            }
        }
        else
        {
            $array                  = array("vish_yoga" => "No");
        }
        return $array;
    }
    protected function checkBudhAditya($sun, $mercury)
    {
        $sun_sign                   = $this->calcDetails($sun);
        $merc_sign                  = $this->calcDetails($mercury);
        $diff                       = $sun - $mercury;
        
        if($sun_sign == $merc_sign)
        {
            if(($sun_sign == "Leo" || $sun_sign == "Gemini" || $sun_sign == "Virgo")&&((int)$diff <= 12))
            {
                $array              = array("budh_aditya" => "There is a very strong <a href='https://www.astroisha.com/yogas/162-budh-aditya'  title='budh-aditya yoga'>Budh-Aditya Yoga</a> in a favorable sign formed in your horoscope.");
            }
            else 
            {
                $array              = array("budh_aditya" => "There is <a href='https://www.astroisha.com/yogas/162-budh-aditya'  title='budh-aditya yoga'>Budh-Aditya Yoga</a> formed in your horoscope.");
            }   
            
        }
        else
        {
            $array                  = array("budh_aditya" => "No");
        }
        return $array;
    }
    protected function checkVipraChandal($jup, $rahu)
    {       
        if($jup == $rahu)
        {
            if($jup_sign == "Sagittarius" || $jup_sign == "Pisces")
            {
                $array                  = array("vipra_chandal" => "There is <a href='https://www.astroisha.com/yogas/77-vcy'  title='vipra-chandal yoga'>Vipra-Chandal Yoga</a> in Jupiter's sign formed in your horoscope.");
            }
            else 
            {
                $array                  = array("vipra_chandal" => "There is <a href='https://www.astroisha.com/yogas/77-vcy'  title='vipra-chandal yoga'>Vipra-Chandal Yoga</a> formed in your horoscope.");
            }
        }
        else
        {
            $array                      = array("vipra_chandal" => "No");
        }
        return $array;
    }
    protected function checkShrapit($sat, $rahu, $ketu)
    {  
        if($sat == $rahu)
        {
            $array                  = array("shrapit_yoga" => "There is <a href='https://www.astroisha.com/yogas/391-shrapit-association' title='shrapit yoga' >Shrapit Yoga</a> formed in your horoscope due to Saturn and Rahu joining together in the same sign.");
        }
        else if($sat == $ketu)
        {
            $array                  = array("shrapit_yoga" => "There is <a href='https://www.astroisha.com/yogas/391-shrapit-association' title='shrapit yoga' >Shrapit Yoga</a> formed in your horoscope due to Saturn and Ketu joining together in the same sign.");
        }
        else
        {
            $array                  = array("shrapit_yoga" => "No");
        }
        return $array;
    }
    protected function checkGrahan($sun, $moon, $rahu, $ketu)
    { 
        if($sun == $rahu)
        {
            $array                  = array("grahan_yoga" => "There is <a href='https://www.astroisha.com/yogas/447-grahan-yoga' title='grahan yoga' >grahan yoga</a> formed in your horoscope due to Sun and Rahu joining in same sign.");
        }
        else if($sun == $ketu)
        {
            $array                  = array("grahan_yoga" => "There is <a href='https://www.astroisha.com/yogas/447-grahan-yoga' title='grahan yoga' >Grahan Yoga</a> formed in your horoscope due to Sun and Ketu joining in same sign.");
        }
        else if($moon == $rahu)
        {
            $array                  = array("grahan_yoga" => "There is <a href='https://www.astroisha.com/yogas/447-grahan-yoga' title='grahan yoga' >Grahan Yoga</a> formed in your horoscope due to Moon and Rahu joining in same sign.");
        }
        else if($moon == $ketu)
        {
            $array                  = array("grahan_yoga" => "There is <a href='https://www.astroisha.com/yogas/447-grahan-yoga' title='grahan yoga' >Grahan Yoga</a> formed in your horoscope due to Moon and Ketu joining in same sign.");
        }
        else
        {
            $array                  = array("grahan_yoga" => "No");
        }
        return $array;
    }
    protected function checkPitru($sun, $sat)
    {
        $sun_sign                   = $this->calcDetails($sun);
        $sat_sign                   = $this->calcDetails($sat);
        $diff                       = $sun - $sat;
        if($sun_sign == $sat_sign)
        {
            if((int)$diff <= 12)
            {
                $array              = array("pitru_dosha" => "There is a strong <a href='https://www.astroisha.com/yogas/97-pitru-dosha-2' title='pitru dosha' >Pitru Dosha</a> formed in your horoscope due to Sun and Saturn joining together in same sign.");
            }
            else
            {
                $array              = array("pitru_dosha" => "There is <a href='https://www.astroisha.com/yogas/97-pitru-dosha-2' title='pitru dosha' >Pitru Dosha</a> formed in your horoscope due to Sun and Saturn joining together in same sign.");
            }
        }
        else
        {
            $array                  = array("pitru_dosha" => "No");
        }
        return $array;
    }
    protected function checkKaalSarpa($data)
    {
        $asc                        = $data['Ascendant'];
        $rahu_dist                  = $this->getHouseDistance($asc, $data['Rahu']);
        $ketu_dist                  = $this->getHouseDistance($asc, $data['Ketu']);
        $planets                    = array("Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn");
        $array                      = array();$upper = array();$lower = array();
        $j                          = 0;
        $k                          = 0;$i = 0;
        foreach($planets as $planet)
        {
            $planet_sign            = $data[$planet];
            $planet_dist            = $this->getHouseDistance($asc,$planet_sign);
            
            if($rahu_dist      < $ketu_dist)
            {
                if($planet_dist > $rahu_dist && $planet_dist < $ketu_dist)
                {
                     $j         = $j+1;
                }
                else if($planet_dist == $rahu_dist || $planet_dist == $ketu_dist)
                {
                    $i          = $i+1;
                }
                else
                {
                    $k          = $k+1;
                }
            }
            else
            {
                //$k                  = $k+1;
                if($planet_dist < $rahu_dist && $planet_dist > $ketu_dist)
                {
                    $j          = $j+1;
                }
                else if($planet_dist == $rahu_dist || $planet_dist == $ketu_dist)
                {
                    $i          = $i+1;
                }
                else
                {
                    $k          = $k+1;
                }
            }
        }
        if($j+$i == "7" || $k+$i == "7")
        {
            $array              = array("kaal_sarpa"=> "There is <a href='https://www.astroisha.com/yogas/91-kaal-sarp' title='kaal sarpa yoga'>Kaal Sarpa Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array              = array("kaal_sarpa"=>"No");
        }
        return $array;
    }
    protected function checkNBRY($data)
    {
        $asc_sign                   = $data['Ascendant'];
        $moon_sign                  = $data['Moon'];
        $planets                    = array("Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn");
        $deb                        = array("Sun"=>"Libra","Moon"=>"Scorpio","Mars"=>"Cancer",
                                            "Mercury"=>"Pisces","Jupiter"=>"Capricorn",
                                            "Venus"=>"Virgo","Saturn"=>"Aries");
        $exal_sign                  = array("Libra"=>"Saturn","Scorpio"=>"","Cancer"=>"Jupiter","Taurus"=>"Moon",
                                            "Pisces"=>"Venus","Capricorn"=>"Mars","Virgo"=>"Mecury","Aries"=>"Sun");
        $own_sign                   = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $array                      = array();   // empty array for checks
        $j                          = 1;
        for($i=0;$i< count($planets);$i++)
        {
           $sign                    = $data[$planets[$i]];
           $deb_sign                = $deb[$planets[$i]];

           if($sign == $deb_sign)
           {
               $deb_planets         = array("deb_planet_".$j => $planets[$i]);
               $array               = array_merge($array,$deb_planets);
               $j                   = $j+1;
           }
        }
        $nbry_planets               = array();
        foreach($array as $planet)
        {
            $planet_sign            = $data[$planet];
            $planet_from_asc        = $this->getHouseDistance($asc_sign, $planet_sign);
            $planet_from_moon       = $this->getHouseDistance($moon_sign, $planet_sign);
            $deb_sign               = $deb[$planet];
            $exal_planet            = $exal_sign[$deb_sign]; //echo $exal_planet;exit;
            $own_planet             = $own_sign[$deb_sign]; //echo $own_planet;exit;
            $ex_pl_sign             = $data[$exal_planet];  // horoscope placement sign of planet which gets exalted in debilitated sign
            $own_pl_sign            = $data[$own_planet];   // horoscope placement sign of planet which owns the debilitated sign  
            //echo $ex_pl_sign." ".$own_pl_sign;exit;
            if($planet_sign == $deb_sign)
            {
                 // check1 sees if planet is in a quadrant or Not
                if($planet_from_asc == "1" || $planet_from_asc == "4"||
                   $planet_from_asc == "7" || $planet_from_asc == "10")
                {
                    $check1         = "pass";
                }
                else
                {
                    $check1         = "fail";
                }
                if($planet_from_moon == "1" || $planet_from_moon == "4"||
                   $planet_from_moon == "7" || $planet_from_moon == "10")
                {
                    $check5         = "pass";
                }
                else
                {
                    $check5         = "fail";
                }
                // check2 sees if there is exalted or own-sign planet as co-tenant
                if($deb_sign == $ex_pl_sign || $deb_sign == $own_pl_sign)
                {
                    $check2         = "pass";
                }
                else
                {
                    $check2         = "fail";
                }
                 // check3 sees if signs ruled by debilitated planet have an exalted planet in them
                $pair              = array_keys($own_sign, $planet);
                for($i=0; $i < count($pair);$i++)
                {
                    $ex_pl          = $exal_sign[$pair[$i]];  // checks to see which planet is exalted in the sign
                    $ex_pl_loc      = $data[$ex_pl]; // checks the horoscope sign of exalted planet
                    if($ex_pl_loc == $pair[$i])
                    {
                        $check3     = "pass";break; // will break the loop if one of the signs has an exalted planet
                    }
                    else
                    {
                        $check3     = "fail";
                    }
                }
                // check4 checks if planetary lord is exalted in one of the quadrants from ascendant
                //print_r($array);exit;
                $ex_sign            = array_search($own_planet, $exal_sign);        // checks the exalted sign of planetary lord
                $pl_from_asc        = $this->getHouseDistance($asc_sign, $own_pl_sign);     // gets distance from ascendant
                
                if(($pl_from_asc == "1" || $pl_from_asc == "4" || 
                    $pl_from_asc == "7" || $pl_from_asc == "10")&&($own_pl_sign == $ex_sign))
                {
                    $check4         = "pass";
                }
                else
                {
                    $check4         = "fail";
                }
                //echo $check4;exit;
                 // check5 checks if planet is retrograde in a quadrant from ascendant
                
                if($check1 == "pass" && $check2 == "pass")
                {
                    $nbry_planets[]         = $planet." does <a href='https://www.astroisha.com/yogas/75-nbry' title='NBRY'>NBRY</a> in Main Chart in your horoscope.";
                }
                else  if($check5 == "pass" && $check2 == "pass")
                {
                    $nbry_planets[]         = $planet." does <a href='https://www.astroisha.com/yogas/75-nbry' title='NBRY'>NBRY</a> in Moon Chart in your horoscope.";
                }
                else if($check1 == "pass" && $check3 == "pass")
                {
                    $nbry_planets[]         = $planet." does <a href='https://www.astroisha.com/yogas/75-nbry' title='NBRY'>NBRY</a> in Main Chart in your horoscope.";
                }
                else  if($check5 == "pass" && $check2 == "pass")
                {
                    $nbry_planets[]         = $planet." does <a href='https://www.astroisha.com/yogas/75-nbry' title='NBRY'>NBRY</a> in Moon Chart in your horoscope.";
                }
                else if($check1 == "pass" && $check4 == "pass")
                {
                    $nbry_planets[]         = $planet." does <a href='https://www.astroisha.com/yogas/75-nbry' title='NBRY'>NBRY</a> in Main Chart in your horoscope.";
                }
                else  if($check5 == "pass" && $check2 == "pass")
                {
                    $nbry_planets[]         = $planet." does <a href='https://www.astroisha.com/yogas/75-nbry' title='NBRY'>NBRY</a> in Moon Chart in your horoscope.";
                }
                else
                {
                    $nbry_planets[]         = $planet.": No";
                }
            }
        }
        
        //print_r($nbry_planets);exit;
        return array("nbry_yoga" => $nbry_planets);     
    }
    protected function checkVRY($data)
    {
        $own_sign                   = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $asc_sign                   = $data['Ascendant'];
        $sixth_sign                 = $this->getHouseSign($asc_sign, 6);
        $eight_sign                 = $this->getHouseSign($asc_sign, 8);
        $twelfth_sign               = $this->getHouseSign($asc_sign, 12);
        $sixth_lord                 = $own_sign[$sixth_sign];
        $eight_lord                 = $own_sign[$eight_sign];
        $twelfth_lord               = $own_sign[$twelfth_sign];
        $sixth_lord_pl              = $data[$sixth_lord];  // placement sign of sixth house lord
        $eight_lord_pl              = $data[$eight_lord];   // placement sign of eight house lord
        $twelfth_lord_pl            = $data[$twelfth_lord]; // placement sign of twelfth house lord
        $array                      = array();
        
        if($twelfth_lord_pl == $sixth_sign || $eight_lord_pl == $sixth_sign ||
            $sixth_lord_pl == $sixth_sign)
        {
            $harsha                 = array("harsha" => "There is Harsha Yoga of the <a href='https://www.astroisha.com/yogas/76-vry' title='Vipreeta Raj Yoga'>Vipreeta Raj Yoga</a> formed in your horoscope.");
            $array                  = array_merge($array, $harsha);
        }
        else
        {
            $harsha                 = array("harsha" => "No");
            $array                  = array_merge($array, $harsha);
        }
        if($twelfth_lord_pl == $eight_sign || $eight_lord_pl == $eight_sign ||
            $sixth_lord_pl == $eight_sign)
        {
            $sarala                 = array("sarala" => "There is Sarala Yoga of the <a href='https://www.astroisha.com/yogas/76-vry' title='Vipreeta Raj Yoga'>Vipreeta Raj Yoga</a> formed in your horoscope.");
            $array                  = array_merge($array, $sarala);
        }
        else
        {
            $sarala                 = array("sarala" => "No");
            $array                  = array_merge($array, $sarala);
        }
        if($twelfth_lord_pl == $twelfth_sign || $eight_lord_pl == $twelfth_sign ||
            $sixth_lord_pl == $twelfth_sign)
        {
            $vimala                  = array("vimala" => "There is Vimala Yoga of the <a href='https://www.astroisha.com/yogas/76-vry' title='Vipreeta Raj Yoga'>Vipreeta Raj Yoga</a> formed in your horoscope.");
            $array                  = array_merge($array, $vimala);
        }
        else
        {
            $vimala                 = array("vimala" => "No");
            $array                  = array_merge($array, $vimala);
        }
        //print_r($array);exit;
        return $array;
    }
     protected function checkAngaraka($mars, $rahu)
    {
        $dist                       = $this->getHouseDistance($mars, $rahu);
        if($dist == "1" || $dist == "7")
        {
            $array                  = array("angaraka_yoga" => "There is <a href='https://www.astroisha.com/yogas/451-angaraka-yoga' title='Angaraka Yoga'>Angaraka Yoga</a> in your horoscope.");
        }
        else
        {
            $array                  = array("angaraka_yoga" => "No");
        }
        return $array;
    }
    protected function checkParivartana($data)
    {
        $asc_sign                   = $data['Ascendant'];
        $own_sign                   = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $array                      = array();
        $i                          = 1;
        foreach($data as $key=>$planet)
        {
            if($key == "Sun" || $key == "Moon" || $key == "Mars" ||
               $key == "Mercury" || $key == "Jupiter" || 
               $key == "Venus" || $key == "Saturn")
            {
                $pl_sign_lord       = $own_sign[$planet]; // checks the lord of the sign where planet is located
                $pl_lord_loc        = $data[$pl_sign_lord];
                $sign_of_pl_lord    = $own_sign[$pl_lord_loc];
                if($key == $sign_of_pl_lord && $key !== $pl_sign_lord)
                {
                    unset($data[$key]);unset($data[$sign_of_pl_lord]);
                    $parivar        = array("parivartana_yoga_".$i => $key." and ".$pl_sign_lord." do <a href='https://www.astroisha.com/yogas/83-payo' title='Parivartana Yoga'>Parivartana Yoga</a> in your horoscope.");        
                    $array          = array_merge($array, $parivar);
                    $i              = $i + 1;
                }
                else
                {   
                    continue;
                }
                //if(($sun_lord == "Moon" && $moon_lord == "Sun")||($sun_lord == "Mars"))
            }
        }
        if(empty($array))
        {
            $array                  = array("parivartana_yoga_0" => "No");
        }
        //print_r($array);exit;
        return $array;
    }
    protected function checkChandraMangal($moon,$mars)
    {
        $moon_sign                  = $this->calcDetails($moon);
        $mars_sign                  = $this->calcDetails($mars);
        $diff                       = $moon - $mars;
        
        if($moon_sign == $mars_sign)
        {
            if(((int)$diff <= 12)&&($mars_sign == "Leo" || $mars_sign == "Aries" || $mars_sign == "Scorpio" || $mars_sign =="Sagittarius" || $mars_sign =="Pisces"))
            {
                $array              = array("chandra_mangal" => "There is very strong <a href='https://www.astroisha.com/yogas/150-chandra-mangal' title='chandra mangal yoga'>chandra-mangala yoga</a> formed in a favorable sign in your horoscope.");
            }
            else if(((int)$diff <= 12)&&($mars_sign !== "Leo" || $mars_sign !== "Aries" || $mars_sign !== "Scorpio" || $mars_sign !=="Sagittarius" || $mars_sign !=="Pisces"))
            {
                $array              = array("chandra_mangal" => "There is strong <a href='https://www.astroisha.com/yogas/150-chandra-mangal' title='chandra mangal yoga'>chandra-mangala yoga</a> formed in your horoscope.");
            }
            else
            {
                $array              = array("chandra_mangal" => "There is <a href='https://www.astroisha.com/yogas/150-chandra-mangal' title='chandra mangal yoga'>chandra-mangala yoga</a> formed in your horoscope.");
            }
        }
        else
        {
            $array                  = array("chandra_mangal" => "No");
        }
        return $array;
    }
    protected function checkGajaKesari($moon, $jupiter)
    {
        $jupiter                    = $this->removeRetro($jupiter);
        $moon_sign                  = $this->calcDetails($moon);
        $jup_sign                   = $this->calcDetails($jupiter);
        $dist                       = $this->getHouseDistance($moon_sign, $jup_sign);
        $diff                       = $moon - $jupiter;
        //echo $dist;exit;
        if(($jup_sign == $moon_sign) && ($jup_sign == "Cancer"|| $jup_sign == "Pisces") && ((int)$diff <= 12))
        {
            $array                  = array("gaja_kesari" => "There is very strong <a href='https://www.astroisha.com/yogas/84-gky' title='gaja-kesari yoga'>Gaja-Kesari Yoga</a> formed in a supportive sign in your horoscope.");
        }
        else if(($jup_sign == $moon_sign) && ($jup_sign !== "Cancer"|| $jup_sign !== "Pisces") && ((int)$diff <= 12))
        {
            $array                  = array("gaja_kesari" => "There is strong <a href='https://www.astroisha.com/yogas/84-gky' title='gaja-kesari yoga'>Gaja-Kesari Yoga</a> formed in your horoscope.");
        }
        else if($dist == "4" || $dist=="7"|| $dist=="1"||$dist=="10")
        {
            $array                  = array("gaja_kesari" => "There is <a href='https://www.astroisha.com/yogas/84-gky' title='gaja-kesari yoga'>Gaja-Kesari Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array                  = array("gaja_kesari" => "No");
        }
        return $array;
    }
    protected function checkSashaYoga($asc, $moon, $sat)
    {
        if($sat == "Libra" || $sat == "Capricorn"|| $sat == "Aquarius")
        {
            $dist_moon          = $this->getHouseDistance($moon, $sat);
            $dist_asc           = $this->getHouseDistance($asc, $sat);
            if($dist_asc == "1" || $dist_asc == "4" || $dist_asc == "7" || $dist_asc == "10")
            {
                $array              = array("sasha_yoga"    => "There is a powerful <a href='https://www.astroisha.com/yogas/78-sasha' title='sasha yoga'>Sasha Yoga</a> counted from ascendant in your horoscope.");
            }
            else if($dist_moon == "1" || $dist_moon == "4" || $dist_moon == "7" || $dist_moon == "10")
            {
                $array              = array("sasha_yoga"    => "There is <a href='https://www.astroisha.com/yogas/78-sasha' title='sasha yoga'>Sasha Yoga</a> counted from moon in your horoscope.");
            }
            else
            {
                $array              = array("sasha_yoga"    => "No");
            }
        }
        else
        {
            $array              = array("sasha_yoga"    => "No");
        }
        //print_r($array);exit;
        return $array;
    }
    protected function checkHansaYoga($asc_sign, $moon_sign, $jup_sign)
    {

        if($jup_sign == "Sagittarius" || $jup_sign == "Pisces"|| $jup_sign == "Cancer")
        {
            $dist_moon          = $this->getHouseDistance($moon_sign, $jup_sign);
            $dist_asc           = $this->getHouseDistance($asc_sign, $jup_sign);
            if($dist_asc == "1" || $dist_asc == "4" || $dist_asc == "7" || $dist_asc == "10")
            {
                $array              = array("hansa_yoga"    => "There is a powerful <a href='https://www.astroisha.com/yogas/80-hansa' title='hansa yoga'>Hansa Yoga</a> counted from ascendant in your horoscope.");
            }
            else if($dist_moon == "1" || $dist_moon == "4" || $dist_moon == "7" || $dist_moon == "10")
            {
                $array              = array("hansa_yoga"    => "There is <a href='https://www.astroisha.com/yogas/80-hansa' title='hansa yoga'>Hansa Yoga</a> counted from moon in your horoscope.");
            }
            else
            {
                $array              = array("hansa_yoga"    => "No");
            }
        }
        else
        {
            $array              = array("hansa_yoga"    => "No");
        }
        return $array;
    }
    protected function checkRuchakaYoga($asc_sign, $moon_sign, $mars_sign)
    {

        if($mars_sign == "Aries" || $mars_sign == "Scorpio"|| $mars_sign == "Capricorn")
        {
            $dist_moon          = $this->getHouseDistance($moon_sign, $mars_sign);
            $dist_asc           = $this->getHouseDistance($asc_sign, $mars_sign);
            if($dist_asc == "1" || $dist_asc == "4" || $dist_asc == "7" || $dist_asc == "10")
            {
                $array              = array("ruchak_yoga"    => "There is a powerful <a href='https://www.astroisha.com/yogas/79-ruchaka' title='ruchaka yoga'>Ruchaka Yoga</a> counted from ascendant in your horoscope.");
            }
            else if($dist_moon == "1" || $dist_moon == "4" || $dist_moon == "7" || $dist_moon == "10")
            {
                $array              = array("ruchak_yoga"    => "There is <a href='https://www.astroisha.com/yogas/79-ruchaka' title='ruchaka yoga'>Ruchaka Yoga</a> counted from moon in your horoscope.");
            }
            else
            {
                $array              = array("ruchak_yoga"    => "No");
            }
        }
        else
        {
            $array              = array("ruchak_yoga"    => "No");
        }
        return $array;
    }
    protected function checkMalavyaYoga($asc_sign, $moon_sign, $ven_sign)
    {

        if($ven_sign == "Taurus" || $ven_sign == "Libra"|| $ven_sign == "Pisces")
        {
            $dist_moon          = $this->getHouseDistance($moon_sign, $ven_sign);
            $dist_asc           = $this->getHouseDistance($asc_sign, $ven_sign);
            if($dist_asc == "1" || $dist_asc == "4" || $dist_asc == "7" || $dist_asc == "10")
            {
                $array              = array("malavya_yoga"    => "There is a powerful <a href='https://www.astroisha.com/yogas/81-mala' title='malavya yoga'>Malavya Yoga</a> counted from ascendant in your horoscope.");
            }
            else if($dist_moon == "1" || $dist_moon == "4" || $dist_moon == "7" || $dist_moon == "10")
            {
                $array              = array("malavya_yoga"    => "There is <a href='https://www.astroisha.com/yogas/81-mala' title='malavya yoga'>Malavya Yoga</a> counted from moon in your horoscope.");
            }
            else
            {
                $array              = array("malavya_yoga"    => "No");
            }
        }
        else
        {
            $array              = array("malavya_yoga"    => "No");
        }
        //print_r($array);exit;
        return $array;
    }
       protected function checkBhadraYoga($asc_sign, $moon_sign, $merc_sign)
    {
        //$merc_sign      = "Gemini";$asc_sign = "Pisces";
        if($merc_sign == "Gemini" || $merc_sign == "Virgo")
        {
            $dist_moon          = $this->getHouseDistance($moon_sign, $merc_sign);
            $dist_asc           = $this->getHouseDistance($asc_sign, $merc_sign);
            if($dist_asc == "1" || $dist_asc == "4" || $dist_asc == "7" || $dist_asc == "10")
            {
                $array              = array("bhadra_yoga"    => "There is a powerful <a href='https://www.astroisha.com/yogas/82-bhadra' title='bhadra yoga'>Bhadra Yoga</a> counted from ascendant in your horoscope.");
            }
            else if($dist_moon == "1" || $dist_moon == "4" || $dist_moon == "7" || $dist_moon == "10")
            {
                $array              = array("bhadra_yoga"    => "There is <a href='https://www.astroisha.com/yogas/82-bhadra' title='bhadra yoga'>Bhadra Yoga</a> counted from moon in your horoscope.");
            }
            else
            {
                $array              = array("bhadra_yoga"    => "No");
            }
        }
        else
        {
            $array              = array("bhadra_yoga"    => "No");
        }
        //print_r($array);exit;
       return $array;
    }
    protected function checkSunapha($data)
    {
        $moon_sign              = $data['Moon'];
        $get_next_sign          = $this->getHouseSign($moon_sign,2);
        $mars                   = $data['Mars'];
        $mercury                = $data['Mercury'];
        $jupiter                = $data['Jupiter'];
        $venus                  = $data['Venus'];
        $saturn                 = $data['Saturn'];
        //echo $mars." ".$mercury." ".$jupiter." ".$venus." ".$saturn;exit;
        if($saturn == $get_next_sign || $mars == $get_next_sign || $mercury == $get_next_sign
            || $jupiter == $get_next_sign || $venus == $get_next_sign)
        {
            $array              = array("sunapha_yoga" => "There is <a href='https://www.astroisha.com/yogas/145-sunapha-yoga' title='Sunapha Yoga'>Sunapha Yoga</a> formed in your horoscope");
        }
        else
        {
            $array              = array("sunapha_yoga" => "No");
        }
        //print_r($array);exit;
        return $array;
    }
    protected function checkAnapha($data)
    {
        $moon_sign              = $data['Moon'];
        $get_prev_sign          = $this->getHouseSign($moon_sign,12);
        $mars                   = $data['Mars'];
        $mercury                = $data['Mercury'];
        $jupiter                = $data['Jupiter'];
        $venus                  = $data['Venus'];
        $saturn                 = $data['Saturn'];
        //echo $mars." ".$mercury." ".$jupiter." ".$venus." ".$saturn;exit;
        if($saturn == $get_prev_sign || $mars == $get_prev_sign || $mercury == $get_prev_sign
            || $jupiter == $get_prev_sign || $venus == $get_prev_sign)
        {
            $array              = array("anapha_yoga" => "There is <a href='https://www.astroisha.com/yogas/147-anapha-yoga' title='Anapha Yoga'>Anapha Yoga</a> formed in your horoscope");
        }
        else
        {
            $array              = array("anapha_yoga" => "No");
        }
        //print_r($array);exit;
        return $array;
    }
    protected function checkDhurdura($data)
    {
        $moon_sign              = $data['Moon'];
        $get_prev_sign          = $this->getHouseSign($moon_sign,12);
        $get_next_sign          = $this->getHouseSign($moon_sign,2);
        $mars                   = $data['Mars'];
        $mercury                = $data['Mercury'];
        $jupiter                = $data['Jupiter'];
        $venus                  = $data['Venus'];
        $saturn                 = $data['Saturn'];
        
        if(($saturn == $get_next_sign) && ($mars == $get_prev_sign || $mercury == $get_prev_sign
            || $jupiter == $get_prev_sign || $venus == $get_prev_sign)) 
        {
            $array              = array("dhurdhura_yoga" => "There is <a href='https://www.astroisha.com/yogas/148-dhurdhura-yoga' title='Dhurdura Yoga'>Dhurdhura Yoga</a> formed in your horoscope");
        }
        else if(($jupiter == $get_next_sign) && ($mars == $get_prev_sign || $mercury == $get_prev_sign
            || $saturn == $get_prev_sign || $venus == $get_prev_sign))
        {
            $array              = array("dhurdhura_yoga" => "There is <a href='https://www.astroisha.com/yogas/148-dhurdhura-yoga' title='Dhurdura Yoga'>Dhurdhura Yoga</a> formed in your horoscope");
        }
        else if(($mercury == $get_next_sign) && ($mars == $get_prev_sign || $jupiter == $get_prev_sign
            || $saturn == $get_prev_sign || $venus == $get_prev_sign))
        {
            $array              = array("dhurdhura_yoga" => "There is <a href='https://www.astroisha.com/yogas/148-dhurdhura-yoga' title='Dhurdura Yoga'>Dhurdhura Yoga</a> formed in your horoscope");
        }
        else if(($venus == $get_next_sign) && ($mars == $get_prev_sign || $jupiter == $get_prev_sign
            || $saturn == $get_prev_sign || $mercury == $get_prev_sign))
        {
            $array              = array("dhurdhura_yoga" => "There is <a href='https://www.astroisha.com/yogas/148-dhurdhura-yoga' title='Dhurdura Yoga'>Dhurdhura Yoga</a> formed in your horoscope");
        }
        else if(($mars == $get_next_sign) && ($mercury == $get_prev_sign || $jupiter == $get_prev_sign
            || $saturn == $get_prev_sign || $venus == $get_prev_sign))
        {
            $array              = array("dhurdhura_yoga" => "There is <a href='https://www.astroisha.com/yogas/148-dhurdhura-yoga' title='Dhurdura Yoga'>Dhurdhura Yoga</a> formed in your horoscope");
        }
        else
        {
            $array              = array("dhurdhura_yoga" => "No");
        }
        //print_r($array);exit;
        return $array;
    }
    protected function checkKemdruma($data)
    {
        $moon_sign              = $data['Moon'];
        $get_prev_sign          = $this->getHouseSign($moon_sign,12);
        $get_next_sign          = $this->getHouseSign($moon_sign,2);
        $sun                    = $data['Sun'];
        $mars                   = $data['Mars'];
        $mercury                = $data['Mercury'];
        $jupiter                = $data['Jupiter'];
        $venus                  = $data['Venus'];
        $saturn                 = $data['Saturn'];
        
        if($saturn == $get_next_sign || $saturn == $get_prev_sign) 
        {
            $array              = array("kemdruma_yoga" => "No");
        }
        else if($jupiter == $get_next_sign || $jupiter == $get_prev_sign) 
        {
            $array              = array("kemdruma_yoga" => "No");
        }
        else if($mercury == $get_next_sign || $mercury == $get_prev_sign) 
        {
            $array              = array("kemdruma_yoga" => "No");
        }
        else if($venus == $get_next_sign || $venus == $get_prev_sign) 
        {
            $array              = array("kemdruma_yoga" => "No");
        }
        else if($mars == $get_next_sign || $mars == $get_prev_sign) 
        {
            $array              = array("kemdruma_yoga" => "No");
        }
        else if($mars == $moon_sign || $jupiter == $moon_sign || $mercury == $moon_sign ||
                $venus == $moon_sign || $saturn == $moon_sign)
        {
            $array              = array("kemdruma_yoga" => "<a href='https://www.astroisha.com/yogas/149-kemdruma-yoga' title='Kemdruma Yoga'>Kemdruma Yoga</a> gets cancelled in your horoscope due to a planet placed in same house as Moon.");
        }
         else if($sun == $get_next_sign || $sun == $get_prev_sign) 
        {
            $array              = array("kemdruma_yoga" => "No");
        }
        else
        {
            $array              = array("kemdruma_yoga" => "There is <a href='https://www.astroisha.com/yogas/149-kemdruma-yoga' title='Kemdruma Yoga'>Kemdruma Yoga</a> in your horoscope.");
        }
        //print_r($array);exit;
        return $array;
    }
    protected function checkAdhiYoga($moon_sign, $merc_sign, $jup_sign, $ven_sign)
    {
        $merc_dist          = $this->getHouseDistance($moon_sign, $merc_sign);
        $jup_dist           = $this->getHouseDistance($moon_sign, $jup_sign);
        $ven_dist           = $this->getHouseDistance($moon_sign, $ven_sign);
        //echo $merc_dist." ".$jup_dist." ".$ven_dist;exit;
        if($merc_dist == "6"&& $jup_dist=="7"&& $ven_dist=="8")
        {
            $array          = array("adhi_yoga"=>"There is <a href='https://www.astroisha.com/yogas/151-adhi-yoga' title='Adhi Yoga'>Adhi Yoga</a> in your horoscope.");
        }
        else if($merc_dist == "6"&& $jup_dist=="8"&& $ven_dist=="7")
        {
            $array          = array("adhi_yoga"=>"There is <a href='https://www.astroisha.com/yogas/151-adhi-yoga' title='Adhi Yoga'>Adhi Yoga</a> in your horoscope.");
        }
        else if($merc_dist == "7"&& $jup_dist=="8"&& $ven_dist=="6")
        {
            $array          = array("adhi_yoga"=>"There is <a href='https://www.astroisha.com/yogas/151-adhi-yoga' title='Adhi Yoga'>Adhi Yoga</a> in your horoscope.");
        }
         else if($merc_dist == "7"&& $jup_dist=="6"&& $ven_dist=="8")
        {
            $array          = array("adhi_yoga"=>"There is <a href='https://www.astroisha.com/yogas/151-adhi-yoga' title='Adhi Yoga'>Adhi Yoga</a> in your horoscope.");
        }
        else if($merc_dist == "8"&& $jup_dist=="6"&& $ven_dist=="7")
        {
            $array          = array("adhi_yoga"=>"There is <a href='https://www.astroisha.com/yogas/151-adhi-yoga' title='Adhi Yoga'>Adhi Yoga</a> in your horoscope.");
        }
        else if($merc_dist == "8"&& $jup_dist=="7"&& $ven_dist=="6")
        {
            $array          = array("adhi_yoga"=>"There is <a href='https://www.astroisha.com/yogas/151-adhi-yoga' title='Adhi Yoga'>Adhi Yoga</a> in your horoscope.");
        }
        else
        {
            $array          = array("adhi_yoga"=>"No");
        }
        //print_r($array);exit;
        return $array;
    }
    protected function checkVasumati($data)
    {
        $asc                = $data['Ascendant'];
        $moon               = $data['Moon'];
        $jup                = $data['Jupiter'];
        $ven                = $data['Venus'];
        $merc               = $data['Mercury'];
        
        $jup_asc_dist       = $this->getHouseDistance($asc, $jup);
        $jup_moon_dist      = $this->getHouseDistance($moon, $jup);
        $ven_asc_dist       = $this->getHouseDistance($asc, $ven);
        $ven_moon_dist      = $this->getHouseDistance($moon, $ven);
        $merc_asc_dist      = $this->getHouseDistance($asc, $merc);
        $merc_moon_dist     = $this->getHouseDistance($moon, $merc);
        $moon_asc_dist      = $this->getHouseDistance($asc, $moon);

        if($moon_asc_dist == "3" || $moon_asc_dist == "6" || $moon_asc_dist == "10" ||
            $moon_asc_dist == "11" || $ven_asc_dist == "3" || $ven_asc_dist == "6" ||
            $ven_asc_dist == "10" || $ven_asc_dist == "11" || $jup_asc_dist == "3" ||
            $jup_asc_dist == "6" || $jup_asc_dist == "10" || $jup_asc_dist == "11" ||
            $merc_asc_dist == "3" || $merc_asc_dist == "6" || $merc_asc_dist == "10" ||
            $merc_asc_dist == "11")
        {
            $array          = array("vasumati_yoga"  => "There is strong <a href='https://www.astroisha.com/yogas/154-vasumathi-yoga' title='Vasumathi Yoga'>Vasumathi Yoga</a> formed in your horoscope");
        }
        else if($ven_moon_dist == "3" || $ven_moon_dist == "6" ||
            $ven_moon_dist == "10" || $ven_moon_dist == "11" || $jup_moon_dist == "3" ||
            $jup_moon_dist == "6" || $jup_moon_dist == "10" || $jup_moon_dist == "11" ||
            $merc_moon_dist == "3" || $merc_moon_dist == "6" || $merc_moon_dist == "10" ||
            $merc_moon_dist == "11")
        {
            $array          = array("vasumati_yoga"  => "There is mild <a href='https://www.astroisha.com/yogas/154-vasumathi-yoga' title='Vasumathi Yoga'>Vasumathi Yoga</a> formed in your horoscope");
        }
        else
        {
            $array          = array("vasumati_yoga"  => "No");
        }
        return $array;
    }
    protected function checkChatusagara($data)
    {
        $asc_sign           = $data['Ascendant'];
        $planets            = array("Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu");
        $array              = array();
        foreach($planets as $planet)
        {
            $planet_sign     = $data[$planet];
            $planet_dist     = $this->getHouseDistance($asc_sign, $planet_sign);

            if($planet_sign     == $asc_sign)
            {
                $array_asc      = array("planet_asc"=>"yes");
                $array          = array_merge($array, $array_asc);
            }
            else if($planet_dist    == "4")
            {
                $array_4        = array("planet_4"=>"yes");
                $array          = array_merge($array,$array_4);
            }
            else if($planet_dist    == "7")
            {
                $array_7        = array("planet_7"=>"yes");
                $array          = array_merge($array,$array_7);
            }
            else if($planet_dist    == "10")
            {
                $array_10       = array("planet_10"=>"yes");
                $array          = array_merge($array,$array_10);
            }
        }
        //print_r($array);exit;
        if($array['planet_asc'] == "yes" && $array['planet_4'] == "yes" && $array['planet_7'] == "yes" && $array['planet_10'] == "yes")
        {
            $yoga           = array("chatusagara_yoga" => "There is <a href='https://www.astroisha.com/yogas/152-chatusagara-yoga' title='Chatusagara Yoga'>Chatusagara Yoga</a> in your horoscope");
        }
        else
        {
            $yoga           = array("chatusagara_yoga"  => "No");
        }
        //print_r($yoga);exit;
        return $yoga;
    }
    protected function checkRajlakshana($asc_sign,$moon_sign,$merc_sign,$jup_sign,$ven_sign)
    {
        $moon_dist          = $this->getHouseDistance($asc_sign, $moon_sign);
        $merc_dist          = $this->getHouseDistance($asc_sign, $merc_sign);
        $jup_dist           = $this->getHouseDistance($asc_sign, $jup_sign);
        $ven_dist           = $this->getHouseDistance($asc_sign, $ven_sign);
        
        if(($moon_dist == "1" || $moon_dist=="4"||$moon_dist =="7"||$moon_dist=="10")&&
           ($merc_dist == "1" || $merc_dist=="4"||$merc_dist =="7"||$merc_dist=="10") &&
           ($jup_dist == "1" || $jup_dist=="4"||$jup_dist =="7"||$jup_dist=="10") &&
           ($ven_dist == "1" || $ven_dist=="4"||$ven_dist =="7"||$ven_dist=="10"))
        {
            $array          = array("rajlakshana_yoga"  => "There is <a href='https://www.astroisha.com/yogas/155-rajlakshana' title='Rajlakshana Yoga'>Rajlakshana Yoga</a> in your horoscope");
        }
        else
        {
            $array          = array("rajlakshana_yoga"  => "No");
        }
        //print_r($array);exit;
        return $array;
    }
    protected function checkSakata($moon_sign,$jup_sign)
    {
        $dist               = $this->getHouseDistance($jup_sign, $moon_sign);
        if($dist == "6" || $dist == "8" || $dist == "12")
        {
            $array          = array("sakata_yoga" => "There is <a href='https://www.astroisha.com/yogas/156-sakata-yoga' title='Sakata Yoga'>Sakata Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array          = array("sakata_yoga"   => "No");
        }
        return $array;
    }
    protected function checkAmala($asc_sign,$moon_sign,$merc_sign,$jup_sign,$ven_sign)
    {
        $merc_dist_asc      = $this->getHouseDistance($asc_sign, $merc_sign);
        $jup_dist_asc       = $this->getHouseDistance($asc_sign, $jup_sign);
        $ven_dist_asc       = $this->getHouseDistance($asc_sign, $ven_sign);
        $merc_dist_moo      = $this->getHouseDistance($moon_sign, $merc_sign);
        $jup_dist_moo       = $this->getHouseDistance($moon_sign, $jup_sign);
        $ven_dist_moo       = $this->getHouseDistance($moon_sign, $ven_sign);
        
        if($merc_dist_asc=="10" || $jup_dist_asc == "10" ||$ven_dist_asc == "10")
        {
            $array          = array("amala_yoga"  => "There is <a href='https://www.astroisha.com/yogas/157-amala-yoga' title='Amala Yoga'>Amala Yoga</a> formed in your horoscope");
        }
        else if($merc_dist_moo=="10" || $jup_dist_moo == "10" ||$ven_dist_moo == "10")
        {
            $array          = array("amala_yoga"  => "There is <a href='https://www.astroisha.com/yogas/157-amala-yoga' title='Amala Yoga'>Amala Yoga</a> formed in your horoscope");
        }
        else
        {
            $array          = array("amala_yoga"  => "No");
        }
        //print_r($array);exit;
        return $array;
    }
    protected function checkParvata($data)
    {
        //print_r($data);exit;
        $asc_sign           = $data['Ascendant'];
        $jup_sign           = $data['Jupiter'];
        $merc_sign          = $data['Mercury'];
        $ven_sign           = $data['Venus'];
        $moon_sign          = $data['Moon'];
        //echo $asc_sign.' '.$jup_sign.' '.$merc_sign.' '.$ven_sign.' '.$moon_sign;exit;
        $twelfth_sign       = $this->getHouseSign($asc_sign,12);
        
        $jup_dist           = $this->getHouseDistance($asc_sign, $jup_sign);
        $merc_dist          = $this->getHouseDistance($asc_sign, $merc_sign);
        $ven_dist           = $this->getHouseDistance($asc_sign, $ven_sign);
        $moon_dist          = $this->getHouseDistance($asc_sign, $moon_sign);
        $own_sign                   = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $array                      = array();
        $sixth_planets      = $this->checkPlanetsInHouse($data, 6);
        $eight_planets      = $this->checkPlanetsInHouse($data, 8);
        $asc_lord           = $own_sign[$asc_sign];
        $twelfth_lord       = $own_sign[$twelfth_sign];
        $asc_lord_sign      = $data[$asc_lord];
        $twelfth_lord_sign  = $data[$twelfth_lord];
        $asc_lord_dist      = $this->getHouseDistance($asc_sign, $asc_lord_sign);
        $twelfth_lord_dist  = $this->getHouseDistance($asc_sign,$twelfth_lord_sign);

        if(($asc_lord_dist == "1" || $asc_lord_dist == "4" ||
           $asc_lord_dist == "7" || $asc_lord_dist == "10") &&
          ($twelfth_lord_dist == "1" || $twelfth_lord_dist == "4" ||
           $twelfth_lord_dist == "7" || $twelfth_lord_dist == "10"))
        {
            $array          = array("parvata_yoga" => "There is <a href='https://www.astroisha.com/yogas/158-parvata-yoga' title='Parvata Yoga'>Parvata Yoga</a> formed in your horoscope.");
        }
        else if(($jup_dist == "1" || $jup_dist == "4" || $jup_dist == "7" ||
                $jup_dist == "10") && ($merc_dist == "1" || $merc_dist == "4" ||
                $merc_dist == "7" || $merc_dist == "10") && ($ven_dist == "1" ||
                $ven_dist == "4" || $ven_dist == "7" || $ven_dist == "10") &&
                ($moon_dist == "1" || $moon_dist == "4" || $moon_dist == "7" || $moon_dist == "10") &&
                (count($sixth_planets['house_6']) == "0") && (count($eight_planets['house_8']) == "0"))
        {
            $array          = array("parvata_yoga" => "There is <a href='https://www.astroisha.com/yogas/158-parvata-yoga' title='Parvata Yoga'>Parvata Yoga</a> formed in your horoscope.");
        }
        else if(($jup_dist == "1" || $jup_dist == "4" || $jup_dist == "7" ||
            $jup_dist == "10" || $jup_dist =="6" || $jup_dist == "8") && 
            ($merc_dist == "1" || $merc_dist == "4" || $merc_dist == "7" ||
            $merc_dist == "10" || $merc_dist =="6" || $merc_dist == "8") && 
            ($ven_dist == "1" || $ven_dist == "4" || $ven_dist == "7" || 
            $ven_dist == "10" || $ven_dist =="6" || $ven_dist == "8") &&
            ($moon_dist == "1" || $moon_dist == "4" || $moon_dist == "7" ||
            $moon_dist == "10" || $moon_dist =="6" || $moon_dist == "8"))
        {
            $array          = array("parvata_yoga" => "There is <a href='https://www.astroisha.com/yogas/158-parvata-yoga' title='Parvata Yoga'>Parvata Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array          = array("parvata_yoga"  => "No");
        }
        return $array;
    }
    protected function checkKahala($data)
    {
        $own_sign           = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                    "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                    "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                    "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $exal_sign          = array("Libra"=>"Saturn","Scorpio"=>"","Cancer"=>"Jupiter","Taurus"=>"Moon",
                                    "Pisces"=>"Venus","Capricorn"=>"Mars","Virgo"=>"Mecury","Aries"=>"Sun");
        $asc_sign           = $data['Ascendant'];
        $asc_lord           = $own_sign[$asc_sign];
        $asc_pl             = $data[$asc_lord];
        $exal_pl            = $exal_sign[$asc_pl];
        $own_pl             = $own_sign[$asc_pl];
        //echo $asc_lord." ".$exal_pl." ".$own_pl;exit;
        $fourth_sign        = $this->getHouseSign($asc_sign, 4);
        $ninth_sign         = $this->getHouseSign($asc_sign, 9);
        
        $fourth_pl          = $data[$own_sign[$fourth_sign]];  // get horoscope sign of 4th lord
        $ninth_pl           = $data[$own_sign[$ninth_sign]];   // get horoscope sign of 9th lord
        
        $dist               = $this->getHouseDistance($fourth_pl, $ninth_pl);
        if(($dist == "1" || $dist == "4" || $dist == "7" || $dist == "10")&&
            ($asc_lord == $exal_pl || $asc_lord == $own_pl))
        {
            $array          = array("kahala_yoga"  => "There is <a href='https://www.astroisha.com/yogas/159-kahala-yoga' title='kahala yoga'>Kahala Yoga</a> formed in your horoscope.");

        }
        else
        {
            $array          = array("kahala_yoga"  => "No");
        }
     return $array;
    }
    protected function checkVesi($data)
    {
        $sun_sign           = $data['Sun'];
        $rahu_sign          = $data['Rahu'];
        $ketu_sign          = $data['Ketu'];
        $moon_sign          = $data['Moon'];
        $get_next_sign      = $this->getHouseSign($sun_sign, 2);
        $planets            = array("Mars","Mercury","Jupiter","Venus","Saturn");
        
        if($get_next_sign == $rahu_sign || $get_next_sign == $ketu_sign || $get_next_sign == $moon_sign)
        {
            $array      = array("vesi_yoga" => "No");
        }
        else
        {
            foreach($planets as $planet)
            {
                $sign           = $data[$planet];
                if($get_next_sign == $sign)
                {
                     $array      = array("vesi_yoga" => "There is <a href='https://www.astroisha.com/yogas/160-vesi-yoga' title='Vesi Yoga'>Vesi Yoga</a> formed in your horoscope.");
                     break;
                }
                else
                {
                    $array      = array("vesi_yoga" => "No");
                }
            }
        }
        //print_r($array);exit;
        return $array;
    }
    protected function checkObyachari($data)
    {
        $sun                = $data["Sun"];
        $moon               = $data["Moon"];
        $get_next_sign      = $this->getHouseSign($sun, 2);
        $get_prev_sign      = $this->getHouseSign($sun, 12);

        $planets            = array("Mars","Mercury","Jupiter","Venus","Saturn");
        
        if($moon == $get_next_sign || $moon == $get_prev_sign)
        {
            $array      = array("obya_yoga" => "No");
        }
        else
        {
            foreach($planets as $planet)
            {
                $sign           = $data[$planet];
                if($get_next_sign == $sign || $get_prev_sign == $sign)
                {
                     $array      = array("obya_yoga" => "There is <a href='https://www.astroisha.com/yogas/161-obyachari-yoga' title='Obyachari Yoga'>Obyachari Yoga</a> formed in your horoscope.");
                     break;
                }
                else
                {
                    $array      = array("obya_yoga" => "No");
                }
            }
        }
        return $array;
    }
    protected function checkMahabhagyaYoga($user_data, $data)
    {
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
            $timezone       = $user_data['tmz_words'];
        }
        $asc_sign           = $data['Ascendant'];
        $sun_sign           = $data['Sun'];
        $moon_sign          = $data['Moon'];
        $odd_sign           = array("Aries","Gemini","Leo","Libra","Sagittarius","Aquarius");
        $even_sign          = array("Taurus","Cancer","Virgo","Scorpio","Capricorn","Pisces");
        $gender             = $user_data['gender'];
        $dob                = new DateTime($user_data['dob_tob']);
        $date               = $dob->format('d.m.Y');
        $tob                = $dob->format('d-m-Y H:i:s');
        $tmz                = $timezone;
        
        $checkSunTimes      = $this->getSunTimings($date, $tmz, $lat, $lon, 0, 3);
        $sun_rise           = $checkSunTimes['sun_rise_2'];
        $sun_set            = $checkSunTimes['sun_set_2'];
        $next_sun_rise      = $checkSunTimes['sun_rise_3'];
        //echo $sun_rise." ".$sun_set." ".$tob;exit;
        // checks to see if gender is male, birth is during daytime and 
        // ascendant, moon and sun are in odd signs
        if($gender == "male" && $tob > $sun_rise && $tob < $sun_set &&
            in_array($asc_sign, $odd_sign) && in_array($moon_sign,$odd_sign) &&
            in_array($sun_sign, $odd_sign))
        {
            $array          = array("mahabhagya_yoga" => "There is <a href='https://www.astroisha.com/yogas/163-mahabhagya-yoga' title='Mahabhagya Yoga'>Mahabhagya Yoga</a> formed in your horoscope.");
        }
        // checks to see if gender is female, birth is at night and ascendant,
        // moon and sun are in even signs
        else if($gender == "female" && $tob > $sun_set && $tob < $next_sun_rise &&
             in_array($asc_sign, $even_sign) && in_array($moon_sign,$even_sign) &&
            in_array($sun_sign, $even_sign))
        {
            $array          = array("mahabhagya_yoga" => "There is <a href='https://www.astroisha.com/yogas/163-mahabhagya-yoga' title='Mahabhagya Yoga'>Mahabhagya Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array          = array("mahabhagya_yoga" => "No");
        }
        //print_r($array);exit;
        return $array;
    }
    protected function checkLaxmi($data)
    {
        $exal_sign                  = array("Libra"=>"Saturn","Scorpio"=>"","Cancer"=>"Jupiter","Taurus"=>"Moon",
                                            "Pisces"=>"Venus","Capricorn"=>"Mars","Virgo"=>"Mecury","Aries"=>"Sun");
        $own_sign                   = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $asc_sign           = $data['Ascendant'];       // ascendant sign
        $asc_lord           = $own_sign[$asc_sign];     // lord of asc
        $asc_lord_pl        = $data[$asc_lord];         // sign in which asc lord is
        $asc_exal           = $exal_sign[$asc_lord_pl];
        $asc_own            = $own_sign[$asc_lord_pl];
        $asc_lord_dist      = $this->getHouseDistance($asc_sign, $asc_lord_pl);
        $ninth_sign         = $this->getHouseSign($asc_sign, 9);        // 9th sign
        $ninth_lord         = $own_sign[$ninth_sign];       // lord of 9th sign
        $ninth_lord_pl      = $data[$ninth_lord];       // sign where 9th lord is placed
        $ninth_lord_dist    = $this->getHouseDistance($asc_sign, $ninth_lord_pl);  // dist from ascendant
        $ninth_exal         = $exal_sign[$ninth_lord_pl];
        $ninth_own          = $own_sign[$ninth_lord_pl];
        //echo $ninth_lord." ".$ninth_exal." ".$ninth_own;exit;
        $venus_sign         = $data['Venus'];
        $venus_dist         = $this->getHouseDistance($asc_sign, $venus_sign);
         //echo $asc_lord." ".$asc_exal." ".$asc_own;exit;
        if(($asc_lord == $asc_exal || $asc_lord == $asc_own)&&
            ($asc_lord_dist == "1" || $asc_lord_dist == "4" || 
            $asc_lord_dist == "7" || $asc_lord_dist == "10") &&
            ($ninth_lord == $ninth_exal || $ninth_lord == $ninth_own)&&
            ($ninth_lord_dist == "1" || $ninth_lord_dist == "4" || 
            $ninth_lord_dist == "7" || $ninth_lord_dist == "10"))
        {
            $array          = array("laxmi_yoga" => "There is <a href='https://www.astroisha.com/yogas/167-laxmi-yoga' title='Laxmi Yoga'>Laxmi Yoga</a> formed in your horoscope.");
        }
        else if((($ninth_lord == $ninth_exal || $ninth_lord == $ninth_own)&&
            ($ninth_lord_dist == "1" || $ninth_lord_dist == "4" || 
            $ninth_lord_dist == "7" || $ninth_lord_dist == "10")) && 
            (($venus_sign == "Taurus" || $venus_sign == "Libra" || $venus_sign == "Pisces")&&
             ($venus_dist == "1" || $venus_dist == "4" || $venus_dist == "10" || $venus_dist == "7")))
        {
            $array          = array("laxmi_yoga" => "There is <a href='https://www.astroisha.com/yogas/167-laxmi-yoga' title='Laxmi Yoga'>Laxmi Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array          = array("laxmi_yoga" => "No");
        }
        return $array;
    }
    protected function checkGauri($data)
    {
        $own_sign           = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                    "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                    "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                    "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $asc_sign           = $this->calcDetails($data['Ascendant']);
        $asc_dist           = $this->convertDecimalToDegree(str_replace(":r","",$data['Ascendant']),"details");
        $navamsha           = $this->getNavamsha("Ascendant", $asc_sign, $asc_dist);
        $navamsha           = $navamsha['Ascendant_navamsha_sign'];
        $asc_lord           = $own_sign[$asc_sign];
        $nav_lord           = $own_sign[$navamsha];
        $tenth_sign         = $this->getHouseSign($asc_sign, "10");
        $tenth_lord         = $own_sign[$tenth_sign];
        $tenth_lord_sign    = $this->calcDetails($data[$tenth_lord]);
        $tenth_lord_dist    = $this->getHouseDistance($asc_sign, $tenth_lord_sign);
       
        $asc_lord_sign      = $this->calcDetails($data[$asc_lord]);
        $nav_lord_sign      = $this->calcDetails($data[$nav_lord]);
        $asc_lord_dist      = $this->getHouseDistance($asc_sign, $asc_lord_sign);
        $nav_lord_dist      = $this->getHouseDistance($asc_sign, $nav_lord_sign);
        if(($asc_lord_dist == "10" && $nav_lord_dist == "10")||
            ($tenth_lord_dist == "10" && $nav_lord_dist == "10"))
        {
            $array          = array("gauri_yoga" => "There is <a href='https://www.astroisha.com/yogas/168-gauri-yoga' title='Gauri Yoga'>Gauri Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array          = array("gauri_yoga" => "No");
        }
        return $array;
    }
    protected function checkChapa($data)
    {
        $own_sign           = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $exal_sign          = array("Libra"=>"Saturn","Scorpio"=>"","Cancer"=>"Jupiter","Taurus"=>"Moon",
                                "Pisces"=>"Venus","Capricorn"=>"Mars","Virgo"=>"Mecury","Aries"=>"Sun");
        $asc_sign           = $data['Ascendant'];
        $asc_lord           = $own_sign[$asc_sign];
        $asc_exal_sign      = array_search($asc_lord, $exal_sign);
        $asc_lord_sign      = $data[$asc_lord];
        $fourth_sign        = $this->getHouseSign($asc_sign, 4);
        $fourth_lord        = $own_sign[$fourth_sign];
        $tenth_sign         = $this->getHouseSign($asc_sign, 10);
        $tenth_lord         = $own_sign[$tenth_sign];

        $fourth_lord_sign   = $data[$fourth_lord];
        $tenth_lord_sign    = $data[$tenth_lord];
         
        if(($asc_lord_sign == $asc_exal_sign) && ($fourth_lord_sign == $tenth_sign) && 
            ($tenth_lord_sign == $fourth_sign))
        {
            $array          = array("chapa_yoga" => "There is Chapa Yoga formed in your horoscope.");
        }
        else
        {
            $array          = array("chapa_yoga" => "No");
        }
        return $array;
    }
    protected function checkSreenatha($asc, $merc)
    {
       if($asc == "Sagittarius" && $merc == "Virgo")
       {
           $array           = array("sreenatha_yoga" => "There is <a href='https://www.astroisha.com/yogas/173-sreenatha-yoga' title='Sreenatha Yoga'>Sreenatha Yoga</a> formed in your horoscope.");
       }
       else
       {
           $array           = array("sreenatha_yoga" => "No");
       }
       return $array;
    }
    protected function checkMallika($data)
    {
        unset($data['Ascendant']);unset($data['Rahu']);unset($data['Ketu']);
        unset($data['Uranus']);unset($data['Pluto']);unset($data['Neptune']);
        $data       = array("Sun"=>"Aries","Moon"=>"Taurus","Mars"=>"Capricorn","Mercury"=>"Gemini",
                            "Jupiter"=>"Cancer","Venus"=>"Pisces","Saturn"=>"Libra");
        if(count($data) !== count(array_unique($data)))
        {
            $array           = array("malika_yoga" => "No");
        }
        else
        {
            $i          = 0;
            foreach($data as $key=>$value)
            {
                $prev_sign      = $this->getHouseSign($value, 12);
                $next_sign      = $this->getHouseSign($value, 2);
                
                if(in_array($prev_sign, $data) || in_array($next_sign, $data))
                {
                    //echo $key." ".$value." ".$i."<br/>";
                    $i++;
                }
                else
                {
                    $array           = array("malika_yoga" => "No");
                }
            }
            if($i == "7")
            {
                $array           = array("malika_yoga" => "There is <a href='https://www.astroisha.com/yogas/174-malika-yoga'>Mallika Yoga</a> formed in horoscope.");
            }
            else
            {
                $array           = array("malika_yoga" => "No");
            }

        }
   
        return $array;
    }
    protected function checkSankha($data)
    {
        $own_sign           = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $exal_sign          = array("Libra"=>"Saturn","Scorpio"=>"","Cancer"=>"Jupiter","Taurus"=>"Moon",
                                "Pisces"=>"Venus","Capricorn"=>"Mars","Virgo"=>"Mecury","Aries"=>"Sun");
        $asc_sign           = $data['Ascendant'];
        $asc_lord           = $own_sign[$asc_sign];
        $fifth_sign         = $this->getHouseSign($asc_sign, 5);
        $sixth_sign         = $this->getHouseSign($asc_sign, 6);
        $fifth_lord         = $own_sign[$fifth_sign];
        $sixth_lord         = $own_sign[$sixth_sign];
        $fifth_lord_pl      = $data[$fifth_lord];
        $sixth_lord_pl      = $data[$sixth_lord];
        $dist               = $this->getHouseDistance($fifth_lord_pl, $sixth_lord_pl);
        $own_sign           = array_keys($own_sign, $asc_lord);
        $exal_sign          = array_search($asc_lord, $exal_sign);

        $count              = count($own_sign);
        if($count == "2")
        {
            if(($data[$asc_lord] == $exal_sign || $data[$asc_lord] == $own_sign[0] ||
               $data[$asc_lord] == $own_sign[1]) && ($dist == "1" || $dist == "4" ||
               $dist == "7" || $dist == "10"))
            {
                $array      = array("sankha_yoga" => "There is <a href='https://www.astroisha.com/yogas/183-sankha-yoga' title='Sankha Yoga'>Sankha Yoga</a> formed in your horoscope.");
            }
            else
            {
                $array      = array("sankha_yoga" => "No");
            }
        }
        else
        {
            if(($data[$asc_lord] == $exal_sign || $data[$asc_lord] == $own_sign[0])
                && ($dist == "1" || $dist == "4" ||
               $dist == "7" || $dist == "10"))
            {
                $array      = array("sankha_yoga" => "There is <a href='https://www.astroisha.com/yogas/183-sankha-yoga' title='Sankha Yoga'>Sankha Yoga</a> formed in your horoscope.");
            }
            else
            {
                $array      = array("sankha_yoga" => "No");
            }
        }
        return $array;
    }
    protected function checkDaridra($data)
    {
        $own_sign           = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        
        $asc_sign           = $data['Ascendant'];
        $eleventh_sign      = $this->getHouseSign($asc_sign, 11);
        $eleventh_lord      = $own_sign[$eleventh_sign];
        $eleventh_lord_pl   = $data[$eleventh_lord];
        $dist               = $this->getHouseDistance($asc_sign, $eleventh_lord_pl);
        if($dist == "6" || $dist == "8" || $dist == "12")
        {
            $array          = array("daridra_yoga" => "There is <a href='https://www.astroisha.com/yogas/269-daridra-yoga' title='Daridra Yoga'>Daridra Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array          = array("daridra_yoga" => "No");
        }
        return $array;
    }
    protected function checkBheri($data)
    {
        $own_sign           = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                    "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                    "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                    "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");          
        $asc_sign           = $data['Ascendant'];
        $asc_lord           = $own_sign[$asc_sign];
        $asc_lord_sign      = $data[$asc_lord];
        $jup_sign           = $data['Jupiter'];
        $ven_sign           = $data['Venus'];
        
        $asc_lord_dist      = $this->getHouseDistance($asc_sign, $asc_lord_sign);
        $jup_dist           = $this->getHouseDistance($asc_sign, $jup_sign);
        $ven_dist           = $this->getHouseDistance($asc_sign, $ven_sign);
        
        if(($asc_lord_dist == "1" || $asc_lord_dist == "4" || $asc_lord_dist == "7" ||
            $asc_lord_dist == "10")&&($jup_dist == "1" || $jup_dist == "4" || 
            $jup_dist == "7" || $jup_dist == "10")&&($ven_dist == "1" || $ven_dist == "4" ||
            $ven_dist == "7" || $ven_dist == "10"))
        {
            $array          = array("bheri_yoga"    => "There is <a href='https://www.astroisha.com/yogas/282-bheri-yoga' title='Bheri Yoga'>Bheri Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array          = array("bheri_yoga"    => "No");
        }
        return $array;
    }
    protected function checkMridanga($data)
    {
        $own_sign           = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                    "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                    "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                    "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $exal_sign          = array("Libra"=>"Saturn","Scorpio"=>"","Cancer"=>"Jupiter","Taurus"=>"Moon",
                                    "Pisces"=>"Venus","Capricorn"=>"Mars","Virgo"=>"Mecury","Aries"=>"Sun");
        $asc_sign           = $this->calcDetails($data['Ascendant']);
        $asc_lord           = $own_sign[$asc_sign];
        $asc_lord_pl        = $this->calcDetails($data[$asc_lord]);
        $asc_dist           = $this->convertDecimalToDegree(str_replace(":r","",$data['Ascendant']),"details");
        $asc_own            = array_keys($own_sign, $asc_lord);
        $asc_exal           = array_search($asc_lord, $exal_sign);
        $count              = count($asc_own);

        if($count == "2")
        {
            if($asc_own[0] == $asc_lord_pl || $asc_own[1] == $asc_lord_pl ||
                $asc_exal == $asc_lord_pl)
            {
                $navamsha           = $this->getNavamsha("Ascendant", $asc_sign, $asc_dist);
                $nav_sign           = $navamsha['Ascendant_navamsha_sign'];
                $nav_lord           = $own_sign[$nav_sign];
                $nav_exal           = array_search($nav_lord, $exal_sign);
                $nav_own            = array_keys($own_sign, $nav_lord);
                $count              = count($nav_own);
                $dist               = $this->getHouseDistance($asc_sign, $nav_sign);
        
                if(($dist == "1" || $dist == "4" || $dist == "7" ||
                   $dist == "10" || $dist == "5" || $dist == "9") && 
                    $nav_exal == $nav_sign)
                {
                    $nav_dist           = $this->convertDecimalToDegree(str_replace(":r","",$data[$nav_lord]),"details");
                    $nav_lord_sign      = $this->getNavamsha($nav_lord, $nav_sign, $nav_dist);
                    $nav_lord_sign      = $nav_lord_sign[$nav_lord."_navamsha_sign"];
                    if($count == "2")
                    {
                       if($nav_lord_sign == $nav_own[0] || $nav_lord_sign == $nav_own[1] ||
                           $nav_lord_sign == $nav_exal)
                       {
                          return array("mridanga_yoga"    => "There is <a href='https://www.astroisha.com/yogas/288-mridanga-yoga' title='Mridanga Yoga'>Mridanga Yoga</a> formed in your horoscope.");
                       }
                       else
                        {
                            return array("mridanga_yoga" => "No");exit;
                        }
                    }
                    else
                    {
                        if($nav_lord_sign == $nav_own[0] || $nav_lord_sign == $nav_exal)
                        {
                            return array("mridanga_yoga"    => "There is <a href='https://www.astroisha.com/yogas/288-mridanga-yoga' title='Mridanga Yoga'>Mridanga Yoga</a> formed in your horoscope.");
                        }
                        else
                        {
                            return array("mridanga_yoga" => "No");exit;
                        }
                    }
                }
                else
                {
                    return array("mridanga_yoga" => "No");exit;
                }               
            }
            else
            {
                return array("mridanga_yoga" => "No");exit;
            }
        }
        else
        {
             if($asc_own[0] == $asc_lord_pl || $asc_exal == $asc_lord_pl)
            {
                $navamsha           = $this->getNavamsha("Ascendant", $asc_sign, $asc_dist);
                $nav_sign           = $navamsha['Ascendant_navamsha_sign'];
                $nav_lord           = $own_sign[$nav_sign];
                $nav_exal           = array_search($nav_lord, $exal_sign);
                $nav_own            = array_keys($own_sign, $nav_lord);
                $count              = count($nav_own);
                $dist               = $this->getHouseDistance($asc_sign, $nav_sign);
        
                if(($dist == "1" || $dist == "4" || $dist == "7" ||
                   $dist == "10" || $dist == "5" || $dist == "9") && 
                    $nav_exal == $nav_sign)
                {
                    $nav_dist           = $this->convertDecimalToDegree(str_replace(":r","",$data[$nav_lord]),"details");
                    $nav_lord_sign      = $this->getNavamsha($nav_lord, $nav_sign, $nav_dist);
                    $nav_lord_sign      = $nav_lord_sign[$nav_lord."_navamsha_sign"];
                    if($count == "2")
                    {
                       if($nav_lord_sign == $nav_own[0] || $nav_lord_sign == $nav_own[1] ||
                           $nav_lord_sign == $nav_exal)
                       {
                           $array    = array("mridanga_yoga"    => "There is <a href='https://www.astroisha.com/yogas/288-mridanga-yoga' title='Mridanga Yoga'>Mridanga Yoga</a> formed in your horoscope.");
                       }
                       else
                        {
                            return array("mridanga_yoga" => "No");exit;
                        }
                    }
                    else
                    {
                        if($nav_lord_sign == $nav_own[0] || $nav_lord_sign == $nav_exal)
                        {
                            $array    = array("mridanga_yoga"    => "There is <a href='https://www.astroisha.com/yogas/288-mridanga-yoga' title='Mridanga Yoga'>Mridanga Yoga</a> formed in your horoscope.");
                        }
                        else
                        {
                            return array("mridanga_yoga" => "No");exit;
                        }
                    }
                }
                else
                {
                    return array("mridanga_yoga" => "No");exit;
                }   
            }
            else
            {
                return array("mridanga_yoga" => "No");exit;
            }
        } 
    }
    protected function checkGaja($data)
    {
        $own_sign           = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                    "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                    "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                    "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $asc_sign           = $this->calcDetails($data['Ascendant']);
        $eleventh_sign      = $this->getHouseSign($asc_sign, 11);
        $eleventh_lord      = $own_sign[$eleventh_sign];
        $seventh_sign       = $this->getHouseSign($asc_sign, 7);
        $seventh_lord       = $own_sign[$seventh_sign];
        $seventh_pl         = $data[$seventh_lord];
        $moon_pl            = $data['Moon'];
        $check_aspects      = $this->checkAspectsOnHouse($data, 11);
        $check_aspects      = $check_aspects['aspect_11'];
        $count              = count($check_aspects);
        
        if($seventh_pl == $eleventh_sign && $moon_pl == $eleventh_sign)
        {
            for($i=0; $i<= $count; $i++)
            {
                $lord       = $check_aspects[$i];
                if($lord    == $eleventh_lord)
                {
                    return array("gaja_yoga" => "There is Gaja Yoga formed in your horoscope.");exit;
                }   
                else
                {
                    continue;
                }
            }
            
        }
        else
        {
            return array("gaja_yoga"    => "No");exit;
        }
    }
    protected function checkKalnidhi($asc, $merc, $jup, $ven)
    {
        $dist           = $this->getHouseDistance($asc, $jup);
        if(($dist == "2" || $dist == "5")&& $jup == "Virgo" ||
            ($jup == "Gemini" || $jup == "Libra" || $jup == "Taurus")&&
            ($jup == $merc && $jup == $ven))
        {
            $array      = array("kalnidhi_yoga" => "There is <a href='https://www.astroisha.com/yogas/323-kalinidhi_yoga' title='kalnidhi Yoga'>Kalnidhi Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array      = array("kalnidhi_yoga" => "No");
        }
        return $array;
    }
    protected function checkAmsavatara($data)
    {
        $sat            = $data['Saturn'];
        $asc            = $data['Ascendant'];
        $jup            = $data['Jupiter'];
        $ven            = $data['Venus'];

        $mov_sign       = array("Aries", "Cancer","Libra","Capricorn");
        if($sat == "Libra" && in_array($asc, $mov_sign) && in_array($jup, $mov_sign)
            && in_array($ven, $mov_sign))
        {
           $array       = array("amsavatara_yoga"   => "There is <a href='https://www.astroisha.com/yogas/329-amsavatara-yoga' title='Amsavatara Yoga'>Amsavatara Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array      = array("amsavatara_yoga" => "No");
        }
        return $array;
    }
    protected function checkKusuma($data)
    {
        $asc            = $data['Ascendant'];
        $jup            = $data['Jupiter'];
        $moon           = $data['Moon'];
        $sun            = $data['Sun'];
        $seventh        = $this->getHouseSign($asc, 7);
        $second         = $this->getHouseSign($asc, 2);      
        
        if($asc == $jup && $moon == $seventh && $sun == $second)
        {
            $array      = array("kusuma_yoga"   => "There is <a href='https://www.astroisha.com/yogas/335-kusuma-yoga' title='Kusuma Yoga'>Kusuma Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array      = array("kusuma_yoga"   => "No");
        }
        
        return $array;
    }
    protected function checkKurma($data)
    {
        $asc            = $this->calcDetails($data['Ascendant']);
        $third          = $this->getHouseSign($asc, 3);
        $eleventh       = $this->getHouseSign($asc,11);
       
        $fifth          = $this->getHouseSign($asc, 5);
        $sixth          = $this->getHouseSign($asc, 6);
        $seventh        = $this->getHouseSign($asc, 7);
        $array          = array();
        $benefic        = array();
        $exal_sign                  = array("Libra"=>"Saturn","Scorpio"=>"","Cancer"=>"Jupiter","Taurus"=>"Moon",
                                            "Pisces"=>"Venus","Capricorn"=>"Mars","Virgo"=>"Mecury","Aries"=>"Sun");
        $own_sign                   = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $friendly                   = array("Jupiter"=>"Aries,Scorpio,Leo","Venus"=>"Gemini,Cancer,Capricorn,Aquarius",
                                            "Moon"=>"Aries,Leo,Libra,Sagittarius,Pisces","Mercury"=>"Taurus,Leo,Libra,Capricorn, Aquarius");
        // checks the benefics in 5th house, 6th house and 7th house
        $x              = 0;
        $y              = 0;
        foreach($data as $planet=>$dist)
        {

            $sign       = $this->calcDetails($dist);
            if(($planet == "Jupiter" || $planet == "Venus" ||
               $planet == "Mercury" || $planet == "Moon") && $sign == $fifth)
            {
                $pl_dist        = $this->convertDecimalToDegree(str_replace(":r","",$data[$planet]),"details");
                $pl_nav         = $this->getNavamsha($planet, $sign, $pl_dist);
                $pl_nav_sign    = $pl_nav[$planet.'_navamsha_sign'];
                if($exal_sign[$pl_nav_sign] == $planet || $own_sign[$pl_nav_sign] == $planet ||
                        (strpos($friendly[$planet], $pl_nav_sign) !== false))
                {
                    $x          = $x + 1;
                }
            }
            else if(($planet == "Jupiter" || $planet == "Venus" ||
               $planet == "Mercury" || $planet == "Moon") && $sign == $sixth)
            {
                $pl_dist        = $this->convertDecimalToDegree(str_replace(":r","",$data[$planet]),"details");
                $pl_nav         = $this->getNavamsha($planet, $sign, $pl_dist);
                $pl_nav_sign    = $pl_nav[$planet.'_navamsha_sign'];
                if($exal_sign[$pl_nav_sign] == $planet || $own_sign[$pl_nav_sign] == $planet ||
                        (strpos($friendly[$planet], $pl_nav_sign) !== false))
                {
                    $x          = $x + 1;
                }
 
            }
            else if(($planet == "Jupiter" || $planet == "Venus" ||
               $planet == "Mercury" || $planet == "Moon") && $sign == $seventh)
            {
                $pl_dist        = $this->convertDecimalToDegree(str_replace(":r","",$data[$planet]),"details");
                $pl_nav         = $this->getNavamsha($planet, $sign, $pl_dist);
                $pl_nav_sign    = $pl_nav[$planet.'_navamsha_sign'];
                if($exal_sign[$pl_nav_sign] == $planet || $own_sign[$pl_nav_sign] == $planet ||
                        (strpos($friendly[$planet], $pl_nav_sign) !== false))
                {
                    $x          = $x + 1;
                }
                
            }
            
        }
        if($x == "3")
        {
            $array              = array("kurma_yoga" => "There is <a href='https://www.astroisha.com/yogas/489-kurma-yoga' title='Kurma Yoga'>Kurma Yoga</a> formed in your horoscope.");
        }
        else
        {
            foreach($data as $planet=>$dist)
            {
                $sign       = $this->calcDetails($dist);
                if(($planet == "Jupiter" || $planet == "Venus" ||
                $planet == "Mercury" || $planet == "Moon") && $sign == $asc)
                {
                    if($exal_sign[$sign] == $planet || $own_sign[$sign] == $planet ||
                            (strpos($friendly[$planet], $sign) !== false))
                    {
                        $y          = $y + 1;
                    }
                }
                else if(($planet == "Jupiter" || $planet == "Venus" ||
                $planet == "Mercury" || $planet == "Moon") && $sign == $third)
                {
                    if($exal_sign[$sign] == $planet || $own_sign[$sign] == $planet ||
                            (strpos($friendly[$planet], $sign) !== false))
                    {
                        $y          = $y + 1;
                    }
                }
                else if(($planet == "Jupiter" || $planet == "Venus" ||
                $planet == "Mercury" || $planet == "Moon") && $sign == $eleventh)
                {
                    if($exal_sign[$sign] == $planet || $own_sign[$sign] == $planet ||
                            (strpos($friendly[$planet], $sign) !== false))
                    {
                        $y          = $y + 1;
                    }
                }
             
            }
        }
        if($y == "3")
        {
            $array              = array("kurma_yoga" => "There is <a href='https://www.astroisha.com/yogas/489-kurma-yoga' title='Kurma Yoga'>Kurma Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array              = array("kurma_yoga"   => "No");
        }
        return $array;
    }
    protected function checkDevendra($data)
    {
        $own_sign               = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                        "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                        "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                        "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $asc_sign               = $data['Ascendant'];
        $sec_sign               = $this->getHouseSign($asc_sign, 2);
        $ten_sign               = $this->getHouseSign($asc_sign, 10);
        $elev_sign              = $this->getHouseSign($asc_sign, 11);
        
        $asc_lord               = $own_sign[$asc_sign];
        $sec_lord               = $own_sign[$sec_sign];
        $ten_lord               = $own_sign[$ten_sign];
        $elev_lord              = $own_sign[$elev_sign];
        //echo $data[$asc_lord]." ".$elev_sign." ".$data[$elev_lord]." ".$asc_sign;exit;
        //echo $data[$ten_lord]." ".$sec_sign." ".$data[$sec_lord]." ".$ten_sign;exit;
        if(($data[$asc_lord] == $elev_sign && $data[$elev_lord] == $asc_sign)&&
            ($data[$ten_lord] == $sec_sign && $data[$sec_lord] == $ten_sign))
        {
            $array              = array("deven_yoga" => "There is <a href='https://www.astroisha.com/yogas/492-deven-yoga' title='Devendra Yoga'>Devendra Yoga</a> formed in your horoscope.");
        }
        else
        {
            $array              = array("deven_yoga" => "no");
        }
        return $array;
    }
}
