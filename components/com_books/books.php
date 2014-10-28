<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

// Include dependancies
//require_once __DIR__ . '/helpers/books.php';
//require_once __DIR__ . '/helpers/route.php';

$controller	= JControllerLegacy::getInstance('Books');
$controller->execute(JFactory::getApplication()->input->getCmd('task'));
$controller->redirect();