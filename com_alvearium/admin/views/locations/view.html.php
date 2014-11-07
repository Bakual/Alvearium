<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class AlveariumViewLocations extends JViewLegacy
{
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();

		parent::display($tpl);
	}

	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/alvearium.php';

		$state	= $this->get('State');
		$canDo	= AlveariumHelper::getActions();
		$user	= JFactory::getUser();

		JToolBarHelper::title(JText::_('COM_ALVEARIUM_MANAGER_LOCATIONS'), 'locations');

		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('location.add','JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('location.edit','JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.edit.state')) {

			JToolBarHelper::divider();
			JToolBarHelper::custom('locations.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('locations.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);


			JToolBarHelper::divider();
			JToolBarHelper::archiveList('locations.archive','JTOOLBAR_ARCHIVE');
			JToolBarHelper::custom('locations.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}
		if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'locations.delete','JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		} else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('locations.trash','JTOOLBAR_TRASH');
			JToolBarHelper::divider();
		}
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_alvearium');
			JToolBarHelper::divider();
		}

		JToolBarHelper::help('JHELP_COMPONENTS_ALVEARIUM_LINKS');
	}
}
