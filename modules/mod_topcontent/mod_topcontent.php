<?php
 // no direct access
defined('_JEXEC') or die;
require_once __DIR__ . '/helper.php';


//$toprated 	= modTopContentHelper::gettoprated();
$topview	= modTopContentHelper::gettopview();
$toprecent      = modTopContentHelper::getRecentTop();

require JModuleHelper::getLayoutPath('mod_topcontent', $params->get('layout'));
?>
