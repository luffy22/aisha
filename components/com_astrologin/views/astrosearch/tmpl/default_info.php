<?php
defined('_JEXEC') or die('Restricted access');
$data      = $this->astro;
?>
<div class="mt-2"></div>
<a href="<?php echo $data['url'] ?>" class="btn btn-primary"><i class="fa fa-caret-left"></i> Go Back</a>
<div class="mb-1"></div>
<div class="card" id="<?php echo "astro_".$data['number']; ?>">
    <div class="card-block">
        <?php
         if($data->membership == "Paid")
         {
      ?>
        <p class="float-xs-right"><a class="btn btn-success" href="<?php echo JUri::base() ?>ask-question"><i class="fa fa-globe"></i> Ask Online</a></p>
      <?php
         }
      ?>
        <div class="row">
            <div class="col-md-2"><img src="<?php echo JURI::base() ?>images/blank-profile.png" title="<?php echo $this->img_1 ?>" class="img-fluid" /></div>
            <div class="col-md-10">
                <table class="table table-borderd table-hover">
                    <tr><th>Name</th><td><?php echo $data['name']; ?></td></tr>
                    <tr><th>Email</th><td><?php echo $data['email']; ?></td></tr>
                    <tr><th>Address Line 1</th><td><?php echo $data['addr_1'] ?></td></tr>
                    <tr><th>Address Line 2</th><td><?php echo $data['addr_2'] ?></td></tr>
                    <tr><th>City</th><td><?php echo $data['city']; ?></td></tr>
                    <tr><th>State</th><td><?php echo $data['state']; ?></td></tr>
                    <tr><th>Country</th><td><?php echo $data['country']; ?></td></tr>
                    <tr><th>Postcode</th><td><?php echo $data['postcode']; ?></td></tr>
                    <tr><th>Phone</th><td><?php echo $data['phone']; ?></td></tr>
                    <tr><th>Mobile</th><td><?php echo $data['mobile']; ?></td></tr>
                    <tr><th>Available On WhatsApp</th><td><?php if(!empty($data['mobile'])){echo ucfirst($data['whatsapp']);}else{echo "No"; } ?></td></tr>
                </table>
            </div>       
        </div>
    </div>
</div>
<div class="mb-2"></div>
