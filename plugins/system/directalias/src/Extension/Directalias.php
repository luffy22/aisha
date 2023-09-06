<?php
/**
 * @package        Direct Alias
 * @copyright      Copyright (C) 2009-2021 AlterBrains.com. All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace AlterBrains\Plugin\System\Directalias\Extension;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Menu\SiteMenu;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Router\Router;
use Joomla\CMS\Router\SiteRouter;
use Joomla\CMS\Uri\Uri;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;

\defined('_JEXEC') or die;

/**
 * @since        3.0.0
 * @noinspection PhpUnused
 */
class Directalias extends CMSPlugin implements SubscriberInterface
{
    /**
     * @var   ?SiteRouter
     * @since 3.0.0
     */
    private $router;

    /**
     * @var array
     * @since 3.0.0
     */
    private $custom_routes = [];

    /**
     * @var bool
     * @since 2.1.1
     */
    private static $has_falang;

    /**
     * @inheritDoc
     *
     * @param  SiteRouter|null  $router
     *
     * @since  1.0
     */
    public function __construct(&$subject, $config, ?SiteRouter $router)
    {
        parent::__construct($subject, $config);

        $this->router = $router;
    }

    /**
     * @inheritDoc
     * @since 3.0.0
     */
    public static function getSubscribedEvents(): array
    {
        static::$has_falang = \class_exists(\plgSystemFalangdriver::class);

        if (Factory::getApplication()->isClient('administrator')) {
            return [
                'onContentPrepareForm' => 'onContentPrepareForm',
            ];
        }

        return [
            // Use the lowest priority to execute Falang first, highest otherwise.
            'onAfterInitialise' => ['onAfterInitialise', static::$has_falang ? -1 : \PHP_INT_MAX],
        ];
    }

    /**
     * @param  Event  $event
     *
     * @return  void
     *
     * @since   3.0.0
     */
    public function onContentPrepareForm(Event $event)
    {
        /**
         * @var   Form  $form The form to be altered.
         * @var   mixed $data The associated data for the form.
         */
        [$form/*, $data*/] = $event->getArguments();

        if ($form->getName() !== 'com_menus.item' || $this->params->get('shorten_all')) {
            return;
        }

        $this->loadLanguage();

        FormHelper::addFieldPrefix('AlterBrains\Plugin\System\\' . (new \ReflectionClass($this))->getShortName() . '\Field');

        $form->setFieldAttribute('alias', 'type', 'directalias');

        $form->load(
            '<?xml version="1.0" encoding="utf-8"?>
			<form>
				<fields name="params">
					<fieldset name="menu-options">
						<field name="direct_alias" type="hidden" />
						<field name="absent_alias" type="hidden" />
					</fieldset>
				</fields>
			</form>',
            false
        );

        // Display real switchers in Falang
        if ($this->getApplication()->input->get('option') === 'com_falang') {
            $form->load(
                '<?xml version="1.0" encoding="utf-8"?>
				<form>
					<fields name="params">
						<fieldset name="menu-options">
							<!--suppress HtmlUnknownAttribute -->
							<field name="direct_alias" type="radio" class="btn-group btn-group-yesno" default="0"
							    label="PLG_SYSTEM_FIELD_DIRECT_ALIAS_MODE" description="PLG_SYSTEM_DIRECT_ALIAS_DIRECT_TIP_DESC">
								<option value="1">PLG_SYSTEM_DIRECT_ALIAS_DIRECT</option>
								<option value="0">PLG_SYSTEM_DIRECT_ALIAS_RELATIVE</option>
							</field>
							<!--suppress HtmlUnknownAttribute -->
							<field name="absent_alias" type="radio" class="btn-group btn-group-yesno" default="0"
							    label="PLG_SYSTEM_FIELD_ABSENT_ALIAS_MODE" description="PLG_SYSTEM_DIRECT_ALIAS_ABSENT_TIP_DESC">
								<option value="1">PLG_SYSTEM_DIRECT_ALIAS_ABSENT</option>
								<option value="0">PLG_SYSTEM_DIRECT_ALIAS_PRESENT</option>
							</field>
						</fieldset>
					</fields>
				</form>',
                false
            );
        }
    }

