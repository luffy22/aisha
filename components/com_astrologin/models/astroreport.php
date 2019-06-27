<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
class AstrologinModelAstroReport extends JModelItem
{
    public function getData()
    {
        //include_once "/home/astroxou/php/Net/GeoIP/GeoIP.php";
        //$geoip                          = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoIP/GeoLiteCity.dat");
        $ip                           = '117.196.1.11';
        //$ip                             = '157.55.39.123';  // ip address
        //$ip                       	= $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server
        $info                         = geoip_country_code_by_name($ip);
        $country                      = geoip_country_name_by_name($ip);
        
        //$location               	= $geoip->lookupLocation($ip);
        //$info                   	= $location->countryCode;
        //$country                	= $location->countryName;
        $u_id           = '222';
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.id','a.name','a.username','b.img_name','b.img_new_name',
                                                       'c.city','c.country','c.membership','c.info','c.profile_status','c.max_no_ques','c.phone_or_report')));
        $query          ->from($db->quoteName('#__users','a'));
        $query          ->join('RIGHT', $db->quoteName('#__user_img','b'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('b.user_id') . ')');
        $query          ->join('RIGHT', $db->quoteName('#__user_astrologer','c'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('c.UserId') . ')');
        $query          ->where($db->quoteName('a.id').' = '.$db->quote($u_id));
        $db             ->setQuery($query);
        $db->execute();
        $result         = $db->loadAssoc();
        $result1        = $this->getCurrencyDetails($info, $u_id);
        //print_r($result1);exit;        
        $country            = array("country_full"=>$country);
        $details            = array_merge($result1,$country);
        $full_details       = array_merge($result,$details);
        return $full_details;
    }
    public function getCurrencyDetails($info, $u_id)
    {
        $service1       = 'yearly';
        $service2       = 'life';
        $service3       = 'career';
        $service4       = 'marriage';
        if($info=='FR'||$info=='DE'||$info=='IE'||$info=='NL'||$info=='CR'||$info=='BE'
                ||$info=='GR'||$info=='IT'||$info=='PT'||$info=='ES'||$info=='MT'||$info=='LV'||$info=='TR')
        {
            $info       = "EU";
        }
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($info).' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($info).' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($info).' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($info));
        $db                 ->setQuery($query);
        $result             = $db->loadAssocList();
        return $result;
    }
    public function insertDetails($details)
    {
              //print_r($details);exit;
        $app                = JFactory::getApplication();
        $token              = uniqid('report_');
        $name               = ucfirst($details['name']);
        $email              = $details['email'];
        $gender             = ucfirst($details['gender']);
        $dob                = $details['dob'];
        $tob                = explode(":",$details['tob']);
        $pob                = $details['pob'];
        $ques_type          = $details['type'];
        $fees               = $details['fees'];
        $currency           = $details['currency'];
        $pay_mode           = $details['pay_mode'];
        $expert_id          = '222';
        $no_of_ques         = '0';
        
        $date               = new DateTime($dob);
        $date               ->setTime($tob[0],$tob[1],"00");
        $dob_tob            = strtotime($date->format('Y-m-d H:i:s'));
        $date1              = new DateTime('now');
        $date1              ->setTimezone('Asia/Kolkata');
        $ques_ask_date      = $date1->format('Y-m-d H:i:s');
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $columns            = array('UniqueID','expert_id','no_of_ques','fees','currency','pay_mode','name','email','gender', 'dob_tob', 
                                    'pob','order_type','ques_ask_date'
                            );
        $values         = array(
                                $db->quote($token),$db->quote($expert_id),$db->quote($no_of_ques),
                                $db->quote($fees),$db->quote($currency),$db->quote($pay_mode),
                                $db->quote($name), $db->quote($email),$db->quote($gender), 
                                $db->quote($dob_tob),$db->quote($pob),$db->quote($ques_type),$db->quote($ques_ask_date)
                                );
        // Prepare the insert query
        $query          ->insert($db->quoteName('#__question_details'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
        $db             ->setQuery($query);
        $result          = $db->query();
        if($result)
        {
            $query          ->clear();
            $query          ->select($db->quoteName(array('UniqueID','order_type')))
                            ->from('#__question_details')
                            ->where($db->quoteName('email').' = '.$db->quote($email).' AND '.
                                    $db->quoteName('UniqueID').' = '.$db->quote($token));
            $db                  ->setQuery($query);
            $details        = $db->loadAssoc();
            $uniqID         = $details['UniqueID'];
            $order_type     = $details['order_type'];       
            $app            ->redirect(JUri::base().'get-report?uniq_id='.$uniqID.'&order_type='.$order_type);
        }
        else
        {
            $msg            = "Something went wrong. Please try again.";
            $type           = "error";
            $app            ->redirect(Juri::base().'get-report',$msg,$type);
        }
    }
    public function insertDetails2($details)
    {
        //print_r($details);exit;
        $order_id           = $details['order_id'];
        $order_type         = $details['order_type'];
        $query_about        = $details['query_about'];
        $query_explain      = $details['details_explain'];
        $app                = JFactory::getApplication();
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $columns            = array('order_id','order_type','query_about','query_explain'
                            );
        $values             = array(
                                    $db->quote($order_id),$db->quote($order_type),$db->quote($query_about),
                                    $db->quote($query_explain)
                                );
        // Prepare the insert query
        $query          ->insert($db->quoteName('#__order_reports'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
        $db             ->setQuery($query);
        $result          = $db->query();
        if($result)
        {
            $query              ->clear();
            $query              ->select($db->quoteName(array('UniqueID','name','email',
                                        'pay_mode','fees','currency')))
                                ->from($db->quoteName('#__question_details'))
                                ->where($db->quoteName('UniqueID').'='.$db->quote($order_id));
           $db                  ->setQuery($query);
           $row                 = $db->loadAssoc();
           print_r($row);exit;
           $token               = $row['UniqueID'];
           $name                = str_replace(" ","_",$row['name']);
           $email               = $row['email'];
           $currency            = $row['currency'];
           $fees                = $row['fees'];
           $pay_mode            = $row['pay_mode'];
           //echo $pay_mode;exit;
           if($pay_mode == "ccavenue")
           {
                $app->redirect(JUri::base().'ccavenue/nonseam/ccavenue_payment.php?token='.$token.'&name='.$name.'&email='.$email.'&curr='.$currency.'&fees='.$fees);
           }
           else if($pay_mode == "paytm")
           {
                $app->redirect(JUri::base().'PaytmKit/TxnTest.php?token='.$token.'&email='.$email.'&fees='.$fees); 
           }
           else if($pay_mode=="paypal")
           {
               $app->redirect(JUri::base().'vendor/paypal.php?token='.$token.'&name='.$name.'&email='.$email.'&curr='.$currency.'&fees='.$fees); 
           }
        }
    }
}