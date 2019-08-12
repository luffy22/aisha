<?php
defined('_JEXEC') or die;

// Include the latest functions only once
JLoader::register('ModHoroMenuHelper', __DIR__ . '/helper.php');

$list            = ModHoroMenuHelper::getMenu();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_horomenu', $params->get('layout', 'default'));
