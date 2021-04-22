<?php
jimport( 'joomla.application.component.model'); 
class AstroLoginViewEditUser extends JViewLegacy
{
    public $data;
    public function display($tpl = null)
    {
        $user = JFactory::getUser();
        if(!empty($user->id))
        {
            $this->data		= $this->get('Data');
        }

        if (count($errors   = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        if(!empty($this->data))
        {
            $tpl                = 'profile';
        }
        else
        {
            $tpl        = null;
        }
        //echo gettype($this->data);
        parent::display($tpl);
    }

}
?>
