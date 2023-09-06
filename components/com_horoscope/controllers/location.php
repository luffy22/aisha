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
class HoroscopeControllerLocation extends HoroscopeController
{
    public function getLocation()
    {
        if(isset($_POST['muhurat_submit']))
        {
            $location       = $_POST['muhurat_loc'];$lon          = $_POST['muhurat_lon'];
            $lat            = $_POST['muhurat_lat'];$tmz          = $_POST['muhurat_tmz'];
            $redirect		= $_POST['muhurat_redirect'];
            
            // put location details(loc_details) in an array
            $loc_details   = array(
                                     'location'=>$location,'lat'=>$lat,'lon'=>$lon,
									 'tmz'=>$tmz,'redirect'=>$redirect);
            //print_r($loc_details);exit;
            $model          = $this->getModel('location');  // Add the array to model
            $model			->addLocation($loc_details);
            //$view           = $this->getView('mangaldosha','html');
            //$view->data     = $data;
            //$view->display();
        }
    }
    
}
