<?php
defined('_JEXEC') or die('Restricted access');

class ExtendedProfileViewDashboard extends JViewLegacy
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
            if((empty($this->msg['membership']))||isset($this->msg['error']))
            {
                $tpl = null;
            }
            else if((!empty($this->msg))&&($this->msg['membership']=='Free'||$this->msg['membership']=='Unpaid'))
            {
                $tpl    = "free";
            }
            else if((!empty($this->msg))&&($this->msg['membership']=='Paid'))
            {
                
                $tpl    = "paid";
            }
            else
            {
                $tpl   = null;
            }
            parent::display($tpl);
	}
}
