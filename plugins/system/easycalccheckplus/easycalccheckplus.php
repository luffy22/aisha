<?php
/**
 * @Copyright
 * @package        EasyCalcCheck Plus - ECC+ for Joomla! 3
 * @author         Viktor Vogel <admin@kubik-rubik.de>
 * @version        3.1.4 - 2018-01-31
 * @link           https://joomla-extensions.kubik-rubik.de/ecc-easycalccheck-plus
 *
 * @license        GNU/GPL
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');

class PlgSystemEasyCalcCheckPlus extends JPlugin
{
	protected $app;
	protected $autoloadLanguage = true;
	protected $custom_call;
	protected $debug_plugin;
	protected $extension_info;
	protected $load_ecc;
	protected $load_ecc_check;
	protected $redirect_url;
	protected $request;
	protected $session;
	protected $user;
	protected $warning_shown;

	function __construct(&$subject, $config)
	{
		$this->app = JFactory::getApplication();
		$this->loadLanguage('plg_system_easycalccheckplus', JPATH_ADMINISTRATOR);

		// Check Joomla version
		$version = new JVersion();

		if($version->PRODUCT == 'Joomla!' AND $version->RELEASE < '3.0')
		{
			$this->app->enqueueMessage(JText::_('PLG_ECC_WRONGJOOMLAVERSION'), 'error');

			return;
		}

		parent::__construct($subject, $config);

		$this->load_ecc = false;
		$this->load_ecc_check = false;
		$this->session = JFactory::getSession();
		$this->extension_info = array();

		$this->redirect_url = $this->session->get('redirect_url', null, 'easycalccheck');
		$this->session->clear('redirect_url', 'easycalccheck');

		if(empty($this->redirect_url))
		{
			$this->redirect_url = JUri::getInstance()->toString();
		}

		$this->request = $this->app->input;
		$this->user = JFactory::getUser();

		// Check whether the debug plugin is activated - important workaround for Joomla! 3.x
		// This is important because if the plugin is activated, then the input request variables are set before ECC+
		// can decode them back. This means that the components do not use the correct request variables if the option
		// "Encode all fields" is used in ECC+. If the plugin is activated, then we can not use the encode functionality!
		$this->debug_plugin = false;

		if(JPluginHelper::isEnabled('system', 'debug'))
		{
			$this->debug_plugin = true;
		}
	}

	/**
	 * Purge Cache, Bot-Trap, SQL Injection Protection & Backend Token
	 */
	function onAfterInitialise()
	{
		// Okay, if we use the encoding option, then we have to decode all fields as soon as possible to avoid errors
		// Decode all input fields but only if debug plugin is not used
		if($this->params->get('encode') AND empty($this->debug_plugin))
		{
			$this->decodeFields();
		}

		// Clean page cache if System Cache plugin is enabled
		if(JPluginHelper::isEnabled('system', 'cache'))
		{
			$cache_id = JUri::getInstance()->toString();

			if(version_compare(JVersion::RELEASE, '3.8', 'ge'))
			{
				$cache_id = md5(serialize(array(JUri::getInstance()->toString())));
			}

			$cache = JCache::getInstance('page');
			$cache->remove($cache_id, 'page');
		}

		// Bot-Trap
		// Further informations: http://www.bot-trap.de
		// File has to be named page.restrictor.php and be saved in plugins/system/easycalccheckplus/bottrap/
		if($this->params->get('bottrap'))
		{
			// Set correct path to the helper PHP file
			$path = 'plugins/system/easycalccheckplus/bottrap/';

			if($this->app->isAdmin())
			{
				$path = '../plugins/system/easycalccheckplus/bottrap/';
			}

			// File exists, then set the white / black lists and do the global check
			if(file_exists($path.'page.restrictor.php'))
			{
				if($this->params->get('btWhitelistIP'))
				{
					$btWhitelistIP = str_replace(',', '|', $this->params->get('btWhitelistIP'));
					define('PRES_WHITELIST_IP', $btWhitelistIP);
				}

				if($this->params->get('btWhitelistIPRange'))
				{
					$btWhitelistIPRange = str_replace(',', '|', $this->params->get('btWhitelistIPRange'));
					define('PRES_WHITELIST_IPR', $btWhitelistIPRange);
				}

				if($this->params->get('btWhitelistUA'))
				{
					$btWhitelistUA = str_replace(',', '|', $this->params->get('btWhitelistUA'));
					define('PRES_WHITELIST_UA', $btWhitelistUA);
				}

				if($this->params->get('btBlacklistIP'))
				{
					$btBlacklistIP = str_replace(',', '|', $this->params->get('btBlacklistIP'));
					define('PRES_BLACKLIST_IP', $btBlacklistIP);
				}

				if($this->params->get('btBlacklistIPRange'))
				{
					$btBlacklistIPRange = str_replace(',', '|', $this->params->get('btBlacklistIPRange'));
					define('PRES_BLACKLIST_IPR', $btBlacklistIPRange);
				}

				if($this->params->get('btBlacklistUA'))
				{
					$btBlacklistUA = str_replace(',', '|', $this->params->get('btBlacklistUA'));
					define('PRES_BLACKLIST_UA', $btBlacklistUA);
				}

				include_once($path.'page.restrictor.php');
			}
			else
			{
				$this->app->enqueueMessage(JText::_('PLG_ECC_ERRORBOTTRAP'), 'error');
			}
		}

		// Based on Marco's SQL Injection Plugin
		// Further informations: http://www.mmleoni.net/sql-iniection-lfi-protection-plugin-for-joomla
		if($this->params->get('sqlinjection-lfi'))
		{
			foreach(explode(',', 'GET,POST,REQUEST') as $name_space)
			{
				if($name_space == 'GET')
				{
					$name_space = $this->request->getArray($_GET);
				}
				elseif($name_space == 'POST')
				{
					$name_space = $this->request->getArray($_POST);
				}
				elseif($name_space == 'REQUEST')
				{
					$name_space = $this->request->getArray($_REQUEST);
				}

				if(!empty($name_space))
				{
					foreach($name_space as $k => $v)
					{
						if(is_numeric($v) OR is_array($v))
						{
							continue;
						}

						$a = preg_replace('@/\*.*?\*/@s', ' ', $v);

						if(preg_match('@UNION(?:\s+ALL)?\s+SELECT@i', $a))
						{
							throw new Exception(JText::_('PLG_ECC_INTERNALERRORSQLINJECTION'), 500);
						}

						$p_dbprefix = $this->app->get('dbprefix');
						$ta = array('/(\s+|\.|,)`?(#__)/',
						            '/(\s+|\.|,)`?(jos_)/i',
						            "/(\s+|\.|,)`?({$p_dbprefix}_)/i");

						foreach($ta as $t)
						{
							if(preg_match($t, $v))
							{
								throw new Exception(JText::_('PLG_ECC_INTERNALERRORSQLINJECTION'), 500);
							}
						}

						if(in_array($k, array('controller',
						                      'view',
						                      'model',
						                      'template')))
						{
							$recurse = str_repeat('\.\.\/', 2);

							while(preg_match('@'.$recurse.'@', $v))
							{
								throw new Exception(JText::_('PLG_ECC_INTERNALERRORSQLINJECTION'), 500);
							}
						}

						unset($v);
					}
				}
			}
		}

		// Backend protection
		if($this->params->get('backendprotection'))
		{
			if($this->app->isAdmin())
			{
				if($this->user->guest)
				{
					$token = $this->params->get('token');
					$request_token = $this->request->get('token', 0, 'RAW');
					$tokensession = $this->session->get('token', null, 'easycalccheck');

					if(!isset($tokensession))
					{
						$this->session->set('token', 0, 'easycalccheck');
					}

					if(utf8_encode($request_token) == $token) // Conversion to UTF8 (german umlauts)
					{
						$this->session->set('token', 1, 'easycalccheck');
					}
					elseif(utf8_encode($request_token) != $token)
					{
						if(empty($tokensession))
						{
							$url = $this->params->get('urlfalsetoken');

							if(empty($url))
							{
								$url = JUri::root();
							}

							$this->session->clear('token', 'easycalccheck');
							$this->redirect($url);
						}
					}
				}
			}
		}
	}

	/**
	 * Decodes encoded fields
	 *
	 * @since 2.5-8
	 */
	private function decodeFields()
	{
		$encoded_variables_session = $this->session->get('fields_encoded', '', 'easycalccheck_encode');

		if(!empty($encoded_variables_session))
		{
			$form = array();
			$encoded_variables = unserialize(base64_decode($encoded_variables_session));

			foreach($encoded_variables as $key => $value)
			{
				$value_request = $this->request->get($value, null, 'STRING');

				// Decode variable only if it is set!
				if(isset($value_request))
				{
					// Is this decoded variable trasmitted in the request?
					if(!empty($value_request))
					{
						// If key is an array, then handle it correctly
						if(preg_match('@(.*)\[(.+)\]@isU', $key, $matches))
						{
							$form[$matches[1]][$matches[2]] = $value_request;
						}
						else
						{
							$form[$key] = $value_request;
						}

						// Unset the decoded variable from the request
						$this->request->set($value, '');

						continue;
					}

					// If key is an array, then handle it correctly
					if(preg_match('@(.*)\[(.+)\]@isU', $key, $matches))
					{
						$form[$matches[1]][$matches[2]] = '';
					}
					else
					{
						$form[$key] = '';
					}

					// Unset the decoded variable from the request
					$this->request->set($value, '');
				}
			}

			// Set the decoded fields back to the request variable
			foreach($form as $key => $value)
			{
				$this->request->set($key, $value);

				// We also need to set the variable to the global $_POST variable - needed for the token check of the components
				// Do not use the API because we need first to gather all information - set variables directly
				$_POST[$key] = $value;
			}

			$this->session->clear('fields_encoded', 'easycalccheck_encode');
		}
	}

	/**
	 * Redirects if spamcheck was not passed successfully
	 *
	 * @param string $redirect_url
	 */
	private function redirect($redirect_url)
	{
		// PHP Redirection
		header('Location: '.$redirect_url);

		// JS Redirection - as fallback
		?>
		<script type="text/javascript">window.location = '<?php echo $redirect_url; ?>'</script>
		<?php
		// White page - if redirection doesn't work
		jexit(JText::_('PLG_ECC_YOUHAVENOTRESOLVEDOURSPAMCHECK'));
	}

	/**
	 * Detects whether the plugin routine has to be loaded and call the checks
	 */
	function onAfterRoute()
	{
		// Check whether ECC has to be loaded
		$option = $this->request->get('option', '', 'WORD');
		$view = $this->request->get('view', '', 'WORD');
		$task = $this->request->get('task', '', 'CMD');
		$func = $this->request->get('func', '', 'WORD');
		$layout = $this->request->get('layout', '', 'WORD');

		$this->loadEcc($option, $task, $view, $func, $layout);

		// If the custom call is activated, then the input has to be checked here to intercept the process handling of the extension
		if($this->params->get('custom_call') AND $this->loadEccCustom())
		{
			// Load error notice if needed
			$this->raiseErrorWarning($option, true);

			// Determine whether the check was already loaded and the data have to be validated
			$check_custom_call = (array)$this->session->get('check_custom_call', null, 'easycalccheck');
			$this->session->clear('check_custom_call', 'easycalccheck');

			if(!empty($check_custom_call))
			{
				// Get all request variables for the check
				$request = $this->request->getArray($_REQUEST);

				// Go through all request variable until one hit to check whether the form was submitted by the user
				foreach($check_custom_call as $request_variable)
				{
					if(array_key_exists($request_variable, $request))
					{
						// Clean cache
						$this->cleanCache();

						// Save entered values in session for autofill
						if($this->params->get('autofill_values'))
						{
							$this->saveData();
						}

						// Do the checks to protect the custom form
						if(!$this->performChecks())
						{
							// Set error session variable for the message output
							$this->session->set('error_output', 'check_failed_custom', 'easycalccheck');
							$this->redirect($this->redirect_url);
						}

						break;
					}
				}
			}
		}

		// Clean cache of component if ECC+ has to be loaded
		if($this->load_ecc_check == true OR $this->load_ecc == true)
		{
			$this->cleanCache();
		}

		if($this->load_ecc_check == true)
		{
			// Save entered values in session for autofill
			if($this->params->get('autofill_values'))
			{
				$this->saveData();
			}

			// Call checks for forms
			$this->callChecks($option, $task);
		}

		if($this->load_ecc == true)
		{
			// Raise error warning if needed - do the check
			$this->raiseErrorWarning($option);

			// Write head data
			$head = array();
			$head[] = '<style type="text/css">#easycalccheckplus {margin: 8px 0 !important; padding: 2px !important;}</style>';

			if($option == "com_flexicontactplus" AND $this->params->get('flexicontactplus'))
			{
				$head[] = '<style type="text/css">#easycalccheckplus label {width: auto;}</style>';
			}

			if($option == 'com_comprofiler' AND $this->params->get('communitybuilder'))
			{
				$head[] = '<style type="text/css">#easycalccheckplus label {width: 100%;} #easycalccheckplus input {height: 34px;}</style>';
			}

			if($this->params->get('poweredby'))
			{
				$head[] = '<style type="text/css">.protectedby {font-size: x-small !important; text-align: right !important;}</style>';
			}

			if($this->params->get('type_hidden'))
			{
				$this->session->set('hidden_class', $this->random(), 'easycalccheck');
				$head[] = '<style type="text/css">.'.$this->session->get('hidden_class', null, 'easycalccheck').' {display: none !important;}</style>';

				if($this->params->get('foxcontact') AND $option == "com_foxcontact")
				{
					$head[] = '<style type="text/css">label.'.$this->session->get('hidden_class', null, 'easycalccheck').' {margin: 0 !important; padding: 0 !important;}</style>';
				}
			}

			if($option == 'com_kunena' AND $this->params->get('kunena') AND $this->params->get('recaptcha'))
			{
				$head[] = '<style type="text/css">div#recaptcha_area{margin: auto !important;}</style>';
			}

			if($option == 'com_kunena' AND $this->params->get('kunena'))
			{
				$head[] = '<style type="text/css">a#btn_qreply{display:none;}</style>';
			}

			if($this->params->get('recaptcha'))
			{
				$this->getRecaptchaHead($head);
			}

			$head = "\n".implode("\n", $head)."\n";
			$document = JFactory::getDocument();

			if($document->getType() == 'html')
			{
				$document->addCustomTag($head);
			}
		}

		// Workaround for Kunena - Remove Quick Reply button, only allow full editor replies
		if($option == 'com_kunena' AND $this->params->get('kunena'))
		{
			if($this->user->guest)
			{
				$document = JFactory::getDocument();

				if($document->getType() == 'html')
				{
					$document->addCustomTag('<style type="text/css">a#btn_qreply{display:none;}</style>');
				}
			}
		}
	}

	/**
	 * Creates the head information for the reCaptcha implementation
	 *
	 * @param $head
	 */
	private function getRecaptchaHead(&$head)
	{
		if($this->params->get('recaptcha_publickey') AND $this->params->get('recaptcha_privatekey'))
		{
			$head[] = '<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl='.substr(JFactory::getLanguage()->getTag(), 0, 2).'" defer async></script>';

			$theme = 'light';

			if($this->params->get('recaptcha_theme') == 1)
			{
				$theme = 'dark';
			}

			$head[] = '<script type="text/javascript">var onloadCallback = function() {grecaptcha.render("recaptcha", {"sitekey" : "'.$this->params->get('recaptcha_publickey').'", "theme" : "'.$theme.'"});};</script>';

			$head[] = '<style type="text/css">.ecc-recaptcha{margin-top: 5px;}</style>';
		}
	}

	/**
	 * Checks whether ECC+ has to be loaded in normal call and defines check rules depending on the loaded component
	 *
	 * @param $option
	 * @param $task
	 * @param $view
	 * @param $func
	 * @param $layout
	 *
	 * @throws Exception
	 */
	private function loadEcc($option, $task, $view, $func, $layout)
	{
		if($this->app->isAdmin() OR ($this->params->get('onlyguests') AND !$this->user->guest))
		{
			$this->load_ecc = false;
			$this->load_ecc_check = false;
		}
		else
		{
			// Find out if ECC+ has to be loaded depending on the called component
			if($option == 'com_contact')
			{
				// Array -> (name, form, regex for hidden field, regex for output, task, request exception for encode option);
				$this->extension_info = array('com_contact',
				                              '<form[^>]+id="contact-form".+</form>',
				                              '<label id="jform_contact.+>',
				                              '<button class="btn btn-primary validate" type="submit">',
				                              'contact.submit');

				if($this->params->get('contact') AND $view == 'contact')
				{
					$this->load_ecc = true;
				}

				if($this->params->get('contact') AND $task == 'contact.submit')
				{
					$this->load_ecc_check = true;
				}
			}
			elseif($option == 'com_users')
			{
				if($layout != 'confirm' AND $layout != 'complete')
				{
					if($view == 'registration')
					{
						$this->extension_info = array('com_users',
						                              '<form[^>]+id="member-registration".+</form>',
						                              '<label id="jform.+>',
						                              '<button type="submit" class="validate">',
						                              'registration.register');
					}
					elseif($view == 'reset' OR $view == 'remind')
					{
						$this->extension_info = array('com_users',
						                              '<form[^>]+id="user-registration".+</form>',
						                              '<label id="jform_email-lbl"',
						                              '<button type="submit">',
						                              'registration.register');
					}
					elseif($view == 'login' OR $view == '')
					{
						$this->extension_info = array('com_users',
						                              '<form[^>]+(task=user.login)?.+(value="user.login")?.+</form>',
						                              '<label id=".+"',
						                              '<button type="submit" class=".*">',
						                              'registration.register');
					}

					if($this->params->get('user_reg') AND ($view == 'registration' OR $view == 'reset' OR $view == 'remind'))
					{
						$this->load_ecc = true;
					}

					if($this->params->get('user_reg') AND ($task == 'registration.register' OR $task == 'reset.request' OR $task == 'remind.remind'))
					{
						$this->load_ecc_check = true;
					}

					if($this->params->get('user_login') AND ($view == 'login' OR $view == '') AND ($task == ''))
					{
						$this->load_ecc = true;
						$this->session->set('user_login', 1, 'easycalccheck');
					}
					elseif($this->params->get('user_login') AND ($task == 'user.login'))
					{
						$user_login_check = $this->session->get('user_login', null, 'easycalccheck');

						if(!empty($user_login_check))
						{
							$this->load_ecc_check = true;
						}
						else
						{
							$failed_login_attempts = $this->session->get('failed_login_attempts', null, 'easycalccheck');

							if(empty($failed_login_attempts))
							{
								$failed_login_attempts = 0;
							}

							if($failed_login_attempts >= $this->params->get('user_login_attempts'))
							{
								$this->redirect(JRoute::_('index.php?option=com_users&view=login&eccp_err=login_attempts', false));
							}
						}
					}
				}
			}
			elseif($option == 'com_easybookreloaded' AND $this->params->get('easybookreloaded')) // Easybook Reloaded 3.3.1
			{
				$this->extension_info = array('com_easybookreloaded',
				                              '<form[^>]+name=("|\')gbookForm("|\').+</form>',
				                              '<input type=.+>',
				                              '<p id="easysubmit">',
				                              'save',
				                              'gbookForm, gbvote, gbtext');

				if($task == 'add')
				{
					$this->load_ecc = true;
				}
				elseif($task == 'save')
				{
					$this->load_ecc_check = true;
				}
			}
			elseif($option == 'com_phocaguestbook' AND $this->params->get('phocaguestbook')) // Phoca Guestbook 3.0.6
			{
				$this->extension_info = array('com_phocaguestbook',
				                              '<form.+com_phocaguestbook.*</form>',
				                              '<input type=.+>',
				                              '<div class="btn-group">\s*<button type="submit".*>',
				                              'submit');

				if($view == 'guestbook' AND $task != 'phocaguestbook.submit')
				{
					$this->load_ecc = true;
				}
				elseif($task == 'phocaguestbook.submit')
				{
					$this->load_ecc_check = true;
				}
			}
			elseif($option == 'com_comprofiler' AND $this->params->get('communitybuilder')) // Community Builder 2.1.2
			{
				$ecc_loaded = $this->session->get('ecc_loaded', false, 'easycalccheck');

				if($task == 'registers' OR $view == 'registers')
				{
					$this->extension_info = array('com_comprofiler',
					                              '<form[^>]+id="cbcheckedadminForm".+</form>',
					                              '<label for=".+>',
					                              '<input type="submit" value=".+" class="button" />',
					                              'saveregisters');
				}
				elseif($task == 'lostpassword' OR $view == 'lostpassword')
				{
					$this->extension_info = array('com_comprofiler',
					                              '<form[^>]+id="adminForm".+</form>',
					                              '<label for=".+>',
					                              '<input type="submit" class="button" id="cbsendnewuspass" value=".+" />',
					                              'sendNewPass');
				}

				if($task == 'registers' OR $view == 'registers' OR $task == 'lostpassword' OR $view == 'lostpassword')
				{
					$this->load_ecc = true;
				}
				elseif($task == 'saveregisters' OR $view == 'saveregisters' OR $task == 'sendNewPass' OR $view == 'sendnewpass')
				{
					if($ecc_loaded == true)
					{
						$this->load_ecc_check = true;
					}
				}
			}
			elseif($option == 'com_dfcontact' AND $this->params->get('dfcontact')) // DFContact - tested with version 1.6.6
			{
				$this->extension_info = array('com_dfcontact',
				                              '<form[^>]+id="dfContactForm".+</form>',
				                              '<label for="dfContactField.+>',
				                              '<input type="submit" value=".+" class="button" />');

				if($view == 'dfcontact' AND empty($_REQUEST["submit"]))
				{
					$this->load_ecc = true;
				}
				elseif($view == 'dfcontact' AND !empty($_REQUEST["submit"]))
				{
					$this->load_ecc_check = true;
				}
			}
			elseif($option == 'com_foxcontact' AND $this->params->get('foxcontact')) // FoxContact - tested with version 2.0.15
			{
				$this->extension_info = array('com_foxcontact',
				                              '<form[^>]+id="FoxForm".+</form>',
				                              '<input class=.+>',
				                              '<input class="foxbutton" type="submit" style=".+" name=".+" value=".+"/>');

				$Itemid = $this->request->get('Itemid', '', 'CMD');

				if($view == 'foxcontact' AND !isset($_REQUEST['cid_'.$Itemid]))
				{
					$this->load_ecc = true;
				}
				elseif($view == 'foxcontact' AND isset($_REQUEST['cid_'.$Itemid]))
				{
					$this->load_ecc_check = true;
				}
			}
			elseif($option == 'com_flexicontact' OR $option == 'com_flexicontactplus') // FlexiContact 10.05 / FlexiContact Plus - tested with version 6.07
			{
				$regex_output = '<input type="submit" class=".+".*name="send_button".+/>';

				if($option == 'com_flexicontactplus')
				{
					$regex_output = '<div class="fcp_sendrow">';
				}

				$this->extension_info = array($option,
				                              '<form[^>]+name="fc.?_form".+</form>',
				                              '<input type=.+>',
				                              $regex_output,
				                              'send');

				if((($this->params->get('flexicontact') AND $option == 'com_flexicontact') OR ($this->params->get('flexicontactplus') AND $option == 'com_flexicontactplus')) AND $view == 'contact' AND empty($task))
				{
					$this->load_ecc = true;
				}
				elseif((($this->params->get('flexicontact') AND $option == 'com_flexicontact') OR ($this->params->get('flexicontactplus') AND $option == 'com_flexicontactplus')) AND $view == 'contact' AND $task == 'send')
				{
					$this->load_ecc_check = true;
				}
			}
			elseif($option == 'com_kunena' AND $this->params->get('kunena')) // Kunena Forum 5.0.7
			{
				$this->extension_info = array('com_kunena',
				                              '<form[^>]+id="postform".+</form>',
				                              '<input type=.+>',
				                              '<button[^>]+type="submit"[^>]+>',
				                              'post');

				if(($func == 'post' OR ($view == 'topic' AND ($layout == 'reply' OR $layout == 'create' OR $layout == ''))) AND $task != 'post')
				{
					$this->load_ecc = true;
				}
				elseif($func == 'post' OR $task == 'post')
				{
					$this->load_ecc_check = true;
				}
			}
			elseif($option == 'com_alfcontact' AND $this->params->get('alfcontact')) // ALFContact 3.2.6
			{
				$this->extension_info = array('com_alfcontact',
				                              '<form[^>]+id="contact-form".+</form>',
				                              '<label for=".+>',
				                              '<button class="button">',
				                              'sendemail');

				if($view == 'alfcontact' AND empty($task))
				{
					$this->load_ecc = true;
				}
				elseif($task == 'sendemail')
				{
					$this->load_ecc_check = true;
				}
			}
			elseif($option == 'com_aicontactsafe' AND $this->params->get('aicontactsafe')) // aiContactSafe - tested with version 2.0.19
			{
				$this->extension_info = array('com_aicontactsafe',
				                              '<form[^>]+id="adminForm_.+</form>',
				                              '<label for=".+>',
				                              '<input type="submit" id="aiContactSafeSendButton"',
				                              'display');

				$sTask = $this->request->get('sTask', '', 'STRING');

				if(empty($sTask))
				{
					$this->load_ecc = true;
				}
				elseif($sTask == 'message')
				{
					$this->load_ecc_check = true;
				}
			}
			elseif($option == 'com_community' AND $this->params->get('jomsocial')) // JomSocial - tested with version 2.6 RC2
			{
				$this->extension_info = array('com_community',
				                              '<form[^>]+id="jomsForm".+</form>',
				                              '<label id=".+>',
				                              '<div[^>]+cwin-wait.*></div>',
				                              'register_save');

				if($view == 'register' AND ($task == '' OR $task == 'register'))
				{
					$this->load_ecc = true;
				}
				elseif($view == 'register' AND $task == 'register_save')
				{
					$this->load_ecc_check = true;
				}
			}
			elseif($option == 'com_virtuemart' AND $this->params->get('virtuemart')) // Virtuemart - tested with version 2.0.24a
			{
				if($task == 'askquestion' OR $task == 'mailAskquestion')
				{
					$this->extension_info = array('com_virtuemart',
					                              '<form[^>]+id="askform".+</form>',
					                              '<label>',
					                              '<input[^>]*type="submit" name="submit_ask"[^>]*/>',
					                              'mailAskquestion');

					if($view == 'productdetails' AND $task == 'askquestion')
					{
						$this->load_ecc = true;
					}
					elseif($view == 'productdetails' AND $task == 'mailAskquestion')
					{
						$this->load_ecc_check = true;
					}
				}
				elseif($task == 'editaddresscheckout' OR $task == 'registercheckoutuser' OR $task == 'savecheckoutuser')
				{
					$this->extension_info = array('com_virtuemart',
					                              '<form[^>]+id="userForm".+</form>',
					                              '<label.+>',
					                              '<button[^>]*type="submit"[^>]*>',
					                              'savecheckoutuser');

					if($view == 'user' AND $task == 'editaddresscheckout')
					{
						$this->load_ecc = true;
					}
					elseif($view == 'user' AND ($task == 'registercheckoutuser' OR $task == 'savecheckoutuser'))
					{
						$this->load_ecc_check = true;
					}
				}
				elseif($task == 'editaddresscart' OR $task == 'registercartuser' OR $task == 'savecartuser')
				{
					$this->extension_info = array('com_virtuemart',
					                              '<form[^>]+id="userForm".+</form>',
					                              '<label.+>',
					                              '<button[^>]*type="submit"[^>]*>',
					                              'savecartuser');

					if($view == 'user' AND $task == 'editaddresscart')
					{
						$this->load_ecc = true;
					}
					elseif($view == 'user' AND ($task == 'registercartuser' OR $task == 'savecartuser'))
					{
						$this->load_ecc_check = true;
					}
				}
				elseif($view == 'user' AND ($layout == 'edit' OR $layout == 'default' OR $task == 'saveUser' OR $task == 'register'))
				{
					$this->extension_info = array('com_virtuemart',
					                              '<form[^>]+name="userForm".+</form>',
					                              '<label.+>',
					                              '<button[^>]*type="submit"[^>]*>',
					                              'saveUser');

					if(($layout == 'edit' OR $layout == 'default' OR $task == 'register') AND $task != 'saveUser')
					{
						$this->load_ecc = true;
					}
					elseif($task == 'saveUser')
					{
						$this->load_ecc_check = true;
					}
				}
			}
			elseif($option == 'com_iproperty' AND $this->params->get('iproperty')) // IProperty - tested with version 3.3
			{
				$this->extension_info = array('com_iproperty',
				                              '<form[^>]+name="sendRequest".+</form>',
				                              '<label id=".+>',
				                              '<button[^>]*type="submit"[^>]*>',
				                              'property.sendRequest');

				if($view == 'property' AND $task == '')
				{
					$this->load_ecc = true;
				}
				elseif($view == 'property' AND $task == 'property.sendRequest')
				{
					$this->load_ecc_check = true;
				}
			}
		}

		// Clear user_login session variable to avoid errors if a user logs in via the module
		if($this->params->get('user_login') AND $this->session->get('user_login', null, 'easycalccheck'))
		{
			if($option == 'com_users')
			{
				if($this->load_ecc == false)
				{
					$this->session->clear('user_login', 'easycalccheck');
				}
			}
			else
			{
				$this->session->clear('user_login', 'easycalccheck');
			}
		}

		$this->session->clear('ecc_loaded', 'easycalccheck');
	}

	/**
	 * Checks whether ECC+ has to be loaded in a custom call
	 *
	 * @return boolean
	 */
	private function loadEccCustom()
	{
		// Do not execute the custom call in the administration or if the check is disabled for guests
		if($this->app->isAdmin() OR ($this->params->get('onlyguests') AND !$this->user->guest))
		{
			return false;
		}

		return true;
	}

	/**
	 * Loads error notice if needed only once per process
	 *
	 * @param string $option
	 * @param bool   $custom
	 */
	private function raiseErrorWarning($option, $custom = false)
	{
		if(empty($this->warning_shown))
		{
			// Load error session variable for the message output
			$error_output = $this->session->get('error_output', null, 'easycalccheck');

			if(!empty($error_output))
			{
				if($error_output == 'check_failed')
				{
					if(($option == 'com_phocaguestbook' AND $this->session->get('phocaguestbook', null, 'easycalccheck') == 0) OR ($option == 'com_easybookreloaded' AND $this->session->get('easybookreloaded', null, 'easycalccheck') == 0))
					{
						// No message output needed - message is raised by components
					}
					else
					{
						$this->app->enqueueMessage(JText::_('PLG_ECC_YOUHAVENOTRESOLVEDOURSPAMCHECK'), 'error');
					}
				}
				elseif($error_output == 'check_failed_custom' AND $custom == true)
				{
					// Only raise general error message if the custom call is used
					$this->app->enqueueMessage(JText::_('PLG_ECC_YOUHAVENOTRESOLVEDOURSPAMCHECK'), 'error');
				}
				elseif($error_output == 'login_attempts')
				{
					$this->app->enqueueMessage(JText::_('PLG_ECC_TOOMANYFAILEDLOGINATTEMPTS'), 'error');
				}

				$this->session->clear('error_output', 'easycalccheck');
				$this->warning_shown = true;
			}
		}
	}

	/**
	 * Cleans cache to avoid inconsistent output
	 */
	private function cleanCache()
	{
		$config = JFactory::getConfig();

		if($config->get('caching') != 0)
		{
			$cache = JFactory::getCache($this->request->get('option', '', 'WORD'));
			$cache->clean();
		}
	}

	/**
	 * Saves entered data into the session
	 */
	private function saveData()
	{
		$request = $this->request->getArray($_REQUEST);
		$data_array = array();
		$keys_exclude = array('option',
		                      'view',
		                      'layout',
		                      'id',
		                      'Itemid',
		                      'task',
		                      'controller',
		                      'func');

		foreach($request as $key => $value)
		{
			if(!in_array($key, $keys_exclude))
			{
				if(is_array($value))
				{
					foreach($value as $key2 => $value2)
					{
						// Need second request for user profile plugin
						if(is_array($value2))
						{
							foreach($value2 as $key3 => $value3)
							{
								$key4 = $key.'['.$key2.']['.$key3.']';
								$data_array[$key4] = $value3;
							}

							continue;
						}

						$key3 = $key.'['.$key2.']';
						$data_array[$key3] = $value2;
					}

					continue;
				}

				$data_array[$key] = $value;
			}
		}

		$this->session->set('saved_data', $data_array, 'easycalccheck');
	}

	/**
	 * Performs the antispam checks
	 *
	 * @return bool
	 * @throws Exception
	 */
	private function performChecks()
	{
		$request = $this->request->getArray($_REQUEST);

		// Calc check
		if($this->params->get('type_calc'))
		{
			if($this->session->get('rot13', null, 'easycalccheck') == 1)
			{
				$spamcheckresult = base64_decode(str_rot13($this->session->get('spamcheckresult', null, 'easycalccheck')));
			}
			else
			{
				$spamcheckresult = base64_decode($this->session->get('spamcheckresult', null, 'easycalccheck'));
			}

			$spamcheck = $request[$this->session->get('spamcheck', null, 'easycalccheck')];

			$this->session->clear('rot13', 'easycalccheck');
			$this->session->clear('spamcheck', 'easycalccheck');
			$this->session->clear('spamcheckresult', 'easycalccheck');

			if(!is_numeric($spamcheckresult) || $spamcheckresult != $spamcheck)
			{
				return false; // Failed
			}
		}

		// Hidden field
		if($this->params->get('type_hidden'))
		{
			$hidden_field = $request[$this->session->get('hidden_field', null, 'easycalccheck')];
			$this->session->clear('hidden_field', 'easycalccheck');

			if(!empty($hidden_field))
			{
				return false; // Hidden field was filled out - failed
			}
		}

		// Time lock
		if($this->params->get('type_time'))
		{
			$time = $this->session->get('time', null, 'easycalccheck');
			$this->session->clear('time', 'easycalccheck');

			if(time() - $this->params->get('type_time_sec') <= $time)
			{
				return false; // Submitted too fast - failed
			}
		}

		// Own Question
		// Conversion to lower case
		if($this->params->get('question'))
		{
			$answer = strtolower($request[$this->session->get('question', null, 'easycalccheck')]);
			$this->session->clear('question', 'easycalccheck');

			if($answer != strtolower($this->params->get('question_a')))
			{
				return false; // Question wasn't answered - failed
			}
		}

		// StopForumSpam - Check the IP Address
		// Further informations: http://www.stopforumspam.com
		if($this->params->get('stopforumspam'))
		{
			$url = 'http://www.stopforumspam.com/api?ip='.$this->session->get('ip', null, 'easycalccheck');

			// Function test - Comment out to test - Important: Enter a active Spam-IP
			// $ip = '88.180.52.46';
			// $url = 'http://www.stopforumspam.com/api?ip='.$ip;

			$response = false;
			$is_spam = false;

			if(function_exists('curl_init'))
			{
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_POST, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$response = curl_exec($ch);
				curl_close($ch);
			}

			if($response)
			{
				preg_match('#<appears>(.*)</appears>#', $response, $out);
				$is_spam = $out[1];
			}
			else
			{
				$response = @fopen($url, 'r');

				if($response)
				{
					while(!feof($response))
					{
						$line = fgets($response, 1024);

						if(preg_match('#<appears>(.*)</appears>#', $line, $out))
						{
							$is_spam = $out[1];
							break;
						}
					}

					fclose($response);
				}
			}

			if($is_spam == 'yes' AND $response == true)
			{
				return false; // Spam-IP - failed
			}
		}

		// Honeypot Project
		// Further informations: http://www.projecthoneypot.org/home.php
		// BL ACCESS KEY - http://www.projecthoneypot.org/httpbl_configure.php
		if($this->params->get('honeypot'))
		{
			require_once(dirname(__FILE__).'/easycalccheckplus/honeypot.php');
			$http_blKey = $this->params->get('honeypot_key');

			if($http_blKey)
			{
				$http_bl = new http_bl($http_blKey);
				$result = $http_bl->query($this->session->get('ip', null, 'easycalccheck'));

				// Function test - Comment out to test - Important: Enter an active Spam-IP
				// $ip = '117.21.224.251';
				// $result = $http_bl->query($ip);

				if($result == 2)
				{
					return false;
				}
			}
		}

		// Akismet
		// Further informations: http://akismet.com/
		if($this->params->get('akismet'))
		{
			require_once(dirname(__FILE__).'/easycalccheckplus/akismet.php');
			$akismet_key = $this->params->get('akismet_key');

			if($akismet_key)
			{
				$akismet_url = JUri::getInstance()->toString();

				$name = '';
				$email = '';
				$url = '';
				$comment = '';

				if($request['option'] == 'com_contact')
				{
					$name = $request['jform']['contact_name'];
					$email = $request['jform']['contact_email'];
					$comment = $request['jform']['contact_message'];
				}
				elseif($request['option'] == 'com_users')
				{
					$name = $request['jform']['name'];
					$email = $request['jform']['email1'];

					if(isset($request['jform']['email']))
					{
						$email = $request['jform']['email'];
					}
				}
				elseif($request['option'] == 'com_comprofiler')
				{
					$name = $request['name'];
					$email = $request['email'];

					if(isset($request['checkusername']))
					{
						$name = $request['checkusername'];
					}

					if(isset($request['checkemail']))
					{
						$email = $request['checkemail'];
					}
				}
				elseif($request['option'] == 'com_easybookreloaded')
				{
					$name = $request['gbname'];
					$email = $request['gbmail'];
					$comment = $request['gbtext'];

					if(isset($request['gbpage']))
					{
						$url = $request['gbpage'];
					}
				}
				elseif($request['option'] == 'com_phocaguestbook')
				{
					$name = $request['pgusername'];
					$email = $request['email'];
					$comment = $request['pgbcontent'];
				}
				elseif($request['option'] == 'com_dfcontact')
				{
					$name = $request['name'];
					$email = $request['email'];
					$comment = $request['message'];
				}
				elseif($request['option'] == 'com_flexicontact' OR $request['option'] == 'com_flexicontactplus')
				{
					$name = $request['from_name'];
					$email = $request['from_email'];
					$comment = $request['area_data'];
				}
				elseif($request['option'] == 'com_alfcontact')
				{
					$name = $request['name'];
					$email = $request['email'];
					$comment = $request['message'];
				}
				elseif($request['option'] == 'com_community')
				{
					$name = $request['usernamepass'];
					$email = $request['emailpass'];
				}
				elseif($request['option'] == 'com_virtuemart')
				{
					$name = $request['name'];
					$email = $request['email'];
					$comment = $request['comment'];
				}
				elseif($request['option'] == 'com_aicontactsafe')
				{
					$name = $request['aics_name'];
					$email = $request['aics_email'];
					$comment = $request['aics_message'];
				}

				$akismet = new Akismet($akismet_url, $akismet_key);
				$akismet->setCommentAuthor($name);
				$akismet->setCommentAuthorEmail($email);
				$akismet->setCommentAuthorURL($url);
				$akismet->setCommentContent($comment);

				if($akismet->isCommentSpam())
				{
					return false;
				}
			}
		}

		// ReCaptcha - Further informations: https://www.google.com/recaptcha
		if($this->params->get('recaptcha'))
		{
			if($this->params->get('recaptcha_publickey') AND $this->params->get('recaptcha_privatekey'))
			{
				require_once(dirname(__FILE__).'/easycalccheckplus/recaptchalib.php');
				$privatekey = $this->params->get('recaptcha_privatekey');

				$reCaptcha = new ReCaptcha($privatekey);
				$response = $reCaptcha->verifyResponse($this->session->get('ip', null, 'easycalccheck'), $request['g-recaptcha-response']);

				if($response->success == false)
				{
					return false;
				}
			}
		}

		// Botscout - Check the IP Address
		// Further informations: http://botscout.com/
		if($this->params->get('botscout') AND $this->params->get('botscout_key'))
		{
			$url = 'http://botscout.com/test/?ip='.$this->session->get('ip', null, 'easycalccheck').'&key='.$this->params->get('botscout_key');

			// Function test - Comment out to test - Important: Enter a active Spam-IP
			// $ip = '87.103.128.199';
			// $url = 'http://botscout.com/test/?ip='.$ip.'&key='.$this->params->get('botscout_key');

			$response = false;
			$is_spam = false;

			if(function_exists('curl_init'))
			{
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_POST, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$response = curl_exec($ch);
				curl_close($ch);
			}

			if($response)
			{
				$is_spam = substr($response, 0, 1);
			}
			else
			{
				$response = @ fopen($url, 'r');

				if($response)
				{
					while(!feof($response))
					{
						$line = fgets($response, 1024);

						$is_spam = substr($line, 0, 1);
					}
					fclose($response);
				}
			}

			if($is_spam == 'Y' AND $response == true)
			{
				// Spam-IP - failed
				return false;
			}
		}

		// Mollom
		// Further informations: http://mollom.com/
		if($this->params->get('mollom') AND $this->params->get('mollom_publickey') AND $this->params->get('mollom_privatekey'))
		{
			require_once(dirname(__FILE__).'/easycalccheckplus/mollom.php');

			Mollom::setPublicKey($this->params->get('mollom_publickey'));
			Mollom::setPrivateKey($this->params->get('mollom_privatekey'));

			$servers = Mollom::getServerList();

			$name = '';
			$email = '';
			$url = '';
			$comment = '';

			if($request['option'] == 'com_contact')
			{
				$name = $request['jform']['contact_name'];
				$email = $request['jform']['contact_email'];
				$comment = $request['jform']['contact_message'];
			}
			elseif($request['option'] == 'com_users')
			{
				$name = $request['jform']['name'];
				$email = $request['jform']['email1'];

				if(isset($request['jform']['email']))
				{
					$email = $request['jform']['email'];
				}
			}
			elseif($request['option'] == 'com_comprofiler')
			{
				$name = $request['name'];
				$email = $request['email'];

				if(isset($request['checkusername']))
				{
					$name = $request['checkusername'];
				}

				if(isset($request['checkemail']))
				{
					$email = $request['checkemail'];
				}
			}
			elseif($request['option'] == 'com_easybookreloaded')
			{
				$name = $request['gbname'];
				$email = $request['gbmail'];
				$comment = $request['gbtext'];

				if(isset($request['gbpage']))
				{
					$url = $request['gbpage'];
				}
			}
			elseif($request['option'] == 'com_phocaguestbook')
			{
				$name = $request['pgusername'];
				$email = $request['email'];
				$comment = $request['pgbcontent'];
			}
			elseif($request['option'] == 'com_dfcontact')
			{
				$name = $request['name'];
				$email = $request['email'];
				$comment = $request['message'];
			}
			elseif($request['option'] == 'com_flexicontact' OR $request['option'] == 'com_flexicontactplus')
			{
				$name = $request['from_name'];
				$email = $request['from_email'];
				$comment = $request['area_data'];
			}
			elseif($request['option'] == 'com_alfcontact')
			{
				$name = $request['name'];
				$email = $request['email'];
				$comment = $request['message'];
			}
			elseif($request['option'] == 'com_community')
			{
				$name = $request['usernamepass'];
				$email = $request['emailpass'];
			}
			elseif($request['option'] == 'com_virtuemart')
			{
				$name = $request['name'];
				$email = $request['email'];
				$comment = $request['comment'];
			}
			elseif($request['option'] == 'com_aicontactsafe')
			{
				$name = $request['aics_name'];
				$email = $request['aics_email'];
				$comment = $request['aics_message'];
			}

			$feedback = Mollom::checkContent(null, null, $comment, $name, $url, $email);

			if($feedback['spam'] == 'spam')
			{
				return false;
			}
		}

		$this->session->clear('ip', 'easycalccheck');
		$this->session->clear('saved_data', 'easycalccheck');

		// Yeeeha, no spam detected!
		return true;
	}

	/**
	 * Calls checks for supported extensions
	 *
	 * @param $option
	 * @param $task
	 *
	 * @throws Exception
	 */
	private function callChecks($option, $task)
	{
		$check_failed = false;
		$Itemid = $this->request->get('Itemid', '', 'CMD');
		$view = $this->request->get('view', '', 'WORD');

		if($option == 'com_users' AND ($task == 'reset.request' OR $task == 'remind.remind'))
		{
			if(!$this->performChecks())
			{
				$check_failed = true;
			}
		}
		elseif($option == 'com_users' AND $task == 'user.login')
		{
			if(!$this->performChecks())
			{
				$check_failed = true;
			}
			else
			{
				$this->session->clear('failed_login_attempts', 'easycalccheck');
			}
		}
		elseif($option == 'com_easybookreloaded' AND $task == 'save')
		{
			if(!$this->performChecks())
			{
				$this->session->set('easybookreloaded', 1, 'easycalccheck');
				$check_failed = true;
			}
		}
		elseif($option == 'com_phocaguestbook' AND $task == 'phocaguestbook.submit')
		{
			if(!$this->performChecks())
			{
				$this->session->set('phocaguestbook', 1, 'easycalccheck');
				$check_failed = true;
			}
		}
		elseif($option == 'com_comprofiler' AND ($task == 'sendNewPass' OR $view == 'sendnewpass' OR $view == 'saveregisters'))
		{
			if(!$this->performChecks())
			{
				$check_failed = true;
			}
		}
		elseif($option == 'com_dfcontact' AND !empty($_REQUEST["submit"]))
		{
			if(!$this->performChecks())
			{
				$check_failed = true;
			}
		}
		elseif($option == 'com_foxcontact' AND isset($_REQUEST['cid_'.$Itemid]))
		{
			if(!$this->performChecks())
			{
				$check_failed = true;
			}
		}
		elseif(($option == 'com_flexicontact' OR $option == 'com_flexicontactplus') AND $task == 'send')
		{
			if(!$this->performChecks())
			{
				$check_failed = true;
			}
		}
		elseif($option == 'com_kunena' AND $task = 'post')
		{
			if(!$this->performChecks())
			{
				$check_failed = true;
			}
		}
		elseif($option == 'com_alfcontact' AND $task == 'sendemail')
		{
			if(!$this->performChecks())
			{
				$check_failed = true;
			}
		}
		elseif($option == 'com_community' AND $task == 'register_save')
		{
			if(!$this->performChecks())
			{
				$check_failed = true;
			}
		}
		elseif($option == 'com_virtuemart' AND ($task == 'mailAskquestion' OR $task == 'registercheckoutuser' OR $task == 'savecheckoutuser' OR $task == 'registercartuser' OR $task == 'savecartuser' OR $task == 'saveUser'))
		{
			if(!$this->performChecks())
			{
				$check_failed = true;
			}
		}
		elseif($option == 'com_aicontactsafe')
		{
			$sTask = $this->request->get('sTask', '', 'STRING');

			if($sTask == 'message')
			{
				if(!$this->performChecks())
				{
					$check_failed = true;
				}
			}
		}
		elseif($option == 'com_iproperty' AND $task == 'property.sendRequest')
		{
			if(!$this->performChecks())
			{
				$check_failed = true;
			}
		}

		if($check_failed == true)
		{
			// Set error session variable for the message output
			$this->session->set('error_output', 'check_failed', 'easycalccheck');
			$this->redirect($this->redirect_url);
		}
	}

	/**
	 * Creates one or an array of (pseudo-)random strings
	 *
	 * @param integer $count
	 *
	 * @return mixed - if $count is 1, then string else array
	 */
	private function random($count = 1)
	{
		$characters = range('a', 'z');
		$numbers = range(0, 9);
		$pw_array = array();

		for($i = 0; $i < $count; $i++)
		{
			$pw = '';

			// first character has to be a letter
			$pw .= $characters[mt_rand(0, 25)];

			// other characters arbitrarily
			$characters = array_merge($characters, $numbers);

			$pw_length = mt_rand(4, 12);

			for($a = 0; $a < $pw_length; $a++)
			{
				$pw .= $characters[mt_rand(0, 35)];
			}

			$pw_array[] = $pw;
		}

		if($count == 1)
		{
			$pw_array = $pw_array[0];
		}

		return $pw_array;
	}

	/**
	 * Detects whether the plugin routine has to be loaded and call the checks
	 */
	public function onAfterRender()
	{
		// Custom call check - call it here because we need access to the output - since 2.5-8
		if($this->load_ecc == false)
		{
			if($this->params->get('custom_call') AND $this->loadEccCustom())
			{
				$this->customCall();
			}
		}

		if($this->load_ecc == true)
		{
			$option = $this->request->get('option', '', 'WORD');
			$this->loadLanguage('plg_system_easycalccheckplus', JPATH_ADMINISTRATOR);

			// Read in content of the output
			$body = $this->app->getBody();

			// Get form of extension
			preg_match('@'.$this->extension_info[1].'@isU', $body, $match_extension);

			// Form was not found, the template probably uses overrides, try it with the detection of the task or set error message for debug mode
			if(empty($match_extension))
			{
				// Try to find the form by the task if provided
				if(!empty($this->extension_info[4]))
				{
					// Get all forms on the loaded page and find the correct form by the task value
					preg_match_all('@<form[^>]*>.*</form>@isU', $body, $match_extension_forms);

					if(!empty($match_extension_forms))
					{
						foreach($match_extension_forms[0] as $match_extension_form)
						{
							if(preg_match('@<form[^>]*>.*value=["|\']'.$this->extension_info[4].'["|\'].*</form>@isU', $match_extension_form, $match_extension))
							{
								break;
							}
						}
					}
				}

				if(empty($match_extension))
				{
					$this->app->enqueueMessage(JText::_('PLG_ECC_WARNING_FORMNOTFOUND'), 'error');
				}
			}

			// Fill in form input values if the check failed previously (_warning_shown is set)
			if($this->params->get('autofill_values') AND !empty($this->warning_shown))
			{
				$this->fillForm($body, $match_extension);
			}

			// Hidden field
			if($this->params->get('type_hidden') AND !empty($match_extension))
			{
				$pattern_search_string = '@'.$this->extension_info[2].'@isU';
				preg_match_all($pattern_search_string, $match_extension[0], $matches);

				if(empty($matches[0]))
				{
					$this->app->enqueueMessage(JText::_('PLG_ECC_WARNING_NOHIDDENFIELD'), 'error');
				}
				else
				{
					$count = mt_rand(0, count($matches[0]) - 1);
					$search_string_hidden = $matches[0][$count];

					// Generate random variable
					$this->session->set('hidden_field', $this->random(), 'easycalccheck');
					$this->session->set('hidden_field_label', $this->random(), 'easycalccheck');

					// Line width for obfuscation
					$input_size = 30;

					$add_string = '<label class="'.$this->session->get('hidden_class', null, 'easycalccheck').'" for="'.$this->session->get('hidden_field_label', null, 'easycalccheck').'"></label><input type="text" id="'.$this->session->get('hidden_field_label', null, 'easycalccheck').'" name="'.$this->session->get('hidden_field', null, 'easycalccheck').'" size="'.$input_size.'" class="inputbox '.$this->session->get('hidden_class', null, 'easycalccheck').'" />';

					// Yootheme Fix - Put the hidden field in an own div container to avoid displacement of other fields
					if(preg_match('@<div[^>]*>\s*'.preg_quote($search_string_hidden, '@').'@isU', $match_extension[0], $matches_div))
					{
						$search_string_hidden = $matches_div[0];
					}

					if(isset($search_string_hidden))
					{
						$body = str_replace($search_string_hidden, $add_string.$search_string_hidden, $body);
					}
				}
			}

			// Calc check
			if(($this->params->get('type_calc') OR $this->params->get('recaptcha') OR $this->params->get('question')) AND !empty($match_extension))
			{
				// Without overrides
				$pattern_output = '@'.$this->extension_info[3].'@isU';

				if(preg_match($pattern_output, $match_extension[0], $matches))
				{
					$search_string_output = $matches[0];
				}
				else
				{
					// Alternative search string from settings
					$string_alternative = $this->params->get('string_alternative');

					if(!empty($string_alternative))
					{
						$pattern = '@'.$string_alternative.'@isU';

						if(preg_match($pattern, $match_extension[0], $matches))
						{
							$search_string_output = $matches[0];
						}
					}

					// With overrides
					if(!isset($search_string_output))
					{
						// Artisteer Template
						if(preg_match('@<span class=".*-button-wrapper">@isU', $match_extension[0], $matches))
						{
							$search_string_output = $matches[0];
						}

						// Rockettheme Template
						if(preg_match('@<div class="readon">@isU', $match_extension[0], $matches))
						{
							$search_string_output = $matches[0];
						}

						// String still not found - take the submit attribute
						if(!isset($search_string_output))
						{
							if(preg_match('@<[^>]*type="submit".*>@isU', $match_extension[0], $matches))
							{
								$search_string_output = $matches[0];
							}
						}
					}
				}

				$add_string = '<!-- EasyCalcCheck Plus - Kubik-Rubik Joomla! Extensions --><div id="easycalccheckplus">';

				if($this->params->get('type_calc'))
				{
					$this->session->set('spamcheck', $this->random(), 'easycalccheck');
					$this->session->set('rot13', mt_rand(0, 1), 'easycalccheck');

					// Determine operator
					$tcalc = 1;

					if($this->params->get('operator') == 2)
					{
						$tcalc = mt_rand(1, 2);
					}
					elseif($this->params->get('operator') == 1)
					{
						$tcalc = 2;
					}

					// Determine max. operand
					$max_value = $this->params->get('max_value', 20);

					$spam_check_1 = mt_rand(1, $max_value);
					$spam_check_2 = mt_rand(1, $max_value);

					if($this->params->get('operand') == 3)
					{
						$spam_check_3 = mt_rand(0, $max_value);
					}

					if(($this->params->get('negative') == 0) AND ($tcalc == 2))
					{
						$spam_check_1 = mt_rand($max_value / 2, $max_value);
						$spam_check_2 = mt_rand(1, $max_value / 2);

						if($this->params->get('operand') == 3)
						{
							$spam_check_3 = mt_rand(0, $spam_check_1 - $spam_check_2);
						}
					}

					if($tcalc == 1) // Addition
					{
						if($this->session->get('rot13', null, 'easycalccheck') == 1) // ROT13 coding
						{
							if($this->params->get('operand') == 2)
							{
								$this->session->set('spamcheckresult', str_rot13(base64_encode($spam_check_1 + $spam_check_2)), 'easycalccheck');
							}
							elseif($this->params->get('operand') == 3)
							{
								$this->session->set('spamcheckresult', str_rot13(base64_encode($spam_check_1 + $spam_check_2 + $spam_check_3)), 'easycalccheck');
							}
						}
						else
						{
							if($this->params->get('operand') == 2)
							{
								$this->session->set('spamcheckresult', base64_encode($spam_check_1 + $spam_check_2), 'easycalccheck');
							}
							elseif($this->params->get('operand') == 3)
							{
								$this->session->set('spamcheckresult', base64_encode($spam_check_1 + $spam_check_2 + $spam_check_3), 'easycalccheck');
							}
						}
					}
					elseif($tcalc == 2) // Subtraction
					{
						if($this->session->get('rot13', null, 'easycalccheck') == 1)
						{
							if($this->params->get('operand') == 2)
							{
								$this->session->set('spamcheckresult', str_rot13(base64_encode($spam_check_1 - $spam_check_2)), 'easycalccheck');
							}
							elseif($this->params->get('operand') == 3)
							{
								$this->session->set('spamcheckresult', str_rot13(base64_encode($spam_check_1 - $spam_check_2 - $spam_check_3)), 'easycalccheck');
							}
						}
						else
						{
							if($this->params->get('operand') == 2)
							{
								$this->session->set('spamcheckresult', base64_encode($spam_check_1 - $spam_check_2), 'easycalccheck');
							}
							elseif($this->params->get('operand') == 3)
							{
								$this->session->set('spamcheckresult', base64_encode($spam_check_1 - $spam_check_2 - $spam_check_3), 'easycalccheck');
							}
						}
					}

					$add_string .= '<div><label for="'.$this->session->get('spamcheck', null, 'easycalccheck').'">'.JText::_('PLG_ECC_SPAMCHECK');

					if($tcalc == 1)
					{
						if($this->params->get('converttostring'))
						{
							if($this->params->get('operand') == 2)
							{
								$add_string .= $this->converttostring($spam_check_1).' '.JText::_('PLG_ECC_PLUS').' '.$this->converttostring($spam_check_2).' '.JText::_('PLG_ECC_EQUALS').' ';
							}
							elseif($this->params->get('operand') == 3)
							{
								$add_string .= $this->converttostring($spam_check_1).' '.JText::_('PLG_ECC_PLUS').' '.$this->converttostring($spam_check_2).' '.JText::_('PLG_ECC_PLUS').' '.$this->converttostring($spam_check_3).' '.JText::_('PLG_ECC_EQUALS').' ';
							}
						}
						else
						{
							if($this->params->get('operand') == 2)
							{
								$add_string .= $spam_check_1.' '.JText::_('PLG_ECC_PLUS').' '.$spam_check_2.' '.JText::_('PLG_ECC_EQUALS').' ';
							}
							elseif($this->params->get('operand') == 3)
							{
								$add_string .= $spam_check_1.' '.JText::_('PLG_ECC_PLUS').' '.$spam_check_2.' '.JText::_('PLG_ECC_PLUS').' '.$spam_check_3.' '.JText::_('PLG_ECC_EQUALS').' ';
							}
						}
					}
					elseif($tcalc == 2)
					{
						if($this->params->get('converttostring'))
						{
							if($this->params->get('operand') == 2)
							{
								$add_string .= $this->converttostring($spam_check_1).' '.JText::_('PLG_ECC_MINUS').' '.$this->converttostring($spam_check_2).' '.JText::_('PLG_ECC_EQUALS').' ';
							}
							elseif($this->params->get('operand') == 3)
							{
								$add_string .= $this->converttostring($spam_check_1).' '.JText::_('PLG_ECC_MINUS').' '.$this->converttostring($spam_check_2).' '.JText::_('PLG_ECC_MINUS').' '.$this->converttostring($spam_check_3).' '.JText::_('PLG_ECC_EQUALS').' ';
							}
						}
						else
						{
							if($this->params->get('operand') == 2)
							{
								$add_string .= $spam_check_1.' '.JText::_('PLG_ECC_MINUS').' '.$spam_check_2.' '.JText::_('PLG_ECC_EQUALS').' ';
							}
							elseif($this->params->get('operand') == 3)
							{
								$add_string .= $spam_check_1.' '.JText::_('PLG_ECC_MINUS').' '.$spam_check_2.' '.JText::_('PLG_ECC_MINUS').' '.$spam_check_3.' '.JText::_('PLG_ECC_EQUALS').' ';
							}
						}
					}

					$add_string .= '</label>';
					$add_string .= '<input type="text" name="'.$this->session->get('spamcheck', null, 'easycalccheck').'" id="'.$this->session->get('spamcheck', null, 'easycalccheck').'" size="3" class="inputbox '.$this->random().' validate-numeric required" value="" required="required" />';
					$add_string .= '</div>';

					// Show warnings
					if($this->params->get('warn_ref') AND !$this->params->get('autofill_values'))
					{
						$add_string .= '<p><img src="'.JUri::root().'plugins/system/easycalccheckplus/easycalccheckplus/warning.png" alt="'.JText::_('PLG_ECC_WARNING').'" /> ';
						$add_string .= '<strong>'.JText::_('PLG_ECC_WARNING').'</strong><br /><small>'.JText::_('PLG_ECC_WARNINGDESC').'</small>';

						if($this->params->get('converttostring'))
						{
							$add_string .= '<br /><small>'.JText::_('PLG_ECC_CONVERTWARNING').'</small><br />';
						}

						$add_string .= '</p>';
					}
					elseif($this->params->get('converttostring'))
					{
						$add_string .= '<p><small>'.JText::_('PLG_ECC_CONVERTWARNING').'</small></p>';
					}
				}

				// Own Question
				if($this->params->get('question') AND $this->params->get('question_q') AND $this->params->get('question_a'))
				{
					$this->session->set('question', $this->random(), 'easycalccheck');

					$size = strlen($this->params->get('question_a')) + mt_rand(0, 2);

					$add_string .= '<div><label for="'.$this->session->get('question', null, 'easycalccheck').'">'.$this->params->get('question_q').'</label><input type="text" name="'.$this->session->get('question', null, 'easycalccheck').'" id="'.$this->session->get('question', null, 'easycalccheck').'" size="'.$size.'" class="inputbox '.$this->random().' required" value="" /></div>';
				}

				// ReCaptcha
				if($this->params->get('recaptcha'))
				{
					if($this->params->get('recaptcha_publickey') AND $this->params->get('recaptcha_privatekey'))
					{
						$add_string .= '<div class="ecc-recaptcha"><div class="g-recaptcha" id="recaptcha"></div></div>';
					}
				}

				if($this->params->get('poweredby') == 1)
				{
					$add_string .= '<div class="protectedby"><a href="http://joomla-extensions.kubik-rubik.de/" title="EasyCalcCheck Plus for Joomla! - Kubik-Rubik Joomla! Extensions" target="_blank">'.JText::_('PLG_ECC_PROTECTEDBY').'</a></div>';
				}

				$add_string .= '</div>';

				if(isset($search_string_output))
				{
					if(empty($this->custom_call))
					{
						$body = str_replace($search_string_output, $add_string.$search_string_output, $body);
					}
					else
					{
						$body = str_replace($search_string_output, $add_string, $body);
					}
				}
			}

			// Encode fields - since 2.5-8 in all forms where ECC+ is loaded
			if($this->params->get('encode') AND empty($this->debug_plugin))
			{
				$this->encodeFields($body, $match_extension);
			}

			// Set body content after all modifications have been applied
			$this->app->setBody($body);

			// Get IP address
			$this->session->set('ip', getenv('REMOTE_ADDR'), 'easycalccheck');

			// Set session variable for error output - Phoca Guestbook / Easybook Reloaded
			if($option == 'com_phocaguestbook')
			{
				$this->session->set('phocaguestbook', 0, 'easycalccheck');
			}
			elseif($option == 'com_easybookreloaded')
			{
				$this->session->set('easybookreloaded', 0, 'easycalccheck');
			}

			// Set redirect url
			$this->session->set('redirect_url', JUri::getInstance()->toString(), 'easycalccheck');
			$this->session->set('ecc_loaded', true, 'easycalccheck');

			// Time Lock
			if($this->params->get('type_time'))
			{
				$this->session->set('time', time(), 'easycalccheck');
			}
		}
	}

	/**
	 * Prepares the custom call for the correct output
	 *
	 * @throws Exception
	 */
	private function customCall()
	{
		// Read in content of the output
		$body = $this->app->getBody();

		if(preg_match("@(<form[^>]*>)(.*)({easycalccheckplus})(.*</form>)@Us", $body, $matches))
		{
			// Workaround to get the correct form if several form attributes are provided on the loaded page
			if(strripos($matches[2], '<form') !== false)
			{
				$matches[0] = substr($matches[2], strripos($matches[2], '<form')).$matches[3].$matches[4];

				// Set a new matches array with the correct form
				preg_match("@(<form[^>]*>)(.*)({easycalccheckplus})(.*)(</form>)@Us", $matches[0], $matches);
			}

			if(!empty($matches))
			{
				// Custom call string was found, set needed class attribute
				$this->custom_call = true;

				// Clean the cache of the component first
				$this->cleanCache();

				// The request does not have to be validated, so get all information for the output of the checks
				$custom_call_form = $matches[0];
				$custom_call_form_content = $matches[2].$matches[4];

				// Do some general checks to get needed information from the form of the unknown extension
				// Hidden field - check whether labels are used if not take the input tags
				$custom_call_hidden_regex = '<input.+>';

				if(strripos($custom_call_form_content, '<label') !== false)
				{
					$custom_call_hidden_regex = '<label.+>';
				}

				// Get task value of the form
				$custom_call_form_task = '';

				if(strripos($custom_call_form_content, 'name="task"') !== false)
				{
					preg_match('@<input.+name="task".+>@U', $custom_call_form_content, $match_task);

					if(preg_match('@value="(.+)"@', $match_task[0], $match_value))
					{
						$custom_call_form_task = $match_value[1];
					}
				}

				// Set the extension info array for the further execution with the collected information
				// Array -> (name, form, regex for hidden field, regex for output, task, request exception for encode option);
				$this->load_ecc = true;
				$this->extension_info = array($this->request->get('option', '', 'WORD'),
				                              preg_quote($custom_call_form),
				                              $custom_call_hidden_regex,
				                              '{easycalccheckplus}',
				                              $custom_call_form_task);

				// Set the needed CSS instructions - since we are already in the trigger onAfterRender, we have to manipulate the output manually
				$head = array();
				$head[] = '<style type="text/css">#easycalccheckplus {margin: 8px 0 !important; padding: 2px !important;}</style>';

				if($this->params->get('poweredby'))
				{
					$head[] = '<style type="text/css">.protectedby {font-size: x-small !important; text-align: right !important;}</style>';
				}

				if($this->params->get('type_hidden'))
				{
					$this->session->set('hidden_class', $this->random(), 'easycalccheck');
					$head[] = '<style type="text/css">.'.$this->session->get('hidden_class', null, 'easycalccheck').' {display: none !important;}</style>';
				}

				if($this->params->get('recaptcha'))
				{
					$this->getRecaptchaHead($head);
				}

				$head = implode("\n", $head)."\n";

				// Set body after the modifications have been applied
				$body = str_replace('</head>', $head.'</head>', $body);
				$this->app->setBody($body);

				// Set the custom call session variable - Get all possible request variable of the loaded form
				preg_match_all('@name=["|\'](.*)["|\']@Us', $matches[0], $matches_request_variables);
				$this->session->set('check_custom_call', $matches_request_variables[1], 'easycalccheck');
			}
		}
	}

	/**
	 * Fills the form with the entered data from the user - autofill function
	 *
	 * @param string $body
	 * @param array  $match_extension_main
	 */
	private function fillForm(&$body, &$match_extension_main)
	{
		$autofill = $this->session->get('saved_data', null, 'easycalccheck');

		if(!empty($autofill))
		{
			// Get form of extension
			$pattern_form = '@'.$this->extension_info[1].'@isU';
			preg_match($pattern_form, $body, $match_extension);

			$pattern_input = '@<input[^>].*/?>@isU';
			preg_match_all($pattern_input, $match_extension[0], $matches_input);

			foreach($matches_input[0] as $input_value)
			{
				foreach($autofill as $key => $autofill_value)
				{
					if($autofill_value != '')
					{
						$value = '@name=("|\')'.preg_quote($key).'("|\')@isU';

						if(preg_match($value, $input_value))
						{
							$value = '@value=("|\').*("|\')@isU';

							if(preg_match($value, $input_value, $match))
							{
								$pattern_value = '/'.preg_quote($match[0], '/').'/isU';
								$input_value_replaced = preg_replace($pattern_value, 'value="'.$autofill_value.'"', $input_value);

								// Set the value to the body and the extension form for further modifications
								$body = str_replace($input_value, $input_value_replaced, $body);
								$match_extension_main[0] = str_replace($input_value, $input_value_replaced, $match_extension_main[0]);
								unset($autofill[$key]);
								break;
							}
						}
					}
				}
			}

			$pattern_textarea = '@<textarea[^>].*>(.*</textarea>)@isU';
			preg_match_all($pattern_textarea, $match_extension[0], $matches_textarea);

			$count = 0;

			foreach($matches_textarea[0] as $textarea_value)
			{
				foreach($autofill as $key => $autofill_value)
				{
					$value = '@name=("|\')'.preg_quote($key).'("|\')@';

					if(preg_match($value, $textarea_value))
					{
						$pattern_value = '@'.preg_quote($matches_textarea[1][$count]).'@isU';
						$textarea_value_replaced = preg_replace($pattern_value, $autofill_value.'</textarea>', $textarea_value);

						// Set the value to the body and the extension form for further modifications
						$body = str_replace($textarea_value, $textarea_value_replaced, $body);
						$match_extension_main[0] = str_replace($textarea_value, $textarea_value_replaced, $match_extension_main[0]);
						unset($autofill[$key]);
						break;
					}
				}

				$count++;
			}

			$this->session->clear('saved_data', 'easycalccheck');
		}
	}

	/**
	 * Converts numbers into strings
	 *
	 * @param int $x
	 *
	 * @return string
	 */
	private function converttostring($x)
	{
		// Probability 2/3 for conversion
		$random = mt_rand(1, 3);

		if($random != 1)
		{
			if($x > 20)
			{
				return $x;
			}

			// Names of the numbers are read from language file
			$names = array(JText::_('PLG_ECC_NULL'),
			               JText::_('PLG_ECC_ONE'),
			               JText::_('PLG_ECC_TWO'),
			               JText::_('PLG_ECC_THREE'),
			               JText::_('PLG_ECC_FOUR'),
			               JText::_('PLG_ECC_FIVE'),
			               JText::_('PLG_ECC_SIX'),
			               JText::_('PLG_ECC_SEVEN'),
			               JText::_('PLG_ECC_EIGHT'),
			               JText::_('PLG_ECC_NINE'),
			               JText::_('PLG_ECC_TEN'),
			               JText::_('PLG_ECC_ELEVEN'),
			               JText::_('PLG_ECC_TWELVE'),
			               JText::_('PLG_ECC_THIRTEEN'),
			               JText::_('PLG_ECC_FOURTEEN'),
			               JText::_('PLG_ECC_FIFTEEN'),
			               JText::_('PLG_ECC_SIXTEEN'),
			               JText::_('PLG_ECC_SEVENTEEN'),
			               JText::_('PLG_ECC_EIGHTEEN'),
			               JText::_('PLG_ECC_NINETEEN'),
			               JText::_('PLG_ECC_TWENTY'));

			return $names[$x];
		}

		return $x;
	}

	/**
	 * Encodes input fields
	 *
	 * @param $body
	 * @param $match_extension
	 *
	 * @since 2.5-8
	 */
	private function encodeFields(&$body, $match_extension)
	{
		$pattern_encode = '@<[^>]+(name=("|\')([^>]*)("|\'))[^>]*>@isU';
		preg_match_all($pattern_encode, $match_extension[0], $matches_encode);

		$match_encode_replacement = array();

		// Add global exceptions - this fields should not be renamed to avoid execution errors
		$replace_not = array('option',
		                     'view',
		                     'task',
		                     'func',
		                     'layout',
		                     'controller');

		// Add exceptions from extension if provided
		if(!empty($this->extension_info[5]))
		{
			$replace_not = array_merge($replace_not, array_map('trim', explode(',', $this->extension_info[5])));
		}

		$fields_encoded = array();

		foreach($matches_encode[3] as $key => $match)
		{
			if(!in_array($match, $replace_not))
			{
				$random = $this->random();
				$fields_encoded[$match] = $random;
				$match_encode_replacement[$key] = str_replace($matches_encode[1][$key], 'name="'.$random.'"', $matches_encode[0][$key]);
			}
			else
			{
				unset($matches_encode[0][$key]);
			}
		}

		if(!empty($fields_encoded))
		{
			$this->session->set('fields_encoded', base64_encode(serialize($fields_encoded)), 'easycalccheck_encode');
		}

		if(!empty($match_encode_replacement))
		{
			$body = str_replace($matches_encode[0], $match_encode_replacement, $body);
		}
	}

	/**
	 * Detects whether the plugin routine has to be loaded and call the checks
	 *
	 * @param $contact
	 * @param $post
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function onValidateContact($contact, $post)
	{
		if($this->load_ecc_check == true)
		{
			$option = $this->request->get('option', '', 'WORD');

			if($this->params->get('contact') AND $option == 'com_contact')
			{
				if(!$this->performChecks())
				{
					// Set error session variable for the message output
					$this->session->set('error_output', 'check_failed', 'easycalccheck');
					$this->redirect($this->redirect_url);
				}
			}

			return true;
		}
	}

	/**
	 * Detect whether the plugin routine has to be loaded and call the checks
	 *
	 * @param $user
	 * @param $isnew
	 * @param $new
	 *
	 * @throws Exception
	 */
	public function onUserBeforeSave($user, $isnew, $new)
	{
		if($this->load_ecc_check == true)
		{
			if(!empty($isnew))
			{
				$option = $this->request->get('option', '', 'WORD');

				if(($this->params->get('user_reg') AND $option == 'com_users') OR ($this->params->get('communitybuilder') AND $option == 'com_comprofiler'))
				{
					if(!$this->performChecks())
					{
						// Set error session variable for the message output
						$this->session->set('error_output', 'check_failed', 'easycalccheck');
						$this->redirect($this->redirect_url);
					}
				}
			}
		}
	}

	/**
	 * Detects whether the plugin routine has to be loaded and call the checks
	 */
	public function onUserLoginFailure()
	{
		$failed_login_attempts = $this->session->get('failed_login_attempts', null, 'easycalccheck');
		$this->session->set('failed_login_attempts', $failed_login_attempts + 1, 'easycalccheck');
	}

	/**
	 * Successful login, clear sessions variable
	 */
	public function onUserLogin()
	{
		$this->session->clear('failed_login_attempts', 'easycalccheck');
	}
}
