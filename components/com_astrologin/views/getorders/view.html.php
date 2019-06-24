<?php
defined('_JEXEC') or die('Restricted access');
class AstroLoginViewGetOrders extends JViewLegacy
{
    /*
    * Display the extended profile view
    */
    var $order;
    var $email;
    function display($tpl = null)
    {
        if(isset($_GET['ref'])|| isset($_GET['order']))
        {
            $this->order 			= $this->get('Order');
            //print_r($this->order);exit;
        }
        if(empty($this->order) && empty($this->email))
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
