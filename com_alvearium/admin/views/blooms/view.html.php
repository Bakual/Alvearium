<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class AlveariumViewBlooms extends JViewLegacy
{
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->authors		= $this->get('Authors');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal') {
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
		}

		parent::display($tpl);
	}

	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/alvearium.php';

		$state	= $this->get('State');
		$canDo	= AlveariumHelper::getActions($state->get('filter.category_id'));
		$user	= JFactory::getUser();

		JToolBarHelper::title(JText::_('COM_ALVEARIUM_MANAGER_BLOOMS'), 'blooms');

		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('bloom.add','JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('bloom.edit','JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.edit.state')) {

			JToolBarHelper::divider();
			JToolBarHelper::custom('blooms.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('blooms.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);


			JToolBarHelper::divider();
			JToolBarHelper::archiveList('blooms.archive','JTOOLBAR_ARCHIVE');
			JToolBarHelper::custom('blooms.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}
		if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'blooms.delete','JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		} else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('blooms.trash','JTOOLBAR_TRASH');
			JToolBarHelper::divider();
		}
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_alvearium');
			JToolBarHelper::divider();
		}

		JToolBarHelper::help('JHELP_COMPONENTS_ALVEARIUM_LINKS');
	}
}
