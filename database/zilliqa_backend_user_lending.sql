/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : zilliqa-2019

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-10-10 12:28:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zilliqa_backend_user_lending
-- ----------------------------
DROP TABLE IF EXISTS `zilliqa_backend_user_lending`;
CREATE TABLE `zilliqa_backend_user_lending` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lending_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `is_update_bonus` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of zilliqa_backend_user_lending
-- ----------------------------
INSERT INTO `zilliqa_backend_user_lending` VALUES ('1', '1', '1', '2019-10-03 14:00:10', null, '1', '1');
INSERT INTO `zilliqa_backend_user_lending` VALUES ('3', '1', '1', '2019-10-10 09:52:21', '2019-10-10 09:52:21', '5', '0');
