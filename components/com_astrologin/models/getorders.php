<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Pagination;
class AstrologinModelGetOrders extends ListModel
{
	/**
   * Items total
   * @var integer
   */
	var $_total = null;

  /**
   * Pagination object
   * @var object
   */
	var $_pagination = null;
     public function getOrder()
    {	
        $mainframe          = JFactory::getApplication();
        $jinput             = $mainframe->input;
        $email              = $jinput->get('ref','default_value','string');
        $order              = $jinput->get('order', 'default_value', 'string');
        
        $limit              = $mainframe->getUserStateFromRequest("$option.limit", 'limit', 3, 'int');
        $limitstart         = $mainframe->input->get('limitstart', 0, '', 'uint');
	
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
        $query->order('ques_ask_date DESC');
        $db             ->setQuery($query,$limitstart, $limit);
        $result         = $db->loadObjectList();
        //print_r($result);exit;
        return $result;
        
    }
    public function getTotal()
    {
        $jinput             = JFactory::getApplication()->input;
        $email              = $jinput->get('ref','default_value','string');
        //echo $email;exit;
        $db             	= JFactory::getDbo();  // Get db connection
        $query          	= $db->getQuery(true);
        $query          	->select(array('COUNT(*)'))
                                            ->from($db->quoteName('#__question_details'))
                                            ->where($db->quoteName('email').' = '.$db->quote($email).' AND '.
                                            $db->quoteName('paid').' = '.$db->quote('yes'));
        $db             	->setQuery($query);
        $total      = $db->loadResult();
        //print_r($total);exit;
        return $total;
		
    }
    public function getPagination()
    {
        $mainframe 			= JFactory::getApplication();
        $total 				= $this->getTotal();
        //echo $total;exit;
        // Load the content if it doesn't already exist
        $limit				= $mainframe->getUserStateFromRequest("$option.limit", 'limit', 3, 'int');
        $limitstart			= $mainframe->input->get('limitstart', 0, '', 'uint');
        //echo $limitstart;exit;
        jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $limit);
        //print_r($pagination);exit;
        return $pagination;
    }
   
}
