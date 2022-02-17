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
class HoroscopeControllerLateMarry extends HoroscopeController
{
    public function findlate()
    {
        if(isset($_POST['latesubmit']))
        {
            $fname  = $_POST['late_fname'];$gender     = $_POST['late_gender'];
            $dob    = $_POST['late_dob'];$pob          = $_POST['late_pob'];
            $tob    = $_POST['late_tob'];$lon          = $_POST['late_lon'];
            $lat    = $_POST['late_lat'];$tmz          = $_POST['late_tmz'];
            $chart  = $_POST['late_chart'];
            if(empty($lat) && empty($lon))
            {
                $tmz        = "none";
                $lon_dir    = $_POST['late_lon_dir'];
                $lat_dir    = $_POST['late_lat_dir'];
                if($lon_dir == "E"&& $lat_dir=="N")
                {
                    $lon        = $_POST['late_lon_deg'].".".$_POST['late_lon_min'];
                    $lat        = $_POST['late_lat_deg'].".".$_POST['late_lat_min'];
                }
                else if($lon_dir == "W" && $lat_dir=="N")
                {
                    $lon        = "-".$_POST['late_lon_deg'].".".$_POST['late_lon_min'];
                    $lat        = $_POST['late_lat_deg'].".".$_POST['late_lat_min'];
                }
                else if($lon_dir == "E" && $lat_dir=="S")
                { 
                    $lon        = $_POST['late_lon_deg'].".".$_POST['late_lon_min'];
                    $lat        = "-".$_POST['late_lat_deg'].".".$_POST['late_lat_min'];
                }
                else if($lon_dir == "W" && $lat_dir=="S")
                {
                    $lon        = "-".$_POST['late_lon_deg'].".".$_POST['late_lon_min'];
                    $lat        = "-".$_POST['late_lat_deg'].".".$_POST['late_lat_min'];
                }
                else
                {
                    $lon        = $_POST['late_lon_deg'].".".$_POST['late_lon_min'];
                    $lat        = $_POST['late_lat_deg'].".".$_POST['late_lat_min'];
                }
                
            }
            
            $user_details   = array(
                                    'fname'=>$fname,'gender'=>$gender,'dob'=>$dob,"pob"=>$pob,
                                    'tob'=>$tob,'lon'=>$lon,'lat'=>$lat,'tmz'=>$tmz,"chart"=>$chart
                                    );
            //print_r($user_details);exit;
            $model          = $this->getModel('latemarry');  // Add the array to model
            $data           = $model->addUser($user_details);
        }
    }
}

