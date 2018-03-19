<script type="text/javascript">
function getAscDetails()
{
    document.getElementById("asc_details").submit();
}
function getMoonDetails()
{
    document.getElementById("moon_details").submit();
}
function getNakshatraDetails()
{
    document.getElementById("nakshatra_details").submit();
}
</script>
<?php
defined('_JEXEC') or die();
//print_r($this->data);exit;
$array = array($this->data['fname'],$this->data['gender'],str_replace("\/","-",$this->data['dob']),
                                  $this->data['tob'],$this->data['pob'],$this->data['lat'],
                                  $this->data['lon'],$this->data['tmz'], $this->data['dst']);
$array = json_encode($array);
?>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar1" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo JUri::base() ?>calculate-lagna" title="Navigate to Horoscope Form">Horoscope</a>
    </div>
    <div id="navbar1" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Planet Details</a></li>
          <li><a href="#" onclick="javascript:getAscDetails()">Ascendant</a></li>
          <li><a href="#" onclick="javascript:getMoonDetails();">Moon</a></li>
          <li><a href="#" onclick="javascript:getNakshatraDetails();">Nakshatra</a></li>
          <!--<li><form method="post"enctype="application/x-www-form-urlencoded" action="<?php //echo JRoute::_('index.php?option=com_horoscope&task=lagna.getnavamsha'); ?>"><input type="hidden" name="data" value="<?php //echo htmlspecialchars($array); ?>" /><input type="submit" class="navbar-brand navbar-inverse" value="Navamsha" /></form></li>-->
        </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
<div class="spacer"></div>
<h3>User Details</h3>
<table class="table table-striped">
    <tr>
        <th>Name</th>
        <td><?php echo ucfirst($this->data['fname']); ?></td>
    </tr>
    <tr>
        <th>Gender</th>
        <td><?php echo ucfirst($this->data['gender']); ?></td>
    </tr>
    <tr>
        <th>Date Of Birth</th>
        <td><?php echo $this->data['dob']; ?></td>
    </tr>
    <tr>
        <th>Time Of Birth</th>
        <td><?php echo $this->data['tob']; ?></td>
    </tr>
    <tr>
        <th>Place Of Birth</th>
        <td><?php echo $this->data['pob']; ?></td>
    </tr>
    <tr>
        <th>Latitude</th>
        <td><?php echo $this->data['lat']; ?></td>
    </tr>
    <tr>
        <th>Longitude</th>
        <td><?php echo $this->data['lon']; ?></td>
    </tr>
    <tr>
        <th>Time Zone</th>
        <td>GMT<?php echo $this->data['tmz']; ?></td>
    </tr>
    <tr>
        <th>Daylight Savings</th>
        <td><?php if($this->data['dst'] == '00:00:00')
                    { echo "None"; }
                  else
                  { echo $this->data['dst']; } ?></td>
    </tr>
