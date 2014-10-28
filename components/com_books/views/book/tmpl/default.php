<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

JHtml::_('stylesheet', 'com_books/style.css', array(), true);


?>

<div class="item-page">
	<h2>Details</h2>
		<div class="book-details">
		<div class="thumb">
			<img src="<?php echo JURI::base() . '/' . $this->item->thumbnail; ?>">

		</div>
		<h3><?php echo $this->item->title; ?></h3>
		<p><?php echo $this->item->author; ?></p>
		<p><?php echo $this->item->short_description; ?></p>
	</div>
</div>