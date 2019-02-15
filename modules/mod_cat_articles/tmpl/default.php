<?php
defined('_JEXEC') or die;
$counter = 0;
$count          = count($list);
if ($module->showtitle) 
{
?>
<div class="mb-4"></div>
<h3 class="lead alert alert-dark"><?php echo $module->title ?></h3>
<?php
}
?>
<div class="mb-2"></div>
<?php
//print_r($list);exit;
foreach ($list as $item)
{
    
    $item->slug     = $item->article_id . ':' . $item->article_alias;
    $item->link     = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->cat_id, $item->language));
    if($counter % 3 == 0)
    {
?>
<div class="row">
<?php
    }
$images                 = json_decode($item->images);
?>
<div class="col">
	<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" class="content_links">
		<span>
			<img src="<?php echo htmlspecialchars($images->image_intro); ?>"  alt="<?php echo $item->title; ?>" height="50px" width="50px"/> <?php echo $item->title; ?>
		</span>
	</a>
</div>
<?php
    $counter++;
    if($counter % 3 == 0)
   {
?>
</div><div class="mb-4"></div>
<?php 
    }
    if($counter % 3 !== 0 && $count == $counter)
    {
?>
</div><div class="mb-4"></div>
<?php 
    }
}
?>


