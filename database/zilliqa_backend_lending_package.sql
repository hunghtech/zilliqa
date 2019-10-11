/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : zilliqa-2019

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-10-10 12:28:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zilliqa_backend_lending_package
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of zilliqa_backend_lending_package
-- ----------------------------
INSERT INTO `zilliqa_backend_lending_package` VALUES ('1', '10000', '5', '1000', 'Zil1fq62xcaasa20x5qg9avvdavcrvxmv5scxqmrlt', '/qr-code/qrcode.png', 'Send only ZIL to this deposit address.\r\nSending coin or token other than ZIL to this address may result in the loss of your deposit.', '2019-10-02 21:38:44', '2019-10-02 21:38:44');
INSERT INTO `zilliqa_backend_lending_package` VALUES ('2', '5000', '5', '500', 'Zil1fq62xcaasa20x5qg9avvdavcrvxmv5scxqmrlt', '/qr-code/qrcode.png', 'Send only ZIL to this deposit address.\r\nSending coin or token other than ZIL to this address may result in the loss of your deposit.', '2019-10-03 09:08:24', '2019-10-02 21:38:50');
INSERT INTO `zilliqa_backend_lending_package` VALUES ('3', '1000', '5', '100', 'Zil1fq62xcaasa20x5qg9avvdavcrvxmv5scxqmrlt', '/qr-code/qrcode.png', 'Send only ZIL to this deposit address.\r\nSending coin or token other than ZIL to this address may result in the loss of your deposit.', '2019-10-02 21:38:57', '2019-10-02 21:38:57');
INSERT INTO `zilliqa_backend_lending_package` VALUES ('4', '500', '5', '50', 'Zil1fq62xcaasa20x5qg9avvdavcrvxmv5scxqmrlt', '/qr-code/qrcode.png', 'Send only ZIL to this deposit address.\r\nSending coin or token other than ZIL to this address may result in the loss of your deposit.', '2019-10-02 14:38:22', '2019-10-02 07:38:22');
INSERT INTO `zilliqa_backend_lending_package` VALUES ('5', '15', '5', '15', 'Zil1fq62xcaasa20x5qg9avvdavcrvxmv5scxqmrlt', '/qr-code/qrcode.png', 'Send only ZIL to this deposit address.\r\nSending coin or token other than ZIL to this address may result in the loss of your deposit.', '2019-10-02 14:38:51', '2019-10-02 07:38:51');
