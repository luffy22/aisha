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
<style type="text/css">
.open-button {
  background-color: #555;
  color: white;
  padding: 10px 10px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  top: 10px;
  right: 10px;
  width: 140px;
}
.form-popup {
  display: none;
  position: fixed;
  top: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
  background-color: white;
} 
.form-container {
  padding: 10px;
  background-color: white;
}

</style>
<script type="text/javascript">
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>
<div class="container-fluid">
<div class="p-2 d-flex justify-content-end">
    <button class="btn btn-primary" onclick="openForm()">Login</button>
</div>
<div class="form-popup" id="myForm">
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form" class="form-container">
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
    <div class="form-row d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Log in</button>&nbsp;&nbsp;
        <button type="button" class="btn btn-danger" onclick="closeForm()">Close</button>
    </div>
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
</div>
</div>
<div class="mb-3"></div>

