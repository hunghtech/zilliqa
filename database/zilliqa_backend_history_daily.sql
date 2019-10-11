/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : zilliqa-2019

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-10-10 12:28:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zilliqa_backend_history_daily
-- ----------------------------
DROP TABLE IF EXISTS `zilliqa_backend_history_daily`;
CREATE TABLE `zilliqa_backend_history_daily` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `daily` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of zilliqa_backend_history_daily
-- ----------------------------
INSERT INTO `zilliqa_backend_history_daily` VALUES ('1', '1', '500', '2019-10-08 14:09:25', '2019-10-08 14:09:25');
INSERT INTO `zilliqa_backend_history_daily` VALUES ('2', '1', '10', '2019-10-08 14:45:16', '2019-10-08 14:45:16');
