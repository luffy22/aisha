<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$this->form->reset( true );

// to load in our own version of login.xml
$this->form->loadFile( dirname(__FILE__) . DS . "reset_request.xml");
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
?>
<div class="reset <?php echo $this->pageclass_sfx?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<div class="page-header">
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	</div>
	<?php endif; ?>
	<form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=reset.request'); ?>" method="post" class="form-validate">
		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
		<p><?php echo JText::_($fieldset->label); ?></p>
			<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
				<div class="form-group">
					<label><?php echo $field->label; ?></label>
					<?php echo $field->input; ?>
				</div>
			<?php endforeach; ?>
		<?php endforeach; ?>
			<button type="submit" class="btn btn-primary validate"><?php echo JText::_('JSUBMIT'); ?></button>
			<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
