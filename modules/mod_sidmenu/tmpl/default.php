<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$id = '';

if ($tagId = $params->get('tag_id', ''))
{
	$id = ' id="' . $tagId . '"';
}   

// The menu class is deprecated. Use nav instead
//print_r($list);exit;
?>
<div class="dropdown dropright">
<button class="btn"onclick="openNav()" title="Click to open menu"><i class="fas fa-bars"></i></button></div>
<div class="mb-3"></div>
<div id="sidenav">    
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="far fa-times-circle"></i></a>
<nav class="nav navbar-dark bg-dark">    
        <!--<a class="navbar-brand"><img src="images/logo.png" alt="logo" /></a>
        <span class="navbar-text">Astro Isha</span>-->
    
    <ul class="nav nav-pills flex-column">
  
<?php 
foreach($list as $item)
{
    $url    = JRoute::_($item->link);
    if($active_id  == $item->id)
    {
?>
    <li class="nav-item">
    <a class="nav-link active" href="<?php echo $url; ?>"><?php echo $item->title; ?></a>
  </li>
<?php
    }
    else
    {
?>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo $url; ?>"><?php echo $item->title; ?></a>
  </li>
<?php        
    }
}
?>
</ul>
</nav>
</div>