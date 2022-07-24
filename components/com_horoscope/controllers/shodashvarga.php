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
class HoroscopeControllerShodashvarga extends HoroscopeController
{
    public function findshodasha()
    {
        if(isset($_POST['shodas_submit']))
        {
            $fname  = $_POST['shodas_fname'];$gender     = $_POST['shodas_gender'];
            $dob    = $_POST['shodas_dob'];$pob          = $_POST['shodas_pob'];
            $tob    = $_POST['shodas_tob'];$lon          = $_POST['shodas_lon'];
            $lat    = $_POST['shodas_lat'];$tmz          = $_POST['shodas_tmz'];
            $chart  = $_POST['shodas_chart'];
            if(empty($lat) && empty($lon))
            {
                $tmz        = "none";
                $lon_dir    = $_POST['shodas_lon_dir'];
                $lat_dir    = $_POST['shodas_lat_dir'];
                if($lon_dir == "E"&& $lat_dir=="N")
                {
                    $lon        = $_POST['shodas_lon_deg'].".".$_POST['shodas_lon_min'];
                    $lat        = $_POST['shodas_lat_deg'].".".$_POST['shodas_lat_min'];
                }
                else if($lon_dir == "W" && $lat_dir=="N")
                {
                    $lon        = "-".$_POST['shodas_lon_deg'].".".$_POST['shodas_lon_min'];
                    $lat        = $_POST['shodas_lat_deg'].".".$_POST['shodas_lat_min'];
                }
                else if($lon_dir == "E" && $lat_dir=="S")
                { 
                    $lon        = $_POST['shodas_lon_deg'].".".$_POST['shodas_lon_min'];
                    $lat        = "-".$_POST['shodas_lat_deg'].".".$_POST['shodas_lat_min'];
                }
                else if($lon_dir == "W" && $lat_dir=="S")
                {
                    $lon        = "-".$_POST['shodas_lon_deg'].".".$_POST['shodas_lon_min'];
                    $lat        = "-".$_POST['shodas_lat_deg'].".".$_POST['shodas_lat_min'];
                }
                else
                {
                    $lon        = $_POST['shodas_lon_deg'].".".$_POST['shodas_lon_min'];
                    $lat        = $_POST['shodas_lat_deg'].".".$_POST['shodas_lat_min'];
                }
                
            }
            
            $user_details   = array(
                                    'fname'=>$fname,'gender'=>$gender,'dob'=>$dob,"pob"=>$pob,
                                    'tob'=>$tob,'lon'=>$lon,'lat'=>$lat,'tmz'=>$tmz,"chart"=>$chart
                                    );
            //print_r($user_details);exit;
            $model          = $this->getModel('shodashvarga');  // Add the array to model
            $data           = $model->addUser($user_details);
        }
    }
}
