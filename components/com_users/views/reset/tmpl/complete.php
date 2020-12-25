<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

?>
Hell With Life

<div class="reset-complete<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>
	<form action="<?php echo JRoute::_('index.php?option=com_users&task=reset.complete'); ?>" method="post" class="form-validate form-horizontal well">
		<div class="form-group">
		<label for"jform_username">Username*</label>
		<input type="text" name="jform[username]" id="jform_username" value="" class="required form-text" size="30" required="" aria-required="true">
		</div>
		<div class="form-group">
		<label for"jform_token">Verification Code*</label>
		<input type="text" name="jform[token]" id="jform_token" value="" class="required form-text" size="32" required="" aria-required="true">
		</div>
		<div class="form-group">
		<button type="submit" class="btn btn-primary validate">
			<?php echo JText::_('JSUBMIT'); ?>
		</button>
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
