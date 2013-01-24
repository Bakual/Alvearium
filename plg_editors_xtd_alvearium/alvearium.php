<?php
/**
 * @version		$Id: alvearium.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Editor Alvearium buton
 *
 * @package		Joomla.Plugin
 * @subpackage	Editors-xtd.alvearium
 * @since 1.5
 */
class plgButtonAlvearium extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       1.5
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * Display the button
	 *
	 * @return array A two element array of (imageName, textToInsert)
	 */
	public function onDisplay($name)
	{
		/*
		 * Javascript to insert the link
		 * View element calls jSelectPlant when an plant is clicked
		 * jSelectArticle creates the plugin tag, sends it to the editor,
		 * and closes the select frame.
		 */
		$js = "
		function jSelectPlant(id) {
			var tag = '{alvearium='+id+'}';
			jInsertEditorText(tag, '".$name."');
			SqueezeBox.close();
		}";

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($js);

		JHtml::_('behavior.modal');

		/*
		 * Use the built-in element view to select the plant.
		 * Currently uses blank class.
		 */
		$link = 'index.php?option=com_alvearium&amp;view=plants&amp;layout=modal&amp;tmpl=component';

		$button = new JObject();
		$button->set('modal', true);
		$button->set('link', $link);
		$button->set('text', JText::_('PLG_EDITORS-XTD_ALVEARIUM_BUTTON_ALVEARIUM'));
		$button->set('name', 'blank');
		$button->set('options', "{handler: 'iframe', size: {x: 770, y: 400}}");

		return $button;
	}
}
