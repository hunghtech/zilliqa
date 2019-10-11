/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : zilliqa-2019

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-10-10 12:28:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zilliqa_backend_presenter
-- ----------------------------
DROP TABLE IF EXISTS `zilliqa_backend_presenter`;
CREATE TABLE `zilliqa_backend_presenter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_present` int(11) NOT NULL,
  `parent_present` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `business_volume` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of zilliqa_backend_presenter
-- ----------------------------
INSERT INTO `zilliqa_backend_presenter` VALUES ('1', '1', '1', '0', '2019-10-09 13:55:41', '2019-10-03 15:23:13', '0');
INSERT INTO `zilliqa_backend_presenter` VALUES ('10', '5', '1', '1', '2019-10-10 09:52:21', '2019-10-10 09:52:21', '10000');
INSERT INTO `zilliqa_backend_presenter` VALUES ('11', '17', '5', '10', '2019-10-10 09:59:38', null, '10000');
INSERT INTO `zilliqa_backend_presenter` VALUES ('12', '19', '17', '11', '2019-10-10 09:59:40', null, '10000');
INSERT INTO `zilliqa_backend_presenter` VALUES ('15', '20', '1', '0', '2019-10-10 10:09:36', '2019-10-10 10:09:36', '0');
INSERT INTO `zilliqa_backend_presenter` VALUES ('16', '21', '1', '0', '2019-10-10 10:12:53', '2019-10-10 10:12:53', '0');
INSERT INTO `zilliqa_backend_presenter` VALUES ('17', '23', '1', '0', '2019-10-10 10:15:10', '2019-10-10 10:15:10', '0');
INSERT INTO `zilliqa_backend_presenter` VALUES ('18', '27', '1', '1', '2019-10-10 10:17:27', '2019-10-10 10:17:27', '0');
INSERT INTO `zilliqa_backend_presenter` VALUES ('19', '28', '5', '10', '2019-10-10 10:18:00', '2019-10-10 10:18:00', '0');
