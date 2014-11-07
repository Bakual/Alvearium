<?php
defined('_JEXEC') or die('Restricted access');

JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_alvearium/tables');

class AlveariumControllerBloom extends AlveariumController
{
	/**
	 * Custom Constructor (registers additional tasks to methods)
	 */
	function __construct($default = array())
	{
		parent::__construct($default);

		$this->registerTask('apply', 'save');
		$this->registerTask('unpublish', 'publish');
		$this->registerTask('edit',	'display');
		$this->registerTask('add', 'display' );
	}

	function display(){
		switch($this->getTask()){
			case 'add':
				JRequest::setVar('hidemainmenu', 1);
				JRequest::setVar('layout', 'form');
				JRequest::setVar('view', 'letter');
				JRequest::setVar('edit', false);
				break;
			case 'edit':
				JRequest::setVar('hidemainmenu', 1);
				JRequest::setVar('layout', 'form');
				JRequest::setVar('view', 'letter');
				JRequest::setVar('edit', true);
				break;
		}
		parent::display();
	}

	function save()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$row = &JTable::getInstance('blooms', 'Table');
		$post = JRequest::get('post');
		// get the Text Area 'text' again, but not full *cleaned* by JRequest.
		$post['body'] = JRequest::getVar('body', '', 'post', 'string', JREQUEST_ALLOWRAW);

		$success = $row->save($post);
		if (!$success) {
			JError::raiseError(500, $row->getError());
		}

		switch ($this->_task)
		{
			case 'apply':
				$msg = JText::_('COM_ALVEARIUM_BLOOMS_APPLIED');
				$link = 'index.php?option=com_alvearium&controller=letter&task=edit&cid[]='.$row->id;
				break;

			case 'save':
			default:
				$msg = JText::_('COM_ALVEARIUM_BLOOMS_SAVED');
				$link = 'index.php?option=com_alvearium&view=blooms';
				break;
		}

		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$cid = JRequest::getVar('cid', array(), '', 'array');
		JArrayHelper::toInteger($cid);

		$msg = JText::_('COM_ALVEARIUM_BLOOMS_DELETED');
		$row = &JTable::getInstance('blooms', 'Table');

		for ($i=0, $n=count($cid); $i < $n; $i++)
		{
			if (!$row->delete($cid[$i]))
			{
				$msg .= $row->getError();
			}
		}
		$this->setRedirect('index.php?option=com_alvearium&view=blooms', $msg);
	}

	function cancel()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$id	= JRequest::getInt('id', 0);
		$db	= &JFactory::getDBO();
		$row = &JTable::getInstance('blooms', 'Table');
		$row->checkin($id);
		$msg = JText::_('COM_ALVEARIUM_CANCELED');
		$this->setRedirect('index.php?option=com_alvearium&view=blooms', $msg );
	}

	/**
	* Plant the selected letter as Start-letter
	*/
	function BloomStart()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit( 'Invalid Token' );

		// Initialize some variables
		$db		= & JFactory::getDBO();
		$cid	= JRequest::getVar('cid', array(), 'method', 'array');
		$cid	= array(JFilterInput::clean(@$cid[0], 'cmd'));

		if ($cid[0]){
			$query = "UPDATE #__alvearium_blooms \n"
					."SET start = 0 \n";
			$db->setQuery($query);
			$db->query();

			$query = "UPDATE #__alvearium_blooms \n"
					."SET start = 1 \n"
					."WHERE id = ".$db->Quote($cid[0]);
			$db->setQuery($query);
			$db->query();
		}

		$msg = JText::_('COM_ALVEARIUM_STATUS');
		$this->setRedirect('index.php?option=com_alvearium&view=blooms', $msg );
	}

	/**
	* Plant the selected letter as Intervall-letter
	*/
	function BloomIntervall()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit( 'Invalid Token' );

		// Initialize some variables
		$db		= & JFactory::getDBO();
		$cid	= JRequest::getVar('cid', array(), 'method', 'array');
		$cid	= array(JFilterInput::clean(@$cid[0], 'cmd'));

		if ($cid[0]){
			$query = "UPDATE #__alvearium_blooms \n"
					."SET intervall = 0 \n";
			$db->setQuery($query);
			$db->query();

			$query = "UPDATE #__alvearium_blooms \n"
					."SET intervall = 1 \n"
					."WHERE id = ".$db->Quote($cid[0]);
			$db->setQuery($query);
			$db->query();
		}

		$msg = JText::_('COM_ALVEARIUM_STATUS');
		$this->setRedirect('index.php?option=com_alvearium&view=blooms', $msg );
	}
}
