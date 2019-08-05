<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
class AstroLoginModelCall extends JModelItem
{
    public function getData()
    {
        $mailer     = JFactory::getMailer();
        $config     = JFactory::getConfig();
        $app        = JFactory::getApplication(); 
        $body       = "";
        $sender     = array(
                        $config->get('mailfrom'),
                        $config->get('fromname')
                            );

        $mailer     ->setSender($sender);
        $recepient  = 	'99198989727841461@airtelmail.com';
        $mailer     ->addRecipient($recepient);
        $subject    = "Test Sms";
        $mailer     ->setSubject($subject);
        $body       = "";
        $body       .= "<p>This is a test msg from astroisha.com</p>";
        $mailer->isHtml(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);

        $send = $mailer->Send();
       
        if ( $send !== true ) {
           echo "error sending message";
        } 
        else 
        {
            echo 'Sms sent successfully.';
        }   
    }
}