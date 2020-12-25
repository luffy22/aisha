<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
//echo dirname(__FILE__) . DS . "login.xml";exit;
$this->form->reset( true ); // to reset the form xml loaded by the view
$this->form->loadFile(dirname(__FILE__) . DS . "login.xml"); // to load in our own version of login.xml
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
//print_r($this->form);exit;

?>
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>
	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
		<div class="login-description">
	<?php endif; ?>
	<?php if ($this->params->get('logindescription_show') == 1) : ?>
		<?php echo $this->params->get('login_description'); ?>
	<?php endif; ?>
	<?php if ($this->params->get('login_image') != '') : ?>
		<img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JText::_('COM_USERS_LOGIN_IMAGE_ALT'); ?>" />
	<?php endif; ?>
	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
		</div>
	<?php endif; ?>
	<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" >
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="" class="form-control required" size="25" required="" aria-required="true" autofocus="">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="" class="form-control required" size="25" required="" aria-required="true" autofocus="">
        </div>
        <?php if ($this->tfa) : ?>
                <?php echo $this->form->renderField('secretkey'); ?>
        <?php endif; ?>
        <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
            <div class="mb-3"></div>    
        <div class="form-group">
        <label for="remember">
                <?php echo JText::_('COM_USERS_LOGIN_REMEMBER_ME'); ?>
        </label>
        <input id="remember" type="checkbox" name="remember" class="inputbox" value="yes" />
        </div>
        <?php endif; ?>
        <div class="control-group">
                <div class="controls">
                        <button type="submit" class="btn btn-primary">
                                <?php echo JText::_('JLOGIN'); ?>
                        </button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
        </div>
			<?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem'))); ?>
			<input type="hidden" name="return" value="<?php echo base64_encode($return); ?>" />
			<?php echo JHtml::_('form.token'); ?>
	</form>
<div class="mb-3"></div>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
                    <?php echo JText::_('COM_USERS_LOGIN_RESET'); ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
                    <?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?>
            </a>
        </li>
        <?php $usersConfig = JComponentHelper::getParams('com_users'); ?>
        <?php if ($usersConfig->get('allowUserRegistration')) : ?>
        <li class="nav-item">
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
                    <?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?>
            </a>
        </li>
        <?php endif; ?>
    </ul>