</table>
<div class="spacer"></div>
<h3>Planetary Table</h3>
<div class="table-responsive">
<table class="table table-hover">
    <tr>
        <th>Planets</th>
        <th>Sign</th>
        <th>Sign Lord</th>
        <th>Distance</th>
        <th>Nakshatra</th>
        <th>Nakshatra Lord</th>
    </tr>
    <tr>
        <th>Ascendant</th>
        <td><?php echo $this->data['lagna_sign'] ?></td>
        <td><?php echo $this->data['lagna_sign_lord'] ?></td>
        <td><?php echo $this->data['lagna_distance'] ?></td>
        <td><?php echo $this->data['lagna_nakshatra'] ?></td>
        <td><?php echo $this->data['lagna_nakshatra_lord'] ?></td>
    </tr>
    <tr>
        <th>Sun</th>
        <td><?php echo $this->data['surya_sign']; ?></td>
        <td><?php echo $this->data['surya_sign_lord'] ?></td>
        <td><?php echo $this->data['surya_distance']; ?></td>
        <td><?php echo $this->data['surya_nakshatra'] ?></td>
        <td><?php echo $this->data['surya_nakshatra_lord'] ?></td>
    </tr>
    <tr>
        <th>Moon</th>
        <td><?php echo $this->data['moon_sign']; ?></td>
        <td><?php echo $this->data['moon_sign_lord'] ?></td>
        <td><?php echo $this->data['moon_distance']; ?></td>
        <td><?php echo $this->data['moon_nakshatra'] ?></td>
        <td><?php echo $this->data['moon_nakshatra_lord'] ?></td>
    </tr>
    <tr>
        <th>Mars</th>
        <td><?php echo $this->data['mangal_sign']; ?></td>
        <td><?php echo $this->data['mangal_sign_lord'] ?></td>
        <td><?php echo $this->data['mangal_distance']; ?></td>
        <td><?php echo $this->data['mangal_nakshatra'] ?></td>
        <td><?php echo $this->data['mangal_nakshatra_lord'] ?></td>
    </tr>
    <tr>
        <th>Mercury</th>
        <td><?php echo $this->data['budh_sign']; ?></td>
        <td><?php echo $this->data['budh_sign_lord'] ?></td>
        <td><?php echo $this->data['budh_distance']; ?></td>
        <td><?php echo $this->data['budh_nakshatra'] ?></td>
        <td><?php echo $this->data['budh_nakshatra_lord'] ?></td>
    </tr>
    <tr>
        <th>Jupiter</th>
        <td><?php echo $this->data['guru_sign']; ?></td>
        <td><?php echo $this->data['guru_sign_lord'] ?></td>
        <td><?php echo $this->data['guru_distance']; ?></td>
        <td><?php echo $this->data['guru_nakshatra'] ?></td>
        <td><?php echo $this->data['guru_nakshatra_lord'] ?></td>
    </tr>
    <tr>
        <th>Venus</th>
        <td><?php echo $this->data['shukra_sign']; ?></td>
        <td><?php echo $this->data['shukra_sign_lord'] ?></td>
        <td><?php echo $this->data['shukra_distance']; ?></td>
        <td><?php echo $this->data['shukra_nakshatra'] ?></td>
        <td><?php echo $this->data['shukra_nakshatra_lord'] ?></td>
    </tr>
    <tr>
        <th>Saturn</th>
        <td><?php echo $this->data['shani_sign']; ?></td>
        <td><?php echo $this->data['shani_sign_lord'] ?></td>
        <td><?php echo $this->data['shani_distance']; ?></td>
        <td><?php echo $this->data['shani_nakshatra'] ?></td>
        <td><?php echo $this->data['shani_nakshatra_lord'] ?></td>
    </tr>
    <tr>
        <th>Rahu</th>
        <td><?php echo $this->data['rahu_sign']; ?></td>
        <td><?php echo $this->data['rahu_sign_lord'] ?></td>
        <td><?php echo $this->data['rahu_distance']; ?></td>
        <td><?php echo $this->data['rahu_nakshatra'] ?></td>
        <td><?php echo $this->data['rahu_nakshatra_lord'] ?></td>
    </tr>
    <tr>
        <th>Ketu</th>
        <td><?php echo $this->data['ketu_sign']; ?></td>
        <td><?php echo $this->data['ketu_sign_lord'] ?></td>
        <td><?php echo $this->data['ketu_distance']; ?></td>
        <td><?php echo $this->data['ketu_nakshatra'] ?></td>
        <td><?php echo $this->data['ketu_nakshatra_lord'] ?></td>
    </tr>
</table>
</div>
<?php
unset(
        $this->data['surya_sign'],$this->data['surya_distance'],$this->data['surya_sign_lord'],$this->data['surya_nakshatra'],$this->data['surya_nakshatra_lord'],
        $this->data['moon_sign'],$this->data['moon_distance'],$this->data['moon_sign_lord'],$this->data['moon_nakshatra'],$this->data['moon_nakshatra_lord'],
        $this->data['mangal_sign'],$this->data['mangal_distance'],$this->data['mangal_sign_lord'],$this->data['mangal_nakshatra'],$this->data['mangal_nakshatra_lord'],
        $this->data['budh_sign'],$this->data['budh_distance'],$this->data['budh_sign_lord'],$this->data['budh_nakshatra'],$this->data['budh_nakshatra_lord'],
        $this->data['guru_sign'],$this->data['guru_distance'],$this->data['guru_sign_lord'],$this->data['guru_nakshatra'],$this->data['guru_nakshatra_lord'],
        $this->data['shukra_sign'],$this->data['shukra_distance'],$this->data['shukra_sign_lord'],$this->data['shukra_nakshatra'],$this->data['shukra_nakshatra_lord'],
        $this->data['shani_sign'],$this->data['shani_distance'],$this->data['shani_sign_lord'],$this->data['shani_nakshatra'],$this->data['shani_nakshatra_lord'],
        $this->data['rahu_sign'],$this->data['rahu_distance'],$this->data['rahu_sign_lord'],$this->data['rahu_nakshatra'],$this->data['rahu_nakshatra_lord'],
        $this->data['ketu_sign'],$this->data['ketu_distance'],$this->data['ketu_sign_lord'],$this->data['ketu_nakshatra'],$this->data['ketu_nakshatra_lord']
    );

?>
<form id="asc_details" method="post"enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('index.php?option=com_horoscope&task=lagna.getascendant'); ?>"><input type="hidden" name="data" value="<?php echo htmlspecialchars($array); ?>" /></form>
<form id="moon_details" method="post"enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('index.php?option=com_horoscope&task=lagna.getmoon'); ?>"><input type="hidden" name="data" value="<?php echo htmlspecialchars($array); ?>" /></form>
<form id="nakshatra_details" method="post"enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('index.php?option=com_horoscope&task=lagna.getnakshatra'); ?>"><input type="hidden" name="data" value="<?php echo htmlspecialchars($array); ?>" /></form>