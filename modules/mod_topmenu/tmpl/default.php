<?php
defined('_JEXEC') or die;
//print_r($topmenu);exit;
use Joomla\CMS\Router\Route;
?>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header d-flex justify-content-end">
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
      <div id="sidenav">    
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()" title="close menu"><i class="far fa-times-circle"></i></a>
 
        <!--<a class="navbar-brand"><img src="images/logo.png" alt="logo" /></a>
        <span class="navbar-text">Astro Isha</span>-->
    <div class="list-group">
  
<?php 
foreach($topmenu as $item)
{
    if ((strpos($item->link, 'index.php?') === 0) && (strpos($item->link, 'id=') === false))
    {
        // If this is an internal Joomla link, ensure the Itemid is set.
        $item->link         = $item->alias;
        $url    = JUri::base().$item->link;
    }
    else 
    {
       $url    = Route::_($item->link);
    }
    
    if($active->id  == $item->id)
    {
?>
    <a class="list-group-item list-group-item-action active" href="<?php echo $item->link ?>"><?php echo $item->title; ?></a>
<?php
    }
    else
    {
?>
    <a class="list-group-item list-group-item-action" href="<?php echo $url; ?>"><?php echo $item->title; ?></a>
<?php        
    }
}
?>
</div>
</div>
  </div>
</div>

<!--<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
    <button class="navbar-toggler" data-toggle="collapse" data-target="#top-menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="top-menu">
        <!--<a class="navbar-brand"><img src="images/logo.png" alt="logo" /></a>
        <span class="navbar-text">Astro Isha</span>-->
        <!--<ul class="navbar-nav">
        <?php
            //foreach($topmenu as $menu)
            //{ 
        ?>
            <li class="nav-item dropdown">
                <?php
                /*if($menu->level == "2")
                {
                    $p_menu = $app->getMenu();
                    $children       = $p_menu->getItems('parent_id',$menu->id, false);
                    $count          = count($children);
                    $i=0;  // counter to increment for divider
                ?>
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="top-1" href="#"><?php echo $menu->title; ?></a>
                    <div class="dropdown-menu navbar-dark bg-dark">
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
                        <a class="dropdown-item" href="<?php echo $url ?>"><?php echo $child->title; ?></a>
                <?php
                        if($i+1 < $count)
                        {
                ?>
                        <div class="dropdown-divider"></div>
                <?php
                        }
                        $i++;
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
<!--<a class="dropdown-item" href="#"><?php //echo $menu->title; ?></a>--> */

//<?php //unset($topmenu); ?>
                        <div class="dropdown-divider"></div>-->              
