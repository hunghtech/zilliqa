/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : zilliqa-2019

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-09-24 21:38:39
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `backend_access_log`
-- ----------------------------
DROP TABLE IF EXISTS `backend_access_log`;
CREATE TABLE `backend_access_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of backend_access_log
-- ----------------------------
INSERT INTO backend_access_log VALUES ('1', '1', '127.0.0.1', '2019-09-23 13:33:52', '2019-09-23 13:33:52');

-- ----------------------------
-- Table structure for `backend_users`
-- ----------------------------
DROP TABLE IF EXISTS `backend_users`;
CREATE TABLE `backend_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activation_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persist_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `is_activated` tinyint(1) NOT NULL DEFAULT '0',
  `role_id` int(10) unsigned DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_superuser` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_unique` (`login`),
  UNIQUE KEY `email_unique` (`email`),
  KEY `act_code_index` (`activation_code`),
  KEY `reset_code_index` (`reset_password_code`),
  KEY `admin_role_index` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of backend_users
-- ----------------------------
INSERT INTO backend_users VALUES ('1', 'Sys', 'Admin', 'sysadmin', 'hungdn0502@gmail.com', '$2y$10$2kt9m6D5ba/NpxXjghGC8OkJvejVcdD0eTc9btBmj3ySt/mSnBuDq', null, '$2y$10$y1fprpfBgfiW2DT14oDqwetbgCZZsPKMBA5mJTJECFWeKEttI2vEC', null, '', '1', '2', null, '2019-09-23 13:33:52', '2019-09-23 13:28:02', '2019-09-23 13:33:52', null, '1');

-- ----------------------------
-- Table structure for `backend_users_groups`
-- ----------------------------
DROP TABLE IF EXISTS `backend_users_groups`;
CREATE TABLE `backend_users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `user_group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`user_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of backend_users_groups
-- ----------------------------
INSERT INTO backend_users_groups VALUES ('1', '1');

-- ----------------------------
-- Table structure for `backend_user_groups`
-- ----------------------------
DROP TABLE IF EXISTS `backend_user_groups`;
CREATE TABLE `backend_user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_new_user_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_unique` (`name`),
  KEY `code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of backend_user_groups
-- ----------------------------
INSERT INTO backend_user_groups VALUES ('1', 'Owners', '2019-09-23 13:28:02', '2019-09-23 13:28:02', 'owners', 'Default group for website owners.', '0');

