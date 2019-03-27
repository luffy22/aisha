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
        $libPath        = JPATH_BASE.'/sweph/';
        $jinput         = JFactory::getApplication()->input;
        $date           = $jinput->get('date', 'default_value', 'filter');
        if($date == "default_value")
        {
            $date           = date('Y-m-d');
        }
        if(!isset($_COOKIE["loc"]) && !isset($_COOKIE["lat"]) &&
           !isset($_COOKIE["lon"]) && !isset($_COOKIE["tmz"])) {
            $loc            = "Ujjain, India";
            $timezone       = "Asia/Kolkata";
            $lon            = "75.78";  $lat            = "23.17";  $alt    = 0;
        } else {
           $loc         = $_COOKIE["loc"];
           $lat         = $_COOKIE["lat"];
           $lon         = $_COOKIE["lon"];
           $timezone    = $_COOKIE["tmz"];
           $alt         = 0;
        }
    }
}
