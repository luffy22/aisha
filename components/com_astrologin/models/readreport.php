<?php

defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
class AstrologinModelReadReport extends JModelItem
{
    function getDetails()
    {
        $jinput             = JFactory::getApplication()->input;
        $order              = $jinput->get('order', 'default_value', 'string');
        //echo $order;exit;
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.UniqueID','a.expert_id','a.fees',
                                        'a.currency', 'a.paid', 'a.pay_mode','a.name',
                                        'a.email','a.gender','a.dob_tob','a.pob','a.order_type', 
                                        'a.ques_ask_date')))

                        ->from($db->quoteName('#__question_details','a'))
                        ->where($db->quoteName('a.UniqueID').' = '.$db->quote($order));
        $db                  ->setQuery($query);
        $result1         = $db->loadObject();
        //print_r($result1);exit;
        return $result1;
    }
    function getOrder()
    {
        $jinput             = JFactory::getApplication()->input;
        $order              = $jinput->get('order', 'default_value', 'string');
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select($db->quoteName(array('b.query_about','b.query_explain','a.order_full_text',
                                                            'b.query_answer','c.summary_full_text')));
        $query              ->from($db->quoteName('#__order_reports','a'));
        $query          ->join('RIGHT', $db->quoteName('#__order_queries','b'). ' ON (' . $db->quoteName('a.order_id').' = '.$db->quoteName('b.order_id') . ')');
        $query          ->join('RIGHT', $db->quoteName('#__order_summary','c'). ' ON (' . $db->quoteName('a.order_id').' = '.$db->quoteName('c.order_id') . ')');
        $query              ->where($db->quoteName('a.order_id').' = '.$db->quote($order));
        $db                  ->setQuery($query);
        $result         = $db->loadObjectList();
        //print_r($result);exit;
        return $result;
    }
}
