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
<div class="remind<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>
	<form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=remind.remind'); ?>" method="post" class="form-validate form-horizontal well">
            <p>Please enter the email address associated with your User account. Your username will be emailed to the email address on file.</p>
            <div class="form-group">
                <label  for="jform_email" class="hasPopover required" title="Email Address" data-content="Please enter the email address associated with your User account.<br />Your username will be emailed to the email address on file.">
                Email Address *</span></label>
		<input type="email" name="jform[email]" class="form-control validate-email required" id="jform_email" value="" size="30" autocomplete="email" required="" aria-required="true">	</div>
            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-primary validate">
                <?php echo JText::_('JSUBMIT'); ?>
            </button>
			
            </div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
