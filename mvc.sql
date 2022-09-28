/*
Navicat MySQL Data Transfer

Source Server         : my
Source Server Version : 50731
Source Host           : localhost:3306
Source Database       : mvc

Target Server Type    : MYSQL
Target Server Version : 50731
File Encoding         : 65001

Date: 2020-12-24 15:41:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `messages`
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(128) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of messages
-- ----------------------------
INSERT INTO `messages` VALUES ('1', 'admin', 'Hello', 'Strange thing happened', '2020-12-24 14:57:58', '1');
INSERT INTO `messages` VALUES ('2', 'petro', 'Googf evening', 'Hmmmm........', '2020-12-25 15:39:02', '0');
INSERT INTO `messages` VALUES ('3', 'valera', 'Hi', 'It is good idea', '2020-12-25 15:39:55', '0');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '1@1', 'admin', '123123', '1');
INSERT INTO `users` VALUES ('2', '2@2', 'user1', '111', '0');
INSERT INTO `users` VALUES ('3', '3@3', 'user2', '111', '0');
