<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/controller.php';
class AstrologinControllerAstroReport extends AstroLoginController
{
    public function submitReport()
    { 
         if(isset($_POST['report_submit']))
        {
            $report_type        = $_POST['select_report'];
            $fees               = $_POST['report_final_fees'];
            $currency           = $_POST['report_currency'];
            $pay_mode           = $_POST['report_choice'];
            
        }
        $app                    = JFactory::getApplication();
        $app        ->redirect(JUri::base().'get-report?report='.$report_type.'&fees='.$fees."_".$currency.'&pay_mode='.$pay_mode);        
        
    }
     public function fillDetails()
    { 
            $report_type    = $_POST['report_type'];
            $fees           = $_POST['report_fees'];
            $currency       = $_POST['report_currency'];
            $pay_mode       = $_POST['report_pay_mode'];
            $name           = $_POST['report_name'];
            $email          = $_POST['report_email'];
            $gender         = $_POST['report_gender'];
            $dob            = $_POST['report_dob'];
            $pob            = $_POST['report_pob'];
            $tob            = $_POST['report_time'];
            
            
            $details    = array(
                                 "type"=>$report_type,"fees"=>$fees,
                                "currency"=>$currency,"pay_mode"=>$pay_mode,
                                "name"=>$name,"email"=>$email,"gender"=>$gender,"explain"=>$explain,
                                "dob"=>$dob,"pob"=>$pob, "tob"=>$tob
                                );
            print_r($details);exit;
            $model          = $this->getModel('astroask');  // Add the array to model
            $model->insertDetails($details);
        
    }
    public function askQuestions2()
    { 
            $uniq_id        = $_POST['ques_id'];
            $ques_no        = $_POST['ques_no'];
            $ques           = array();
            for($i=1;$i<=$ques_no;$i++)
            {
                ${"ques_select".$i}                 = $_POST['ques_select_'.$i] ;
                ${"ques_".$i}                       = $_POST['ques_'.$i];
                ${"ques_details_".$i}               = $_POST['ques_details_'.$i];
                $ques_new                           = array("select_".$i    =>${"ques_select".$i},
                                                            "ask_".$i       =>${"ques_".$i},
                                                            "details_".$i   =>${"ques_details_".$i});
                $ques                               = array_merge($ques,$ques_new);
                
            }
            //print_r($ques);exit;
            $details                    = array("uniq_id"=>$uniq_id,"ques_no"=>$ques_no);
            $details                    = array_merge($details,$ques);
            //print_r($details);exit;
            $model          = $this->getModel('astroask');  // Add the array to model
            $model          ->insertQuestions($details);
    }
    public function confirmPayment()
    {
        $id             = $_GET['id'];
        $auth_id       = $_GET['auth_id'];
        $token          = $_GET['token'];
        $details        = array("paypal_id"=>$id,"auth_id"=>$auth_id,"token"=>$token);
        $model          = $this->getModel('astroask');  // Add the array to model
        $model          ->authorizePayment($details);
    }
    public function failPayment()
    {
        $token              = $_GET['token'];
        $details        = array("token"=>$token);
        $model          = $this->getModel('astroask');  // Add the array to model
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
        $model          = $this->getModel('astroask');  // Add the array to model
        $model          ->confirmCCPayment($details);
    }
    public function askExpert()
    {
        
    }
}
?>
