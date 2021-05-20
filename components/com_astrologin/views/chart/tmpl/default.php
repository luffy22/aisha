<!--<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><i class="fas fa-exclamation-circle"></i> Orders Closed!</strong> Orders are temporarily closed. We would begin taking orders from Friday 4th December 2020.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span></button></div>-->
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

//print_r($this->data);exit;
//print_r($this->usr);exit;
//print_r($this->pagination);exit;

?>
<p class="text-right">Welcome <?php echo $this->usr['username']; ?></p>
<a href="<?php echo Juri::base().'horologin' ?>"><button class="btn btn-primary btn-large"><i class="fas fa-user-plus"></i> Add</button></a>
<div class="mb-3"></div>
<table class="table table-bordered table-striped">
    <tr><th>No</th><th>Name</th><th>Date(d-m-y)</th><th>Time</th><th>Place</th><th><i class="fas fa-edit"></i></th><th><i class="fas fa-trash-alt"></i></th></tr>
<?php
    $i = 1;
foreach($this->data as $user)
{
    //echo $user->dob_tob;exit;
    $date   = new DateTime($user->dob_tob);
    $date   ->setTimeZone($user->timezone);
    //print_r($date);exit;
    
?>
<tr>
    <td><?php echo $i; ?></td>
    <td><a href="<?php echo JUri::base().'horoscope?chart='.$user->uniq_id ?>"><?php echo $user->fname; ?></a></td>
    <td><?php echo $date->format('d-m-Y'); ?></td>
    <td><?php echo $date->format('h:i a'); ?></td>
    <td><?php echo $user->city; ?></td>
</tr>
<?php 
$i      = $i+1;
}
?>
</table>
<div class="mb-4"></div>
<div class="pagination">
    <p class="counter pull-right">
        <?php echo $this->pagination->getPagesCounter(); ?>
    </p>
    <?php echo $this->pagination->getPagesLinks(); ?>
</div>
<?php
unset($this->data);unset($this->usr);unset($this->pagination);
?>

