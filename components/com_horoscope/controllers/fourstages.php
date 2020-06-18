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
class HoroscopeControllerFourStages extends HoroscopeController
{
    public function findstage()
    {
        if(isset($_POST['stage_submit']))
        {
            $fname  = $_POST['stage_fname'];$gender     = $_POST['stage_gender'];
            $dob    = $_POST['stage_dob'];$pob          = $_POST['stage_pob'];
            $tob    = $_POST['stage_tob'];$lon          = $_POST['stage_lon'];
            $lat    = $_POST['stage_lat'];$tmz          = $_POST['stage_tmz'];
            $chart  = $_POST['stage_chart'];
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
            $model          = $this->getModel('fourstages');  // Add the array to model
            $data           = $model->addUserDetails($user_details);
        }
    }
}

