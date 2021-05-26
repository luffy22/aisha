<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelHoroLogin extends HoroscopeModelLagna
{
    public function getData()
    {
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $query          ->select($db->quoteName(array('a.fname','a.gender','a.chart_type','a.dob_tob','b.country','b.state','b.city','b.latitude','b.longitude','c.tmz_words')))
                        ->from($db->quoteName('#__horo_login','a'))
                        ->join('RIGHT', $db->quoteName('#__location','b').' ON '.$db->quoteName('a.loc_id')." = ".$db->quoteName('b.id'))
                        ->join('RIGHT', $db->quoteName('#__timezone','c').' ON '.$db->quoteName('c.tmz_id').' = '.$db->quoteName('b.timezone'))
                        ->where($db->quoteName('a.user_id').' = '.$db->quote($user_id).' AND '.
                                $db->quoteName('a.uniq_id').' = '.$db->quote($horo_id));
        $db             ->setQuery($query);
        $db->execute();
        $result         = $db->loadAssoc();
        return $result;
    }
    public function getTotal($user)
    {
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $u_id           = $user['user_id'];
        //echo $u_id;exit;
        $query              = $db->getQuery(true);
        $query              ->select('COUNT(*)')
                            ->from($db->quoteName('#__horo_login'))
                            ->where($db->quoteName('user_id').' = '.$db->quote($u_id));
        $db                 ->setQuery($query);
        $db                 ->execute();
        $total              = $db->loadResult();
        if($total >= 100)
        {
            $app        = JFactory::getApplication();
            $link       = JURI::base().'charts';
            $app->enqueueMessage('Maximum 100 charts can be added to account', 'warning');
            $app        ->redirect($link);
        }
        else
        {
            $this->saveDetails($user);
        }
    }
    public function saveDetails($user)
    {
        //print_r($user);exit;
        $u_id           = $user['user_id'];
        $fname          = $user['fname'];
        $gender         = $user['gender'];
        $chart          = $user['chart'];
        $dob_tob        = $user['dob_tob'];
        $place_id       = $user['place_id'];
       
        $uniq_id        = uniqid('horo_');
        $now            = date('Y-m-d H:i:s');
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        $columns        = array('uniq_id','user_id','fname','gender','chart_type','dob_tob','loc_id','added_on');
        $values         = array($db->quote($uniq_id),$db->quote($u_id),$db->quote($fname),$db->quote($gender),$db->quote($chart),$db->quote($dob_tob),
                                $db->quote($place_id),$db->quote($now));
        $query          ->insert($db->quoteName('#__horo_login'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it
        $db             ->setQuery($query);
        $result          = $db->query();
        if($result)
        {
            $app        = JFactory::getApplication();
            $link       = JURI::base().'charts';
            $app->enqueueMessage('Profile added successfully.', 'success');
            $app        ->redirect($link);
        }
        
    }
    public function notifyUser()
    {
        $app        = JFactory::getApplication();
        $link       = JURI::base().'addlocation?redirect=horologin';
        $app->enqueueMessage("Add location to database to save your chart.", 'warning');
        $app        ->redirect($link);
    }
    
  }  
?>
