<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$location		= ModNavtaraHelper::getLocation();
$nakshatra      = ModNavtaraHelper::getNakshatraList();
$current        = ModNavtaraHelper::getForecastAjax();

require JModuleHelper::getLayoutPath('mod_navtara', $params->get('layout', 'default'));
