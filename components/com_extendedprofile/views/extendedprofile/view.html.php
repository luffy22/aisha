<?php
defined('_JEXEC') or die('Restricted access');

class ExtendedProfileViewExtendedProfile extends JViewLegacy
{
    /*
    * Display the extended profile view
    */
    public $msg;
    function display($tpl = null)
	{
            // Assign data to the view
            $this->msg = $this->get('Data');
            //print_r($this->msg);exit;
            if(empty($this->msg))
            {
                $app =& JFactory::getApplication();
                $link   = JURI::base().'dashboard';
                $msg    = "No Data Found For User. Kindly select membership type before proceding";
                $app->redirect($link, $msg);
            }
            
            else
            {
                $tpl    = "astro";
            }
            parent::display($tpl);
	}
}