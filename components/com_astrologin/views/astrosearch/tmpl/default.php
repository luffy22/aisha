<?php
defined('_JEXEC') or die('Restricted access');
$astro      = $this->astro;
?>
<div class="mt-1"></div>
<p class="float-xs-right">Results Per Page: <?php echo $this->pagination->getLimitBox(); ?></p>
<div class="mb-3"></div>
<?php
     foreach($astro as $data)
     {
        $user       = $data->username;    
        $jinput = JFactory::getApplication()->input;
        $jinput->set('user',  $user, 'string');
?>      
<div class="card" id="<?php echo "astro_".$data->number ?>">
    <div class="card-block">
        <h3 class="card-title"><?php echo $data->name; ?></h3>
        <?php
         if($data->membership == "Paid")
         {
      ?>
        <p class="float-xs-right"><a class="btn btn-primary" href="<?php echo JUri::base() ?>ask-question"><i class="fa fa-globe"></i> Ask Online</a></p>
      <?php
         }
      ?>
        <div class="row">
            <div class="col-md-2">
             <?php
            if(empty($data->img_new_name))
            {
        ?>   
                <img src="<?php echo JURI::base() ?>images/blank-profile.png" class="img-fluid" />
        <?php
            }
            else
            {
        ?>
                <img src="<?php echo JURI::base() ?>images/profiles/<?php echo $data->img_new_name; ?>" title="<?php $data->img_name; ?>" class="img-fluid" />
        <?php
            }
        ?>
            </div>
            <div class="col-md-10"><strong>Location:</strong> <?php echo $data->city.", ",$data->state.", ".$data->country;  ?><br/>
                <strong>Little About Me:</strong><br/> <?php if(strlen($data->info) > 1000){echo stripslashes(substr($data->info,0,1000))."...";}else{echo stripslashes($data->info);} ?><br/>
                <a class="btn btn-primary" href="<?php echo JRoute::_('index.php?view=astrosearch&user='.$user); ?>"><i class="fa fa-address-card-o"></i> Get Full Details</a>
            </div>
        </div>
    </div>
</div>
<?php
     }
?>
<div class="mb-1"></div>
<?php // Add pagination links ?>
<?php if (!empty($this->items)) : ?>
	<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
		<div class="pagination">

			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter pull-right">
					<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			<?php endif; ?>

			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	<?php endif; ?>
<?php  endif; ?>    
<div class="mb-2"></div>

