<?php
defined('_JEXEC') or die;
//print_r($topmenu);exit;
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
    <button class="navbar-toggler" data-toggle="collapse" data-target="#top-menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="top-menu">
        <a class="navbar-brand"><img src="images/logo.png" alt="logo" /></a>
        <span class="navbar-text">Astro Isha</span>
        <ul class="navbar-nav">
        <?php
            foreach($topmenu as $menu)
            { 
        ?>
            <li class="nav-item dropdown">
                <?php
                if($menu->level == "2")
                {
                    $menu_id    = $menu->id;
                    
                ?>
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="top-1" href="#"><?php echo $menu->title; ?></a>
                    <div class="dropdown-menu navbar-dark bg-dark">
                 <?php
          
                        if($menu->level == "3" && $menu->parent_id == $menu_id)
                        {
                            echo "calls";exit;
                 ?>
                        <a class="dropdown-item" href="#"><?php echo $menu->title; ?></a>
                        <div class="dropdown-divider"></div>                   
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
