<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/controller.php';
/**
 * Registration controller class for Users.
 *
 * @package     Joomla.Site
 * @subpackage  com_users
 * @since       1.6
 */
class HoroscopeControllerHoroEdit extends HoroscopeController
{
    public function edithoro()
    {
        if(isset($_POST['editsubmit']))
        {
            $uniq_id    = $_POST['edit_uniq_id'];
            $fname      = $_POST['edit_fname'];$gender = $_POST['edit_gender'];
            $place_id   = $_POST['edit_pl_id'];$u_id       = $_POST['edit_user_id'];
            $chart      = $_POST['edit_chart'];$pob     = $_POST['edit_pob'];
            $dob_tob    = $_POST['edit_dob']." ".$_POST['edit_tob'];
            if($_POST['edit_pl_id'] == "0")
            {
                //print_r($user_details);exit;
                $model          = $this->getModel('horoedit');  // Add the array to model
                $data           = $model->notifyUser();
                
            }
            else
            {
                $user_details   = array(
                                    'fname'=>$fname,'gender'=>$gender,'chart'=>$chart,'dob_tob'=>$dob_tob,
                                    'place_id'=>$place_id,'user_id'=>$u_id,'uniq_id'=>$uniq_id
                                    );
                //print_r($user_details);exit;
                $model          = $this->getModel('horoedit');  // Add the array to model
                $data           = $model->editDetails($user_details);
            }

                     //print_r($data);
        }
        else
        {
            echo JRoute::_('index.php');
        }
        //$model          = &$this->getModel('process');  // Add the array to model
        //$model          ->getLagna();
        //echo "calls";
    }
}

