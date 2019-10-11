/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : zilliqa-2019

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-10-10 12:27:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zilliqa_backend_history_commission
-- ----------------------------
DROP TABLE IF EXISTS `zilliqa_backend_history_commission`;
CREATE TABLE `zilliqa_backend_history_commission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `commission` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of zilliqa_backend_history_commission
-- ----------------------------
INSERT INTO `zilliqa_backend_history_commission` VALUES ('1', '5', '700', '2019-10-10 09:52:21', '2019-10-10 09:52:21');