-- ----------------------------
-- Table structure for `backend_user_preferences`
-- ----------------------------
DROP TABLE IF EXISTS `backend_user_preferences`;
CREATE TABLE `backend_user_preferences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `namespace` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_item_index` (`user_id`,`namespace`,`group`,`item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of backend_user_preferences
-- ----------------------------

-- ----------------------------
-- Table structure for `backend_user_roles`
-- ----------------------------
DROP TABLE IF EXISTS `backend_user_roles`;
CREATE TABLE `backend_user_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_unique` (`name`),
  KEY `role_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of backend_user_roles
-- ----------------------------
INSERT INTO backend_user_roles VALUES ('1', 'Publisher', 'publisher', 'Site editor with access to publishing tools.', '', '1', '2019-09-23 13:28:02', '2019-09-23 13:28:02');
INSERT INTO backend_user_roles VALUES ('2', 'Developer', 'developer', 'Site administrator with access to developer tools.', '', '1', '2019-09-23 13:28:02', '2019-09-23 13:28:02');

-- ----------------------------
-- Table structure for `backend_user_throttle`
-- ----------------------------
DROP TABLE IF EXISTS `backend_user_throttle`;
CREATE TABLE `backend_user_throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `is_suspended` tinyint(1) NOT NULL DEFAULT '0',
  `suspended_at` timestamp NULL DEFAULT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `backend_user_throttle_user_id_index` (`user_id`),
  KEY `backend_user_throttle_ip_address_index` (`ip_address`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of backend_user_throttle
-- ----------------------------
INSERT INTO backend_user_throttle VALUES ('1', '1', '127.0.0.1', '0', null, '0', null, '0', null);

-- ----------------------------
-- Table structure for `cache`
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  UNIQUE KEY `cache_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_theme_data`
-- ----------------------------
DROP TABLE IF EXISTS `cms_theme_data`;
CREATE TABLE `cms_theme_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cms_theme_data_theme_index` (`theme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cms_theme_data
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_theme_logs`
-- ----------------------------
DROP TABLE IF EXISTS `cms_theme_logs`;
CREATE TABLE `cms_theme_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_template` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `old_content` longtext COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cms_theme_logs_type_index` (`type`),
  KEY `cms_theme_logs_theme_index` (`theme`),
  KEY `cms_theme_logs_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cms_theme_logs
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_theme_templates`
-- ----------------------------
DROP TABLE IF EXISTS `cms_theme_templates`;
CREATE TABLE `cms_theme_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `source` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int(10) unsigned NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cms_theme_templates_source_index` (`source`),
  KEY `cms_theme_templates_path_index` (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cms_theme_templates
-- ----------------------------

-- ----------------------------
-- Table structure for `deferred_bindings`
-- ----------------------------
DROP TABLE IF EXISTS `deferred_bindings`;
CREATE TABLE `deferred_bindings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `master_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `master_field` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slave_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slave_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_bind` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deferred_bindings_master_type_index` (`master_type`),
  KEY `deferred_bindings_master_field_index` (`master_field`),
  KEY `deferred_bindings_slave_type_index` (`slave_type`),
  KEY `deferred_bindings_slave_id_index` (`slave_id`),
  KEY `deferred_bindings_session_key_index` (`session_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of deferred_bindings
-- ----------------------------

-- ----------------------------
-- Table structure for `failed_jobs`
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci,
  `failed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for `jobs`
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO migrations VALUES ('1', '2013_10_01_000001_Db_Deferred_Bindings', '1');
INSERT INTO migrations VALUES ('2', '2013_10_01_000002_Db_System_Files', '1');
INSERT INTO migrations VALUES ('3', '2013_10_01_000003_Db_System_Plugin_Versions', '1');
INSERT INTO migrations VALUES ('4', '2013_10_01_000004_Db_System_Plugin_History', '1');
INSERT INTO migrations VALUES ('5', '2013_10_01_000005_Db_System_Settings', '1');
INSERT INTO migrations VALUES ('6', '2013_10_01_000006_Db_System_Parameters', '1');
INSERT INTO migrations VALUES ('7', '2013_10_01_000007_Db_System_Add_Disabled_Flag', '1');
INSERT INTO migrations VALUES ('8', '2013_10_01_000008_Db_System_Mail_Templates', '1');
INSERT INTO migrations VALUES ('9', '2013_10_01_000009_Db_System_Mail_Layouts', '1');
INSERT INTO migrations VALUES ('10', '2014_10_01_000010_Db_Jobs', '1');
INSERT INTO migrations VALUES ('11', '2014_10_01_000011_Db_System_Event_Logs', '1');
INSERT INTO migrations VALUES ('12', '2014_10_01_000012_Db_System_Request_Logs', '1');
INSERT INTO migrations VALUES ('13', '2014_10_01_000013_Db_System_Sessions', '1');
INSERT INTO migrations VALUES ('14', '2015_10_01_000014_Db_System_Mail_Layout_Rename', '1');
INSERT INTO migrations VALUES ('15', '2015_10_01_000015_Db_System_Add_Frozen_Flag', '1');
INSERT INTO migrations VALUES ('16', '2015_10_01_000016_Db_Cache', '1');
INSERT INTO migrations VALUES ('17', '2015_10_01_000017_Db_System_Revisions', '1');
INSERT INTO migrations VALUES ('18', '2015_10_01_000018_Db_FailedJobs', '1');
INSERT INTO migrations VALUES ('19', '2016_10_01_000019_Db_System_Plugin_History_Detail_Text', '1');
INSERT INTO migrations VALUES ('20', '2016_10_01_000020_Db_System_Timestamp_Fix', '1');
INSERT INTO migrations VALUES ('21', '2017_08_04_121309_Db_Deferred_Bindings_Add_Index_Session', '1');
INSERT INTO migrations VALUES ('22', '2017_10_01_000021_Db_System_Sessions_Update', '1');
INSERT INTO migrations VALUES ('23', '2017_10_01_000022_Db_Jobs_FailedJobs_Update', '1');
INSERT INTO migrations VALUES ('24', '2017_10_01_000023_Db_System_Mail_Partials', '1');
INSERT INTO migrations VALUES ('25', '2017_10_23_000024_Db_System_Mail_Layouts_Add_Options_Field', '1');
INSERT INTO migrations VALUES ('26', '2013_10_01_000001_Db_Backend_Users', '2');
INSERT INTO migrations VALUES ('27', '2013_10_01_000002_Db_Backend_User_Groups', '2');
INSERT INTO migrations VALUES ('28', '2013_10_01_000003_Db_Backend_Users_Groups', '2');
INSERT INTO migrations VALUES ('29', '2013_10_01_000004_Db_Backend_User_Throttle', '2');
INSERT INTO migrations VALUES ('30', '2014_01_04_000005_Db_Backend_User_Preferences', '2');
INSERT INTO migrations VALUES ('31', '2014_10_01_000006_Db_Backend_Access_Log', '2');
INSERT INTO migrations VALUES ('32', '2014_10_01_000007_Db_Backend_Add_Description_Field', '2');
INSERT INTO migrations VALUES ('33', '2015_10_01_000008_Db_Backend_Add_Superuser_Flag', '2');
INSERT INTO migrations VALUES ('34', '2016_10_01_000009_Db_Backend_Timestamp_Fix', '2');
INSERT INTO migrations VALUES ('35', '2017_10_01_000010_Db_Backend_User_Roles', '2');
INSERT INTO migrations VALUES ('36', '2018_12_16_000011_Db_Backend_Add_Deleted_At', '2');
INSERT INTO migrations VALUES ('37', '2014_10_01_000001_Db_Cms_Theme_Data', '3');
INSERT INTO migrations VALUES ('38', '2016_10_01_000002_Db_Cms_Timestamp_Fix', '3');
INSERT INTO migrations VALUES ('39', '2017_10_01_000003_Db_Cms_Theme_Logs', '3');
INSERT INTO migrations VALUES ('40', '2018_11_01_000001_Db_Cms_Theme_Templates', '3');

-- ----------------------------
-- Table structure for `rainlab_user_mail_blockers`
-- ----------------------------
DROP TABLE IF EXISTS `rainlab_user_mail_blockers`;
CREATE TABLE `rainlab_user_mail_blockers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rainlab_user_mail_blockers_email_index` (`email`),
  KEY `rainlab_user_mail_blockers_template_index` (`template`),
  KEY `rainlab_user_mail_blockers_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of rainlab_user_mail_blockers
-- ----------------------------

-- ----------------------------
-- Table structure for `sessions`
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci,
  `last_activity` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------

-- ----------------------------
-- Table structure for `system_event_logs`
-- ----------------------------
DROP TABLE IF EXISTS `system_event_logs`;
CREATE TABLE `system_event_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `details` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_event_logs_level_index` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of system_event_logs
-- ----------------------------

-- ----------------------------
-- Table structure for `system_files`
-- ----------------------------
DROP TABLE IF EXISTS `system_files`;
CREATE TABLE `system_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `disk_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int(11) NOT NULL,
  `content_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `field` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_files_field_index` (`field`),
  KEY `system_files_attachment_id_index` (`attachment_id`),
  KEY `system_files_attachment_type_index` (`attachment_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of system_files
-- ----------------------------

-- ----------------------------
-- Table structure for `system_mail_layouts`
-- ----------------------------
DROP TABLE IF EXISTS `system_mail_layouts`;
CREATE TABLE `system_mail_layouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_html` text COLLATE utf8mb4_unicode_ci,
  `content_text` text COLLATE utf8mb4_unicode_ci,
  `content_css` text COLLATE utf8mb4_unicode_ci,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `options` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of system_mail_layouts
-- ----------------------------
INSERT INTO system_mail_layouts VALUES ('1', 'Default layout', 'default', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n</head>\n<body>\n    <style type=\"text/css\" media=\"screen\">\n        {{ brandCss|raw }}\n        {{ css|raw }}\n    </style>\n\n    <table class=\"wrapper layout-default\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n\n        <!-- Header -->\n        {% partial \'header\' body %}\n            {{ subject|raw }}\n        {% endpartial %}\n\n        <tr>\n            <td align=\"center\">\n                <table class=\"content\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n                    <!-- Email Body -->\n                    <tr>\n                        <td class=\"body\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n                            <table class=\"inner-body\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\">\n                                <!-- Body content -->\n                                <tr>\n                                    <td class=\"content-cell\">\n                                        {{ content|raw }}\n                                    </td>\n                                </tr>\n                            </table>\n                        </td>\n                    </tr>\n                </table>\n            </td>\n        </tr>\n\n        <!-- Footer -->\n        {% partial \'footer\' body %}\n            &copy; {{ \"now\"|date(\"Y\") }} {{ appName }}. All rights reserved.\n        {% endpartial %}\n\n    </table>\n\n</body>\n</html>', '{{ content|raw }}', '@media only screen and (max-width: 600px) {\n    .inner-body {\n        width: 100% !important;\n    }\n\n    .footer {\n        width: 100% !important;\n    }\n}\n\n@media only screen and (max-width: 500px) {\n    .button {\n        width: 100% !important;\n    }\n}', '1', null, '2019-09-23 13:28:02', '2019-09-23 13:28:02');
INSERT INTO system_mail_layouts VALUES ('2', 'System layout', 'system', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n</head>\n<body>\n    <style type=\"text/css\" media=\"screen\">\n        {{ brandCss|raw }}\n        {{ css|raw }}\n    </style>\n\n    <table class=\"wrapper layout-system\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n        <tr>\n            <td align=\"center\">\n                <table class=\"content\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n                    <!-- Email Body -->\n                    <tr>\n                        <td class=\"body\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n                            <table class=\"inner-body\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\">\n                                <!-- Body content -->\n                                <tr>\n                                    <td class=\"content-cell\">\n                                        {{ content|raw }}\n\n                                        <!-- Subcopy -->\n                                        {% partial \'subcopy\' body %}\n                                            **This is an automatic message. Please do not reply to it.**\n                                        {% endpartial %}\n                                    </td>\n                                </tr>\n                            </table>\n                        </td>\n                    </tr>\n                </table>\n            </td>\n        </tr>\n    </table>\n\n</body>\n</html>', '{{ content|raw }}\n\n\n---\nThis is an automatic message. Please do not reply to it.', '@media only screen and (max-width: 600px) {\n    .inner-body {\n        width: 100% !important;\n    }\n\n    .footer {\n        width: 100% !important;\n    }\n}\n\n@media only screen and (max-width: 500px) {\n    .button {\n        width: 100% !important;\n    }\n}', '1', null, '2019-09-23 13:28:02', '2019-09-23 13:28:02');

-- ----------------------------
-- Table structure for `system_mail_partials`
-- ----------------------------
DROP TABLE IF EXISTS `system_mail_partials`;
CREATE TABLE `system_mail_partials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_html` text COLLATE utf8mb4_unicode_ci,
  `content_text` text COLLATE utf8mb4_unicode_ci,
  `is_custom` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of system_mail_partials
-- ----------------------------

-- ----------------------------
-- Table structure for `system_mail_templates`
-- ----------------------------
DROP TABLE IF EXISTS `system_mail_templates`;
CREATE TABLE `system_mail_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content_html` text COLLATE utf8mb4_unicode_ci,
  `content_text` text COLLATE utf8mb4_unicode_ci,
  `layout_id` int(11) DEFAULT NULL,
  `is_custom` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_mail_templates_layout_id_index` (`layout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of system_mail_templates
-- ----------------------------

-- ----------------------------
-- Table structure for `system_parameters`
-- ----------------------------
DROP TABLE IF EXISTS `system_parameters`;
CREATE TABLE `system_parameters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namespace` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `item_index` (`namespace`,`group`,`item`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of system_parameters
-- ----------------------------
INSERT INTO system_parameters VALUES ('1', 'system', 'update', 'count', '0');
INSERT INTO system_parameters VALUES ('2', 'system', 'update', 'retry', '1569332036');

-- ----------------------------
-- Table structure for `system_plugin_history`
-- ----------------------------
DROP TABLE IF EXISTS `system_plugin_history`;
CREATE TABLE `system_plugin_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_plugin_history_code_index` (`code`),
  KEY `system_plugin_history_type_index` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of system_plugin_history
-- ----------------------------
INSERT INTO system_plugin_history VALUES ('1', 'October.Demo', 'comment', '1.0.1', 'First version of Demo', '2019-09-23 13:28:01');
INSERT INTO system_plugin_history VALUES ('2', 'RainLab.User', 'script', '1.0.1', 'create_users_table.php', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('3', 'RainLab.User', 'script', '1.0.1', 'create_throttle_table.php', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('4', 'RainLab.User', 'comment', '1.0.1', 'Initialize plugin.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('5', 'RainLab.User', 'comment', '1.0.2', 'Seed tables.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('6', 'RainLab.User', 'comment', '1.0.3', 'Translated hard-coded text to language strings.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('7', 'RainLab.User', 'comment', '1.0.4', 'Improvements to user-interface for Location manager.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('8', 'RainLab.User', 'comment', '1.0.5', 'Added contact details for users.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('9', 'RainLab.User', 'script', '1.0.6', 'create_mail_blockers_table.php', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('10', 'RainLab.User', 'comment', '1.0.6', 'Added Mail Blocker utility so users can block specific mail templates.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('11', 'RainLab.User', 'comment', '1.0.7', 'Add back-end Settings page.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('12', 'RainLab.User', 'comment', '1.0.8', 'Updated the Settings page.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('13', 'RainLab.User', 'comment', '1.0.9', 'Adds new welcome mail message for users and administrators.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('14', 'RainLab.User', 'comment', '1.0.10', 'Adds administrator-only activation mode.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('15', 'RainLab.User', 'script', '1.0.11', 'users_add_login_column.php', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('16', 'RainLab.User', 'comment', '1.0.11', 'Users now have an optional login field that defaults to the email field.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('17', 'RainLab.User', 'script', '1.0.12', 'users_rename_login_to_username.php', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('18', 'RainLab.User', 'comment', '1.0.12', 'Create a dedicated setting for choosing the login mode.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('19', 'RainLab.User', 'comment', '1.0.13', 'Minor fix to the Account sign in logic.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('20', 'RainLab.User', 'comment', '1.0.14', 'Minor improvements to the code.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('21', 'RainLab.User', 'script', '1.0.15', 'users_add_surname.php', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('22', 'RainLab.User', 'comment', '1.0.15', 'Adds last name column to users table (surname).', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('23', 'RainLab.User', 'comment', '1.0.16', 'Require permissions for settings page too.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('24', 'RainLab.User', 'comment', '1.1.0', '!!! Profile fields and Locations have been removed.', '2019-09-23 13:34:35');
INSERT INTO system_plugin_history VALUES ('25', 'RainLab.User', 'script', '1.1.1', 'create_user_groups_table.php', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('26', 'RainLab.User', 'script', '1.1.1', 'seed_user_groups_table.php', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('27', 'RainLab.User', 'comment', '1.1.1', 'Users can now be added to groups.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('28', 'RainLab.User', 'comment', '1.1.2', 'A raw URL can now be passed as the redirect property in the Account component.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('29', 'RainLab.User', 'comment', '1.1.3', 'Adds a super user flag to the users table, reserved for future use.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('30', 'RainLab.User', 'comment', '1.1.4', 'User list can be filtered by the group they belong to.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('31', 'RainLab.User', 'comment', '1.1.5', 'Adds a new permission to hide the User settings menu item.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('32', 'RainLab.User', 'script', '1.2.0', 'users_add_deleted_at.php', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('33', 'RainLab.User', 'comment', '1.2.0', 'Users can now deactivate their own accounts.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('34', 'RainLab.User', 'comment', '1.2.1', 'New feature for checking if a user is recently active/online.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('35', 'RainLab.User', 'comment', '1.2.2', 'Add bulk action button to user list.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('36', 'RainLab.User', 'comment', '1.2.3', 'Included some descriptive paragraphs in the Reset Password component markup.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('37', 'RainLab.User', 'comment', '1.2.4', 'Added a checkbox for blocking all mail sent to the user.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('38', 'RainLab.User', 'script', '1.2.5', 'update_timestamp_nullable.php', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('39', 'RainLab.User', 'comment', '1.2.5', 'Database maintenance. Updated all timestamp columns to be nullable.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('40', 'RainLab.User', 'script', '1.2.6', 'users_add_last_seen.php', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('41', 'RainLab.User', 'comment', '1.2.6', 'Add a dedicated last seen column for users.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('42', 'RainLab.User', 'comment', '1.2.7', 'Minor fix to user timestamp attributes.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('43', 'RainLab.User', 'comment', '1.2.8', 'Add date range filter to users list. Introduced a logout event.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('44', 'RainLab.User', 'comment', '1.2.9', 'Add invitation mail for new accounts created in the back-end.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('45', 'RainLab.User', 'script', '1.3.0', 'users_add_guest_flag.php', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('46', 'RainLab.User', 'script', '1.3.0', 'users_add_superuser_flag.php', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('47', 'RainLab.User', 'comment', '1.3.0', 'Introduced guest user accounts.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('48', 'RainLab.User', 'comment', '1.3.1', 'User notification variables can now be extended.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('49', 'RainLab.User', 'comment', '1.3.2', 'Minor fix to the Auth::register method.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('50', 'RainLab.User', 'comment', '1.3.3', 'Allow prevention of concurrent user sessions via the user settings.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('51', 'RainLab.User', 'comment', '1.3.4', 'Added force secure protocol property to the account component.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('52', 'RainLab.User', 'comment', '1.4.0', '!!! The Notifications tab in User settings has been removed.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('53', 'RainLab.User', 'comment', '1.4.1', 'Added support for user impersonation.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('54', 'RainLab.User', 'comment', '1.4.2', 'Fixes security bug in Password Reset component.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('55', 'RainLab.User', 'comment', '1.4.3', 'Fixes session handling for AJAX requests.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('56', 'RainLab.User', 'comment', '1.4.4', 'Fixes bug where impersonation touches the last seen timestamp.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('57', 'RainLab.User', 'comment', '1.4.5', 'Added token fallback process to Account / Reset Password components when parameter is missing.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('58', 'RainLab.User', 'comment', '1.4.6', 'Fixes Auth::register method signature mismatch with core OctoberCMS Auth library', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('59', 'RainLab.User', 'comment', '1.4.7', 'Fixes redirect bug in Account component / Update translations and separate user and group management.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('60', 'RainLab.User', 'comment', '1.4.8', 'Fixes a bug where calling MailBlocker::removeBlock could remove all mail blocks for the user.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('61', 'RainLab.User', 'comment', '1.5.0', '!!! Required password length is now a minimum of 8 characters. Previous passwords will not be affected until the next password change.', '2019-09-23 13:34:36');
INSERT INTO system_plugin_history VALUES ('62', 'RainLab.Builder', 'comment', '1.0.1', 'Initialize plugin.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('63', 'RainLab.Builder', 'comment', '1.0.2', 'Fixes the problem with selecting a plugin. Minor localization corrections. Configuration files in the list and form behaviors are now autocomplete.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('64', 'RainLab.Builder', 'comment', '1.0.3', 'Improved handling of the enum data type.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('65', 'RainLab.Builder', 'comment', '1.0.4', 'Added user permissions to work with the Builder.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('66', 'RainLab.Builder', 'comment', '1.0.5', 'Fixed permissions registration.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('67', 'RainLab.Builder', 'comment', '1.0.6', 'Fixed front-end record ordering in the Record List component.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('68', 'RainLab.Builder', 'comment', '1.0.7', 'Builder settings are now protected with user permissions. The database table column list is scrollable now. Minor code cleanup.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('69', 'RainLab.Builder', 'comment', '1.0.8', 'Added the Reorder Controller behavior.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('70', 'RainLab.Builder', 'comment', '1.0.9', 'Minor API and UI updates.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('71', 'RainLab.Builder', 'comment', '1.0.10', 'Minor styling update.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('72', 'RainLab.Builder', 'comment', '1.0.11', 'Fixed a bug where clicking placeholder in a repeater would open Inspector. Fixed a problem with saving forms with repeaters in tabs. Minor style fix.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('73', 'RainLab.Builder', 'comment', '1.0.12', 'Added support for the Trigger property to the Media Finder widget configuration. Names of form fields and list columns definition files can now contain underscores.', '2019-09-23 13:35:03');
INSERT INTO system_plugin_history VALUES ('74', 'RainLab.Builder', 'comment', '1.0.13', 'Minor styling fix on the database editor.', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('75', 'RainLab.Builder', 'comment', '1.0.14', 'Added support for published_at timestamp field', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('76', 'RainLab.Builder', 'comment', '1.0.15', 'Fixed a bug where saving a localization string in Inspector could cause a JavaScript error. Added support for Timestamps and Soft Deleting for new models.', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('77', 'RainLab.Builder', 'comment', '1.0.16', 'Fixed a bug when saving a form with the Repeater widget in a tab could create invalid fields in the form\'s outside area. Added a check that prevents creating localization strings inside other existing strings.', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('78', 'RainLab.Builder', 'comment', '1.0.17', 'Added support Trigger attribute support for RecordFinder and Repeater form widgets.', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('79', 'RainLab.Builder', 'comment', '1.0.18', 'Fixes a bug where \'::class\' notations in a model class definition could prevent the model from appearing in the Builder model list. Added emptyOption property support to the dropdown form control.', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('80', 'RainLab.Builder', 'comment', '1.0.19', 'Added a feature allowing to add all database columns to a list definition. Added max length validation for database table and column names.', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('81', 'RainLab.Builder', 'comment', '1.0.20', 'Fixes a bug where form the builder could trigger the \"current.hasAttribute is not a function\" error.', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('82', 'RainLab.Builder', 'comment', '1.0.21', 'Back-end navigation sort order updated.', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('83', 'RainLab.Builder', 'comment', '1.0.22', 'Added scopeValue property to the RecordList component.', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('84', 'RainLab.Builder', 'comment', '1.0.23', 'Added support for balloon-selector field type, added Brazilian Portuguese translation, fixed some bugs', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('85', 'RainLab.Builder', 'comment', '1.0.24', 'Added support for tag list field type, added read only toggle for fields. Prevent plugins from using reserved PHP keywords for class names and namespaces', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('86', 'RainLab.Builder', 'comment', '1.0.25', 'Allow editing of migration code in the \"Migration\" popup when saving changes in the database editor.', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('87', 'RainLab.Builder', 'comment', '1.0.26', 'Allow special default values for columns and added new \"Add ID column\" button to database editor.', '2019-09-23 13:35:04');
INSERT INTO system_plugin_history VALUES ('88', 'Zilliqa.Backend', 'comment', '1.0.1', 'First version of Backend', '2019-09-24 13:45:39');
INSERT INTO system_plugin_history VALUES ('89', 'Zilliqa.Backend', 'script', '1.0.2', 'builder_table_create_zilliqa_backend_lending_package.php', '2019-09-24 13:45:39');
INSERT INTO system_plugin_history VALUES ('90', 'Zilliqa.Backend', 'comment', '1.0.2', 'Created table zilliqa_backend_lending_package', '2019-09-24 13:45:39');
INSERT INTO system_plugin_history VALUES ('91', 'Zilliqa.Backend', 'script', '1.0.3', 'builder_table_create_zilliqa_backend_history_deposit.php', '2019-09-24 13:47:50');
INSERT INTO system_plugin_history VALUES ('92', 'Zilliqa.Backend', 'comment', '1.0.3', 'Created table zilliqa_backend_history_deposit', '2019-09-24 13:47:50');
INSERT INTO system_plugin_history VALUES ('93', 'Zilliqa.Backend', 'script', '1.0.4', 'builder_table_create_zilliqa_backend_history_with_draw.php', '2019-09-24 13:49:11');
INSERT INTO system_plugin_history VALUES ('94', 'Zilliqa.Backend', 'comment', '1.0.4', 'Created table zilliqa_backend_history_with_draw', '2019-09-24 13:49:11');
INSERT INTO system_plugin_history VALUES ('95', 'Zilliqa.Backend', 'script', '1.0.5', 'builder_table_create_zilliqa_backend_user_lending.php', '2019-09-24 14:23:44');
INSERT INTO system_plugin_history VALUES ('96', 'Zilliqa.Backend', 'comment', '1.0.5', 'Created table zilliqa_backend_user_lending', '2019-09-24 14:23:44');
INSERT INTO system_plugin_history VALUES ('97', 'Zilliqa.Backend', 'script', '1.0.6', 'builder_table_update_zilliqa_backend_history_with_draw.php', '2019-09-24 14:24:02');
INSERT INTO system_plugin_history VALUES ('98', 'Zilliqa.Backend', 'comment', '1.0.6', 'Updated table zilliqa_backend_history_with_draw', '2019-09-24 14:24:02');
INSERT INTO system_plugin_history VALUES ('99', 'Zilliqa.Backend', 'script', '1.0.7', 'builder_table_create_zilliqa_backend_presenter.php', '2019-09-24 14:26:38');
INSERT INTO system_plugin_history VALUES ('100', 'Zilliqa.Backend', 'comment', '1.0.7', 'Created table zilliqa_backend_presenter', '2019-09-24 14:26:38');
INSERT INTO system_plugin_history VALUES ('101', 'RainLab.User', 'script', '1.5.1', 'users_add_user_code.php', '2019-09-24 14:37:35');
INSERT INTO system_plugin_history VALUES ('102', 'RainLab.User', 'comment', '1.5.1', 'Users Add user code, info zil address.', '2019-09-24 14:37:35');

-- ----------------------------
-- Table structure for `system_plugin_versions`
-- ----------------------------
DROP TABLE IF EXISTS `system_plugin_versions`;
CREATE TABLE `system_plugin_versions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `is_disabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_frozen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `system_plugin_versions_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of system_plugin_versions
-- ----------------------------
INSERT INTO system_plugin_versions VALUES ('1', 'October.Demo', '1.0.1', '2019-09-23 13:28:01', '0', '0');
INSERT INTO system_plugin_versions VALUES ('2', 'RainLab.User', '1.5.1', '2019-09-24 14:37:35', '0', '0');
INSERT INTO system_plugin_versions VALUES ('3', 'RainLab.Builder', '1.0.26', '2019-09-23 13:35:04', '0', '0');
INSERT INTO system_plugin_versions VALUES ('4', 'Zilliqa.Backend', '1.0.7', '2019-09-24 14:26:38', '0', '0');

-- ----------------------------
-- Table structure for `system_request_logs`
-- ----------------------------
DROP TABLE IF EXISTS `system_request_logs`;
CREATE TABLE `system_request_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status_code` int(11) DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referer` text COLLATE utf8mb4_unicode_ci,
  `count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of system_request_logs
-- ----------------------------

-- ----------------------------
-- Table structure for `system_revisions`
-- ----------------------------
DROP TABLE IF EXISTS `system_revisions`;
CREATE TABLE `system_revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `field` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cast` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci,
  `new_value` text COLLATE utf8mb4_unicode_ci,
  `revisionable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revisionable_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_revisions_revisionable_id_revisionable_type_index` (`revisionable_id`,`revisionable_type`),
  KEY `system_revisions_user_id_index` (`user_id`),
  KEY `system_revisions_field_index` (`field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of system_revisions
-- ----------------------------

-- ----------------------------
-- Table structure for `system_settings`
-- ----------------------------
DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE `system_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `system_settings_item_index` (`item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of system_settings
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activation_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persist_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `is_activated` tinyint(1) NOT NULL DEFAULT '0',
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `is_guest` tinyint(1) NOT NULL DEFAULT '0',
  `is_superuser` tinyint(1) NOT NULL DEFAULT '0',
  `user_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zil_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eth_adress` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daily` int(11) NOT NULL,
  `commission` int(11) NOT NULL,
  `lending` int(11) NOT NULL,
  `zlliqa` int(11) NOT NULL,
  `downline_member` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_login_unique` (`username`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`),
  KEY `users_login_index` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------

-- ----------------------------
-- Table structure for `users_groups`
-- ----------------------------
DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `user_group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`user_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_groups
-- ----------------------------

-- ----------------------------
-- Table structure for `user_groups`
-- ----------------------------
DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_groups_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_groups
-- ----------------------------
INSERT INTO user_groups VALUES ('1', 'Guest', 'guest', 'Default group for guest users.', '2019-09-23 13:34:36', '2019-09-23 13:34:36');
INSERT INTO user_groups VALUES ('2', 'Registered', 'registered', 'Default group for registered users.', '2019-09-23 13:34:36', '2019-09-23 13:34:36');

-- ----------------------------
-- Table structure for `user_throttle`
-- ----------------------------
DROP TABLE IF EXISTS `user_throttle`;
CREATE TABLE `user_throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `is_suspended` tinyint(1) NOT NULL DEFAULT '0',
  `suspended_at` timestamp NULL DEFAULT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_throttle_user_id_index` (`user_id`),
  KEY `user_throttle_ip_address_index` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_throttle
-- ----------------------------

-- ----------------------------
-- Table structure for `zilliqa_backend_history_deposit`
-- ----------------------------
DROP TABLE IF EXISTS `zilliqa_backend_history_deposit`;
CREATE TABLE `zilliqa_backend_history_deposit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `coint` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of zilliqa_backend_history_deposit
-- ----------------------------

-- ----------------------------
-- Table structure for `zilliqa_backend_history_with_draw`
-- ----------------------------
DROP TABLE IF EXISTS `zilliqa_backend_history_with_draw`;
CREATE TABLE `zilliqa_backend_history_with_draw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `coint` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of zilliqa_backend_history_with_draw
-- ----------------------------

-- ----------------------------
-- Table structure for `zilliqa_backend_lending_package`
-- ----------------------------
DROP TABLE IF EXISTS `zilliqa_backend_lending_package`;
CREATE TABLE `zilliqa_backend_lending_package` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bonus_zil` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zil_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of zilliqa_backend_lending_package
-- ----------------------------

-- ----------------------------
-- Table structure for `zilliqa_backend_presenter`
-- ----------------------------
DROP TABLE IF EXISTS `zilliqa_backend_presenter`;
CREATE TABLE `zilliqa_backend_presenter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_present` int(11) NOT NULL,
  `parent_present` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of zilliqa_backend_presenter
-- ----------------------------

-- ----------------------------
-- Table structure for `zilliqa_backend_user_lending`
-- ----------------------------
DROP TABLE IF EXISTS `zilliqa_backend_user_lending`;
CREATE TABLE `zilliqa_backend_user_lending` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lending_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of zilliqa_backend_user_lending
-- ----------------------------
