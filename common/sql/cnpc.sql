/*
MySQL Data Transfer
Source Host: localhost
Source Database: cnpc
Target Host: localhost
Target Database: cnpc
Date: 2015/7/17 15:47:10
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for migration
-- ----------------------------
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for session
-- ----------------------------
CREATE TABLE `session` (
  `id` char(40) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user
-- ----------------------------
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户名',
  `phone` int(11) DEFAULT NULL COMMENT '手机',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1436856356');
INSERT INTO `migration` VALUES ('m130524_201442_init', '1436856359');
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', '1436856663');
INSERT INTO `session` VALUES ('1mhu7lifv4h8fhfvgrs24u2nf0', '1437161427', 0x5F5F666C6173687C613A303A7B7D);
INSERT INTO `session` VALUES ('1qv92jaeee9f83hntq523mkuv4', '1437161535', 0x5F5F666C6173687C613A303A7B7D);
INSERT INTO `session` VALUES ('9fu8u01rt34no4lc9hfe409ib5', '1437162003', 0x5F5F666C6173687C613A303A7B7D);
INSERT INTO `session` VALUES ('o0njd0oi49q2etf8cmr0kci4p2', '1437162297', 0x5F5F666C6173687C613A303A7B7D5F5F72657475726E55726C7C733A32333A222F746F706F6C6F67792F64656661756C742F696E646578223B5F5F69647C693A343B);
INSERT INTO `user` VALUES ('1', 'test', '', '', null, '', '10', '0', '0', null, null);
INSERT INTO `user` VALUES ('2', '111', 'xyRTkw563Ql_a8Y0OLjv5G4yyIJgQX2p', '$2y$13$aHzRtU8MOgRAS0c4RBXsw.zy8qqTXwyzqvP6vySAgKgSUwlseckFO', null, '1111@111.111', '10', '2015', '2015', '12121', '111');
INSERT INTO `user` VALUES ('3', 'test1', 'V_fyl11qCCvBHwdRW9noJVbmbz6jJQp4', '$2y$13$qLDuVOiBVbRJR3bTLOObB.WNfCJS//Yt9PIJ8SAGwLLmGJMyCrb5C', null, '111@111.111', '10', '2015', '2015', 'sdfadsfads', '111');
INSERT INTO `user` VALUES ('4', 'test2', 'Bs_q8pCeuMHmr_mGV-cIi6Sx1wZgsMR1', '$2y$13$kYwsuc/QMkWd7quG/mJMPeroor9MfABtUikOte8XT7oJ16ZwvJ0mK', null, '11@11.11', '10', '2015', '2015', 'ceshi', '111');
