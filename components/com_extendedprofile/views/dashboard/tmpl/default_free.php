<?php
defined('_JEXEC') or die;
//print_r($this->msg);exit;
$document = JFactory::getDocument();
$sheet      = JUri::base().'ajaxcalls/dropzone.css';
$script     = JUri::base().'ajaxcalls/dropzone.js';
$document->addStyleSheet($sheet);
$document->addScript($script);
$u_id         = $this->msg['id'];
?>
<h3>Expert: Free Account</h3>
<div class="float-xs-right"><a href="<?php echo JUri::base().'finance' ?>">Get Paid Membership</a> | 
   <?php if($this->msg['profile_status'] == "hidden"){ ?>
    <i class="fa fa-user-secret"></i> Profile Hidden
    <?php }else{ ?>
    <a href="<?php echo JUri::base(); ?>astro/<?php echo $this->msg['username'] ?>" title="Check how your page looks to others"><i class="fa fa-user"></i> Profile</a><?php } ?>  |  <a href="<?php echo JURI::base() ?>details" title="Edit Details"> <i class="fa fa-pencil"></i> Edit Details</a></div>
<div class="mb-3"></div>
<?php if($this->msg['profile_status'] == "hidden"){ ?>
<p><i class="fa fa-user-secret"></i> Your Profile is currently hidden at front-end. Go into Edit Details section to make it visible again.</p>
    <?php } ?>
<div class="mt-1"></div>
<div id="dashboard_free">
<h3>Basic Details</h3>
<div>
    <div class="row">
        <div class="col-md-3">
          <?php if(empty($this->msg['img_new_name'])){ ?>
          <form action="<?php echo JUri::base() ?>ajaxcalls/upload.php" class="dropzone"><img src="<?php echo JURI::base() ?>images/blank-profile.png" alt="blank photo" 
               class="img-fluid img-thumbnail" id="img_upload" title="Please Upload Your Photo..." /><input type="hidden" name="img_id" value="img_100<?php echo $u_id ?>" /></form>
          <?php
          }
          else
          {
          ?>
          <img src="<?php echo JURI::base() ?>images/profiles/<?php echo $this->msg['img_new_name'] ?>" alt="<?php echo $this->msg['img_name'] ?> image" 
               class="img-fluid img-thumbnail" title="<?php echo $this->msg['img_name']; ?>" /><?php } ?>
      </div>
      <div class="col-md-5">
          <div class="table-responsive">
          <table class="table table-bordered table-hover ">
              <tr><th>Username: </th><td><?php echo $this->msg['username']; ?></td></tr>
              <tr><th>Name: </th><td><?php echo $this->msg['name']; ?></td></tr>
              <tr><th>Profile Status: </th><td><?php echo ucfirst($this->msg['profile_status']); ?></td></tr>
          </table>
          </div>
      </div>
    </div>
    <div class="mt-1"></div>
    <p class="lead">Little About Me:</p>
        <p class="text-left"><?php echo stripslashes($this->msg['info']); ?></p>
</div>
<h3>Location Details</h3>
<div>
    <table class="table table-bordered table-hover ">
      <tr><th><span class="glyphicon glyphicon-home"></span> Address Line 1: </th><td><?php if(empty($this->msg['addr_1'])){echo "Not Provided"; }else{ echo $this->msg['addr_1'];} ?></td></tr>
      <tr><th><span class="glyphicon glyphicon-road"></span> Address Line 2: </th><td><?php if(empty($this->msg['addr_2'])){echo "Not Provided"; }else{ echo $this->msg['addr_2'];} ?></td></tr>
      <tr><th>City: </th><td><?php echo $this->msg['city']; ?></td></tr>
      <tr><th>State: </th><td><?php if(empty($this->msg['state'])){echo "Not Provided"; }else{ echo $this->msg['state'];} ?></td></tr>
      <tr><th>Country: </th><td><?php echo $this->msg['country']; ?></td></tr>
      <tr><th>Postcode: </th><td><?php echo $this->msg['postcode']; ?></td></tr>
    </table>
</div>
<h3>Contact Details</h3>
<div>
    <table class="table table-hover table-bordered">
      <tr><th><span class="glyphicon glyphicon-envelope"></span> Email: </th><td><?php echo $this->msg['email']; ?></td></tr>
      <tr><th><span class="glyphicon glyphicon-phone-alt"></span> Phone: </th><td><?php if(empty($this->msg['phone'])){echo "Not Provided"; }else{ echo $this->msg['phone'];} ?></td></tr>
      <tr><th><span class="glyphicon glyphicon-phone"></span> Mobile: </th><td><?php if(empty($this->msg['mobile'])){echo "Not Provided"; }else{ echo $this->msg['mobile'];} ?></td></tr>
      <tr><th><img src="<?php echo JURI::base() ?>images/whatsapp.png" alt="whatsapp logo" title="Whether Astrologer Uses Whatsapp" height="25px" width="25px" /> Available On Whatsapp: </th><td><?php echo ucfirst($this->msg['whatsapp']); ?></td></tr>
      <tr><th><span class="fa fa-globe"></span> Website/Blog: </th><td><?php if(empty($this->msg['website'])){echo 'Not Provided'; }else{ echo $this->msg['website']; } ?></td></tr>
      <tr><th><i class="fa fa-facebook-square"></i> Facebook: </th><td><?php if(empty($this->msg['fb_page'])){echo 'Not Provided'; }else{ echo "https://www.facebook.com/".$this->msg['fb_page']; } ?></td></tr>
      <tr><th><i class="fa fa-google-plus-circle"></i> Google Plus: </th><td><?php if(empty($this->msg['fb_page'])){echo 'Not Provided'; }else{ echo "https://plus.google.com/".$this->msg['gplus_page']; } ?></td></tr>
      <tr><th><i class="fa fa-twitter"></i> Twitter: </th><td><?php if(empty($this->msg['fb_page'])){echo 'Not Provided'; }else{ echo "https://twitter.com/".$this->msg['tweet_page']; } ?></td></tr>
    </table>
</div>
</div>
<div class="mb-1"></div>