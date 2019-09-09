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
 
    public function addUserDetails($details)
    {
        //print_r($details);exit;
        $fname          = $details['fname'];
        $gender         = $details['gender'];
        $dob            = $details['dob'];
        $tob            = $details['tob'];
        $pob            = $details['pob'];
        $lon            = $details['lon'];
        $lat            = $details['lat'];
        $tmz            = $details['tmz'];
        $chart          = $details['chart'];
        if($tmz == "none")
        {
            $date           = new DateTime($dob." ".$tob);
            $timestamp      = $date->format('U');
            $tmz            = $this->getTimeZone($lat, $lon, "rohdes");
            if($tmz == "error")
            {
                $tmz        = "UTC";        // if timezone not available use UTC(Universal Time Cooridnated)
            }
            $newdate        = new DateTime($dob." ".$tob, new DateTimeZone($tmz));
            $dob_tob        = $newdate->format('Y-m-d H:i:s');
        }
        else
        {
            $date       = new DateTime($dob." ".$tob, new DateTimeZone($tmz));
            $dob_tob    = $date->format('Y-m-d H:i:s');
        }
        $uniq_id        = uniqid('horo_');
        
        $now            = date('Y-m-d H:i:s');
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $columns        = array('uniq_id','fname','gender','chart_type','dob_tob','pob','lon','lat','timezone','query_date','query_cause');
        $values         = array($db->quote($uniq_id),$db->quote($fname),$db->quote($gender),$db->quote($chart),$db->quote($dob_tob),
                                $db->quote($pob),$db->quote($lon),$db->quote($lat),$db->quote($tmz),$db->quote($now),$db->quote('astroyogas'));
        $query          ->insert($db->quoteName('#__horo_query'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
        $db             ->setQuery($query);
        $result          = $db->query();
        if($result)
        {
            //echo "query inserted";exit;
            $app        = JFactory::getApplication();
            $link       = JURI::base().'astroyogas?chart='.str_replace("horo","chart",$uniq_id);
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
        $fname          = $user_data['fname'];
        $gender         = $user_data['gender'];
        $dob_tob        = $user_data['dob_tob'];
        $pob            = $user_data['pob'];
        $lat            = $user_data['lat'];
        $lon            = $user_data['lon'];
        $timezone       = $user_data['timezone'];
        
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
        $data                       = array_merge($asc,$planets);
        $checkVishYoga              = $this->checkVishYoga($data['Moon'],$data['Saturn']);
        $checkBudhAditya            = $this->checkBudhAditya($data['Sun'],$data['Mercury']);
        $checkVipraChandal          = $this->checkVipraChandal($data['Jupiter'],$data['Rahu']);
        $checkShrapit               = $this->checkShrapit($data['Saturn'],$data['Rahu'],$data['Ketu']);
        $checkGrahan                = $this->checkGrahan($data['Sun'],$data['Moon'],$data['Rahu'],$data['Ketu']);
        $checkPitru                 = $this->checkPitru($data['Sun'],$data['Saturn']);
        $checkKaalSarpa             = $this->checkKaalSarpa($data);
        $checkNBRY                  = $this->checkNBRY($data);
        $checkVRY                   = $this->checkVRY($data);
        $checkChandraMangal         = $this->checkChandraMangal($data['Moon'],$data['Mars']);
        $checkGajaKesari            = $this->checkGajaKesari($data['Moon'], $data['Jupiter']);
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
        $checkRajlakshana           = $this->checkRajlakshana($data['Ascendant'],$data["Moon"],$data['Mercury'],$data['Jupiter'],$data['Venus']);
        $checkSakata                = $this->checkSakata($data['Moon'],$data['Jupiter']);
        $checkAmala                 = $this->checkAmala($data['Ascendant'],$data['Moon'],$data['Mercury'],$data['Jupiter'],$data['Venus']);
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
                $array              = array("vish_yoga" => "There is a strong <a href='https://www.astroisha.com/yogas/74-visha-yoga' title='vish yoga' >vish yoga</a> in your horoscope. Your life could be full of difficulties.");
            }
            else
            {
                $array              = array("visha_yoga" => "There is <a href='https://www.astroisha.com/yogas/74-visha-yoga' title='vish yoga' >vish yoga</a> in your horoscope. Some troubles in life are expected.");
            }
        }
        else
        {
            $array                  = array("visha_Yoga" => "none");
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
                $array              = array("budh_aditya" => "There is a very strong <a href='https://www.astroisha.com/yogas/162-budh-aditya'  title='budh-aditya yoga'>budh-aditya yoga</a> in a favorable sign in your horoscope.");
            }
            else  if(($sun_sign !== "Leo" || $sun_sign !== "Gemini" || $sun_sign !== "Virgo")&&((int)$diff <= 12))
            {
                $array              = array("budh_aditya" => "There is a strong <a href='https://www.astroisha.com/yogas/162-budh-aditya'  title='budh-aditya yoga'>budh-aditya yoga</a> in your horoscope.");
            }
            else 
            {
                $array              = array("budh_aditya" => "There is a mild <a href='https://www.astroisha.com/yogas/162-budh-aditya'  title='budh-aditya yoga'>budh-aditya yoga</a> in your horoscope.");
            }   
            
        }
        else
        {
            $array                  = array("budh_aditya" => "none");
        }
        return $array;
    }
    protected function checkVipraChandal($jup, $rahu)
    {
        $jup_sign                   = $this->calcDetails($jup);
        $rahu_sign                  = $this->calcDetails($rahu);
        
        if($jup_sign == $rahu_sign)
        {
            if($jup_sign == "Sagittarius" || $jup_sign == "Pisces")
            {
                $array                  = array("vipra_chandal" => "There is <a href='https://www.astroisha.com/yogas/77-vcy'  title='vipra-chandal yoga'>vipra-chandal yoga</a> in Jupiter's sign in your horoscope. Though its a bad yoga it can work in your favour if you accomodate traits of Jupiter in your life.");
            }
            else 
            {
                $array                  = array("vipra_chandal" => "There is <a href='https://www.astroisha.com/yogas/77-vcy'  title='vipra-chandal yoga'>vipra-chandal yoga</a> in your horoscope. Troubles in life are possible especially if you try shortcuts in life.");
            }
        }
        else
        {
            $array                      = array("vipra_chandal" => "none");
        }
        return $array;
    }
    protected function checkShrapit($sat, $rahu, $ketu)
    {
        $sat_sign                   = $this->calcDetails($sat);
        $rahu_sign                  = $this->calcDetails($rahu);
        $ketu_sign                  = $this->calcDetails($ketu);
        
        if($sat_sign == $rahu_sign)
        {
            $array                  = array("shrapit_yoga" => "There is <a href='https://www.astroisha.com/yogas/391-shrapit-association' title='shrapit yoga' >shrapit yoga</a> in your horoscope due to Saturn and Rahu joining together in the same sign.");
        }
        else if($sat_sign == $ketu_sign)
        {
            $array                  = array("shrapit_yoga" => "There is <a href='https://www.astroisha.com/yogas/391-shrapit-association' title='shrapit yoga' >shrapit yoga</a> in your horoscope due to Saturn and Ketu joining together in the same sign.");
        }
        else
        {
            $array                  = array("shrapit_yoga" => "none");
        }
        return $array;
    }
    protected function checkGrahan($sun, $moon, $rahu, $ketu)
    {
        $sun_sign                   = $this->calcDetails($sun);
        $moon_sign                  = $this->calcDetails($moon);
        $rahu_sign                  = $this->calcDetails($rahu);
        $ketu_sign                  = $this->calcDetails($ketu);
        
        if($sun_sign == $rahu_sign)
        {
            $array                  = array("grahan_yoga" => "There is <a href='https://www.astroisha.com/yogas/447-grahan-yoga' title='grahan yoga' >grahan yoga</a> in your horoscope due to Sun and Rahu joining in same sign.");
        }
        else if($sun_sign == $ketu_sign)
        {
            $array                  = array("grahan_yoga" => "There is <a href='https://www.astroisha.com/yogas/447-grahan-yoga' title='grahan yoga' >grahan yoga</a> in your horoscope due to Moon and Rahu joining in same sign.");
        }
        else if($moon_sign == $rahu_sign)
        {
            $array                  = array("grahan_yoga" => "There is <a href='https://www.astroisha.com/yogas/447-grahan-yoga' title='grahan yoga' >grahan yoga</a> in your horoscope due to Sun and Ketu joining in same sign.");
        }
        else if($moon_sign == $ketu_sign)
        {
            $array                  = array("grahan_yoga" => "There is <a href='https://www.astroisha.com/yogas/447-grahan-yoga' title='grahan yoga' >grahan yoga</a> in your horoscope due to Moon and Ketu joining in same sign.");
        }
        else
        {
            $array                  = array("grahan_yoga" => "none");
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
                $array              = array("pitru_dosha" => "There is a strong <a href='https://www.astroisha.com/yogas/97-pitru-dosha-2' title='pitru dosha' >pitru dosha</a> in your horoscope due to Sun and Saturn joining together in same sign. Your life could be full of difficulties.");
            }
            else
            {
                $array              = array("pitru_dosha" => "There is <a href='https://www.astroisha.com/yogas/97-pitru-dosha-2' title='pitru dosha' >pitru dosha</a> in your horoscope due to Sun and Saturn joining together in same sign. Some troubles in life are expected.");
            }
        }
        else
        {
            $array                  = array("pitru_dosha" => "none");
        }
        return $array;
    }
    protected function checkKaalSarpa($data)
    {
        $asc_sign                   = $this->calcDetails($data['Ascendant']);
        $rahu_sign                  = $this->calcDetails($data['Rahu']);
        $ketu_sign                  = $this->calcDetails($data['Ketu']);
        $rahu_dist                  = $this->getHouseDistance($asc_sign, $rahu_sign);
        $ketu_dist                  = $this->getHouseDistance($asc_sign,$ketu_sign);
        $planets                    = array("Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn");
        $array                      = array();$upper = array();$lower = array();
        $j                          = 0;
        $k                          = 0;
        //echo $rahu_dist." ".$ketu_dist."<br/>";
        foreach($planets as $planet)
        {
            $planet_sign            = $this->calcDetails($data[$planet]);
            $planet_dist            = $this->getHouseDistance($asc_sign,$planet_sign);
           
            if($rahu_dist      < $ketu_dist)
            {
                if($planet_dist >= $rahu_dist && $planet_dist <= $ketu_dist)
                {
                    
                     $j         = $j+1;
                }
                else
                {
                    $k          = $k+1;
                }
            }
            else
            {
                //$k                  = $k+1;
                if($planet_dist <= $rahu_dist && $planet_dist > $ketu_dist)
                {
                    $j          = $j+1;
                }
                else
                {
                    $k          = $k+1;
                }
            }
        }
        if($j == "7" || $k == "7")
        {
            $array              = array("kaal_sarpa"=> "There is Kaal Sarpa Yoga in your horoscope.");
        }
        else
        {
            $array              = array("kaal_sarpa"=>"none");
        }
        return $array;
    }
    protected function checkNBRY($data)
    {
        $asc_sign                   = $this->calcDetails($data['Ascendant']);

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
           
           $sign                    = $this->calcDetails($data[$planets[$i]]);
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
            if(strpos($data[$planet],":r")){$status = "retro";}else{$status = "normal";}
            $planet_sign            = $this->calcDetails($data[$planet]);
            $planet_from_asc        = $this->getHouseDistance($asc_sign, $planet_sign);
            $deb_sign               = $deb[$planet];
            $exal_planet            = $exal_sign[$deb_sign]; //echo $exal_planet;exit;
            $own_planet             = $own_sign[$deb_sign]; //echo $own_planet;exit;
            $ex_pl_sign             = $this->calcDetails($data[$exal_planet]);  // horoscope placement sign of planet which gets exalted in debilitated sign
            $own_pl_sign            = $this->calcDetails($data[$own_planet]);   // horoscope placement sign of planet which owns the debilitated sign  

            if($planet_sign == $deb_sign)
            {
                 // check1 sees if planet is in a quadrant or not
                if($planet_from_asc == "1" || $planet_from_asc == "4"||
                   $planet_from_asc == "7" || $planet_from_asc == "7")
                {
                    $check1         = "pass";
                }
                else
                {
                    $check1         = "fail";
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
                    $ex_pl_loc      = $this->calcDetails($data[$ex_pl]); // checks the horoscope sign of exalted planet
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
                 // check5 checks if planet is retrograde in a quadrant from ascendant
                if($status == "retro" && ($pl_from_asc == "1" || $pl_from_asc == "4" || 
                    $pl_from_asc == "7" || $pl_from_asc == "10"))
                {
                    $check5         = "pass";
                }
                else
                {
                    $check5         = "fail";
                }
                if($check1 == "pass" && $check2 == "pass")
                {
                    $nbry_planets[]         = $planet." does <a href='https://www.astroisha.com/yogas/75-nbry' title='NBRY'>NBRY</a> in your horoscope.";
                }
                else if($check1 == "pass" && $check3 == "pass")
                {
                    $nbry_planets[]         = $planet." does <a href='https://www.astroisha.com/yogas/75-nbry' title='NBRY'>NBRY</a> in your horoscope.";
                }
                else if($check1 == "pass" && $check4 == "pass")
                {
                    $nbry_planets[]         = $planet." does <a href='https://www.astroisha.com/yogas/75-nbry' title='NBRY'>NBRY</a> in your horoscope.";
                }
                else if($check1 == "true" && $check5 == "true")
                {
                    $nbry_planets[]         = $planet." does correction in your horoscope. <a href='https://www.astroisha.com/yogas/75-nbry' title='NBRY'>NBRY</a> may or may not happen.";
                }
                else
                {
                    $nbry_planets[]         = $planet." none";
                }
            }
            
        }
        return $nbry_planets;     
    }
    protected function checkVRY($data)
    {
        $own_sign                   = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        $asc_sign                   = $this->calcDetails($data['Ascendant']);
        $sixth_sign                 = $this->getHouseSign($asc_sign, 6);
        $eigth_sign                 = $this->getHouseSign($asc_sign, 8);
        $twelfth_sign               = $this->getHouseSign($asc_sign, 12);
        $sixth_lord                 = $own_sign[$sixth_sign];
        
    }
    protected function checkChandraMangal($moon,$mars)
    {
        $moon_sign                  = $this->calcDetails($sun);
        $mars_sign                  = $this->calcDetails($mars);
        $diff                       = $moon - $mars;
        
        if($moon_sign == $mars_sign)
        {
            if(((int)$diff <= 12)&&($mars_sign == "Leo" || $mars_sign == "Aries" || $mars_sign == "Scorpio" || $mars_sign =="Sagittarius" || $mars_sign =="Pisces"))
            {
                $array              = array("chandra_mangal" => "There is very strong <a href='https://www.astroisha.com/yogas/150-chandra-mangal' title='chandra mangal yoga'>chandra-mangala yoga</a> in a favorable sign in your horoscope. You would be happy and successful in life via hard work and genuine efforts.");
            }
            else if(((int)$diff <= 12)&&($mars_sign !== "Leo" || $mars_sign !== "Aries" || $mars_sign !== "Scorpio" || $mars_sign !=="Sagittarius" || $mars_sign !=="Pisces"))
            {
                $array              = array("chandra_mangal" => "There is strong <a href='https://www.astroisha.com/yogas/150-chandra-mangal' title='chandra mangal yoga'>chanra-mangala yoga</a> in your horoscope. This yoga promises happiness and success if you work hard.");
            }
            else
            {
                $array              = array("chandra_mangal" => "There is <a href='https://www.astroisha.com/yogas/150-chandra-mangal' title='chandra mangal yoga'>chandra-mangala yoga</a> in your horoscope. You would achieve success and happiness via hard work.");
            }
        }
        else
        {
            $array                  = array("chandra_mangal" => "none");
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
            $array                  = array("gaja_kesari" => "There is very strong <a href='https://www.astroisha.com/yogas/84-gky' title='gaja-kesari yoga'>gaja-kesari yoga</a> in a supportive sign in your horoscope.");
        }
        else if(($jup_sign == $moon_sign) && ($jup_sign !== "Cancer"|| $jup_sign !== "Pisces") && ((int)$diff <= 12))
        {
            $array                  = array("gaja_kesari" => "There is strong <a href='https://www.astroisha.com/yogas/84-gky' title='gaja-kesari yoga'>gaja-kesari yoga</a> in your horoscope.");
        }
        else if($dist == "4" || $dist=="7"|| $dist=="1"||$dist=="10")
        {
            $array                  = array("gaja_kesari" => "There is <a href='https://www.astroisha.com/yogas/84-gky' title='gaja-kesari yoga'>gaja-kesari yoga</a> in your horoscope.");
        }
        else
        {
            $array                  = array("gaja_kesari" => "none");
        }
        return $array;
    }
    protected function checkSashaYoga($asc, $moon, $saturn)
    {
        $asc_sign       = $this->calcDetails($asc);
        $moon_sign      = $this->calcDetails($moon);
        $sat_sign       = $this->calcDetails($saturn);
        
        if($sat_sign == "Libra" || $sat_sign == "Capricorn"|| $sat_sign == "Aquarius")
        {
            $dist_moon          = $this->getHouseDistance($moon_sign, $sat_sign);
            $dist_asc           = $this->getHouseDistance($asc_sign, $sat_sign);
            if($dist_asc == "1" || $dist_asc == "4" || $dist_asc == "7" || $dist_asc == "10")
            {
                $array              = array("sasha_yoga"    => "There is a powerful <a href='https://www.astroisha.com/yogas/78-sasha' title='sasha yoga'>sasha yoga</a> counted from ascendant in your horoscope.");
            }
            else if($dist_moon == "1" || $dist_moon == "4" || $dist_moon == "7" || $dist_moon == "10")
            {
                $array              = array("sasha_yoga"    => "There is <a href='https://www.astroisha.com/yogas/78-sasha' title='sasha yoga'>sasha yoga</a> counted from moon in your horoscope.");
            }
            else
            {
                $array              = array("sasha_yoga"    => "none");
            }
        }
        else
        {
            $array              = array("sasha_yoga"    => "none");
        }
        return $array;
    }
    protected function checkHansaYoga($asc, $moon, $jupiter)
    {
        $asc_sign       = $this->calcDetails($asc);
        $moon_sign      = $this->calcDetails($moon);
        $jup_sign       = $this->calcDetails($jupiter);

        if($jup_sign == "Sagittarius" || $jup_sign == "Pisces"|| $jup_sign == "Cancer")
        {
            $dist_moon          = $this->getHouseDistance($moon_sign, $jup_sign);
            $dist_asc           = $this->getHouseDistance($asc_sign, $jup_sign);
            if($dist_asc == "1" || $dist_asc == "4" || $dist_asc == "7" || $dist_asc == "10")
            {
                $array              = array("hansa_yoga"    => "There is a powerful <a href='https://www.astroisha.com/yogas/80-hansa' title='hansa yoga'>hansa yoga</a> counted from ascendant in your horoscope.");
            }
            else if($dist_moon == "1" || $dist_moon == "4" || $dist_moon == "7" || $dist_moon == "10")
            {
                $array              = array("hansa_yoga"    => "There is <a href='https://www.astroisha.com/yogas/80-hansa' title='hansa yoga'>hansa yoga</a> counted from moon in your horoscope.");
            }
            else
            {
                $array              = array("hansa_yoga"    => "none");
            }
        }
        else
        {
            $array              = array("hansa_yoga"    => "none");
        }
        return $array;
    }
    protected function checkRuchakaYoga($asc, $moon, $mars)
    {
        $asc_sign       = $this->calcDetails($asc);
        $moon_sign      = $this->calcDetails($moon);
        $mars_sign      = $this->calcDetails($mars);

        if($mars_sign == "Aries" || $mars_sign == "Scorpio"|| $mars_sign == "Capricorn")
        {
            $dist_moon          = $this->getHouseDistance($moon_sign, $mars_sign);
            $dist_asc           = $this->getHouseDistance($asc_sign, $mars_sign);
            if($dist_asc == "1" || $dist_asc == "4" || $dist_asc == "7" || $dist_asc == "10")
            {
                $array              = array("ruchak_yoga"    => "There is a powerful <a href='https://www.astroisha.com/yogas/79-ruchaka' title='ruchaka yoga'>ruchaka yoga</a> counted from ascendant in your horoscope.");
            }
            else if($dist_moon == "1" || $dist_moon == "4" || $dist_moon == "7" || $dist_moon == "10")
            {
                $array              = array("ruchak_yoga"    => "There is <a href='https://www.astroisha.com/yogas/79-ruchaka' title='ruchaka yoga'>ruchaka yoga</a> counted from moon in your horoscope.");
            }
            else
            {
                $array              = array("ruchak_yoga"    => "none");
            }
        }
        else
        {
            $array              = array("ruchak_yoga"    => "none");
        }
        return $array;
    }
    protected function checkMalavyaYoga($asc, $moon, $venus)
    {
        $asc_sign       = $this->calcDetails($asc);
        $moon_sign      = $this->calcDetails($moon);
        $ven_sign       = $this->calcDetails($venus);

        if($ven_sign == "Taurus" || $ven_sign == "Libra"|| $ven_sign == "Pisces")
        {
            $dist_moon          = $this->getHouseDistance($moon_sign, $ven_sign);
            $dist_asc           = $this->getHouseDistance($asc_sign, $ven_sign);
            if($dist_asc == "1" || $dist_asc == "4" || $dist_asc == "7" || $dist_asc == "10")
            {
                $array              = array("malavya_yoga"    => "There is a powerful <a href='https://www.astroisha.com/yogas/81-mala' title='malavya yoga'>malavya yoga</a> counted from ascendant in your horoscope.");
            }
            else if($dist_moon == "1" || $dist_moon == "4" || $dist_moon == "7" || $dist_moon == "10")
            {
                $array              = array("malavya_yoga"    => "There is <a href='https://www.astroisha.com/yogas/81-mala' title='malavya yoga'>malavya yoga</a> counted from moon in your horoscope.");
            }
            else
            {
                $array              = array("malavya_yoga"    => "none");
            }
        }
        else
        {
            $array              = array("malavya_yoga"    => "none");
        }
        return $array;
    }
       protected function checkBhadraYoga($asc, $moon, $merc)
    {
        $asc_sign       = $this->calcDetails($asc);
        $moon_sign      = $this->calcDetails($moon);
        $merc_sign      = $this->calcDetails($merc);
        //$merc_sign      = "Gemini";$asc_sign = "Pisces";
        if($merc_sign == "Gemini" || $merc_sign == "Virgo")
        {
            $dist_moon          = $this->getHouseDistance($moon_sign, $merc_sign);
            $dist_asc           = $this->getHouseDistance($asc_sign, $merc_sign);
            if($dist_asc == "1" || $dist_asc == "4" || $dist_asc == "7" || $dist_asc == "10")
            {
                $array              = array("bhadra_yoga"    => "There is a powerful <a href='https://www.astroisha.com/yogas/82-bhadra' title='bhadra yoga'>bhadra yoga</a> counted from ascendant in your horoscope.");
            }
            else if($dist_moon == "1" || $dist_moon == "4" || $dist_moon == "7" || $dist_moon == "10")
            {
                $array              = array("bhadra_yoga"    => "There is <a href='https://www.astroisha.com/yogas/82-bhadra' title='bhadra yoga'>bhadra yoga</a> counted from moon in your horoscope.");
            }
            else
            {
                $array              = array("bhadra_yoga"    => "none");
            }
        }
        else
        {
            $array              = array("bhadra_yoga"    => "none");
        }
       return $array;
    }
    protected function checkSunapha($data)
    {
        $moon                   = $data['Moon'];
        $moon_sign              = $this->calcDetails($moon);
        $get_next_sign          = $this->getHouseSign($moon_sign,2);
        $mars                   = $this->calcDetails($data['Mars']);
        $mercury                = $this->calcDetails($data['Mercury']);
        $jupiter                = $this->calcDetails($data['Jupiter']);
        $venus                  = $this->calcDetails($data['Venus']);
        $saturn                 = $this->calcDetails($data['Saturn']);
        
        if($saturn == $get_next_sign || $mars == $get_next_sign || $mercury == $get_next_sign
            || $jupiter == $get_next_sign || $venus == $get_next_sign)
        {
            $array              = array("sunapha_yoga" => "There is <a href='https://www.astroisha.com/yogas/145-sunapha-yoga' title='Sunapha Yoga'>Sunapha Yoga</a> formed in your horoscope");
        }
        else
        {
            $array              = array("sunapha_yoga" => "none");
        }
        return $array;
    }
    protected function checkAnapha($data)
    {
        $moon                   = $data['Moon'];
        $moon_sign              = $this->calcDetails($moon);
        $get_prev_sign          = $this->getHouseSign($moon_sign,12);
        $mars                   = $this->calcDetails($data['Mars']);
        $mercury                = $this->calcDetails($data['Mercury']);
        $jupiter                = $this->calcDetails($data['Jupiter']);
        $venus                  = $this->calcDetails($data['Venus']);
        $saturn                 = $this->calcDetails($data['Saturn']);
        
        if($saturn == $get_prev_sign || $mars == $get_prev_sign || $mercury == $get_prev_sign
            || $jupiter == $get_prev_sign || $venus == $get_prev_sign)
        {
            $array              = array("anapha_yoga" => "There is <a href='https://www.astroisha.com/yogas/147-anapha-yoga' title='Anapha Yoga'>Anapha Yoga</a> formed in your horoscope");
        }
        else
        {
            $array              = array("anapha_yoga" => "none");
        }
        return $array;
    }
    protected function checkDhurdura($data)
    {
        $moon                   = $data['Moon'];
        $moon_sign              = $this->calcDetails($moon);
        $get_prev_sign          = $this->getHouseSign($moon_sign,12);
        $get_next_sign          = $this->getHouseSign($moon_sign,2);
        $mars                   = $this->calcDetails($data['Mars']);
        $mercury                = $this->calcDetails($data['Mercury']);
        $jupiter                = $this->calcDetails($data['Jupiter']);
        $venus                  = $this->calcDetails($data['Venus']);
        $saturn                 = $this->calcDetails($data['Saturn']);
        
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
            $array              = array("dhurdhura_yoga" => "none");
        }
        return $array;
    }
    protected function checkKemdruma($data)
    {
        $moon                   = $data['Moon'];
        $moon_sign              = $this->calcDetails($moon);
        $get_prev_sign          = $this->getHouseSign($moon_sign,12);
        $get_next_sign          = $this->getHouseSign($moon_sign,2);
        $mars                   = $this->calcDetails($data['Mars']);
        $mercury                = $this->calcDetails($data['Mercury']);
        $jupiter                = $this->calcDetails($data['Jupiter']);
        $venus                  = $this->calcDetails($data['Venus']);
        $saturn                 = $this->calcDetails($data['Saturn']);
        
        if($saturn == $get_next_sign || $saturn == $get_prev_sign) 
        {
            $array              = array("kemdruma_yoga" => "none");
        }
        else if($jupiter == $get_next_sign || $jupiter == $get_prev_sign) 
        {
            $array              = array("kemdruma_yoga" => "none");
        }
        else if($mercury == $get_next_sign || $mercury == $get_prev_sign) 
        {
            $array              = array("kemdruma_yoga" => "none");
        }
        else if($venus == $get_next_sign || $venus == $get_prev_sign) 
        {
            $array              = array("kemdruma_yoga" => "none");
        }
        else if($mars == $get_next_sign || $mars == $get_prev_sign) 
        {
            $array              = array("kemdruma_yoga" => "none");
        }
        else if($mars == $moon_sign || $jupiter == $moon_sign || $mercury == $moon_sign ||
                $venus == $moon_sign || $saturn == $moon_sign)
        {
            $array              = array("kemdruma_yoga" => "<a href='https://www.astroisha.com/yogas/149-kemdruma-yoga' title='Kemdruma Yoga'>Kemdruma Yoga</a> gets cancelled in your horoscope due to a planet placed in same house as Moon.");
        }
        else
        {
            $array              = array("kemdruma_yoga" => "There is <a href='https://www.astroisha.com/yogas/149-kemdruma-yoga' title='Kemdruma Yoga'>Kemdruma Yoga</a> in your horoscope.");
        }
        return $array;
    }
    protected function checkAdhiYoga($moon, $mercury, $jupiter, $venus)
    {
        $moon_sign          = $this->calcDetails($moon);
        $merc_sign          = $this->calcDetails($mercury);
        $jup_sign           = $this->calcDetails($jupiter);
        $ven_sign           = $this->calcDetails($venus);
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
            $array          = array("adhi_yoga"=>"none");
        }
        return $array;
    }
    protected function checkChatusagara($data)
    {
        $asc                = $data['Ascendant'];
        $asc_sign           = $this->calcDetails($asc);
        $planets            = array("Sun","Moon","Mars","Mercury","Jupiter","Venus","Saturn","Rahu","Ketu");
        $array              = array();
        foreach($planets as $planet)
        {
            $planet_sign     = $this->calcDetails($data[$planet]);
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
            $yoga           = array("chatusagara_yoga" => "There is <a href='' title='Chatusagara Yoga'>Chatusagara Yoga</a> in your horoscope");
        }
        else
        {
            $yoga           = array("chatusagara_yoga"  => "none");
        }
        return $yoga;
    }
    protected function checkRajlakshana($asc,$moon,$mercury,$jupiter,$venus)
    {
        $asc_sign           = $this->calcDetails($asc);
        $moon_sign          = $this->calcDetails($moon);
        $merc_sign          = $this->calcDetails($mercury);
        $jup_sign           = $this->calcDetails($jupiter);
        $ven_sign           = $this->calcDetails($venus);
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
            $array          = array("rajlakshana_yoga"  => "none");
        }
        return $array;
    }
    protected function checkSakata($moon,$jup)
    {
        $moon_sign          = $this->calcDetails($moon);
        $jup_sign           = $this->calcDetails($jup);
        $dist               = $this->getHouseDistance($jup_sign, $moon_sign);
        if($dist == "6" || $dist == "8" || $dist == "12")
        {
            $array          = array("sakata_yoga" => "There is <a href='https://www.astroisha.com/yogas/156-sakata-yoga' title='Sakata Yoga'>Sakata Yoga</a> in your horoscope.");
        }
        else
        {
            $array          = array("sakata_yoga"   => "none");
        }
        return $array;
    }
    protected function checkAmala($asc,$moon,$mercury,$jupiter,$venus)
    {
        $asc_sign           = $this->calcDetails($asc);
        $moon_sign          = $this->calcDetails($moon);
        $merc_sign          = $this->calcDetails($mercury);
        $jup_sign           = $this->calcDetails($jupiter);
        $ven_sign           = $this->calcDetails($venus);
        $merc_dist_asc      = $this->getHouseDistance($asc_sign, $merc_sign);
        $jup_dist_asc       = $this->getHouseDistance($asc_sign, $jup_sign);
        $ven_dist_asc       = $this->getHouseDistance($asc_sign, $ven_sign);
        $merc_dist_moo      = $this->getHouseDistance($moon_sign, $merc_sign);
        $jup_dist_moo       = $this->getHouseDistance($moon_sign, $jup_sign);
        $ven_dist_moo       = $this->getHouseDistance($moon_sign, $ven_sign);
        
        if($merc_dist_asc=="10" || $jup_dist_asc == "10" ||$ven_dist_asc == "10")
        {
            $array          = array("amala_yoga"  => "There is <a href='https://www.astroisha.com/yogas/157-amala-yoga' title='Amala Yoga'>Amala Yoga</a> in your horoscope");
        }
        else if($merc_dist_moo=="10" || $jup_dist_moo == "10" ||$ven_dist_moo == "10")
        {
            $array          = array("amala_yoga"  => "There is <a href='https://www.astroisha.com/yogas/157-amala-yoga' title='Amala Yoga'>Amala Yoga</a> in your horoscope");
        }
        else
        {
            $array          = array("amala_yoga"  => "none");
        }
        return $array;
    }
}