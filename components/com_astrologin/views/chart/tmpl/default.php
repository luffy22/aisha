<!--<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><i class="fas fa-exclamation-circle"></i> Orders Closed!</strong> Orders are temporarily closed. We would begin taking orders from Friday 4th December 2020.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span></button></div>-->
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$details                    = $this->msg;
//print_r($details);exit;
//echo "calls";exit;

?>
<p class="text-right">Welcome <?php echo $details['username'] ?></p>
<button class="btn btn-primary btn-large"><i class="fas fa-user-plus"></i> Add Horoscope</button>
<?php 
unset($details);unset($this->msg);
?>

