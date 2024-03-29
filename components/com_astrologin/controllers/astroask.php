<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/controller.php';
class AstrologinControllerAstroask extends AstroLoginController
{
    public function askQuestions()
    { 
            $expert         = $_POST['ques_expert'];
            $ques_type      = $_POST['ques_type'];
            $no_of_ques     = $_POST['ques_no'];
            $fees           = $_POST['ques_fees'];
            $currency       = $_POST['ques_currency'];
            $name           = $_POST['ques_name'];
            $email          = $_POST['ques_email'];
            $gender         = $_POST['ques_gender'];
            $dob            = $_POST['ques_dob'];
            $pob            = $_POST['ques_pob'];
            $tob            = $_POST['ques_time'];
            $pay_mode       = $_POST['ques_pay_mode'];
            
            $details    = array(
                                "expert"=>$expert,"no_of_ques"=>$no_of_ques,"fees"=>$fees,
                                "currency"=>$currency,"ques_type"=>$ques_type,
                                "name"=>$name,"email"=>$email,"gender"=>$gender,"explain"=>$explain,
                                "dob"=>$dob,"pob"=>$pob, "tob"=>$tob,"pay_mode"=>$pay_mode
                                );
            //print_r($details);exit;
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
        $token          = $_GET['token'];
        //$email          = $_GET['email'];
        $status         = $_GET['status'];
        $details        = array("token"=>$token,"status"=>$status);
        //print_r($details);exit;
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
        $status            = $_GET['status'];
        $bank_ref 		   = $_GET['bank_ref'];
        
        $details        = array("token"=>$token,"bank_ref"=>$bank_ref,"trackid"=>$track_id,"status"=>$status);
        //print_r($details);exit;
        $model          = $this->getModel('astroask');  // Add the array to model
        $model          ->confirmCCPayment($details);
    }
    public function askExpert()
    {
        if(isset($_POST['expert_submit']))
        {
            $uname              = $_POST['expert_uname'];
            $ques               = $_POST['expert_max_ques'];
            $ques_type          = $_POST['ques_type'];
            //echo $ques_type;exit;
            if($ques > 3 && $ques_type == "short_ans")
            {
				$app            = JFactory::getApplication();
				$msg            = "Maximum three queries allowed at a time.";
				$type           = "error";
				$app			->enqueueMessage($msg, $msgType);
				$app            ->redirect(Juri::base().'short-ans');
			}
			if($ques > 3 && $ques_type == "long_ans")
            {
				$app            = JFactory::getApplication();
				$msg            = "Maximum three queries allowed at a time.";
				$type           = "error";
				$app			->enqueueMessage($msg, $msgType);
				$app            ->redirect(Juri::base().'long-ans');
			}
            $fees               = $_POST['expert_final_fees'];
            $currency           = $_POST['expert_currency'];
            $pay_mode           = $_POST['expert_choice'];
            
        }
        $app                    = JFactory::getApplication();
        $app        ->redirect(JUri::base().'ask-question?uname='.$uname.'&ques='.$ques.'&type='.$ques_type.'&fees='.$fees."_".$currency.'&pay_mode='.$pay_mode);        
    }
}
?>
