<?php
jimport( 'joomla.application.component.model'); 
class AstroLoginViewAstroReport extends JViewLegacy
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
        else if(!empty($this->msg)&&isset($_GET['report'])&&isset($_GET['fees'])&&isset($_GET['pay_mode']))
        {
             $tpl       = 'details';
        }
        else if(empty($this->msg)&&isset($_GET['report'])&&isset($_GET['fees'])&&isset($_GET['pay_mode']))
        {
             $tpl       = 'details';
        }
        else if((!empty($this->msg))&&(isset($_GET['uniq_id']))&&(isset($_GET['order_type'])) && $_GET['order_type'] == 'yearly')
        {
            $tpl                = 'yearly';
        }
       
        else if((empty($this->msg))&&(isset($_GET['uniq_id']))&&(isset($_GET['order_type'])) && $_GET['order_type'] == 'yearly')
        {
            $tpl                = 'yearly';
        }
        else if((!empty($this->msg))&&(isset($_GET['uniq_id']))&&(isset($_GET['order_type'])) && $_GET['order_type'] == 'career')
        {
            $tpl                = 'career';
        }
       
        else if((empty($this->msg))&&(isset($_GET['uniq_id']))&&(isset($_GET['order_type'])) && $_GET['order_type'] == 'career')
        {
            $tpl                = 'career';
        }
         else if((!empty($this->msg))&&(isset($_GET['uniq_id']))&&(isset($_GET['order_type'])) && $_GET['order_type'] == 'marriage')
        {
            $tpl                = 'marriage';
        }
       
        else if((empty($this->msg))&&(isset($_GET['uniq_id']))&&(isset($_GET['order_type'])) && $_GET['order_type'] == 'marriage')
        {
            $tpl                = 'marriage';
        }
        else if((!empty($this->msg))&&(isset($_GET['uniq_id']))&&(isset($_GET['order_type'])) && $_GET['order_type'] == 'life')
        {
            $tpl                = 'life';
        }
       
        else if((empty($this->msg))&&(isset($_GET['uniq_id']))&&(isset($_GET['order_type'])) && $_GET['order_type'] == 'life')
        {
            $tpl                = 'life';
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
