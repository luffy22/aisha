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
$id         = $this->data['id'];
$title      = $this->data['title'];
if(strpos($title, "Females"))
{
    $title      = str_replace(" Ascendant Females", "", $title);
}
else
{
    $title      = str_replace(" Ascendant Males","", $title);
}
$text       = $this->data['introtext'];
?>
<div id="<?php echo $this->data['id']; ?>" class="accordion-id"></div>
<h3><?php echo "Your Ascendant is ".$title; ?></h3>
<?php echo $text; ?>
