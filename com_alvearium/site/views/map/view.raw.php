<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.application.categories');

class AlveariumViewMap extends JViewLegacy
{
	function display( $tpl = null )
	{
		$document = JFactory::getDocument();
		$document->setMimeEncoding('text/xml');

		$categories = JCategories::getInstance('Alvearium');
		$parent = $categories->get('root');
		$this->categories = $parent->getChildren(true);

		// get data from the model
		$this->items = $this->get('Items');

		parent::display($tpl);
	}
}
