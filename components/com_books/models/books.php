<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Methods supporting a list of Project records.
 *
 * @package		Joomla.Site
 * @subpakage	ExtStore.AdvPortfolioPro
 */
class BooksModelBooks extends JModelList {
	/**
	 * Constructor.
	 *
	 * @param    array    An optional associative array of configuration settings.
	 * @see        JControllerLegacy
	 */
	public function __construct($config = array()) {
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'alias', 'a.alias',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'catid', 'a.catid', 'category_title',
				'state', 'a.state',
				'access', 'a.access', 'access_level',
				'created', 'a.created',
				'created_by', 'a.created_by',
				'ordering', 'a.ordering',
				'language', 'a.language',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState($ordering = null, $direction = null) {
		// Initialize variables.
		$app = JFactory::getApplication('site');

		// Load the parameters. Merge Global and Menu Item params into new object
		$params = $app->getParams();

				// List state information
		$value = $app->input->get('limit', $params->get('limit', $app->getCfg('list_limit', 0)), 'uint');
		$this->setState('list.limit', $value);

		$value = $app->input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $value);

		$this->setState('list.direction', '');

		//
		$this->setState('filter.state', 1);

				// process show_noauth parameter
		if (!$params->get('show_noauth')) {
			$this->setState('filter.access', true);
		} else {
			$this->setState('filter.access', false);
		}

		// Optional filter text
		$this->setState('list.filter', $app->input->getString('filter-search'));

		$this->setState('filter.language', JLanguageMultilang::isEnabled());

		$this->setState('layout', $app->input->get('layout'));
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and different modules
	 * that might need different sets of data or different ordering requirements.
	 *
	 * @param    string $id    A prefix for the store id.
	 * @return    string        A store id.
	 */
	protected function getStoreId($id = '') {
		// compile the store id.
		$id .= ':' . $this->getState('list.filter');
		$id .= ':' . $this->getState('filter.access');
		$id .= ':' . $this->getState('filter.state');
		$id .= ':' . $this->getState('filter.language');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return    JDatabaseQuery
	 */
	protected function getListQuery() {
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.title, a.alias, a.checked_out, a.checked_out_time, a.catid,
				 a.state, a.access, a.ordering, a.price,
				 a.language, a.created,
				 a.short_description, a.thumbnail'
			)
		);

		$query->from('#__books AS a');



		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published)) {
			$query->where('a.state = ' . $published);
		} else if (is_array($published)) {
			JArrayHelper::toInteger($published);
			$published = implode(', ', $published);
			$query->where('a.state IN (' . $published . ')');
		}

		// Add the list ordering clause.
		$query->order($this->getState('list.ordering', 'a.ordering') . ' ' . $this->getState('list.direction', 'ASC'));

		return $query;
	}


}