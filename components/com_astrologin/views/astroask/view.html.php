<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jimport( 'joomla.application.component.model'); 
class AstroLoginViewAstroAsk extends JViewLegacy
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
        if((!empty($this->msg))&&(!isset($_GET['uname']))&&(!isset($_GET['ques']))&&(!isset($_GET['type']))
            && (!isset($_GET['uniq_id']))&&(!isset($_GET['no_of_ques'])))
        {
            $tpl        = null;
        }
        else if(!empty($this->msg)&&isset($_GET['uname'])&&isset($_GET['ques'])&&isset($_GET['type']))
        {
             $tpl       = 'details';
        }
        else if((!empty($this->msg))&&(isset($_GET['uniq_id']))&&(isset($_GET['no_of_ques']))&&(isset($_GET['expert'])))
        {
            $expert             = $_GET['expert'];
            $jinput             = JFactory::getApplication()->input;
            $jinput             ->set('expert',  $expert, 'string');
            $this->data         = $this->get('Expert');
            $tpl                = 'details2';
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
