<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
class AstrologinModelAstroask extends JModelItem
{
    function getData()
    {
        include_once "/home/astroxou/php/Net/GeoIP/GeoIP.php";
        $geoip                  = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoIP/GeoLiteCity.dat");
        //$ip                         = '117.196.1.11';
        //$ip                         = '157.55.39.123';  // ip address
       $ip                       	= $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server
        //$info                       = geoip_country_code_by_name($ip);
        //$country                    = geoip_country_name_by_name($ip);
        
        $location               	= $geoip->lookupLocation($ip);
        $info                   	= $location->countryCode;
        $country                	= $location->countryName;
        $u_id           = '750';
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query1          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.id','a.name','a.username','b.img_name','b.img_new_name',
                                                       'c.city','c.country','c.membership','c.info','c.profile_status','c.max_no_ques','c.phone_or_report')));
        $query          ->from($db->quoteName('#__users','a'));
        $query          ->join('RIGHT', $db->quoteName('#__user_img','b'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('b.user_id') . ')');
        $query          ->join('RIGHT', $db->quoteName('#__user_astrologer','c'). ' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('c.UserId') . ')');
        $query          ->where($db->quoteName('a.id').' = '.$db->quote($u_id));
        $db             ->setQuery($query);
        $db->execute();
        $result         = $db->loadAssoc();
        $service1        = 'long_ans_fees';
        $service2        = 'short_ans_fees';
        
        if($info == "US")
        {
             $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('US').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('US'));

        }
        else if($info == 'IN'||$info=='NP')
        {
            $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('IN').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('IN'));
        }
        else if($info=='UK')
        {
           $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('UK').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('UK'));
        }
        else if($info=='NZ')
        {
             $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('NZ').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('NZ'));
        }
        else if($info=='CA')
        {
           $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('CA').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('CA'));
        }
        else if($info=='SG')
        {
            $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('SG').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('SG'));
        }
        else if($info=='AU')
        {
            $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('AU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('AU'));
        }
        else if($info=='FR'||$info=='DE'||$info=='IE'||$info=='NL'||$info=='CR'||$info=='BE'
                ||$info=='GR'||$info=='IT'||$info=='PT'||$info=='ES'||$info=='MT'||$info=='LV'||$info=='TR')
        {
            $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('EU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('EU'));
        }
        else if($info =='RU')
        {
            $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('RU').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('RU'));
        }
         else
        {
            $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('ROW').' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('ROW'));
        }
        $db                 ->setQuery($query1);
        $result1            = $db->loadAssocList();
        $country            = array("country_full"=>$country);
        $details            = array_merge($result1,$country);
        $full_details       = array_merge($result,$details);
        return $full_details;
    }
