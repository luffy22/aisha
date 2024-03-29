<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
use Joomla\CMS\MVC\Model\ListModel;
require_once(JPATH_BASE.'/geoip/autoload.php');
use GeoIp2\Database\Reader;
class AstrologinModelAstroReport extends ListModel
{
    public function getData()
    {
        $reader = new Reader('/usr/local/share/GeoIP/GeoIP2-City.mmdb');  // local file
        //$reader             = new Reader('/home3/astroxou/usr/share/GeoIP2-City.mmdb'); // server file
        $ip               = '117.196.1.11';
        //$ip                             = '140.120.6.207';
        //$ip                             = '157.55.39.123';  // ip address
        //$ip 							= '1.10.128.129';  // thai address
        //	$ip 							= '175.157.193.156'; // srilanka ip address
        //$ip                       		= $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server
        $record             = $reader->city($ip);
        $info               = $record->country->isoCode;
        $country            = $record->country->name;
        $state              = $record->mostSpecificSubdivision->name;
        $state_code         = $record->mostSpecificSubdivision->isoCode;
        $city               = $record->city->name;
        
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
        $service5       = 'finance';
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
                                            $db->quoteName('country').' = '.$db->quote($info).' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service3).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($info).' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service4).' AND '.
                                            $db->quoteName('country').' = '.$db->quote($info).' OR '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service5).' AND '.
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
        $loc_id             = $details['loc_id'];
        //echo $loc_id;exit;
        // Check if location exists in database
        if($loc_id == "0")
        {
            $loc            = $pob;
        }
        else 
        {
            $loc            = $loc_id;
        }
        $expert_id          = '222';
        $no_of_ques         = '0';
        
        $date               = new DateTime($dob);
        $date               ->setTime($tob[0],$tob[1],"00");
        $dob_tob            = strtotime($date->format('Y-m-d H:i:s'));
        $date1              = new DateTime('now');
        $date1              ->setTimezone(new DateTimeZone('Asia/Kolkata'));
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
                                $db->quote($dob_tob),$db->quote($loc),$db->quote($ques_type),$db->quote($ques_ask_date)
                                );
        // Prepare the insert query
        $query          ->insert($db->quoteName('#__question_details'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
        $db->setQuery($query);
		
        
        if($result          = $db->execute())
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
            $app            ->redirect(JUri::base().'order-report?uniq_id='.$uniqID.'&order_type='.$order_type);
        }
        else
        {
            $msg            = "Something went wrong. Please try again.";
            $type           = "warning";
            $app            ->redirect(Juri::base().'order-report',$msg,$type);
        }
    }
    public function insertDetails2($details)
    {
        //print_r($details);exit;
        $order_id           = $details['order_id'];
        $order_type         = $details['order_type'];
        $query_about        = $details['query_about'];
        
        if($order_type == "career")
        {
            $order_branch   = "career_report";
        }
        else if($order_type == "marriage")
        {
            $order_branch   = "marriage_report";
        }
        else if($order_type == "yearly")
        {
            $order_branch   = "yearly_report";
        }
        else if($order_type == "finance")
        {
            $order_branch   = "finance_report";
        }
        else if($order_type == "education")
        {
            $order_branch   = "education_report";
        }
        else
        {       
            $order_branch   = "marriage_report";
        }
        //echo $order_branch;exit;
        $query_explain      = $details['details_explain'];
        $app                = JFactory::getApplication();
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select('COUNT(*)')
                            ->from($db->quoteName('#__order_queries'))
                            ->where($db->quoteName('order_id').' = '.$db->quote($order_id));
        $db                 ->setQuery($query);
        $count = $db->loadResult();
        if($count > 0)
        {
			$fields            	= array(
											$db->quoteName('order_type').' = '.$db->quote($order_type),
											$db->quoteName('query_about').' = '.$db->quote($query_about),
											$db->quoteName('query_explain').' = '.$db->quote($query_explain));
			$conditions			= array(
											$db->quoteName('order_id').' = '.$db->quote($order_id)
										);
			$query->clear();
			$query->update($db->quoteName('#__order_queries'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$result = $db->execute();			
		}
		else
		{
			$columns            = array('order_id','order_type','query_about','query_explain'
								);
			$values             = array(
										$db->quote($order_id),$db->quote($order_type),$db->quote($query_about),
										$db->quote($query_explain)
									);
			// Prepare the insert query
			$query 			->clear();
			$query          ->insert($db->quoteName('#__order_queries'))
							->columns($db->quoteName($columns))
							->values(implode(',', $values));
			// Set the query using our newly populated query object and execute it
			$db             ->setQuery($query);
			$result          = $db->execute();unset($result);
		
			$query           ->clear();
			$columns            = array('order_id','order_branch');
			$values             = array($db->quote($order_id), $db->quote($order_branch));
			// Prepare the insert query
			$query          ->insert($db->quoteName('#__order_reports'))
							->columns($db->quoteName($columns))
							->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
			$db             ->setQuery($query);
			$result 		= $db->execute();
		}
		$query              ->clear();
		$query              ->select($db->quoteName(array('UniqueID','name','email',
									'pay_mode','fees','currency')))
							->from($db->quoteName('#__question_details'))
							->where($db->quoteName('UniqueID').'='.$db->quote($order_id));
		$db                  ->setQuery($query);
		$row                 = $db->loadAssoc();
		//print_r($row);exit;
		$token               = $row['UniqueID'];
		$name                = str_replace(" ","_",$row['name']);
		$email               = $row['email'];
		$currency            = $row['currency'];
		$fees                = $row['fees'];
		$pay_mode            = $row['pay_mode'];
	   //echo $pay_mode;exit;
	   
		if($pay_mode == "razorpay")
		{
			$app->redirect(JUri::base().'razorpay/order.php?token='.$token.'&name='.$name.'&email='.$email.'&curr='.$currency.'&fees='.$fees);
		}
	   else if($pay_mode == "paytm")
		{
			$app->redirect(JUri::base().'PaytmKit/TxnTest2.php?token='.$token.'&email='.$email.'&fees='.$fees); 
		}
	   else if($pay_mode=="paypal")
		{
		   $app->redirect(JUri::base().'vendor/paypal2.php?token='.$token.'&name='.$name.'&email='.$email.'&curr='.$currency.'&fees='.$fees); 
		}
          
    }
    public function insertDetails3($details)
    {
        //print_r($details);exit;
        $query_about_1          = $details['career_about'];
        $query_explain_1        = $details['career_explain'];
        $query_about_2          = $details['marriage_about'];
        $query_explain_2        = $details['marriage_explain'];
        $query_about_3          = $details['other_about'];
        $query_explain_3        = $details['other_explain'];
        $order_id               = $details['order_id'];
        $order_type             = $details['order_type'];
        $app                    = JFactory::getApplication();
        $db                     = JFactory::getDbo();  // Get db connection
        $query                  = $db->getQuery(true);
        $query              ->select('COUNT(*)')
                            ->from($db->quoteName('#__order_queries'))
                            ->where($db->quoteName('order_id').' = '.$db->quote($order_id));
        $db                 ->setQuery($query);
        $count = $db->loadResult();
        //echo $count;exit;
        if($count > 0)
        {
			
            for($i=1;$i<4;$i++)
            {
                $query 				->clear();
                $query_no			= $i;
                $query_about        = ${"query_about_".$i};
                $query_explain      = ${"query_explain_".$i};
                $fields            	= array(
                                                $db->quoteName('order_type').' = '.$db->quote($order_type),
                                                $db->quoteName('query_about').' = '.$db->quote($query_about),
                                                                                $db->quoteName('query_explain').' = '.$db->quote($query_explain)
                                                );
                $conditions		= array(
                                                $db->quoteName('order_id').' = '.$db->quote($order_id).' AND '.
                                                $db->quoteName('query_no').' = '.$db->quote($query_no)
                                                );
                $query->update($db->quoteName('#__order_queries'))->set($fields)->where($conditions);
                $db->setQuery($query);
                $result = $db->execute();
                $query->clear();
               
            }		
			
        }
        else
        {
            for($i=1;$i<4;$i++)
            {
                $query 				->clear();
                $order_id           = $details['order_id'];
                $order_type         = $details['order_type'];
                $query_no			= $i;
                $query_about        = ${"query_about_".$i};
                $query_explain      = ${"query_explain_".$i};
                $columns                = array(
                                                'order_id','order_type','query_no','query_about','query_explain'
                                                );
                $values                 = array(
                                                    $db->quote($order_id),$db->quote($order_type),$db->quote($query_no),$db->quote($query_about),
                                                    $db->quote($query_explain)
                                                );

                // Prepare the insert query
                $query              ->insert($db->quoteName('#__order_queries'))
                                                    ->columns($db->quoteName($columns))
                                                    ->values(implode(',', $values));
                // Set the query using our newly populated query object and execute it
                $db             ->setQuery($query);
                $db->execute();
                $query->clear();
            }
            $array1     = array('life_main','life_planets','life_houses','life_dasha','life_basics','life_yogas','life_sadesati');	
            $array2     = array(
                                array('main_chart','moon_chart','nav_chart','das_chart','tithi','nakshatra','rashi','yoga','karana'),
                                array('sun','moon','mars','mercury','jupiter','venus','saturn','rahu','ketu'),
                                array('house_1','house_2','house_3','house_4','house_5','house_6',
                                        'house_7','house_8','house_9','house_10','house_11','house_12'),
                                array('dasha_1','dasha_2','dasha_3','dasha_4','dasha_5','dasha_6','dasha_7'),
                                array('education','career','marriage','health','finance','children'),
                                array('good_yogas','bad_yogas','other_yogas'),
                                array('sadesati_1','sade_sati2','sade_sati3')
                                );
            $k  = 0;
            for($i=0;$i<7;$i++)
            {
                $order_branch      = $array1[$i];
                //echo count($arechoray2[$i]);exit;
                for($j=0;$j<count($array2[$i]);$j++)
                {

                    $order_sub      = $array2[$i][$j];
                    $columns        = array('order_id','order_branch','order_sub');
                    $values         = array(
                                            $db->quote($order_id),$db->quote($order_branch),
                                            $db->quote($order_sub));
                    $query          ->insert($db->quoteName('#__order_reports'))
                                    ->columns($db->quoteName($columns))
                                    ->values(implode(',', $values));
                            // Set the query using our newly populated query object and execute it
                    $db             ->setQuery($query);
                    $result         = $db->execute();
                    $query->clear();
                }
            }
				
        }
        $query 				->clear();
        $query              ->select($db->quoteName(array('UniqueID','name','email',
                                        'pay_mode','fees','currency')))
                            ->from($db->quoteName('#__question_details'))
                            ->where($db->quoteName('UniqueID').'='.$db->quote($order_id));
        $db                 ->setQuery($query);
        $row                = $db->loadAssoc();
        //print_r($row);exit;
        $token               = $row['UniqueID'];
        $name                = str_replace(" ","_",$row['name']);
        $email               = $row['email'];
        $currency            = $row['currency'];
        $fees                = $row['fees'];
        $pay_mode            = $row['pay_mode'];
       //echo $pay_mode;exit;
        if($pay_mode == "razorpay")
        {
            $app->redirect(JUri::base().'razorpay/order.php?token='.$token.'&name='.$name.'&email='.$email.'&curr='.$currency.'&fees='.$fees);
        }
       else if($pay_mode == "paytm")
        {
            $app->redirect(JUri::base().'PaytmKit/TxnTest2.php?token='.$token.'&email='.$email.'&fees='.$fees); 
        }
       else if($pay_mode=="paypal")
        {
           $app->redirect(JUri::base().'vendor/paypal2.php?token='.$token.'&name='.$name.'&email='.$email.'&curr='.$currency.'&fees='.$fees); 
        }

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
                                        'a.gender','a.dob_tob','a.pob','a.pay_mode','a.order_type','a.fees','a.currency','a.paid','b.paypal_id','b.status')))
                                ->from($db->quoteName('#__question_details','a'))
                                ->join('INNER', $db->quoteName('#__paypal_info', 'b') . ' ON (' . $db->quoteName('a.UniqueID').' = '.$db->quoteName('b.UniqueID') . ')')
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
        $query              ->select($db->quoteName(array('a.UniqueID','a.name','a.email',
                                        'a.gender','a.dob_tob','a.pob','a.pay_mode','a.order_type','a.fees','a.currency','a.paid')))
                                ->from($db->quoteName('#__question_details','a'))
                                ->where($db->quoteName('a.UniqueID').'='.$db->quote($token));
        $db                  ->setQuery($query);
        $db->execute();
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
        $db 				= JFactory::getDbo();
        $query 				= $db->getQuery(true);
        if($status      == 'Success'||$status =='TXN_SUCCESS'||$status="confirmed")
        {
            $status = "Success";
		}
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
        $mailer     ->addBcc('consult@astroisha.com');
        $subject    = "AstroIsha ".ucfirst($data->order_type)." Report: ".$data->UniqueID;
        $mailer     ->setSubject($subject);
		
		$body 		.= "<p><strong>This is an automated response from server. No need to reply to this email.</strong></p>";
        $body       .= "<p>Hello ".$data->name.",</p>";
        if($data->paid =="yes")
        {
                $body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your online payment to AstroIsha(https://www.astroisha.com) is successful. Your report would be completed and mailed to you in 15-20 working days.</p><br/>"; 
        }
        else
        {
                $body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your online payment to AstroIsha(https://www.astroisha.com) has failed. Kindly retry again if you wish your an answer to your questions. If you have cancelled the order than kindly ignore this email.</p>";
        }
        $body           .= "<p><strong>Details Of Your Order Are As Below: </strong></p>";
        $body           .= "<p>Order ID: ".$data->UniqueID."</p>";

        if($data->order_type == "yearly")
        {
                $body 			.= "<p>Order Type: Yearly Report</p>";
        }
        else if($data->order_type == "life")
        {
                $body 			.= "<p>Order Type: Life Report</p>";
        }
        else if($data->order_type == "career")
        {
                $body 			.= "<p>Order Type: Career Report</p>";
        }
        else if($data->order_type == "marriage")
        {
                $body 			.= "<p>Order Type: Marriage Report</p>";
        }
        else if($data->order_type == "finance")
        {
                $body 			.= "<p>Order Type: Financial Report</p>";
        }
        else if($data->order_type == "education")
        {
                $body 			.= "<p>Order Type: Education Report</p>";
        }
        else
        {
                $body 			.= "<p>Order Type: Life Report</p>";
        }

        $order_link           = "https://www.astroisha.com/read-report?order=".$data->UniqueID."&ref=".$data->email;
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

        if(($data->pay_mode=="paytm"||$data->pay_mode=="razorpay")&&$data->paid=="yes")
        {
            $body       .= "<p>Payment Status: Success</p>";
            $body       .= "<p>Payment Id: ".$data->track_id."</p>";
            $body       .= "<br/><p><strong>Please keep this email as reference. Alternatively you can also print this email for future reference.</strong></p>";
            $body       .= "<p><strong>In case the order is not completed in twenty-five working days you would be refunded most of the amount back into your bank account. Amount deducted would be service charge by third-party payment service. AstroIsha does not charge anything for uncompleted orders.</strong></p><br/>";
        }
        else if($data->pay_mode=="paypal"&&$data->paid=="yes")
        {
            $body       .= "<p>Payment Status: ".$data->status."</p>";
            $body       .= "<p>Your payment is safe with paypal. AstroIsha would only ask for credit after we have finished your order and mailed it to you.</p>";
            $body       .= "<br/><p><strong>Please keep this email as reference. Alternatively you can also print this email for future reference.</strong></p>";
            $body       .= "<p><strong>In case your order is not completed in twenty-five working days you would be refunded most of the amount back into your bank account. Amount if deducted would be service charge by paypal. 
                             AstroIsha does not charge anything for uncompleted orders.</strong></p><br/>";
        }
        else
        {
            $body       .= "Something went wrong. Please contact the administrator at admin@astroisha.com";
        }

        $body           .= "<p>Admin At Astro Isha,<br/>Rohan Desai</p>";
        $mailer->isHtml(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);

        $send = $mailer->Send();
        $link       = JUri::base().'read-report?order='.$data->UniqueID.'&ref='.$data->email.'&payment=success';
        if ( $send !== true ) {
            $msg    = 'Error sending email: Try again and if problem continues contact admin@astroisha.com.';
            $msgType = "warning";
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
        $body       .= "<p>Hello ".$data->name.",</p>";
        $body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your online payment to AstroIsha(https://www.astroisha.com) has failed. If you have cancelled the order than kindly ignore this email.</p>";
        $body           .= "<p>Admin At Astro Isha,<br/>Rohan Desai</p>";
        $mailer->isHtml(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);

        $send = $mailer->Send();
        $link       = JUri::base().'read-report?order='.$token.'&ref='.$data->email.'&payment=fail';
        if ( $send !== true ) {
            $msg    = 'Error sending email: Try again and if problem continues contact admin@astroisha.com.';
            $msgType = "warning";
            $app->enqueueMessage($msg, $msgType);
            $app->redirect($link);
        } 
        else 
        {
            $msg    =  'Payment has failed. Please check your email.';
            $msgType    = "warning";
            $app->enqueueMessage($msg, $msgType);
            $app->redirect($link);
        }   
    }
}
