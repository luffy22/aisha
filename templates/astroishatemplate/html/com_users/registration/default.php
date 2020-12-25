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
<div class="registration<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		</div>
	<?php endif; ?>
	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
            <div class="form-group">
                <label for="jform_name">Full Name</label>
                <input type="text" name="jform[name]" id="jform_name" value="" class="form-control" size="25" required aria-required="true">
            </div>
            <div class="form-group">
                <label for="jform_username">Username</label>
                <input type="text" name="jform[username]" id="jform_username" value="" class="form-control" size="25" required aria-required="true">
            </div>
            <div class="form-group">
                <label for="jform_password1">Password</label>
                <input type="password" name="jform[password1]" id="jform_password1" value="" class="form-control hasPopover" size="25" required aria-required="true">
            </div>
            <div class="form-group">
                <label for="jform_password2">Confirm Password</label>
                <input type="password" name="jform[password2]" id="jform_password2" value="" class="form-control validate-password" size="25" required aria-required="true">
            </div>
            <div class="form-group">
                <label for="jform_email1">Email</label>
                <input type="text" name="jform[email1]" id="jform_email1" value="" class="form-control hasPopover" size="25" required aria-required="true">
            </div>
            <div class="form-group">
                <label for="jform_email2">Confirm Email</label>
                <input type="text" name="jform[email2]" id="jform_email2" value="" class="form-control validate-email" size="25" required aria-required="true">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary validate">
                        <?php echo JText::_('JREGISTER'); ?>
                </button>
                <a class="btn" href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>">
                        <?php echo JText::_('JCANCEL'); ?>
                </a>
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="registration.register" />
            </div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
