<?php

// No direct access
defined('_JEXEC') or die;

class AlveariumHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 * @since	1.6
	 */
	public static function addSubmenu($vName = 'main')
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_ALVEARIUM_HIVES'),
			'index.php?option=com_alvearium&view=hives',
			$vName == 'hives'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_ALVEARIUM_PLANTS'),
			'index.php?option=com_alvearium&view=plants',
			$vName == 'plants'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_ALVEARIUM_BLOOMS'),
			'index.php?option=com_alvearium&view=blooms',
			$vName == 'blooms'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_ALVEARIUM_DATES'),
			'index.php?option=com_alvearium&view=dates',
			$vName == 'dates'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_ALVEARIUM_LOCATIONS'),
			'index.php?option=com_alvearium&view=locations',
			$vName == 'locations'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_ALVEARIUM_CATEGORY'),
			'index.php?option=com_categories&extension=com_alvearium',
			$vName == 'categories'
		);
		if ($vName=='categories') {
			JToolBarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE',JText::_('com_alvearium')),
				'alvearium-categories');
		}
	}

	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_alvearium';
		} else {
			$assetName = 'com_alvearium.category.'.(int) $categoryId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}