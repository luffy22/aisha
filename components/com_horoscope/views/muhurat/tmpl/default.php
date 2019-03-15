<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
//print_r($this->data);exit;
$sunrise            = new DateTime($this->data['sun_rise_2']);
$sunset             = new DateTime($this->data['sun_set_2']);
$moonrise           = new DateTime($this->data['moon_rise_2']);
$moonset            = new DateTime($this->data['moon_set_2']);
$rahu_kaal_start    = new DateTime($this->data['rahu_kalam_start']);
$rahu_kaal_end      = new DateTime($this->data['rahu_kalam_end']);
$yama_kaal_start    = new DateTime($this->data['yama_kalam_start']);
$yama_kaal_end      = new DateTime($this->data['yama_kalam_end']);
$guli_kaal_start    = new DateTime($this->data['guli_kalam_start']);
$guli_kaal_end      = new DateTime($this->data['guli_kalam_end']);
$abhijit_start      = new DateTime($this->data['abhijit_start']);
$abhijit_end        = new DateTime($this->data['abhijit_end']);
?>
<body>
<div id="default_loc">
    <p>Location: <?php echo $this->data['location'] ?> <button class="btn btn-primary" onclick="javascript:showLocationForm();">Change Location</button></p>
</div>
<div id="loc_form">
<form class="form-inline" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_horoscope&task=muhurat.getMuhurat'); ?>">
  <label for="inlineFormInput">Location:&nbsp;</label>
    <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" name="muhurat_loc" id="muhurat_loc" placeholder="New Delhi, India" />
    <input type="hidden" id="muhurat_lat" name="muhurat_lat" />
    <input type="hidden" id="muhurat_lon" name="muhurat_lon" />
    <input type="hidden" id="muhurat_tmz" name="muhurat_tmz" />
    <button type="submit" class="btn btn-primary mr-sm-2" name="muhurat_submit">Go</button>
    <button type="button" class="btn btn-danger" onclick="javascript:hideLocationForm();">Cancel</button>
</form>
</div>
<div class="mb-3"></div>
<p>Vedic Calendar counts day from sunrise to sunset and night from sunset to next sunrise. Whole day is from sunrise to next sunrise.</p>
<div class="mb-3"></div>
<div class="lead alert alert-dark"><strong>Today's Muhurat, Chogadiya & Hora</strong></div>
<div class="mb-3"></div>
<ul class="nav nav-pills">
<li class="nav-item"><a class="nav-link active" href="#muhurat" data-toggle="tab">Muhurat</a></li>
<li class="nav-item"><a class="nav-link" href="#chogadiya" data-toggle="tab">Chogadiya</a></li>
<li class="nav-item"><a class="nav-link" href="#hora" data-toggle="tab">Hora</a></li>
</ul>
<div class="tab-content">
<div id="muhurat" class="tab-pane active">
<div class="mb-3"></div>
<table class="table table-striped table-bordered">
<tr><th><img src="images/clipart/sunrise.png" class="img-fluid" alt="sunrise" title="sunrise" /> Sunrise </th><td><?php echo $sunrise->format('h:i:s a');unset($sunrise); ?></td></tr>
<tr><th><img src="images/clipart/sunset.png" class="img-fluid" alt="sunset" title="sunset" /> Sunset </th><td><?php echo $sunset->format('h:i:s a');unset($sunset); ?></td></tr>
<tr><th><img src="images/clipart/moonrise.png" class="img-fluid" alt="moonset" title="moonrise" /> Moonrise </th><td><?php echo $moonrise->format('h:i:s a');unset($moonrise); ?></td></tr>
<tr><th><img src="images/clipart/moonset.png" class="img-fluid" alt="moonset" title="moonset" /> Moonset </th><td><?php echo $moonset->format('h:i:s a');unset($moonset); ?></td></tr>
<tr><th><img src="images/art_img/rahu.png" height="48px" width="48px" class="img-fluid" alt="rahu kaal" title="rahu kaal" /> Rahu Kaal(Bad) </th><td><?php echo $rahu_kaal_start->format('h:i:s a')." - ".$rahu_kaal_end->format('h:i:s a');unset($rahu_kaal_start);unset($rahu_kaal_end); ?></td></tr>
<tr><th><img src="images/clipart/yama.png" height="48px" width="48px" class="img-fluid" alt="yama kaal" title="yama kaal" />Yama Kaal(Bad) </th><td><?php echo $yama_kaal_start->format('h:i:s a')." - ".$yama_kaal_end->format('h:i:s a');unset($yama_kaal_start);unset($yama_kaal_end); ?></td></tr>
<tr><th><img src="images/clipart/gulika.png" height="48px" width="40px" class="img-fluid" alt="guli kaal" title="guli kaal" /> Guli Kaal(Bad) </th><td><?php echo $guli_kaal_start->format('h:i:s a')." - ".$guli_kaal_end->format('h:i:s a');unset($guli_kaal_start);unset($guli_kaal_end); ?></td></tr>
<tr><th><i class="fas fa-om fa-2x"></i> Abhijit Kaal(Auspicious)</th><td><?php echo $abhijit_start->format('h:i:s a')." - ".$abhijit_end->format('h:i:s a');unset($abhijit_start);unset($abhijit_end); ?></td></tr>
</table><div class="mb-3"></div>
</div>
<div id="chogadiya" class="tab-pane">
<div class="mb-3"></div>
<p>Chogadiya marked with <i class="fa fa-om"></i> sign besides them and green color background are auspicious to start any task. Others not so auspicious.</p>
<div class="mb-3"></div>
<div class="lead alert alert-dark"><strong>Day Chogadia</strong></div>
<table class="table table-bordered">
    <tr><th>Chogadiya</th><th>Duration</th></tr>
