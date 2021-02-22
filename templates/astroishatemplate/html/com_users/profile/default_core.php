<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<h3><?php echo JText::_('COM_USERS_PROFILE_CORE_LEGEND'); ?></h3>
<table class="table table-bordered table-striped">
    <tr><th><?php echo JText::_('COM_USERS_PROFILE_NAME_LABEL'); ?></th><td><?php echo $this->escape($this->data->name); ?></td></tr>
    <tr><th><?php echo JText::_('COM_USERS_PROFILE_USERNAME_LABEL'); ?></th><td><?php echo $this->escape($this->data->username); ?></td></tr>
    <tr><th><?php echo JText::_('COM_USERS_PROFILE_REGISTERED_DATE_LABEL'); ?></th><td><?php echo JHtml::_('date', $this->data->registerDate, JText::_('DATE_FORMAT_LC1')); ?></td></tr>
    <tr><th><?php echo JText::_('COM_USERS_PROFILE_LAST_VISITED_DATE_LABEL'); ?></th>
        <?php if ($this->data->lastvisitDate != $this->db->getNullDate()) : ?>
			<td>
				<?php echo JHtml::_('date', $this->data->lastvisitDate, JText::_('DATE_FORMAT_LC1')); ?>
			</td>
		<?php else : ?>
			<td>
				<?php echo JText::_('COM_USERS_PROFILE_NEVER_VISITED'); ?>
			</td>
		<?php endif; ?></tr>
</table>
	
		
