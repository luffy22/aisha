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
    public function checkyogas()
    {
        if(isset($_POST['yogas_submit']))
        {
            $fname  = $_POST['yogas_fname'];$gender     = $_POST['yogas_gender'];
            $dob    = $_POST['yogas_dob'];$pob          = $_POST['yogas_pob'];
            $tob    = $_POST['yogas_tob'];$lon          = $_POST['yogas_lon'];
            $lat    = $_POST['yogas_lat'];$tmz          = $_POST['yogas_tmz'];
            $chart  = $_POST['yogas_chart'];
            if(empty($lat) && empty($lon))
            {
                $tmz        = "none";
                $lon_dir    = $_POST['yogas_lon_dir'];
                $lat_dir    = $_POST['yogas_lat_dir'];
                if($lon_dir == "E"&& $lat_dir=="N")
                {
                    $lon        = $_POST['yogas_lon_deg'].".".$_POST['yogas_lon_min'];
                    $lat        = $_POST['yogas_lat_deg'].".".$_POST['yogas_lat_min'];
                }
                else if($lon_dir == "W" && $lat_dir=="N")
                {
                    $lon        = "-".$_POST['yogas_lon_deg'].".".$_POST['yogas_lon_min'];
                    $lat        = $_POST['yogas_lat_deg'].".".$_POST['yogas_lat_min'];
                }
                else if($lon_dir == "E" && $lat_dir=="S")
                { 
                    $lon        = $_POST['yogas_lon_deg'].".".$_POST['yogas_lon_min'];
                    $lat        = "-".$_POST['yogas_lat_deg'].".".$_POST['yogas_lat_min'];
                }
                else if($lon_dir == "W" && $lat_dir=="S")
                {
                    $lon        = "-".$_POST['yogas_lon_deg'].".".$_POST['yogas_lon_min'];
                    $lat        = "-".$_POST['yogas_lat_deg'].".".$_POST['yogas_lat_min'];
                }
                else
                {
                    $lon        = $_POST['yogas_lon_deg'].".".$_POST['yogas_lon_min'];
                    $lat        = $_POST['yogas_lat_deg'].".".$_POST['yogas_lat_min'];
                }
                
            }
            
            $user_details   = array(
                                    'fname'=>$fname,'gender'=>$gender,'dob'=>$dob,"pob"=>$pob,
                                    'tob'=>$tob,'lon'=>$lon,'lat'=>$lat,'tmz'=>$tmz,"chart"=>$chart
                                    );
            //print_r($user_details);exit;
            $model          = $this->getModel('astroyogas');  // Add the array to model
            $data           = $model->addUserDetails($user_details);
        }
    }
}

