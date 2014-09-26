<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Product Model.
 *
 * @package		Joomla.Administrator
 * @subpakage	Skyline.MediaStore
 */
class BooksModelBook extends JModelAdmin {
	/** @var string		The prefix to use with controller messages. */
	protected $text_prefix	= 'COM_BOOKS_BOOKS';

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 * @return	bool	True if allowed to delete the record. Defaults to the permission set in the component.
	 */
	protected function canDelete($record) {
		if (!empty($record->id)) {
			return parent::canDelete($record);
		}
	}
	
	/**
	 * Returns a reference to a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @pararm	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 */
	public function getTable($type = 'Book', $prefix = 'BooksTable', $config = array()) {
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm				A JForm object on success, false on failure.
	 */
	public function getForm($data = array(), $loadData = true) {
		// Initialize variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form	= $this->loadForm('com_books.book', 'book', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		// Determine correct permissions to check.
		if ($this->getState('book.id')) {
			// Existing record. Can only edit in selected Categories.
			$form->setFieldAttribute('catid', 'action', 'core.edit');
		} else {
			// New record. Can only create in selected Categories.
			$form->setFieldAttribute('catid', 'action', 'core.create');
		}
		// Modify the form based on access controls.
		if (!$this->canEditState((object) $data)) {
			// Disable fields for display.
			$form->setFieldAttribute('state', 'disabled', 'true');

			// Disable field while saving.
			// The controller has already verified this is a record you can edit.
			$form->setFieldAttribute('state', 'filter', 'unset');
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return mixed	The data for the form.
	 */
	protected function loadFormData() {
		$app = JFactory::getApplication();

		// Check the session for previously entered form data.
		$data	= JFactory::getApplication()->getUserState('com_books.edit.book.data', array());

		if (empty($data)) {
			$data	= $this->getItem();

			// Prime some default values.
			if ($this->getState('book.id') == 0) {
				$app	= JFactory::getApplication();
				$data->set('cat_id', $app->input->getInt('cat_id', $app->getUserState('com_books.books.filter.category_id')));
			}
		}

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	int		The id of the primary key.
	 * @return	mixed	Object on success, false, on failure.
	 */
	public function getItem($pk = null) {
		if ($item	= parent::getItem($pk)) {
			// Convert the params field to an array.
			$registry		= new JRegistry();
			$registry->loadString($item->metadata);
			$item->metadata	= $registry->toArray();


		}

		return $item;
	}

	/**
	 * Prepare and sanitize the table prior to saving.
	 */
	protected function prepareTable(&$table) {
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();

		$table->title		= htmlspecialchars_decode($table->title, ENT_QUOTES);
		$table->alias		= JApplication::stringURLSafe($table->alias);

		if (empty($table->alias)) {
			$table->alias	= JApplication::stringURLSafe($table->title);
		}
	}


/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param   JTable  $table  A JTable object.
	 *
	 * @return  array  An array of conditions to add to ordering queries.
	 *
	 * @since   1.6
	 */
	protected function getReorderConditions($table)
	{
		$condition = array();
		$condition[] = 'catid = ' . (int) $table->catid;

		return $condition;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since	3.1
	 */
	public function save($data)
	{
		$app = JFactory::getApplication();

		// Alter the title for save as copy
		if ($app->input->get('task') == 'save2copy')
		{
			list($name, $alias) = $this->generateNewTitle($data['catid'], $data['alias'], $data['title']);
			$data['title']	= $name;
			$data['alias']	= $alias;
			$data['state']	= 0;
		}

		return parent::save($data);
	}

	/**
	 * Method to change the title & alias.
	 *
	 * @param   integer  $category_id  The id of the parent.
	 * @param   string   $alias        The alias.
	 * @param   string   $name         The title.
	 *
	 * @return  array  Contains the modified title and alias.
	 *
	 * @since   3.1
	 */
	protected function generateNewTitle($category_id, $alias, $name)
	{
		// Alter the title & alias
		$table = $this->getTable();

		while ($table->load(array('alias' => $alias, 'catid' => $category_id)))
		{
			if ($name == $table->title)
			{
				$name = JString::increment($name);
			}

			$alias = JString::increment($alias, 'dash');
		}

		return array($name, $alias);
	}

}