<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
use Joomla\CMS\MVC\Model\ListModel;
class AstrologinModelReadPlanet extends ListModel
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
        $type 				= 'life_planets';
        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select('COUNT(*)');
        $query              ->from($db->quoteName('#__order_reports'));
        $query              ->where($db->quoteName('order_id').' = '.$db->quote($order).' AND '.
									$db->quoteName('order_branch').' = '.$db->quote($type));
        $db                  ->setQuery($query);
        $count 				= $db->loadResult();
        //echo $count;exit;
        if($count == "1")
        {
			$query 				->clear();      
			$query              ->select($db->quoteName(array('order_full_text')));
			$query              ->from($db->quoteName('#__order_reports'));
			$query              ->where($db->quoteName('order_id').' = '.$db->quote($order).' AND '.
										$db->quoteName('order_branch').' = '.$db->quote($type));
			$db                  ->setQuery($query);
			$result         = $db->loadAssoc();
			//print_r($result);exit;
			
		}
		else
		{
			//echo "calls2";exit;
			$query 			->clear();
			$query              ->select($db->quoteName(array('order_sub')));
			$query              ->from($db->quoteName('#__order_reports'));
			$query              ->where($db->quoteName('order_id').' = '.$db->quote($order).' AND '.
										$db->quoteName('order_branch').' = '.$db->quote($type));
			$db                  ->setQuery($query);
			$result         = $db->loadColumn();
			//print_r($result);exit;
			
		}
		//print_r($result);exit;
		return $result;
    }
}
