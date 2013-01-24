<?php
// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Alvearium Content Plugin
 *
 * Displays the bloom dates in a content item
 *
 */
class plgContentAlvearium extends JPlugin
{
	public function onContentPrepare($context, &$article, &$params, $limitstart = 0)
	{
		$app = JFactory::getApplication();
		$this->loadLanguage();

		// define the regular expression for the plugin
		$regex = "/{alvearium=(.*)}/U";

		// find all instances of plugin and put in $matches
		$matches = array();
		preg_match_all( $regex, $article->text, $matches, PREG_SET_ORDER );
		foreach ($matches as $match) {
			$plant = $match[1];
			$db = JFactory::getDBO();
			$query 	= 'SELECT start_date, stop_date'
					. ' FROM #__alvearium_blooms'
					. ' WHERE state = 1'
					. ' AND type = 1'
					. ' AND ext_id = '.$plant
					. ' ORDER BY start_date DESC'
					. ' LIMIT '.(int)$this->params->get('alvearium_count', 3);
			$db->setQuery($query);
			$blooms = $db->loadObjectList();
			$html = '';
			if (count($blooms)){
				$html = '<div class="alvearium"><b>'.JText::_('PLG_CONTENT_ALVEARIUM_BLOOMS').':</b><ul>';
				foreach ($blooms as $bloom){
					if ($bloom->stop_date && ($bloom->stop_date)){
						$html .= '<li>'.JHTML::Date($bloom->start_date, 'Y: j. F').' - '.JHTML::Date($bloom->stop_date, 'j. F').'</li>';
					} else {
						$html .= '<li>'.JHTML::Date($bloom->start_date, 'Y: j. F').' - ...</li>';
					}
				}
				$html .= '</ul></div>';
			}
			$article->text = preg_replace($regex, $html, $article->text, 1);
		}
		return true;
	}
}