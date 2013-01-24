<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class AlveariumModelMap extends JModelList
{
	function getListQuery()
	{
		$app	= JFactory::getApplication();
		$params	= $app->getParams();

		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$query->select(
			$this->getState(
				'list.select',
				'a.ext_id, a.lat, a.lng, a.title, a.type'
			)
		);
		$query->from('`#__alvearium_locations` AS a');

		$query->select('CASE WHEN a.type=1 THEN b.title ELSE h.title END AS ext_title');
		$query->select('CASE WHEN a.type=1 THEN b.title_lat ELSE "" END AS title_lat');
		$query->select('CASE WHEN a.type=1 THEN b.catid ELSE h.catid END AS category');
		$query->join('LEFT', '#__alvearium_plants AS b ON a.ext_id = b.id');
		$query->join('LEFT', '#__alvearium_hives AS h ON a.ext_id = h.id');

		$query->where('a.state = 1');
		switch ((int)$params->get('type', 0)){
			case 1:
				$query->where('a.type = 1');
				$query->where('b.state = 1');
				break;
			case 3:
				$query->where('a.type = 3');
				$query->where('h.state = 1');
				break;
			default:
				$query->where('((a.type = 1 AND b.state = 1) OR (a.type = 3 AND h.state = 1))');
				break;
		}
		if ((int)$params->get('filter_date', 0)){
			$query->where('((a.type != 1) OR (DAYOFYEAR(CURDATE()) BETWEEN b.avg_start AND b.avg_stop))');
		}
		$query->where('a.lat != 0.000000');
		$query->where('a.lng != 0.000000');
		$query->order('a.type, a.title');

		return $query;
	}
}