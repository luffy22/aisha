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
$text       = $this->data['introtext'];
?>
<?php $chart_id = $_GET['chart']; ?>
<div class="mb-3"></div>
<div id="<?php echo $this->data['id']; ?>" class="accordion-id"></div>
<div class="lead alert alert-dark"><?php echo "You are born with Moon in ".$title ?></div>
<div class="mb-2"></div>
<?php echo $text; ?>
<?php unset($this->data); ?>
