<?php
defined('_JEXEC') or die('Restricted access');

JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_alvearium/tables');

class AlveariumControllerBloom extends AlveariumController
{
	/**
	 * Custom Constructor (registers additional tasks to methods)
	 */
	public function __construct($default = array())
	{
		parent::__construct($default);

		$this->registerTask('apply', 'save');
		$this->registerTask('unpublish', 'publish');
		$this->registerTask('edit',	'display');
		$this->registerTask('add', 'display' );
	}

	public function display()
	{
		$jinput = JFactory::getApplication()->input;

		switch ($this->task)
		{
			case 'add':
				$jinput->set('hidemainmenu', 1);
				$jinput->set('layout', 'form');
				$jinput->set('view', 'letter');
				$jinput->set('edit', false);
				break;
			case 'edit':
				$jinput->set('hidemainmenu', 1);
				$jinput->set('layout', 'form');
				$jinput->set('view', 'letter');
				$jinput->set('edit', true);
				break;
		}

		return parent::display();
	}

	public function save()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$jinput = JFactory::getApplication()->input;
		$row    = JTable::getInstance('blooms', 'Table');
		$post   = $jinput->post->getArray();

		// Get the Text Area 'text' again, but not full *cleaned* by JInput.
		$post['body'] = $jinput->get('body', '', 'post', 'string', JREQUEST_ALLOWRAW);

		$success = $row->save($post);

		if (!$success)
		{
			JError::raiseError(500, $row->getError());
		}

		switch ($this->_task)
		{
			case 'apply':
				$msg  = JText::_('COM_ALVEARIUM_BLOOMS_APPLIED');
				$link = 'index.php?option=com_alvearium&controller=letter&task=edit&cid[]=' . $row->id;
				break;

			case 'save':
			default:
				$msg  = JText::_('COM_ALVEARIUM_BLOOMS_SAVED');
				$link = 'index.php?option=com_alvearium&view=blooms';
				break;
		}

		$this->setRedirect($link, $msg);
	}

	public function remove()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$jinput = JFactory::getApplication()->input;
		$cid    = $jinput->get('cid', array(), '', 'array');
		JArrayHelper::toInteger($cid);

		$msg = JText::_('COM_ALVEARIUM_BLOOMS_DELETED');
		$row = &JTable::getInstance('blooms', 'Table');

		for ($i = 0, $n = count($cid); $i < $n; $i++)
		{
			if (!$row->delete($cid[$i]))
			{
				$msg .= $row->getError();
			}
		}

		$this->setRedirect('index.php?option=com_alvearium&view=blooms', $msg);
	}

	public function cancel()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$id  = JFactory::getApplication()->input->getInt('id', 0);
		$row = JTable::getInstance('blooms', 'Table');
		$row->checkin($id);
		$msg = JText::_('COM_ALVEARIUM_CANCELED');
		$this->setRedirect('index.php?option=com_alvearium&view=blooms', $msg);
	}

	/**
	* Plant the selected letter as Start-letter
	*/
	public function BloomStart()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit( 'Invalid Token' );

		// Initialize some variables
		$db  = JFactory::getDBO();
		$cid = JFactory::getApplication()->input->get('cid', array(), 'method', 'array');
		$cid = array(JFilterInput::clean(@$cid[0], 'cmd'));

		if ($cid[0])
		{
			$query = "UPDATE #__alvearium_blooms \n"
					. "SET start = 0 \n";
			$db->setQuery($query);
			$db->execute();

			$query = "UPDATE #__alvearium_blooms \n"
					. "SET start = 1 \n"
					. "WHERE id = " . $db->Quote($cid[0]);
			$db->setQuery($query);
			$db->execute();
		}

		$msg = JText::_('COM_ALVEARIUM_STATUS');
		$this->setRedirect('index.php?option=com_alvearium&view=blooms', $msg);
	}

	/**
	* Plant the selected letter as Intervall-letter
	*/
	public function BloomIntervall()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit( 'Invalid Token' );

		// Initialize some variables
		$db  = JFactory::getDBO();
		$cid = JFactory::getApplication()->input->get('cid', array(), 'method', 'array');
		$cid = array(JFilterInput::clean(@$cid[0], 'cmd'));

		if ($cid[0])
		{
			$query = "UPDATE #__alvearium_blooms \n"
					. "SET intervall = 0 \n";
			$db->setQuery($query);
			$db->execute();

			$query = "UPDATE #__alvearium_blooms \n"
					. "SET intervall = 1 \n"
					. "WHERE id = " . $db->quote($cid[0]);
			$db->setQuery($query);
			$db->execute();
		}

		$msg = JText::_('COM_ALVEARIUM_STATUS');
		$this->setRedirect('index.php?option=com_alvearium&view=blooms', $msg);
	}
}
