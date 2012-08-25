### Changed: 03/17/2005

ALTER TABLE `swg_data` CHANGE `ddbdata_catid` `ddbdata_id_cat` VARCHAR( 20 ) NOT NULL;

ALTER TABLE `swg_tmp_storage` CHANGE `ddbtmp_storage_mintime` `ddbtmp_storage_time_min` BIGINT( 20 ) UNSIGNED DEFAULT '0' NOT NULL,
CHANGE `ddbtmp_storage_maxtime` `ddbtmp_storage_time_max` BIGINT( 20 ) UNSIGNED DEFAULT '0' NOT NULL;

### sWG v0.1.02

### Changed: 04/18/2005

ALTER TABLE `swg_users` DROP `ddbusers_deleted_cleanup`;

### Changed: 05/02/2005

ALTER TABLE `swg_tmp_storage` ADD `ddbtmp_storage_maintained` CHAR( 1 ) DEFAULT '0' NOT NULL;

### Changed: 05/20/2005

ALTER TABLE `swg_data` DROP INDEX `ddbdata_data`;
ALTER TABLE `swg_data` ADD FULLTEXT `ddbdata_titledata` (`ddbdata_title`, `ddbdata_data`);

### Changed: 07/23/2005

ALTER TABLE `swg_related_links` RENAME `swg_related_data`;

ALTER TABLE `swg_related_data` CHANGE `ddbrelated_links_id` `ddbrelated_data_id` VARCHAR( 20 ) NOT NULL,
CHANGE `ddbrelated_links_data` `ddbrelated_data_data` TEXT NOT NULL;

ALTER TABLE `swg_related_data` ADD `ddbrelated_data_oid` VARCHAR( 32 ) NOT NULL AFTER `ddbrelated_data_id`,
ADD `ddbrelated_data_mod` VARCHAR( 100 ) NOT NULL AFTER `ddbrelated_data_oid`,
ADD `ddbrelated_data_output_name` VARCHAR( 100 ) NOT NULL AFTER `ddbrelated_data_mod`;

ALTER TABLE `swg_related_data` ADD INDEX ( `ddbrelated_data_oid` );

### Changed: 12/29/2005

## Please check your database for related_data

DROP TABLE `swg_images_linked`;
DROP TABLE `swg_related_links`;

ALTER TABLE `swg_related_data` RENAME `swg_evar_archive`;

ALTER TABLE `swg_evar_archive` CHANGE `ddbrelated_data_id` `ddbevar_archive_id` VARCHAR( 20 ) NOT NULL ,
CHANGE `ddbrelated_data_oid` `ddbevar_archive_created` BIGINT UNSIGNED NOT NULL ,
CHANGE `ddbrelated_data_mod` `ddbevar_archive_editor_id` VARCHAR( 20 ) NOT NULL ,
CHANGE `ddbrelated_data_output_name` `ddbevar_archive_editor_ip` VARCHAR( 20 ) NOT NULL ,
CHANGE `ddbrelated_data_data` `ddbevar_archive_content` TEXT NOT NULL;

ALTER TABLE `swg_evar_archive` DROP INDEX `ddbrelated_data_oid`;

ALTER TABLE `swg_evar_archive` ADD `ddbevar_archive_owner_id` VARCHAR( 20 ) NOT NULL AFTER `ddbevar_archive_created` ,
ADD `ddbevar_archive_owner_ip` VARCHAR( 20 ) NOT NULL AFTER `ddbevar_archive_owner_id` ,
ADD `ddbevar_archive_changed` BIGINT UNSIGNED NOT NULL AFTER `ddbevar_archive_owner_ip` ;

### Changed: 02/08/2006

ALTER TABLE `swg_tmp_storage` CHANGE `ddbtmp_storage_data` `ddbtmp_storage_data` MEDIUMTEXT NOT NULL;

### Changed: 02/11/2006

ALTER TABLE `swg_users` ADD `ddbusers_timezone` TINYINT DEFAULT '0' NOT NULL AFTER `ddbusers_rating`;

### sWG v0.1.03

UPDATE `swg_users` SET `ddbusers_deleted` = '1' WHERE `ddbusers_id` = 'dng' LIMIT 1;
UPDATE `swg_users` SET `ddbusers_avatar`='';

### Changed: 03/18/2008

ALTER TABLE `swg_log` ADD INDEX (`ddblog_time`);
ALTER TABLE `swg_users` ADD INDEX (`ddbusers_name`);
ALTER TABLE `swg_users` ADD INDEX (`ddbusers_lastvisit_time`);
ALTER TABLE `swg_tmp_storage` ADD INDEX ( `ddbtmp_storage_time_min` );
ALTER TABLE `swg_tmp_storage` ADD INDEX ( `ddbtmp_storage_time_max` );
ALTER TABLE `swg_tmp_storage` ADD INDEX ( `ddbtmp_storage_maintained` );

### Changed: 03/01/2009

ALTER TABLE `swg_uuids_list` ADD `ddbuuids_list_passcode_prev` CHAR( 96 ) NULL AFTER `ddbuuids_list_passcode` ,
ADD INDEX ( `ddbuuids_list_maxage_inactivity` ) ,
CHANGE `ddbuuids_list_passcode` `ddbuuids_list_passcode` CHAR( 96 ) NOT NULL ;

ALTER TABLE `swg_log` CHANGE `ddblog_data` `ddblog_data` TEXT NULL ;

### Changed: 10/21/2009

ALTER TABLE `swg_evars_archive` CHANGE `ddbevars_archive_id` `ddbevars_archive_id` VARCHAR( 32 ) NOT NULL;
ALTER TABLE `swg_users` CHANGE `ddbusers_lang` `ddbusers_lang` VARCHAR( 20 ) NOT NULL;

### Changed: 12/02/2010

ALTER TABLE `swg_datalinker` ADD `ddbdatalinker_id_site` VARCHAR( 20 ) DEFAULT NULL AFTER `ddbdatalinker_id_main`;
ALTER TABLE `swg_datalinker` ADD INDEX ( `ddbdatalinker_id_site` ) ;
ALTER TABLE `swg_log` ADD `ddblog_source_id` VARCHAR( 20 ) NOT NULL AFTER `ddblog_id`;
ALTER TABLE `swg_log` ADD `ddblog_maintained` CHAR( 1 ) DEFAULT '0' NOT NULL AFTER `ddblog_data`;
ALTER TABLE `swg_log` ADD INDEX ( `ddblog_maintained` ) ;

### Changed: 06/11/2012

ALTER TABLE `swg_uuids_list` DROP `ddbuuids_list_maxage_timeout` ;