<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
jimport('joomla.application.component.controller');
/**
 * HTML View class for the HelloWorld Component
 */
class HoroscopeViewLagna extends JViewLegacy
{
    public $data;
    function display($tpl = null) 
    {
        $this->data         = $this->get('Login');
        if (count($errors   = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        if(isset($_GET['chart']) && (!empty($this->data)))
        {
            $tpl                = 'lagna';
        }
        else  if(isset($_GET['chart']) && (empty($this->data)))
        {
            $this->data         = array("no_data"=>"Horoscope deleted. Please re-enter details.");
            $tpl                = null;
        }
        else
        {
            $tpl        = null;
        }
        //echo gettype($this->data);
        parent::display($tpl);
    }
}
