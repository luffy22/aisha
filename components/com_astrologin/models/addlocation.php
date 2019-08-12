<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
class AstroLoginModelAddlocation extends JModelItem
{
    public function insertDetails($details)
    {
        //print_r($details);
        $app                = JFactory::getApplication();
        $city               = $details['city'];
        $state              = $details['state'];
        $country            = $details['country'];
        $lat                = $details['lat'];
        $lon                = $details['lon'];
        $redirect           = $details['redirect'];
        
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
         $columns        = array('city','state','country','latitude','longitude');
        $values         = array(
                                $db->quote($city),$db->quote($state),$db->quote($country),
                                $db->quote($lat),$db->quote($lon));
        // Prepare the insert query
        $query          ->insert($db->quoteName('#__location'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
        $db             ->setQuery($query);
        $result          = $db->query();
        if($result)
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
            $recepient  = array($data->email);
            $mailer     ->addRecipient('admin@astroisha.com');
            $subject    = "New Location Added";
            $mailer     ->setSubject($subject);
            $body       .= "<p>Location Details</p>";
            $body       .= "<p>City: ".$city."</p>";
            $body       .= "<p>State: ".$state."</p>";
            $body       .= "<p>Country: ".$country."</p>"; 
            $body       .= "<p>Latitude: ".$lat."</p>";
            $body       .= "<p>Longitude: ".$lon."</p>";
            
            $mailer->isHtml(true);
            $mailer->Encoding = 'base64';
            $mailer->setBody($body);

            $send = $mailer->Send();
            
            if ( $send !== true ) {
             $app->redirect($link);
            } 
            else 
            {
                $msg    =  'Location added successfully';
                $msgType    = "success";
                $app->redirect($redirect, $msg,$msgType);
            }        

        }
        
    }
}
