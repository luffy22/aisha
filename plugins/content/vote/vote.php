<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.vote
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Vote plugin.
 *
 * @since  1.5
 */
class PlgContentVote extends JPlugin
{
	/**
	 * Displays the voting area if in an article
	 *
	 * @param   string   $context  The context of the content being passed to the plugin
	 * @param   object   &$row     The article object
	 * @param   object   &$params  The article params
	 * @param   integer  $page     The 'page' number
	 *
	 * @return  mixed  html string containing code for the votes if in com_content else boolean false
	 *
	 * @since   1.6
	 */
	public function onContentBeforeDisplay($context, &$row, &$params, $page=0)
	{
		$parts = explode(".", $context);

		if ($parts[0] != 'com_content')
		{
			return false;
		}

		$html = '';

		if (!empty($params) && $params->get('show_vote', null))
		{
			// Load plugin language files only when needed (ex: they are not needed if show_vote is not active).
			$this->loadLanguage();

			$rating = (int) @$row->rating;

			$view = JFactory::getApplication()->input->getString('view', '');
			$img = '';

			// Look for images in template if available
			$starImageOn  = JHtml::_('image', 'system/rating_star.png', JText::_('PLG_VOTE_STAR_ACTIVE'), null, true);
			$starImageOff = JHtml::_('image', 'system/rating_star_blank.png', JText::_('PLG_VOTE_STAR_INACTIVE'), null, true);

			for ($i = 0; $i < $rating; $i++)
			{
				$img .= $starImageOn;
			}

			for ($i = $rating; $i < 5; $i++)
			{
				$img .= $starImageOff;
			}

			$html .= '<div class="content_rating" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">';
			$html .= '<p class="unseen element-invisible">'
					. JText::sprintf('PLG_VOTE_USER_RATING', '<span itemprop="ratingValue">' . $rating . '</span>', '<span itemprop="bestRating">5</span>')
					. '<meta itemprop="ratingCount" content="' . (int) $row->rating_count . '" />'
					. '<meta itemprop="worstRating" content="0" />'
					. '</p>';
			$html .= $img;
			$html .= '</div>';

			if ($view == 'article' && $row->state == 1)
			{
				$uri = clone JUri::getInstance();
				$uri->setVar('hitcount', '0');

				// Create option list for voting select box
				$options = array();

				for ($i = 1; $i < 6; $i++)
				{
					$options[] = JHtml::_('select.option', $i, $i.JTEXT::sprintf(" star"));
				}

				// Generate voting form
				$html .= '<form method="post" action="' . htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8') . '" class="form-inline">';
				$html .= '<span class="content_vote">';
				$html .= '<label class="unseen element-invisible" for="content_vote_' . $row->id . '">' . JText::_('Rate:') . '</label>&nbsp;';
				$html .= JHtml::_('select.genericlist', $options, 'user_rating', null, 'value', 'text', '5', 'content_vote_' . $row->id);
				$html .= '&#160;<input class="btn btn-sm btn-outline-primary" type="submit" name="submit_vote" value="' . JText::_('PLG_VOTE_RATE') . '" />';
				$html .= '<input type="hidden" name="task" value="article.vote" />';
				$html .= '<input type="hidden" name="hitcount" value="0" />';
				$html .= '<input type="hidden" name="url" value="' . htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8') . '" />';
				$html .= JHtml::_('form.token');
				$html .= '</span>';
				$html .= '</form>';
				$html .= '<br/><div class ="container">';
				$html .= '<a href="https://www.facebook.com/AstroIsha" target="_blank" title="Official Facebook Page"><i class="fa fa-3x fa-facebook-official"></i></a> ';
				$html .= '<a href="https://www.instagram.com/astroisha/" target="_blank" rel="noopener noreferrer" title="Official Instagram Page"><i class="fa fa-3x fa-instagram"></i></a> ';
				$html .= '<a href="https://plus.google.com/+JyotishividyaCoInplus" target="_blank" title="Official Google Plus Page"><i class="fa fa-3x fa-google-plus-official"></i></a> ';
				$html .= '<a href="https://twitter.com/astroishaweb" target="_blank" title="Offical Twitter Page"><i class="fa fa-3x fa-twitter"></i></a> ';
				$html .= '<div class="fb-like" data-layout="box_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>&nbsp;&nbsp;';
				$html .= '<div class="g-plusone" data-size="tall"></div> ';
				$html .= '</div><div class="mb-1"></div>';
			}
		}

		return $html;
	}
}
