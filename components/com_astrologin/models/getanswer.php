<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
use Joomla\CMS\MVC\Model\ListModel;
class AstrologinModelGetAnswer extends ListModel
{
    function getOrder()
    {
        $jinput             = JFactory::getApplication()->input;
        $order              = $jinput->get('order', 'default_value', 'string');
        
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.UniqueID','a.expert_id','a.no_of_ques','a.fees',
                                        'a.currency', 'a.paid', 'a.pay_mode','a.name',
                                        'a.email','a.gender','a.dob_tob','a.pob','a.order_type', 
                                        'a.ques_ask_date')))

                        ->from($db->quoteName('#__question_details','a'))
                        ->where($db->quoteName('a.UniqueID').' = '.$db->quote($order));
        $db                  ->setQuery($query);
        $result         = $db->loadObject();
        //print_r($result);exit;
        return $result;
    }
    function getQuestions()
    {
        $jinput             = JFactory::getApplication()->input;
        $order              = $jinput->get('order', 'default_value', 'string');
        
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName(array('order_id','ques_topic','ques_ask','ques_details','ques_answer')));
        $query              ->from($db->quoteName('#__question'));
        $query              ->where($db->quoteName('order_id').' = '.$db->quote($order));
        $db                  ->setQuery($query);
        $result         = $db->loadObjectList();
        //print_r($result);exit;
        return $result;
    }
    function getSummary()
    {
        $jinput             = JFactory::getApplication()->input;
        $order              = $jinput->get('order', 'default_value', 'string');
        
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName('summary_txt'));
        $query              ->from($db->quoteName('#__question_summary'));
        $query              ->where($db->quoteName('order_id').' = '.$db->quote($order));
        $db                  ->setQuery($query);
        $result         = $db->loadObject();
        //print_r($result);exit;
        return $result;
    }
}
