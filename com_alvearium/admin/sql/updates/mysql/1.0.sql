CREATE TABLE IF NOT EXISTS `#__alvearium_locations` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NOT NULL,
	`alias` VARCHAR(255) NOT NULL,
	`ordering` INT(11) NOT NULL DEFAULT '0',
	`hits` INT(10) NOT NULL DEFAULT '0',
	`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`created_by` INT(10) NOT NULL DEFAULT '0',
	`catid` INT(10) NOT NULL DEFAULT '0',
	`metakey` TEXT NOT NULL,
	`metadesc` TEXT NOT NULL,
	`checked_out` INT(11) NOT NULL DEFAULT '0',
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`state` TINYINT(3) NOT NULL DEFAULT '0',
	`lat` DECIMAL(8,6) NOT NULL DEFAULT '0',
	`lng` DECIMAL(9,6) NOT NULL DEFAULT '0',
	`ext_id` INT(10) NOT NULL DEFAULT '0',
	`type` INT(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
INSERT INTO `#__alvearium_locations`
	(`lat`,`lng`, `ext_id`) 
	SELECT `lat`, `lng`, `id` FROM `#__alvearium_blooms` WHERE `type` = '1';
ALTER TABLE `#__alvearium_blooms` DROP `lat`;
ALTER TABLE `#__alvearium_blooms` DROP `lng`;
ALTER TABLE #__alvearium_plants ADD `checked_out` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE #__alvearium_plants ADD `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER TABLE #__alvearium_blooms ADD `checked_out` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE #__alvearium_blooms ADD `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER TABLE #__alvearium_blooms CHANGE `plant_id` `ext_id` INT(10) NOT NULL DEFAULT '0';
ALTER TABLE #__alvearium_dates ADD `checked_out` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE #__alvearium_dates ADD `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';
