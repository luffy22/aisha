<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelLocation extends HoroscopeModelLagna
{
    public function addLocation($loc)
    {
		//print_r($loc);exit;
        $location			= $loc['location'];
        $lat				= $loc['lat'];
        $lon				= $loc['lon'];
        $tmz				= $loc['tmz'];
        $redirect 			= $loc['redirect'];
        
        setcookie ('location', $location, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('lat', $lat, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('lon', $lon, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('tmz', $tmz, time() + 60 * 60 * 24 * 30, '/', '', 0);
		
		$app        = JFactory::getApplication();
		if($redirect == "navtara")
		{
		 	$link       = JURI::base();
		}
		else if($redirect == "muhurat")
		{
			$link 		= JURI::base().'muhurat';
		}
		else if($redirect == "calendar")
		{
			$link 		= JURI::base().'calendar';
		}
		$app        ->redirect($link);
         
    }
}
