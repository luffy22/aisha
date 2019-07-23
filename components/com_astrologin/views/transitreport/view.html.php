<?php
jimport( 'joomla.application.component.model'); 
class AstroLoginViewTransitReport extends JViewLegacy
{
    public $msg;
    public $data;
    public function display($tpl = null)
    {
        $this->msg         = $this->get('Data');
        //print_r($this->msg);exit;
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        if((!empty($this->msg))&&(!isset($_GET['report']))&&(!isset($_GET['fees']))&&(!isset($_GET['pay_mode']))&&
                (!isset($_GET['order_type']))&&(!isset($_GET['uniq_id'])))
        {
            $tpl        = null;
        }
        else if(!empty($this->msg)&&isset($_GET['transit'])&&isset($_GET['fees'])&&isset($_GET['pay_mode']))
        {
             $tpl       = 'details';
        }
        else if(empty($this->msg)&&isset($_GET['transit'])&&isset($_GET['fees'])&&isset($_GET['pay_mode']))
        {
             $tpl       = 'details';
        }
        else if((!empty($this->msg))&&(isset($_GET['uniq_id']))&&(isset($_GET['order_type'])) && ($_GET['order_type'] == 'saturn'
                || $_GET['order_type'] == 'rahu' || $_GET['order_type'] == 'jupiter'))
        {
            $tpl                = 'transit';
        }
       
         else if((!empty($this->msg))&&(isset($_GET['uniq_id']))&&(isset($_GET['order_type'])) && ($_GET['order_type'] == 'saturn'
                || $_GET['order_type'] == 'rahu' || $_GET['order_type'] == 'jupiter'))
        {
            $tpl                = 'transit';
        }
        else
        {
            $tpl                = null;
        }
        parent::display($tpl);
    }
    public function page2($tpl=null)
    {
        //print_r($this->data);exit;
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        if(!empty($this->data))
        {
            $tpl        = 'details';
        }
        else
        {
            $tpl        = null;
        }
        parent::display($tpl);
    }
}
?>
