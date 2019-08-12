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
<div class="col-4"><a class="content_links" title="Main Chart" href="<?php echo Juri::base() ?>mainchart?chart=<?php echo $chart_id; ?>"><span> <img src="images/mainchart.jpeg" width="50px" height="50px" alt="main" />&nbsp;Main Chart</span> </a></div>
<div class="col-4"><a class="content_links" title="Ascendant Chart" href="<?php echo Juri::base() ?>getasc?chart=<?php echo $chart_id; ?>"> <span> <img src="images/horo.jpeg" alt="ascendant" width="50px" height="50px" />&nbsp;Ascendant Chart</span></a></div>
<div class="col-4"><a class="content_links" title="Moon Chart" href="<?php echo Juri::base() ?>getmoon?chart=<?php echo $chart_id; ?>"> <span> <img src="images/art_img/moon.png" alt="moon" width="50px" height="50px" />&nbsp;Moon Chart</span></a></div>
</div>
<div class="mb-3"></div>
<div class="row">
<div class="col-4"><a class="content_links" title="nakshatra finder" href="<?php echo Juri::base() ?>getnakshatra?chart=<?php echo $chart_id; ?>"> <span> <img src="images/nakshatra.jpeg" alt="nakshatra" width="50px" height="50px" />&nbsp;Nakshatra Finder</span></a></div>
<div class="col-4"><a class="content_links" title="Navamsha Chart" href="<?php echo Juri::base() ?>getnavamsha?chart=<?php echo $chart_id; ?>"> <span> <img src="images/navamsha.jpeg" alt="navamsha" width="50px" height="50px" />&nbsp;Navamsha Chart</span></a></div>
<div class="col-4"><a class="content_links" title="Vimhshottari Dasha" href="<?php echo Juri::base() ?>getvimshottari?chart=<?php echo $chart_id; ?>"> <span> <img src="images/vimshottari.jpeg" alt="vimshottari" width="50px" height="50px" />&nbsp;Vimshottari Dasha</span></a></div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Marriage</div>
<div class="row">
    <div class="col-4"><a class="content_links" title="Spouse Finder" href="<?php echo Juri::base() ?>findspouse?chart=<?php echo $chart_id; ?>&back=fspouse"> <span> <img src="images/art_img/marriage.png" alt="marriage"  width="50px" height="50px" />&nbsp;Spouse Finder</span></a></div>
    <div class="col-4"><a class="content_links" title="Mangal Dosha Calculator" href="<?php echo Juri::base() ?>mangaldosha?chart=<?php echo $chart_id; ?>&back=mdosha"> <span> <img src="images/mars_dosha.png" alt="mdosha" width="50px" height="50px" />&nbsp;Mangal Dosha Calculator</span> </a></div>    
</div>
<div class="mb-3"></div>
