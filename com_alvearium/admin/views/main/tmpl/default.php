<?php
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
?>

<table class="adminform">
	<tbody><tr><td valign="top">
		<div id="cpanel">
			<div style="float: left;"><div class="icon">
				<a href="index.php?option=com_alvearium&view=hives">
					<img border="0" align="middle" alt="<?php echo JText::_('COM_ALVEARIUM_MAIN_HIVES'); ?>" src="<?php echo JURI::base()."components/com_alvearium/images/Mushroom-Bee-icon.png"; ?>"/>
					<span><?php echo JText::_('COM_ALVEARIUM_MAIN_HIVES'); ?></span>
				</a>
			</div></div>
			<div style="float: left;"><div class="icon">
				<a href="index.php?option=com_alvearium&view=plants">
					<img border="0" align="middle" alt="<?php echo JText::_('COM_ALVEARIUM_MAIN_PLANTS'); ?>" src="<?php echo JURI::base()."components/com_alvearium/images/Flower-Fire-icon.png"; ?>"/>
					<span><?php echo JText::_('COM_ALVEARIUM_MAIN_PLANTS'); ?></span>
				</a>
			</div></div>
			<div style="float: left;"><div class="icon">
				<a href="index.php?option=com_alvearium&view=blooms">
					<img border="0" align="middle" alt="<?php echo JText::_('COM_ALVEARIUM_MAIN_BLOOMS'); ?>" src="<?php echo JURI::base()."components/com_alvearium/images/Pollen-Flower-icon.png"; ?>"/>
					<span><?php echo JText::_('COM_ALVEARIUM_MAIN_BLOOMS'); ?></span>
				</a>
			</div></div>
			<div style="float: left;"><div class="icon">
				<a href="index.php?option=com_alvearium&view=dates">
					<img border="0" align="middle" alt="<?php echo JText::_('COM_ALVEARIUM_MAIN_DATES'); ?>" src="<?php echo JURI::base()."components/com_alvearium/images/Calendar-icon.png"; ?>"/>
					<span><?php echo JText::_('COM_ALVEARIUM_MAIN_DATES'); ?></span>
				</a>
			</div></div>
			<div style="float: left;"><div class="icon">
				<a href="index.php?option=com_alvearium&view=locations">
					<img border="0" align="middle" alt="<?php echo JText::_('COM_ALVEARIUM_MAIN_LOCATIONS'); ?>" src="<?php echo JURI::base()."components/com_alvearium/images/Location-icon.png"; ?>"/>
					<span><?php echo JText::_('COM_ALVEARIUM_MAIN_LOCATIONS'); ?></span>
				</a>
			</div></div>
		</div>
		<div style="clear: both;"> </div>
	</td></tr></tbody>
</table>	
