<?php
jimport( 'joomla.application.component.model'); 
class AstroLoginViewEducation extends JViewLegacy
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
			$tpl			= null;
		}
       
        parent::display($tpl);
    }
    
}
?>
