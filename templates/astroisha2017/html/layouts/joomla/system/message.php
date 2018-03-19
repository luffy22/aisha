<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$msgList = $displayData['msgList'];

if (is_array($msgList) && !empty($msgList)) : ?>
    <?php foreach ($msgList as $type => $msgs) : ?>
        <div class="alert alert-<?php if($type=="error"){echo "danger";}else{echo $type;} ?> alert-dismissible fade in">
                <?php // This requires JS so we should add it trough JS. Progressive enhancement and stuff. ?>
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php if (!empty($msgs)) : ?>
        <h4 class="alert-heading"><?php echo JText::_($type); ?></h4>
            <div>
        <?php foreach ($msgs as $msg) : ?>
                    <?php echo $msg; ?>
        <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

