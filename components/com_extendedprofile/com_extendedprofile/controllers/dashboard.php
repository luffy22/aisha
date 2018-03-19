<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/controller.php';
class ExtendedProfileControllerDashboard extends ExtendedProfileController
{
    public function confirmPayment()
    {
        $status         = $_GET['status'];
        $token          = $_GET['token'];
        $uid            = $_GET['uid'];
        if(isset($_GET['sale_id']))
        {
            $sale_id    = $_GET['sale_id'];
        }
        $email          = $_GET['email'];
        if($status == "success")
        {
            $details        = array("status"=>$status, "token"=>$token,"pay_id"=>$sale_id,"email"=>$email,"uid"=>$uid);
        }
         else 
        {
            $details        = array("status"=>$status, "token"=>$token,"email"=>$email,"uid"=>$uid);
        }
        $model          = $this->getModel('dashboard');  // Add the array to model
        $model          ->authorizePayment($details);
    }
    
}