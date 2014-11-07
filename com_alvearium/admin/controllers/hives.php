<?php
// No direct access.
defined('_JEXEC') or die;

class AlveariumControllerHives extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 */
	public function &getModel($name = 'Hive', $prefix = 'AlveariumModel')
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}
}
