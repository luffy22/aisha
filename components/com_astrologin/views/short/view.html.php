<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jimport( 'joomla.application.component.model'); 
class AstroLoginViewShort extends JViewLegacy
{
    public $msg;
    public $data;
    public function display($tpl = null)
    {
        $this->msg         = $this->get('Data');
        //print_r($this->msg);exit;
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        else 
        {
			$tpl 			= null;
		}
        parent::display($tpl);
    }
    public function page2($tpl=null)
    {
        //print_r($this->data);exit;
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        if(!empty($this->data))
        {
            $tpl        = 'details';
        }
        else
        {
            $tpl        = null;
        }
        parent::display($tpl);
    }
}
?>
