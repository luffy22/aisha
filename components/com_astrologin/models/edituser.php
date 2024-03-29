<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
use Joomla\CMS\MVC\Model\ListModel;
class AstrologinModelEditUser extends ListModel
{
    public function getData()
    {
        $user   = JFactory::getUser();
        $id     = $user->id;
        
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('id','name','email','username')))

                        ->from($db->quoteName('#__users'))
                        ->where($db->quoteName('id').' = '.$db->quote($id));
        $db                  ->setQuery($query);
        $result             = $db->loadAssoc();
        return $result;
    }
    public function updateDetails($user)
    {
        //print_r($user);exit;
        jimport('joomla.user.helper');
        $app                = JFactory::getApplication();
        $u_id               = $user['u_id'];
        $fname              = $user['fname'];
        $uname              = $user['uname'];
        $email              = $user['email'];
        $pwd1               = $user['pwd1'];
        $pwd2               = $user['pwd2'];
        
        $db                 = JFactory::getDbo();       // get database object
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName('username','id'));
        $query              ->from($db->quoteName('#__users'));
        $query              ->where($db->quoteName('username') . ' = ' . $db->quote($uname).' AND '.
                                    $db->quoteName('id').' != '.$db->quote($u_id));
        $db                 ->setQuery($query);$db->execute();
        $count              = $db->getNumRows();
        if($count > 0)
        {
            $msg            = "Username already exists. Please use alternate username";
            $type           = "warning";
            $app            ->redirect(Juri::base().'edit-profile',$msg,$type);
        }
        else
        {
            //echo $u_id;exit;
            if($pwd1 !== $pwd2)
            {
                $msg            = "Passwords do not match!";
                $type           = "warning";
                $app            ->redirect(Juri::base().'edit-profile',$msg,$type);
            }
            else
            {
                if(empty($pwd1))
                {
                    //echo "calls";exit;
                    $query->clear();
                    $fields = array(
                    $db->quoteName('name') . ' = ' . $db->quote($fname),
                    $db->quoteName('username') . ' = '. $db->quote($uname),
                    $db->quoteName('email') . ' = '. $db->quote($email));

                    // If you would like to store NULL value, you should specify that.
                    $conditions = array($db->quoteName('id') . ' = '.$u_id);

                    $query->update($db->quoteName('#__users'))->set($fields)->where($conditions);

                    $db->setQuery($query);

                    $result = $db->execute();
                }
                else
                {
                    $pwd        = JUserHelper::hashPassword($pwd1);

                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    $fields = array(
                    $db->quoteName('name') . ' = ' . $db->quote($fname),
                    $db->quoteName('username') . ' = '. $db->quote($uname),
                    $db->quoteName('email') . ' = '. $db->quote($email),
                    $db->quoteName('password') . ' = '. $db->quote($pwd));

                    // If you would like to store NULL value, you should specify that.
                    $conditions = array($db->quoteName('id') . ' = '.$u_id);

                    $query->update($db->quoteName('#__users'))->set($fields)->where($conditions);

                    $result = $db->execute();

                }
            }
        }
        $query  -> clear();
        $query              ->select($db->quoteName(array('name','username','email')))
                            ->where($db->quoteName('id').'='.$db->quote($u_id))
                            ->from($db->quoteName('#__users'));    
        $db                  ->setQuery($query);
        $data                = $db->loadObject();
        //print_r($data);exit;
        $this->sendMail($data);
        
    }
    protected function sendMail($data)
    {
        //print_r($data);exit;
        $mailer         = JFactory::getMailer();
        $config         = JFactory::getConfig();
        $app            = JFactory::getApplication(); 
        $body           = "";
        $sender         = array(
                                $config->get('mailfrom'),
                                $config->get('fromname')
                                );

        $mailer         ->setSender($sender);
        $recepient      = array($data->email);
        $mailer         ->addRecipient($recepient);
        $mailer 	->addBcc('consult@astroisha.com');
        $subject        = "Astro Isha: User Details Updated";
        $mailer         ->setSubject($subject);
        $body           .= "<p>Hello ".$data->name.",</p>";
        $body           .= "<p>Your user details have been updated. Kindly note below details</p>";
        $body           .= "<p>Name:".$data->name."</p>";
        $body           .= "<p>Username:".$data->username."</p>";
        $body           .= "<p>Email:".$data->email."</p>";
        $body           .= "<p><span style='color:red'>Note: Passwords won't be provided in email to protect your security.</span></p>";
         
        $body           .= "<p>Admin At Astro Isha,<br/>Rohan Desai</p>";
        $mailer->isHtml(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);

        $send = $mailer->Send();
        
        $link       = JUri::base();
        if ( $send !== true ) {
            $msg    = 'Error sending email: Try again and if problem continues contact admin@astroisha.com.';
            $msgType = "error";
            $app->redirect($link, $msg,$msgType);
        } 
        else 
        {
            $msg    =  'Your user details have been updated. Please see email for updated details.';
            $msgType    = "success";
            $app->redirect($link, $msg,$msgType);
        }       
    }  
}
?>
