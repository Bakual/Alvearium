<?php
defined('_JEXEC') or die('Restricted access');

class AlveariumController extends JControllerLegacy
{
	protected $default_view = 'main';

	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT . '/helpers/alvearium.php';

		return parent::display();
	}
}
