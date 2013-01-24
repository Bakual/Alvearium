<?php
defined('_JEXEC') or die('Restricted access');
echo '<?xml version="1.0" encoding="UTF-8" ?>';
$type = 0;
$folder_open = 0;
$cats = array(); ?>
<kml xmlns="http://www.opengis.net/kml/2.2">
	<Document>
		<name>Alvearium Locations</name>
		<open>1</open>
		<description>Plants and Hives from Alvearium</description>
		<Style id="style1">
			<IconStyle>
				<Icon>
					<href><?php echo JURI::root(); ?>media/com_alvearium/icons/marker_1.png</href>
				</Icon>
			</IconStyle>
		</Style>
		<Style id="style3">
			<IconStyle>
				<Icon>
					<href><?php echo JURI::root(); ?>media/com_alvearium/icons/marker_3.png</href>
				</Icon>
			</IconStyle>
		</Style>
		<?php foreach ($this->categories as $category):
			if ($image = $category->getParams()->get('image')):
				$cats[$category->id] = true; ?>
				<Style id="cat<?php echo $category->id; ?>">
					<IconStyle>
						<Icon>
							<href><?php echo JURI::root().$image; ?></href>
						</Icon>
					</IconStyle>
				</Style>
			<?php endif;
		endforeach;
		foreach ($this->items as $item):
			if ($item->type > $type):
				$type = $item->type;
				if ($folder_open): ?>
				</Folder>
				<?php endif; ?>
				<Folder>
					<name><?php echo JText::_('COM_ALVEARIUM_TYPE_'.$type); ?></name>
					<description><?php echo JText::_('COM_ALVEARIUM_TYPE_'.$type); ?></description>
				<?php $folder_open = 1;
			endif; ?>
				<Placemark>
					<name><?php echo $item->ext_title; ?></name>
					<description>
						<![CDATA[<?php if ($item->title_lat):
							?><p><i>(<?php echo $item->title_lat; ?>)</i></p><?php
						endif;
						if ($item->title):
							?><p><small><?php echo $item->title; ?></small></p><?php
						endif; ?>]]>
					</description>
					<?php if (isset($cats[$item->category])): ?>
						<styleUrl>#cat<?php echo $item->category; ?></styleUrl>
					<?php else: ?>
						<styleUrl>#style<?php echo $type; ?></styleUrl>
					<?php endif; ?>
 					<Point>
						<coordinates><?php echo $item->lng; ?>,<?php echo $item->lat; ?></coordinates>
					</Point>
				</Placemark>
		<?php endforeach;
		if ($this->items): ?>
			</Folder>
		<?php endif; ?>
	</Document>
</kml>