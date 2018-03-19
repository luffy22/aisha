<?php
class modTopMenuHelper
{
    /**
     * Get base menu item.
     *
     * @param   JRegistry  &$params  The module options.
     *
     * @return   object
     *
     * @since	3.0.2
     */
    public function gettopmenu(&$params)
    {
	$app = JFactory::getApplication();
        $menu = $app->getMenu();
        $config = JFactory::getConfig();
        $site = $config->get('sitename');
        // Get active menu item
        $base       = self::getBase($params);
        $result     = $menu->getItems('menutype', $base->menutype);
?>
<nav class="navbar navbar-light navbar-fixed-top bg-primary">
<button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#top-menu" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
<div class="collapse navbar-toggleable-md" id="top-menu">
<a href="<?php echo JUri::base(); ?>" class="navbar-brand top-menu"><img src="<?php echo JUri::base() ?>logo.png" height="30" width="30" /> <?php echo $site; ?></a>
  <ul class="nav navbar-nav">
<?php
        foreach($result as $items)
        {
            $url   = JRoute::_($items->link . "&Itemid=" . $items->id);
            if($items->level !== '1')
            {
                continue;
            }
       ?>
            <li class="nav-item dropdown bg-primary">
          <?php
            if($items->level=="1")
            {
                $children       = $menu->getItems('parent_id',$items->id, false);
          ?>
             <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="nav-link dropdown-toggle top-menu" href="<?php echo $url ?>"><?php echo $items->title ?><span class="caret"></span></a>
             <div class="dropdown-menu bg-primary" aria-labelledby="supportedContentDropdown">
             <?php
                    foreach($children as $child)
                    {
                        if($child->type=="url")
                        {
                            $url    = JRoute::_($child->link);
                        }
                        else
                        {
                            $url   = JRoute::_($child->link . "&Itemid=" . $child->id);
                        }
                     ?>
                         <a href="<?php echo $url; ?>" title="<?php echo $child->title; ?>" class="dropdown-item top-menu-link"><?php echo $child->title; ?></a>
                 <?php
                    }
                    
             ?>
             </div>
      <?php
            }
            
      ?>
            </li>
            
<?php
      }
?>
    </ul>
</div>
</nav>
<?php
    }
    public function getChildren($title, $link, $id)
    {
        $app        = JFactory::getApplication();
        $menu       = $app->getMenu()->getItems('parent_id',$id, true);
        $result     = array("title"=>$title, "link"=>$link,"id"=>$id,$menu);
        return $result;      
        
    }
    public static function getBase(&$params)
    {
        // Get base menu item from parameters
        if ($params->get('base'))
        {
                $base = JFactory::getApplication()->getMenu()->getItem($params->get('base'));
        }
        else
        {
                $base = false;
        }

        // Use active menu item if no base found
        if (!$base)
        {
                $base = self::getActive($params);
        }

        return $base;
    }
    public static function getActive(&$params)
    {
        $menu = JFactory::getApplication()->getMenu();

        return $menu->getActive() ? $menu->getActive() : $menu->getDefault();
    }
        
}
