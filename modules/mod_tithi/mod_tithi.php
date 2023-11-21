<?php
 // no direct access
defined('_JEXEC') or die;
require_once( dirname(__FILE__) . '/helper.php' );

 
//$toprated 	= modTopContentHelper::gettoprated();
$tithi			= modTithiHelper::getTithiCurr();	
require( JModuleHelper::getLayoutPath('mod_tithi'));

?>
