<?php
defined('_JEXEC') or die;  // No direct Access
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_horoscope/models/');
$model = JModelLegacy::getInstance('lagna', 'horoscopeModel');
$libPath = JPATH_BASE.'/sweph/';
putenv("PATH=$libPath");
class HoroscopeModelPanchang extends HoroscopeModelLagna
{
    public function getData()
    {
        $today      = date('d-m-Y');
        $tmz        = "Asia/Kolkata";
        $lon        = "75.78";$lat      = "23.17";  $alt    = 0;
        $date       = new DateTime($today, new DateTimeZone($tmz));
        $sunrise    = $this->getSunTimings($date->format('Y-m-d'), $tmz,$lat,$lon,$alt, 2);
        $moonrise   = $this->getMoonTimings($date->format('Y-m-d'), $tmz, $lat, $lon, $alt, 2);
        return array("date"=>$date->format('dS F Y'),"day_today"=>$date->format('l'),
                      $sunrise, $moonrise);
    }
}