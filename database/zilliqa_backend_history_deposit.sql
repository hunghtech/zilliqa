/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : zilliqa-2019

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-10-10 12:28:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zilliqa_backend_history_deposit
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
  `deleted_at` timestamp NULL DEFAULT NULL,
  `lending_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of zilliqa_backend_history_deposit
-- ----------------------------
INSERT INTO `zilliqa_backend_history_deposit` VALUES ('1', '1', 'ETH', '55.707', '0', '2019-10-07 10:41:29', '2019-10-07 10:41:29', null, '1');
INSERT INTO `zilliqa_backend_history_deposit` VALUES ('2', '5', 'ETH', '55.707', '2', '2019-10-10 09:52:21', '2019-10-10 09:52:21', null, '1');
INSERT INTO `zilliqa_backend_history_deposit` VALUES ('3', '17', 'ETH', '55.707', '0', '2019-10-10 09:23:59', '2019-10-07 10:57:27', null, '1');
