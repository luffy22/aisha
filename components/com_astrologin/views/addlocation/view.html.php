<?php
class AstroLoginViewAddLocation extends JViewLegacy
{
   public function display($tpl = null)
    {
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        $tpl        = null;
        parent::display($tpl);
    }
}
