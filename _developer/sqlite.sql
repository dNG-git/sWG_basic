PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE [swg_credits] (
ddbcredits_id VARCHAR(20) NOT NULL PRIMARY KEY,
ddbcredits_id_obj VARCHAR(20) DEFAULT '' NOT NULL,
ddbcredits_id_user VARCHAR(20) DEFAULT '' NOT NULL,
ddbcredits_controller VARCHAR(255) DEFAULT '' NOT NULL,
ddbcredits_identifier VARCHAR(255) DEFAULT '' NOT NULL,
ddbcredits_time REAL DEFAULT 0 NOT NULL,
ddbcredits_amount INTEGER DEFAULT 0 NOT NULL,
ddbcredits_counter INTEGER DEFAULT 0 NOT NULL);
CREATE TABLE [swg_credits_specials] (
ddbcredits_specials_id VARCHAR(20) NOT NULL PRIMARY KEY,
ddbcredits_specials_id_obj VARCHAR(32) DEFAULT '' NOT NULL,
ddbcredits_specials_group VARCHAR(20) DEFAULT '' NOT NULL,
ddbcredits_specials_onetime INTEGER DEFAULT 0 NOT NULL,
ddbcredits_specials_periodically INTEGER DEFAULT 0 NOT NULL);
CREATE TABLE [swg_data] (
ddbdata_id VARCHAR(20) NOT NULL PRIMARY KEY,
ddbdata_id_cat VARCHAR(20) DEFAULT '' NOT NULL,
ddbdata_owner VARCHAR(20) DEFAULT '' NOT NULL,
ddbdata_data TEXT DEFAULT '' NOT NULL,
ddbdata_sid VARCHAR(32) DEFAULT '' NOT NULL,
ddbdata_mode_user VARCHAR(1) DEFAULT '-' NOT NULL,
ddbdata_mode_group VARCHAR(1) DEFAULT '-' NOT NULL,
ddbdata_mode_all VARCHAR(1) DEFAULT '-' NOT NULL);
CREATE TABLE [swg_evars_archive] (
ddbevars_archive_id VARCHAR(20) NOT NULL PRIMARY KEY,
ddbevars_archive_data TEXT DEFAULT '' NOT NULL);
CREATE TABLE [swg_log] (
ddblog_id VARCHAR(20) PRIMARY KEY NOT NULL,
ddblog_source_id VARCHAR(20) DEFAULT '' NOT NULL,
ddblog_time REAL DEFAULT 0 NOT NULL,
ddblog_source_user_id VARCHAR(20) DEFAULT '' NOT NULL,
ddblog_source_user_ip VARCHAR(100) DEFAULT '' NOT NULL,
ddblog_target_user_id VARCHAR(20) DEFAULT '' NOT NULL,
ddblog_target_user_ip VARCHAR(100) DEFAULT '' NOT NULL,
ddblog_identifier VARCHAR(255) DEFAULT '' NOT NULL,
ddblog_sid VARCHAR(32) DEFAULT '' NOT NULL,
ddblog_data TEXT NULL,
ddblog_maintained CHAR(1) DEFAULT '1' NOT NULL,
ddblog_customdata_id VARCHAR(20) DEFAULT '' NOT NULL);
CREATE TABLE [swg_tmp_storage] (
ddbtmp_storage_id VARCHAR(96) PRIMARY KEY NOT NULL,
ddbtmp_storage_time_min REAL DEFAULT 0 NOT NULL,
ddbtmp_storage_time_max REAL DEFAULT 0 NOT NULL,
ddbtmp_storage_sid VARCHAR(32) DEFAULT '' NOT NULL,
ddbtmp_storage_identifier VARCHAR(255) DEFAULT '' NOT NULL,
ddbtmp_storage_data TEXT DEFAULT '' NOT NULL,
ddbtmp_storage_maintained VARCHAR(1) DEFAULT '0' NOT NULL);
INSERT INTO "swg_tmp_storage" VALUES('510bf66f710451edf184365b1fb3cadfe3699b03e25829bde24980fe1407745ca19c12c0233aced0218072f71e13252e',1081191985.0,1081191985.0,'9d3bb895f22bf0afa958d68c2a58ded7','auto_maintenance','<evars><job_identifier value="cron_auto_maintenance" /><job_control_file value="swgi_auto_maintenance.php" /><job_ignore_limit value="1" /><loop value="1" /><loop_interval value="300" /></evars>','1');
CREATE TABLE [swg_users] (
ddbusers_id VARCHAR(20) PRIMARY KEY NOT NULL,
ddbusers_type VARCHAR(2) DEFAULT 'me' NOT NULL,
ddbusers_type_ex VARCHAR(50) NULL,
ddbusers_banned VARCHAR(1) DEFAULT '0' NOT NULL,
ddbusers_deleted VARCHAR(1) DEFAULT '0' NOT NULL,
ddbusers_locked VARCHAR(1) DEFAULT '1' NOT NULL,
ddbusers_name VARCHAR(100) DEFAULT '' NOT NULL,
ddbusers_password VARCHAR(96) DEFAULT '' NOT NULL,
ddbusers_lang VARCHAR(2) DEFAULT '' NOT NULL,
ddbusers_theme VARCHAR(255) DEFAULT '' NOT NULL,
ddbusers_email VARCHAR(255) DEFAULT '' NOT NULL,
ddbusers_email_public VARCHAR(1) DEFAULT '0' NOT NULL,
ddbusers_credits REAL DEFAULT 0 NOT NULL,
ddbusers_title VARCHAR(255) DEFAULT '' NOT NULL,
ddbusers_avatar VARCHAR(255) DEFAULT '' NOT NULL,
ddbusers_signature TEXT DEFAULT '' NOT NULL,
ddbusers_registration_ip VARCHAR(100) DEFAULT '' NOT NULL,
ddbusers_registration_time REAL DEFAULT 0 NOT NULL,
ddbusers_secid VARCHAR(96) DEFAULT '' NOT NULL,
ddbusers_lastvisit_ip VARCHAR(100) DEFAULT '' NOT NULL,
ddbusers_lastvisit_time REAL DEFAULT 0 NOT NULL,
ddbusers_lastactivity_time REAL DEFAULT 0 NOT NULL,
ddbusers_rating REAL DEFAULT 0 NOT NULL,
ddbusers_timezone INTEGER DEFAULT 2 NOT NULL);
INSERT INTO "swg_users" VALUES('dng','sm',NULL,'0','1','1','direct Netware Group','','','','noreply@direct-netware.de','0',0.0,'','','We are building the "secured WebGine"','unknown',1081191985.0,'','unknown',1081191985.0,1081191985.0,0.0,0);
CREATE TABLE [swg_uuids_list] (
ddbuuids_list_id VARCHAR(32) PRIMARY KEY NOT NULL,
ddbuuids_list_passcode_timeout REAL DEFAULT 0 NOT NULL,
ddbuuids_list_maxage_inactivity REAL DEFAULT 0 NOT NULL,
ddbuuids_list_ip VARCHAR(100) DEFAULT '' NOT NULL,
ddbuuids_list_passcode CHAR(96) DEFAULT '' NOT NULL,
ddbuuids_list_passcode_prev CHAR(96) NULL,
ddbuuids_list_data TEXT DEFAULT '' NOT NULL);
CREATE INDEX "sqli_idx_ddbcredits_controller" ON [swg_credits] (ddbcredits_controller ASC);
CREATE INDEX "sqli_idx_ddbcredits_id_obj" ON [swg_credits] (ddbcredits_id_obj ASC);
CREATE INDEX "sqli_idx_ddbcredits_identifier" ON [swg_credits] (ddbcredits_identifier ASC);
CREATE INDEX "sqli_idx_ddbcredits_time" ON [swg_credits] (ddbcredits_time ASC);
CREATE INDEX "sqli_idx_ddbcredits_specials_id_obj" ON [swg_credits_specials] (ddbcredits_specials_id_obj ASC);
CREATE INDEX "sqli_idx_ddbdata_data" ON [swg_data] (ddbdata_data ASC);
CREATE INDEX "sqli_idx_ddbdata_id_cat" ON [swg_data] (ddbdata_id_cat ASC);
CREATE INDEX "sqli_idx_ddbdata_sid" ON [swg_data] (ddbdata_sid ASC);
CREATE INDEX "sqli_idx_ddblog_source_id" on [swg_log] (ddblog_source_id ASC);
CREATE INDEX "sqli_idx_ddblog_maintained" on [swg_log] (ddblog_maintained ASC);
CREATE INDEX "sqli_idx_ddbtmp_storage_maintained" ON [swg_tmp_storage] (ddbtmp_storage_maintained ASC);
CREATE INDEX "sqli_idx_ddbtmp_storage_time_max" ON [swg_tmp_storage] (ddbtmp_storage_time_max ASC);
CREATE INDEX "sqli_idx_ddbtmp_storage_time_min" ON [swg_tmp_storage] (ddbtmp_storage_time_min ASC);
CREATE INDEX "sqli_idx_ddbusers_credits" ON [swg_users] (ddbusers_credits ASC);
CREATE INDEX "sqli_idx_ddbusers_name" ON [swg_users] (ddbusers_name ASC);
CREATE INDEX "sqli_idx_ddbusers_lastvisit_time" ON [swg_users] (ddbusers_lastvisit_time ASC);
CREATE INDEX "sqli_idx_ddbuuids_list_maxage_inactivity" ON [swg_uuids_list] (ddbuuids_list_maxage_inactivity ASC);
COMMIT;