<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
use Joomla\CMS\MVC\Model\ListModel;
class AstrologinModelChart extends ListModel
{
    public function getUserData()
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
    public function getData()
    {
        $mainframe 			= JFactory::getApplication();
        $jinput             = $mainframe->input;
        
        $limit				= $mainframe->getUserStateFromRequest("$option.limit", 'limit', 10, 'int');
        $limitstart			= $mainframe->input->get('limitstart', 0, '', 'uint');
        $user   = JFactory::getUser();
        $id     = $user->id;
        //echo $id;exit;
        $db             = JFactory::getDbo();
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.uniq_id','a.fname','a.dob_tob','b.city','c.tmz_words')))
                        ->from($db->quoteName('#__horo_login','a'))
                        ->join('RIGHT', $db->quoteName('#__location','b').' ON '.$db->quoteName('a.loc_id')." = ".$db->quoteName('b.id'))
                        ->join('RIGHT', $db->quoteName('#__timezone','c').' ON '.$db->quoteName('c.tmz_id').' = '.$db->quoteName('b.timezone'))
                        ->where($db->quoteName('user_id').' = '.$db->quote($id));
        $query          ->order('Horo_ID ASC');
        $db             ->setQuery($query,$limitstart, $limit);
        $result             = $db->loadObjectList();
        //print_r($result);exit;
        return $result;
    }
    public function getTotal()
    {
        $user               = JFactory::getUser();
        $id                 = $user->id;

        $db                 = JFactory::getDbo();  // Get db connection
        $query              = $db->getQuery(true);
        $query              ->select(array('COUNT(*)'))
                            ->from($db->quoteName('#__horo_login'))
                            ->where($db->quoteName('user_id').' = '.$db->quote($id));
        $db                 ->setQuery($query);
        $total              = $db->loadResult();
        return $total;
		
    }  
    public function getPagination()
    {
        $mainframe 			= JFactory::getApplication();
        $total 				= $this->getTotal();
        // Load the content if it doesn't already exist
        $limit				= $mainframe->getUserStateFromRequest("$option.limit", 'limit', 10, 'int');
        $limitstart			= $mainframe->input->get('limitstart', 0, '', 'uint');
        jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $limit);
        //print_r($pagination);exit;
        return $pagination;
    } 
  }  
?>
