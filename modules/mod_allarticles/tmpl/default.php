<?php
JHtml::_('behavior.keepalive');
//print_r($allarticles);exit;
 $counter = 0;
?>
<h3>Recent Articles</h3><div class="mb-2"></div>
<?php
foreach($allarticles as $data)
{  
    $images                 = json_decode($data->images);
    $data->slug             = $data->article_id.':'.$data->article_alias;
    $data->catslug          = $data->cat_id.':'.$data->cat_alias;
    $data->link             = JRoute::_(ContentHelperRoute::getArticleRoute($data->slug, $data->catslug));
    $data->catlink          = JRoute::_(ContentHelperRoute::getCategoryRoute($data->cat_id, $data->language));
    if($counter % 2 == 0)
    {
?>
<div class="card-deck-wrapper">
    <div class="card-deck">
<?php
    }
?>
        <div class="card" id="panel_<?php echo $data->article_id; ?>">
<?php
        if(empty($images->image_intro) && !empty($images->image_fulltext))
        {
?>
            <a href="<?php echo $data->link ?>"><img class="img-fluid" src="<?php echo htmlspecialchars($images->image_fulltext); ?>" title="Click To Open Article" alt="<?php echo $data->title; ?>" /></a>
<?php
        }
        else if(!empty($images->image_intro) && !empty($images->image_fulltext))
        {
?>
           <a href="<?php echo $data->link ?>"><img class="img-fluid" src="<?php echo htmlspecialchars($images->image_fulltext); ?>" title="Click To Open Article" alt="<?php echo $data->title; ?>" /></a>
<?php
        }
        else
        {
?>
          <a href="<?php echo $data->link ?>"><img class="img-fluid" src="<?php JURI::base() ?>images/art_img/img_soon.jpg" alt="Image Soon" title="Image Coming Soon..." /></a>  
<?php
        }
?>
        <div class="card-header"><p class="lead"><?php echo $data->title; ?></p></div>
            <div class="card-block">
            <div class="card-header">
            <p class="text-right"><strong>Hits: <?php echo $data->hits; ?></strong></p></div>
            <p><?php echo strip_tags(trim($data->article_text))."..."; ?><a class="btn btn-primary" href="<?php echo $data->link ?>" title="Click on link to read whole article">Read More</a></p>
            <div class="card-footer text-muted">
                <p class="text-left">Category: <a href="<?php echo $data->catlink; ?>" title="Browse through Category: <?php echo $data->cat_title; ?> articles"><?php echo $data->cat_title; ?></a></p>
            </div>
            </div>
        </div> 
<?php
    if($counter % 2 !== 0)
    {
?>
        </div>
    </div>
<?php
    }
        $counter++;
    }
?>

