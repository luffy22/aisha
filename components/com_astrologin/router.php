<?php
defined('_JEXEC') or die;
use Joomla\CMS\Component\Router\RouterBase;
/**
 * Routing class from com_content
 *
 * @since  3.3
 */
class AstroLoginRouter extends RouterBase
{
     public function build(&$query)
    {
       //print_r($query);exit;
        
        //print_r($item_id);exit;
        $segments = array();
        if (isset($query['view']) && isset($query['Itemid']))
        {
            //$segments[] = $query['view'];
            unset($query['view']);
            $item_id    = $query['Itemid'];
            unset($query['Itemid']);
        }
        else if(isset($query['view']) && isset($query['id']))
        {
            //echo "calls";exit;
            $item_id    = $query['id'];
            unset($query['id']);
            unset($query['view']);
        }
        //print_r($query);exit;
        $db = JFactory::getDbo();
        $qry = $db->getQuery(true);
        $qry->select('alias');
        $qry->from('#__menu');
        $qry->where('id = ' . $db->quote($item_id));
        $db->setQuery($qry);
        $alias = $db->loadResult();
        //print_r($alias);exit;
        $segments[] = $alias;
        //print_r($segments);exit;
        return $segments;
    }
    public function parse(&$segments)
    {
        //print_r($segments);exit;
        $vars = array();
        $vars['alias']  = $segment[0];
        return $vars;
    }
    public function preprocess($query)
    {
        //print_r($query);exit;
        return $query;
    }
    
}
