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
class HoroscopeControllerDivorce extends HoroscopeController
{
    public function checkchances()
    {
        if(isset($_POST['divorce_submit']))
        {
            $fname  = $_POST['divorce_fname'];$gender     = $_POST['divorce_gender'];
            $dob    = $_POST['divorce_dob'];$pob          = $_POST['divorce_pob'];
            $tob    = $_POST['divorce_tob'];$lon          = $_POST['divorce_lon'];
            $lat    = $_POST['divorce_lat'];$tmz          = $_POST['divorce_tmz'];
            $chart  = $_POST['divorce_chart'];
            if(empty($lat) && empty($lon))
            {
                $tmz        = "none";
                $divorce_lon_dir    = $_POST['divorce_lon_dir'];
                $divorce_lat_dir    = $_POST['divorce_lat_dir'];
                if($divorce_lon_dir == "E"&& $divorce_lat_dir=="N")
                {
                    $lon        = $_POST['divorce_lon_deg'].".".$_POST['divorce_lon_min'];
                    $lat        = $_POST['divorce_lat_deg'].".".$_POST['divorce_lat_min'];
                }
                else if($divorce_lon_dir == "W" && $divorce_lat_dir=="N")
                {
                    $lon        = "-".$_POST['divorce_lon_deg'].".".$_POST['divorce_lon_min'];
                    $lat        = $_POST['divorce_lat_deg'].".".$_POST['divorce_lat_min'];
                }
                else if($divorce_lon_dir == "E" && $divorce_lat_dir=="S")
                {
                    $lon        = $_POST['divorce_lon_deg'].".".$_POST['divorce_lon_min'];
                    $lat        = "-".$_POST['divorce_lat_deg'].".".$_POST['divorce_lat_min'];
                }
                else if($divorce_lon_dir == "W" && $divorce_lat_dir=="S")
                {
                    $lon        = "-".$_POST['divorce_lon_deg'].".".$_POST['divorce_lon_min'];
                    $lat        = "-".$_POST['divorce_lat_deg'].".".$_POST['divorce_lat_min'];
                }
                else
                {
                    $lon        = $_POST['divorce_lon_deg'].".".$_POST['divorce_lon_min'];
                    $lat        = $_POST['divorce_lat_deg'].".".$_POST['divorce_lat_min'];
                }
                
            }
            $user_details   = array(
                                    'fname'=>$fname,'gender'=>$gender,'dob'=>$dob,"pob"=>$pob,
                                    'tob'=>$tob,'lon'=>$lon,'lat'=>$lat,'tmz'=>$tmz,"chart"=>$chart
                                    );
            //print_r($user_details);exit;
            $model          = $this->getModel('divorce');  // Add the array to model
            $data           = $model->addDivorceDetails($user_details);

            $view           = $this->getView('mangaldosha','html');
            $view->data     = $data;
            $view->display();
        }
    }
}
