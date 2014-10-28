<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * HTML Project View class for the PortfolioPro component.
 *
 * @package		Joomla.Site
 * @subpakage	ExtStore.AdvPortfolioPro
 */
class BooksViewBook extends JViewLegacy {
	protected $item;
	protected $params;
	protected $state;

	public function display($tpl = null) {
		$app			= JFactory::getApplication();
		$user			= JFactory::getUser();
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseWarning(500, implode("\n", $errors));

			return false;
		}

		// Create a shortcut for $item.
		$item = &$this->item;


		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */

}