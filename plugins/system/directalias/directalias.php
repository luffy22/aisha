<?php
/**
* @package		Direct Alias
* @copyright	Copyright (C) 2009-2015 AlterBrains.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

defined('_JEXEC') or die('Restricted access'); 

class plgSystemDirectalias extends JPlugin
{
	public function onContentPrepareForm($form, $data)
	{
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}
		
		if ($form->getName() != 'com_menus.item')
		{
			return true;
		}
		
		$this->loadLanguage();
		
		JForm::addFieldPath(__DIR__);
		$form->setFieldAttribute('alias', 'type', 'directaliasfield');

		$form->load('<?xml version="1.0" encoding="utf-8"?>
			<form>
				<fields name="params">
					<fieldset name="menu-options">
						<field name="direct_alias" type="hidden" />
						<field name="absent_alias" type="hidden" />
					</fieldset>
				</fields>
			</form>', false);
	}
	
	public function onAfterInitialise()
	{
		$app = JFactory::getApplication();
		
		if ($app->isAdmin())
		{
			return;
		}

		// Falang overloads menu items via own router's parse rule, so we need to update routes after its rule but now now.
		if (class_exists('plgSystemFalangdriver'))
		{
			$app->getRouter()->attachParseRule(array($this, 'updateDirectRoutes'));
		}
		else
		{
			$this->updateDirectRoutes();
		}
	}
	
	public function updateDirectRoutes()
	{
		$menu = JFactory::getApplication()->getMenu();
		
		// I hate Joomla sometimes... smbd is crazy on privates
		$rProperty = new ReflectionProperty($menu, '_items');
		$rProperty->setAccessible(true);
		$items = $rProperty->getValue($menu);

		$direct_aliases = array();
		
		foreach($items as &$item)
		{
			// Remember original route.
			$item->original_route = $item->route;
			
			if ($item->params->get('absent_alias') && $item->params->get('direct_alias'))
			{
				$direct_aliases[$item->route] = '';

				$item->route = $item->alias;
			}
			// Remove alias for all children
			elseif ($item->params->get('absent_alias'))
			{
				if (!isset($direct_aliases[$item->route]))
				{
					$direct_aliases[$item->route] = trim(dirname($item->route), './');
				}
			}
			
			// Own direct alias
			// Remove parent alias
			elseif ($item->params->get('direct_alias'))
			{
				$direct_aliases[$item->route] = $item->alias;
				
				$item->route = $item->alias;
			}
			// Remove parent alias of parents with direct aliases
			elseif ($item->level > 1 && !empty($direct_aliases))
			{
				$test_route = $item->route;
				
				while($test_route = substr($test_route, 0, strrpos($test_route, '/')))
				{
					if (isset($direct_aliases[$test_route]))
					{
						$item->route = trim($direct_aliases[$test_route] . '/' . substr($item->route, strlen($test_route)+1), '/');
						break;
					}
				}
			}
		}
	}
}
