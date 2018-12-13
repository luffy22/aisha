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
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="top-1" href="#">Dropdown </a>
                <div class="dropdown-menu navbar-dark bg-dark">
                    <a class="dropdown-item" href="#">PHP Tutorials</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">CSS Tutorials</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">HTML Tutorials</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link 2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link 3</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link 4</a>
            </li>
        </ul>
    </div>
</nav>
