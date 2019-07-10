<?php
defined('_JEXEC') or die('Restricted access');
$data      = $this->astro;
$user       = JFactory::getUser();
$username   = $user->username;
//print_r($data);exit;
?>
<div class="mt-2"></div>
<a href="<?php echo JUri::base() ?>astro" class="btn btn-primary"><i class="fa fa-home"></i> Search Home</a>
<div class="mb-1"></div>
<div class="card" id="<?php echo "astro_".$data->number; ?>">
    <div class="card-block">
        <div class="row float-xs-right">
        <?php
         if($data->membership == "Paid")
         {
      ?>
        <a class="btn btn-primary" href="<?php echo JUri::base() ?>ask-question"><i class="fa fa-globe"></i> Ask Online</a>&nbsp;
      <?php
         }
        if($username == $data->username)
         {
       ?>
       <a class="btn btn-primary" href="<?php echo JUri::base() ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
        <?php
        }
      ?>
        </div>
        <?php
            if(empty($data->img_new_name))
            {
        ?>
          <img src="<?php echo JURI::base() ?>images/blank-profile.png" height="180px" width="120px" />
        <?php
            }
            else
            {
        ?>
          <img src="<?php echo JURI::base() ?>images/profiles/<?php echo $data->img_new_name; ?>" height="180px" width="120px" />
      <?php
            }
      ?>
          <div class="mb-1"></div>
          <p class="text-lead"><?php echo stripslashes($data->info); ?></p>
          <h3>Expertise: </h3>
<?php
      foreach($this->expert as $expert)
      {
           if($expert->role_super == "0")
          {
            $id         = $expert->role_id;
?>            
          <p><strong><?php echo $expert->role_name ?></strong></p>
          <p>
<?php
             foreach($this->expert as $exp)
             {
                if($exp->role_super == $id)
                {
                    echo "{".$exp->role_name."} ";
                }
                
             }
?>
          </p>
<?php
          }
         
      }
      ?>             
        <div class="mb-2"></div>
        <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Name: </strong><?php echo $data->name; ?></li>
        <li class="list-group-item"><strong><i class="fa fa-envelope-o"></i> Email: </strong><?php echo $data->email; ?><?php if($user->sendEmail == '0'){ ?><span style="color:green"> <i class="fa fa-check-circle" aria-hidden="true"></i></span><?php } ?></li>
        <li class="list-group-item"><strong><i class="fa fa-street-view"></i> Address Line 1: </strong><?php echo $data->addr_1; ?></li>
        <li class="list-group-item"><strong><i class="fa fa-street-view"></i> Address Line 2: </strong><?php echo $data->addr_2; ?></li>
        <li class="list-group-item"><strong>City: </strong><?php echo $data->city; ?></li>
        <li class="list-group-item"><strong>State: </strong><?php echo $data->state; ?></li>
        <li class="list-group-item"><strong>Country: </strong><?php echo $data->country; ?></li>
        <li class="list-group-item"><strong><i class="fa fa-map-marker"></i> Pincode: </strong><?php echo $data->postcode; ?></li>
        <li class="list-group-item"><strong><i class="fa fa-phone"></i> Phone: </strong><?php echo $data->phone; ?></li>
        <li class="list-group-item"><strong><i class="fa fa-mobile"></i> Mobile: </strong><?php echo $data->mobile; ?></li>
        <li class="list-group-item"><strong><i class="fa fa-whatsapp"></i> Available On WhatsApp: </strong><?php if(!empty($data->mobile)){echo ucfirst($data->whatsapp);}else{echo "No"; } ?></li>
        <li class="list-group-item"><strong><i class="fa fa-globe"></i> Website: </strong><?php if(!empty($data->website)){echo $data->website;} ?></li>
        <li class="list-group-item"><strong><i class="fa fa-facebook"></i> Facebook: </strong><?php if(!empty($data->fb_page)){echo "https://www.facebook.com/".$data->fb_page;} ?></li>
        <li class="list-group-item"><strong><i class="fa fa-google-plus"></i> Google+: </strong><?php if(!empty($data->gplus_page)){echo "https://plus.google.com/".$data->gplus_page;} ?></li>
        <li class="list-group-item"><strong><i class="fa fa-twitter"></i> Twitter: </strong><?php if(!empty($data->tweet_page)){echo "https://twitter.com/".$data->tweet_page;} ?></li>
     </ul>
    </div>
</div>
<div class="mb-2"></div>
