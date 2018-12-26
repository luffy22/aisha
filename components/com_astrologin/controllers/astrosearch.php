<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/controller.php';
class AstrologinControllerAstrosearch extends AstroLoginController
{
    public function getDetails()
    {
        if(isset($_POST['profile_full']))
        {
            $url        = $_POST['current_url'];
            $user       = $_POST['astro_getuser'];
            $details    = array(
                                    "url"   =>$url, "user"=>$user
                                );
            $model          = $this->getModel('astrosearch');  // Add the array to model
            $data           = $model->getDetails($details);
            $view           = $this->getView('astrosearch','html');
            $view->showDetails($data);
        }
    }
}
?>
