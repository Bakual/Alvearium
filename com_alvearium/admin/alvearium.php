<?php
defined('_JEXEC') or die('Restricted access');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_alvearium'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Require helper file
JLoader::register('AlveariumHelper', dirname(__FILE__) . '/helpers/alvearium.php');

JHTML::stylesheet('administrator/components/com_alvearium/alvearium.css');

$controller = JControllerLegacy::getInstance('Alvearium');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
