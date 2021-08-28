<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
$curr_sign          = end($this->data);
$new_data           = $this->data;
array_pop($new_data);
//print_r($new_data);exit;
$counter        = 0;
?>
<div class="mb-3"></div>
<div class="lead alert alert-dark">Mars Transit</div>
<?php
for($i = 0; $i < count($new_data)/4;$i++)
{
    if($i % 2 == 0)
    {
?>
<div class="row">
<?php
    }
?>
    <div class="col-6">
<?php
        if($this->data['curr_sign'] == $this->data['sign_'.$i])
        {
?>
        <div class="card bg-light border-dark">
<?php
        }
        else
        {
?>
        <div class="card">    
<?php            
        }
?>
            <!--<img class="card-img-top" src="images/art_img/<?php //echo strtolower($this->data['sign_'.$i]) ?>.png" alt="Card image cap">-->
            <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><img src="images/art_img/<?php echo strtolower($this->data['sign_'.$i]) ?>.png" width="50px" height="50px" /> <p class="lead"> <?php echo $this->data['sign_'.$i]; ?></p></li>
                <li class="list-group-item"><?php echo $this->data['date_'.$i]; ?></li>
                <li class="list-group-item"><?php echo $this->data['time_'.$i]; ?></li>
                <li class="list-group-item"><?php echo $this->data['day_'.$i]; ?></li>
            </ul>
            </div>
        </div>
    </div>
<?php
    if($i % 2 !== 0)
    {
?>
    </div><div class="mb-4"></div>
<?php
    }
}
unset($new_data);
unset($this->data);
?>

