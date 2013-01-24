<?php 
// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
include_once JPATH_SITE . '/components/com_content/helpers/route.php';
$now	= time();
?>
<ul class="alvearium<?php echo $moduleclass_sfx; ?>">
<?php 
foreach ($list as $item) :
	$expl_stop			= explode(';', $item->stop_dates);
	$newest['stop']		= end($expl_stop);
	$expl_start			= explode(';', $item->start_dates);
	$newest['start']	= end($expl_start);
	if (!$newest['stop'] || (count($expl_stop) < count($expl_start)) || (strtotime($newest['stop']) > $now)):
		$state	= 1; // active
	elseif ((strtotime($newest['stop']) < $now) && (strtotime($item->stop) > $now)):
		$state	= 0; // expected
	else:
		continue;
	endif;
	if ($state):
		if (strtotime($newest['start']) < $time):
			$state	= 1;
			$class	= 'active';
		else:
			continue;
		endif;
	else:
		if (strtotime($item->start) < $now):
			$state	= -1;
			$class	= 'expected-since';
		elseif (strtotime($item->start) < $time):
			$state	= 0;
			$class	= 'expected-in';
		else:
			continue;
		endif;
	endif;
	?>
	<li class="<?php echo $class; ?>">
		<?php if ($item->type == 1): // Pflanze
			$title	= $item->plant_title;
			$tip	= array();
			if($item->title_lat){
				$tip[]	= '<i>'.$item->title_lat.'</i>';
				$title	.= ' <small><i>('.$item->title_lat.')</i></small>';
			}
			foreach ($expl_start AS $key => $start):
				$string	= JHtml::Date($start, JText::_('DATE_FORMAT_LC4')).' - ';
				$string	.= (isset($expl_stop[$key]) && $expl_stop[$key]) ? JHtml::Date($expl_stop[$key], JText::_('DATE_FORMAT_LC4')) : '...';
				$tip[]	= $string;
			endforeach;
			$tip	= implode('<br/>', $tip);
			$link	= ($item->content_item) ? JRoute::_(ContentHelperRoute::getArticleRoute($item->content_item, $item->content_cat).'&Itemid='.$itemid) : '';
			echo JHTML::tooltip($tip, $item->plant_title, '', $title, $link);
		else: // Datum
			echo $item->date_title;
		endif; ?>
		<br />
		<span class="dates <?php echo $class; ?>">
			<?php
			if ($state < 0): // expected since
				echo JText::sprintf('MOD_ALVEARIUM_SINCE_DAYS', ceil(($now - strtotime($item->start)) / 86400));
			elseif (!$state): // expected in
				echo JText::sprintf('MOD_ALVEARIUM_IN_DAYS', ceil((strtotime($item->start) - $now) / 86400));
			else: // active
				if ($newest['start'] == $newest['stop']):
					echo JText::sprintf('MOD_ALVEARIUM_ACTIVE', JHtml::Date($newest['start'], 'd.F'));
				elseif ($newest['stop'] && (count($expl_stop) == count($expl_start))):
					echo JText::sprintf('MOD_ALVEARIUM_ACTIVE', JHtml::Date($newest['start'], 'd.F').' - '.JHtml::Date($newest['stop'], 'd.F'));
				else:
					echo JText::sprintf('MOD_ALVEARIUM_ACTIVE', JHtml::Date($newest['start'], 'd.F').' - ...');
				endif;
			endif;
			?>
		</span>
	</li>
<?php endforeach; ?>
</ul>