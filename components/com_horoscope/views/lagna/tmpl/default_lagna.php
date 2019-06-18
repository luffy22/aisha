<html>
 <head>
     <title>Get Horoscope Details</title>
<!-- <style type="text/css">
#horo_canvas{width: 100%;padding: 0 !important;margin: 0 !important;}@media (min-width: 768px) {#horo_canvas{width:65%}}
</style>-->
</head>
<body>
<?php $chart_id = $_GET['chart']; ?>
<div class="lead alert alert-dark">Horoscope</div>
<div class="row">
  <div class="col-sm-3">
    <div class="card">
        <a href="<?php echo Juri::base() ?>mainchart?chart=<?php echo $chart_id; ?>" title="main chart"><img class="card-img-top" src="images/mainchart.jpeg" class="img-fluid" alt="main" /></a>
      <div class="card-body">
          <h5 class="card-title"><a href="<?php echo Juri::base() ?>mainchart?chart=<?php echo $chart_id; ?>" title="main chart">Main Chart</a></h5>
        <p class="card-text">Get birth and planetary details</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
        <a href="<?php echo Juri::base() ?>getasc?chart=<?php echo $chart_id; ?>" title="ascendant chart"><img class="card-img-top" class="img-fluid" src="images/horo.jpeg" alt="ascendant" /></a>
      <div class="card-body">
          <h5 class="card-title"><a href="<?php echo Juri::base() ?>getasc?chart=<?php echo $chart_id; ?>" title="ascendant chart">Ascendant Chart</a></h5>
        <p class="card-text">Find out your ascendant</p>
      </div>
    </div>
  </div>
    <div class="col-sm-3">
    <div class="card">
        <a href="<?php echo Juri::base() ?>getmoon?chart=<?php echo $chart_id; ?>" title="moon sign"><img class="card-img-top" class="img-fluid" src="images/art_img/moon.png" alt="moon" /></a>
      <div class="card-body">
          <h5 class="card-title"><a href="<?php echo Juri::base() ?>getmoon?chart=<?php echo $chart_id; ?>" title="moon sign">Moon Sign</a></h5>
        <p class="card-text">Find out your moon sign</p>
      </div>
    </div>
  </div>
    <div class="col-sm-3">
    <div class="card">
        <a href="<?php echo Juri::base() ?>getnakshatra?chart=<?php echo $chart_id; ?>" title="nakshatra"><img class="card-img-top" class="img-fluid" src="images/nakshatra.jpeg" alt="nakshatra" /></a>
      <div class="card-body">
          <h5 class="card-title"><a href="<?php echo Juri::base() ?>getnakshatra?chart=<?php echo $chart_id; ?>" title="nakshatra">Nakshatra</a></h5>
        <p class="card-text">Find out your birth time nakshatra</p>
      </div>
    </div>
    </div>
</div>
<div class="mb-3"></div>
<div class="row">
  <div class="col-sm-3">
    <div class="card">
        <a href="<?php echo Juri::base() ?>getnavamsha?chart=<?php echo $chart_id; ?>" title="navamsha chart"><img class="card-img-top" class="img-fluid" src="images/navamsha.jpeg" alt="navamsha" /></a>
      <div class="card-body">
          <h5 class="card-title"><a href="<?php echo Juri::base() ?>getnavamsha?chart=<?php echo $chart_id; ?>" title="navamsha chart">Navamsha Chart</a></h5>
        <p class="card-text">Get details about navamsha chart</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
        <a href="<?php echo Juri::base() ?>getvimshottari?chart=<?php echo $chart_id; ?>" title="vimshottari dasha"><img class="card-img-top" src="images/vimshottari.jpeg" alt="vimshottari" /></a>
      <div class="card-body">
          <h5 class="card-title"><a href="<?php echo Juri::base() ?>getvimshottari?chart=<?php echo $chart_id; ?>" title="vimshottari dasha">Vimshottari Dasha</a></h5>
        <p class="card-text">Find out period-subperiod of vimshottari dasha</p>
      </div>
    </div>
  </div>
</div>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Marriage</div>
<div class="row">
  <div class="col-sm-3">
    <div class="card">
        <a href="<?php echo Juri::base() ?>findspouse?chart=<?php echo $chart_id; ?>&back=fspouse" title="spouse finder"><img class="card-img-top" class="img-fluid" src="images/art_img/marriage.png" alt="marriage" /></a>
      <div class="card-body">
          <h5 class="card-title"><a href="<?php echo Juri::base() ?>findspouse?chart=<?php echo $chart_id; ?>&back=fspouse" title="spouse finder">Spouse Finder</a></h5>
        <p class="card-text">Check out how to attract future spouse</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
        <a href="<?php echo Juri::base() ?>mangaldosha?chart=<?php echo $chart_id; ?>&back=mdosha" title="mangal dosha"><img class="card-img-top" class="img-fluid" src="images/art_img/mars.png" alt="mangal" /></a>
      <div class="card-body">
          <h5 class="card-title"><a href="<?php echo Juri::base() ?>mangaldosha?chart=<?php echo $chart_id; ?>&back=mdosha" title="mangal dosha">Mangal Dosha</a></h5>
        <p class="card-text">Check if you have mangal dosha</p>
      </div>
    </div>
  </div>
</div>
<div class="mb-3"></div>
