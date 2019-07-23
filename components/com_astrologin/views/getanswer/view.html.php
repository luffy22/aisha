<?php
defined('_JEXEC') or die('Restricted access');

class AstroLoginViewGetAnswer extends JViewLegacy
{
    /*
    * Display the extended profile view
    */
    var $order;
    var $ques;
    var $summary;
    function display($tpl = null)
    {
        $this->order            = $this->get('Order');
        if($this->order->order_type == "long_ans")
        {
            $this->summary      = $this->get('Summary');
        }
        $this->ques             = $this->get('Questions');
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
