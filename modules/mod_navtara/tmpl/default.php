<?php 
defined('_JEXEC') or die;
//print_r($current);exit;
//print_r($location);exit;
?>
<div class="card">
<div class="card-header lead alert alert-dark">Daily Fortune using Navtara</div>
<p class="text-end">Location: <?php echo $location['city'].", ".$location['country']; ?>&nbsp;<a href="#" class="btn btn-primary btn-small"><i class="bi bi-pencil"></i></a></p>
  <div class="card-body" id="navtara_form">
    <div class="row g-2">
  <div class="col-md">
    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInputGrid" placeholder="Enter your birth-time Moon Nakshatra" value="Birth-Time Nakshatra" disabled>
      <label for="floatingInputGrid">Nakshatra</label>
    </div>
  </div>
    <div class="col-md">
        <div class="form-floating">
        <select class="form-select form-select-lg" id="nakshatra_sel" aria-label="Selection Birth-Time Nakshatra">
        <?php
        foreach($nakshatra as $value)
        {
     ?>
            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
    <?php
        }
    ?>
      </select>
        </div>
    </div>
    </div>
    <div class="mb-3"></div>
    <div class="col-md">
    <button class="btn btn-primary" onclick="javascript:getForecast();">Get Forecast</button>
    </div>
    
  </div>
<ul class="list-group list-group-flush" id="navtara_body">
    <li class="list-group-item" id="birth_nak"></li>
    <li class="list-group-item" id="curr_nak"></li>
    <li class="list-group-item" id="demo"> </li>
</ul>
</div>
<div class="mb-3"></div>



