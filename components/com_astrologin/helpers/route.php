<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * AstroLogin Component Route Helper.
 *
 * @since  1.5
 */
abstract class AstroLoginHelperRoute
{
	protected static $lookup = array();

	/**
	 * Get the user route.
	 *
	 * @param   integer  $user        The user of the profile.
	 *
	 * @return  string  The article route.
	 *
	 * @since   1.5
	 */
	public static function getUserRoute($user)
	{
          print_r($user);exit;
            // Create the link
            $link = 'index.php?&view=astrosearch&user=' . $user;
            return $link;
	}
}	
