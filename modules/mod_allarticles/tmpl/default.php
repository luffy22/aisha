<?php
JHtml::_('behavior.keepalive');
//print_r($allarticles);exit;
 $counter = 0;
?>
<h3 class="lead alert alert-dark">Recent Articles</h3><div class="mb-4"></div>
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
            <div class="card-body">
                <div class="card-title"><a class="content_links" href="<?php echo $data->link ?>" title="Click on link to read whole article"><?php echo $data->title; ?></a></div>
                <div class="card-subtitle mb-2 text-muted">Views: <?php echo $data->hits; ?></div>
                <p><?php echo strip_tags(trim($data->article_text))."..."; ?></p>
            <p class="text-left">Category: <a class="content_links" href="<?php echo $data->catlink; ?>" title="Browse through Category: <?php echo $data->cat_title; ?> articles"><?php echo $data->cat_title; ?></a></p>
            </div>
        </div>
<?php
    if($counter % 2 !== 0)
    {
?>
    </div></div><div class="mb-4"></div>
<?php
    }
        $counter++;
    }
?>

