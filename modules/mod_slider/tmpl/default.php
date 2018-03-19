<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_popular
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
//print_r($list);exit;
$count = count($list);
$i = 0;
?>
<div id="article_caroussel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
  <?php
  while($i < $count)
  {
      if($i == 0)
      {
  ?>
    <li data-target="#article_caroussel" data-slide-to="<?php echo $i; ?>" class="active"></li>
  <?php
      }
    else
    {
  ?>
    <li data-target="#article_caroussel" data-slide-to="<?php echo $i; ?>"></li>
<?php
    }
    if($i >= $count)$i = 0;else $i++;
  }    
?>
  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
   <?php
        $j = 0; 
        foreach($list as $item)
        {
        $images = json_decode($item->images);
        if($j == 0)
        {
    ?>
            <div class="carousel-item active">
                <?php
        if(!empty($images->image_intro) && empty($images->image_fulltext))
        {
?>
                <a href="<?php echo $item->link ?>"><img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $item->title; ?>"></a>
        <?php
        }
        else if(empty($images->image_intro) && !empty($images->image_fulltext))
        {
?>
           <a href="<?php echo $item->link ?>"><img class="img-fluid" src="<?php echo htmlspecialchars($images->image_fulltext); ?>" title="Click To Open Article" alt="<?php echo $item->title; ?>" /></a>
<?php
        }
        else
        {
?>
          <a href="<?php echo $item->link ?>"><img class="img-fluid" src="<?php JURI::base() ?>images/art_img/img_soon.jpg" alt="Image Soon" title="Click To Open Article" /></a>  
<?php
        }
?>
                <div class="carousel-caption">
                   <h3 class="hidden-xs-down hidden-sm-down"><a href="<?php echo $item->link ?>"><?php echo $item->title; ?></a></h3>
                   <p class="hidden-xs-down hidden-sm-down"><?php echo $item->metadesc; ?></p>
              </div>
            </div>
   <?php
        }
 else {
   ?>
      <div class="carousel-item">
                                <?php
        if(!empty($images->image_intro) && empty($images->image_fulltext))
        {
?>
                <a href="<?php echo $item->link ?>"><img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $item->title; ?>"></a>
        <?php
        }
        else if(empty($images->image_intro) && !empty($images->image_fulltext))
        {
?>
           <a href="<?php echo $item->link ?>"><img class="img-fluid" src="<?php echo htmlspecialchars($images->image_fulltext); ?>" title="Click To Open Article" alt="<?php echo $item->title; ?>" /></a>
<?php
        }
        else
        {
?>
          <a href="<?php echo $item->link ?>"><img class="img-fluid" src="<?php JURI::base() ?>images/art_img/img_soon.jpg" alt="Image Soon" title="Click To Open Article" /></a>  
<?php
        }
?>
                <div class="carousel-caption">
                   <h3 class="hidden-xs-down hidden-sm-down"><a href="<?php echo $item->link ?>"><?php echo $item->title; ?></a></h3>
                   <p class="hidden-xs-down hidden-sm-down"><?php echo $item->metadesc; ?></p>
              </div>
            </div>
  <?php
  
  }
        $j++;
        }
 if($j >= $count)$j =0;
  
?>
</div>
<a class="left carousel-control" href="#article_caroussel" role="button" data-slide="prev">
    <span class="icon-prev" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#article_caroussel" role="button" data-slide="next">
    <span class="icon-next" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>