public function insertDetails($details)
{
    //print_r($details);exit;
    $app                = JFactory::getApplication();
    $token              = uniqid('token_');
    $name               = ucfirst($details['name']);
    $email              = $details['email'];
    $gender             = ucfirst($details['gender']);
    $dob                = $details['dob'];
    $tob                = explode(":",$details['tob']);
    $fees               = $details['fees'];
    $currency           = $details['currency'];
    $pob                = $details['pob'];
    $expert             = $details['expert'];
    $no_of_ques         = $details['no_of_ques'];
    $ques_type         = $details['ques_type'];
    $pay_mode           = $details['pay_mode'];
    
    $date               = new DateTime($dob);
    $date               ->setTime($tob[0],$tob[1],"00");
    $dob_tob            = strtotime($date->format('Y-m-d H:i:s'));
    $date1              = new DateTime('now');
    $date1              ->setTimezone('Asia/Kolkata');
    $ques_ask_date      = $date1->format('Y-m-d H:i:s');
    $db                 = JFactory::getDbo();  // Get db connection
    $query              = $db->getQuery(true);
    $query              ->select($db->quoteName(array('id')))
                        ->from($db->quoteName('#__users'))
                        ->where($db->quoteName('username').' = '.$db->quote($expert));
    $db                 ->setQuery($query);
    $row                = $db->loadAssoc();
    $expert_id          = $row['id'];   
       //print_r($details);exit;
    //$query1         = $db->getQuery(true);
    $columns        = array('UniqueID','expert_id','no_of_ques','fees','currency','pay_mode','name','email','gender', 'dob_tob', 
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
        $query          ->select($db->quoteName(array('UniqueID','no_of_ques')))
                        ->from('#__question_details')
                        ->where($db->quoteName('email').' = '.$db->quote($email).' AND '.
                                $db->quoteName('UniqueID').' = '.$db->quote($token));
        $db                  ->setQuery($query);
        $details        = $db->loadAssoc();
        $uniqID         = $details['UniqueID'];
        $no_of_ques     = $details['no_of_ques'];       
        $app            ->redirect(JUri::base().'ask-question?uniq_id='.$uniqID.'&no_of_ques='.$no_of_ques.'&expert='.$expert);
    }
    else
    {
        $msg            = "Something went wrong. Please try again.";
        $type           = "error";
        $app            ->redirect(Juri::base().'ask-expert',$msg,$type);
    }
    
}
public function insertQuestions($details)
{
    //print_r($details);exit;
    $app                = JFactory::getApplication();
    $db                 = JFactory::getDbo();  // Get db connection
    $query              = $db->getQuery(true);
    $query1             = $db->getQuery(true);
    $token              = $details['uniq_id'];
    $no_of_ques         = $details['ques_no'];
    for($i=1;$i<=$no_of_ques;$i++)
    {
        ${"select_".$i}                     = $details['select_'.$i];
        ${"ask_".$i}                        = addslashes($details['ask_'.$i]);
        ${"ques_details_".$i}               = addslashes($details['details_'.$i]);
        $query                              = "INSERT INTO jv_question (order_id,ques_topic,ques_ask,ques_details) 
                                                VALUES ('".$token."','".${"select_".$i}."','".${"ask_".$i}."','".${"ques_details_".$i}."')";
        // Set the query using our newly populated query object and execute it
        $db             ->setQuery($query);
        $result          = $db->query();
    }
    if($result)
    {
        $query1              ->select($db->quoteName(array('UniqueID','name','email',
                                    'pay_mode','fees','currency')))
                            ->from($db->quoteName('#__question_details'))
                            ->where($db->quoteName('UniqueID').'='.$db->quote($token));
       $db                  ->setQuery($query1);
       $row                 = $db->loadAssoc();
       //print_r($row);exit;
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
       else if($pay_mode=="phonepe"||$pay_mode=="bhim"||$pay_mode=="cheque"
                ||$pay_mode=="direct"||$pay_mode=="paypalme"||$pay_mode=="directint")
       {
           $query1           ->clear();
           $query1              ->select($db->quoteName(array('a.UniqueID','a.expert_id','a.no_of_ques','a.name','a.email',
                                    'a.gender','a.dob_tob','a.pob','a.pay_mode','a.order_type','a.fees','a.currency','a.paid','c.username')))
                         ->select($db->quoteName('c.name','expertname'))  
                         ->select($db->quoteName('c.email','expertemail'))
                            ->from($db->quoteName('#__question_details','a'))
                            ->join('RIGHT', $db->quoteName('#__users', 'c').' ON ('.$db->quoteName('c.id').' = '.$db->quoteName('a.expert_id').')')
                            ->where($db->quoteName('a.UniqueID').'='.$db->quote($token));
            $db                  ->setQuery($query1);
            $data                = $db->loadObject();
            $this->sendMail($data);
       }
    }
    else
    {
        $msg            = "Something went wrong. Please try again.";
        $type           = "error";
        $app            ->redirect(Juri::base().'ask-expert',$msg,$type);
    }
}
public function getExpert()
{
    
    $jinput             = JFactory::getApplication()->input;
    $expert             = $jinput->get('expert',  'default_value', 'string');
    $db                 = JFactory::getDbo();  // Get db connection
    $query              = $db->getQuery(true);
    $query2              = $db->getQuery(true);
    $query              ->select($db->quoteName(array('id')))
                        ->from($db->quoteName('#__users'))
                        ->where($db->quoteName('username').' = '.$db->quote($expert));
    $db                     ->setQuery($query);
    $id                     = $db->loadResult();
    $query                  ->clear();
    $query              ->clear();
    $query                  =   "SELECT DISTINCT(main_expert) from jv_role_astro where astro_id ='".$id."'";
    $db                     ->setQuery($query);
    $main                    = $db->loadColumn();     
    $main_exp               = array();
    foreach($main as $mainexp)
    {
        $query2                 ->select($db->quoteName(array('role_id','role_name','role_super')))
                                ->from($db->quoteName('#__role'))
                                ->where($db->quoteName('role_id') . ' = '. $db->quote($mainexp));
        $db                     ->setQuery($query2);
        $row                    = $db->loadObjectList();
        $main_exp               = array_merge($main_exp,$row);
        $query2                 ->clear();

    }
    $query2                     ->select($db->quoteName('sub_expert'))
                                ->from($db->quoteName('#__role_astro'))
                                ->where($db->quoteName('astro_id').' = '.$db->quote($id));
    $db                         ->setQuery($query2);
    $sub                        = $db->loadColumn();
    $sub_exp                    = array();
    foreach($sub as $subexp)
    {
        $query2                 ->clear();
        $query2                  ->select($db->quoteName(array('role_id','role_name','role_super')))
                                ->from($db->quoteName('#__role'))
                                ->where($db->quoteName('role_id') . ' = '. $db->quote($subexp));
        $db                     ->setQuery($query2);
        $row                    = $db->loadObjectList();
        $sub_exp               = array_merge($sub_exp,$row);

    }
    $exp                      = array_merge($main_exp, $sub_exp);
    return $exp;
    
}
// paypal authorize Order
public function authorizePayment($details)
{
    $paypal_id              = $details['paypal_id'];
    $auth_id                = $details['auth_id'];
    $token                  = $details['token'];
    $data                   = array();
    $db                     = JFactory::getDbo();
    $query                  = $db->getQuery(true);
    // Fields to update.
    $object                 = new stdClass();
    $object->paid           = "yes";
    $object->UniqueId       = $token;
    // Update their details in the users table using id as the primary key.
    $result = JFactory::getDbo()->updateObject('#__question_details', $object, 'UniqueId');
    
    $columns        = array('paypal_id','authorize_id','status','UniqueID');
    // Conditions for which records should be updated.
    $values         = array($db->quote($paypal_id),$db->quote($auth_id),$db->quote('Authorized'),$db->quote($token));
    
    $query              ->insert($db->quoteName('#__paypal_info'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
    // Set the query using our newly populated query object and execute it
    $db                 ->setQuery($query);
    $result             = $db->query();
 
    $query              ->clear();
    $query              ->select($db->quoteName(array('a.UniqueID','a.expert_id','a.no_of_ques','a.name','a.email',
                                    'a.gender','a.dob_tob','a.pob','a.pay_mode','a.order_type','a.fees','a.currency','a.paid','b.paypal_id','b.status','c.username')))
                         ->select($db->quoteName('c.name','expertname'))  
                         ->select($db->quoteName('c.email','expertemail'))
                            ->from($db->quoteName('#__question_details','a'))
                            ->join('INNER', $db->quoteName('#__paypal_info', 'b') . ' ON (' . $db->quoteName('a.UniqueID').' = '.$db->quoteName('b.UniqueID') . ')')
                            ->join('RIGHT', $db->quoteName('#__users', 'c').' ON ('.$db->quoteName('c.id').' = '.$db->quoteName('a.expert_id').')')
                            ->where($db->quoteName('b.paypal_id').'='.$db->quote($paypal_id),' AND '.
                                    $db->quoteName('a.UniqueID').' = '.$db->quote($token));
       $db                  ->setQuery($query);
       $data                = $db->loadObject();
       //print_r($data);exit;
       $this->sendMail($data);
}
public function failPayment($details)
{
    //print_r($details);exit;
    $token          = $details['token'];
    $db         = JFactory::getDbo();
    $query      = $db->getQuery(true);
    $query              ->select($db->quoteName(array('a.UniqueID','a.expert_id','a.no_of_ques','a.name','a.email',
                                    'a.gender','a.dob_tob','a.pob','a.pay_mode','a.order_type','a.fees','a.currency','a.paid','c.username')))
                         ->select($db->quoteName('c.name','expertname'))  
                         ->select($db->quoteName('c.email','expertemail'))
                            ->from($db->quoteName('#__question_details','a'))
                            ->join('RIGHT', $db->quoteName('#__users', 'c').' ON ('.$db->quoteName('c.id').' = '.$db->quoteName('a.expert_id').')')
                            ->where($db->quoteName('a.UniqueID').'='.$db->quote($token));
       $db                  ->setQuery($query);
       $data                = $db->loadObject();
    $this->sendMail($data);
}
public function confirmCCPayment($details)
{
    //print_r($details);exit;
    $token              = $details['token'];
    $trackid            = $details['trackid'];
    $bankref            = $details['bankref'];
    $status             = $details['status'];
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    if($status      == 'Success'||$status =='TXN_SUCCESS')
    {
    // Fields to update.
        $object                 = new stdClass();
        $object->paid           = "yes";
        $object->UniqueId       = $token;

        // Update their details in the users table using id as the primary key.
        $result                 = JFactory::getDbo()->updateObject('#__question_details', $object, 'UniqueId');
    }
    if($status == 'TXN_SUCCESS')
    {
        $status = "Success";
    }
    else if($status == 'TXN_FAILURE')
    {
        $status     = "Failure";
    }
    $columns                = array('pay_token','track_id','bank_ref','pay_status');
    // Conditions for which records should be updated.
    $values                 = array($db->quote($token),$db->quote($trackid),$db->quote($bankref),$db->quote($status));
    
    $query              ->insert($db->quoteName('#__ccavenue_paytm'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));  
    $db                 ->setQuery($query);
    $result             = $db->query();
    
    $query              ->clear();
    $query                  ->select($db->quoteName(array('a.UniqueID','a.expert_id','a.no_of_ques','a.name','a.email',
                                    'a.gender','a.dob_tob','a.pob','a.pay_mode','a.order_type','a.fees','a.currency','a.paid','b.track_id',
                                    'b.bank_ref','b.pay_status','c.username')))
                            ->select($db->quoteName('c.name','expertname'))  
                            ->select($db->quoteName('c.email','expertemail'))
                            ->from($db->quoteName('#__question_details','a'))
                            ->join('INNER', $db->quoteName('#__ccavenue_paytm', 'b') . ' ON (' . $db->quoteName('a.UniqueID').' = '.$db->quoteName('b.pay_token') . ')')
                            ->join('RIGHT', $db->quoteName('#__users', 'c').' ON ('.$db->quoteName('c.id').' = '.$db->quoteName('a.expert_id').')')
                            ->where($db->quoteName('a.UniqueID').' = '.$db->quote($token));
    $db                     ->setQuery($query);
    $data                   = $db->loadObject();
    //print_r($data);exit;
    $this->sendMail($data);
}
function sendMail($data)
{
    //print_r($data);exit;
    $date       = new DateTime();
    $date       ->setTimestamp($data->dob_tob);
    $dob        = $date->format('d-m-Y');
    $tob        = $date->format('h:i:s a');
    //echo $tob;exit;
    $mailer     = JFactory::getMailer();
    $config     = JFactory::getConfig();
    $app        = JFactory::getApplication(); 
    $body       = "";
    $sender     = array(
                    $config->get('mailfrom'),
                    $config->get('fromname')
                        );

    $mailer     ->setSender($sender);
    $recepient  = array($data->email);
    $mailer     ->addRecipient($recepient);
    $mailer     ->addBcc('kopnite@gmail.com');
    $mailer 	->addBcc('consult@astroisha.com');
    $subject    = "AstroIsha Order: ".$data->UniqueID;
    $mailer     ->setSubject($subject);

	$body       .= "<p>Dear ".$data->name.",</p>";
	if($data->paid=="no")
	{
		$body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Online Payment to AstroIsha(https://www.astroisha.com) has failed. Kindly retry again if you wish your an answer to your questions. If you have Cancelled the Order then kindly ignore this email.</p>";
	}
	else if($data->paid =="yes")
	{
		$body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Online Payment to AstroIsha(https://www.astroisha.com) is successful. The answers to your questions would be resolved and mailed to you in ten working days.</p><br/>"; 
	}
	else
	{
		$body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Online Payment to AstroIsha(https://www.astroisha.com) has failed. Kindly retry again if you wish your an answer to your questions. If you have Cancelled the Order then kindly ignore this email.</p>";
	}
    $body           .= "<p><strong>Details Of Your Order Are As Below: </strong></p>";
    $body           .= "<p>Order ID: ".$data->UniqueID."</p>";
    
    if($data->order_type == "short_ans")
    {
		$body 			.= "<p>Answer Type: Short Answer</p>";
	}
	else
	{
		$body 			.= "<p>Answer Type: Detailed Report</p>";
	}
    $body           .= "<p>Number Of Questions: ".$data->no_of_ques."</p>";
    $order_link           = "https://www.astroisha.com/getanswer?order=".$data->UniqueID."&ref=".$data->email;
    $body               .= "<p>Once your report is finished you would be notified via email. You can view your report here: <a href='".$order_link."' title='Click to get report'>Click For Report</a></p><br/>";
    $body           .= "<p><strong>Below Are Your Personal Details: </strong></p>";
    $body           .= "<p>Name: ".$data->name."</p>";
    $body           .= "<p>Email: ".$data->email."</p>";
    $body           .= "<p>Gender: ".$data->gender."</p>";
    $body           .= "<p>Date Of Birth: ".$dob."</p>";
    $body           .= "<p>Time Of Birth: ".$tob."</p>";
    $body           .= "<p>Place Of Birth: ".$data->pob."</p><br/>";
    $body           .= "<p><strong>Below Are The Payment Details:</strong></p>";
    $body           .= "<p>Fees: ".$data->fees."&nbsp;".$data->currency."</p>";
    $body           .= "<p>Payment Via: ".$data->pay_mode."</p>";
    
    if(($data->pay_mode=="paytm"||$data->pay_mode=="ccavenue"||$data->pay_mode=="paypal")&&$data->paid=="no")
    {
        $body       .= "<p>Payment Status: </strong>Failed</p>";

    }
    else if(($data->pay_mode=="paytm"||$data->pay_mode=="ccavenue")&&$data->paid=="yes")
    {
        $body       .= "<p>Payment Status: Success</p>";
        $body       .= "<p>Payment Id: ".$data->track_id."</p>";
        $body       .= "<p>Bank Reference Id: ".$data->bank_ref."</p>";
        $body       .= "<br/><p><strong>Please keep this email as reference. Alternatively you can also print this email for future reference.</strong></p>";
        $body       .= "<p><strong>In case the order is not completed in ten working days you would be refunded full amount back into your bank account.</strong></p><br/>";
    }
    else if($data->pay_mode=="paypal"&&$data->paid=="yes")
    {
        $body       .= "<p>Payment Status: Success</p>";
        $body       .= "<p>Payment Id: ".$data->paypal_id."</p>";
        $body       .= "<p>Payment Status: ".$data->status."</p>";
        $body       .= "<br/><p><strong>Please keep this email as reference. Alternatively you can also print this email for future reference.</strong></p>";
        $body       .= "<p><strong>In case the order is not completed in ten working days you would be refunded full amount back into your bank account.</strong></p><br/>";
    }
    else
    {
        $body       .= "<p>Payable To: Astro Isha</p>";
        $body       .= "<p>Account Number: 915020051554614</p>";
        $body       .= "<p>Bank Name: Axis Bank</p>";
        $body       .= "<p>IFSC Code: UTIB0000080</p>";
        $body       .= "<p>Swift Code: AXISINBB080</p>";
    }
    
    $body           .= "<p>Admin At Astro Isha,<br/>Rohan Desai</p>";
    $mailer->isHtml(true);
    $mailer->Encoding = 'base64';
    $mailer->setBody($body);
    
    $send = $mailer->Send();
    $link       = JUri::base().'getanswer?order='.$data->UniqueID.'&ref='.$data->email;
    if ( $send !== true ) {
        $msg    = 'Error sending email: Try again and if problem continues contact admin@astroisha.com.';
        $msgType = "error";
        $app->redirect($link, $msg,$msgType);
    } 
    else 
    {
        if(($data->pay_mode=="paytm"||$data->pay_mode=="ccavenue")&&$data->paid=="yes")
        {
            $msg    =  'Payment to Astro Isha is successful. Please check your email to see payment details.';
            $msgType    = "success";
            $app->redirect($link, $msg,$msgType);
        }
        else if(($data->pay_mode=="paytm"||$data->pay_mode=="ccavenue")&&$data->paid=="no")
        {
            $msg    =  'Payment to Astro Isha has failed. Kindly check your email for details.';
            $msgType    = "error";
            $app->redirect($link, $msg,$msgType);
        }
        
        else if($data->pay_mode=="paypal"&&$data->paid=="no")
        {
            $msg    =  'Payment via Paypal has failed. Kindly check your email for details.';
            $msgType    = "error";
            $app->redirect($link, $msg,$msgType);
        }
        else if($data->pay_mode=="paypal"&&$data->paid=="yes")
        {
            $msg    =  'Payment via Paypal is successfull. Please check your email to see payment details.';
            $msgType    = "success";
            $app->redirect($link, $msg,$msgType);
        }
        else
        {
            $msg    =  'Please check your email for more information about payment.';
            $msgType    = "success";
            $app->redirect($link, $msg,$msgType);
        }
    }        
}
    
}
?>
