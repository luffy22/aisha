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
<div class="reset<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>
	<p>Please enter the email address for your account. A verification code will be sent to you. Once you have received the verification code, you will be able to choose a new password for your account.</p>
	<form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=reset.request'); ?>" method="post" class="form-validate form-horizontal well">
		<div class="form-group">
		<label for"jform_email">Email Address*</label>
		<input type="text" name="jform[email]" id="jform_email" value="" class="validate-username form-control required" size="30" required="" aria-required="true">
	</div>
	<div class="form-group">	
		<button type="submit" class="btn btn-primary validate">
			<?php echo JText::_('JSUBMIT'); ?>
		</button>
	</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
