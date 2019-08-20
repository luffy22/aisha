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
class HoroscopeControllerCareer extends HoroscopeController
{
    public function checkcareer()
    {
        if(isset($_POST['career_submit']))
        {
            $fname  = $_POST['career_fname'];$gender     = $_POST['career_gender'];
            $dob    = $_POST['career_dob'];$pob          = $_POST['career_pob'];
            $tob    = $_POST['career_tob'];$lon          = $_POST['career_lon'];
            $lat    = $_POST['career_lat'];$tmz          = $_POST['career_tmz'];
            $chart  = $_POST['career_chart'];
            if(empty($lat) && empty($lon))
            {
                $tmz        = "none";
                if($career_lon_dir == "E"&& $career_lat_dir=="N")
                {
                    $lon        = $_POST['career_lon_deg'].".".$_POST['career_lon_min'];
                    $lat        = $_POST['career_lat_deg'].".".$_POST['career_lat_min'];
                }
                else if($career_lon_dir == "W" && $career_lat_dir=="N")
                {
                    $lon        = "-".$_POST['career_lon_deg'].".".$_POST['career_lon_min'];
                    $lat        = $_POST['career_lat_deg'].".".$_POST['career_lat_min'];
                }
                else if($career_lon_dir == "E" && $career_lat_dir=="S")
                {
                    $lon        = $_POST['career_lon_deg'].".".$_POST['career_lon_min'];
                    $lat        = "-".$_POST['career_lat_deg'].".".$_POST['career_lat_min'];
                }
                else if($career_lon_dir == "W" && $career_lat_dir=="S")
                {
                    $lon        = "-".$_POST['career_lon_deg'].".".$_POST['career_lon_min'];
                    $lat        = "-".$_POST['career_lat_deg'].".".$_POST['career_lat_min'];
                }
                else
                {
                    $lon        = $_POST['career_lon_deg'].".".$_POST['career_lon_min'];
                    $lat        = $_POST['career_lat_deg'].".".$_POST['career_lat_min'];
                }
                
            }
            $user_details   = array(
                                    'fname'=>$fname,'gender'=>$gender,'dob'=>$dob,"pob"=>$pob,
                                    'tob'=>$tob,'lon'=>$lon,'lat'=>$lat,'tmz'=>$tmz,"chart"=>$chart
                                    );
            //print_r($user_details);exit;
            $model          = $this->getModel('career');  // Add the array to model
            $data           = $model->addCareerDetails($user_details);

            $view           = $this->getView('mangaldosha','html');
            $view->data     = $data;
            $view->display();
        }
    }
}