    /**
     * @since        1.0
     * @noinspection PhpUnused
     */
    public function onAfterInitialise()
    {
        // Falang overloads menu items via own router's parse rule, so we need to update routes after its rule but not now.
        if (static::$has_falang) {
            $this->router->attachParseRule([$this, 'updateDirectRoutes'], Router::PROCESS_BEFORE);
        } else {
            $this->updateDirectRoutes();
        }
    }

    /**
     * Joomla4 requires parent_id=1 for top-level shorten URLs.
     * @since 1.0
     */
    public function updateDirectRoutes()
    {
        // Execute only once since method can be attached as parse rule and executed multiple times.
        static $updated = 0;
        if ($updated++) {
            return;
        }

        /** @var SiteApplication $app */
        $app = $this->getApplication();

        // Just shorten all URLs.
        if ($this->params->get('shorten_all')) {
            foreach ($app->getMenu()->getMenu() as $item) {
                /** @noinspection PhpDeprecationInspection */
                $item->getParams()->set('_route', $item->route);
                $item->route = $item->alias;
            }
        } // Or custom settings per menu item
        else {
            $changed_routes = [];

            foreach ($app->getMenu()->getMenu() as $item) {
                $params = $item->getParams();

                if ($params->get('direct_alias')) {
                    /** @noinspection PhpDeprecationInspection */
                    $params->set('_route', $item->route);
                    $item->route = $item->alias;
                    $this->custom_routes[$item->language][$item->route] = $item->id;

                    $changed_routes[$item->id] = $item->route;
                }

                if ($params->get('absent_alias')) {
                    $changed_routes[$item->id] = $changed_routes[$item->parent_id] ?? \trim(\dirname($item->route), './');
                }

                if ($item->level > 1 && isset($changed_routes[$item->parent_id])) {
                    /** @noinspection PhpDeprecationInspection */
                    $params->set('_route', $item->route);
                    $item->route = \ltrim($changed_routes[$item->parent_id] . '/' . $item->alias, '/');
                    $this->custom_routes[$item->language][$item->route] = $item->id;
                }
            }
        }

        // Decorate router
        if ($this->params->get('shorten_all') || $this->custom_routes) {
            $getDuringRules = (static function &($router) {
                return $router->rules['parse' . Router::PROCESS_DURING];
            })->bindTo(null, SiteRouter::class);

            foreach ($getDuringRules($this->router) as &$callback) {
                if (\is_array($callback)
                    && $callback[1] === 'parseSefRoute'
                    && \is_object($callback[0])
                    && \get_class($callback[0]) === SiteRouter::class
                ) {
                    $callback = [$this, 'parseSefRoute'];
                    break;
                }
            }
        }
    }

