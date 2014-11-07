<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Alvearium Component Controller
 */
class AlveariumController extends JControllerLegacy
{
	protected $default_view = 'map';

	public function display($cachable = false, $urlparams = false)
	{
		$cachable = true;

		$jinput = JFactory::getApplication()->input;

		if ($jinput->getCmd('view') == 'map' && ($jinput->getCmd('format') != 'raw'))
		{
			$this->setRedirect('index.php?option=com_alvearium&view=map&format=raw');

			return;
		}

		$safeurlparams = array(
			'id' => 'INT',
			'limit' => 'INT',
			'limitstart' => 'INT',
			'filter_order' => 'CMD',
			'filter_order_Dir' => 'CMD',
			'lang' => 'CMD'
		);

		return parent::display($cachable, $safeurlparams);
	}
}
