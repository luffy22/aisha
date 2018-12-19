<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_footer
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\String\StringHelper;

$app        = JFactory::getApplication();
$date       = JFactory::getDate();
$cur_year   = date('Y');

$csite_name = $app->get('sitename');

$lineone    = $cur_year.'&nbsp;'.$csite_name;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_footer', $params->get('layout', 'default'));
