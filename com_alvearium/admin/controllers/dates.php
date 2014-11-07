<?php
// No direct access.
defined('_JEXEC') or die;

class AlveariumControllerDates extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 */
	public function &getModel($name = 'Date', $prefix = 'AlveariumModel')
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}
}
