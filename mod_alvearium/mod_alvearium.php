<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DS.'helper.php');

$cacheparams = new stdClass;
$cacheparams->cachemode = 'static';
$cacheparams->class = 'modAlveariumHelper';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$list = JModuleHelper::moduleCache ($module, $params, $cacheparams);

if (!count($list)) {
	return;
}

$moduleclass_sfx	= htmlspecialchars($params->get('moduleclass_sfx'));
$itemid				= (int)$params->get('menuitem');
$daysplus			= (int)$params->get('daysplus', 30);
$time				= time() + $daysplus * 86400;

require JModuleHelper::getLayoutPath('mod_alvearium', $params->get('layout', 'default'));