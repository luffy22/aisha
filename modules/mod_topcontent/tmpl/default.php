<?php
defined('_JEXEC') or die;
//echo "<pre>";
//echo print_r($topview);
//echo "</pre>";
?>
<div class="mt-4"></div>
<h3 class="lead alert alert-dark">Most Popular Articles</h3>
<table class="table table-striped">
    <tr><th>Articles</th><th>Views</th></tr>
</div>
<?php
foreach($topview as $data)
{
    $data->slug    = $data->article_id . ':' . $data->article_alias;
    $data->link = JRoute::_(ContentHelperRoute::getArticleRoute($data->slug, $data->cat_id, $data->language));
?>
    <tr>
        <td><a href="<?php echo $data->link; ?>" class="content_links" title="Click to open article"><?php echo $data->title; ?></a></td><td><?php echo $data->hits; ?></td>
    </tr>
<?php
}
?>
</table>
<?php
unset($topview);
/*
$i=1;
foreach($toprecent as $data)
{
    
    $images                 = json_decode($data->images);
    $data->slug             = $data->article_id.':'.$data->article_alias;
    $data->catslug          = $data->cat_id.':'.$data->cat_alias;
    $data->link             = JRoute::_(ContentHelperRoute::getArticleRoute($data->slug, $data->catslug));
    $data->catlink          = JRoute::_(ContentHelperRoute::getCategoryRoute($data->cat_id, $data->language));
?>
<div>
        <div class="card" id="panel_<?php echo $data->article_id; ?>">
<?php
        if(!empty($images->image_intro) && empty($images->image_fulltext))
        {
?>
            <a href="<?php echo $data->link ?>"><img class="img-fluid" src="<?php echo htmlspecialchars($images->image_intro); ?>" title="Click To Open Article" alt="<?php echo $data->title; ?>" /></a>
<?php
        }
        else if(empty($images->image_intro) && !empty($images->image_fulltext))
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
          <a href="<?php echo $data->link ?>"><img class="img-fluid" src="<?php JURI::base() ?>images/art_img/img_soon.jpg" alt="Image Soon" title="Click To Open Article" /></a>
<?php
        }
?>
            <div class="card-block">
            <div class="card-header"><p class="lead"><?php echo $data->title; ?></p></div>
            <div class="card-header">
            <p><strong>Hits: <?php echo $data->hits; ?></strong></p></div>
            <p><?php echo strip_tags(trim($data->article_text))."..."; ?><a href="<?php echo $data->link ?>" title="Click on link to read whole article">Read More</a></p>
            <div class="card-footer text-muted">
                <p class="text-left">Category: <a href="<?php echo $data->catlink; ?>" title="Browse through Category: <?php echo $data->cat_title; ?> articles"><?php echo $data->cat_title; ?></a></p>
            </div>
            </div>
        </div>
  </div>
<?php
$i++;
}
?>
</div>
<!-- End of tabs -->
</div> <!-- class="tab-content" -->
</div>   <!--div mobile visibile off   -->
 * ?>
 */
?>
<div class="mb-3"></div>
