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
class HoroscopeControllerArrangeLove extends HoroscopeController
{
    public function checktype()
    {
        if(isset($_POST['marry_submit']))
        {
            $fname  = $_POST['marry_fname'];$gender     = $_POST['marry_gender'];
            $dob    = $_POST['marry_dob'];$pob          = $_POST['marry_pob'];
            $tob    = $_POST['marry_tob'];$lon          = $_POST['marry_lon'];
            $lat    = $_POST['marry_lat'];$tmz          = $_POST['marry_tmz'];
            $chart  = $_POST['marry_chart'];
            if(empty($lat) && empty($lon))
            {
                $tmz        = "none";
                $lon_dir    = $_POST['marry_lon_dir'];
                $lat_dir    = $_POST['marry_lat_dir'];
                if($lon_dir == "E"&& $lat_dir=="N")
                {
                    $lon        = $_POST['marry_lon_deg'].".".$_POST['marry_lon_min'];
                    $lat        = $_POST['marry_lat_deg'].".".$_POST['marry_lat_min'];
                }
                else if($lon_dir == "W" && $lat_dir=="N")
                {
                    $lon        = "-".$_POST['marry_lon_deg'].".".$_POST['marry_lon_min'];
                    $lat        = $_POST['marry_lat_deg'].".".$_POST['marry_lat_min'];
                }
                else if($lon_dir == "E" && $lat_dir=="S")
                { 
                    $lon        = $_POST['marry_lon_deg'].".".$_POST['marry_lon_min'];
                    $lat        = "-".$_POST['marry_lat_deg'].".".$_POST['marry_lat_min'];
                }
                else if($lon_dir == "W" && $lat_dir=="S")
                {
                    $lon        = "-".$_POST['marry_lon_deg'].".".$_POST['marry_lon_min'];
                    $lat        = "-".$_POST['marry_lat_deg'].".".$_POST['marry_lat_min'];
                }
                else
                {
                    $lon        = $_POST['marry_lon_deg'].".".$_POST['marry_lon_min'];
                    $lat        = $_POST['marry_lat_deg'].".".$_POST['marry_lat_min'];
                }
                
            }
            
            $user_details   = array(
                                    'fname'=>$fname,'gender'=>$gender,'dob'=>$dob,"pob"=>$pob,
                                    'tob'=>$tob,'lon'=>$lon,'lat'=>$lat,'tmz'=>$tmz,"chart"=>$chart
                                    );
            //print_r($user_details);exit;
            $model          = $this->getModel('arrangelove');  // Add the array to model
            $data           = $model->addUser($user_details);
        }
    }
}

