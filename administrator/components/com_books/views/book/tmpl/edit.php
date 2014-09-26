<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'book.cancel' || document.formvalidator.isValid(document.id('book-form'))) {
			<?php echo $this->form->getField('description')->save(); ?>
			Joomla.submitform(task, document.getElementById('book-form'));
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_books&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="book-form" class="form-validate">
	<div class="row-fluid">
		<fieldset>
			<div class="span10 form-horizontal">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#details" data-toggle="tab">
							<?php echo empty($this->item->id) ? JText::_('COM_BOOKS_BOOK_NEW') : JText::sprintf('COM_BOOKS_BOOK_EDIT', $this->item->id); ?>
						</a>
					</li>

					<li>
						<a href="#publishing" data-toggle="tab">
							<?php echo JText::_('JGLOBAL_FIELDSET_PUBLISHING');?>
						</a>
					</li>

					<?php
					$fieldSets	= $this->form->getFieldsets('params');
					foreach ($fieldSets as $name => $fieldSet) :
					?>
					<li>
						<a href="#params-<?php echo $name; ?>" data-toggle="tab">
							<?php echo JText::_($fieldSet->label); ?>
						</a>
					</li>
					<?php endforeach; ?>

					<?php
					$fieldSets	= $this->form->getFieldsets('metadata');
					foreach ($fieldSets as $name => $fieldSet) :
					?>
					<li>
						<a href="#metadata-<?php echo $name; ?>" data-toggle="tab">
							<?php echo JText::_($fieldSet->label); ?>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="details">
						<div class="row-fluid">
							<div class="span6">
								<div class="control-group">
									<?php echo $this->form->getLabel('title'); ?>
									<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
								</div>

								<div class="control-group">
									<?php echo $this->form->getLabel('cat_id'); ?>
									<div class="controls"><?php echo @$this->form->getInput('cat_id'); ?></div>
								</div>

							</div>
							<div class="span6">
								<div class="control-group">
									<?php echo $this->form->getLabel('price'); ?>
									<div class="controls">
										<div class="input-append">
											<?php echo $this->form->getInput('price'); ?>
										</div>
									</div>
								</div>

								<div class="control-group">
									<?php echo $this->form->getLabel('author'); ?>
									<div class="controls">
										<div class="input-append">
											<?php echo $this->form->getInput('author'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="control-group">
							<?php echo $this->form->getLabel('thumbnail'); ?>
							<div class="controls"><?php echo $this->form->getInput('thumbnail'); ?></div>
						</div>
						<div class="control-group">
							<?php echo $this->form->getLabel('short_description'); ?>
							<div class="controls"><?php echo $this->form->getInput('short_description'); ?></div>
						</div>
						<div class="control-group">
							<?php echo $this->form->getLabel('description'); ?>
							<div class="controls"><?php echo $this->form->getInput('description'); ?></div>
						</div>
					</div>

					<div class="tab-pane" id="publishing">
						<div class="control-group">
							<?php echo $this->form->getLabel('alias'); ?>
							<div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
						</div>
						<div class="control-group">
							<?php echo $this->form->getLabel('id'); ?>
							<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
						</div>
						<div class="control-group">
							<?php echo $this->form->getLabel('created_by'); ?>
							<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
						</div>
						<div class="control-group">
							<?php echo $this->form->getLabel('created_by_alias'); ?>
							<div class="controls"><?php echo $this->form->getInput('created_by_alias'); ?></div>
						</div>
						<div class="control-group">
							<?php echo $this->form->getLabel('created'); ?>
							<div class="controls"><?php echo $this->form->getInput('created'); ?></div>
						</div>
						<div class="control-group">
							<?php echo $this->form->getLabel('modified_by'); ?>
							<div class="controls"><?php echo $this->form->getInput('modified_by'); ?></div>
						</div>
						<div class="control-group">
							<?php echo $this->form->getLabel('modified'); ?>
							<div class="controls"><?php echo $this->form->getInput('modified'); ?></div>
						</div>
						<div class="control-group">
							<?php echo $this->form->getLabel('hits'); ?>
							<div class="controls"><?php echo $this->form->getInput('hits'); ?></div>
						</div>
						
					</div>

					<?php echo $this->loadTemplate('params'); ?>

					<?php echo $this->loadTemplate('metadata'); ?>

					<input type="hidden" name="task" value="" />
					<input type="hidden" name="return" value="<?php echo JFactory::getApplication()->input->getCmd('return');?>" />
					<?php echo JHtml::_('form.token'); ?>
				</div>
			</div>

			<div class="span2">
				<h4><?php echo JText::_('JDETAILS'); ?></h4>
				<hr />
				<fieldset class="form-vertical">
					<div class="control-group">
						<div class="controls"><?php echo $this->form->getValue('title'); ?></div>
					</div>
					<div class="control-group">
						<?php echo $this->form->getLabel('featured'); ?>
						<div class="controls"><?php echo $this->form->getInput('featured'); ?></div>
					</div>
					<div class="control-group">
						<?php echo $this->form->getLabel('state'); ?>
						<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
					</div>
					<div class="control-group">
						<?php echo $this->form->getLabel('access'); ?>
						<div class="controls"><?php echo $this->form->getInput('access'); ?></div>
					</div>
					<div class="control-group">
						<?php echo $this->form->getLabel('language'); ?>
						<div class="controls"><?php echo $this->form->getInput('language'); ?></div>
					</div>
				</fieldset>
			</div>
		</fieldset>
	</div>
</form>

<?php
