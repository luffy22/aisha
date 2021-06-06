<?php
class AstrologinModelChart extends JModelItem
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
        $mainframe		= JFactory::getApplication();
        $limit			= $mainframe->getUserStateFromRequest("$option.limit", 'limit', 10, 'int');
        $limitstart		= JRequest::getVar('limitstart', 0, '', 'int');
        $user   = JFactory::getUser();
        $id     = $user->id;

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
        return $result;
    }
    public function getTotal()
    {
        $user               = JFactory::getUser();
        $id                 = $user->id;
        $jinput             = JFactory::getApplication()->input;
        $email              = $jinput->get('ref','default_value','string');

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
        $total 				= self::getTotal();
        //print_r($total);exit;
		// Load the content if it doesn't already exist
        $limit				= $mainframe->getUserStateFromRequest("$option.limit", 'limit',10, 'int');
        $limitstart			= JRequest::getVar('limitstart', 0, '', 'int');
        jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $limit);
        //print_r($pagination);exit;
        return $pagination;
    } 
  }  
?>
