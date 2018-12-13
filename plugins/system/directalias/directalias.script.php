<?php
/**
 * @package        Direct Alias
 * @copyright      Copyright (C) 2009-2017 AlterBrains.com. All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die('Restricted access');

class plgSystemDirectaliasInstallerScript
{
	public function install()
	{
		JFactory::getApplication()->enqueueMessage(JText::_('Successfully installed "System - Direct Alias" plugin!'));
	}

	public function uninstall()
	{
		JFactory::getApplication()->enqueueMessage(JText::_('Successfully uninstalled "System - Direct Alias" plugin!'));
	}

	public function update()
	{
		JFactory::getApplication()->enqueueMessage(JText::_('Successfully updated "System - Direct Alias" plugin!'));
	}
}