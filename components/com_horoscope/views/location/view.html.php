<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
jimport('joomla.application.component.controller');
/**
 * HTML View class for the HelloWorld Component
 */
class HoroscopeViewLocation extends JViewLegacy
{
    public $data;
    function display($tpl = null) 
    { 
        
        //$this->data		= $this->get('Data');
        $tpl 				= null;
        //echo gettype($this->data);
        parent::display($tpl);        
    }
    
}
