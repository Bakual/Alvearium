ALTER TABLE #__alvearium_blooms ADD `notes` LONGTEXT NOT NULL;
ALTER TABLE #__alvearium_blooms CHANGE `lon` `lng` DECIMAL(9,6) NOT NULL DEFAULT '0';
