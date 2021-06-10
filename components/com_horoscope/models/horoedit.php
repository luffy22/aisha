<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelHoroEdit extends HoroscopeModelLagna
{
    public function getData()
    {
        $user           = JFactory::getUser();
        $user_id        = $user->id;
        $jinput         = JFactory::getApplication()->input;
        $horo_id        = $jinput->get('edituser', 'default_value', 'filter');
        $horo_id        = str_replace("chart","horo",$horo_id);
        
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.uniq_id','a.fname','a.gender','a.chart_type','a.dob_tob','b.country','b.state','b.city','a.loc_id')))
                        ->from($db->quoteName('#__horo_login','a'))
                        ->join('RIGHT', $db->quoteName('#__location','b').' ON '.$db->quoteName('a.loc_id')." = ".$db->quoteName('b.id'))
                        ->where($db->quoteName('a.user_id').' = '.$db->quote($user_id).' AND '.
                                $db->quoteName('a.uniq_id').' = '.$db->quote($horo_id));
        $db             ->setQuery($query);
        $db->execute();
        $result         = $db->loadObject();
        //print_r($result);exit;
        return $result;
    }
    
    public function editDetails($user)
    {
        //print_r($user);exit;
        $u_id           = $user['user_id'];
        $uniq_id        = $user['uniq_id'];
        $fname          = $user['fname'];
        $gender         = $user['gender'];
        $chart          = $user['chart'];
        $dob_tob        = $user['dob_tob'];
        $place_id       = $user['place_id'];
       
        
        $now            = date('Y-m-d H:i:s');
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $fields         = array($db->quoteName('fname')." = ".$db->quote($fname),
                                $db->quoteName('gender')." = ".$db->quote($gender),
                                $db->quoteName('chart_type')." = ".$db->quote($chart),
                                $db->quoteName('dob_tob')." = ".$db->quote($dob_tob),
                                $db->quoteName('loc_id')." = ".$db->quote($place_id),
                                $db->quoteName('edit_on')." = ".$db->quote($now));
        $conditions = array(
                                $db->quoteName('uniq_id') . ' = '.$db->quote($uniq_id), 
                                $db->quoteName('user_id') . ' = ' . $db->quote($u_id));

        $query->update($db->quoteName('#__horo_login'))->set($fields)->where($conditions);
        // Set the query using our newly populated query object and execute it
        $db             ->setQuery($query);
        $result          = $db->execute();
        $app        = JFactory::getApplication();
        $link       = JURI::base().'charts';
        $app->enqueueMessage('Profile updated successfully.', 'success');
        $app        ->redirect($link);
 
        
    }
    public function notifyUser()
    {
        $app        = JFactory::getApplication();
        $link       = JURI::base().'addlocation?redirect=horologin';
        $app->enqueueMessage("Add location to database to save your chart.", 'warning');
        $app        ->redirect($link);
    }
    public function getDeletion()
    {
        $user           = JFactory::getUser();
        $user_id        = $user->id;
        
        $jinput         = JFactory::getApplication()->input;
        $horo_id        = $jinput->get('deluser', 'default_value', 'filter');
        $horo_id        = str_replace("chart","horo",$horo_id);
        
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // delete all custom keys for user 1001.
        $conditions = array(
                $db->quoteName('user_id') . ' = '.$db->quote($user_id), 
                $db->quoteName('uniq_id') . ' = ' . $db->quote($horo_id)
            );

        $query->delete($db->quoteName('#__horo_login'));
        $query->where($conditions);
        $db->setQuery($query);
        $result = $db->execute();
        
        $app        = JFactory::getApplication();
        $link       = JURI::base().'charts';
        $app->enqueueMessage('Profile deleted successfully.', 'success');
        $app        ->redirect($link);
    }
  }  
?>
