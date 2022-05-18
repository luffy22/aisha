<?php
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Router\Route;

class modTopMenuHelper
{
   /**
	 * Get a list of the menu items.
	 *
	 * @param   \Joomla\Registry\Registry  &$params  The module options.
	 *
	 * @return  array
	 *
	 * @since   1.5
	 */
	public static function getTopMenu(&$params)
	{
            $app        = JFactory::getApplication();
            $menu       = $app->getMenu();
            $config     = JFactory::getConfig();
            $site       = $config->get('sitename');
            // Get active menu item
            $base       = self::getBase($params);
            $result     = $menu->getItems('menutype', $base->menutype);
            //$result     = $this->menu->getItem($this->getVar('Itemid')); 
            return $result;
            //print_r($result);exit;
            //return $result;
	}

	/**
	 * Get base menu item.
	 *
	 * @param   \Joomla\Registry\Registry  &$params  The module options.
	 *
	 * @return  object
	 *
	 * @since	3.0.2
	 */
	public static function getBase(&$params)
	{
            // Get base menu item from parameters
            if ($params->get('base'))
            {
                    $base = Factory::getApplication()->getMenu()->getItem($params->get('base'));
            }
            else
            {
                    $base = false;
            }

            // Use active menu item if no base found
            if (!$base)
            {
                    $base = self::getActive($params);
            }

            return $base;
        }

	/**
	 * Get active menu item.
	 *
	 * @param   \Joomla\Registry\Registry  &$params  The module options.
	 *
	 * @return  object
	 *
	 * @since	3.0.2
	 */
	public static function getActive(&$params)
	{
            $menu = Factory::getApplication()->getMenu();
            return $menu->getActive() ?: self::getDefault();
	}

	/**
	 * Get default menu item (home page) for current language.
	 *
	 * @return  object
	 */
	public static function getDefault()
	{
            $menu = Factory::getApplication()->getMenu();

            // Look for the home menu
            if (Multilanguage::isEnabled())
            {
                    return $menu->getDefault(Factory::getLanguage()->getTag());
            }

            return $menu->getDefault();
	}
}
?>
