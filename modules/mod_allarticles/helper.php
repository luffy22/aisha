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
class modAllarticlesHelper
{
	public function showArticles()
	{
            $db             = JFactory::getDbo();  // Get db connection
            $query          = $db->getQuery(true);
            $query          = "SELECT jv_content.id AS article_id, jv_content.alias as article_alias,
                                jv_content.title as title, jv_content.images as images, jv_content.language as language,
                                LEFT(jv_content.introtext,500) AS article_text,
                                jv_content.hits AS hits, jv_categories.alias AS cat_alias, jv_categories.title as cat_title, jv_content.catid AS cat_id FROM jv_content INNER JOIN jv_categories
                                ON jv_content.catid = jv_categories.id WHERE state=1 ORDER BY jv_content.id DESC LIMIT 10"; 
            $db->setQuery($query);
  
            // Load the results as a list of stdClass objects (see later for more options on retrieving data).
           $results        = $db->loadObjectList();
           return $results;
	}
        public function getMoreArticlesAjax()
        {
            if(isset($_GET['lastid']))
            {
                $id             = str_replace("panel_","",$_GET['lastid']);
                $db             = JFactory::getDbo();  // Get db connection
                $query          = $db->getQuery(true);
                $query          = "SELECT jv_content.id AS article_id, jv_content.alias as article_alias,
                                    jv_content.asset_id AS article_assetid,jv_content.title, LEFT(jv_content.introtext,1000) AS article_text,
                                    jv_content.hits, jv_categories.alias AS cat_alias, jv_categories.title as cat_title, jv_content.catid FROM jv_content 
                                    INNER JOIN jv_categories ON jv_content.catid = jv_categories.id 
                                    WHERE jv_content.id < '".$id."' ORDER BY jv_content.id DESC LIMIT 10"; 
                $db->setQuery($query);
                $item           = array();
                // Load the results as a list of stdClass objects (see later for more options on retrieving data).
                $results        = $db->loadObjectList();
                foreach($results as $items)
                {
                    $items['slug']      = $items['article_id'].':'.$items['article_alias'];
                    $items['catslug']   = $items['catid'].':'.$items['cat_alias'];
                    $items['link']      = JRoute::_(ContentHelperRoute::getArticleRoute($items['slug'], $items['catslug']));
                    $items['catlink']    = JRoute::_(ContentHelperRoute::getCategoryRoute($items['catid'], $language));
                    $arr                = array("art_link"=>$items['link'],"cat_link"=>$items['catlink']);
                    $item               = array_merge($item,$arr);
                }
                //$data               = json_encode(array("link"=>$item));
                $data               = json_encode(array("art_link"=>$results['title']));
             }
            //else
            //{
               // $msg = "Fail to load Data";
                //$data   = json_encode($msg);
            //}
            return $data;
        }
}
