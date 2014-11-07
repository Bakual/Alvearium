<?php
/**
 * @version		$Id: edit.php 20549 2011-02-04 15:01:51Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_alvearium
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'location.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			Joomla.submitform(task, document.getElementById('adminForm'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_alvearium&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="form-horizontal">
					<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'plant-panel')); ?>
					<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'plant-panel', JText::_('COM_ALVEARIUM_PLANT', true)); ?>
					<fieldset class="adminform">
						<legend><?php echo empty($this->item->id) ? JText::_('COM_ALVEARIUM_NEW_PLANT') : JText::sprintf('COM_ALVEARIUM_EDIT_PLANT', $this->item->id); ?></legend>
						<?php $field = $this->form->getField('plant_id'); ?>
						<?php echo $field->getControlGroup(); ?>
					</fieldset>
					<?php echo JHtml::_('bootstrap.endTab'); ?>
					<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'hive-panel', JText::_('COM_ALVEARIUM_HIVE', true)); ?>
					<fieldset class="adminform">
						<legend><?php echo empty($this->item->id) ? JText::_('COM_ALVEARIUM_NEW_HIVE') : JText::sprintf('COM_ALVEARIUM_EDIT_HIVE', $this->item->id); ?></legend>
						<?php $field = $this->form->getField('hive_id'); ?>
						<?php echo $field->getControlGroup(); ?>
					</fieldset>
					<?php echo JHtml::_('bootstrap.endTab'); ?>
					<?php echo JHtml::_('bootstrap.endTabSet'); ?>

					<div class="row-fluid form-horizontal-desktop">
						<div class="span6">
							<?php foreach($this->form->getFieldset('detail') as $field): ?>
								<?php echo $field->getControlGroup(); ?>
							<?php endforeach; ?>
							<?php echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
						</div>
						<div class="span6">
							<?php echo JLayoutHelper::render('joomla.edit.metadata', $this); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="span3">
				<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
			</div>
		</div>
	</div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="return" value="<?php echo JFactory::getApplication()->input->getCmd('return'); ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
