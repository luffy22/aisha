<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
class AstrologinModelGetOrders extends JModelItem
{
    public function getOrder()
    {	
        $jinput             = JFactory::getApplication()->input;
        $email              = $jinput->get('ref','default_value','string');
        $order              = $jinput->get('order', 'default_value', 'string');

        $db             	= JFactory::getDbo();  // Get db connection
        if($email == 'default_value')
        {
            $query          = $db->getQuery(true);
            $query          ->select($db->quoteName(array('email','UniqueID')))
                            ->from($db->quoteName('#__question_details'))
                            ->where($db->quoteName('UniqueID').' = '.$db->quote($order).' AND '.
                                    $db->quoteName('paid').' = '.$db->quote('yes'));
            $db             ->setQuery($query);
            $result         = $db->loadAssoc();
            $email 			= $result['email'];
            $query 			->clear();unset($result);
        }
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('UniqueID','no_of_ques',
                        'name','email','gender','dob_tob','pob',
                        'order_type','ques_ask_date')))
                                        ->from($db->quoteName('#__question_details'))
                                        ->where($db->quoteName('email').' = '.$db->quote($email).' AND '.
                                                $db->quoteName('paid').' = '.$db->quote('yes'));
        $db                  ->setQuery($query);
        $result         = $db->loadObjectList();
        return $result;
        
    }
   
}
