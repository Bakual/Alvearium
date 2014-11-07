<?php
// No direct access.
defined('_JEXEC') or die;

class AlveariumControllerBlooms extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 */
	public function getModel($name = 'Bloom', $prefix = 'AlveariumModel', $config = array())
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}
}
