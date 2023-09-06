<?php
/**
 * @package        Direct Alias
 * @copyright      Copyright (C) 2009-2021 AlterBrains.com. All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\SiteRouter;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;

use AlterBrains\Plugin\System\Directalias\Extension\Directalias;

return new class () implements ServiceProviderInterface {
    /**
     * @inheritDoc
     * @since 3.0.0
     */
    public function register(Container $container)
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {
                $plugin                 = PluginHelper::getPlugin('system', 'directalias');
                $dispatcher             = $container->get(DispatcherInterface::class);
                $router                 = $container->has(SiteRouter::class) ? $container->get(SiteRouter::class) : null;

                $plugin = new Directalias($dispatcher, (array) $plugin, $router);
                $plugin->setApplication(Factory::getApplication());

                return $plugin;
            }
        );
    }
};
