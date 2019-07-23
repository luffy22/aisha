<?php
defined('_JEXEC') or die('Restricted access');

class AstroLoginViewReadReport extends JViewLegacy
{
    /*
    * Display the extended profile view
    */
    var $order;
    var $ques;
    function display($tpl = null)
    {
        $this->order            = $this->get('Order');
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
