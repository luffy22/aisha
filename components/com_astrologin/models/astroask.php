<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
use Joomla\CMS\MVC\Model\ListModel;
class AstrologinModelAstroask extends ListModel
{
    function getData()
    {
        include_once "/home/astroxou/php/Net/GeoIP/GeoIP.php";
        $geoip                          = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoIP/GeoLiteCity.dat");
        //$ip                           = '117.196.1.11';
        //$ip                             = '140.120.6.207';
        //$ip                             = '157.55.39.123';  // ip address
        //$ip 							= '1.10.128.129';  // thai address
        //	$ip 							= '175.157.193.156'; // srilanka ip address
        $ip                       		= $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server
        //$info                         = geoip_country_code_by_name($ip);
        //$country                      = geoip_country_name_by_name($ip);
        
        $location               	= $geoip->lookupLocation($ip);
        $info                   	= $location->countryCode;
        $country                	= $location->countryName;
        $u_id           = '222';
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
        $service1       = 'long';
        $service2       = 'short';
        $result1        = $this->getCurrencyDetails($info, $u_id);
        
        $country            = array("country_full"=>$country);
        $details            = array_merge($result1,$country);
        $full_details       = array_merge($result,$details);
        return $full_details;
    }
    public function getCurrencyDetails($info, $u_id)
    {
        $service1           = 'long';
        $service2           = 'short';
        $country_code       = array("IN","US","UK","NZ","AU","SG","CA","RU","TH");
        if($info=='FR'||$info=='DE'||$info=='IE'||$info=='NL'||$info=='CR'||$info=='BE'
                ||$info=='GR'||$info=='IT'||$info=='PT'||$info=='ES'||$info=='MT'||$info=='LV'||$info=='TR')
        {
            $info       = "EU";
        }
        else if($info=="IN"||$info=="NP"||$info=="LK")
        {
            $info       = "IN";
        }
        else if(!in_array($info, $country_code))
        {
            $info       = "ROW";
        }

        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.country','a.amount','a.disc_percent','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service1).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($info).' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service2).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($info));
        $db                 ->setQuery($query);
        $result             = $db->loadAssocList();
        return $result;
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
        //echo $pay_mode;exit;
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
        $query->clear();
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

