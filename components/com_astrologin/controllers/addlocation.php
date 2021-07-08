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
            $array 		= array("Mysore","Chembur","Mumbai","kolkata","Delhi");
			if(in_array($city, $array) || strpos($city, 'chembur')!== false)
			{
				$app = JFactory::getApplication();
				$link 	= JUri::base().'addlocation';
				$msg    =  'You are not allowed to add this location';
                $msgType    = "warning";
                $app->redirect($redirect, $msg,$msgType);
			}
			
			if($_POST['lat_dir'] == "N")
			{
				$lat    = $_POST['lat_deg'].".".$_POST['lat_min'];
			}
			else if($_POST['lat_dir'] == "S")
			{
				$lat    = "-".$_POST['lat_deg'].".".$_POST['lat_min'];
			}
			if($_POST['lon_dir'] == "E")
			{
				$lon    = $_POST['lon_deg'].".".$_POST['lon_min'];
			}
			else if($_POST['lon_dir'] == "W")
			{
				$lon    = "-".$_POST['lon_deg'].".".$_POST['lon_min'];
			}
		
            //echo $lat." ".$lon;exit;
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
