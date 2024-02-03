<?php
defined('_JEXEC') or die;
//print_r($tithi);exit;
?>
<div class="card">
<div class="card-header lead alert alert-dark">Daily Fortune using Tithi</div>
<div class="card-body" id="tithi_form">
<ul class="list-group list-group-flush" id="tithi_body">
    <li class="list-group-item" id="curr_tithi"><strong>Current Tithi: </strong><?php echo $tithi['tithi']; ?></li>
    <li class="list-group-item" id="curr_paksh"><strong>Paksha: </strong><?php echo $tithi['paksh']; ?></li>
    <li class="list-group-item" id="tithi_type"><strong>Tithi Type: </strong><?php echo $tithi['tithi_type']; ?></li>
    <li class="list-group-item" id="tithi_desc"><?php echo $tithi['description']; ?></li>
</ul>
</div>
</div>
<div class="mb-3"></div>
<?php
unset($tithi);
?>
