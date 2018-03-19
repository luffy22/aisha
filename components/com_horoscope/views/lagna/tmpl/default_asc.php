<script type="text/javascript">
function getPlanetDetails()
{
    document.getElementById("planet_details").submit();
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
            <li><a href="#" onclick="javascript:getPlanetDetails();">Planet Details</a></li>
          <li class="active"><a href="#">Ascendant</a></li>
          <li><a href="#" onclick="javascript:getMoonDetails();">Moon</a></li>
          <li><a href="#" onclick="javascript:getNakshatraDetails();">Nakshatra</a></li>
          <!--<li><form method="post"enctype="application/x-www-form-urlencoded" action="<?php //echo JRoute::_('index.php?option=com_horoscope&task=lagna.getnavamsha'); ?>"><input type="hidden" name="data" value="<?php //echo htmlspecialchars($array); ?>" /><input type="submit" class="navbar-brand navbar-inverse" value="Navamsha" /></form></li>-->
        </ul>
    </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>
<div class="spacer"></div>
<div id="<?php echo $this->data['id']; ?>" class="accordion-id"></div>
<div class="spacer"></div>
<h3>Your Ascendant is: <?php echo $this->data['lagna_sign'] ?></h3>
<?php
echo $this->data['introtext'];

unset($this->data['introtext'],$this->data['id']);
?>
<form id="planet_details" method="post"enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('index.php?option=com_horoscope&task=lagna.getdetails'); ?>">
              <input type="hidden" name="data" value="<?php echo htmlspecialchars($array); ?>" /></form>
<form id="moon_details" method="post"enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('index.php?option=com_horoscope&task=lagna.getmoon'); ?>"><input type="hidden" name="data" value="<?php echo htmlspecialchars($array); ?>" /></form>
<form id="nakshatra_details" method="post"enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('index.php?option=com_horoscope&task=lagna.getnakshatra'); ?>"><input type="hidden" name="data" value="<?php echo htmlspecialchars($array); ?>" /></form>