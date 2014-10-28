<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Project Model.
 *
 * @package		Joomla.Site
 * @subpakage	ExtStore.AdvPortfolioPro
 */
class BooksModelBook extends JModelItem {

	/**
	 * @var		string	Model context string.
	 */
	protected $_context = 'com_books.book';

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load state from the request.
		$pk = $app->input->getInt('id');
		$this->setState('book.id', $pk);

		$offset = $app->input->getUInt('limitstart');
		$this->setState('list.offset', $offset);

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		// TODO: Tune these values based on other permissions.
		$this->setState('filter.state', 1);
		$this->setState('filter.archived', 2);
		$this->setState('filter.access', !$params->get('show_noauth'));

		$this->setState('filter.language', JLanguageMultilang::isEnabled());
	}


	/**
	 * Method to get an object.
	 *
	 * @param	integer	The id of the object to get.
	 * @return	mixed	Object on success, false on failure.
	 */
	public function &getItem($id = null) {
		$pk	= (!empty($pk)) ? $pk : (int) $this->getState('book.id');

		if ($this->_item === null) {
			$this->_item = array();
		}

		if (!isset($this->_item[$pk])) {
			try {
				$db		= $this->getDbo();
				$query	= $db->getQuery(true);

				$query->select(
					$this->getState('item.select', 'a.*')
				);
				$query->from('#__books AS a');
				$query->where('a.id = ' . (int) $pk);

				// Join over the Categories.
				$query->select('c.title AS category_title, c.alias AS category_alias, c.access AS category_access');
				$query->join('LEFT', '#__categories AS c ON c.id = a.catid');

							// Filter by published state.
				$published	= $this->getState('filter.state');

				if (is_numeric($published)) {
					$query->where('(a.state = ' . (int) $published . ' OR a.state = ' . (int) $archived . ')');
				}

				$db->setQuery($query);
				$data	= $db->loadObject();

								// Convert parameter fields to objects
				$registry	= new JRegistry();
				$params		= clone $this->getState('params');
				$registry->loadString($data->params);
				$params->merge($registry);
				$data->params	= $params;

				$registry	= new JRegistry();
				$registry->loadString($data->metadata);
				$data->metadata	= $registry;




				$this->_item[$pk] = $data;

			} catch(Exception $e) {
				if ($e->getCode() == 404) {
					// Need to go thru the error handler to allow Redirect to work.
					JError::raiseError(404, $e->getMessage());
				} else {
					$this->setError($e);
					$this->_item[$pk]	= false;
				}
			}
		}

		return $this->_item[$pk];
	}
}