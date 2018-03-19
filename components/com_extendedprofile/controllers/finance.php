<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/controller.php';
class ExtendedProfileControllerFinance extends ExtendedProfileController
{
    public function saveDetails()
    {
        if(isset($_POST['bank_submit']))
        {
            $acc_name               = $_POST['acc_bank'];       
            $acc_number             = $_POST['acc_number'];
            $acc_bank_name          = $_POST['acc_bank_name'];
            $acc_bank_addr          = $_POST['acc_bank_addr'];
            $acc_iban               = $_POST['acc_iban'];
            $acc_swift              = $_POST['acc_swift'];
            $acc_ifsc               = $_POST['acc_ifsc'];
            $acc_paypal             = $_POST['acc_paypal'];
            
            $details                = array( 'acc_name'=>$acc_name, 'acc_number'=>$acc_number,
                                            'acc_bank_name'=>$acc_bank_name, 'acc_bank_addr'=>$acc_bank_addr,
                                            'acc_iban'=>$acc_iban,'acc_swift'=>$acc_swift,'acc_ifsc'=>$acc_ifsc,
                                            'acc_paypal'=>$acc_paypal
                                            );
            $model          = $this->getModel('finance');  // Add the array to model
            $data           = $model->saveDetails($details);
        }
    }
    function paidMember()
    {
        if(isset($_POST['pay_submit']))
        {
            $choice         = $_POST['pay_choice'];
            $currency       = $_POST['pay_currency'];
            $country        = $_POST['pay_country'];
            $amount         = $_POST['pay_amount'];
            $details                = array('pay_choice'=>$choice,'pay_currency'=>$currency,
                                            'pay_amount'=> $amount,'pay_country'=>$country);
            $model          = $this->getModel('finance');  // Add the array to model
            $model->getPaidMembership($details);
        }
    }
    function orderStatus()
    {
        $txnid              = $_GET['txnid'];
        $token              = str_replace("order_","token_", ($_GET['order']));
        $bank_ref           = $_GET['bank_ref'];
        $status             = $_GET['status'];
        $details                = array('txnid'=>$txnid,'token'=>$token,
                                            'bank_ref'=> $bank_ref,'status'=>$status);
        $model          = $this->getModel('finance');  // Add the array to model
        $model->confirmPaymentIn($details);
    }
    public function confirmCCPayment()
    {
        $status             = $_GET['status'];
        $token              = $_GET['token'];
        $email              = $_GET['email'];
        $track_id           = $_GET['track_id'];
        
        if($status      == "Failure"||$status =="Aborted")
        {
            $details        = array('status'=>strtolower($status),'token'=>$token,'email'=>$email,'track_id'=>$track_id);
        }
        else if($status  == "Success")
        {
            $bank_ref       = $_GET['bank_ref'];
            $details        = array('status'=>strtolower($status),'token'=>$token,'email'=>$email,'track_id'=>$track_id,
                                    'bank_ref'=>$bank_ref);
        }
        //print_r($details);exit;
        $model          = $this->getModel('finance');  // Add the array to model
        $model              ->authorizeCCPayment($details);
    }
    public function paypalPayment()
    {
        $status         = $_GET['status'];
        $token          = $_GET['token'];
        if(isset($_GET['sale_id']))
        {
            $sale_id    = $_GET['sale_id'];
        }
        $email          = $_GET['email'];
        if($status == "success")
        {
            $details        = array("status"=>$status, "token"=>$token,"pay_id"=>$sale_id,"email"=>$email);
        }
         else 
        {
            $details        = array("status"=>$status, "token"=>$token,"email"=>$email);
        }
        //print_r($details);exit;
        $model          = $this->getModel('finance');  // Add the array to model
        $model          ->authorizePayment($details);
    }
}