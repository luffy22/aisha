<?php
defined('_JEXEC') or die;
if(isset($_GET['chart']))
{
$chart_id       = $_GET['chart'];
$current        = Juri::current();
?>
<nav class="navbar navbar-dark bg-dark navbar-expand-md sticky-top">
    <a class="navbar-brand" href="<?php echo Juri::base().'horoscope?chart='.$chart_id; ?>"><i class="fas fa-home"></i>&nbsp;&nbsp;&nbsp;&nbsp;</a>
    <button class="navbar-toggler" data-toggle="collapse" data-target="#horo_menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="horo_menu">
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="horo_1" href="#">
                Horoscope </a>
            <div class="dropdown-menu bg-dark" aria-labelledby="horo_1">
                <a class="dropdown-item <?php if($current == Juri::base().'mainchart'){ echo "active";} ?>" href="<?php echo Juri::base().'mainchart?chart='.$chart_id; ?>">Horo Details</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item <?php if($current == Juri::base().'getasc'){ echo "active";} ?>" href="<?php echo Juri::base().'getasc?chart='.$chart_id; ?>">Ascendant Chart</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item <?php if($current == Juri::base().'getmoon'){ echo "active";} ?>" href="<?php echo Juri::base().'getmoon?chart='.$chart_id; ?>">Moon Chart</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item <?php if($current == Juri::base().'getnakshatra'){ echo "active";} ?>" href="<?php echo Juri::base().'getnakshatra?chart='.$chart_id; ?>">Nakshatra Finder</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item <?php if($current == Juri::base().'getnavamsha'){ echo "active";} ?>" href="<?php echo Juri::base().'getnavamsha?chart='.$chart_id; ?>">Navamsha Chart</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item <?php if($current == Juri::base().'getvimshottari'){ echo "active";} ?>" href="<?php echo Juri::base().'getvimshottari?chart='.$chart_id; ?>">Vimshottari Dasha</a>
             </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="horo_3" href="#">
                Career </a>
            <div class="dropdown-menu bg-dark" aria-labelledby="horo_3">
                <a class="dropdown-item <?php if($current == Juri::base().'careerfind'){ echo "active";} ?>" href="<?php echo Juri::base().'careerfind?chart='.$chart_id; ?>">Career Finder</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="horo_2" href="#">
                Marriage </a>
            <div class="dropdown-menu bg-dark" aria-labelledby="horo_2">
                <a class="dropdown-item <?php if($current == Juri::base().'findspouse'){ echo "active";} ?>" href="<?php echo Juri::base().'findspouse?chart='.$chart_id; ?>">Spouse Finder</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item <?php if($current == Juri::base().'mangaldosha'){ echo "active";} ?>" href="<?php echo Juri::base().'mangaldosha?chart='.$chart_id; ?>">Mangal Dosha</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item <?php if($current == Juri::base().'divorce'){ echo "active";} ?>" href="<?php echo Juri::base().'divorce?chart='.$chart_id; ?>">Divorce Chances</a>
            </div>
        </li>
    </ul>
    </div>
</nav>
<?php
}
?>
<div class="mb-3"></div>