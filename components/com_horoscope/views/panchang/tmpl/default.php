<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
//print_r($this->data);
$sunrise        = new DateTime($this->data[0]['sun_rise_2']);
$sunset         = new DateTime($this->data[0]['sun_set_2']);
$moonrise       = new DateTime($this->data[1]['moon_rise_2']);
$moonset        = new DateTime($this->data[1]['moon_set_2']);
?>
<table class="table table-bordered table-striped">
    <tr>
        <th><i class="far fa-2x fa-calendar-alt"></i> Date</th><td><?php echo $this->data['date']; ?></td>
    </tr>
    <tr>
        <th><img src="/aisha/images/clipart/sunrise.png" class="img-fluid" alt="sunrise" title="sunrise" /> Sunrise</th><td><?php echo $sunrise->format('h:i:s a'); ?></td>
    </tr>
    <tr>
        <th><img src="/aisha/images/clipart/sunset.png" class="img-fluid" alt="sunset" title="sunset" /> Sunset</th><td><?php echo $sunset->format('h:i:s a'); ?></td>
    </tr>
    <tr>
        <th><img src="/aisha/images/clipart/moonrise.png" class="img-fluid" alt="moonset" title="moonrise" /> Moonrise</th><td><?php echo $moonrise->format('h:i:s a'); ?></td>
    </tr>
    <tr>
        <th><img src="/aisha/images/clipart/moonset.png" class="img-fluid" alt="moonset" title="moonset" /> Moonset</th><td><?php echo $moonset->format('h:i:s a'); ?></td>
    </tr>
</table>
<div class="mb-3"></div>
<div class="lead alert alert-dark"><strong>Today's Panchang</strong></div>
<table class="table table-bordered table-striped">
    <tr>
        <th><i class="far fa-2x fa-calendar"></i> Day</th><td><?php echo $this->data['day_today']; ?></td>
    </tr>
</table>
<?php
//echo "panchang for today";
unset($this->data);
?>

