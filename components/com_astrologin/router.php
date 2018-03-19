<?php
defined('_JEXEC') or die;

/**
 * Routing class from com_content
 *
 * @since  3.3
 */
class AstroLoginRouter extends JComponentRouterBase
{
    public function build(&$query)
    {
        //print_r($query);exit;
		 $segments = array();
       if (isset($query['view']))
       {
                $segments[] = $query['astrosearch'];
                unset($query['view']);
       }
       if (isset($query['user']))
       {
                $segments[] = $query['user'];
                unset($query['user']);
       };
       return $segments;
		//$router = new AstroLoginRouter;

		//return $router->build($query);
	}
	public function parse(&$segments)
	{   
            $vars           = array();
            $vars['view']   = 'astrosearch';
            $vars['user']   = $segments[0];
            return $vars;
	}
	public function AstroLoginBuildRoute(&$query)
	{
		$this->build($query);
	}
	public function AstroLoginParseRoute($segments)
	{
		$this->parse($segments);
	}
}
