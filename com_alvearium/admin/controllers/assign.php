<?php
defined('_JEXEC') or die('Restricted access');

JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_alvearium/tables');

class AlveariumControllerPlant extends AlveariumController
{
	/**
	 * Custom Constructor (registers additional tasks to methods)
	 */
	public function __construct($default = array())
	{
		parent::__construct($default);

		$this->registerTask('apply', 'save');
		$this->registerTask('unpublish', 'publish');
		$this->registerTask('edit', 'display');
		$this->registerTask('add', 'display');
	}

	public function display()
	{
		$input = JFactory::getApplication()->input;

		switch($this->getTask())
		{
			case 'add':
				JRequest::setVar('hidemainmenu', 1);
				JRequest::setVar('layout', 'form');
				JRequest::setVar('view', 'assign');
				JRequest::setVar('edit', false);
				break;
			case 'edit':
				JRequest::setVar('hidemainmenu', 1);
				JRequest::setVar('layout', 'form');
				JRequest::setVar('view', 'assign');
				JRequest::setVar('edit', true);
				break;
		}
		parent::display();
	}

	public function save()
	{
		$input = JFactory::getApplication()->input;

		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$row  = JTable::getInstance('plants', 'Table');
		$post = $input->get('post');

		$success = $row->save($post);
		if (!$success) {
			JError::raiseError(500, $row->getError());
		}

		switch ($this->_task)
		{
			case 'apply':
				$msg = JText::_('COM_ALVEARIUM_PLANTS_APPLIED');
				$link = 'index.php?option=com_alvearium&controller=assign&task=edit&cid[]='.$row->id;
				break;

			case 'save':
			default:
				$msg = JText::_('COM_ALVEARIUM_PLANTS_SAVED');
				$link = 'index.php?option=com_alvearium&view=plants';
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

		$msg = JText::_('COM_ALVEARIUM_PLANTS_DELETED');
		$row = &JTable::getInstance('plants', 'Table');

		for ($i=0, $n=count($cid); $i < $n; $i++)
		{
			if (!$row->delete($cid[$i]))
			{
				$msg .= $row->getError();
			}
		}

		$this->setRedirect('index.php?option=com_alvearium&view=plants', $msg);
	}

	/**
	* Publishes or Unpublishes one or more records
	*/
	function publish()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$cid = JRequest::getVar('cid', array(), '', 'array');
		JArrayHelper::toInteger($cid);
		$publish = ($this->getTask() == 'publish' ? 1 : 0);

		if (count($cid) < 1) {
			$action = $publish ? JText::_('PUBLISH') : JText::_('UNPUBLISH');
			JError::raiseError(500, JText::_('SELECT_ITEM_TO'.$action, true));
		}

		$msg = $publish ? JText::_('COM_ALVEARIUM_PLANTS').' '.JText::_('PUBLISHED') : JText::_('COM_ALVEARIUM_PLANTS').' '.JText::_('UNPUBLISHED');
		$row = &JTable::getInstance('plants', 'Table');
		if (!$row->publish($cid,$publish)) {
			$msg = $row->getError();
		}

		$this->setRedirect('index.php?option=com_alvearium&view=plants', $msg);
	}

	function cancel()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$id	= JRequest::getInt('id', 0);
		$db	= &JFactory::getDBO();
		$row = &JTable::getInstance('plants', 'Table');
		$row->checkin($id);
		$msg = JText::_('COM_ALVEARIUM_CANCELED');
		$this->setRedirect('index.php?option=com_alvearium&view=plants', $msg );
	}

}
