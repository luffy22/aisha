<?php
/**
 * @Copyright
 * @package        EasyCalcCheck Plus - ECC+ for Joomla! 3
 * @author         Viktor Vogel <admin@kubik-rubik.de>
 * @version        3.1.5 - 2018-05-20
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
    protected $customCall;
    protected $debugPlugin;
    protected $extensionInfo;
    protected $loadEcc;
    protected $loadEccCheck;
    protected $redirectUrl;
    protected $request;
    protected $session;
    protected $user;
    protected $warningShown;
    protected $pluginId = 'easycalccheckplus';

    function __construct(&$subject, $config)
    {
        $this->app = JFactory::getApplication();
        $this->loadLanguage('plg_system_easycalccheckplus', JPATH_ADMINISTRATOR);

        // Check Joomla version
        $version = new JVersion();

        if ($version->PRODUCT == 'Joomla!' && $version->RELEASE < '3.0') {
            $this->app->enqueueMessage(JText::_('PLG_ECC_WRONGJOOMLAVERSION'), 'error');

            return;
        }

        parent::__construct($subject, $config);

        $this->loadEcc = false;
        $this->loadEccCheck = false;
        $this->session = JFactory::getSession();
        $this->extensionInfo = array();

        $this->redirectUrl = $this->getSession('redirect_url');
        $this->clearSession('redirect_url');

        if (empty($this->redirectUrl)) {
            $this->redirectUrl = JUri::getInstance()->toString();
        }

        $this->request = $this->app->input;
        $this->user = JFactory::getUser();

        // Check whether the debug plugin is activated - important workaround for Joomla! 3.x
        // This is important because if the plugin is activated, then the input request variables are set before ECC+
        // can decode them back. This means that the components do not use the correct request variables if the option
        // "Encode all fields" is used in ECC+. If the plugin is activated, then we can not use the encode functionality!
        $this->debugPlugin = false;

        if (JPluginHelper::isEnabled('system', 'debug')) {
            $this->debugPlugin = true;
        }
    }

    /**
     * Purge Cache, Bot-Trap, SQL Injection Protection & Backend Token
     */
    function onAfterInitialise()
    {
        // Okay, if we use the encoding option, then we have to decode all fields as soon as possible to avoid errors
        // Decode all input fields but only if debug plugin is not used
        if ($this->params->get('encode') && empty($this->debugPlugin)) {
            $this->decodeFields();
        }

        // Clean page cache if System Cache plugin is enabled
        if (JPluginHelper::isEnabled('system', 'cache')) {
            $cacheId = JUri::getInstance()->toString();

            if (version_compare(JVersion::RELEASE, '3.8', 'ge')) {
                $cacheId = md5(serialize(array(JUri::getInstance()->toString())));
            }

            $cache = JCache::getInstance('page');
            $cache->remove($cacheId, 'page');
        }

        // Bot-Trap
        // Further informations: http://www.bot-trap.de
        // File has to be named page.restrictor.php and be saved in plugins/system/easycalccheckplus/bottrap/
        if ($this->params->get('bottrap')) {
            // Set correct path to the helper PHP file
            $path = 'plugins/system/easycalccheckplus/bottrap/';

            if ($this->app->isAdmin()) {
                $path = '../plugins/system/easycalccheckplus/bottrap/';
            }

            // File exists, then set the white / black lists and do the global check
            if (file_exists($path . 'page.restrictor.php')) {
                if ($this->params->get('btWhitelistIP')) {
                    $btWhitelistIP = str_replace(',', '|', $this->params->get('btWhitelistIP'));
                    define('PRES_WHITELIST_IP', $btWhitelistIP);
                }

                if ($this->params->get('btWhitelistIPRange')) {
                    $btWhitelistIPRange = str_replace(',', '|', $this->params->get('btWhitelistIPRange'));
                    define('PRES_WHITELIST_IPR', $btWhitelistIPRange);
                }

                if ($this->params->get('btWhitelistUA')) {
                    $btWhitelistUA = str_replace(',', '|', $this->params->get('btWhitelistUA'));
                    define('PRES_WHITELIST_UA', $btWhitelistUA);
                }

                if ($this->params->get('btBlacklistIP')) {
                    $btBlacklistIP = str_replace(',', '|', $this->params->get('btBlacklistIP'));
                    define('PRES_BLACKLIST_IP', $btBlacklistIP);
                }

                if ($this->params->get('btBlacklistIPRange')) {
                    $btBlacklistIPRange = str_replace(',', '|', $this->params->get('btBlacklistIPRange'));
                    define('PRES_BLACKLIST_IPR', $btBlacklistIPRange);
                }

                if ($this->params->get('btBlacklistUA')) {
                    $btBlacklistUA = str_replace(',', '|', $this->params->get('btBlacklistUA'));
                    define('PRES_BLACKLIST_UA', $btBlacklistUA);
                }

                include_once($path . 'page.restrictor.php');
            } else {
                $this->app->enqueueMessage(JText::_('PLG_ECC_ERRORBOTTRAP'), 'error');
            }
        }

        // Based on Marco's SQL Injection Plugin
        // Further informations: http://www.mmleoni.net/sql-iniection-lfi-protection-plugin-for-joomla
        if ($this->params->get('sqlinjection-lfi')) {
            foreach (explode(',', 'GET,POST,REQUEST') as $nameSpace) {
                if ($nameSpace == 'GET') {
                    $nameSpace = $this->request->getArray($_GET);
                } elseif ($nameSpace == 'POST') {
                    $nameSpace = $this->request->getArray($_POST);
                } elseif ($nameSpace == 'REQUEST') {
                    $nameSpace = $this->request->getArray($_REQUEST);
                }

                if (!empty($nameSpace)) {
                    foreach ($nameSpace as $k => $v) {
                        if (is_numeric($v) || is_array($v)) {
                            continue;
                        }

                        $a = preg_replace('@/\*.*?\*/@s', ' ', $v);

                        if (preg_match('@UNION(?:\s+ALL)?\s+SELECT@i', $a)) {
                            throw new Exception(JText::_('PLG_ECC_INTERNALERRORSQLINJECTION'), 500);
                        }

                        $pDbprefix = $this->app->get('dbprefix');
                        $ta = array(
                            '/(\s+|\.|,)`?(#__)/',
                            '/(\s+|\.|,)`?(jos_)/i',
                            "/(\s+|\.|,)`?({$pDbprefix}_)/i"
                        );

                        foreach ($ta as $t) {
                            if (preg_match($t, $v)) {
                                throw new Exception(JText::_('PLG_ECC_INTERNALERRORSQLINJECTION'), 500);
                            }
                        }

                        if (in_array($k, array(
                            'controller',
                            'view',
                            'model',
                            'template'
                        ))) {
                            $recurse = str_repeat('\.\.\/', 2);

                            while (preg_match('@' . $recurse . '@', $v)) {
                                throw new Exception(JText::_('PLG_ECC_INTERNALERRORSQLINJECTION'), 500);
                            }
                        }

                        unset($v);
                    }
                }
            }
        }

        // Backend protection
        if ($this->params->get('backendprotection')) {
            if ($this->app->isAdmin()) {
                if ($this->user->guest) {
                    $token = $this->params->get('token');
                    $requestToken = $this->request->get('token', 0, 'RAW');
                    $tokenSession = $this->getSession('token');

                    if (!isset($tokenSession)) {
                        $this->setSession('token', 0);
                    }

                    // Conversion to UTF8 (german umlauts)
                    if (utf8_encode($requestToken) == $token) {
                        $this->setSession('token', 1);
                    } elseif (utf8_encode($requestToken) != $token) {
                        if (empty($tokenSession)) {
                            $url = $this->params->get('urlfalsetoken');

                            if (empty($url)) {
                                $url = JUri::root();
                            }

                            $this->clearSession('token');
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
        $encodedVariablesSession = $this->getSession('fields_encoded', '');

        if (!empty($encodedVariablesSession)) {
            $form = array();
            $encodedVariables = unserialize(base64_decode($encodedVariablesSession));

            foreach ($encodedVariables as $key => $value) {
                $valueRequest = $this->request->get($value, null, 'STRING');

                // Decode variable only if it is set!
                if (isset($valueRequest)) {
                    // Is this decoded variable trasmitted in the request?
                    if (!empty($valueRequest)) {
                        // If key is an array, then handle it correctly
                        if (preg_match('@(.*)\[(.+)\]@isU', $key, $matches)) {
                            $form[$matches[1]][$matches[2]] = $valueRequest;
                        } else {
                            $form[$key] = $valueRequest;
                        }

                        // Unset the decoded variable from the request
                        $this->request->set($value, '');

                        continue;
                    }

                    // If key is an array, then handle it correctly
                    if (preg_match('@(.*)\[(.+)\]@isU', $key, $matches)) {
                        $form[$matches[1]][$matches[2]] = '';
                    } else {
                        $form[$key] = '';
                    }

                    // Unset the decoded variable from the request
                    $this->request->set($value, '');
                }
            }

            // Set the decoded fields back to the request variable
            foreach ($form as $key => $value) {
                $this->request->set($key, $value);

                // We also need to set the variable to the global $_POST variable - needed for the token check of the components
                // Do not use the API because we need first to gather all information - set variables directly
                $_POST[$key] = $value;
            }

            $this->clearSession('fields_encoded');
        }
    }

    /**
     * Redirects if spamcheck was not passed successfully
     *
     * @param string $redirectUrl
     */
    private function redirect($redirectUrl)
    {
        // PHP Redirection
        header('Location: ' . $redirectUrl);

        // JS Redirection - as fallback
        ?>
        <script type="text/javascript">window.location = '<?php echo $redirectUrl; ?>'</script>
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
        if ($this->params->get('custom_call') && $this->loadEccCustom()) {
            // Load error notice if needed
            $this->raiseErrorWarning($option, true);

            // Determine whether the check was already loaded and the data have to be validated
            $checkCustomCall = (array) $this->getSession('check_custom_call', array());
            $this->clearSession('check_custom_call');

            if (!empty($checkCustomCall)) {
                // Get all request variables for the check
                $request = $this->request->getArray($_REQUEST);

                // Go through all request variable until one hit to check whether the form was submitted by the user
                foreach ($checkCustomCall as $requestVariable) {
                    if (array_key_exists($requestVariable, $request)) {
                        // Clean cache
                        $this->cleanCache();

                        // Save entered values in session for autofill
                        if ($this->params->get('autofill_values')) {
                            $this->saveData();
                        }

                        // Do the checks to protect the custom form
                        if (!$this->performChecks()) {
                            // Set error session variable for the message output
                            $this->setSession('error_output', 'check_failed_custom');
                            $this->redirect($this->redirectUrl);
                        }

                        break;
                    }
                }
            }
        }

        // Clean cache of component if ECC+ has to be loaded
        if ($this->loadEccCheck == true || $this->loadEcc == true) {
            $this->cleanCache();
        }

        if ($this->loadEccCheck == true) {
            // Save entered values in session for autofill
            if ($this->params->get('autofill_values')) {
                $this->saveData();
            }

            // Call checks for forms
            $this->callChecks($option, $task);
        }

        if ($this->loadEcc == true) {
            // Raise error warning if needed - do the check
            $this->raiseErrorWarning($option);

            // Write head data
            $head = array();
            $head[] = '<style type="text/css">#easycalccheckplus {margin: 8px 0 !important; padding: 2px !important;}</style>';

            if ($option == "com_flexicontactplus" && $this->params->get('flexicontactplus')) {
                $head[] = '<style type="text/css">#easycalccheckplus label {width: auto;}</style>';
            }

            if ($option == 'com_comprofiler' && $this->params->get('communitybuilder')) {
                $head[] = '<style type="text/css">#easycalccheckplus label {width: 100%;} #easycalccheckplus input {height: 34px;}</style>';
            }

            if ($this->params->get('poweredby')) {
                $head[] = '<style type="text/css">.protectedby {font-size: x-small !important; text-align: right !important;}</style>';
            }

            if ($this->params->get('type_hidden')) {
                $this->setSession('hidden_class', $this->random());
                $head[] = '<style type="text/css">.' . $this->getSession('hidden_class') . ' {display: none !important;}</style>';

                if ($this->params->get('foxcontact') && $option == "com_foxcontact") {
                    $head[] = '<style type="text/css">label.' . $this->getSession('hidden_class') . ' {margin: 0 !important; padding: 0 !important;}</style>';
                }
            }

            if ($option == 'com_kunena' && $this->params->get('kunena') && $this->params->get('recaptcha')) {
                $head[] = '<style type="text/css">div#recaptcha_area{margin: auto !important;}</style>';
            }

            if ($option == 'com_kunena' && $this->params->get('kunena')) {
                $head[] = '<style type="text/css">a#btn_qreply{display:none;}</style>';
            }

            if ($this->params->get('recaptcha')) {
                $this->getRecaptchaHead($head);
            }

            $head = "\n" . implode("\n", $head) . "\n";
            $document = JFactory::getDocument();

            if ($document->getType() == 'html') {
                $document->addCustomTag($head);
            }
        }

        // Workaround for Kunena - Remove Quick Reply button, only allow full editor replies
        if ($option == 'com_kunena' && $this->params->get('kunena')) {
            if ($this->user->guest) {
                $document = JFactory::getDocument();

                if ($document->getType() == 'html') {
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
        if ($this->params->get('recaptcha_publickey') && $this->params->get('recaptcha_privatekey')) {
            $head[] = '<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=' . substr(JFactory::getLanguage()->getTag(), 0, 2) . '" defer async></script>';

            $theme = 'light';

            if ($this->params->get('recaptcha_theme') == 1) {
                $theme = 'dark';
            }

            $head[] = '<script type="text/javascript">var onloadCallback = function() {grecaptcha.render("recaptcha", {"sitekey" : "' . $this->params->get('recaptcha_publickey') . '", "theme" : "' . $theme . '"});};</script>';

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
        if ($this->app->isAdmin() || ($this->params->get('onlyguests') && !$this->user->guest)) {
            $this->loadEcc = false;
            $this->loadEccCheck = false;
        } else {
            // Find out if ECC+ has to be loaded depending on the called component
            if ($option == 'com_contact') {
                // Array -> (name, form, regex for hidden field, regex for output, task, request exception for encode option);
                $this->extensionInfo = array(
                    'com_contact',
                    '<form[^>]+id="contact-form".+</form>',
                    '<label id="jform_contact.+>',
                    '<button class="btn btn-primary validate" type="submit">',
                    'contact.submit'
                );

                if ($this->params->get('contact') && $view == 'contact') {
                    $this->loadEcc = true;
                }

                if ($this->params->get('contact') && $task == 'contact.submit') {
                    $this->loadEccCheck = true;
                }
            } elseif ($option == 'com_mailto') {
                $this->extensionInfo = array(
                    'com_mailto',
                    '<form[^>]+id="mailtoForm".+</form>',
                    '<label for=".+_field".+>',
                    '<button type="button" class="button" onclick=".+submitbutton.+">',
                    'send'
                );

                if ($this->params->get('mailto_content')) {
                    if ($task != 'send') {
                        $this->loadEcc = true;
                    } elseif ($task == 'send') {
                        $this->loadEccCheck = true;
                    }
                }
            } elseif ($option == 'com_users') {
                if ($layout != 'confirm' && $layout != 'complete') {
                    if ($view == 'registration') {
                        $this->extensionInfo = array(
                            'com_users',
                            '<form[^>]+id="member-registration".+</form>',
                            '<label id="jform.+>',
                            '<button type="submit" class="validate">',
                            'registration.register'
                        );
                    } elseif ($view == 'reset' || $view == 'remind') {
                        $this->extensionInfo = array(
                            'com_users',
                            '<form[^>]+id="user-registration".+</form>',
                            '<label id="jform_email-lbl"',
                            '<button type="submit">',
                            'registration.register'
                        );
                    } elseif ($view == 'login' || $view == '') {
                        $this->extensionInfo = array(
                            'com_users',
                            '<form[^>]+(task=user\.login.+>|>.+value="user\.login")+.+</form>',
                            '<label id=".+"',
                            '<button type="submit" class=".*">',
                            'registration.register'
                        );
                    }

                    if ($this->params->get('user_reg') && ($view == 'registration' || $view == 'reset' || $view == 'remind')) {
                        $this->loadEcc = true;
                    }

                    if ($this->params->get('user_reg') && ($task == 'registration.register' || $task == 'reset.request' || $task == 'remind.remind')) {
                        $this->loadEccCheck = true;
                    }

                    if ($this->params->get('user_login') && ($view == 'login' || $view == '') && ($task == '')) {
                        $this->loadEcc = true;
                        $this->setSession('user_login', 1);
                    } elseif ($this->params->get('user_login') && ($task == 'user.login')) {
                        $userLoginCheck = $this->getSession('user_login');

                        if (!empty($userLoginCheck)) {
                            $this->loadEccCheck = true;
                        } else {
                            $failedLoginAttempts = $this->getSession('failed_login_attempts');

                            if (empty($failedLoginAttempts)) {
                                $failedLoginAttempts = 0;
                            }

                            if ($failedLoginAttempts >= $this->params->get('user_login_attempts')) {
                                $this->redirect(JRoute::_('index.php?option=com_users&view=login&eccp_err=login_attempts', false));
                            }
                        }
                    }
                }
            } elseif ($option == 'com_easybookreloaded' && $this->params->get('easybookreloaded')) {
                // Easybook Reloaded 3.3.1
                $this->extensionInfo = array(
                    'com_easybookreloaded',
                    '<form[^>]+name=("|\')gbookForm("|\').+</form>',
                    '<input type=.+>',
                    '<p id="easysubmit">',
                    'save',
                    'gbookForm, gbvote, gbtext'
                );

                if ($task == 'add') {
                    $this->loadEcc = true;
                } elseif ($task == 'save') {
                    $this->loadEccCheck = true;
                }
            } elseif ($option == 'com_phocaguestbook' && $this->params->get('phocaguestbook')) {
                // Phoca Guestbook 3.0.6
                $this->extensionInfo = array(
                    'com_phocaguestbook',
                    '<form.+com_phocaguestbook.*</form>',
                    '<input type=.+>',
                    '<div class="btn-group">\s*<button type="submit".*>',
                    'submit'
                );

                if ($view == 'guestbook' && $task != 'phocaguestbook.submit') {
                    $this->loadEcc = true;
                } elseif ($task == 'phocaguestbook.submit') {
                    $this->loadEccCheck = true;
                }
            } elseif ($option == 'com_comprofiler' && $this->params->get('communitybuilder')) {
                // Community Builder 2.1.2
                $eccLoaded = $this->getSession('ecc_loaded', false);

                if ($task == 'registers' || $view == 'registers') {
                    $this->extensionInfo = array(
                        'com_comprofiler',
                        '<form[^>]+id="cbcheckedadminForm".+</form>',
                        '<label for=".+>',
                        '<input type="submit" value=".+" class="button" />',
                        'saveregisters'
                    );
                } elseif ($task == 'lostpassword' || $view == 'lostpassword') {
                    $this->extensionInfo = array(
                        'com_comprofiler',
                        '<form[^>]+id="adminForm".+</form>',
                        '<label for=".+>',
                        '<input type="submit" class="button" id="cbsendnewuspass" value=".+" />',
                        'sendNewPass'
                    );
                }

                if ($task == 'registers' || $view == 'registers' || $task == 'lostpassword' || $view == 'lostpassword') {
                    $this->loadEcc = true;
                } elseif ($task == 'saveregisters' || $view == 'saveregisters' || $task == 'sendNewPass' || $view == 'sendnewpass') {
                    if ($eccLoaded == true) {
                        $this->loadEccCheck = true;
                    }
                }
            } elseif ($option == 'com_dfcontact' && $this->params->get('dfcontact')) {
                // DFContact - tested with version 1.6.6
                $this->extensionInfo = array(
                    'com_dfcontact',
                    '<form[^>]+id="dfContactForm".+</form>',
                    '<label for="dfContactField.+>',
                    '<input type="submit" value=".+" class="button" />'
                );

                if ($view == 'dfcontact' && empty($_REQUEST["submit"])) {
                    $this->loadEcc = true;
                } elseif ($view == 'dfcontact' && !empty($_REQUEST["submit"])) {
                    $this->loadEccCheck = true;
                }
            } elseif ($option == 'com_foxcontact' && $this->params->get('foxcontact')) {
                // FoxContact - tested with version 2.0.15
                $this->extensionInfo = array(
                    'com_foxcontact',
                    '<form[^>]+id="FoxForm".+</form>',
                    '<input class=.+>',
                    '<input class="foxbutton" type="submit" style=".+" name=".+" value=".+"/>'
                );

                $Itemid = $this->request->get('Itemid', '', 'CMD');

                if ($view == 'foxcontact' && !isset($_REQUEST['cid_' . $Itemid])) {
                    $this->loadEcc = true;
                } elseif ($view == 'foxcontact' && isset($_REQUEST['cid_' . $Itemid])) {
                    $this->loadEccCheck = true;
                }
            } elseif ($option == 'com_flexicontact' || $option == 'com_flexicontactplus') {
                // FlexiContact 10.05 / FlexiContact Plus - tested with version 6.07
                $regexOutput = '<input type="submit" class=".+".*name="send_button".+/>';

                if ($option == 'com_flexicontactplus') {
                    $regexOutput = '<div class="fcp_sendrow">';
                }

                $this->extensionInfo = array(
                    $option,
                    '<form[^>]+name="fc.?_form".+</form>',
                    '<input type=.+>',
                    $regexOutput,
                    'send'
                );

                if ((($this->params->get('flexicontact') && $option == 'com_flexicontact') || ($this->params->get('flexicontactplus') && $option == 'com_flexicontactplus')) && $view == 'contact' && empty($task)) {
                    $this->loadEcc = true;
                } elseif ((($this->params->get('flexicontact') && $option == 'com_flexicontact') || ($this->params->get('flexicontactplus') && $option == 'com_flexicontactplus')) && $view == 'contact' && $task == 'send') {
                    $this->loadEccCheck = true;
                }
            } elseif ($option == 'com_kunena' && $this->params->get('kunena')) // Kunena Forum 5.0.7
            {
                $this->extensionInfo = array(
                    'com_kunena',
                    '<form[^>]+id="postform".+</form>',
                    '<input type=.+>',
                    '<button[^>]+type="submit"[^>]+>',
                    'post'
                );

                if (($func == 'post' || ($view == 'topic' && ($layout == 'reply' || $layout == 'create' || $layout == ''))) && $task != 'post') {
                    $this->loadEcc = true;
                } elseif ($func == 'post' || $task == 'post') {
                    $this->loadEccCheck = true;
                }
            } elseif ($option == 'com_alfcontact' && $this->params->get('alfcontact')) {
                // ALFContact 3.2.6
                $this->extensionInfo = array(
                    'com_alfcontact',
                    '<form[^>]+id="contact-form".+</form>',
                    '<label for=".+>',
                    '<button class="button">',
                    'sendemail'
                );

                if ($view == 'alfcontact' && empty($task)) {
                    $this->loadEcc = true;
                } elseif ($task == 'sendemail') {
                    $this->loadEccCheck = true;
                }
            } elseif ($option == 'com_aicontactsafe' && $this->params->get('aicontactsafe')) {
                // aiContactSafe - tested with version 2.0.19
                $this->extensionInfo = array(
                    'com_aicontactsafe',
                    '<form[^>]+id="adminForm_.+</form>',
                    '<label for=".+>',
                    '<input type="submit" id="aiContactSafeSendButton"',
                    'display'
                );

                $sTask = $this->request->get('sTask', '', 'STRING');

                if (empty($sTask)) {
                    $this->loadEcc = true;
                } elseif ($sTask == 'message') {
                    $this->loadEccCheck = true;
                }
            } elseif ($option == 'com_community' && $this->params->get('jomsocial')) {
                // JomSocial - tested with version 2.6 RC2
                $this->extensionInfo = array(
                    'com_community',
                    '<form[^>]+id="jomsForm".+</form>',
                    '<label id=".+>',
                    '<div[^>]+cwin-wait.*></div>',
                    'register_save'
                );

                if ($view == 'register' && ($task == '' || $task == 'register')) {
                    $this->loadEcc = true;
                } elseif ($view == 'register' && $task == 'register_save') {
                    $this->loadEccCheck = true;
                }
            } elseif ($option == 'com_virtuemart' && $this->params->get('virtuemart')) {
                // Virtuemart - tested with version 2.0.24a
                if ($task == 'askquestion' || $task == 'mailAskquestion') {
                    $this->extensionInfo = array(
                        'com_virtuemart',
                        '<form[^>]+id="askform".+</form>',
                        '<label>',
                        '<input[^>]*type="submit" name="submit_ask"[^>]*/>',
                        'mailAskquestion'
                    );

                    if ($view == 'productdetails' && $task == 'askquestion') {
                        $this->loadEcc = true;
                    } elseif ($view == 'productdetails' && $task == 'mailAskquestion') {
                        $this->loadEccCheck = true;
                    }
                } elseif ($task == 'editaddresscheckout' || $task == 'registercheckoutuser' || $task == 'savecheckoutuser') {
                    $this->extensionInfo = array(
                        'com_virtuemart',
                        '<form[^>]+id="userForm".+</form>',
                        '<label.+>',
                        '<button[^>]*type="submit"[^>]*>',
                        'savecheckoutuser'
                    );

                    if ($view == 'user' && $task == 'editaddresscheckout') {
                        $this->loadEcc = true;
                    } elseif ($view == 'user' && ($task == 'registercheckoutuser' || $task == 'savecheckoutuser')) {
                        $this->loadEccCheck = true;
                    }
                } elseif ($task == 'editaddresscart' || $task == 'registercartuser' || $task == 'savecartuser') {
                    $this->extensionInfo = array(
                        'com_virtuemart',
                        '<form[^>]+id="userForm".+</form>',
                        '<label.+>',
                        '<button[^>]*type="submit"[^>]*>',
                        'savecartuser'
                    );

                    if ($view == 'user' && $task == 'editaddresscart') {
                        $this->loadEcc = true;
                    } elseif ($view == 'user' && ($task == 'registercartuser' || $task == 'savecartuser')) {
                        $this->loadEccCheck = true;
                    }
                } elseif ($view == 'user' && ($layout == 'edit' || $layout == 'default' || $task == 'saveUser' || $task == 'register')) {
                    $this->extensionInfo = array(
                        'com_virtuemart',
                        '<form[^>]+name="userForm".+</form>',
                        '<label.+>',
                        '<button[^>]*type="submit"[^>]*>',
                        'saveUser'
                    );

                    if (($layout == 'edit' || $layout == 'default' || $task == 'register') && $task != 'saveUser') {
                        $this->loadEcc = true;
                    } elseif ($task == 'saveUser') {
                        $this->loadEccCheck = true;
                    }
                }
            } elseif ($option == 'com_iproperty' && $this->params->get('iproperty')) {
                // IProperty - tested with version 3.3
                $this->extensionInfo = array(
                    'com_iproperty',
                    '<form[^>]+name="sendRequest".+</form>',
                    '<label id=".+>',
                    '<button[^>]*type="submit"[^>]*>',
                    'property.sendRequest'
                );

                if ($view == 'property' && $task == '') {
                    $this->loadEcc = true;
                } elseif ($view == 'property' && $task == 'property.sendRequest') {
                    $this->loadEccCheck = true;
                }
            }
        }

        // Clear user_login session variable to avoid errors if a user logs in via the module
        if ($this->params->get('user_login') && $this->getSession('user_login')) {
            if ($option == 'com_users') {
                if ($this->loadEcc == false) {
                    $this->clearSession('user_login');
                }
            } else {
                $this->clearSession('user_login');
            }
        }

        $this->clearSession('ecc_loaded');
    }

    /**
     * Checks whether ECC+ has to be loaded in a custom call
     *
     * @return boolean
     */
    private function loadEccCustom()
    {
        // Do not execute the custom call in the administration or if the check is disabled for guests
        if ($this->app->isAdmin() || ($this->params->get('onlyguests') && !$this->user->guest)) {
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
        if (empty($this->warningShown)) {
            // Load error session variable for the message output
            $errorOutput = $this->getSession('error_output');

            if (!empty($errorOutput)) {
                if ($errorOutput == 'check_failed') {
                    if (($option == 'com_phocaguestbook' && $this->getSession('phocaguestbook') == 0) || ($option == 'com_easybookreloaded' && $this->getSession('easybookreloaded') == 0)) {
                        // No message output needed - message is raised by components
                    } else {
                        $this->app->enqueueMessage(JText::_('PLG_ECC_YOUHAVENOTRESOLVEDOURSPAMCHECK'), 'error');
                    }
                } elseif ($errorOutput == 'check_failed_custom' && $custom == true) {
                    // Only raise general error message if the custom call is used
                    $this->app->enqueueMessage(JText::_('PLG_ECC_YOUHAVENOTRESOLVEDOURSPAMCHECK'), 'error');
                } elseif ($errorOutput == 'login_attempts') {
                    $this->app->enqueueMessage(JText::_('PLG_ECC_TOOMANYFAILEDLOGINATTEMPTS'), 'error');
                }

                $this->clearSession('error_output');
                $this->warningShown = true;
            }
        }
    }

    /**
     * Cleans cache to avoid inconsistent output
     */
    private function cleanCache()
    {
        $config = JFactory::getConfig();

        if ($config->get('caching') != 0) {
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
        $dataArray = array();
        $keysExclude = array(
            'option',
            'view',
            'layout',
            'id',
            'Itemid',
            'task',
            'controller',
            'func'
        );

        foreach ($request as $key => $value) {
            if (!in_array($key, $keysExclude)) {
                if (is_array($value)) {
                    foreach ($value as $key2 => $value2) {
                        // Need second request for user profile plugin
                        if (is_array($value2)) {
                            foreach ($value2 as $key3 => $value3) {
                                $key4 = $key . '[' . $key2 . '][' . $key3 . ']';
                                $dataArray[$key4] = $value3;
                            }

                            continue;
                        }

                        $key3 = $key . '[' . $key2 . ']';
                        $dataArray[$key3] = $value2;
                    }

                    continue;
                }

                $dataArray[$key] = $value;
            }
        }

        $this->setSession('saved_data', $dataArray);
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
        if ($this->params->get('type_calc')) {
            if ($this->getSession('rot13') == 1) {
                $spamcheckResult = base64_decode(str_rot13($this->getSession('spamcheckresult')));
            } else {
                $spamcheckResult = base64_decode($this->getSession('spamcheckresult'));
            }

            $spamcheck = $request[$this->getSession('spamcheck')];

            $this->clearSession('rot13');
            $this->clearSession('spamcheck');
            $this->clearSession('spamcheckresult');

            if (!is_numeric($spamcheckResult) || $spamcheckResult != $spamcheck) {
                return false; // Wrong result - failed
            }
        }

        // Hidden field
        if ($this->params->get('type_hidden')) {
            $hiddenField = $request[$this->getSession('hidden_field')];
            $this->clearSession('hidden_field');

            if (!empty($hiddenField)) {
                return false; // Hidden field was filled out - failed
            }
        }

        // Time lock
        if ($this->params->get('type_time')) {
            $time = $this->getSession('time');
            $this->clearSession('time');

            if (time() - $this->params->get('type_time_sec') <= $time) {
                return false; // Submitted too fast - failed
            }
        }

        // Own Question
        // Conversion to lower case
        if ($this->params->get('question')) {
            $answer = strtolower($request[$this->getSession('question')]);
            $this->clearSession('question');

            if ($answer != strtolower($this->params->get('question_a'))) {
                return false; // Question wasn't answered - failed
            }
        }

        // StopForumSpam - Check the IP Address
        // Further informations: http://www.stopforumspam.com
        if ($this->params->get('stopforumspam')) {
            $url = 'http://www.stopforumspam.com/api?ip=' . $this->getSession('ip');

            // Function test - Comment out to test - Important: Enter a active Spam-IP
            // $ip = '88.180.52.46';
            // $url = 'http://www.stopforumspam.com/api?ip='.$ip;

            $response = false;
            $isSpam = false;

            if (function_exists('curl_init')) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_POST, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($ch);
                curl_close($ch);
            }

            if ($response) {
                preg_match('#<appears>(.*)</appears>#', $response, $out);
                $isSpam = $out[1];
            } else {
                $response = @fopen($url, 'r');

                if ($response) {
                    while (!feof($response)) {
                        $line = fgets($response, 1024);

                        if (preg_match('#<appears>(.*)</appears>#', $line, $out)) {
                            $isSpam = $out[1];
                            break;
                        }
                    }

                    fclose($response);
                }
            }

            if ($isSpam == 'yes' && $response == true) {
                return false; // Spam-IP - failed
            }
        }

        // Honeypot Project
        // Further informations: http://www.projecthoneypot.org/home.php
        // BL ACCESS KEY - http://www.projecthoneypot.org/httpbl_configure.php
        if ($this->params->get('honeypot')) {
            require_once(dirname(__FILE__) . '/easycalccheckplus/honeypot.php');
            $httpBlKey = $this->params->get('honeypot_key');

            if ($httpBlKey) {
                $httpBl = new http_bl($httpBlKey);
                $result = $httpBl->query($this->getSession('ip'));

                // Function test - Comment out to test - Important: Enter an active Spam-IP
                // $ip = '117.21.224.251';
                // $result = $http_bl->query($ip);

                if ($result == 2) {
                    return false;
                }
            }
        }

        // Akismet
        // Further informations: http://akismet.com/
        if ($this->params->get('akismet')) {
            require_once(dirname(__FILE__) . '/easycalccheckplus/akismet.php');
            $akismetKey = $this->params->get('akismet_key');

            if ($akismetKey) {
                $akismetUrl = JUri::getInstance()->toString();

                $name = '';
                $email = '';
                $url = '';
                $comment = '';

                if ($request['option'] == 'com_contact') {
                    $name = $request['jform']['contact_name'];
                    $email = $request['jform']['contact_email'];
                    $comment = $request['jform']['contact_message'];
                } elseif ($request['option'] == 'com_mailto') {
                    $name = $request['sender'];
                    $email = $request['mailto'];
                    $comment = $request['subject'];
                } elseif ($request['option'] == 'com_users') {
                    $name = $request['jform']['name'];
                    $email = $request['jform']['email1'];

                    if (isset($request['jform']['email'])) {
                        $email = $request['jform']['email'];
                    }
                } elseif ($request['option'] == 'com_comprofiler') {
                    $name = $request['name'];
                    $email = $request['email'];

                    if (isset($request['checkusername'])) {
                        $name = $request['checkusername'];
                    }

                    if (isset($request['checkemail'])) {
                        $email = $request['checkemail'];
                    }
                } elseif ($request['option'] == 'com_easybookreloaded') {
                    $name = $request['gbname'];
                    $email = $request['gbmail'];
                    $comment = $request['gbtext'];

                    if (isset($request['gbpage'])) {
                        $url = $request['gbpage'];
                    }
                } elseif ($request['option'] == 'com_phocaguestbook') {
                    $name = $request['pgusername'];
                    $email = $request['email'];
                    $comment = $request['pgbcontent'];
                } elseif ($request['option'] == 'com_dfcontact') {
                    $name = $request['name'];
                    $email = $request['email'];
                    $comment = $request['message'];
                } elseif ($request['option'] == 'com_flexicontact' || $request['option'] == 'com_flexicontactplus') {
                    $name = $request['from_name'];
                    $email = $request['from_email'];
                    $comment = $request['area_data'];
                } elseif ($request['option'] == 'com_alfcontact') {
                    $name = $request['name'];
                    $email = $request['email'];
                    $comment = $request['message'];
                } elseif ($request['option'] == 'com_community') {
                    $name = $request['usernamepass'];
                    $email = $request['emailpass'];
                } elseif ($request['option'] == 'com_virtuemart') {
                    $name = $request['name'];
                    $email = $request['email'];
                    $comment = $request['comment'];
                } elseif ($request['option'] == 'com_aicontactsafe') {
                    $name = $request['aics_name'];
                    $email = $request['aics_email'];
                    $comment = $request['aics_message'];
                }

                $akismet = new Akismet($akismetUrl, $akismetKey);
                $akismet->setCommentAuthor($name);
                $akismet->setCommentAuthorEmail($email);
                $akismet->setCommentAuthorURL($url);
                $akismet->setCommentContent($comment);

                if ($akismet->isCommentSpam()) {
                    return false;
                }
            }
        }

        // ReCaptcha - Further informations: https://www.google.com/recaptcha
        if ($this->params->get('recaptcha')) {
            if ($this->params->get('recaptcha_publickey') && $this->params->get('recaptcha_privatekey')) {
                require_once(dirname(__FILE__) . '/easycalccheckplus/recaptchalib.php');
                $privateKey = $this->params->get('recaptcha_privatekey');

                $reCaptcha = new ReCaptcha($privateKey);
                $response = $reCaptcha->verifyResponse($this->getSession('ip'), $request['g-recaptcha-response']);

                if ($response->success == false) {
                    return false;
                }
            }
        }

        // Botscout - Check the IP Address
        // Further informations: http://botscout.com/
        if ($this->params->get('botscout') && $this->params->get('botscout_key')) {
            $url = 'http://botscout.com/test/?ip=' . $this->getSession('ip') . '&key=' . $this->params->get('botscout_key');

            // Function test - Comment out to test - Important: Enter a active Spam-IP
            // $ip = '87.103.128.199';
            // $url = 'http://botscout.com/test/?ip='.$ip.'&key='.$this->params->get('botscout_key');

            $response = false;
            $isSpam = false;

            if (function_exists('curl_init')) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_POST, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($ch);
                curl_close($ch);
            }

            if ($response) {
                $isSpam = substr($response, 0, 1);
            } else {
                $response = @ fopen($url, 'r');

                if ($response) {
                    while (!feof($response)) {
                        $line = fgets($response, 1024);
                        $isSpam = substr($line, 0, 1);
                    }

                    fclose($response);
                }
            }

            if ($isSpam == 'Y' && $response == true) {
                return false; // Spam-IP - failed
            }
        }

        // Mollom
        // Further informations: http://mollom.com/
        if ($this->params->get('mollom') && $this->params->get('mollom_publickey') && $this->params->get('mollom_privatekey')) {
            require_once(dirname(__FILE__) . '/easycalccheckplus/mollom.php');

            Mollom::setPublicKey($this->params->get('mollom_publickey'));
            Mollom::setPrivateKey($this->params->get('mollom_privatekey'));

            $servers = Mollom::getServerList();

            $name = '';
            $email = '';
            $url = '';
            $comment = '';

            if ($request['option'] == 'com_contact') {
                $name = $request['jform']['contact_name'];
                $email = $request['jform']['contact_email'];
                $comment = $request['jform']['contact_message'];
            } elseif ($request['option'] == 'com_mailto') {
                $name = $request['sender'];
                $email = $request['mailto'];
                $comment = $request['subject'];
            } elseif ($request['option'] == 'com_users') {
                $name = $request['jform']['name'];
                $email = $request['jform']['email1'];

                if (isset($request['jform']['email'])) {
                    $email = $request['jform']['email'];
                }
            } elseif ($request['option'] == 'com_comprofiler') {
                $name = $request['name'];
                $email = $request['email'];

                if (isset($request['checkusername'])) {
                    $name = $request['checkusername'];
                }

                if (isset($request['checkemail'])) {
                    $email = $request['checkemail'];
                }
            } elseif ($request['option'] == 'com_easybookreloaded') {
                $name = $request['gbname'];
                $email = $request['gbmail'];
                $comment = $request['gbtext'];

                if (isset($request['gbpage'])) {
                    $url = $request['gbpage'];
                }
            } elseif ($request['option'] == 'com_phocaguestbook') {
                $name = $request['pgusername'];
                $email = $request['email'];
                $comment = $request['pgbcontent'];
            } elseif ($request['option'] == 'com_dfcontact') {
                $name = $request['name'];
                $email = $request['email'];
                $comment = $request['message'];
            } elseif ($request['option'] == 'com_flexicontact' || $request['option'] == 'com_flexicontactplus') {
                $name = $request['from_name'];
                $email = $request['from_email'];
                $comment = $request['area_data'];
            } elseif ($request['option'] == 'com_alfcontact') {
                $name = $request['name'];
                $email = $request['email'];
                $comment = $request['message'];
            } elseif ($request['option'] == 'com_community') {
                $name = $request['usernamepass'];
                $email = $request['emailpass'];
            } elseif ($request['option'] == 'com_virtuemart') {
                $name = $request['name'];
                $email = $request['email'];
                $comment = $request['comment'];
            } elseif ($request['option'] == 'com_aicontactsafe') {
                $name = $request['aics_name'];
                $email = $request['aics_email'];
                $comment = $request['aics_message'];
            }

            $feedback = Mollom::checkContent(null, null, $comment, $name, $url, $email);

            if ($feedback['spam'] == 'spam') {
                return false;
            }
        }

        $this->clearSession('ip');
        $this->clearSession('saved_data');

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
        $checkFailed = false;
        $itemId = $this->request->get('Itemid', '', 'CMD');
        $view = $this->request->get('view', '', 'WORD');

        if ($option == 'com_users' && ($task == 'reset.request' || $task == 'remind.remind')) {
            if (!$this->performChecks()) {
                $checkFailed = true;
            }
        } elseif ($option == 'com_users' && $task == 'user.login') {
            if (!$this->performChecks()) {
                $checkFailed = true;
            } else {
                $this->clearSession('failed_login_attempts');
            }
        } elseif ($option == 'com_mailto' && $task == 'send') {
            if (!$this->performChecks()) {
                $checkFailed = true;
            }
        } elseif ($option == 'com_easybookreloaded' && $task == 'save') {
            if (!$this->performChecks()) {
                $this->setSession('easybookreloaded', 1);
                $checkFailed = true;
            }
        } elseif ($option == 'com_phocaguestbook' && $task == 'phocaguestbook.submit') {
            if (!$this->performChecks()) {
                $this->setSession('phocaguestbook', 1);
                $checkFailed = true;
            }
        } elseif ($option == 'com_comprofiler' && ($task == 'sendNewPass' || $view == 'sendnewpass' || $view == 'saveregisters')) {
            if (!$this->performChecks()) {
                $checkFailed = true;
            }
        } elseif ($option == 'com_dfcontact' && !empty($_REQUEST["submit"])) {
            if (!$this->performChecks()) {
                $checkFailed = true;
            }
        } elseif ($option == 'com_foxcontact' && isset($_REQUEST['cid_' . $itemId])) {
            if (!$this->performChecks()) {
                $checkFailed = true;
            }
        } elseif (($option == 'com_flexicontact' || $option == 'com_flexicontactplus') && $task == 'send') {
            if (!$this->performChecks()) {
                $checkFailed = true;
            }
        } elseif ($option == 'com_kunena' && $task = 'post') {
            if (!$this->performChecks()) {
                $checkFailed = true;
            }
        } elseif ($option == 'com_alfcontact' && $task == 'sendemail') {
            if (!$this->performChecks()) {
                $checkFailed = true;
            }
        } elseif ($option == 'com_community' && $task == 'register_save') {
            if (!$this->performChecks()) {
                $checkFailed = true;
            }
        } elseif ($option == 'com_virtuemart' && ($task == 'mailAskquestion' || $task == 'registercheckoutuser' || $task == 'savecheckoutuser' || $task == 'registercartuser' || $task == 'savecartuser' || $task == 'saveUser')) {
            if (!$this->performChecks()) {
                $checkFailed = true;
            }
        } elseif ($option == 'com_aicontactsafe') {
            $sTask = $this->request->get('sTask', '', 'STRING');

            if ($sTask == 'message') {
                if (!$this->performChecks()) {
                    $checkFailed = true;
                }
            }
        } elseif ($option == 'com_iproperty' && $task == 'property.sendRequest') {
            if (!$this->performChecks()) {
                $checkFailed = true;
            }
        }

        if ($checkFailed == true) {
            // Set error session variable for the message output
            $this->setSession('error_output', 'check_failed');
            $this->redirect($this->redirectUrl);
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
        $pwArray = array();

        for ($i = 0; $i < $count; $i++) {
            $pw = '';

            // first character has to be a letter
            $pw .= $characters[mt_rand(0, 25)];

            // other characters arbitrarily
            $characters = array_merge($characters, $numbers);

            $pwLength = mt_rand(4, 12);

            for ($a = 0; $a < $pwLength; $a++) {
                $pw .= $characters[mt_rand(0, 35)];
            }

            $pwArray[] = $pw;
        }

        if ($count == 1) {
            $pwArray = $pwArray[0];
        }

        return $pwArray;
    }

    /**
     * Detects whether the plugin routine has to be loaded and call the checks
     */
    public function onAfterRender()
    {
        // Custom call check - call it here because we need access to the output - since 2.5-8
        if ($this->loadEcc == false) {
            if ($this->params->get('custom_call') && $this->loadEccCustom()) {
                $this->customCall();
            }
        }

        if ($this->loadEcc == true) {
            $option = $this->request->get('option', '', 'WORD');
            $this->loadLanguage('plg_system_easycalccheckplus', JPATH_ADMINISTRATOR);

            // Read in content of the output
            $body = $this->app->getBody();

            // Get form of extension
            preg_match('@' . $this->extensionInfo[1] . '@isU', $body, $matchExtension);

            // Form was not found, the template probably uses overrides, try it with the detection of the task or set error message for debug mode
            if (empty($matchExtension)) {
                // Try to find the form by the task if provided
                if (!empty($this->extensionInfo[4])) {
                    // Get all forms on the loaded page and find the correct form by the task value
                    preg_match_all('@<form[^>]*>.*</form>@isU', $body, $matchExtensionForms);

                    if (!empty($matchExtensionForms)) {
                        foreach ($matchExtensionForms[0] as $matchExtensionForm) {
                            if (preg_match('@<form[^>]*>.*value=["|\']' . $this->extensionInfo[4] . '["|\'].*</form>@isU', $matchExtensionForm, $matchExtension)) {
                                break;
                            }
                        }
                    }
                }

                if (empty($matchExtension)) {
                    $this->app->enqueueMessage(JText::_('PLG_ECC_WARNING_FORMNOTFOUND'), 'error');
                }
            }

            // Fill in form input values if the check failed previously (_warning_shown is set)
            if ($this->params->get('autofill_values') && !empty($this->warningShown)) {
                $this->fillForm($body, $matchExtension);
            }

            // Hidden field
            if ($this->params->get('type_hidden') && !empty($matchExtension)) {
                $patternSearchString = '@' . $this->extensionInfo[2] . '@isU';
                preg_match_all($patternSearchString, $matchExtension[0], $matches);

                if (empty($matches[0])) {
                    $this->app->enqueueMessage(JText::_('PLG_ECC_WARNING_NOHIDDENFIELD'), 'error');
                } else {
                    $count = mt_rand(0, count($matches[0]) - 1);
                    $searchStringHidden = $matches[0][$count];

                    // Generate random variable
                    $this->setSession('hidden_field', $this->random());
                    $this->setSession('hidden_field_label', $this->random());

                    // Line width for obfuscation
                    $inputSize = 30;

                    $addString = '<label class="' . $this->getSession('hidden_class') . '" for="' . $this->getSession('hidden_field_label') . '"></label><input type="text" id="' . $this->getSession('hidden_field_label') . '" name="' . $this->getSession('hidden_field') . '" size="' . $inputSize . '" class="inputbox ' . $this->getSession('hidden_class') . '" />';

                    // Yootheme Fix - Put the hidden field in an own div container to avoid displacement of other fields
                    if (preg_match('@<div[^>]*>\s*' . preg_quote($searchStringHidden, '@') . '@isU', $matchExtension[0], $matchesDiv)) {
                        $searchStringHidden = $matchesDiv[0];
                    }

                    if (isset($searchStringHidden)) {
                        $body = str_replace($searchStringHidden, $addString . $searchStringHidden, $body);
                    }
                }
            }

            // Calc check
            if (($this->params->get('type_calc') || $this->params->get('recaptcha') || $this->params->get('question')) && !empty($matchExtension)) {
                // Without overrides
                $patternOutput = '@' . $this->extensionInfo[3] . '@isU';

                if (preg_match($patternOutput, $matchExtension[0], $matches)) {
                    $searchStringOutput = $matches[0];
                } else {
                    // Alternative search string from settings
                    $stringAlternative = $this->params->get('string_alternative');

                    if (!empty($stringAlternative)) {
                        $pattern = '@' . $stringAlternative . '@isU';

                        if (preg_match($pattern, $matchExtension[0], $matches)) {
                            $searchStringOutput = $matches[0];
                        }
                    }

                    // With overrides
                    if (!isset($searchStringOutput)) {
                        // Artisteer Template
                        if (preg_match('@<span class=".*-button-wrapper">@isU', $matchExtension[0], $matches)) {
                            $searchStringOutput = $matches[0];
                        }

                        // Rockettheme Template
                        if (preg_match('@<div class="readon">@isU', $matchExtension[0], $matches)) {
                            $searchStringOutput = $matches[0];
                        }

                        // String still not found - take the submit attribute
                        if (!isset($searchStringOutput)) {
                            if (preg_match('@<[^>]*type="submit".*>@isU', $matchExtension[0], $matches)) {
                                $searchStringOutput = $matches[0];
                            }
                        }
                    }
                }

                $addString = '<!-- EasyCalcCheck Plus - Kubik-Rubik Joomla! Extensions --><div id="easycalccheckplus">';

                if ($this->params->get('type_calc')) {
                    $this->setSession('spamcheck', $this->random());
                    $this->setSession('rot13', mt_rand(0, 1));

                    // Determine operator
                    $tcalc = 1;

                    if ($this->params->get('operator') == 2) {
                        $tcalc = mt_rand(1, 2);
                    } elseif ($this->params->get('operator') == 1) {
                        $tcalc = 2;
                    }

                    // Determine max. operand
                    $maxValue = $this->params->get('max_value', 20);

                    $spamCheck1 = mt_rand(1, $maxValue);
                    $spamCheck2 = mt_rand(1, $maxValue);

                    if ($this->params->get('operand') == 3) {
                        $spamCheck3 = mt_rand(0, $maxValue);
                    }

                    if (($this->params->get('negative') == 0) && ($tcalc == 2)) {
                        $spamCheck1 = mt_rand($maxValue / 2, $maxValue);
                        $spamCheck2 = mt_rand(1, $maxValue / 2);

                        if ($this->params->get('operand') == 3) {
                            $spamCheck3 = mt_rand(0, $spamCheck1 - $spamCheck2);
                        }
                    }

                    if ($tcalc == 1) // Addition
                    {
                        if ($this->getSession('rot13') == 1) // ROT13 coding
                        {
                            if ($this->params->get('operand') == 2) {
                                $this->setSession('spamcheckresult', str_rot13(base64_encode($spamCheck1 + $spamCheck2)));
                            } elseif ($this->params->get('operand') == 3) {
                                $this->setSession('spamcheckresult', str_rot13(base64_encode($spamCheck1 + $spamCheck2 + $spamCheck3)));
                            }
                        } else {
                            if ($this->params->get('operand') == 2) {
                                $this->setSession('spamcheckresult', base64_encode($spamCheck1 + $spamCheck2));
                            } elseif ($this->params->get('operand') == 3) {
                                $this->setSession('spamcheckresult', base64_encode($spamCheck1 + $spamCheck2 + $spamCheck3));
                            }
                        }
                    } elseif ($tcalc == 2) // Subtraction
                    {
                        if ($this->getSession('rot13') == 1) {
                            if ($this->params->get('operand') == 2) {
                                $this->setSession('spamcheckresult', str_rot13(base64_encode($spamCheck1 - $spamCheck2)));
                            } elseif ($this->params->get('operand') == 3) {
                                $this->setSession('spamcheckresult', str_rot13(base64_encode($spamCheck1 - $spamCheck2 - $spamCheck3)));
                            }
                        } else {
                            if ($this->params->get('operand') == 2) {
                                $this->setSession('spamcheckresult', base64_encode($spamCheck1 - $spamCheck2));
                            } elseif ($this->params->get('operand') == 3) {
                                $this->setSession('spamcheckresult', base64_encode($spamCheck1 - $spamCheck2 - $spamCheck3));
                            }
                        }
                    }

                    $addString .= '<div><label for="' . $this->getSession('spamcheck') . '">' . JText::_('PLG_ECC_SPAMCHECK');

                    if ($tcalc == 1) {
                        if ($this->params->get('converttostring')) {
                            if ($this->params->get('operand') == 2) {
                                $addString .= $this->convertToString($spamCheck1) . ' ' . JText::_('PLG_ECC_PLUS') . ' ' . $this->convertToString($spamCheck2) . ' ' . JText::_('PLG_ECC_EQUALS') . ' ';
                            } elseif ($this->params->get('operand') == 3) {
                                $addString .= $this->convertToString($spamCheck1) . ' ' . JText::_('PLG_ECC_PLUS') . ' ' . $this->convertToString($spamCheck2) . ' ' . JText::_('PLG_ECC_PLUS') . ' ' . $this->convertToString($spamCheck3) . ' ' . JText::_('PLG_ECC_EQUALS') . ' ';
                            }
                        } else {
                            if ($this->params->get('operand') == 2) {
                                $addString .= $spamCheck1 . ' ' . JText::_('PLG_ECC_PLUS') . ' ' . $spamCheck2 . ' ' . JText::_('PLG_ECC_EQUALS') . ' ';
                            } elseif ($this->params->get('operand') == 3) {
                                $addString .= $spamCheck1 . ' ' . JText::_('PLG_ECC_PLUS') . ' ' . $spamCheck2 . ' ' . JText::_('PLG_ECC_PLUS') . ' ' . $spamCheck3 . ' ' . JText::_('PLG_ECC_EQUALS') . ' ';
                            }
                        }
                    } elseif ($tcalc == 2) {
                        if ($this->params->get('converttostring')) {
                            if ($this->params->get('operand') == 2) {
                                $addString .= $this->convertToString($spamCheck1) . ' ' . JText::_('PLG_ECC_MINUS') . ' ' . $this->convertToString($spamCheck2) . ' ' . JText::_('PLG_ECC_EQUALS') . ' ';
                            } elseif ($this->params->get('operand') == 3) {
                                $addString .= $this->convertToString($spamCheck1) . ' ' . JText::_('PLG_ECC_MINUS') . ' ' . $this->convertToString($spamCheck2) . ' ' . JText::_('PLG_ECC_MINUS') . ' ' . $this->convertToString($spamCheck3) . ' ' . JText::_('PLG_ECC_EQUALS') . ' ';
                            }
                        } else {
                            if ($this->params->get('operand') == 2) {
                                $addString .= $spamCheck1 . ' ' . JText::_('PLG_ECC_MINUS') . ' ' . $spamCheck2 . ' ' . JText::_('PLG_ECC_EQUALS') . ' ';
                            } elseif ($this->params->get('operand') == 3) {
                                $addString .= $spamCheck1 . ' ' . JText::_('PLG_ECC_MINUS') . ' ' . $spamCheck2 . ' ' . JText::_('PLG_ECC_MINUS') . ' ' . $spamCheck3 . ' ' . JText::_('PLG_ECC_EQUALS') . ' ';
                            }
                        }
                    }

                    $addString .= '</label>';
                    $addString .= '<input type="text" name="' . $this->getSession('spamcheck') . '" id="' . $this->getSession('spamcheck') . '" size="3" class="inputbox ' . $this->random() . ' validate-numeric required" value="" required="required" />';
                    $addString .= '</div>';

                    // Show warnings
                    if ($this->params->get('warn_ref') && !$this->params->get('autofill_values')) {
                        $addString .= '<p><img src="' . JUri::root() . 'plugins/system/easycalccheckplus/easycalccheckplus/warning.png" alt="' . JText::_('PLG_ECC_WARNING') . '" /> ';
                        $addString .= '<strong>' . JText::_('PLG_ECC_WARNING') . '</strong><br /><small>' . JText::_('PLG_ECC_WARNINGDESC') . '</small>';

                        if ($this->params->get('converttostring')) {
                            $addString .= '<br /><small>' . JText::_('PLG_ECC_CONVERTWARNING') . '</small><br />';
                        }

                        $addString .= '</p>';
                    } elseif ($this->params->get('converttostring')) {
                        $addString .= '<p><small>' . JText::_('PLG_ECC_CONVERTWARNING') . '</small></p>';
                    }
                }

                // Own Question
                if ($this->params->get('question') && $this->params->get('question_q') && $this->params->get('question_a')) {
                    $this->setSession('question', $this->random());

                    $size = strlen($this->params->get('question_a')) + mt_rand(0, 2);

                    $addString .= '<div><label for="' . $this->getSession('question') . '">' . $this->params->get('question_q') . '</label><input type="text" name="' . $this->getSession('question') . '" id="' . $this->getSession('question') . '" size="' . $size . '" class="inputbox ' . $this->random() . ' required" value="" /></div>';
                }

                // ReCaptcha
                if ($this->params->get('recaptcha')) {
                    if ($this->params->get('recaptcha_publickey') && $this->params->get('recaptcha_privatekey')) {
                        $addString .= '<div class="ecc-recaptcha"><div class="g-recaptcha" id="recaptcha"></div></div>';
                    }
                }

                if ($this->params->get('poweredby') == 1) {
                    $addString .= '<div class="protectedby"><a href="http://joomla-extensions.kubik-rubik.de/" title="EasyCalcCheck Plus for Joomla! - Kubik-Rubik Joomla! Extensions" target="_blank">' . JText::_('PLG_ECC_PROTECTEDBY') . '</a></div>';
                }

                $addString .= '</div>';

                if (isset($searchStringOutput)) {
                    if (empty($this->customCall)) {
                        $body = str_replace($searchStringOutput, $addString . $searchStringOutput, $body);
                    } else {
                        $body = str_replace($searchStringOutput, $addString, $body);
                    }
                }
            }

            // Encode fields - since 2.5-8 in all forms where ECC+ is loaded
            if ($this->params->get('encode') && empty($this->debugPlugin)) {
                $this->encodeFields($body, $matchExtension);
            }

            // Set body content after all modifications have been applied
            $this->app->setBody($body);

            // Get IP address
            $this->setSession('ip', getenv('REMOTE_ADDR'));

            // Set session variable for error output - Phoca Guestbook / Easybook Reloaded
            if ($option == 'com_phocaguestbook') {
                $this->setSession('phocaguestbook', 0);
            } elseif ($option == 'com_easybookreloaded') {
                $this->setSession('easybookreloaded', 0);
            }

            // Set redirect url
            $this->setSession('redirect_url', JUri::getInstance()->toString());
            $this->setSession('ecc_loaded', true);

            // Time Lock
            if ($this->params->get('type_time')) {
                $this->setSession('time', time());
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

        if (preg_match("@(<form[^>]*>)(.*)({easycalccheckplus})(.*</form>)@Us", $body, $matches)) {
            // Workaround to get the correct form if several form attributes are provided on the loaded page
            if (strripos($matches[2], '<form') !== false) {
                $matches[0] = substr($matches[2], strripos($matches[2], '<form')) . $matches[3] . $matches[4];

                // Set a new matches array with the correct form
                preg_match("@(<form[^>]*>)(.*)({easycalccheckplus})(.*)(</form>)@Us", $matches[0], $matches);
            }

            if (!empty($matches)) {
                // Custom call string was found, set needed class attribute
                $this->customCall = true;

                // Clean the cache of the component first
                $this->cleanCache();

                // The request does not have to be validated, so get all information for the output of the checks
                $customCallForm = $matches[0];
                $customCallFormContent = $matches[2] . $matches[4];

                // Do some general checks to get needed information from the form of the unknown extension
                // Hidden field - check whether labels are used if not take the input tags
                $customCallHiddenRegex = '<input.+>';

                if (strripos($customCallFormContent, '<label') !== false) {
                    $customCallHiddenRegex = '<label.+>';
                }

                // Get task value of the form
                $customCallFormTask = '';

                if (strripos($customCallFormContent, 'name="task"') !== false) {
                    preg_match('@<input.+name="task".+>@U', $customCallFormContent, $matchTask);

                    if (preg_match('@value="(.+)"@', $matchTask[0], $matchValue)) {
                        $customCallFormTask = $matchValue[1];
                    }
                }

                // Set the extension info array for the further execution with the collected information
                // Array -> (name, form, regex for hidden field, regex for output, task, request exception for encode option);
                $this->loadEcc = true;
                $this->extensionInfo = array(
                    $this->request->get('option', '', 'WORD'),
                    preg_quote($customCallForm),
                    $customCallHiddenRegex,
                    '{easycalccheckplus}',
                    $customCallFormTask
                );

                // Set the needed CSS instructions - since we are already in the trigger onAfterRender, we have to manipulate the output manually
                $head = array();
                $head[] = '<style type="text/css">#easycalccheckplus {margin: 8px 0 !important; padding: 2px !important;}</style>';

                if ($this->params->get('poweredby')) {
                    $head[] = '<style type="text/css">.protectedby {font-size: x-small !important; text-align: right !important;}</style>';
                }

                if ($this->params->get('type_hidden')) {
                    $this->setSession('hidden_class', $this->random());
                    $head[] = '<style type="text/css">.' . $this->getSession('hidden_class') . ' {display: none !important;}</style>';
                }

                if ($this->params->get('recaptcha')) {
                    $this->getRecaptchaHead($head);
                }

                $head = implode("\n", $head) . "\n";

                // Set body after the modifications have been applied
                $body = str_replace('</head>', $head . '</head>', $body);
                $this->app->setBody($body);

                // Set the custom call session variable - Get all possible request variable of the loaded form
                preg_match_all('@name=["|\'](.*)["|\']@Us', $matches[0], $matches_request_variables);
                $this->setSession('check_custom_call', $matches_request_variables[1]);
            }
        }
    }

    /**
     * Fills the form with the entered data from the user - autofill function
     *
     * @param string $body
     * @param array  $matchExtensionMain
     */
    private function fillForm(&$body, &$matchExtensionMain)
    {
        $autofill = $this->getSession('saved_data');

        if (!empty($autofill)) {
            // Get form of extension
            $patternForm = '@' . $this->extensionInfo[1] . '@isU';
            preg_match($patternForm, $body, $matchExtension);

            $patternInput = '@<input[^>].*/?>@isU';
            preg_match_all($patternInput, $matchExtension[0], $matchesInput);

            foreach ($matchesInput[0] as $inputValue) {
                foreach ($autofill as $key => $autofillValue) {
                    if ($autofillValue != '') {
                        $value = '@name=("|\')' . preg_quote($key) . '("|\')@isU';

                        if (preg_match($value, $inputValue)) {
                            $value = '@value=("|\').*("|\')@isU';

                            if (preg_match($value, $inputValue, $match)) {
                                $patternValue = '/' . preg_quote($match[0], '/') . '/isU';
                                $inputValueReplaced = preg_replace($patternValue, 'value="' . $autofillValue . '"', $inputValue);

                                // Set the value to the body and the extension form for further modifications
                                $body = str_replace($inputValue, $inputValueReplaced, $body);
                                $matchExtensionMain[0] = str_replace($inputValue, $inputValueReplaced, $matchExtensionMain[0]);
                                unset($autofill[$key]);
                                break;
                            }
                        }
                    }
                }
            }

            $patternTextarea = '@<textarea[^>].*>(.*</textarea>)@isU';
            preg_match_all($patternTextarea, $matchExtension[0], $matchesTextarea);

            $count = 0;

            foreach ($matchesTextarea[0] as $textareaValue) {
                foreach ($autofill as $key => $autofillValue) {
                    $value = '@name=("|\')' . preg_quote($key) . '("|\')@';

                    if (preg_match($value, $textareaValue)) {
                        $patternValue = '@' . preg_quote($matchesTextarea[1][$count]) . '@isU';
                        $textareaValueReplaced = preg_replace($patternValue, $autofillValue . '</textarea>', $textareaValue);

                        // Set the value to the body and the extension form for further modifications
                        $body = str_replace($textareaValue, $textareaValueReplaced, $body);
                        $matchExtensionMain[0] = str_replace($textareaValue, $textareaValueReplaced, $matchExtensionMain[0]);
                        unset($autofill[$key]);
                        break;
                    }
                }

                $count++;
            }

            $this->clearSession('saved_data');
        }
    }

    /**
     * Converts numbers into strings
     *
     * @param int $x
     *
     * @return string
     */
    private function convertToString($x)
    {
        // Probability 2/3 for conversion
        $random = mt_rand(1, 3);

        if ($random != 1) {
            if ($x > 20) {
                return $x;
            }

            // Names of the numbers are read from language file
            $names = array(
                JText::_('PLG_ECC_NULL'),
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
                JText::_('PLG_ECC_TWENTY')
            );

            return $names[$x];
        }

        return $x;
    }

    /**
     * Encodes input fields
     *
     * @param $body
     * @param $matchExtension
     *
     * @since 2.5-8
     */
    private function encodeFields(&$body, $matchExtension)
    {
        $patternEncode = '@<[^>]+(name=("|\')([^>]*)("|\'))[^>]*>@isU';
        preg_match_all($patternEncode, $matchExtension[0], $matchesEncode);

        $matchEncodeReplacement = array();

        // Add global exceptions - this fields should not be renamed to avoid execution errors
        $replaceNot = array(
            'option',
            'view',
            'task',
            'func',
            'layout',
            'controller'
        );

        // Add exceptions from extension if provided
        if (!empty($this->extensionInfo[5])) {
            $replaceNot = array_merge($replaceNot, array_map('trim', explode(',', $this->extensionInfo[5])));
        }

        $fieldsEncoded = array();

        foreach ($matchesEncode[3] as $key => $match) {
            if (!in_array($match, $replaceNot)) {
                $random = $this->random();
                $fieldsEncoded[$match] = $random;
                $matchEncodeReplacement[$key] = str_replace($matchesEncode[1][$key], 'name="' . $random . '"', $matchesEncode[0][$key]);
            } else {
                unset($matchesEncode[0][$key]);
            }
        }

        if (!empty($fieldsEncoded)) {
            $this->setSession('fields_encoded', base64_encode(serialize($fieldsEncoded)));
        }

        if (!empty($matchEncodeReplacement)) {
            $body = str_replace($matchesEncode[0], $matchEncodeReplacement, $body);
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
        if ($this->loadEccCheck == true) {
            $option = $this->request->get('option', '', 'WORD');

            if ($this->params->get('contact') && $option == 'com_contact') {
                if (!$this->performChecks()) {
                    // Set error session variable for the message output
                    $this->setSession('error_output', 'check_failed');
                    $this->redirect($this->redirectUrl);
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
        if ($this->loadEccCheck == true) {
            if (!empty($isnew)) {
                $option = $this->request->get('option', '', 'WORD');

                if (($this->params->get('user_reg') && $option == 'com_users') || ($this->params->get('communitybuilder') && $option == 'com_comprofiler')) {
                    if (!$this->performChecks()) {
                        // Set error session variable for the message output
                        $this->setSession('error_output', 'check_failed');
                        $this->redirect($this->redirectUrl);
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
        $failedLoginAttempts = $this->getSession('failed_login_attempts');
        $this->setSession('failed_login_attempts', $failedLoginAttempts + 1);
    }

    /**
     * Successful login, clear sessions variable
     */
    public function onUserLogin()
    {
        $this->clearSession('failed_login_attempts');
    }

    /**
     * Sets a session variable
     *
     * @param string       $name
     * @param string|array $value
     */
    private function setSession($name, $value)
    {
        $this->session->set($name, $value, $this->pluginId);
    }

    /**
     * Gets a session variable
     *
     * @param $name
     * @param $default
     *
     * @return mixed
     */
    private function getSession($name, $default = null)
    {
        return $this->session->get($name, $default, $this->pluginId);
    }

    /**
     * Clears a session variable
     *
     * @param string $name
     */
    private function clearSession($name)
    {
        $this->session->clear($name, $this->pluginId);
    }
}
