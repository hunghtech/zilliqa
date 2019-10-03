/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : zilliqa-2019

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-10-03 09:09:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users
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
  `eth_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daily` int(11) NOT NULL,
  `commission` int(11) NOT NULL,
  `lending` int(11) NOT NULL,
  `zilliqa` int(11) NOT NULL,
  `downline_member` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `is_block` int(11) NOT NULL,
  `zilliqa_minimum` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_login_unique` (`username`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`),
  KEY `users_login_index` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Đỗ Như Hưng', 'hungdn0502@gmail.com', '$2y$10$JnhCFUWRXm4u.MP8dozDcelnc6ZQNJRGevJSJaCxoj2l7zWTLHZZa', null, null, '', null, '1', '2019-09-25 04:15:47', '2019-10-03 08:35:25', '2019-09-25 03:43:27', '2019-10-03 08:56:36', 'donhuhung0502', 'Đỗ Như Hưng', null, null, '0', '0', '123456', 'ZIL Address', 'ETH Address', '0', '0', '0', '930', '0', '1', '0', '30');
INSERT INTO `users` VALUES ('5', 'Nguyễn Văn A', 'hungdn0503@gmail.com', '$2y$10$yZGaVJ7tmtAhAw8Vqel/KOCTWKQEomQHVjTd.bqvX3zuGwEUq5jFC', null, null, null, null, '1', null, null, '2019-09-25 08:09:22', '2019-09-25 08:09:22', 'donhuhung', null, null, null, '0', '0', '765025', null, null, '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `users` VALUES ('6', 'Nguyễn Văn B', 'nguyenvanb@gmail.com', '$2y$10$LBgnxLKwFd4uwVi94tP5FOchG4ZWIj.FtI/mdw47AhbuqqFxOHDau', null, null, null, null, '1', null, null, '2019-09-30 06:44:30', '2019-09-30 06:44:30', 'nguyenvanb', null, null, null, '0', '0', '451048', null, null, '0', '0', '0', '0', '0', '0', '0', '0');
