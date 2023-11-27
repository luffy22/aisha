<?php
defined('_JEXEC') or die;
//print_r($tithi);exit;
?>
<div class="card">
<div class="card-header lead alert alert-dark">Daily Fortune using Tithi</div>
<div class="card-body" id="tithi_form">
	<h3 class="card-title text-center"><strong>Current Tithi: </strong><?php echo $tithi['tithi']; ?></h5>
	<p><strong>Paksha: </strong><?php echo $tithi['paksh']; ?></p>
	<p><strong>Tithi Type: </strong><?php echo $tithi['tithi_type']; ?></p>
	<p><?php echo $tithi['description']; ?></p>
</div>
</div>
<div class="mb-3"></div>
<?php
unset($tithi);
?>
