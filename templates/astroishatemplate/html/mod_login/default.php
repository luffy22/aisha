<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('UsersHelperRoute', JPATH_SITE . '/components/com_users/helpers/route.php');

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');

?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form">
    <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputUsername">Username</label>
          <input type="text" name="username" class="form-control" id="inputEmail4" placeholder="Enter Username...">
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Password</label>
          <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <div class="form-check">
            <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                <input id="modlgn-remember" type="checkbox" name="remember" class="form-check-input" value="yes"/>
                <label for="modlgn-remember" class="form-check-label"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME'); ?></label> 
            <?php endif; ?>
        </div>
    </div>
    <div class="text-right"><button type="submit" class="btn btn-primary">Log in</button></div>
    <input type="hidden" name="option" value="com_users" />
    <input type="hidden" name="task" value="user.login" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
    <?php echo JHtml::_('form.token'); ?>
    <?php if ($params->get('posttext')) : ?>
        <div class="posttext">
                <p><?php echo $params->get('posttext'); ?></p>
        </div>
    <?php endif; ?>
</form><div class="mb-3"></div>
<p class="text-right">
<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
					<?php echo JText::_('MOD_LOGIN_REGISTER'); ?> <span class="icon-arrow-right"></span></a></p>
<div class="mb-3"></div>
