<?php
// No direct access.
defined('_JEXEC') or die;

class AlveariumControllerPlants extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 */
	public function getModel($name = 'Plant', $prefix = 'AlveariumModel')
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}
}
