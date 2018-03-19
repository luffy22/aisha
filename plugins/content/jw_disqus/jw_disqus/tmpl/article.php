<?php
/**
 * @version		3.5
 * @package		DISQUS Comments for Joomla! (package)
 * @author		JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;
?>
<a id="startOfPage"></a>
<?php $url =  JURI::current(); ?>
<?php if($disqusArticleCounter): ?>
<!-- DISQUS comments counter and anchor link -->
<div class="jwDisqusArticleCounter">
       
	<span>
		<a class="jwDisqusArticleCounterLink" href="#disqus_thread" data-disqus-identifier="<?php echo $output->disqusIdentifier; ?>"><?php echo JText::_("JW_DISQUS_VIEW_COMMENTS"); ?></a>
	</span>
	<div class="clr"></div>
</div>
<?php endif; ?>
<?php echo $row->text; ?>
<div class="mb-2"></div>
<ul class="nav nav-pills" role="tablist">
<li class="nav-item active"><a class="nav-link" href="#fb" role="tab" data-toggle="tab">Facebook</a></li>
<li class="nav-item"><a class="nav-link" href="#disqus" role="tab" data-toggle="tab">Disqus</a></li>
</ul>
<div class="mb-1"></div>
<p><small>If you wish for a reply use Disqus. Facebook does not notify about comments posted.</small></p>
<!-- Tab panes -->
<div class="tab-content">
<div class="mt-1"></div>
<div id="fb" class="tab-pane active" role="tabpanel">
<div class="fb-comments" data-href="<?php echo $url; ?>" data-numposts="2"></div>
</div>
<div id="disqus" class="tab-pane" role="tabpanel">
<!-- DISQUS comments block -->
<div class="jwDisqusForm">
	<?php echo $output->comments; ?>
	<div id="jwDisqusFormFooter">
		<a target="_blank" href="http://disqus.com" class="dsq-brlink">
			<?php echo JText::_("JW_DISQUS_BLOG_COMMENTS_POWERED_BY"); ?> <span class="logo-disqus">DISQUS</span>
		</a>
		<a id="jwDisqusBackToTop" href="#startOfPage">
			<?php echo JText::_("JW_DISQUS_BACK_TO_TOP"); ?>
		</a>
	</div>
</div>
</div>
</div>
