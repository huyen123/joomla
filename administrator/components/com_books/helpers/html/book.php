<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

class JHtmlBook {
	protected static $bookItems			= array();
	protected static $orderItems			= array();
	protected static $orderStatusItems		= null;





	/**
	 * Returns an array of Products.
	 *
	 * @param   array   $config	 An array of configuration options. By default, only
	 *							  published and unpublished Products are returned.
	 *
	 * @return  array
	 */
	public static function ProductOptions($config = array('filter.state' => array(0, 1))) {
		$hash = md5(serialize($config));

		if (!isset(self::$bookItems[$hash])) {
			$config	= (array) $config;
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);

			$query->select('a.id, a.title');
			$query->from('#__books AS a');

			// Filter on the published state
			if (isset($config['filter.state'])) {
				if (is_numeric($config['filter.state'])) {
					$query->where('a.state = ' . (int) $config['filter.state']);
				} else if (is_array($config['filter.state'])) {
					JArrayHelper::toInteger($config['filter.state']);
					$query->where('a.state IN (' . implode(',', $config['filter.state']) . ')');
				}
			}

			$query->order('a.title');

			$db->setQuery($query);
			$items = $db->loadObjectList();

			// Assemble the list options.
			self::$bookItems[$hash] = array();

			foreach ($items as &$item) {
				self::$bookItems[$hash][] = JHtml::_('select.option', $item->id, $item->title);
			}
		}

		return self::$bookItems[$hash];
	}





	/**
	 * @param   int $value	The state value
	 * @param   int $i
	 */
	public static function productFeatured($value = 0, $i, $canChange = true) {
		JHtml::_('bootstrap.tooltip');

		// Array of image, task, title, action
		$states	= array(
			0	=> array('star-empty',	'books.featured',	'COM_BOOKS_BOOKS_UNFEATURED',	'COM_BOOKS_BOOKS_TOGGLE_TO_FEATURE'),
			1	=> array('star',		'books.unfeatured',	'COM_BOOKS_BOOKS_FEATURED',		'COM_BOOKS_BOOKS_TOGGLE_TO_UNFEATURE'),
		);

		$state	= JArrayHelper::getValue($states, (int) $value, $states[1]);
		$icon	= $state[0];

		if ($canChange) {
			$html	= '<a href="#" onclick="return listItemTask(\'cb' . $i . '\',\'' . $state[1] . '\')" class="btn btn-micro hasTooltip' . ($value == 1 ? ' active' : '') . '" title="' . JText::_($state[3]) . '"><i class="icon-' . $icon.'"></i></a>';
		} else {
			$html	= '';
		}

		return $html;
	}


}