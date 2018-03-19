<?php
defined('_JEXEC') or die;
//echo "<pre>";
//echo print_r($topview);
//echo "</pre>";
?>
<div class="mt-2"></div>
<div class="hidden-md-up">
<ul class="nav nav-pills" role="tablist">
<li class="nav-item active"><a class="nav-link" href="#tp-1" role="tab" data-toggle="tab">Most Read</a></li>
<li class="nav-item"><a class="nav-link" href="#tp-2" role="tab" data-toggle="tab">Recent Popular</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
<div class="mb-2"></div>
<div id="tp-1" class="tab-pane active" role="tabpanel">
<div id="top-1">
<?php
$i=1;
foreach($topview as $data)
{
    
    $images                 = json_decode($data->images);
    $data->slug             = $data->article_id.':'.$data->article_alias;
    $data->catslug          = $data->cat_id.':'.$data->cat_alias;
    $data->link             = JRoute::_(ContentHelperRoute::getArticleRoute($data->slug, $data->catslug));
    $data->catlink          = JRoute::_(ContentHelperRoute::getCategoryRoute($data->cat_id, $data->language));
?>
    <h3><?php echo $data->title; ?></h3>
<div>
        <div class="card" id="panel_<?php echo $data->article_id; ?>">
<?php
        if(!empty($images->image_intro) && empty($images->image_fulltext))
        {
?>
             <a href="<?php echo $data->link ?>"><img class="img-fluid" src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $data->title; ?>" /></a>
<?php
        }
        else if(empty($images->image_intro) && !empty($images->image_fulltext))
        {
?>
            <a href="<?php echo $data->link ?>"><img class="img-fluid" src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo $data->title; ?>" /></a>
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
            <p><?php echo strip_tags(trim($data->article_text))."..."; ?><a href="<?php echo $data->link ?>" title="Click on link to read whole article">Read More</a></p>
		</div>
        </div>
  </div>

<?php
$i++;
}
?>
</div>
</div>
<div id="tp-2" class="tab-pane" role="tabpanel">
<div id="top-2"> 
<?php
$i=1;
foreach($toprecent as $data)
{
    
    $images                 = json_decode($data->images);
    $data->slug             = $data->article_id.':'.$data->article_alias;
    $data->catslug          = $data->cat_id.':'.$data->cat_alias;
    $data->link             = JRoute::_(ContentHelperRoute::getArticleRoute($data->slug, $data->catslug));
    $data->catlink          = JRoute::_(ContentHelperRoute::getCategoryRoute($data->cat_id, $data->language));
?>
    <h3><?php echo $data->title; ?></h3>
<div>
        <div class="card" id="panel_<?php echo $data->article_id; ?>">
<?php
        if(!empty($images->image_intro) && !empty($images->image_fulltext))
        {
?>
            <a href="<?php echo $data->link ?>" title="Click on link to read whole article"><img class="img-fluid" src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo $data->title; ?>" /></a>
<?php
        }
        else if(empty($images->image_intro) && !empty($images->image_fulltext))
        {
?>
            <a href="<?php echo $data->link ?>" title="Click on link to read whole article"><img class="img-fluid" src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo $data->title; ?>" /></a>
<?php
        }
        else if(!empty($images->image_intro) && empty($images->image_fulltext))
        {
?>
            <a href="<?php echo $data->link ?>" title="Click on link to read whole article"><img class="img-fluid" src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $data->title; ?>" /></a>
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
        
            <p><?php echo strip_tags(trim($data->article_text))."..."; ?><a href="<?php echo $data->link ?>" title="Click on link to read whole article">Read More</a></p>
            </div>
        </div>
  </div>
<?php
$i++;
}
?>
</div>
</div>
<!-- End of tabs -->
</div> <!-- class="tab-content" -->
</div>   <!--div mobile visibile off   -->
<div class="mb-2"></div>
