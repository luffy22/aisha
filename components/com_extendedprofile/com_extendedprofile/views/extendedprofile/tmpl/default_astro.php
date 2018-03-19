 <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
 <script>
  tinymce.init({
    selector: '#astro_info',
    plugins: "wordcount autolink",
    menubar: false
  });
  </script>

<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($this->msg);exit;
$user = JFactory::getUser();
if($user->guest)
{
    $location   = JURi::base()."login";
    echo header('Location: '.$location);
}
?>
<h3>Enter Details</h3>
<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Fields marked with asterix(*) are compulsory</div>
<div class="form-group"><label>Name:</label> <?php echo $user->name;; ?></div>
<form enctype="multipart/form-data" method="post" action="<?php echo JRoute::_('index.php?option=com_extendedprofile&task=extendedprofile.updateAstro'); ?>">
<input type="hidden" value="<?php echo $this->msg['UserId'] ?>" name="profile_id" />

<div class="form-group">
    <label for="astro_address1">Profile Status: </label>
    <select name="astro_status" id="astro_status" class="form-control">
    <?php if(empty($this->msg['profile_status'])) { ?>
        <option value="visible" selected>Visible <i class="fa fa-eye" aria-hidden="true"></i></option>
        <option value="hidden">Hidden <i class="fa fa-eye-slash" aria-hidden="true"></i></option>
   <?php }else if($this->msg['profile_status'] == 'visible'){
   ?>
        <option value="visible" selected>Visible <i class="fa fa-eye" aria-hidden="true"></i></option>
        <option value="hidden">Hidden <i class="fa fa-eye-slash" aria-hidden="true"></i></option>
        <?php
           }
           else if($this->msg['profile_status'] == 'hidden')
           {
        ?>
            <option value="hidden" selected>Hidden <i class="fa fa-eye-slash" aria-hidden="true"></i></option>
            <option value="visible">Visible <i class="fa fa-eye" aria-hidden="true"></i></option>
        <?php
           }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="astro_address1">Address Line 1: </label>
    <?php if(empty($this->msg['addr_1'])) { ?>
    <input type="text" class="form-control" name="astro_addr1" id="astro_addr1" placeholder="Enter Address of Office or Home" />
    <?php } else{ ?>
    <input type="text" class="form-control" name="astro_addr1" id="astro_addr1" value="<?php echo $this->msg['addr_1'] ?>" />
    <?php
    }
    ?>
</div>
<div class="form-group">
    <label for="astro_address2">Address Line 2: </label>
    <?php if(empty($this->msg['addr_1'])) { ?>    
    <input type="text" class="form-control" name="astro_addr2" id="astro_addr2" placeholder="Enter Related Address Details" />
    <?php } else{ ?>
    <input type="text" class="form-control" name="astro_addr2" id="astro_addr2" value="<?php echo $this->msg['addr_2'] ?>" />
    <?php
    }
    ?>
</div>
<div class="form-group">
    <label for="astro_city">City*: </label>
    <?php if(empty($this->msg['city'])) { ?>    
    <input type="text" class="form-control" name="astro_city" id="astro_city" placeholder="Enter City Name" required />
    <?php } else{ ?>
    <input type="text" class="form-control" name="astro_city" id="astro_city" value="<?php echo $this->msg['city'] ?>" required />
    <?php
    }
    ?>
</div>
<div class="form-group">
    <label for="astro_state">State/Province/Region: </label>
    <?php if(empty($this->msg['state'])) { ?>  
    <input type="text" class="form-control" name="astro_state" id="astro_state" placeholder="Enter Name of State/Province/Region" />
    <?php } else{ ?>
    <input type="text" class="form-control" name="astro_state" id="astro_state" value="<?php echo $this->msg['state'] ?>"  />
    <?php
    }
    ?>
</div>
<div class="form-group">
    <label for="astro_state">Country*: </label>
    <?php if(empty($this->msg['state'])) { ?>  
    <input type="text" class="form-control" name="astro_country" id="astro_country" placeholder="Enter Name of Country" required/>
    <?php } else{ ?>
    <input type="text" class="form-control" name="astro_country" id="astro_country" value="<?php echo $this->msg['country'] ?>" required />
    <?php
    }
    ?>
</div>
<div class="form-group">
    <label for="astro_pcode">Pin Code: </label>
    <?php if(empty($this->msg['postcode'])) { ?>  
    <input type="text" class="form-control" name="astro_pcode" id="astro_pcode" placeholder="Enter Pin Code of your place" />
    <?php } else{ ?>
    <input type="text" class="form-control" name="astro_pcode" id="astro_pcode" value="<?php echo $this->msg['postcode'] ?>"  />
    <?php
    }
    ?>
