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
<div class="reset-confirm<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>
	<p>An email has been sent to your email address. The email has a verification code, please paste the verification code in the field below to prove that you are the owner of this account.</p>
	<form action="<?php echo JRoute::_('index.php?option=com_users&task=reset.confirm'); ?>" method="post" class="form-validate form-horizontal well">
		<div class="form-group">
		<label for"jform_username">Username*</label>
		<input type="text" name="jform[username]" id="jform_username" value="" class="form-control" size="30" required="" aria-required="true">
		</div>
		<div class="form-group">
		<label for"jform_token">Verification Code*</label>
		<input type="text" name="jform[token]" id="jform_token" value="" class="form-control" size="32" required="" aria-required="true">
		</div>
		<div class="form-group">
		<button type="submit" class="btn btn-primary validate">
			<?php echo JText::_('JSUBMIT'); ?>
		</button>
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
