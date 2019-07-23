<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/controller.php';
class AstrologinControllerTransitReport extends AstroLoginController
{
    public function submitReport()
    { 
        if(isset($_POST['transit_submit']))
        {
            $report_type        = $_POST['transit_report'];
            $fees               = $_POST['transit_final_fees'];
            $currency           = $_POST['transit_currency'];
            $pay_mode           = $_POST['transit_choice'];
            
        }
        $app                    = JFactory::getApplication();
        $app        ->redirect(JUri::base().'transitreport?transit='.$report_type.'&fees='.$fees."_".$currency.'&pay_mode='.$pay_mode);        
        
    }
     public function fillDetails()
    { 
            $transit_type    = $_POST['transit_type'];
            $fees           = $_POST['transit_fees'];
            $currency       = $_POST['transit_currency'];
            $pay_mode       = $_POST['transit_pay_mode'];
            $name           = $_POST['transit_name'];
            $email          = $_POST['transit_email'];
            $gender         = $_POST['transit_gender'];
            $dob            = $_POST['transit_dob'];
            $pob            = $_POST['transit_pob'];
            $tob            = $_POST['transit_time'];
                       
            $details    = array(
                                "type"=>$transit_type,"fees"=>$fees,
                                "currency"=>$currency,"pay_mode"=>$pay_mode,
                                "name"=>$name,"email"=>$email,"gender"=>$gender,
                                "dob"=>$dob,"pob"=>$pob, "tob"=>$tob
                                );
            //print_r($details);exit;
            $model          = $this->getModel('transitreport');  // Add the array to model
            $model->insertDetails($details);
        
    }
    public function fillDetails2()
    {
        $order_id           = $_POST['order_id'];
        $order_type         = $_POST['order_type'];
        $yearly_explain     = $_POST['query_explain'];
        $query_about        = $_POST['query_about'];
        $details            = array("order_id" =>$order_id, "order_type"=>$order_type,
                                    "query_about"=>$query_about,"details_explain" => $yearly_explain);
        //print_r($details);exit;
        $model          = $this->getModel('transitreport');  // Add the array to model
        $model->insertDetails2($details);
    }
    public function fillDetails3()
    {
        $order_id           = $_POST['order_id'];
        $order_type         = $_POST['order_type'];
        $other_explain     = $_POST['query_explain'];
        $other_about        = $_POST['query_other_about'];
        $marriage_about     = $_POST['query_marriage_about'];
        $marriage_explain   = $_POST['query_marriage'];
        $career_about       = $_POST['query_career_about'];
        $career_explain     = $_POST['query_career'];
        $details            = array("order_id" =>$order_id, "order_type"=>$order_type,
                                    "other_about"=>$other_about,"other_explain" => $other_explain,
                                    "marriage_about"=>$marriage_about, "marriage_explain"=>$marriage_explain,
                                    "career_about"=>$career_about,"career_explain"=>$career_explain);
        //print_r($details);exit;
        $model          = $this->getModel('transitreport');  // Add the array to model
        $model->insertDetails3($details);
    }
    public function confirmPayment()
    {
        $id             = $_GET['id'];
        $auth_id        = $_GET['auth_id'];
        $token          = $_GET['token'];
        $details        = array("paypal_id"=>$id,"auth_id"=>$auth_id,"token"=>$token);
        //print_r($details);exit;
        $model          = $this->getModel('transitreport');  // Add the array to model
        $model          ->authorizePayment($details);
    }
    public function failPayment()
    {
        $token          = $_GET['token'];
        $email          = $_GET['email'];
        $status         = $_GET['status'];
        $details        = array("token"=>$token,"email"=>$email,"status"=>$status);
        //print_r($details);exit;
        $model          = $this->getModel('transitreport');  // Add the array to model
        $model          ->failPayment($details);
    }
    public function confirmCCPayment()
    {
        if((isset($_GET['payment']))&&($_GET['payment'] == 'fail'))
        {
            $app           = JFactory::getApplication();
            $link          = JUri::base();
            $msg           = 'You have Cancelled your order.';
            $msgType       = 'error';
            $app           ->redirect($link,$msg,$msgType);
        }
        $token             = $_GET['token'];
        $track_id          = $_GET['track_id'];
        $bank_ref          = $_GET['bank_ref'];
        $status            = $_GET['status'];
        
        $details        = array("token"=>$token,"trackid"=>$track_id,"bankref"=>$bank_ref,"status"=>$status);
        //print_r($details);exit;
        $model          = $this->getModel('transitreport');  // Add the array to model
        $model          ->confirmCCPayment($details);
    }
    
}
?>
