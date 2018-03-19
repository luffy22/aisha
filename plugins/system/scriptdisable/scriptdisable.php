<?php
defined('_JEXEC') or die;
class plgSystemScriptDisable extends JPlugin
{
    public function onBeforeCompileHead()
    {
		//echo "compile before";exit;
        // Application Object
        $app = JFactory::getApplication();

        // Front only
        if( $app instanceof JApplicationSite )
        {
            $doc            = JFactory::getDocument();
            // Remove default bootstrap
            unset($doc->_scripts[JURI::root(true) . '/media/jui/js/jquery.min.js']);
            unset($doc->_scripts[JURI::root(true) . '/media/jui/js/jquery-noconflict.js']);
            unset($doc->_scripts[JURI::root(true) . '/media/system/js/mootools-core.js']);
            unset($doc->_scripts[JURI::root(true) . '/media/jui/js/jquery-migrate.min.js']);
            unset($doc->_scripts[JURI::root(true) . '/media/jui/js/bootstrap.min.js']);
        }
    }
}
