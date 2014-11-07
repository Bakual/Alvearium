<?php
defined('_JEXEC') or die('Restricted access');

$controller	= JController::getInstance('Alvearium');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