<?php
for($i=1;$i<9;$i++)
{
    $date_start         = new DateTime($this->data['day_chogad_start_'.$i]);
    $date_end         = new DateTime($this->data['day_chogad_end_'.$i]);
    if($this->data['day_chogad_'.$i] == "Labh" || $this->data['day_chogad_'.$i] == "Shubh"||$this->data['day_chogad_'.$i] == "Amrit")
    {
?>
    <tr class="bg-success"><th><?php echo $this->data['day_chogad_'.$i] ?> <i class="fas fa-om"></i></th><td><?php echo $date_start->format('h:i:s a')." - ".
                                                                                    $date_end->format('h:i:s a'); ?></td></tr>
<?php
    }
    else if($this->data['day_chogad_'.$i] == "Chal")
    {
?>
    <tr class="bg-warning"><th><?php echo $this->data['day_chogad_'.$i] ?></th><td><?php echo $date_start->format('h:i:s a')." - ".
                                                                                    $date_end->format('h:i:s a'); ?></td></tr>
<?php        
    }
    else if($this->data['day_chogad_'.$i] == "Kaal" || $this->data['day_chogad_'.$i] == "Rog"|| $this->data['day_chogad_'.$i] == "Udveg")
    {
?>
    <tr class="bg-danger"><th><?php echo $this->data['day_chogad_'.$i] ?></th><td><?php echo $date_start->format('h:i:s a')." - ".
                                                                                    $date_end->format('h:i:s a'); ?></td></tr>
<?php        
    }
unset($date_start);unset($date_end);
}
?>
</table>
<div class="mb-3"></div><br/>
<div class="lead alert alert-dark"><strong>Night Chogadia</strong></div>
<table class="table table-bordered">
<tr><th>Chogadiya</th><th>Duration</th></tr>
<?php
for($i=1;$i<9;$i++)
{
    $night_start         = new DateTime($this->data['night_chogad_start_'.$i]);
    $night_end         = new DateTime($this->data['night_chogad_end_'.$i]);
    if($this->data['night_chogad_'.$i] == "Labh" || $this->data['night_chogad_'.$i] == "Shubh"||$this->data['night_chogad_'.$i] == "Amrit")
    {
?>
    <tr class="bg-success"><th><?php echo $this->data['night_chogad_'.$i] ?> <i class="fas fa-om"></i></th><td><?php echo $night_start->format('h:i:s a')." - ".
                                                                                    $night_end->format('h:i:s a'); ?></td></tr>
<?php
    }
    else if($this->data['night_chogad_'.$i] == "Chal")
    {
?>
    <tr class="bg-warning"><th><?php echo $this->data['night_chogad_'.$i] ?></th><td><?php echo $night_start->format('h:i:s a')." - ".
                                                                                    $night_end->format('h:i:s a'); ?></td></tr>
<?php        
    }
    else if($this->data['night_chogad_'.$i] == "Kaal" || $this->data['night_chogad_'.$i] == "Rog"|| $this->data['night_chogad_'.$i] == "Udveg")
    {
?>
    <tr class="bg-danger"><th><?php echo $this->data['night_chogad_'.$i] ?></th><td><?php echo $night_start->format('h:i:s a')." - ".
                                                                                    $night_end->format('h:i:s a'); ?></td></tr>
<?php        
    }
unset($night_start);unset($night_end);
}
?>
</table>
<div class="mb-3"></div>
</div>
<div id="hora" class="tab-pane">
<div class="mb-3"></div>
<div class="lead alert alert-dark"><strong>Day Hora</strong></div>
<table class="table table-bordered table-striped">
    <tr><th>Hora</th><th>Duration</th></tr>
<?php
for($i=1;$i<13;$i++)
{
    $date_start         = new DateTime($this->data['day_hora_start_'.$i]);
    $date_end         = new DateTime($this->data['day_hora_end_'.$i]);
?>
    <tr><th><?php echo $this->data['day_hora_'.$i] ?></th><td><?php echo $date_start->format('h:i:s a')." - ".
                                                                                    $date_end->format('h:i:s a'); ?></td></tr>
<?php 
unset($date_start);unset($date_end);
    }
?>
</table>
<div class="mb-3"></div>
<div class="lead alert alert-dark"><strong>Night Hora</strong></div>
<table class="table table-bordered table-striped">
    <tr><th>Hora</th><th>Duration</th></tr>
<?php
for($i=1;$i<13;$i++)
{
    $date_start         = new DateTime($this->data['night_hora_start_'.$i]);
    $date_end         = new DateTime($this->data['night_hora_end_'.$i]);
?>
    <tr><th><?php echo $this->data['night_hora_'.$i] ?></th><td><?php echo $date_start->format('h:i:s a')." - ".
                                                                                    $date_end->format('h:i:s a'); ?></td></tr>
<?php 
unset($date_start);unset($date_end);
    }
?>
</table>
<div class="mb-3"></div>
</div>
</div>
<div class="mb-3"></div>
<p><strong>Kindly Note: </strong>AstroIsha doesn't wish anyone to be over-realiant on Muhurat, Chogadiya & Horas. In Sanskrit there is a terminology <strong>Shubhasya Shigram(शुभस्य शीघ्रम)</strong> which means start 
the auspicious work immediately.</p>
<div class="mb-3"></div>
<?php
unset($this->data);
?>
<div class="mb-1"></div>
<script type="text/javascript"  src="<?php echo JUri::base().'components'.DS.'com_horoscope'.DS.'script/muhurat.js' ?>">
</script>