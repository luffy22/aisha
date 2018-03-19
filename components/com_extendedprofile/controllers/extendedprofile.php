<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/controller.php';
class ExtendedProfileControllerExtendedProfile extends ExtendedProfileController
{
    public function registerAstro()
    {
        $link       = JURI::base().'dashboard';
        $type       = "error";
        $mainframes = JFactory::getApplication();
        if(isset($_POST['submit_profile']))
        {
            $phone          = $_POST['astro_phone'];
            $mobile         = $_POST['astro_mobile'];
            $city           = $_POST['astro_city'];
            $state          = $_POST['astro_state'];
            $country        = $_POST['astro_country'];
            $sub_exp        = $_POST['astro_subexpert'];
            $detail         = $_POST['astro_detail'];
            $terms          = $_POST['astro_terms'];
            if(empty($sub_exp))
            {
                $msg        = "Please select one or more expertise to register with Astro Isha.";
                $mainframes->redirect($link, $msg,$type);
            }
            if(empty($detail)|| str_word_count($detail)<25 || str_word_count($detail)>750 || strlen($detail)> 10000)
            {
                $msg        = "Description is mandatory. Minimum 25 Words and maximum 750 Words and 10,000 Characters allowed.";
                 $mainframes->redirect($link, $msg,$type);
            }
            if($terms !== "yes")
            {
                $msg        = "Please accept the Terms and Conditions";
                 $mainframes->redirect($link, $msg,$type);
            }
           else
           {
               $user_details   = array(
                                        'city'=>$city,
                                        'state'=>$state,'country'=>$country,
                                        'phone'=>$phone,'mobile'=>$mobile,
                                        'sub_exp'=>$sub_exp,
                                        'detail'=>$detail,'terms'=>$terms
                                    );
            $model          = $this->getModel('extendedprofile');  // Add the array to model
            $data           = $model->saveUser($user_details);
               
           }
                
        }
    }
    
    public function saveAstro()
    {
        $id         = $_POST['profile_id'];
        $img        = $_FILES['astro_img']['name'];$img_type    = $_FILES['astro_img']['type'];
        $tmp        = $_FILES['astro_img']['tmp_name'];
        $img_size   = round((filesize($_FILES['astro_img']['tmp_name'])/1024),2);
        $addr1        = $_POST['astro_addr1'];
        $addr2      = $_POST['astro_addr2'];$city       = $_POST['astro_city'];
        $state      = $_POST['astro_state'];$country    = $_POST['astro_country'];
        $pcode      = $_POST['astro_pcode'];
        if(empty($_POST['astro_code'])&& empty($_POST['astro_phone']))
        {
            $phone  = "";
        }
        else
        {
            $phone      = $_POST['astro_code'].'-'.$_POST['astro_phone'];
        }
        $mobile     = $_POST['astro_mobile'];
        if(!empty($_POST['astro_whatsapp'])){$whatsapp="yes";}else{$whatsapp="no";};
        $website   = $_POST['astro_web'];$info          = $_POST['astro_info'];
        
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
        $detectedType = exif_imagetype($_FILES['astro_img']['tmp_name']);
        $error = !in_array($detectedType, $allowedTypes);
         
        if($error)
        {
            $url = JURi::base().'details?image=false';
            $this->directUrl($url);
        }
        else if($img_size >= 2048)
        {
            $url = JRi::base().'details?image=size';
            $this->directUrl($url);
        }
        else
        {
               //echo $tmp;exit;
            $user_details   = array(
                                        'id'=>$id,'img_name'=>$img,'tmp_name'=>$tmp,
                                    'addr1'=>$addr1,'addr2'=>$addr2, 'city'=>$city,
                                    'state'=>$state,'country'=>$country,'pcode'=>$pcode,
                                    'phone'=>$phone,'mobile'=>$mobile,'whatsapp'=>$whatsapp,
                                    'website'=>$website,'info'=>$info
                                    );
            $model          = $this->getModel('extendedprofile');  // Add the array to model
            $data           = $model->saveAstro($user_details);
        }
    }
    public function updateAstro()
    {
        $id         = $_POST['profile_id'];$status      = $_POST['astro_status'];
        $addr1        = $_POST['astro_addr1'];
        $addr2      = $_POST['astro_addr2'];$city       = $_POST['astro_city'];
        $state      = $_POST['astro_state'];$country    = $_POST['astro_country'];
        $pcode      = $_POST['astro_pcode'];$fb_page    = $_POST['astro_fb'];
        $gplus_page = $_POST['astro_gplus'];$tweet_page = $_POST['astro_tweet'];
    
        if(empty($_POST['astro_code'])&& empty($_POST['astro_phone']))
        {
            $phone  = "";
        }
        else
        {
            $phone      = $_POST['astro_code'].'-'.$_POST['astro_phone'];
        }
        $mobile     = $_POST['astro_mobile'];
        if(!empty($_POST['astro_whatsapp'])){$whatsapp="yes";}else{$whatsapp="no";};
        $website   = $_POST['astro_web'];$info          = $_POST['astro_info'];
        
        $user_details   = array(
                                    'id'=>$id,'status'=>$status,
                                'addr1'=>$addr1,'addr2'=>$addr2, 'city'=>$city,
                                'state'=>$state,'country'=>$country,'pcode'=>$pcode,
                                'phone'=>$phone,'mobile'=>$mobile,'whatsapp'=>$whatsapp,
                                'website'=>$website,'fb_page'=>$fb_page,
                                'gplus'=>$gplus_page, 'tweet'=> $tweet_page,'info'=>$info
                                );
        $model          = $this->getModel('extendedprofile');  // Add the array to model
        $data           = $model->updateAstro($user_details);
    }

}
