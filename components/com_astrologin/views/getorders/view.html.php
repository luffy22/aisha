<?php
defined('_JEXEC') or die('Restricted access');
class AstroLoginViewGetOrders extends JViewLegacy
{
    /*
    * Display the extended profile view
    */
    var $order;
    var $email;
    var $pagination;
    function display($tpl = null)
    {
        if(isset($_GET['ref'])|| isset($_GET['order']))
        {
            $this->order 			= $this->get('Order');
            $this->pagination 		= $this->get('Pagination');
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
