<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

// require_once JPATH_COMPONENT.'/helpers/route.php';
// require_once(JPATH_COMPONENT.DS.'helpers'.DS.'sermonspeaker.php');

$controller	= JController::getInstance('Alvearium');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();