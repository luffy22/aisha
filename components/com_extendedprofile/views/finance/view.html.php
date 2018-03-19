<?php
defined('_JEXEC') or die('Restricted access');

class ExtendedProfileViewFinance extends JViewLegacy
{
    /*
    * Display the extended profile view
    */
    public $msg;
    function display($tpl = null)
	{
            $this->msg = $this->get('Data');
            parent::display($tpl);
	}
}
