<div class="row">
<?php
defined('_JEXEC') or die;
//print_r($list);exit;
if ($module->showtitle) 
{
?>
<h3><?php echo $module->title ?></h3><div class="mb-2"></div>
<?php
}
foreach ($list as $item) :  
$images                 = json_decode($item->images);
?>
<div class="col-md-4 col-sm-4 col-xs-4 card-block">
	<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>">
		<span>
			<img src="<?php echo htmlspecialchars($images->image_intro); ?>"  alt="<?php echo $item->title; ?>" height="50px" width="50px"/> <?php echo $item->title ?>
		</span>
	</a>
</div><div class="mb-2"></div>
<?php
	$counter++;
?>
<?php endforeach; ?>
<div class="mb-2"></div>
</div>


