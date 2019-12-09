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
class HoroscopeControllerLagna extends HoroscopeController
{
    public function findlagna()
    {
        if(isset($_POST['lagnasubmit']))
        {
            $fname      = $_POST['lagna_fname'];$gender = $_POST['lagna_gender'];
            $dob        = $_POST['lagna_dob'];$pob      = $_POST['lagna_pob'];
            $tob        = $_POST['lagna_tob'];$lon      = $_POST['lagna_lon'];
            $lat        = $_POST['lagna_lat'];$tmz      = $_POST['lagna_tmz'];
            $chart      = $_POST['lagna_chart'];
            if(empty($lat) && empty($lon))
            {
                $tmz        = "none";
                $lon_dir    = $_POST['lon_dir'];
                $lat_dir    = $_POST['lat_dir'];
                //echo $lon_dir." ".$lat_dir;exit;
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
                                    'fname'=>$fname,'gender'=>$gender,'chart'=>$chart,'dob'=>$dob,"pob"=>$pob,
                                    'tob'=>$tob,'lon'=>$lon,'lat'=>$lat,'tmz'=>$tmz
                                    );
            //print_r($user_details);exit;
            $model          = $this->getModel('lagna');  // Add the array to model
            $data           = $model->getLagna($user_details);

            $view           = $this->getView('lagna','html');
            $view->data     = $data;
            $view->display();
            //print_r($data);
        }
        else
        {
            echo JRoute::_('index.php');
        }
        //$model          = &$this->getModel('process');  // Add the array to model
        //$model          ->getLagna();
        //echo "calls";
    }
    public function getascendant()
    {
        $decode     = json_decode($_POST['data']);
        //print_r($decode);
        $user_details   = array(
                                    'fname'=>$decode[0],'gender'=>$decode[1],'dob'=>$decode[2],
                                    'pob'=>$decode[4],'tob'=>$decode[3],
                                    'lat'=>$decode[5],'lon'=>$decode[6],
                                    'tmz'=>$decode[7], 'dst'=>$decode[8]);
        $model          = $this->getModel('lagna');  // Add the array to model
        $data           = $model->getAscendant($user_details);
        $view           = $this->getView('lagna','html');
        $view->data     = $data;
        $view->ascendant();
    }
    public function getdetails()
    {
        $decode     = json_decode($_POST['data']);
        $user_details   = array(
                                    'fname'=>$decode[0],'gender'=>$decode[1],'dob'=>$decode[2],
                                    'pob'=>$decode[4],'tob'=>$decode[3],
                                    'lat'=>$decode[5],'lon'=>$decode[6],
                                    'tmz'=>$decode[7], 'dst'=>$decode[8]
                                );
        $model          = $this->getModel('lagna');  // Add the array to model
        $data           = $model->getLagna($user_details);

        $view           = $this->getView('lagna','html');
        $view->data     = $data;
        $view->display();
    }
    public function getmoon()
    {
        $decode         = json_decode($_POST['data']);
        $user_details   = array(
                                    'fname'=>$decode[0],'gender'=>$decode[1],'dob'=>$decode[2],
                                    'pob'=>$decode[4],'tob'=>$decode[3],
                                    'lat'=>$decode[5],'lon'=>$decode[6],
                                    'tmz'=>$decode[7], 'dst'=>$decode[8]
                                );
        $model          = $this->getModel('lagna');  // Add the array to model
        $data           = $model->getMoon($user_details);
        //print_r($data);
        $view           = $this->getView('lagna','html');
        $view->data     = $data;
        $view->moon();
    }
    public function getnakshatra()
    {
        $decode         = json_decode($_POST['data']);
        $user_details   = array(
                                    'fname'=>$decode[0],'gender'=>$decode[1],'dob'=>$decode[2],
                                    'pob'=>$decode[4],'tob'=>$decode[3],
                                    'lat'=>$decode[5],'lon'=>$decode[6],
                                    'tmz'=>$decode[7], 'dst'=>$decode[8]
                                );
        $model          = $this->getModel('lagna');  // Add the array to model
        $data           = $model->getNakshatra($user_details);
        //print_r($data);
        $view           = $this->getView('lagna','html');
        $view->data     = $data;
        $view->nakshatra();
    }
    
}
?>
