<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class AlveariumModelDates extends JModelList
{
	function __construct()
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'alias', 'a.alias',
				'catid', 'a.catid', 'category_title',
				'state', 'a.state',
				'created', 'a.created',
				'created_by', 'a.created_by',
				'ordering', 'a.ordering',
			);
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
		$session = JFactory::getSession();

		// Adjust the context to support modal layouts.
		if ($layout = JRequest::getVar('layout')) {
			$this->context .= '.'.$layout;
		}

		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$access = $this->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);

		$authorId = $app->getUserStateFromRequest($this->context.'.filter.author_id', 'filter_author_id');
		$this->setState('filter.author_id', $authorId);

		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
		$this->setState('filter.state', $published);

		$categoryId = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id');
		$this->setState('filter.category_id', $categoryId);

		$language = $this->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '');
		$this->setState('filter.language', $language);

		// List state information.
		parent::populateState('a.title', 'asc');
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('filter.search');
		$id.= ':' . $this->getState('filter.access');
		$id.= ':' . $this->getState('filter.state');
		$id.= ':' . $this->getState('filter.category_id');
		$id.= ':' . $this->getState('filter.language');

		return parent::getStoreId($id);
	}

	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.title, a.alias, a.catid,' .
				'a.created, a.state'
			)
		);
		$query->from('`#__alvearium_dates` AS a');

		// Join over the categories.
		$query->select('c.title AS category_title');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = '.(int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by category.
		$categoryId = $this->getState('filter.category_id');
		if (is_numeric($categoryId)) {
			$query->where('a.catid = '.(int) $categoryId);
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('(a.title LIKE '.$search.' OR a.alias LIKE '.$search.')');
			}
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
		if ($orderCol == 'a.ordering' || $orderCol == 'category_title') {
			$orderCol = 'category_title '.$orderDirn.', a.ordering';
		}
		$query->order($db->getEscaped($orderCol.' '.$orderDirn));

		return $query;
	}
}