<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('mangaldosha', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelSavings extends HoroscopeModelLagna
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
            if(strpos($pob, "India") == "true"||strpos($pob,"india") == true)
            {
                $tmz     = "Asia/Kolkata";
            }
            else
            {
                $date           = new DateTime($dob." ".$tob);
                $timestamp      = $date->format('U');
                $tmz            = $this->getTimeZone($lat, $lon, "rohdes");
                if($tmz == "error")
                {
                    $tmz        = "UTC";        // if timezone not available use UTC(Universal Time Cooridnated)
                }
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
                                $db->quote($pob),$db->quote($lon),$db->quote($lat),$db->quote($tmz),$db->quote($now),$db->quote('savings'));
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
            $link       = JURI::base().'investwhere?chart='.str_replace("horo","chart",$uniq_id);
            $app        ->redirect($link);
        }
    }
    public function getData()
    {
        $libPath        = JPATH_BASE.'/sweph/';
        $iinput         = JFactory::getApplication()->input;
        $chart_id       = $iinput->get('chart', 'default_value', 'filter');
        $chart_id       = str_replace("chart","horo", $chart_id);
        $array          = array();
        $user_data      = $this->getUserData($chart_id);
        
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
 
        exec ("swetest -edir$libPath -b$date -ut$time -sid1 -eswe -fPls -p0142536m -g, -head", $output);
        //print_r($output);exit;

        # OUTPUT ARRAY
        # Planet Name, Planet Degree, Planet Speed per day
        $asc                        = $this->getAscendant($user_data);
        $planets                    = $this->getPlanets($output);
        $planets                    = array_merge($asc,$planets);
        $asc_sign                   = $this->calcDetails($planets['Ascendant']);

        //$check_bank                 = $this->checkBanks($asc_sign, $planets);
        $check_land                 = $this->checkProperty($asc_sign, $planets);
        $check_stock                = $this->checkStocks($asc_sign, $planets);
        
        $data                       = array();
        foreach($planets as $key => $planet)
        {
            $planet_sign            = $this->calcDetails($planet);
            $array                  = array($key => $planet_sign);
            $data                   = array_merge($data, $array);
        }
        print_r($planets);exit;
    }
    protected function removeRetro($planet)
    {
        // This functions removes :r at end of planet for example 29.17:r which suggests
        // planet is retrograde.
        $planet         = str_replace(":r","",$planet);
        return $planet;
    }
    protected function checkElement($sign)
    {
        $water          = array("Pisces","Cancer", "Scorpio");
        $air            = array("Libra","Aquarius","Gemini");
        $earth          = array("Taurus","Virgo","Capricorn");
        $fire           = array("Aries","Leo","Sagittarius");
        
        if(in_array($sign, $water))
        {
            return "water";
        }
        if(in_array($sign, $air))
        {
            return "wind";
        }
        if(in_array($sign, $earth))
        {
            return "earth";
        }
        if(in_array($sign, $fire))
        {
            return "fire";
        }
    }

    protected function checkBanks($asc, $data)
    {
        $sign                       = $this->getHouseSign($asc, "2");
        $element                    = $this->checkElement($sign);
        $planets                    = $this->checkPlanetsInHouse($data, "2");
        $aspects                    = $this->checkAspectsOnHouse($data, "2");
        $planets                    = $planets['house_2'];
        $aspects                    = $aspects['aspect_2'];
        $pl_count                   = count($planets); // count number of planets
        $asp_count                  = count($aspects); // count number of aspects
        $total                      = $pl_count+$asp_count;
        $i                          = 0;
        foreach($planets as $planet)
        {
            if((in_array("Jupiter", $planets) || in_array("Venus", $planets) || 
                in_array("Moon", $planets)) && $element == "water")
            {
                $i                  = $i + 4;
            }
            else if((in_array("Jupiter", $planets) || in_array("Venus", $planets) || 
                in_array("Moon", $planets)) && $element == "earth")
            {
                $i                  = $i + 3;
            }
            else if((in_array("Jupiter", $planets) || in_array("Venus", $planets) || 
                in_array("Moon", $planets)) && $element == "wind")
            {
                $i                  = $i + 2;
            }
            else if((in_array("Jupiter", $planets) || in_array("Venus", $planets) || 
                in_array("Moon", $planets)) && $element == "fire")
            {
                $i                  = $i + 1;
            }
            else if((in_array("Rahu", $planets) || in_array("Saturn", $planets) || 
                in_array("Mercury", $planets)) && $element == "water")
            {
                $i                  = $i + 3;
            }
            else if((in_array("Rahu", $planets) || in_array("Saturn", $planets) || 
                in_array("Mercury", $planets)) && $element == "earth")
            {
               $i                   = $i + 2;
            }
            else if((in_array("Rahu", $planets) || in_array("Saturn", $planets) || 
                in_array("Mercury", $planets)) && $element == "wind")
            {
               $i                   = $i + 1;
            }
            else if((in_array("Rahu", $planets) || in_array("Saturn", $planets) || 
                in_array("Mercury", $planets)) && $element == "fire")
            {
                $i                  = $i + 0;
            }
            else if((in_array("Mars", $planets) || in_array("Ketu", $planets) || 
                in_array("Sun", $planets)) && $element == "water")
            {
               $i                   = $i + 2;
            }
            else if((in_array("Mars", $planets) || in_array("Ketu", $planets) || 
                in_array("Sun", $planets)) && $element == "earth")
            {
                $i                  = $i + 1;
            }
            else if((in_array("Mars", $planets) || in_array("Ketu", $planets) || 
                in_array("Sun", $planets)) && $element == "wind")
            {
                $i                  = $i + 0;
            }
            else if((in_array("Mars", $planets) || in_array("Ketu", $planets) || 
                in_array("Sun", $planets)) && $element == "fire")
            {
                $i                  = $i + 0;
            }
            else
            {
                $i                  = $i + 0;
            }
        }
        foreach($aspects as $aspect)
        {
            if((in_array("Jupiter", $aspects) || in_array("Venus", $aspects) || 
                in_array("Moon", $aspects)) && $element == "water")
            {
               $i                   = $i + 4;
            }
            else if((in_array("Jupiter", $aspects) || in_array("Venus", $aspects) || 
                in_array("Moon", $aspects)) && $element == "earth")
            {
                $i                  = $i + 3;
            }
            else if((in_array("Jupiter", $aspects) || in_array("Venus", $aspects) || 
                in_array("Moon", $aspects)) && $element == "wind")
            {
                $i                  = $i + 2;
            }
            else if((in_array("Jupiter", $aspects) || in_array("Venus", $aspects) || 
                in_array("Moon", $aspects)) && $element == "fire")
            {
                $i                  = $i + 1;
            }
            else if((in_array("Rahu", $aspects) || in_array("Saturn", $aspects) || 
                in_array("Mercury", $aspects)) && $element == "water")
            {
                $i                  = $i + 3;
            }
            else if((in_array("Rahu", $aspects) || in_array("Saturn", $aspects) || 
                in_array("Mercury", $aspects)) && $element == "earth")
            {
                $i                  = $i + 2;
            }
            else if((in_array("Rahu", $aspects) || in_array("Saturn", $aspects) || 
                in_array("Mercury", $aspects)) && $element == "wind")
            {
                $i                  = $i + 1;
                
            }
            else if((in_array("Rahu", $aspects) || in_array("Saturn", $aspects) || 
                in_array("Mercury", $aspects)) && $element == "fire")
            {
                $i                  = $i + 0;
            }
            else if((in_array("Mars", $aspects) || in_array("Ketu", $aspects) || 
                in_array("Sun", $aspects)) && $element == "water")
            {
                $i                  = $i + 2;
            }
            else if((in_array("Mars", $aspects) || in_array("Ketu", $aspects) || 
                in_array("Sun", $aspects)) && $element == "earth")
            {
               $i                   = $i + 1;
            }
            else if((in_array("Mars", $aspects) || in_array("Ketu", $aspects) || 
                in_array("Sun", $aspects)) && $element == "wind")
            {
                $i                  = $i + 0;
            }
            else if((in_array("Mars", $aspects) || in_array("Ketu", $aspects) || 
                in_array("Sun", $aspects)) && $element == "fire")
            {
                $i                  = $i + 0;
            }
        }
    
        $array                       = array("bank_invest" => $i, "bank_pl_asp"=> $total);
        //print_r($array);exit;
    }
    protected function checkProperty($asc, $data)
    {
        $sign                       = $this->getHouseSign($asc, "4");
        $planets                    = $this->checkPlanetsInHouse($data, "4");
        $aspects                    = $this->checkAspectsOnHouse($data, "4");
        $planets                    = $planets['house_4'];
        $aspects                    = $aspects['aspect_4'];
        $pl_count                   = count($planets); // count number of planets
        $asp_count                  = count($aspects); // count number of aspects
        $total                      = $pl_count+$asp_count;
        $i                          = 0;$j  = 0; $k = 0;
        $deb_sign                   = array("Sun"=>"Libra","Moon"=>"Scorpio","Mars"=>"Cancer",
                                            "Mercury"=>"Pisces","Jupiter"=>"Capricorn",
                                            "Venus"=>"Virgo","Saturn"=>"Aries");
        $exal_sign                  = array("Saturn"=>"Libra","Jupiter"=>"Cancer","Moon"=>"Taurus",
                                            "Venus"=>"Pisces","Mars"=>"Capricorn","Mercury"=>"Virgo","Sun"=>"Aries");
        $own_sign                   = array("Aries"=>"Mars", "Taurus"=>"Venus","Gemini"=>"Mercury",
                                            "Cancer"=>"Moon","Leo"=>"Sun","Virgo"=>"Mercury",
                                            "Libra"=>"Venus","Scorpio"=>"Mars","Sagittarius"=>"Jupiter",
                                            "Capricorn"=>"Saturn","Aquarius"=>"Saturn","Pisces"=>"Jupiter");
        foreach($planets as $planet)
        {
            if($planet == "Jupiter" && ($sign == "Pisces" || $sign == "Cancer" ||
                    $sign == "Scorpio"))
            {
                $i                  = $i + 4;
                $j                  = $j + 1;
            }
            else if($planet == "Jupiter" && ($sign == "Capricorn" || $sign == "Taurus" ||
                    $sign == "Virgo"))
            {
                $i                  = $i + 3;
                $j                  = $j + 1;
            }
           else if($planet == "Jupiter" && ($sign == "Libra" || $sign == "Gemini" ||
                    $sign == "Aquarius"))
            {
                $i                  = $i + 2;
                $j                  = $j + 1;
            }
            else if($planet == "Jupiter" && ($sign == "Aries" || $sign == "Leo" ||
                    $sign == "Sagittarius"))
            {
                $i                  = $i + 2;
                $j                  = $j + 1;
            }
            else if($planet == "Venus" && ($sign == "Pisces" || $sign == "Libra" ||
                    $sign == "Taurus" || $sign == "Cancer"))
            {
                $i                  = $i + 4;
                $j                  = $j + 1;
            }
            else if($planet == "Venus" && ($sign == "Scorpio" ||
                    $sign == "Virgo"||$sign == "Capricorn"||$sign=="Gemini"
                    ||$sign=="Aquarius"))
            {
                $i                  = $i + 3;
                $j                  = $j + 1;
            }
            else if($planet == "Venus" && ($sign == "Aries" || $sign == "Leo" ||
                    $sign == "Sagittarius"))
            {
                $i                  = $i + 2;
                $j                  = $j + 1;
            }
            
        }
        echo $i." ".$j." ".$k;exit;
         
        $array                       = array("land_invest" => $total_strength, "land_pl_asp"=> $total);
        
    }
    protected function checkStocks($asc, $data)
    {
         $sign                       = $this->getHouseSign($asc, "5");
        $element                    = $this->checkElement($sign);
        $planets                    = $this->checkPlanetsInHouse($data, "5");
        $aspects                    = $this->checkAspectsOnHouse($data, "5");
        $planets                    = $planets['house_5'];
        $aspects                    = $aspects['aspect_5'];
        $pl_count                   = count($planets); // count number of planets
        $asp_count                  = count($aspects); // count number of aspects
        $total                      = $pl_count+$asp_count;
        $pl_count                   = count($planets); // count number of planets
        $asp_count                  = count($aspects); // count number of aspects
        $total                      = $pl_count+$asp_count;
        $pl_strength                = $this->checkPlacements($planet, $element);
        $asp_strength               = $this->checkAspects($aspects, $element);
        $total_strength             = $pl_strength+$asp_strength;        
        $array                       = array("stock_invest" => $total_strength, "stock_pl_asp"=> $total);
        print_r($array);exit;
    }
}