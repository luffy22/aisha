<?php
jimport( 'joomla.application.component.model'); 
class AstroLoginViewChart extends JViewLegacy
{
    public $pagination;
    public $usr;
    public $data;
    public function display($tpl = null)
    {
        $this->usr              = $this->get('UserData');
        $this->data             = $this->get('Data'); 
        $this->pagination       = $this->get('Pagination');
        //print_r($this->usr);exit;
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        else
        {
            $tpl            = null;
        }
       
        parent::display($tpl);
    }
    
}
?>
