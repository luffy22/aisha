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
            $city       = ucfirst($_POST['loc_city']);
            $state      = $_POST['loc_state'];
            $country    = $_POST['loc_country'];
            $ip_addr 	= $_POST['ip_addr'];
            $array 		= array("Mysore","Chembur","Mumbai","kolkata","Delhi","Coimbatore","New Delhi",
                                        "Ahmedabad","Palakkad","Vadodara","Surat","Chandigarh","Amritsar","Sao Paulo",
                                        "Patna","Nagpur");
            if(in_array($city, $array) || strpos($city, 'chembur')!== false || 
                    strpos($city, 'hospital')!== false || strpos($city, 'Hospital')!== false)
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
                                "ip_addr"=>$ip_addr,"lat"=>$lat,"lon"=>$lon,"redirect"=>$redirect
                                );
            //print_r($details);exit;
            $model          = $this->getModel('addlocation');  // Add the array to model
            $model->insertDetails($details);
        }
    }
}
?>
