<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.vote
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

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

$uri = clone Uri::getInstance();
$uri->setVar('hitcount', '0');
$curr_url   = $uri->getInstance();
// Create option list for voting select box
$options = array();

for ($i = 1; $i < 6; $i++)
{
	$options[] = HTMLHelper::_('select.option', $i, Text::sprintf('PLG_VOTE_VOTE', $i));
}

?>
<form method="post" action="<?php echo htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8'); ?>" class="row g-2 mb-3">
    <div class="col-2 w-auto">
    <?php echo HTMLHelper::_('select.genericlist', $options, 'user_rating', 'class="form-select form-select-sm w-auto"', 'value', 'text', '5', 'content_vote_' . (int) $row->id); ?>
    </div>
    <div class="col-1">
        <input class="btn btn-sm btn-primary" type="submit" name="submit_vote" value="<?php echo Text::_('PLG_VOTE_RATE'); ?>">
        <input type="hidden" name="task" value="article.vote">
        <input type="hidden" name="hitcount" value="0">
        <input type="hidden" name="url" value="<?php echo htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8'); ?>">
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
</form>
<div class="row">
    <div class="w-auto">
    <div class="fb-like" data-href="<?php JUri::getInstance(); ?>" data-width="" data-layout="box_count" data-action="like" data-size="small" data-share="true"></div>
    </div>
    <div class="w-auto">
        <a class="twitter-share-button"
           accesskey=""href="<?php JUri::getInstance(); ?>" data-size="large">
        Tweet</a>
    </div>
    <div class="w-auto">
<?php 
if(isMobileDevice()){
    //Your content or code for mobile devices goes here
?>
<a href="<?php echo "whatsapp://send?text=".JURI::current(); ?>" data-action="share/whatsapp/share"><i class="bi bi-whatsapp fs-1"></i></a>
<?php
}
?>
    </div>
</div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v13.0&appId=1092479767598458&autoLogAppEvents=1" nonce="VybAWjrh"></script>
<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>
<?php 
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
?>