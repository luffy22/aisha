<?php
class AstrologinModelChart extends JModelItem
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
    
  }  
?>
