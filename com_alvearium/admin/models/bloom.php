<?php
/**
 * @version		$Id: bloom.php 21148 2011-04-14 17:30:08Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

class AlveariumModelBloom extends JModelAdmin
{
	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 * @return	boolean	True if allowed to delete the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canDelete($record)
	{
		if (!empty($record->id)) {
				if ($record->state != -2) {
					return ;
				}
			$user = JFactory::getUser();

			if (!empty($record->catid)) {
				return $user->authorise('core.delete', 'com_alvearium.category.'.(int) $record->catid);
			}
			else {
				return $user->authorise('core.delete', 'com_alvearium');
			}
		}
	}

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 * @return	boolean	True if allowed to change the state of the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		if (!empty($record->catid)) {
			return $user->authorise('core.edit.state', 'com_alvearium.category.'.(int) $record->catid);
		}
		else {
			return $user->authorise('core.edit.state', 'com_alvearium');
		}
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Bloom', $prefix = 'AlveariumTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_alvearium.bloom', 'bloom', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_alvearium.edit.bloom.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}
		if ($data->type == 2)
		{
			$data->date_id = $data->ext_id;
			$data->plant_id = 0;
		}
		else
		{
			$data->plant_id = $data->ext_id;
			$data->date_id = 0;
		}

		return $data;
	}

	public function save($data)
	{
		if ($data['type'] == 2)
		{
			$data['ext_id'] = $data['date_id'];
			if ($data['stop_date'] == '0000-00-00' || !$data['stop_date'])
			{
				$data['stop_date'] = $data['start_date'];
			}
		}
		else
		{
			$data['ext_id'] = $data['plant_id'];
		}
		return parent::save($data);
	}

	/**
	 * Prepare and sanitise the table data prior to saving.
	 *
	 * @param	JTable	A JTable object.
	 * @since	1.6
	 */
	protected function prepareTable($table)

	{
		if($table->stop_date == '0000-00-00' || $table->stop_date == ''){
			$table->stop_date = null;
		}
	}
}
