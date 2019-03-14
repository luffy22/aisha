<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
jimport('joomla.application.component.controller');
/**
 * HTML View class for the HelloWorld Component
 */
class HoroscopeViewMuhurat extends JViewLegacy
{
    public $data;
    function display($tpl = null) 
    { 
        
        if (count($errors   = $this->get('Errors')))
        {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
        }
        $this->data		= $this->get('Data');
        $tpl 				= null;
        //echo gettype($this->data);
        parent::display($tpl);        
    }
    
}