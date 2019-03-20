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
class HoroscopeControllerMuhurat extends HoroscopeController
{
    public function getMuhurat()
    {
        if(isset($_POST['muhurat_submit']))
        {
            $location       = $_POST['muhurat_loc'];$lon          = $_POST['muhurat_lon'];
            $lat            = $_POST['muhurat_lat'];$tmz          = $_POST['muhurat_tmz'];
            $date           = $_POST['muhurat_date'];
            // put location details(loc_details) in an array
            $loc_details   = array(
                                     'location'=>$location,'lon'=>$lon,'lat'=>$lat,'tmz'=>$tmz,
                                    "date"=>$date);
            //print_r($loc_details);exit;
            $model          = $this->getModel('muhurat');  // Add the array to model
            $data           = $model->getMuhurat2($loc_details);

            //$view           = $this->getView('mangaldosha','html');
            //$view->data     = $data;
            //$view->display();
        }
    }
    public function getMuhurat2()
    {
        if(!empty($_POST['muhurat_picker']))
        {
            $date           = $_POST['muhurat_picker'];
            $model          = $this->getModel('muhurat');  // Add the array to model
            $model->getMuhurat3($date);
        }
        else {
            $app = JFactory::getApplication();
            $link           = JURI::base().'muhurat';
            // Add a message to the message queue
            $app->enqueueMessage('Please insert a proper date!!', 'warning');
            $app        ->redirect($link);
        }
    }
}