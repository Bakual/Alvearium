<?php
/**
 * @version		$Id: view.html.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit a hive.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_alvearium
 * @since		1.5
 */
class AlveariumViewHive extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$this->form	= $this->get('Form');
		$this->item	= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
//		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		$checkedOut	= 0;
		$canDo		= AlveariumHelper::getActions();

		JToolBarHelper::title($isNew ? JText::_('COM_ALVEARIUM_MANAGER_HIVE_NEW') : JText::_('COM_ALVEARIUM_MANAGER_HIVE_EDIT'), 'hives');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit')||$canDo->get('core.create'))) {
			JToolBarHelper::apply('hive.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('hive.save', 'JTOOLBAR_SAVE');
		}
		if (!$checkedOut && $canDo->get('core.create')) {

			JToolBarHelper::custom('hive.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}
		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create')) {
			JToolBarHelper::custom('hive.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('hive.cancel');
		} else {
			JToolBarHelper::cancel('hive.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
	}
}
