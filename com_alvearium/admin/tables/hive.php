<?php
defined('_JEXEC') or die('Restricted access');

class AlveariumTableHive extends JTable
{
	function __construct(&$db)
	{
		parent::__construct( '#__alvearium_hives', 'id', $db );
	}

	public function store($updateNulls = false)
	{
		// Fill in current user and current date if empty
		if (empty($this->created_by)) {
			$user	= JFactory::getUser();
			$this->created_by = $user->get('id');
		}
		if (!intval($this->created)) {
			$date	= JFactory::getDate();
			$this->created = $date->toSql();
		}

		// Verify that the alias is unique
		$table = JTable::getInstance('hive', 'AlveariumTable');
		if ($table->load(array('alias' => $this->alias)) && ($table->id != $this->id || $this->id == 0)) {
			$this->setError(JText::_('COM_ALVEARIUM_ERROR_ALIAS'));
			return false;
		}

		return parent::store($updateNulls);
	}

	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Get an instance of the table
		$table = JTable::getInstance('Hive','AlveariumTable');

		// For all keys
		foreach ($pks as $pk)
		{
			// Load the banner
			if(!$table->load($pk))
			{
				$this->setError($table->getError());
			}

			// Change the state
			$table->state = $state;

			// Check the row
			$table->check();

			// Store the row
			if (!$table->store())
			{
				$this->setError($table->getError());
			}
		}
		return count($this->getErrors())==0;
	}
}
