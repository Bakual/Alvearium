<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Alvearium Component Controller
 */
class AlveariumController extends JController
{
	public function display($cachable = false, $urlparams = false)
	{
		$cachable = true;

		// Get the document object.
		$document = JFactory::getDocument();

		// Set the default view name and format from the Request.
		$vName		= JRequest::getWord('view', 'map');
		JRequest::setVar('view', $vName);

		if (JRequest::getCmd('view') == 'map' && (JRequest::getCmd('format') != 'raw')){
			$this->setRedirect('index.php?option=com_alvearium&view=map&format=raw');
			return;
		}

		$safeurlparams = array('id'=>'INT','limit'=>'INT','limitstart'=>'INT','filter_order'=>'CMD','filter_order_Dir'=>'CMD','lang'=>'CMD');

		return parent::display($cachable,$safeurlparams);
	}
}