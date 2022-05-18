<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagenavigation
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

$lang = Factory::getLanguage(); ?>
<div class="d-flex justify-content-between mb-3">
	<?php if ($row->prev) :
		$direction = $lang->isRtl() ? 'right' : 'left'; ?>
		<div class="p-2">
			<a class="page-link" href="<?php echo Route::_($row->prev); ?>" rel="prev">
			<span class="visually-hidden">
				<?php echo Text::sprintf('JPREVIOUS_TITLE', htmlspecialchars($rows[$location-1]->title)); ?>
			</span>
                        <i class="bi bi-arrow-left-circle-fill"></i>&nbsp;<?php echo  $row->prev_label; ?>
			</a>
		</div>
	<?php endif; ?>
	<?php if ($row->next) :
		$direction = $lang->isRtl() ? 'left' : 'right'; ?>
		<div class="p-2">
			<a class="page-link" href="<?php echo Route::_($row->next); ?>" rel="next">
			<span class="visually-hidden">
				<?php echo Text::sprintf('JNEXT_TITLE', htmlspecialchars($rows[$location+1]->title)); ?>
			</span>
			<i class="bi bi-arrow-right-circle-fill"></i>&nbsp;<?php echo $row->next_label; ?>
			</a>
		</div>
	<?php endif; ?>
</div>
