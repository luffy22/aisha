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
class HoroscopeControllerMangalDosha extends HoroscopeController
{
    public function mdosha()
    {
        if(isset($_POST['mdosha_submit']))
        {
            $fname  = $_POST['mdosha_fname'];$gender     = $_POST['mdosha_gender'];
            $dob    = $_POST['mdosha_dob'];$pob          = $_POST['mdosha_pob'];
            $tob    = $_POST['mdosha_tob'];$lon          = $_POST['mdosha_lon'];
            $lat    = $_POST['mdosha_lat'];$tmz          = $_POST['mdosha_tmz'];
			if(empty($lat) && empty($lon))
            {
                $tmz        = "none";
                $lon_dir    = $_POST['mdosha_lon_dir'];
                $lat_dir    = $_POST['mdosha_lat_dir'];
                if($lon_dir == "E"&& $mdosha_dir=="N")
                {
                    $lon        = $_POST['mdosha_lon_deg'].".".$_POST['mdosha_lon_min'];
                    $lat        = $_POST['mdosha_lat_deg'].".".$_POST['mdosha_lat_min'];
                }
                else if($lon_dir == "W" && $mdosha_dir=="N")
                {
                    $lon        = "-".$_POST['mdosha_lon_deg'].".".$_POST['mdosha_lon_min'];
                    $lat        = $_POST['mdosha_lat_deg'].".".$_POST['mdosha_lat_min'];
                }
                else if($lon_dir == "E" && $mdosha_dir=="S")
                {
                    $lon        = $_POST['mdosha_lon_deg'].".".$_POST['mdosha_lon_min'];
                    $lat        = "-".$_POST['mdosha_lat_deg'].".".$_POST['mdosha_lat_min'];
                }
                else if($lon_dir == "W" && $mdosha_dir=="S")
                {
                    $lon        = "-".$_POST['mdosha_lon_deg'].".".$_POST['mdosha_lon_min'];
                    $lat        = "-".$_POST['mdosha_lat_deg'].".".$_POST['mdosha_lat_min'];
                }
                else
                {
                    $lon        = $_POST['mdosha_lon_deg'].".".$_POST['mdosha_lon_min'];
                    $lat        = $_POST['mdosha_lat_deg'].".".$_POST['mdosha_lat_min'];
                }
                
            }
            $user_details   = array(
                                    'fname'=>$fname,'gender'=>$gender,'dob'=>$dob,"pob"=>$pob,
                                    'tob'=>$tob,'lon'=>$lon,'lat'=>$lat,'tmz'=>$tmz
                                    );
            //print_r($user_details);exit;
            $model          = $this->getModel('mangaldosha');  // Add the array to model
            $data           = $model->mangalDosha($user_details);

            $view           = $this->getView('mangaldosha','html');
            $view->data     = $data;
            $view->display();
        }
    }
}