        if($result = $db->execute())
        {
            if($ques_type == "long_ans")
            {
                $query1          = "INSERT INTO jv_question_summary(order_id) 
                                   VALUES ('".$token."')";
                // Set the query using our newly populated query object and execute it
                $db             ->setQuery($query1);
                $result          = $db->execute();
            }
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
        //echo $no_of_ques;exit;
        for($i=1;$i<=$no_of_ques;$i++)
        {
            ${"select_".$i}                     = $details['select_'.$i];
            ${"ask_".$i}                        = addslashes($details['ask_'.$i]);
            ${"ques_details_".$i}               = addslashes($details['details_'.$i]);
            $query                              = "INSERT INTO jv_question (order_id,ques_topic,ques_ask,ques_details) 
                                                    VALUES ('".$token."','".${"select_".$i}."','".${"ask_".$i}."','".${"ques_details_".$i}."')";
            // Set the query using our newly populated query object and execute it
            $db                                 ->setQuery($query);
            $result                             = $db->execute();
        }

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
		//echo $pay_mode;exit;
		if($pay_mode == "razorpay")
		{
			$app->redirect(JUri::base().'razorpay/question.php?token='.$token.'&name='.$name.'&email='.$email.'&curr='.$currency.'&fees='.$fees);
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
		//print_r($details);exit;
        $paypal_id              = $details['paypal_id'];
        $auth_id                = $details['auth_id'];
        $token                  = $details['token'];
        $data                   = array();
        $db                     = JFactory::getDbo();
        $query                  = $db->getQuery(true);
        // Fields to update.
		$fields = array($db->quoteName('paid') . ' = ' . $db->quote('yes'));

		// Conditions for which records should be updated.
		$conditions = array(
						$db->quoteName('UniqueID') . ' = '. $db->quote($token)
						);

		$query->update($db->quoteName('#__question_details'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$result = $db->execute();
		$query 	->clear();
        $columns        = array('paypal_id','authorize_id','status','UniqueID');
        // Conditions for which records should be updated.
        $values         = array($db->quote($paypal_id),$db->quote($auth_id),$db->quote('Authorized'),$db->quote($token));

        $query              ->insert($db->quoteName('#__paypal_info'))
                            ->columns($db->quoteName($columns))
                            ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
        $db                 ->setQuery($query);
        $result             = $db->execute();

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
        $token      = $details['token'];
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
        $this->sendFailMail($data);
    }
    public function confirmCCPayment($details)
    {
        //print_r($details);exit;
        $token              = $details['token'];
        $trackid            = $details['trackid'];
        $status             = $details['status'];
        if(empty($bank_ref))
        {
			$bank_ref 		= NULL;
		}
		else
		{
			$bank_ref			= $details['bank_ref'];
		}
        $db                     = JFactory::getDbo();
        $query                  = $db->getQuery(true);
        // Fields to update.
		$fields = array($db->quoteName('paid') . ' = ' . $db->quote('yes'));

		// Conditions for which records should be updated.
		$conditions = array(
						$db->quoteName('UniqueID') . ' = '. $db->quote($token)
						);

		$query->update($db->quoteName('#__question_details'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$result = $db->execute();
		$query 	->clear();
        $columns                = array('pay_token','track_id','bank_ref','pay_status');
        // Conditions for which records should be updated.
        $values                 = array($db->quote($token),$db->quote($trackid),
										$db->quote($bank_ref),$db->quote($status));

        $query              ->insert($db->quoteName('#__ccavenue_paytm'))
                            ->columns($db->quoteName($columns))
                            ->values(implode(',', $values));  
        $db                 ->setQuery($query);
        $result             = $db->execute();
        $query              ->clear();
        $query                  ->select($db->quoteName(array('a.UniqueID','a.expert_id','a.name','a.email',
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
    /*public function convertCurrency($amount, $from, $to)
    {
        $data = file_get_contents("https://finance.google.com/finance/converter?a=$amount&from=$from&to=$to");
        preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
        $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
        return number_format(round($converted, 3),2);
    }*/
    function convertCurrency($amount,$from,$to) {
    $fromCurrency = urlencode($fromCurrency);
    $toCurrency = urlencode($toCurrency);
    $url = "https://www.google.com/search?q=".$from."+to+".$to;
    $get = file_get_contents($url);
    $data = preg_split('/\D\s(.*?)\s=\s/',$get);
    $exhangeRate = (float) substr($data[1],0,7);
    $convertedAmount = $amount*$exhangeRate;
    $data = array( 'exhangeRate' => $exhangeRate, 'convertedAmount' =>$convertedAmount, 'fromCurrency' => strtoupper($from), 'toCurrency' => strtoupper($to));
    return $data['convertedAmount'];
    }
    protected function sendMail($data)
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

        $body       .= "<p>Hello ".$data->name.",</p>";
        $body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Online Payment to AstroIsha(https://www.astroisha.com) is successful. The answers to your questions would be resolved and mailed to you in ten working days.</p><br/>"; 
        $body       .= "<p><strong>Details Of Your Order Are As Below: </strong></p>";
        $body       .= "<p>Order ID: ".$data->UniqueID."</p>";

        if($data->order_type == "short")
        {
			$body 			.= "<p>Answer Type: Short Answer</p>";
        }
        else
        {
			$body 			.= "<p>Answer Type: Detailed Report</p>";
        }
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
        $body           .= "<p>Payment Via: ".ucfirst($data->pay_mode)."</p>";

       if(($data->pay_mode=="paytm"||$data->pay_mode=="razorpay")&&($data->order_type == "short"))
        {
            $body       .= "<p>Payment Status: Success</p>";
            $body       .= "<br/><p>Please keep this email as reference. Alternatively you can also print this email for future reference.</p>";
            $body       .= "<p>Your order will be completed in 3-5 working day(Monday-Friday).</p>";
            $body       .= "<p>You will be notified via email if there is any more delay. And if order is not finished in 30 days your amount will be refunded back into your account.</p>";
        }
        else if($data->pay_mode=="paypal")
        {
            $body       .= "<p>Payment Status: ".$data->status."</p>";
             $body       .= "<br/><p>Please keep this email as reference. Alternatively you can also print this email for future reference.</p>";
            $body       .= "<p>Your order will be completed in 3-5 working day(Monday-Friday).</p>";
        }
        else
        {
            $body       .= "<p>Something went wrong with the payment. Please reply back to this email.</p>";
        }

        $body           .= "<p>Admin At Astro Isha,<br/>Rohan Desai</p>";
        $mailer->isHtml(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);

        $send = $mailer->Send();
        $link       = JUri::base().'getanswer?order='.$data->UniqueID.'&ref='.$data->email.'&payment=success';

        if ( $send !== true ) {
            $msg    = 'Error sending email: Try again and if problem continues contact admin@astroisha.com.';
            $msgType = "error";
            $app->enqueueMessage($msg, $msgType);
            $app->redirect($link);
        } 
        else 
        {
			
            $msg    =  'Payment to Astro Isha is successful. Please check your email to see payment details.';
            $msgType    = "success";
            $app->enqueueMessage($msg, $msgType);
            $app->redirect($link);
        }        
    }
    protected function sendFailMail($data)
    {
        //print_r($data);exit;
        $token      = $data->UniqueID;
        //print_r($data);exit;
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
        $mailer     ->addBcc('consult@astroisha.com');
        $subject    = "AstroIsha ".ucfirst($data->order_type)." Report: ".$data->UniqueID;
        $mailer     ->setSubject($subject);
        $body       = "";
        $body       .= "<p>Dear ".$data->name.",</p>";
        $body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your online payment to AstroIsha(https://www.astroisha.com) has failed. If you have cancelled the order than kindly ignore this email.</p>";
        $body           .= "<p>Admin At Astro Isha,<br/>Rohan Desai</p>";
        $mailer->isHtml(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
		
        $send = $mailer->Send();
        $link       = JUri::base().'getanswer?order='.$token.'&ref='.$data->email.'&payment=fail';
        if ( $send !== true ) {
            $msg    = 'Error sending email: Try again and if problem continues contact admin@astroisha.com.';
            $msgType = "warning";
            $app->redirect($link, $msg,$msgType);
        } 
        else 
        {
            $msg    =  'Payment has failed. Please check your email.';
            $msgType    = "warning";
            $app->redirect($link, $msg,$msgType);
        }
        
    }
    protected function getIPAddress()
    {
        //whether ip is from share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   
          {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
          }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
          {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
          }
        //whether ip is from remote address
        else
          {
            $ip_address = $_SERVER['REMOTE_ADDR'];
          }
        return $ip_address;
    }
 }
?>
