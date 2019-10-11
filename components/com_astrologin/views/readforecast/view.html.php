<?php
defined('_JEXEC') or die('Restricted access');

class AstroLoginViewReadForecast extends JViewLegacy
{
    /*
    * Display the extended profile view
    */
    var $order;
    var $details;
    function display($tpl = null)
    {
        $this->order            = $this->get('Order');
        $this->details          = $this->get('Details');
        if(empty($this->order))
        {
            $tpl        = null;
        }
        else
        {
			
            $tpl        = "order";
        }
        parent::display($tpl);
    }
}
