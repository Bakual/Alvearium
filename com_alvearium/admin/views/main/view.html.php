<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class AlveariumViewMain extends JViewLegacy
{
	function display( $tpl = null )
	{
		/* Save Check
		$params	= &JComponentHelper::getParams('com_alvearium');
		if ($params->get('alt_player') == ''){
			JError::raiseWarning(100, JText::_('COM_ALVEARIUM_NOTSAVED'));
			$app = JFactory::getApplication();
			$app->enqueueMessage(JText::_('COM_ALVEARIUM_RELOAD'));
		}
		*/

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		$canDo 	= AlveariumHelper::getActions();

		JToolBarHelper::title(JText::_('COM_ALVEARIUM'), 'main');

		if ($canDo->get('core.admin')) {
			JToolbarHelper::divider();
			JToolBarHelper::preferences('com_alvearium', 600, 800);
		}
	}
}
