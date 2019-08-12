<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/controller.php';
class AstrologinControllerAddlocation extends AstroLoginController
{
    public function addDetails()
    {
        if(isset($_POST['loc_submit']))
        {
            $redirect   = $_POST['loc_redirect'];
            $city       = $_POST['loc_city'];
            $state      = $_POST['loc_state'];
            $country    = $_POST['loc_country'];
            $lat        = $_POST['loc_lat'];
            $lon        = $_POST['loc_lon'];
            if(strpos($lat, "N"))
            {
                $lat 	= str_replace(".N","",$lat);
            }
            else if(strpos($lat,"S"))
            {
                $lat 	= str_replace(".S","",$lat);
                $lat 	= "-".$lat;
            }
            if(strpos($lon, "E"))
            {
                $lon 	= str_replace(".E","",$lon);
            }
            else if(strpos($lon,"W"))
            {
                $lon 	= str_replace(".W","",$lon);
                $lon 	= "-".$lon;
            }
            $details    = array(
                                "city"=>$city,"state"=>$state,"country"=>$country,
                                "lat"=>$lat,"lon"=>$lon,"redirect"=>$redirect
                                );
            //print_r($details);exit;
            $model          = $this->getModel('addlocation');  // Add the array to model
            $model->insertDetails($details);
        }
    }
}
?>
