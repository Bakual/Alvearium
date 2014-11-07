<?php
// No direct access
defined('_JEXEC') or die;

class AlveariumControllerBloom extends JControllerForm
{
	protected function allowAdd($data = array())
	{
		// In the absense of better information, revert to the component permissions.
		return parent::allowAdd();
	}

	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
		$this->updateAvg($validData);

		return;
	}

	private function updateAvg($validData)
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select('SUM(DAYOFYEAR(a.start_date))/COUNT(a.start_date) AS start');
		$query->select('SUM(DAYOFYEAR(a.stop_date))/COUNT(a.stop_date) AS stop');

		$query->from('#__alvearium_blooms AS a');

		$query->where('a.state = 1');
		$query->where('a.type = ' . $validData['type']);

		if ($validData['type'] == 1)
		{
			$query->where('a.ext_id = ' . $validData['plant_id']);
		}
		else
		{
			$query->where('a.ext_id = ' . $validData['date_id']);
		}

		$query->group('ext_id');

		$db->setQuery($query);
		$dates = $db->loadAssoc();

		$query = $db->getQuery(true);

		if ($validData['type'] == 1)
		{
			$query->update('#__alvearium_plants');
		}
		else
		{
			$query->update('#__alvearium_dates');
		}

		$query->set('avg_start = ' . $dates['start']);
		$query->set('avg_stop = ' . $dates['stop']);

		if ($validData['type'] == 1)
		{
			$query->where('id = ' . $validData['plant_id']);
		}
		else
		{
			$query->where('id = ' . $validData['date_id']);
		}

		$db->setQuery($query);
		$db->execute();

		return;
	}
}
