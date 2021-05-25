<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
jimport('joomla.application.component.controller');
/**
 * HTML View class for the HelloWorld Component
 */
class HoroscopeViewMainChart extends JViewLegacy
{
    public $data;
    function display($tpl = null) 
    {
        $this->data         = $this->get('Data');
        
        if(count($errors   = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        if(isset($_GET['chart']) && (empty($this->data)))
        {
            $app            = JFactory::getApplication();
            $link           = Juri::base().'horoscope?chart='.$_GET['chart'];
            $app->redirect($link);
        }
        else
        {   
            $tpl            = null;
            parent::display($tpl);
        }
        
        //echo gettype($this->data);
       
    }
}
