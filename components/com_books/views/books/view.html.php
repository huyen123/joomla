<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * View class for a list of projects.
 *
 * @package		Joomla.Site
 * @subpakage	ExtStore.AdvPortfolioPro
 */
class BooksViewBooks extends JViewLegacy {
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view.
	 */
	public function display($tpl = null) {
		$app	= JFactory::getApplication();

		// Get some data from the models
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->params		= $this->state->params;

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		parent::display($tpl);
	}

}