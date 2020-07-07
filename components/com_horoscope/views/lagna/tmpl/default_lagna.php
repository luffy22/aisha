<html>
 <head>
     <title>Get Horoscope Details</title>
<!-- <style type="text/css">
#horo_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#horo_canvas{width:65%}}
</style>-->
</head>
<body>
<?php 
$chart_id = $_GET['chart']; 
$type       = $this->data['chart_type'];
?>
<div class="lead alert alert-dark">Horoscope</div>
<div class="row">
<div class="col-4"><a class="content_links" title="Main Chart" href="<?php echo Juri::base() ?>mainchart?chart=<?php echo $chart_id; ?>"><img src="images/mainchart.jpeg" width="50px" height="50px" alt="main" /> Main Chart</a></div>
<div class="col-4"><a class="content_links" title="Ascendant Chart" href="<?php echo Juri::base() ?>getasc?chart=<?php echo $chart_id; ?>"><img src="images/horo.jpeg" alt="ascendant" width="50px" height="50px" /> Ascendant Chart</a></div>
<div class="col-4"><a class="content_links" title="Moon Chart" href="<?php echo Juri::base() ?>getmoon?chart=<?php echo $chart_id; ?>"><img src="images/art_img/moon.png" alt="moon" width="50px" height="50px" /> Moon Chart</a></div>
</div>
<div class="mb-3"></div>
<div class="row">
<div class="col-4"><a class="content_links" title="nakshatra finder" href="<?php echo Juri::base() ?>getnakshatra?chart=<?php echo $chart_id; ?>"><img src="images/nakshatra.jpeg" alt="nakshatra" width="50px" height="50px" /> Nakshatra Finder </a></div>
<div class="col-4"><a class="content_links" title="Navamsha Chart" href="<?php echo Juri::base() ?>getnavamsha?chart=<?php echo $chart_id; ?>"><img src="images/navamsha.jpeg" alt="navamsha" width="50px" height="50px" /> Navamsha Chart</a></div>
<div class="col-4"><a class="content_links" title="Vimhshottari Dasha" href="<?php echo Juri::base() ?>getvimshottari?chart=<?php echo $chart_id; ?>"><img src="images/vimshottari.jpeg" alt="vimshottari" width="50px" height="50px" /> Vimshottari Dasha</a></div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Career</div>
<div class="row">
  <div class="col-4"><a class="content_links" title="career finder" href="<?php echo Juri::base() ?>careerfind?chart=<?php echo $chart_id; ?>"><img src="images/art_img/career.jpg" alt="career" width="50px" height="50px" /> Career Finder</a></div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Finances</div>
<div class="row">
  <div class="col-4"><a class="content_links" title="where to invest" href="<?php echo Juri::base() ?>investwhere?chart=<?php echo $chart_id; ?>"><img src="images/money.jpg" alt="money" width="50px" height="50px" /> Where To Invest</a></div>

</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Marriage</div>
<div class="row">
  <div class="col-4"><a class="content_links" title="Spouse Finder" href="<?php echo Juri::base() ?>findspouse?chart=<?php echo $chart_id; ?>"><img src="images/art_img/marriage.png" alt="marriage"  width="50px" height="50px" /> Spouse Finder</a></div>
  <div class="col-4"><a class="content_links" title="Chances of Love Marriage" href="<?php echo Juri::base() ?>lovemarry?chart=<?php echo $chart_id; ?>"><img src="images/art_img/love.png" alt="love"  width="70px" height="70px" /> Chances of Love Marriage</a></div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Divorce</div>
<div class="row">
    <div class="col-4"><a class="content_links" title="Mangal Dosha Calculator" href="<?php echo Juri::base() ?>mangaldosha?chart=<?php echo $chart_id; ?>"><img src="images/mars_dosha.png" alt="mdosha" width="50px" height="50px" /> Mangal Dosha Calculator</a></div>
  <div class="col-4"><a class="content_links" title="Chances of Divorce" href="<?php echo Juri::base() ?>divorce?chart=<?php echo $chart_id; ?>"><img src="images/divorce_clipart.jpeg" alt="divorce" width="50px" height="50px" /> Divorce Chances</a></div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Misc</div>
<div class="row">
    <div class="col-4"><a class="content_links" title="Astro Yogas" href="<?php echo Juri::base() ?>astroyogas?chart=<?php echo $chart_id; ?>"><img src="images/yogas.png" alt="yogas"  width="50px" height="50px" /> Astro Yogas</a></div>
    <div class="col-4"><a class="content_links" title="4 Stages" href="<?php echo Juri::base() ?>fourstage?chart=<?php echo $chart_id; ?>"><img src="images/four.png" alt="yogas"  width="50px" height="50px" /> Stages Of Life</a></div>

</div>
<div class="mb-3"></div>
