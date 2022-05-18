<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the menu functions only once
JLoader::register('ModSubMenuHelper', __DIR__ . '/helper.php');

$list       = ModSubMenuHelper::getSideMenu($params);
$base       = ModSubMenuHelper::getBase($params);
$active     = ModSubMenuHelper::getActive($params);
$default    = ModSubMenuHelper::getDefault();

if (count($list))
{
	require JModuleHelper::getLayoutPath('mod_sidmenu', $params->get('layout', 'default'));
}
