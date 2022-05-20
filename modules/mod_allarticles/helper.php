<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
/**
 * Helper for mod_allarticles
 */
use Joomla\CMS\Pagination;
class modAllarticlesHelper
{
	public function showArticles()
	{
            $app                = JFactory::getApplication();
            $limit              = $app->getUserStateFromRequest("$option.limit", 'limit',10, 'int');
            $limitstart		= $app->input->get('limitstart', 0, '', 'uint');
            $db                 = JFactory::getDbo();  // Get db connection
            $query              = $db->getQuery(true);
            $query              = "SELECT jv_content.id AS article_id, jv_content.alias as article_alias,
                                    jv_content.title as title, jv_content.images as images, jv_content.language as language,
                                    LEFT(jv_content.introtext,500) AS article_text,
                                    jv_content.hits AS hits, jv_categories.alias AS cat_alias, jv_categories.title as cat_title, jv_content.catid AS cat_id FROM jv_content INNER JOIN jv_categories
                                    ON jv_content.catid = jv_categories.id WHERE state=1 ORDER BY jv_content.id DESC LIMIT ".$limitstart.", ".$limit; 
            $db                 ->setQuery($query);
  
            // Load the results as a list of stdClass objects (see later for more options on retrieving data).
           $results        = $db->loadObjectList();
           return $results;
	}
    public function getTotal()
    {
        $db             	= JFactory::getDbo();  // Get db connection
        $query          	= $db->getQuery(true);
        $query          	->select(array('COUNT(*)'))
                                ->from($db->quoteName('#__content'))
                                ->where($db->quoteName('state').' = '.$db->quote('1'));
        $db             	->setQuery($query);
        $total      		= $db->loadResult();
        return $total;	
    }  
    public function getPagination()
    {
        $app                    = JFactory::getApplication();
        $total                  = self::getTotal();
        //print_r($total);exit;
        // Load the content if it doesn't already exist
        //$limit                  = $app->getUserState
        $limit			= $app->getUserStateFromRequest("$option.limit", 'limit',10, 'int');
        $limitstart		= $app->input->get('limitstart', 0, '', 'uint');

        //jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $limit);
        return $pagination;
    } 
}
