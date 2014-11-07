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
		$jinput = JFactory::getApplication()->input;

		switch($this->task)
		{
			case 'add':
				$jinput->set('hidemainmenu', 1);
				$jinput->set('layout', 'form');
				$jinput->set('view', 'assign');
				$jinput->set('edit', false);
				break;
			case 'edit':
				$jinput->set('hidemainmenu', 1);
				$jinput->set('layout', 'form');
				$jinput->set('view', 'assign');
				$jinput->set('edit', true);
				break;
		}

		return parent::display();
	}

	public function save()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$row  = JTable::getInstance('plants', 'Table');
		$post = JFactory::getApplication()->input->post->getArray();

		$success = $row->save($post);

		if (!$success)
		{
			JError::raiseError(500, $row->getError());
		}

		switch ($this->task)
		{
			case 'apply':
				$msg = JText::_('COM_ALVEARIUM_PLANTS_APPLIED');
				$link = 'index.php?option=com_alvearium&controller=assign&task=edit&cid[]=' . $row->id;
				break;

			case 'save':
			default:
				$msg = JText::_('COM_ALVEARIUM_PLANTS_SAVED');
				$link = 'index.php?option=com_alvearium&view=plants';
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

		$msg = JText::_('COM_ALVEARIUM_PLANTS_DELETED');
		$row = &JTable::getInstance('plants', 'Table');

		for ($i = 0, $n=count($cid); $i < $n; $i++)
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
	public function publish()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$jinput = JFactory::getApplication()->input;
		$cid    = $jinput->get('cid', array(), '', 'array');
		JArrayHelper::toInteger($cid);
		$publish = ($this->getTask() == 'publish' ? 1 : 0);

		if (count($cid) < 1)
		{
			$action = $publish ? JText::_('PUBLISH') : JText::_('UNPUBLISH');
			JError::raiseError(500, JText::_('SELECT_ITEM_TO' . $action, true));
		}

		$msg = $publish ? JText::_('COM_ALVEARIUM_PLANTS') . ' ' . JText::_('PUBLISHED') : JText::_('COM_ALVEARIUM_PLANTS') . ' ' . JText::_('UNPUBLISHED');
		$row = JTable::getInstance('plants', 'Table');

		if (!$row->publish($cid,$publish))
		{
			$msg = $row->getError();
		}

		$this->setRedirect('index.php?option=com_alvearium&view=plants', $msg);
	}

	public function cancel()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$jinput = JFactory::getApplication()->input;
		$id     = $jinput->getInt('id', 0);
		$db     = JFactory::getDBO();
		$row    = JTable::getInstance('plants', 'Table');
		$row->checkin($id);
		$msg = JText::_('COM_ALVEARIUM_CANCELED');
		$this->setRedirect('index.php?option=com_alvearium&view=plants', $msg);
	}

}
