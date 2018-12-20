<?php
defined('_JEXEC') or die;

JLoader::register('ContentHelperRoute', JPATH_SITE . '/components/com_content/helpers/route.php');

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

use Joomla\Utilities\ArrayHelper;
abstract class ModCatArticlesHelper
{
	/**
	 * Retrieve a list of article
	 *
	 * @param   \Joomla\Registry\Registry  &$params  module parameters
	 *
	 * @return  mixed
	 *
	 * @since   1.6
	 */
	public static function getList(&$params)
	{
            //print_r($params);exit;
            $cat_id       = $params->get('catid')[0];
            $count        = $params->get('count');

            $db             = JFactory::getDbo();  // Get db connection
            $query          = $db->getQuery(true);
            $query          = "SELECT jv_content.id AS article_id, jv_content.alias as article_alias,
                                jv_content.title as title, jv_content.images as images, jv_content.language as language,
                                jv_content.hits AS hits, jv_categories.alias AS cat_alias, jv_categories.title as cat_title, jv_content.catid AS cat_id FROM jv_content INNER JOIN jv_categories
                                ON jv_content.catid = jv_categories.id WHERE state=1 AND jv_content.catid = ".$cat_id." ORDER BY jv_content.id ASC LIMIT ".$count; 
            $db->setQuery($query);

            // Load the results as a list of stdClass objects (see later for more options on retrieving data).
            $results        = $db->loadObjectList();
            return $results;
		// Get the dbo
                    
	}
}
