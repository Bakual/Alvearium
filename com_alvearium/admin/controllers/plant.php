<?php
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class AlveariumControllerPlant extends JControllerForm
{
	protected function allowAdd($data = array())
	{
		// In the absense of better information, revert to the component permissions.
		return parent::allowAdd();
	}

	protected function allowEdit($data = array(), $key = 'id')
	{
		// Since there is no asset tracking, revert to the component permissions.
		return parent::allowEdit($data, $key);
	}
}