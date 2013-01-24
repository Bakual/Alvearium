<?php
/**
 * @package		com_sermonspeaker
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.categories');

/**
 * SermonSpeaker Component Category Tree
 *
 * @static
 * @package		com_sermonspeaker
 */
class AlveariumCategories extends JCategories
{
	public function __construct($options = array())
	{
		if (!isset($options['table'])){
			$options['table'] = '#__alvearium_locations';
		}
		$options['extension'] = 'com_alvearium';
		parent::__construct($options);
	}
}
