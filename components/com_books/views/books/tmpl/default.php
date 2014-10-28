<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

// Include CSS and JS
JHtml::_('stylesheet', 'com_books/style.css', false, true, false, false, true);

?>
<div class="book-list">
	<h1>List Books</h1>
	<ul class="list">
		<?php foreach ($this->items as $item) :
			$link = 'index.php?option=com_books&view=book&id=' . $item->id;
		?>
			<li class="item">
				<a href="<?php echo $link; ?>">
					<img src="<?php echo JURI::base() . '/' . $item->thumbnail; ?>">
				</a>
				<p><a href="<?php echo $link; ?>"><?php echo $item->title; ?></a></p>
				<p><?php echo $item->price; ?>.$</p>
			</li>

		<?php endforeach; ?>
	</ul>
</div>


</div>