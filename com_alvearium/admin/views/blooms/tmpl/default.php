<?php
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('script','system/multiselect.js', false, true);

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$canOrder	= $user->authorise('core.edit.state', 'com_alvearium.category');
$saveOrder	= $listOrder == 'a.ordering';
?>

<form action="<?php echo JRoute::_('index.php?option=com_alvearium&view=blooms'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_ALVEARIUM_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">


			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>

			<select name="filter_category_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('category.options', 'com_alvearium'), 'value', 'text', $this->state->get('filter.category_id'));?>
			</select>
		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort',  'JGLOBAL_TITLE', 'p.title', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'COM_ALVEARIUM_START', 'a.start_date', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'COM_ALVEARIUM_STOP', 'a.stop_date', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort',  'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
				</th>
				<th width="20%">
					<?php echo JHtml::_('grid.sort',  'JCATEGORY', 'category_title', $listDirn, $listOrder); ?>
				</th>
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :
			$ordering	= ($listOrder == 'a.ordering');
			$item->cat_link	= JRoute::_('index.php?option=com_categories&extension=com_alvearium&task=edit&type=other&cid[]='. $item->catid);
			$canCreate	= $user->authorise('core.create',		'com_alvearium.category.'.$item->catid);
			$canEdit	= $user->authorise('core.edit',			'com_alvearium.category.'.$item->catid);
			$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out==$user->get('id') || $item->checked_out==0;
			$canChange	= $user->authorise('core.edit.state',	'com_alvearium.category.'.$item->catid) && $canCheckin;
			$title	= ($item->type == 2) ? 'date_title' : 'plant_title';
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				<td>
					<?php if ($canEdit) : ?>
						<a href="<?php echo JRoute::_('index.php?option=com_alvearium&task=bloom.edit&id='.(int) $item->id); ?>">
							<?php echo $this->escape($item->$title); ?></a>
					<?php else : ?>
							<?php echo $this->escape($item->$title); ?>
					<?php endif; ?>
				</td>
				<td class="center">
					<?php echo JHTML::Date($item->start_date, JText::_('DATE_FORMAT_LC4')); ?>
				</td>
				<td class="center">
					<?php if ($item->stop_date){echo JHTML::Date($item->stop_date, JText::_('DATE_FORMAT_LC4'));} ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->state, $i, 'blooms.', $canChange); ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->category_title); ?>
				</td>
				<td class="center">
					<?php echo (int) $item->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
