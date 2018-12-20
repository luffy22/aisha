<?php
defined('_JEXEC') or die;

// Include the latest functions only once
JLoader::register('ModCatArticlesHelper', __DIR__ . '/helper.php');

$list            = ModCatArticlesHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_cat_articles', $params->get('layout', 'default'));
