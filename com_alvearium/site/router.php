<?php
defined('_JEXEC') or die;

function AlveariumBuildRoute(&$query)
{
	$app		= JFactory::getApplication();
	$segments	= array();
	$view		= '';
	if (isset($query['view']))
	{
		$segments[] = $query['view'];
		$view = $query['view'];
		unset($query['view']);
	} 
	else 
	{
		// Get view from Itemid if not specified in query
		// get a menu item based on Itemid or currently active
		$menu		= $app->getMenu();
		// we need a menu item.  Either the one specified in the query, or the current active one if none specified
		if (empty($query['Itemid'])) 
		{
			$menuItem = $menu->getActive();
		} 
		else 
		{
			$menuItem = $menu->getItem($query['Itemid']);
		}
		if (isset($menuItem->query['view']))
		{
			$view	= $menuItem->query['view'];
		}
	}
	if($view == 'map' && !isset($query['format']))
	{
		if($app->getCfg('sef_suffix'))
		{
			$query['format'] = 'raw';
		}
	}
	return $segments;
}

function AlveariumParseRoute($segments)
{
	$vars = array();
	switch ($segments[0])
	{
		case 'map':
			$vars['view'] = 'map';
			$vars['format'] = 'raw';
			break;
	}
	return $vars;
}