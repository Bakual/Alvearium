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
		if (task == 'bloom.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			<?php echo $this->form->getField('notes')->save(); ?>
			Joomla.submitform(task, document.getElementById('item-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_alvearium&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="width-60 fltlft">
		<?php echo JHtml::_('tabs.start','bloom-tabs-'.$this->item->id, array('useCookie'=>1)); ?>
		<?php echo JHtml::_('tabs.panel',JText::_('COM_ALVEARIUM_PLANT'), 'bloom-panel'); ?>
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_ALVEARIUM_NEW_PLANT') : JText::sprintf('COM_ALVEARIUM_EDIT_PLANT', $this->item->id); ?></legend>
			<ul class="adminformlist">
			<li><?php echo $this->form->getLabel('plant_id'); ?>
			<?php echo $this->form->getInput('plant_id'); ?></li>
			</ul>
		</fieldset>
		<?php echo JHtml::_('tabs.panel',JText::_('COM_ALVEARIUM_DATE'), 'date-panel'); ?>
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_ALVEARIUM_NEW_DATE') : JText::sprintf('COM_ALVEARIUM_EDIT_DATE', $this->item->id); ?></legend>
			<ul class="adminformlist">
			<li><?php echo $this->form->getLabel('date_id'); ?>
			<?php echo $this->form->getInput('date_id'); ?></li>
			</ul>
		</fieldset>
		<?php echo JHtml::_('tabs.end'); ?>
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_ALVEARIUM_FIELD_NOTES_LABEL'); ?></legend>
			<div class="clr"></div>
			<?php echo $this->form->getInput('notes'); ?>
		</fieldset>
	</div>

	<div class="width-40 fltrt">
		<fieldset class="adminform" style="border: 1px dashed silver; padding: 5px; margin: 18px 0px 10px;">
			<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('info') as $field): ?>
				<li>
					<?php if (!$field->hidden): ?>
						<?php echo $field->label; ?>
					<?php endif; ?>
					<?php echo $field->input; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		</fieldset>
		<?php echo JHtml::_('sliders.start','bloom-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
		<?php echo JHtml::_('sliders.panel',JText::_('COM_ALVEARIUM_DETAIL'), 'detail-panel'); ?>
		<fieldset class="panelform">
			<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('detail') as $field): ?>
				<li>
					<?php if (!$field->hidden): ?>
						<?php echo $field->label; ?>
					<?php endif; ?>
					<?php echo $field->input; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		</fieldset>
		<?php echo JHtml::_('sliders.end'); ?>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	<div class="clr"></div>
</form>