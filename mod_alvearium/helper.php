<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

abstract class modAlveariumHelper
{
	public static function getList($params)
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.notes, a.type');
		$query->from('#__alvearium_blooms AS a');
		$query->where('a.state = 1');

		// Join over Plants
		$query->select('b.title AS plant_title, b.content_item, b.title_lat');
		$query->join('LEFT', '#__alvearium_plants AS b ON a.ext_id = b.id');

		// Join over Dates
		$query->select('c.title AS date_title');
		$query->join('LEFT', '#__alvearium_dates AS c ON a.ext_id = c.id');

		// Join over Plants
		$query->select('d.catid AS content_cat');
		$query->join('LEFT', '#__content AS d ON b.content_item = d.id');

		// Check states of date/plant
		$query->where('((b.state = 1 AND a.type = 1) OR (c.state = 1 AND a.type = 2))');

		// Grouping
		$query->select('MAKEDATE(YEAR(CURDATE()), (SUM(DAYOFYEAR(a.start_date))/COUNT(a.start_date))) AS start');
		$query->select('MAKEDATE(YEAR(CURDATE()), (SUM(DAYOFYEAR(a.stop_date))/COUNT(a.stop_date))) AS stop');
		$query->select('GROUP_CONCAT(a.start_date ORDER BY a.start_date ASC SEPARATOR ";") AS start_dates');
		$query->select('GROUP_CONCAT(a.stop_date ORDER BY a.start_date ASC SEPARATOR ";") AS stop_dates');
		$query->group('ext_id, type');
		$query->order('start ASC');

		$db->setQuery($query);
		$items	= $db->loadObjectList();

		return $items;
	}
}