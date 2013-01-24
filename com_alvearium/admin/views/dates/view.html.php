<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class AlveariumViewDates extends JView
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

		$this->addToolbar();

		parent::display($tpl);
	}

	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/alvearium.php';

		$state	= $this->get('State');
		$canDo	= AlveariumHelper::getActions();
		$user	= JFactory::getUser();
		
		JToolBarHelper::title(JText::_('COM_ALVEARIUM_MANAGER_DATES'), 'dates');

		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('date.add','JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('date.edit','JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.edit.state')) {

			JToolBarHelper::divider();
			JToolBarHelper::custom('dates.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('dates.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);


			JToolBarHelper::divider();
			JToolBarHelper::archiveList('dates.archive','JTOOLBAR_ARCHIVE');
			JToolBarHelper::custom('dates.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}
		if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'dates.delete','JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		} else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('dates.trash','JTOOLBAR_TRASH');
			JToolBarHelper::divider();
		}
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_alvearium');
			JToolBarHelper::divider();
		}

		JToolBarHelper::help('JHELP_COMPONENTS_ALVEARIUM_LINKS');
	}
}