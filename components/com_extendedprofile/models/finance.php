<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
//Import filesystem libraries. Perhaps not necessary, but does not hurt
jimport('joomla.filesystem.file');
class ExtendedProfileModelFinance extends JModelItem
{
    public function getData()
    {

        $user = JFactory::getUser();
        $id   = $user->id;$name = $user->name;       
        // get the data
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('membership')))
                        ->from($db->quoteName('#__user_astrologer'))
                        ->where($db->quoteName('UserId').' = '.$db->quote($id));
        $db             ->setQuery($query);
        $data           = $db->loadAssoc();
        if($data['membership'] == 'Free')
        {
           $result     = $this->getLocationDetails();
        }
        else
        {
            $app        = JFactory::getApplication(); 
            $link       = JURI::base().'dashboard';
            $msgType    = "error";
            $msg        = 'You are already a Paid Member. You need not visit payment page.'; 
            $app->redirect($link, $msg, $msgType);
        }
       
        return $result;
    }
    function getLocationDetails()
    {
        $u_id           = 750;
        $service        = 'expert_fees';
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        try
        {
            include_once "/home/astroxou/php/Net/GeoIP.php";
            $geoip                  = Net_GeoIP::getInstance("/home/astroxou/php/Net/GeoLiteCity.dat");
            //$ip                     = '117.196.1.11';
            //$ip                         = '157.55.39.123';  // ip address
            $ip                     = $_SERVER['REMOTE_ADDR'];        // uncomment this ip on server
            //$info                   = geoip_country_code_by_name($ip);
            //$country                = geoip_country_name_by_name($ip);
            $location               = $geoip->lookupLocation($ip);
            $info                   = $location->countryCode;
            $country                = $location->countryName;
            if($info == "US")
            {
                $query          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                ->from($db->quoteName('#__expert_charges','a'))
                                ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                        $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                        $db->quoteName('country').' = '.$db->quote('US'));
                
            }
            else if($info == "IN"||$info== 'LK'||$info=='NP'||$info=='TH'||$info=='MY'||$info=='MV')
            {
                 $query          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                ->from($db->quoteName('#__expert_charges','a'))
                                ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                        $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                        $db->quoteName('country').' = '.$db->quote('IN'));
            }
            else if($info=='UK')
            {
                $query          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                ->from($db->quoteName('#__expert_charges','a'))
                                ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                        $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                        $db->quoteName('country').' = '.$db->quote('UK'));
            }
            else if($info=='NZ')
            {
                 $query          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                ->from($db->quoteName('#__expert_charges','a'))
                                ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                        $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                        $db->quoteName('country').' = '.$db->quote('NZ'));
            }
            else if($info=='CA')
            {
                $query          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                ->from($db->quoteName('#__expert_charges','a'))
                                ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                        $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                        $db->quoteName('country').' = '.$db->quote('CA'));
            }
            else if($info=='SG')
            {
                $query          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                ->from($db->quoteName('#__expert_charges','a'))
                                ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                        $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                        $db->quoteName('country').' = '.$db->quote('SG'));
            }
            else if($info=='AU')
            {
                 $query          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                ->from($db->quoteName('#__expert_charges','a'))
                                ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                        $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                        $db->quoteName('country').' = '.$db->quote('AU'));
            }
            else if($info=='FR'||$info=='DE'||$info=='IE'||$info=='NL'||$info=='CR'||$info=='BE'
                    ||$info=='GR'||$info=='IT'||$info=='PT'||$info=='ES'||$info=='MT'||$info=='LV'||$info=='TR')
            {
                $query          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                ->from($db->quoteName('#__expert_charges','a'))
                                ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                        $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                        $db->quoteName('country').' = '.$db->quote('EU'));
            }
            else if($info =='RU')
            {
                $query          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                ->from($db->quoteName('#__expert_charges','a'))
                                ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                        $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                        $db->quoteName('country').' = '.$db->quote('RU'));
            }
             else
            {
                $query          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                ->from($db->quoteName('#__expert_charges','a'))
                                ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                        $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                        $db->quoteName('country').' = '.$db->quote('ROW'));
            }
             $db             ->setQuery($query);
             $country           = array("country_full"=>$country);
             $result           = $db->loadAssoc();
             $details           = array_merge($result,$country);
        }
        catch(Exception $e)
        {
            $details                =  array('error'=> 'Data not showing');
        }
        
        return $details;
    }
    function saveDetails($details)
    {
        //print_r($details);exit;
        $acc_name           = $details['acc_name'];$acc_number              = $details['acc_number'];
        $acc_bank_name      = $details['acc_bank_name'];$acc_bank_addr      = $details['acc_bank_addr'];
        $acc_iban           = $details['acc_iban'];$acc_swift               = $details['acc_swift'];
        $acc_ifsc           = $details['acc_ifsc'];$acc_paypal              = $details['acc_paypal'];
        $user           = JFactory::getUser();
        $id             = $user->id;

        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        
        $fields         = array($db->quoteName('acc_holder_name').' = '.$db->quote($acc_name),
                                $db->quoteName('acc_number').' = '.$db->quote($acc_number),
                                $db->quoteName('acc_bank_name').' = '.$db->quote($acc_bank_name),
                                $db->quoteName('acc_bank_addr').' = '.$db->quote($acc_bank_addr),
                                $db->quoteName('acc_iban').' = '.$db->quote($acc_iban),
                                $db->quoteName('acc_swift_code').' = '.$db->quote($acc_swift),
                                $db->quoteName('acc_iban').' = '.$db->quote($acc_iban),
                                $db->quoteName('acc_ifsc').' = '.$db->quote($acc_ifsc),
                                $db->quoteName('acc_paypalid').' = '.$db->quote($acc_paypal));
        $conditions     = array($db->quoteName('UserId').' = '.$db->quote($id));
        
        
        // Set the query using our newly populated query object and execute it
        $query->update($db->quoteName('#__user_finance'))->set($fields)->where($conditions);
        $db->setQuery($query);
 
        $result = $db->execute();

        if($result)
        {
            $app = JFactory::getApplication(); 
            $link = JURI::base().'dashboard?data=success';
            $msg = 'Successfully added Financial Details'; 
            $app->redirect($link, $msg, $msgType='message');
        }
        else
        {
            $app = JFactory::getApplication(); 
            $link = JURI::base().'dashboard?data=fail';
            $msg = 'Unable to add financial details'; 
            $app->redirect($link, $msg, $msgType='message');
        }
    }
    function getPaidMembership($details)
    {
        $amount     = $details['pay_amount'];
        $choice     = $details['pay_choice'];
        $currency   = $details['pay_currency'];
        $location   = $details['pay_country'];
        $token      = uniqid('token_');
        // get user details
        
        $user       = JFactory::getUser();
        $uid        = $user->id;  
        $email      = $user->email;
               
        // get the data
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query1          = $db->getQuery(true);
        $query          ->select(array('COUNT(*)'))
                        ->from($db->quoteName('#__user_finance'))
                        ->where($db->quoteName('UserId').' = '.$db->quote($uid));
        $db             ->setQuery($query);
        $count          = $db->loadResult();
        if($count  >  0)
        {
            //echo $uid;exit;
            $query      ->clear();
            $object         = new stdClass();
            $object->UserId     = $uid;
            $object->amount     = $amount;
            $object->currency   = $currency;
            $object->location   = $location;
            $object->token      = $token;
            $object->pay_choice = $choice;
            $result             = $db->updateObject('#__user_finance',$object,'UserId'); 
       }
        else
        {
            $query          ->clear();
            $columns        = array('UserId','amount','currency','location','token','paid','pay_choice');
            $values         = array($uid,$amount,$db->quote($currency),
                                    $db->quote($location),$db->quote($token),$db->quote('No'),$db->quote($choice));
            $query
                            ->insert($db->quoteName('#__user_finance'))
                            ->columns($db->quoteName($columns))
                            ->values(implode(',', $values));
            $db->setQuery($query);
            $result             = $db->execute();
        }
        if($result)
        {
            $query           ->clear();
            $query          ->select(array('b.UserId','b.amount','b.currency','b.location','b.paid','b.token', 'b.pay_choice',
                                    'a.name','a.email','c.mobile','c.city','c.state','c.country','c.postcode'))
                            ->from($db->quoteName('#__users','a'))
                            ->join('INNER', $db->quoteName('#__user_finance','b').' ON (' . $db->quoteName('a.id').' = '.$db->quoteName('b.UserId') . ')')
                            ->join('INNER', $db->quoteName('#__user_astrologer', 'c').' ON ('.$db->quoteName('a.id').' = '.$db->quoteName('c.UserId').')')
                            ->where($db->quoteName('a.id').' = '.$db->quote($uid));
            $db->setQuery($query);
            $data           = $db->loadObject();
            $app        = JFactory::getApplication();
            //print_r($data);exit;
            if($data->pay_choice=="phonepe"||$data->pay_choice=="bhim"||$data->pay_choice=="cheque"
                ||$data->pay_choice=="direct"||$data->pay_choice=="paypalme"||$data->pay_choice=="directint")
            {
                $this->sendMail($data);
            }
            else if($data->pay_choice=="paytm")
            {
                $app->redirect(JUri::base().'PaytmKit/TxnTest.php?token='.$data->token.'&name='.$data->name.'&email='.$data->email.'&fees='.$data->amount.'&mobile='.$data->mobile); 
            }
            else if($data->pay_choice=="ccavenue")
            {
                $link   = JUri::base().'ccavenue/nonseam/ccavenue_astrologer.php?name='.str_replace(" ","_",$data->name).'&token='.$data->token.'&email='.$data->email.'&amount='.$data->amount.'&city='.$data->city.
                                        '&state='.$data->state.'&country='.$data->country.'&pcode='.$data->postcode.'&mobile='.$data->mobile; 
                $app->redirect($link);
            }
            else if($data->pay_choice=="paypal")
            {
                //echo $data->pay_choice;exit;
                $link   = JUri::base().'vendor/paypal_astro.php?&token='.$data->token.'&name='.$data->name.'&email='.$data->email.'&curr='.$data->currency.'&amount='.$data->amount;
                $app->redirect($link);
            }
            
        }
    }
    function sendMail($data)
    {
        //print_r($data);exit;
        $user       = JFactory::getUser();
        $mailer     = JFactory::getMailer();
        $config     = JFactory::getConfig();
        $app        = JFactory::getApplication(); 
        $body       = "";
        $sender     = array(
                        $config->get('mailfrom'),
                        $config->get('fromname')
                            );
        
        $mailer     ->setSender($sender);
        $recepient  = $user->email;
        $mailer     ->addRecipient($recepient);
        $mailer     ->addBcc('kopnite@gmail.com');
        $subject    = "AstroIsha Paid Membership Token: ".$data->token;
        $mailer     ->setSubject($subject);
        if($data->pay_choice == "bhim"||$data->pay_choice=="phonepe")
        {
            $pay_mode   = ucfirst($data->pay_choice)." App";
        }
        else if($data->pay_choice=="direct")
        {
            $pay_mode   = ucfirst($data->pay_choice)." Tranfer";
        }
        else if($data->pay_choice=="paypalme")
        {
            $pay_mode   = "<strong>PayPal.Me</strong>";
        }
        else
        {
            $pay_mode   = ucfirst($data->pay_choice);
        }
        if($data->pay_choice=="paytm"||$data->pay_choice=="paypal"||$data->pay_choice=="ccavenue")
        {
            $body       .= "<p>Dear ".$user->name.",</p>";
            if($data->status=="fail")
            {
                $body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Online Payment to AstroIsha(https://www.astroisha.com) has failed. 
                            Kindly re-try payment via: https://www.astroisha.com/finance or try one of the other available options. Once your payment is completed and authorized you would be able to avail benefits of Paid Memberships.</strong></p><br/>"; 
            }
            else if($data->status =="success")
            {
                $body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Online Payment to AstroIsha(https://www.astroisha.com) is successful. You can now avail benefits of Paid Memberships. For more information please visit: https://www.astroisha.com/astrologer</strong></p><br/>"; 
            }
            else
            {
                $body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Online Payment to AstroIsha(https://www.astroisha.com) has failed. 
                            Kindly re-try payment via: https://www.astroisha.com/finance or try one of the other available options. Once your payment is completed and authorized you would be able to avail benefits of Paid Memberships.</strong></p><br/>"; 
                $body       .= "<p><strong>Below Are The Details Of Failed Payment:</strong></p>";
            }
        }
        else
        {
            $body       .= "<p>Dear ".$user->name.",</p>";
            $body       .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You have applied for Paid Membership with AstroIsha(https://www.astroisha.com). 
                            Once your payment is completed and authorized you would be able to avail benefits of Paid Memberships. You have chosen 
                            payment by using ".$pay_mode.". Kindly pay the amount: ".$data->amount." ".$data->currency." and notify 
                            to admin@astroisha.com once payment is completed. <strong>Kindly keep some reference of your payment to avoid issues later.</strong></p><br/>"; 
            $body       .= "<p><strong>Below Are The Payment Details:</strong></p>";
        }    
        if($data->pay_choice == "bhim")
        {
            $body       .= "<p><strong>Pay To: </strong>astroisha@upi or 9727841461</p>";
            $body       .= "<p>Alternatively you can open Bhim App and scan the attached image to make payment.</p>";
        }
        else if($data->pay_choice == "phonepe")
        {
            $body       .= "<p><strong>Pay To: </strong>astroisha@ybl or 9727841461</p>";
            $body       .= "<p>Alternatively you can open PhonePe App and scan the attached image to make payment.</p>";
        }
        else if($data->pay_choice == "direct")
        {
            $body       .= "<p><strong>Payable To: </strong>Astro Isha</p>";
            $body       .= "<p><strong>Account Number: </strong>915020051554614</p>";
            $body       .= "<p><strong>Bank Name: </strong>Axis Bank</p>";
            $body       .= "<p><strong>IFSC Code: </strong>UTIB0000080</p>";                  
        }
        else if($data->pay_choice == "cheque")
        {
            $body       .= "<p>Write a Cheque to <strong>Astro Isha</strong> and submit it to your near Axis Bank. Keep Cheque Number as reference.</p>";
        }
        else if($data->pay_choice == "paypalme")
        {
            $link       = "https://www.paypal.me/AstroIsha/".$data->amount.$data->currency;
            $body       .=  "<a href=".$link.">Pay Using Paypal.Me</a>";
            $body       .= "<p>Click On The Above Link to finish payment. Send the payment confirmation email from Paypal to admin@astroisha.com in order to verify payment.</p>";
        }
        else if($data->pay_choice == "directint")
        {
            $body       .= "<p><strong>Payable To: </strong>Astro Isha</p>";
            $body       .= "<p><strong>Account Number: </strong>915020051554614</p>";
            $body       .= "<p><strong>Bank Name: </strong>Axis Bank</p>";
            $body       .= "<p><strong>Swift Code: </strong>AXISINBB080</p>";
        }
        else if($data->pay_choice=="paytm"&&$data->status=="fail")
        {
            $body       .= "<p><strong>Online Payment via Paytm has Failed. Please try again to get paid membership. Below are details: </strong></p>";
            $body       .= "<p><strong>Amount: </strong>".$data->amount." ".$data->currency."</p>";
            $body       .= "<p><strong>Token: </strong>".$data->token."</p>";
            $body       .= "<p><strong>Payment Via: </strong>".$data->pay_choice."</p>";
            $body       .= "<p><strong>Payment Status: </strong>".ucfirst($data->status)."</p>";
            
        }
        else if($data->pay_choice=="ccavenue"&& $data->status=="fail")
        {
            $body       .= "<p><strong>Online Payment for Astro Isha has Failed. Please try again to get paid membership. Below are details: </strong></p>";
            $body       .= "<p><strong>Amount: </strong>".$data->amount." ".$data->currency."</p>";
            $body       .= "<p><strong>Token: </strong>".$data->token."</p>";
            $body       .= "<p><strong>Payment Via: </strong>".$data->pay_choice."</p>";
            $body       .= "<p><strong>Payment Status: </strong>".ucfirst($data->status)."</p>";
            
        }
        else if($data->pay_choice=="paypal"&& $data->status=="fail")
        {
            $body       .= "<p><strong>Online Payment for Astro Isha via Paypal has Failed. Please try again to get paid membership. Below are details: </strong></p>";
            $body       .= "<p><strong>Amount: </strong>".$data->amount." ".$data->currency."</p>";
            $body       .= "<p><strong>Token: </strong>".$data->token."</p>";
            $body       .= "<p><strong>Payment Via: </strong>".$data->pay_choice."</p>";
            $body       .= "<p><strong>Payment Status: </strong>".ucfirst($data->status)."</p><br/>";
            $body       .= "<p>Alternatively you can use Direct Transfer or PaypalMe. 
                                Below is the link to pay via PaypalMe. Just email the payment confirmation to Astro Isha
                                and mention the token number provided and we would update your Account to Paid Membership.</p>";
            $link       = "https://www.paypal.me/AstroIsha/".$data->amount.$data->currency;
            $body       .=  "<a href=".$link.">Pay Using Paypal.Me</a><br/><br/>";
            
        }
        else if($data->pay_choice=="paytm"&&$data->status=="success")
        {
            $body       .= "<p><strong>Online Payment via Paytm is Successful. Below are the details of payment: </strong></p>";
            $body       .= "<p><strong>Amount: </strong>".$data->amount." ".$data->currency."</p>";
            $body       .= "<p><strong>Token: </strong>".$data->token."</p>";
            $body       .= "<p><strong>Payment Via: </strong>".$data->pay_choice."</p>";
            $body       .= "<p><strong>Payment Status: </strong>".ucfirst($data->status)."</p>";
            $body       .= "<p><strong>Payment Id: </strong>".$data->payment_id."</p>";
            $body       .= "<p><strong>Bank Reference Id: </strong>".$data->bank_ref."</p>";
            $body       .= "<br/><p><strong>Please keep this email as reference. Alternatively you can also print this email for future reference.</strong></p>";
        }
        else if($data->pay_choice=="ccavenue"&&$data->status=="success")
        {
            $body       .= "<p><strong>Online Payment via Paytm is Successful. Below are the details of payment: </strong></p>";
            $body       .= "<p><strong>Amount: </strong>".$data->amount." ".$data->currency."</p>";
            $body       .= "<p><strong>Token: </strong>".$data->token."</p>";
            $body       .= "<p><strong>Payment Via: </strong>".$data->pay_choice."</p>";
            $body       .= "<p><strong>Payment Status: </strong>".ucfirst($data->status)."</p>";
            $body       .= "<p><strong>Payment Id: </strong>".$data->payment_id."</p>";
            $body       .= "<p><strong>Bank Reference Id: </strong>".$data->bank_ref."</p>";
            $body       .= "<br/><p><strong>Please keep this email as reference. Alternatively you can also print this email for future reference.</strong></p>";
        }
        else if($data->pay_choice=="paypal"&&$data->status=="success")
        {
            $body       .= "<p><strong>Online Payment via Paypal is Successful. Below are the details of payment: </strong></p>";
            $body       .= "<p><strong>Amount: </strong>".$data->amount." ".$data->currency."</p>";
            $body       .= "<p><strong>Token: </strong>".$data->token."</p>";
            $body       .= "<p><strong>Payment Via: </strong>".$data->pay_choice."</p>";
            $body       .= "<p><strong>Payment Status: </strong>".ucfirst($data->status)."</p>";
            $body       .= "<p><strong>Payment Id: </strong>".$data->payment_id."</p>";
            $body       .= "<br/><p><strong>Please keep this email as reference. Alternatively you can also print this email for future reference.</strong></p>";
        }
        else
        {
            $body       .= "<p><strong>Payable To: </strong>Astro Isha</p>";
            $body       .= "<p><strong>Account Number: </strong>915020051554614</p>";
            $body       .= "<p><strong>Bank Name: </strong>Axis Bank</p>";
            $body       .= "<p><strong>IFSC Code: </strong>UTIB0000080</p>";
            $body       .= "<p><strong>Swift Code: </strong>AXISINBB080</p>";
        }
        $body       .= "<p>Admin At Astro Isha,<br/>Rohan Desai</p>";
        $mailer->isHtml(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        if($data->pay_choice=="phonepe")
        {
            $mailer->addAttachment(JPATH_BASE.'/images/phonepe_pay.png');
        }
        else if($data->pay_choice=="bhim")
        {
            $mailer->addAttachment(JPATH_BASE.'/images/bhim_pay.jpg');
        }
        else if($data->pay_choice == "direct"||$data->pay_choice =="directint")
        {
            $mailer->addAttachment(JPATH_BASE.'/images/bank_details.pdf');
        }
        $send = $mailer->Send();
        $link       = JUri::base().'dashboard';
        if ( $send !== true ) {
            $msg    = 'Error sending email: Try again and if problem continues contact admin@astroisha.com.';
            $msgType = "error";
            $app->redirect($link, $msg,$msgType);
        } else {
            if($data->pay_choice=="paytm"&&$data->status=="success")
            {
                $msg    =  'Payment via Paytm is successful. Please check your email to see payment details.';
                $msgType    = "success";
                $app->redirect($link, $msg,$msgType);
            }
            else if($data->pay_choice=="paytm"&&$data->status=="fail")
            {
                $msg    =  'Payment via Paytm has failed. Kindly check your email for details.';
                $msgType    = "error";
                $app->redirect($link, $msg,$msgType);
            }
            else if($data->pay_choice=="ccavenue"&&$data->status=="success")
            {
                $msg    =  'Please check your email to see payment details.';
                $msgType    = "success";
                $app->redirect($link, $msg,$msgType);
            }
            else if($data->pay_choice=="ccavenue"&&$data->status=="fail")
            {
                $msg    =  'Payment has failed. Kindly check your email for details.';
                $msgType    = "error";
                $app->redirect($link, $msg,$msgType);
            }
            else if($data->pay_choice=="paypal"&&$data->status=="fail")
            {
                $msg    =  'Payment via Paypal has failed. Kindly check your email for details.';
                $msgType    = "error";
                $app->redirect($link, $msg,$msgType);
            }
            else if($data->pay_choice=="paypal"&&$data->status=="success")
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
    function confirmPaymentIn($data)
    {
        //print_r($data);exit;
        $txnid          = $data['txnid'];
        $token          = $data['token'];
        $bank_ref       = $data['bank_ref'];
        $status         = $data['status'];
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $user       = JFactory::getUser();
        $uid        = $user->id;
        date_default_timezone_set('Asia/Kolkata');
        $date                   = date('d-m-Y H:i:s');
        if($status == 'TXN_SUCCESS')
        {
            $object                 = new stdClass();
            $object->UserId         = $uid;
            $object->membership     = "Paid";
            $result             = $db->updateObject('#__user_astrologer',$object,'UserId'); 
            $query      ->clear();unset($result);
            $object         = new stdClass();
            $object->UserId     = $uid;
            $object->paid       = "Yes";
            $object->payment_id   = $txnid;
            $object->bank_ref      = $bank_ref;
            $object->token          = $token;
            $object->status         = "success";
            $object->date_of_order  = $date;
            $result             = $db->updateObject('#__user_finance',$object,'UserId','token'); 
            $query      ->clear();
            $query          ->select(array('amount','currency','location','paid','token','payment_id','bank_ref','pay_choice','status'))
                            ->from($db->quoteName('#__user_finance'))
                            ->where($db->quoteName('UserId').' = '.$db->quote($uid));
            $db->setQuery($query);
            $data           = $db->loadObject();
            $this->sendMail($data);
            
        }
        else
        {
            $object                 = new stdClass();
            $object->UserId         = $uid;
            $object->token          = $token;
            $object->status         = "fail";
            $object->date_of_order  = $date;
            $result                 = $db->updateObject('#__user_finance',$object,'UserId','token'); 
            $query                  ->select(array('amount','currency','location','paid','token','pay_choice','status'))
                                    ->from($db->quoteName('#__user_finance'))
                                    ->where($db->quoteName('UserId').' = '.$db->quote($uid));
            $db->setQuery($query);
            $data           = $db->loadObject();
            $this->sendMail($data);
        }
    }
    public function authorizeCCPayment($details)
    {
        $user = JFactory::getUser();
        $uid        = $user->id;
        $email      = $details['email'];
        $token      = $details['token'];$status     = $details['status'];
        $track_id   = $details['track_id'];
        $db         = JFactory::getDbo();  // Get db connection
        $query      = $db->getQuery(true);
        $app        = JFactory::getApplication();
        date_default_timezone_set('Asia/Kolkata');
        $date                   = date('d-m-Y H:i:s');
        if($status == "success")
        {
            $bank_ref               = $details['bank_ref'];
            $fields                 = array($db->quoteName('membership').' = '.$db->quote('Paid'));
            $conditions             = array($db->quoteName('UserId') . ' = '.$db->quote($uid));
            $query->update($db->quoteName('#__user_astrologer'))->set($fields)->where($conditions);
            $db->setQuery($query);$result = $db->execute();
            unset($result);$query->clear();unset($fields);unset($conditions);            // unset all variables
            $object         = new stdClass();
            $object->UserId     = $uid;
            $object->paid       = "Yes";
            $object->payment_id   = $track_id;
            $object->bank_ref      = $bank_ref;
            $object->token          = $token;
            $object->status         = "success";
            $object->date_of_order  = $date;
            $result             = $db->updateObject('#__user_finance',$object,'UserId','token'); 
            $query      ->clear();
            unset($result);$query->clear();unset($fields);unset($conditions);            // unset all variables
            $query->clear();        // unset all variables
            $query                  ->select(array('amount','currency','location','paid','token','payment_id','bank_ref','pay_choice','status'))
                                    ->from($db->quoteName('#__user_finance'))
                                    ->where($db->quoteName('UserId').' = '.$db->quote($uid));
            $db->setQuery($query);
            $data           = $db->loadObject();
            //print_r($data);exit;
            $this->sendMail($data);
        }
        else
        {
            $object                 = new stdClass();
            $object->UserId         = $uid;
            $object->token          = $token;
            $object->status         = "fail";
            $object->date_of_order  = $date;
            $result                 = $db->updateObject('#__user_finance',$object,'UserId','token'); 
            $query                  ->select(array('amount','currency','location','paid','token','pay_choice','status'))
                                    ->from($db->quoteName('#__user_finance'))
                                    ->where($db->quoteName('UserId').' = '.$db->quote($uid));
            $db->setQuery($query);
            $data           = $db->loadObject();
            $this->sendMail($data);
        }
    }
    function authorizePayment($data)
    {
        $user = JFactory::getUser();
        $uid        = $user->id;
        //print_r($data);exit;
        $status         = $data['status'];
        $token          = $data['token'];
        $pay_id         = $data['pay_id'];
        $email          = $data['email'];
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $app            = JFactory::getApplication();
        date_default_timezone_set('Asia/Kolkata');
        $date                   = date('d-m-Y H:i:s');
        if($status == "success")
        {
            $fields                 = array($db->quoteName('membership').' = '.$db->quote('Paid'));
            $conditions             = array($db->quoteName('UserId') . ' = '.$db->quote($uid));
            $query->update($db->quoteName('#__user_astrologer'))->set($fields)->where($conditions);
            $db->setQuery($query);$result = $db->execute();
            unset($result);$query->clear();unset($fields);unset($conditions);            // unset all variables
            $object                 = new stdClass();
            $object->UserId         = $uid;
            $object->paid           = "Yes";
            $object->payment_id     = $pay_id;
            $object->token          = $token;
            $object->status         = $status;
            $object->date_of_order  = $date;
            $result             = $db->updateObject('#__user_finance',$object,'UserId','token'); 
            $query      ->clear();
            unset($result);$query->clear();unset($fields);unset($conditions);            // unset all variables
            $query->clear();        // unset all variables
            $query                  ->select(array('amount','currency','location','paid','token','payment_id','pay_choice','status'))
                                    ->from($db->quoteName('#__user_finance'))
                                    ->where($db->quoteName('UserId').' = '.$db->quote($uid));
            $db->setQuery($query);
            $data           = $db->loadObject();
            //print_r($data);exit;
            $this->sendMail($data);
        }
        else
        {
            $object                 = new stdClass();
            $object->UserId         = $uid;
            $object->token          = $token;
            $object->status         = "fail";
            $object->date_of_order  = $date;
            $result                 = $db->updateObject('#__user_finance',$object,'UserId','token'); 
            $query->clear();        // unset all variables
            $query                  ->select(array('amount','currency','location','paid','token','payment_id','pay_choice','status'))
                                    ->from($db->quoteName('#__user_finance'))
                                    ->where($db->quoteName('UserId').' = '.$db->quote($uid));
            $db->setQuery($query);
            $data           = $db->loadObject();
            //print_r($data);exit;
            $this->sendMail($data);
        }
    }
}
