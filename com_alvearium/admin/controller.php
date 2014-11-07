<?php
defined('_JEXEC') or die('Restricted access');

class AlveariumController extends JControllerLegacy {
	function display($cachable = false, $urlparams = false)
	{
		// Setzt einen Standard view
		if(!JRequest::getCmd('view'))
		{
			JRequest::setVar('view', 'main');
		}
		require_once JPATH_COMPONENT.'/helpers/alvearium.php';

		parent::display();

		// Load the submenu.
		$view = JRequest::getWord('view', 'main');
		if ($view != 'main')
		{
			AlveariumHelper::addSubmenu($view);
		}

		return $this;
	}
}