    /**
     * @param  SiteRouter  $router  Router object
     * @param  Uri         $uri     URI object to process
     *
     * @since 3.0.0
     * @see   SiteRouter::parseSefRoute()
     */
    public function parseSefRoute($router, $uri)
    {
        $route = $uri->getPath();

        // If the URL is empty, we handle this in the non-SEF parse URL
        if (empty($route)) {
            return;
        }

        // Parse the application route
        $segments = \explode('/', $route);

// CUSTOM START
        /** @var SiteApplication $app */
        $app = $this->getApplication();

        /** @var SiteMenu $menu */
        $menu = $app->getMenu();
// CUSTOM END

        if (\count($segments) > 1 && $segments[0] === 'component') {
            $uri->setVar('option', 'com_' . $segments[1]);
            $uri->setVar('Itemid', null);
            $route = \implode('/', \array_slice($segments, 2));
        } else {
// CUSTOM START
            $lang_tag = $app->getLanguage()->getTag();
            $found = null;

            if ($this->params->get('shorten_all')) {
                // All short
                foreach ($app->getMenu()->getMenu() as $item) {
                    if ($item->alias == $segments[0]
                        && (!$app->getLanguageFilter() || ($item->language === '*' || $item->language === $lang_tag))
                    ) {
                        $found = $item;
                        break;
                    }
                }
            } elseif ($this->custom_routes) {
                $segmentsTest = \explode('/', $route);
                // Custom short
                while ($segmentsTest) {
                    $routeTest = \implode('/', $segmentsTest);

                    if (isset($this->custom_routes[$lang_tag][$routeTest])) {
                        $found = $menu->getItem($this->custom_routes[$lang_tag][$routeTest]);
                        break;
                    } elseif (isset($this->custom_routes['*'][$routeTest])) {
                        $found = $menu->getItem($this->custom_routes['*'][$routeTest]);
                        break;
                    }

                    \array_pop($segmentsTest);
                }
            }

            // Original usual logic
            if (!$found) {
                /** @noinspection PhpParamsInspection */
                $items = $menu->getItems(['parent_id', 'access'], [1, null]);

                foreach ($segments as $segment) {
                    $matched = false;

                    foreach ($items as $item) {
                        if ($item->alias == $segment
                            && (!$app->getLanguageFilter() || ($item->language === '*' || $item->language === $lang_tag))
                        ) {
                            $found = $item;
                            $matched = true;
                            $items = $item->getChildren();
                            break;
                        }
                    }

                    if (!$matched) {
                        break;
                    }
                }
            }
// CUSTOM END

//            // Get menu items.
//            $items    = $menu->getItems(['parent_id', 'access'], [1, null]);
//            $lang_tag = $this->app->getLanguage()->getTag();
//            $found    = null;
//
//            foreach ($segments as $segment) {
//                $matched = false;
//
//                foreach ($items as $item) {
//                    if (
//                        $item->alias == $segment
//                        && (!$this->app->getLanguageFilter()
//                            || ($item->language === '*'
//                                || $item->language === $lang_tag))
//                    ) {
//                        $found   = $item;
//                        $matched = true;
//                        $items   = $item->getChildren();
//                        break;
//                    }
//                }
//
//                if (!$matched) {
//                    break;
//                }
//            }

            // Menu links are not valid URLs. Find the first parent that isn't a menulink
            if ($found && $found->type === 'menulink') {
                while ($found->hasParent() && $found->type === 'menulink') {
                    $found = $found->getParent();
                }

                if ($found->type === 'menulink') {
                    $found = null;
                }
            }

            if (!$found) {
                $found = $menu->getDefault($lang_tag);
            } else {
                $route = \trim(\substr($route, \strlen($found->route)), '/');
            }

            if ($found) {
                if ($found->type === 'alias') {
                    $newItem = $menu->getItem($found->getParams()->get('aliasoptions'));

                    if ($newItem) {
                        $found->query = \array_merge($found->query, $newItem->query);
                        $found->component = $newItem->component;
                    }
                }

                $uri->setVar('Itemid', $found->id);
                $uri->setVar('option', $found->component);
            }
        }

        // Set the active menu item
        if ($uri->getVar('Itemid')) {
            $menu->setActive($uri->getVar('Itemid'));
        }

        // Parse the component route
        if (!empty($route) && $uri->getVar('option')) {
            $segments = \explode('/', $route);

            if (\count($segments)) {
                // Handle component route
                $component = \preg_replace('/[^A-Z0-9_.-]/i', '', $uri->getVar('option'));
                $crouter = $router->getComponentRouter($component);
                $uri->setQuery(\array_merge($uri->getQuery(true), $crouter->parse($segments)));
            }

            $route = \implode('/', $segments);
        }

        $uri->setPath($route);
    }
}
