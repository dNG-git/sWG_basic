CREATE TABLE `swg_credits` (
  `ddbcredits_id` varchar(20) NOT NULL DEFAULT '',
  `ddbcredits_id_obj` varchar(20) NOT NULL DEFAULT '',
  `ddbcredits_id_user` varchar(20) NOT NULL DEFAULT '',
  `ddbcredits_controller` varchar(255) NOT NULL DEFAULT '',
  `ddbcredits_identifier` varchar(255) NOT NULL DEFAULT '',
  `ddbcredits_time` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ddbcredits_amount` mediumint(9) NOT NULL DEFAULT '0',
  `ddbcredits_counter` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddbcredits_id`),
  KEY `ddbcredits_id_obj` (`ddbcredits_id_obj`),
  KEY `ddbcredits_controller` (`ddbcredits_controller`),
  KEY `ddbcredits_identifier` (`ddbcredits_identifier`),
  KEY `ddbcredits_time` (`ddbcredits_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `swg_credits_specials` (
  `ddbcredits_specials_id` varchar(20) NOT NULL DEFAULT '',
  `ddbcredits_specials_id_obj` varchar(32) NOT NULL DEFAULT '',
  `ddbcredits_specials_group` varchar(20) NOT NULL DEFAULT '',
  `ddbcredits_specials_onetime` mediumint(9) NOT NULL DEFAULT '0',
  `ddbcredits_specials_periodically` mediumint(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddbcredits_specials_id`),
  KEY `ddbcredits_specials_id_obj` (`ddbcredits_specials_id_obj`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `swg_data` (
  `ddbdata_id` varchar(20) NOT NULL DEFAULT '',
  `ddbdata_id_cat` varchar(20) NOT NULL DEFAULT '',
  `ddbdata_owner` varchar(20) NOT NULL DEFAULT '',
  `ddbdata_data` mediumtext NOT NULL,
  `ddbdata_sid` varchar(32) NOT NULL DEFAULT '',
  `ddbdata_mode_user` char(1) NOT NULL DEFAULT '-',
  `ddbdata_mode_group` char(1) NOT NULL DEFAULT '-',
  `ddbdata_mode_all` char(1) NOT NULL DEFAULT '-',
  PRIMARY KEY (`ddbdata_id`),
  KEY `ddbdata_id_cat` (`ddbdata_id_cat`),
  KEY `ddbdata_sid` (`ddbdata_sid`),
  FULLTEXT KEY `ddbdata_data` (`ddbdata_data`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `swg_evars_archive` (
  `ddbevars_archive_id` varchar(32) NOT NULL,
  `ddbevars_archive_data` mediumtext NOT NULL,
  PRIMARY KEY (`ddbevars_archive_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `swg_log` (
  `ddblog_id` varchar(20) NOT NULL DEFAULT '',
  `ddblog_source_id` varchar(20) NOT NULL,
  `ddblog_time` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ddblog_source_user_id` varchar(20) NOT NULL DEFAULT '',
  `ddblog_source_user_ip` varchar(100) NOT NULL DEFAULT '',
  `ddblog_target_user_id` varchar(20) NOT NULL DEFAULT '',
  `ddblog_target_user_ip` varchar(100) NOT NULL DEFAULT '',
  `ddblog_identifier` varchar(255) NOT NULL DEFAULT '',
  `ddblog_sid` varchar(32) NOT NULL DEFAULT '',
  `ddblog_data` text,
  `ddblog_maintained` char(1) NOT NULL DEFAULT '0',
  `ddblog_customdata_id` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`ddblog_id`),
  KEY `ddblog_sid` (`ddblog_sid`),
  KEY `ddblog_time` (`ddblog_time`),
  KEY `ddblog_maintained` (`ddblog_maintained`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `swg_tmp_storage` (
  `ddbtmp_storage_id` varchar(96) NOT NULL DEFAULT '',
  `ddbtmp_storage_time_min` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ddbtmp_storage_time_max` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ddbtmp_storage_sid` varchar(32) NOT NULL DEFAULT '',
  `ddbtmp_storage_identifier` varchar(255) NOT NULL DEFAULT '',
  `ddbtmp_storage_data` mediumtext NOT NULL,
  `ddbtmp_storage_maintained` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddbtmp_storage_id`),
  KEY `ddbtmp_storage_time_min` (`ddbtmp_storage_time_min`),
  KEY `ddbtmp_storage_time_max` (`ddbtmp_storage_time_max`),
  KEY `ddbtmp_storage_sid` (`ddbtmp_storage_sid`),
  KEY `ddbtmp_storage_identifier` (`ddbtmp_storage_identifier`),
  KEY `ddbtmp_storage_maintained` (`ddbtmp_storage_maintained`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `swg_tmp_storage` (`ddbtmp_storage_id`, `ddbtmp_storage_time_min`, `ddbtmp_storage_time_max`, `ddbtmp_storage_sid`, `ddbtmp_storage_identifier`, `ddbtmp_storage_data`, `ddbtmp_storage_maintained`) VALUES 
('510bf66f710451edf184365b1fb3cadfe3699b03e25829bde24980fe1407745ca19c12c0233aced0218072f71e13252e', 1137857071, 1137857521, '9d3bb895f22bf0afa958d68c2a58ded7', 'auto_maintenance', '<evars><job_identifier value="cron_auto_maintenance" /><job_control_file value="swgi_auto_maintenance.php" /><job_ignore_limit value="1" /><loop value="1" /><loop_interval value="300" /></evars>', '1');
CREATE TABLE `swg_users` (
  `ddbusers_id` varchar(20) NOT NULL DEFAULT '',
  `ddbusers_type` varchar(2) NOT NULL DEFAULT 'me',
  `ddbusers_type_ex` varchar(50) DEFAULT NULL,
  `ddbusers_banned` char(1) NOT NULL DEFAULT '0',
  `ddbusers_deleted` char(1) NOT NULL DEFAULT '0',
  `ddbusers_locked` char(1) NOT NULL DEFAULT '1',
  `ddbusers_name` varchar(100) NOT NULL DEFAULT '',
  `ddbusers_password` varchar(96) NOT NULL DEFAULT '',
  `ddbusers_lang` varchar(20) NOT NULL,
  `ddbusers_theme` varchar(255) NOT NULL DEFAULT '',
  `ddbusers_email` varchar(255) NOT NULL DEFAULT '',
  `ddbusers_email_public` char(1) NOT NULL DEFAULT '0',
  `ddbusers_credits` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ddbusers_title` varchar(255) NOT NULL DEFAULT '',
  `ddbusers_avatar` varchar(255) NOT NULL DEFAULT '',
  `ddbusers_signature` text NOT NULL,
  `ddbusers_registration_ip` varchar(100) NOT NULL DEFAULT '',
  `ddbusers_registration_time` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ddbusers_secid` varchar(96) NOT NULL DEFAULT '',
  `ddbusers_lastvisit_ip` varchar(100) NOT NULL DEFAULT '',
  `ddbusers_lastvisit_time` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ddbusers_lastactivity_time` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ddbusers_rating` float NOT NULL DEFAULT '0',
  `ddbusers_timezone` tinyint(4) NOT NULL DEFAULT '2',
  PRIMARY KEY (`ddbusers_id`),
  KEY `ddbusers_credits` (`ddbusers_credits`),
  KEY `ddbusers_name` (`ddbusers_name`),
  KEY `ddbusers_lastvisit_time` (`ddbusers_lastvisit_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `swg_users` (`ddbusers_id`, `ddbusers_type`, `ddbusers_type_ex`, `ddbusers_banned`, `ddbusers_deleted`, `ddbusers_locked`, `ddbusers_name`, `ddbusers_password`, `ddbusers_lang`, `ddbusers_theme`, `ddbusers_email`, `ddbusers_email_public`, `ddbusers_credits`, `ddbusers_title`, `ddbusers_avatar`, `ddbusers_signature`, `ddbusers_registration_ip`, `ddbusers_registration_time`, `ddbusers_secid`, `ddbusers_lastvisit_ip`, `ddbusers_lastvisit_time`, `ddbusers_lastactivity_time`, `ddbusers_rating`, `ddbusers_timezone`, `ddbusers_description`, `ddbusers_pms_via_email`, `ddbusers_real_public`, `ddbusers_real_title`, `ddbusers_real_firstname`, `ddbusers_real_surname`, `ddbusers_real_address`, `ddbusers_real_country`, `ddbusers_aolopenauth_id`, `ddbusers_mslive_id`) VALUES
('dng', 'sm', NULL, '0', '1', '1', 'direct Netware Group', '', '', '', 'noreply@direct-netware.de', '0', 0, '', '', 'We are building the "secured WebGine"', 'unknown', 1081191985, '', 'unknown', 1081191985, 0, 0, 0, '', '0', '0', '', '', '', '', '', '', '');
CREATE TABLE `swg_uuids_list` (
  `ddbuuids_list_id` varchar(32) NOT NULL DEFAULT '',
  `ddbuuids_list_passcode_timeout` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ddbuuids_list_maxage_inactivity` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ddbuuids_list_ip` varchar(100) NOT NULL DEFAULT '',
  `ddbuuids_list_passcode` char(96) NOT NULL,
  `ddbuuids_list_passcode_prev` char(96) DEFAULT NULL,
  `ddbuuids_list_data` text NOT NULL,
  PRIMARY KEY (`ddbuuids_list_id`),
  KEY `ddbuuids_list_maxage_inactivity` (`ddbuuids_list_maxage_inactivity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;