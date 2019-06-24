<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.vote
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Layout variables
 * -----------------
 * @var   string   $context  The context of the content being passed to the plugin
 * @var   object   &$row     The article object
 * @var   object   &$params  The article params
 * @var   integer  $page     The 'page' number
 * @var   array    $parts    The context segments
 * @var   string   $path     Path to this file
 */

$uri = clone JUri::getInstance();
$uri->setVar('hitcount', '0');

// Create option list for voting select box
$options = array();

for ($i = 1; $i < 6; $i++)
{
	$options[] = JHtml::_('select.option', $i, JText::sprintf('PLG_VOTE_VOTE', $i));
}

?>
<form method="post" action="<?php echo htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8'); ?>" class="form-inline">
	<span class="content_vote">
		<label class="unseen element-invisible" for="content_vote_<?php echo (int) $row->id; ?>"><?php echo JText::_('PLG_VOTE_LABEL'); ?></label>
		<?php echo JHtml::_('select.genericlist', $options, 'user_rating', null, 'value', 'text', '5', 'content_vote_' . (int) $row->id); ?>
		&#160;<input class="btn btn-mini" type="submit" name="submit_vote" value="<?php echo JText::_('PLG_VOTE_RATE'); ?>" />
		<input type="hidden" name="task" value="article.vote" />
		<input type="hidden" name="hitcount" value="0" />
		<input type="hidden" name="url" value="<?php echo htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8'); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</span>
</form>
<div class ="container">
<a href="https://www.facebook.com/AstroIsha" target="_blank" title="Official Facebook Page"><i class="fab fa-3x fa-facebook"></i></a> 
<a href="https://www.instagram.com/astroisha/" target="_blank" rel="noopener noreferrer" title="Official Instagram Page"><i class="fab fa-3x fa-instagram"></i></a> 
<a href="https://twitter.com/astroishaweb" target="_blank" title="Offical Twitter Page"><i class="fab fa-3x fa-twitter"></i></a> 
<?php 
if(isMobileDevice()){
    //Your content or code for mobile devices goes here
?>
<a href="<?php echo "whatsapp://send?text=".JURI::current(); ?>" data-action="share/whatsapp/share"><i class="fab fa-3x fa-whatsapp"></i></a>
<?php
}
?>
<div class="fb-like" data-layout="box_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>&nbsp;&nbsp;
</div><div class="mb-2"></div>
<?php 
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
?>
