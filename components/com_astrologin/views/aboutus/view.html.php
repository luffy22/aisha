<?php
class AstroLoginViewAboutUs extends JViewLegacy
{
   public function display($tpl = null)
    {
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        parent::display($tpl);
    }
}
