<?php
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

class modSliderHelper
{
    function getArticles($params)
    {
        if(empty($params->catid))
        {
            $items  = self::getSelectedArticles($params);
        }
        else
        {
            $items  = self::getArticleCategory($params);
        }
       
        return $items;
    }
    function getSelectedArticles($params)
    {
       $articles        = explode(",",$params['text']);
       $model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
        // Set application parameters in model
        $app = JFactory::getApplication();
        $appParams = $app->getParams();
        $model->setState('params', $appParams);

        // Access filter
        $access = !JComponentHelper::getParams('com_content')->get('show_noauth');
        $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
        $model->setState('filter.access', $access);

        // Category filter
        $model->setState('filter.article_id', $articles);
       
        // Filter by language
        $model->setState('filter.language', $app->getLanguageFilter());
        // Set the filters based on the module params
        $model->setState('list.start', 0);
        $model->setState('list.limit', (int)10);
        $model->setState('filter.published', 1);
        $model->setState('filter.featured', $params->get('show_front', 1) == 1 ? 'show' : 'hide');
        // Ordering
        $model->setState('list.ordering', 'a.id');
        $model->setState('list.direction', 'ASC');
        
        $items = $model->getItems();
        //print_r($items);exit;
        foreach ($items as &$item)
        {
                $item->slug = $item->id . ':' . $item->alias;
                $item->catslug = $item->catid . ':' . $item->category_alias;

                if ($access || in_array($item->access, $authorised))
                {
                        // We know that user has the privilege to view the article
                        $item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
                }
                else
                {
                        $item->link = JRoute::_('index.php?option=com_users&view=login');
                }
        }
        return $items;
    }
    function getArticleCategory($params)
    {
        
         // Get an instance of the generic articles model
        $model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
        // Set application parameters in model
        $app = JFactory::getApplication();
        $appParams = $app->getParams();
        $model->setState('params', $appParams);

        // Access filter
        $access = !JComponentHelper::getParams('com_content')->get('show_noauth');
        $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
        $model->setState('filter.access', $access);

        // Category filter
        $model->setState('filter.category_id', $params->get('catid', array()));

        // Filter by language
        $model->setState('filter.language', $app->getLanguageFilter());
        // Set the filters based on the module params
        $model->setState('list.start', 0);
        $model->setState('list.limit', (int) $params->get('count', 12));
        $model->setState('filter.published', 1);
        $model->setState('filter.featured', $params->get('show_front', 1) == 1 ? 'show' : 'hide');
        // Ordering
        $model->setState('list.ordering', 'a.id');
        $model->setState('list.direction', 'ASC');

        $items = $model->getItems();

        foreach ($items as &$item)
        {
                $item->slug = $item->id . ':' . $item->alias;
                $item->catslug = $item->catid . ':' . $item->category_alias;

                if ($access || in_array($item->access, $authorised))
                {
                        // We know that user has the privilege to view the article
                        $item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
                }
                else
                {
                        $item->link = JRoute::_('index.php?option=com_users&view=login');
                }
        }

        return $items;
    }
}

?>
