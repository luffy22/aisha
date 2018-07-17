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
<div id="<?php echo $this->data['id']; ?>" class="accordion-id"></div>
<h3><?php echo "Your Moon Sign is ".str_replace(" Sign","", $title) ?></h3>
<div class="mb-2"></div>
<?php echo $text; ?>