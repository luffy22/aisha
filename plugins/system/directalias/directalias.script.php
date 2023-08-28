<?php
/**
 * @package        Direct Alias
 * @copyright      Copyright (C) 2009-2021 AlterBrains.com. All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

/**
 * @since        1.0
 * @noinspection PhpUnused
 */
class plgSystemDirectaliasInstallerScript
{
    /**
     * @var string
     * @since 3.0
     */
    protected $extension_name = 'System - Direct Alias';

    /**
     * @var string
     * @since 3.0
     */
    protected $minimumPhp = '8.0';

    /**
     * @var string
     * @since 2.0
     */
    protected $minimumJoomla = '4.3';

    /**
     * @return bool
     * @since 2.0
     */
    public function preflight()
    {
        if (!empty($this->minimumPhp) && version_compare(PHP_VERSION, $this->minimumPhp, '<')) {
            Factory::getApplication()->enqueueMessage(Text::sprintf('JLIB_INSTALLER_MINIMUM_PHP', $this->minimumPhp), 'error');

            return false;
        }
        if (!empty($this->minimumJoomla) && version_compare(JVERSION, $this->minimumJoomla, '<')) {
            Factory::getApplication()->enqueueMessage(Text::sprintf('JLIB_INSTALLER_MINIMUM_JOOMLA', $this->minimumJoomla), 'error');

            return false;
        }

        return true;
    }

    /**
     * @since 1.0
     */
    public function install()
    {
        Factory::getApplication()->enqueueMessage(sprintf('Successfully installed "%s" plugin.', $this->extension_name));
    }

    /**
     * @since 1.0
     */
    public function uninstall()
    {
        Factory::getApplication()->enqueueMessage(sprintf('Successfully uninstalled "%s" plugin.', $this->extension_name));
    }

    /**
     * @since 1.0
     */
    public function update()
    {
        Factory::getApplication()->enqueueMessage(sprintf('Successfully updated "%s" plugin.', $this->extension_name));
    }
}
