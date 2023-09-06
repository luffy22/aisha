<?php
/**
 * @package        Direct Alias
 * @copyright      Copyright (C) 2009-2023 AlterBrains.com. All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace AlterBrains\Plugin\System\Directalias\Field;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\TextField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

/**
 * @since        1.0
 * @noinspection PhpUnused
 */
class DirectaliasField extends TextField
{
	/**
	 * @var string
	 * @since 1.0
	 */
	public $type = 'Directalias';

	/**
	 * @inheritdoc
	 * @since 1.0
	 */
	protected function getInput()
	{
		$html = [];

		$direct = $this->form->getValue('direct_alias', 'params', false);
		$absent = $this->form->getValue('absent_alias', 'params', false);

		HTMLHelper::_('bootstrap.popover', '.hasPopover', ['trigger' => 'hover']);

        /** @noinspection PhpUnhandledExceptionInspection */
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        Factory::getApplication()->getDocument()->addScriptDeclaration('
            function toggleDirectAlias(button) {
                var input = document.getElementById("jform_params_direct_alias");
                input.value = 1 - input.value;
                button.innerHTML = (input.value > 0) ? "' . Text::_('PLG_SYSTEM_DIRECT_ALIAS_DIRECT') . '" : "' . Text::_('PLG_SYSTEM_DIRECT_ALIAS_RELATIVE') . '";
                jQuery(button).toggleClass("btn-success", input.value > 0);
                jQuery(button).toggleClass("btn-outline-secondary", input.value < 1);
            }
            function toggleAbsentAlias(button) {
                var input = document.getElementById("jform_params_absent_alias");
                input.value = 1 - input.value;
                button.innerHTML = (input.value > 0) ? "' . Text::_('PLG_SYSTEM_DIRECT_ALIAS_ABSENT') . '" : "' . Text::_('PLG_SYSTEM_DIRECT_ALIAS_PRESENT') . '";
                jQuery(button).toggleClass("btn-success", input.value > 0);
                jQuery(button).toggleClass("btn-outline-secondary", input.value < 1);
            }
        ');

        $html[] = '<div class="input-group">';
        $html[] = parent::getInput();
        $html[] = '<button type="button" onclick="toggleDirectAlias(this)" class="btn ' . ($direct ? 'btn-success' : 'btn-outline-secondary') . ' hasPopover" title="<b>' . Text::_('PLG_SYSTEM_DIRECT_ALIAS_DIRECT_TIP_TITLE') . '" data-bs-content="' . Text::_('PLG_SYSTEM_DIRECT_ALIAS_DIRECT_TIP_DESC') . '" style="cursor:pointer" data-bs-placement="bottom">' . Text::_($direct ? 'PLG_SYSTEM_DIRECT_ALIAS_DIRECT' : 'PLG_SYSTEM_DIRECT_ALIAS_RELATIVE') . '</button>';
        $html[] = '<button type="button" onclick="toggleAbsentAlias(this)" class="btn ' . ($absent ? 'btn-success' : 'btn-outline-secondary') . ' hasPopover" title="<b>' . Text::_('PLG_SYSTEM_DIRECT_ALIAS_ABSENT_TIP_TITLE') . '" data-bs-content="' . Text::_('PLG_SYSTEM_DIRECT_ALIAS_ABSENT_TIP_DESC') . '" style="cursor:pointer" data-bs-placement="bottom">' . Text::_($absent ? 'PLG_SYSTEM_DIRECT_ALIAS_ABSENT' : 'PLG_SYSTEM_DIRECT_ALIAS_PRESENT') . '</button>';
        $html[] = '</div>';

		return \implode("\n", $html);
	}
}
