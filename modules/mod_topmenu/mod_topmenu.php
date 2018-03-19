<?php
 // no direct access
defined('_JEXEC') or die;
require_once( dirname(__FILE__) . '/helper.php' );

 
//$toprated 	= modTopContentHelper::gettoprated();
$topmenu	= modTopMenuHelper::gettopmenu($params);
$base           = modTopMenuHelper::getBase($params);
require( JModuleHelper::getLayoutPath('mod_topmenu'));

?>