</div>
<div class="form-group">
    <label for="astro_phone">Phone: </label>
    <?php 
    if(empty($this->msg['phone'])) { ?>  
    <input type="number" class="form-text1" name="astro_code" id="astro_code" placeholder="area code" /> -
    <input type="number" class="form-text2" name="astro_phone" id="astro_phone" placeholder="phone number" /> Example 22-xxxxxxxx for Mumbai, India
    <?php } else{ 
        $phone      = $this->msg['phone'];
        if(strpos($phone,"-"))
        {
          $phone    = explode("-",$this->msg['phone']);
        ?>
            <input type="number" class="form-text1" name="astro_code" id="astro_code" value="<?php echo $phone[0]; ?>" /> -
            <input type="number" class="form-text2" name="astro_phone" id="astro_phone" value="<?php echo $phone[1]; ?>" /> Example 22-xxxxxxxx for Mumbai, India
        <?php
        }
        else
        {  
        ?>
            <input type="number" class="form-text1" name="astro_code" id="astro_code"  /> -
            <input type="number" class="form-text2" name="astro_phone" id="astro_phone" value="<?php echo $phone; ?>" /> Example 22-xxxxxxxx for Mumbai, India
    <?php 
        }
    }
    ?>
</div>
<div class="form-group">
    <label for="astro_mobile">Mobile(No Country Code): </label>
    <?php if(empty($this->msg['mobile'])) { ?>  
    <input type="number" class="form-text2" name="astro_mobile" id="astro_mobile" placeholder="Enter Mobile Number" /> 
    <input type="checkbox" name="astro_whatsapp" value="yes" /> Check if available on Whatsapp
    <?php } else{ ?>
    <input type="number" class="form-text2" name="astro_mobile" id="astro_mobile" value="<?php echo $this->msg['mobile'] ?>" /> 
    <?php if($this->msg['whatsapp'] == "yes"){ ?>
    <input type="checkbox" name="astro_whatsapp" value="yes" checked /> Check if available on Whatsapp
    <?php } else{ ?>
    <input type="checkbox" name="astro_whatsapp" value="yes" /> Check if available on Whatsapp
    <?php
            }
    }
    ?>
</div> 
<div class="form-group">
    <label for="astro_web">Website/Blog <i class="fa fa-globe"></i>: </label>
    <?php if(empty($this->msg['website'])) { ?>  
    <input type="text" class="form-control" name="astro_web" id="astro_web" placeholder="Enter Website/Blog if Available" />
    <?php } else{ ?>
    <input type="text" class="form-control" name="astro_web" id="astro_web" value="<?php echo $this->msg['website'] ?>" />
    <?php
    }
    ?>
</div>
<div class="form-group">
    <label for="astro_fb">Facebook Page <i class="fa fa-facebook-square"></i> : </label>
    www.facebook.com/<input type="text" class="form-text2" name="astro_fb" id="astro_fb" placeholder="Page Name" value="<?php if(!empty($this->msg['fb_page'])){ echo $this->msg['fb_page'];} ?>" />
</div>
<div class="form-group">
    <label for="astro_gplus">Google Plus <i class="fa fa-google-plus"></i> : </label>
    https://plus.google.com/<input type="text" class="form-text2" name="astro_gplus" id="astro_gplus" placeholder="Page Name" value="<?php if(!empty($this->msg['gplus_page'])){ echo $this->msg['gplus_page'];} ?>" />
</div>
<div class="form-group">
    <label for="astro_fb">Twitter <i class="fa fa-twitter-square"></i> : </label>
    https://twitter.com/<input type="text" class="form-text2" name="astro_tweet" id="astro_tweet" placeholder="Page Name" value="<?php if(!empty($this->msg['tweet_page'])){ echo $this->msg['tweet_page'];} ?>" />
</div>
<div class="form-group">
    <label for="astro_info">Describe About Yourself(1000 Words Max)*: </label>
    <?php if(empty($this->msg['info'])) { ?> 
    <textarea rows="7" class="form-control" name="astro_info" id="astro_info" maxlength="10000 ">Describe your astrological expertise...</textarea>
    <?php } else{ ?>
     <textarea rows="7" class="form-control" name="astro_info" id="astro_info" maxlength="10000" required><?php echo $this->msg['info'] ?></textarea>
    <?php
    }
    ?>
</div>
<div class="form-group">
    <button type="submit" name="update_profile" class="btn btn-primary" >Update</button>
    <button type="reset" name="reset" class="btn btn-warning">Reset</button>
    <a class="btn btn-danger" href="<?php echo JURI::base() ?>dashboard">Cancel</a>
</div>
</form>