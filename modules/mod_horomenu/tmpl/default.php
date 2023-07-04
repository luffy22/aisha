<?php
defined('_JEXEC') or die;
if(isset($_GET['chart']))
{
$chart_id       = $_GET['chart'];
$current        = Juri::current();
?>
<nav class="navbar navbar-dark bg-dark navbar-expand-md sticky-top">
    <a class="navbar-brand" href="<?php echo Juri::base().'horoscope?chart='.$chart_id; ?>">&nbsp;&nbsp;<i class="bi bi-house-fill"></i></a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#horo_menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="horo_menu">
    <ul class="navbar-nav me-auto mb-2">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle p-2" href="#" id="horo_1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Horoscope
          </a>
            <ul class="dropdown-menu bg-dark" aria-labelledby="horo_1">
                <li><a class="dropdown-item <?php if($current == Juri::base().'mainchart'){ echo "active";} ?>" href="<?php echo Juri::base().'mainchart?chart='.$chart_id; ?>">Horo Details</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'getasc'){ echo "active";} ?>" href="<?php echo Juri::base().'getasc?chart='.$chart_id; ?>">Ascendant Chart</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'getmoon'){ echo "active";} ?>" href="<?php echo Juri::base().'getmoon?chart='.$chart_id; ?>">Moon Chart</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'getnakshatra'){ echo "active";} ?>" href="<?php echo Juri::base().'getnakshatra?chart='.$chart_id; ?>">Nakshatra Finder</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'getnavamsha'){ echo "active";} ?>" href="<?php echo Juri::base().'getnavamsha?chart='.$chart_id; ?>">Navamsha Chart</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'getvimshottari'){ echo "active";} ?>" href="<?php echo Juri::base().'getvimshottari?chart='.$chart_id; ?>">Vimshottari Dasha</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'shodasha'){ echo "active";} ?>" href="<?php echo Juri::base().'shodasha?chart='.$chart_id; ?>">Shodashvarga Charts</a></li>
             </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle p-2" href="#" id="horo_3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Career
          </a>
            <ul class="dropdown-menu bg-dark" aria-labelledby="horo_3">
                <li><a class="dropdown-item <?php if($current == Juri::base().'careerfind'){ echo "active";} ?>" href="<?php echo Juri::base().'careerfind?chart='.$chart_id; ?>">Career Finder</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'investwhere'){ echo "active";} ?>" href="<?php echo Juri::base().'investwhere?chart='.$chart_id; ?>">Where To Invest</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle p-2" href="#" id="horo_2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Marriage
          </a>
            <ul class="dropdown-menu bg-dark" aria-labelledby="horo_2">
                <li><a class="dropdown-item <?php if($current == Juri::base().'findspouse'){ echo "active";} ?>" href="<?php echo Juri::base().'findspouse?chart='.$chart_id; ?>">Spouse Finder</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'lovemarry'){ echo "active";} ?>" href="<?php echo Juri::base().'lovemarry?chart='.$chart_id; ?>">Love Marriage</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'latemarry'){ echo "active";} ?>" href="<?php echo Juri::base().'latemarry?chart='.$chart_id; ?>">Late Marriage</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'mangaldosha'){ echo "active";} ?>" href="<?php echo Juri::base().'mangaldosha?chart='.$chart_id; ?>">Mangal Dosha</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'divorce'){ echo "active";} ?>" href="<?php echo Juri::base().'divorce?chart='.$chart_id; ?>">Divorce Chances</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle p-2" href="#" id="horo_4" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Misc
          </a>
            <ul class="dropdown-menu bg-dark" aria-labelledby="horo_4">
                <li><a class="dropdown-item <?php if($current == Juri::base().'astroyogas'){ echo "active";} ?>" href="<?php echo Juri::base().'astroyogas?chart='.$chart_id; ?>">Astro Yogas</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item <?php if($current == Juri::base().'fourstage'){ echo "active";} ?>" href="<?php echo Juri::base().'fourstage?chart='.$chart_id; ?>">Life Stages</a></li>
            </ul>
            
        </li>
    </ul>
    </div>
</nav>
<?php
}
?>
<div class="mb-3"></div>
