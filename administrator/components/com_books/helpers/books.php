<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_weblinks
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Weblinks helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_weblinks
 * @since       1.6
 */
class BooksHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName = 'books')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_BOOKS_SUBMENU_BOOKS'),
			'index.php?option=com_books&view=books',
			$vName == 'books'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_BOOKS_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_books',
			$vName == 'categories'
		);
	}
}
