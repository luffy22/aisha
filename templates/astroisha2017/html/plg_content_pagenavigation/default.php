<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagenavigation
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$lang = JFactory::getLanguage(); ?>
<div class="mt-2"></div>
<ul class="pager pagenav">
<?php if ($row->prev) :
	$direction = $lang->isRtl() ? 'right' : 'left'; ?>
	<li class="previous">
		<a class="btn btn-primary" href="<?php echo $row->prev; ?>" rel="prev">
			<i class="fa fa-arrow-left" aria-hidden="true"></i><?php echo "&nbsp;".$row->prev_label; ?>
		</a>
	</li>
<?php endif; ?>
<?php if ($row->next) :
	$direction = $lang->isRtl() ? 'left' : 'right'; ?>
	<li class="next">
		<a class="btn btn-primary" href="<?php echo $row->next; ?>" rel="next">
			<?php echo $row->next_label . '&nbsp;'; ?><i class="fa fa-arrow-right" aria-hidden="true"></i>
		</a>
	</li>
<?php endif; ?>
</ul>
