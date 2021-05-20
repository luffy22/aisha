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
class HoroscopeControllerHoroLogin extends HoroscopeController
{
    public function savehoro()
    {
        if(isset($_POST['horosubmit']))
        {
            $fname      = $_POST['horo_fname'];$gender = $_POST['horo_gender'];
            $place_id  = $_POST['horo_pl_id'];$u_id       = $_POST['horo_user_id'];
            $chart      = $_POST['horo_chart'];$pob     = $_POST['horo_pob'];
            $dob_tob    = $_POST['horo_dob']." ".$_POST['horo_tob'];
            if($_POST['horo_pl_id'] == "0")
            {
              
               
                //print_r($user_details);exit;
                $model          = $this->getModel('horologin');  // Add the array to model
                $data           = $model->notifyUser();
                
            }
            else
            {
                $user_details   = array(
                                    'fname'=>$fname,'gender'=>$gender,'chart'=>$chart,'dob_tob'=>$dob_tob,
                                    'place_id'=>$place_id,'user_id'=>$u_id
                                    );
                //print_r($user_details);exit;
                $model          = $this->getModel('horologin');  // Add the array to model
                $data           = $model->getTotal($user_details);
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

