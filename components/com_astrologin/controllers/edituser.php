<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/controller.php';
class AstrologinControllerEditUser extends AstroLoginController
{
    public function editdetails()
    {
        $u_id           = $_POST['edit_uid'];
        $fname          = $_POST['edit_fname'];
        $uname          = $_POST['edit_uname'];
        $email          = $_POST['edit_email'];
        $pwd1           = $_POST['edit_pwd1'];
        $pwd2           = $_POST['edit_pwd2'];
        $details    = array("u_id"=>$u_id,"fname"=>$fname,"uname"=>$uname,
                            "email"=>$email,"pwd1"=>$pwd1,"pwd2"=>$pwd2);
        
        $model          = $this->getModel('edituser');  // Add the array to model
        $model          ->updateDetails($details);
    }
}  