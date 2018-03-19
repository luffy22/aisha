<?php
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$list		= modSliderHelper::getArticles($params);

require JModuleHelper::getLayoutPath('mod_slider', $params->get('layout', 'default'));


