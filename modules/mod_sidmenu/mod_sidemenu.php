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
JLoader::register('ModSidemenuHelper', __DIR__ . '/helper.php');

$list       = ModSidemenuHelper::getSideMenu($params);
$base       = ModSidemenuHelper::getBase($params);
$active     = ModSidemenuHelper::getActive($params);
$default    = ModSidemenuHelper::getDefault();

if (count($list))
{
	require JModuleHelper::getLayoutPath('mod_sidmenu', $params->get('layout', 'default'));
}
