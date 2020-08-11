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
class HoroscopeControllerSavings extends HoroscopeController
{
    public function checksavings()
    {
        if(isset($_POST['savings_submit']))
        {
            $fname  = $_POST['savings_fname'];$gender     = $_POST['savings_gender'];
            $dob    = $_POST['savings_dob'];$pob          = $_POST['savings_pob'];
            $tob    = $_POST['savings_tob'];$lon          = $_POST['savings_lon'];
            $lat    = $_POST['savings_lat'];$tmz          = $_POST['savings_tmz'];
            $chart  = $_POST['savings_chart'];
            if(empty($lat) && empty($lon))
            {
                $tmz        = "none";
                $lon_dir    = $_POST['lon_dir'];
                $lat_dir    = $_POST['lat_dir'];
                if($lon_dir == "E"&& $lat_dir=="N")
                {
                    $lon        = $_POST['lon_deg'].".".$_POST['lon_min'];
                    $lat        = $_POST['lat_deg'].".".$_POST['lat_min'];
                }
                else if($lon_dir == "W" && $lat_dir=="N")
                {
                    $lon        = "-".$_POST['lon_deg'].".".$_POST['lon_min'];
                    $lat        = $_POST['lat_deg'].".".$_POST['lat_min'];
                }
                else if($lon_dir == "E" && $lat_dir=="S")
                { 
                    $lon        = $_POST['lon_deg'].".".$_POST['lon_min'];
                    $lat        = "-".$_POST['lat_deg'].".".$_POST['lat_min'];
                }
                else if($lon_dir == "W" && $lat_dir=="S")
                {
                    $lon        = "-".$_POST['lon_deg'].".".$_POST['lon_min'];
                    $lat        = "-".$_POST['lat_deg'].".".$_POST['lat_min'];
                }
                else
                {
                    $lon        = $_POST['lon_deg'].".".$_POST['lon_min'];
                    $lat        = $_POST['lat_deg'].".".$_POST['lat_min'];
                }
                
            }
            
            $user_details   = array(
                                    'fname'=>$fname,'gender'=>$gender,'dob'=>$dob,"pob"=>$pob,
                                    'tob'=>$tob,'lon'=>$lon,'lat'=>$lat,'tmz'=>$tmz,"chart"=>$chart
                                    );
            //print_r($user_details);exit;
            $model          = $this->getModel('savings');  // Add the array to model
            $data           = $model->addUserDetails($user_details);
        }
    }
}

