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
class HoroscopeControllerFindSpouse extends HoroscopeController
{
    public function findspouse()
    {
        if(isset($_POST['fspouse_submit']))
        {
            $fname  = $_POST['fspouse_fname'];$gender     = $_POST['fspouse_gender'];
            $dob    = $_POST['fspouse_dob'];$pob          = $_POST['fspouse_pob'];
            $tob    = $_POST['fspouse_tob'];$lon          = $_POST['fspouse_lon'];
            $lat    = $_POST['fspouse_lat'];$tmz          = $_POST['fspouse_tmz'];
            if(empty($lat) && empty($lon))
            {
                $tmz        = "none";
                if($fspouse_lon_dir=="E"&& $fspouse_lat_dir=="N")
                {
                    $lon        = $_POST['fspouse_lon_deg'].".".$_POST['fspouse_lon_min'];
                    $lat        = $_POST['fspouse_lat_deg'].".".$_POST['fspouse_lat_min'];
                }
                else if($fspouse_lon_dir=="W"&& $fspouse_lat_dir=="N")
                {
                    $lon        = "-".$_POST['fspouse_lon_deg'].".".$_POST['fspouse_lon_min'];
                    $lat        = $_POST['fspouse_lat_deg'].".".$_POST['fspouse_lat_min'];
                }
                else if($fspouse_lon_dir=="E"&& $fspouse_lat_dir=="S")
                {
                    $lon        = $_POST['fspouse_lon_deg'].".".$_POST['fspouse_lon_min'];
                    $lat        = "-".$_POST['fspouse_lat_deg'].".".$_POST['fspouse_lat_min'];
                }
                else if($fspouse_lon_dir=="W"&& $fspouse_lat_dir=="S")
                {
                    $lon        = "-".$_POST['fspouse_lon_deg'].".".$_POST['fspouse_lon_min'];
                    $lat        = "-".$_POST['fspouse_lat_deg'].".".$_POST['fspouse_lat_min'];
                }
                else
                {
                    $lon        = $_POST['fspouse_lon_deg'].".".$_POST['fspouse_lon_min'];
                    $lat        = $_POST['fspouse_lat_deg'].".".$_POST['fspouse_lat_min'];
                }
                
            }
            $user_details   = array(
                                    'fname'=>$fname,'gender'=>$gender,'dob'=>$dob,"pob"=>$pob,
                                    'tob'=>$tob,'lon'=>$lon,'lat'=>$lat,'tmz'=>$tmz
                                    );
            //print_r($user_details);exit;
            $model          = $this->getModel('findspouse');  // Add the array to model
            $data           = $model->findspouse($user_details);

            $view           = $this->getView('findspouse','html');
            $view->data     = $data;
            $view->display();
        }
    }
}