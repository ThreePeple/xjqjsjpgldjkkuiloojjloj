/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50616
 Source Host           : localhost
 Source Database       : cnpc

 Target Server Type    : MySQL
 Target Server Version : 50616
 File Encoding         : utf-8

 Date: 08/09/2015 12:55:19 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `Sheet1`
-- ----------------------------
DROP TABLE IF EXISTS `Sheet1`;
CREATE TABLE `Sheet1` (
  `field2` varchar(255) DEFAULT NULL,
  `field3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `Sheet1`
-- ----------------------------
BEGIN;
INSERT INTO `Sheet1` VALUES ('FLOOR', 'BUILDING'), ('1', 'A'), ('2', 'A'), ('3', 'A'), ('4', 'A'), ('5', 'A'), ('6', 'A'), ('7', 'A'), ('8', 'A'), ('9', 'A'), ('10', 'A'), ('11', 'A'), ('12', 'A'), ('13', 'A'), ('14', 'A'), ('15', 'A'), ('16', 'A'), ('17', 'A'), ('18', 'A'), ('地下一层', 'B'), ('1', 'B'), ('2', 'B'), ('3', 'B'), ('4', 'B'), ('5', 'B'), ('6', 'B'), ('7', 'B'), ('8', 'B'), ('9', 'B'), ('10', 'B'), ('11', 'B'), ('12', 'B'), ('13', 'B'), ('14', 'B'), ('15', 'B'), ('16', 'B'), ('17', 'B'), ('18', 'B'), ('19', 'B'), ('20', 'B'), ('21', 'B'), ('地下一层', 'C'), ('1', 'C'), ('2', 'C'), ('3', 'C'), ('4', 'C'), ('5', 'C'), ('6', 'C'), ('7', 'C'), ('8', 'C'), ('9', 'C'), ('10', 'C'), ('11', 'C'), ('12', 'C'), ('13', 'C'), ('14', 'C'), ('15', 'C'), ('16', 'C'), ('17', 'C'), ('18', 'C'), ('19', 'C'), ('20', 'C'), ('21', 'C'), ('22', 'C'), ('1', 'D'), ('2', 'D'), ('3', 'D'), ('4', 'D'), ('5', 'D'), ('6', 'D'), ('7', 'D'), ('8', 'D'), ('9', 'D'), ('10', 'D'), ('11', 'D'), ('12', 'D'), ('13', 'D'), ('14', 'D'), ('15', 'D'), ('16', 'D'), ('17', 'D'), ('18', 'D'), ('19', 'D'), ('20', 'D'), ('21', 'D'), ('22', 'D'), ('1', 'DL'), ('2', 'DL'), ('3', 'DL'), ('4', 'DL'), ('5', 'DL'), ('6', 'DL'), ('7', 'DL'), ('8', 'DL'), ('9', 'DL'), ('10', 'DL'), ('11', 'DL'), ('12', 'DL'), ('13', 'DL'), ('14', 'DL'), ('15', 'DL'), ('16', 'DL'), ('17', 'DL'), ('18', 'DL'), ('19', 'DL'), ('20', 'DL'), ('21', 'DL'), ('22', 'DL');
COMMIT;

-- ----------------------------
--  Table structure for `alarm_category`
-- ----------------------------
DROP TABLE IF EXISTS `alarm_category`;
CREATE TABLE `alarm_category` (
  `id` int(11) NOT NULL,
  `baseClass` int(11) NOT NULL COMMENT '主分类id',
  `baseDesc` varchar(255) DEFAULT NULL COMMENT '主分类描述',
  `subClass` int(11) NOT NULL COMMENT '子分类id',
  `subDesc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `alarm_category`
-- ----------------------------
BEGIN;
INSERT INTO `alarm_category` VALUES ('1', '1', '其他告警', '1', '其他告警'), ('2', '2', '设备告警', '1', '设备可达性告警'), ('3', '2', '设备告警', '2', '接口\\链路状态告警'), ('4', '2', '设备告警', '3', 'QoS告警'), ('5', '2', '设备告警', '4', '电源告警'), ('7', '2', '设备告警', '6', '其它设备告警'), ('8', '3', '性能告警', '1', 'NMS性能告警'), ('9', '3', '性能告警', '2', '流量分析与审计告警'), ('10', '4', '安全告警', '1', 'IDS告警'), ('11', '4', '安全告警', '2', 'IKE告警'), ('12', '4', '安全告警', '3', 'IPSec告警'), ('13', '4', '安全告警', '4', 'Port Security告警'), ('14', '5', '配置告警', '1', '设备配置变更告警'), ('15', '6', '应用告警', '1', '网管站告警（部分）'), ('16', '6', '应用告警', '2', 'Radius Server告警'), ('1101', '4', '安全告警', '5', 'Syslog告警');
COMMIT;

-- ----------------------------
--  Table structure for `alarm_level`
-- ----------------------------
DROP TABLE IF EXISTS `alarm_level`;
CREATE TABLE `alarm_level` (
  `id` int(11) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `alarm_level`
-- ----------------------------
BEGIN;
INSERT INTO `alarm_level` VALUES ('1', '紧急'), ('2', '重要'), ('3', '次要'), ('4', '警告'), ('5', '通知'), ('255', '所有级别');
COMMIT;

-- ----------------------------
--  Table structure for `alarm_original_type`
-- ----------------------------
DROP TABLE IF EXISTS `alarm_original_type`;
CREATE TABLE `alarm_original_type` (
  `id` int(11) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `alarm_original_type`
-- ----------------------------
BEGIN;
INSERT INTO `alarm_original_type` VALUES ('0', '所有类型'), ('1', 'Trap'), ('2', 'Syslog'), ('3', 'iMC');
COMMIT;

-- ----------------------------
--  Table structure for `alarm_time_range`
-- ----------------------------
DROP TABLE IF EXISTS `alarm_time_range`;
CREATE TABLE `alarm_time_range` (
  `id` int(11) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `area`
-- ----------------------------
DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `area`
-- ----------------------------
BEGIN;
INSERT INTO `area` VALUES ('1', '广域网区域', '0'), ('2', '因特网区域', '0'), ('3', '大厦局域网', '0'), ('4', '基础数据应用中心', '0'), ('5', '三层专业应用系统', '0'), ('6', '一层专业应用系统', '0');
COMMIT;

-- ----------------------------
--  Table structure for `auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `building_floor`
-- ----------------------------
DROP TABLE IF EXISTS `building_floor`;
CREATE TABLE `building_floor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floor` varchar(128) NOT NULL DEFAULT '' COMMENT '楼层',
  `building` varchar(128) NOT NULL COMMENT '楼单元',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `building_floor`
-- ----------------------------
BEGIN;
INSERT INTO `building_floor` VALUES ('13', '1', 'A'), ('14', '2', 'A'), ('15', '3', 'A'), ('16', '4', 'A'), ('17', '5', 'A'), ('18', '6', 'A'), ('19', '7', 'A'), ('20', '8', 'A'), ('21', '9', 'A'), ('22', '10', 'A'), ('23', '11', 'A'), ('24', '12', 'A'), ('25', '13', 'A'), ('26', '14', 'A'), ('27', '15', 'A'), ('28', '16', 'A'), ('29', '17', 'A'), ('30', '18', 'A'), ('31', '地下一层', 'B'), ('32', '1', 'B'), ('33', '2', 'B'), ('34', '3', 'B'), ('35', '4', 'B'), ('36', '5', 'B'), ('37', '6', 'B'), ('38', '7', 'B'), ('39', '8', 'B'), ('40', '9', 'B'), ('41', '10', 'B'), ('42', '11', 'B'), ('43', '12', 'B'), ('44', '13', 'B'), ('45', '14', 'B'), ('46', '15', 'B'), ('47', '16', 'B'), ('48', '17', 'B'), ('49', '18', 'B'), ('50', '19', 'B'), ('51', '20', 'B'), ('52', '21', 'B'), ('53', '地下一层', 'C'), ('54', '1', 'C'), ('55', '2', 'C'), ('56', '3', 'C'), ('57', '4', 'C'), ('58', '5', 'C'), ('59', '6', 'C'), ('60', '7', 'C'), ('61', '8', 'C'), ('62', '9', 'C'), ('63', '10', 'C'), ('64', '11', 'C'), ('65', '12', 'C'), ('66', '13', 'C'), ('67', '14', 'C'), ('68', '15', 'C'), ('69', '16', 'C'), ('70', '17', 'C'), ('71', '18', 'C'), ('72', '19', 'C'), ('73', '20', 'C'), ('74', '21', 'C'), ('75', '22', 'C'), ('76', '1', 'D'), ('77', '2', 'D'), ('78', '3', 'D'), ('79', '4', 'D'), ('80', '5', 'D'), ('81', '6', 'D'), ('82', '7', 'D'), ('83', '8', 'D'), ('84', '9', 'D'), ('85', '10', 'D'), ('86', '11', 'D'), ('87', '12', 'D'), ('88', '13', 'D'), ('89', '14', 'D'), ('90', '15', 'D'), ('91', '16', 'D'), ('92', '17', 'D'), ('93', '18', 'D'), ('94', '19', 'D'), ('95', '20', 'D'), ('96', '21', 'D'), ('97', '22', 'D'), ('98', '1', 'DL'), ('99', '2', 'DL'), ('100', '3', 'DL'), ('101', '4', 'DL'), ('102', '5', 'DL'), ('103', '6', 'DL'), ('104', '7', 'DL'), ('105', '8', 'DL'), ('106', '9', 'DL'), ('107', '10', 'DL'), ('108', '11', 'DL'), ('109', '12', 'DL'), ('110', '13', 'DL'), ('111', '14', 'DL'), ('112', '15', 'DL'), ('113', '16', 'DL'), ('114', '17', 'DL'), ('115', '18', 'DL'), ('116', '19', 'DL'), ('117', '20', 'DL'), ('118', '21', 'DL'), ('119', '22', 'DL');
COMMIT;

-- ----------------------------
--  Table structure for `device_alarm`
-- ----------------------------
DROP TABLE IF EXISTS `device_alarm`;
CREATE TABLE `device_alarm` (
  `id` int(11) NOT NULL,
  `OID` varchar(255) DEFAULT NULL,
  `originalTypeDesc` varchar(255) DEFAULT NULL,
  `deviceId` int(11) NOT NULL DEFAULT '0' COMMENT '设备ID',
  `deviceIp` varchar(64) DEFAULT NULL,
  `deviceName` varchar(255) DEFAULT NULL,
  `alarmLevel` int(2) NOT NULL DEFAULT '0' COMMENT '告警级别',
  `alarmLevelDesc` varchar(255) DEFAULT NULL,
  `alarmCategory` int(2) NOT NULL DEFAULT '0',
  `alarmCategoryDesc` varchar(255) DEFAULT NULL,
  `faultTime` int(11) DEFAULT NULL COMMENT '告警发生时间',
  `faultTimeDesc` varchar(255) DEFAULT NULL,
  `recTime` int(11) DEFAULT NULL COMMENT '恢复时间',
  `recTimeDesc` varchar(255) DEFAULT NULL,
  `recStatus` int(2) DEFAULT NULL,
  `recStatusDesc` varchar(255) DEFAULT NULL,
  `recUserName` varchar(255) DEFAULT NULL,
  `ackTime` int(11) DEFAULT NULL,
  `ackTimeDesc` varchar(255) DEFAULT NULL,
  `ackStatus` tinyint(2) DEFAULT '0',
  `ackStatusDesc` varchar(255) DEFAULT NULL,
  `ackUserName` varchar(255) DEFAULT NULL,
  `alarmDesc` varchar(255) DEFAULT NULL COMMENT '告警描述',
  `somState` int(2) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL COMMENT '告警备注',
  `eventName` varchar(255) DEFAULT NULL,
  `reason` text,
  `defineType` int(4) DEFAULT NULL,
  `customAlarmLevel` int(4) DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '自动记录时间',
  `specificId` int(11) DEFAULT '0' COMMENT '事件id',
  `originalType` int(11) DEFAULT NULL COMMENT '告警来源类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `device_alarm`
-- ----------------------------
BEGIN;
INSERT INTO `device_alarm` VALUES ('55544', '1.3.6.1.4.1.25506.4.1.2.2.6.2', 'iMC', '2', '10.253.1.1', 'CORE-S9512-01', '5', '通知', '8', 'NMS性能告警', '1438236639', '2015-07-30 14:10:39', '1438236639', '2015-07-30 14:10:39', '1', '已恢复', '$SYSTEM', '0', '', '0', '未确认', '', '性能任务（接口发送速率）的实例（GigabitEthernet2/1/2）恢复正常，当前值为37334291.733bps。', '0', '', null, null, null, null, '2015-08-05 23:13:47', '0', '3'), ('55545', '1.3.6.1.4.1.25506.4.1.2.2.6.3', 'iMC', '3', '10.253.5.33', 'DMZ-S5648-01', '2', '重要', '8', 'NMS性能告警', '1438236828', '2015-07-30 14:13:48', '0', '', '0', '未恢复', '', '0', '', '0', '未确认', '', '性能任务（接口接收速率）的实例（GigabitEthernet1/0/31）处于阈值区域：>=500000000bps，当前值为794554544.585bps。', '0', '', null, null, null, null, '2015-08-05 23:13:50', '0', '3'), ('55546', '1.3.6.1.4.1.25506.4.1.2.2.6.3', 'iMC', '4', '10.253.5.26', 'DMZ-S5648-02', '2', '重要', '8', 'NMS性能告警', '1438236828', '2015-07-30 14:13:48', '0', '', '0', '未恢复', '', '0', '', '0', '未确认', '', '性能任务（接口接收速率）的实例（GigabitEthernet1/0/31）处于阈值区域：>=500000000bps，当前值为726519666.773bps。', '0', '', null, null, null, null, '2015-08-05 23:13:54', '0', '3'), ('55547', '1.3.6.1.4.1.25506.4.1.2.2.6.2', 'iMC', '6', '10.253.5.10', 'f5-ltm01.com', '5', '通知', '8', 'NMS性能告警', '1438237142', '2015-07-30 14:19:02', '1438237142', '2015-07-30 14:19:02', '1', '已恢复', '$SYSTEM', '0', '', '0', '未确认', '', '性能任务（CPU利用率）的实例（[CPU:.1.48.1]）恢复正常，当前值为69%。', '0', '', null, null, null, null, '2015-08-05 23:13:57', '0', '3'), ('55548', '1.3.6.1.4.1.25506.4.1.2.2.6.3', 'iMC', '8', '10.6.253.61', 'C-F6-S5100-01', '2', '重要', '8', 'NMS性能告警', '1438237409', '2015-07-30 14:23:29', '1438240708', '2015-07-30 15:18:28', '1', '已恢复', '$SYSTEM', '0', '', '0', '未确认', '', '性能任务（接口输入包丢弃率）的实例（GigabitEthernet1/0/52）处于阈值区域：>=0.050%，当前值为0.144%。', '0', '', null, null, null, null, '2015-08-05 23:14:01', '0', '3'), ('55549', '1.3.6.1.4.1.25506.4.1.1.2.6.2', 'iMC', '2', '10.253.5.10', 'f5-ltm01.com', '2', '重要', '15', '网管站告警（部分）', '1438239535', '2015-07-30 14:58:55', '0', '', '0', '未恢复', '', '0', '', '0', '未确认', '', '设备f5-ltm01.com拒绝访问。', '0', '', null, null, null, null, '2015-08-05 23:14:03', '0', '3'), ('55550', '1.3.6.1.4.1.25506.4.1.2.2.6.1', 'iMC', '3', '10.253.5.10', 'f5-ltm01.com', '3', '次要', '8', 'NMS性能告警', '1438239550', '2015-07-30 14:59:10', '1438241942', '2015-07-30 15:39:02', '1', '已恢复', '$SYSTEM', '0', '', '0', '未确认', '', '性能任务（CPU利用率）的实例（[CPU:.1.48.1]）处于告警阈值区域：>=70%，当前值为71%。', '0', '', null, null, null, null, '2015-08-05 23:14:05', '0', '3'), ('55551', '1.3.6.1.4.1.25506.4.1.2.2.6.4', 'iMC', '4', '10.6.253.61', 'C-F6-S5100-01', '5', '通知', '8', 'NMS性能告警', '1438240708', '2015-07-30 15:18:28', '1438240708', '2015-07-30 15:18:28', '1', '已恢复', '$SYSTEM', '0', '', '0', '未确认', '', '性能任务（接口输入包丢弃率）的实例（GigabitEthernet1/0/52）恢复正常状态，当前值为0.045%。', '0', '', null, null, null, null, '2015-08-05 23:14:08', '0', '3'), ('55552', '1.3.6.1.4.1.25506.4.1.2.2.6.2', 'iMC', '6', '10.253.5.10', 'f5-ltm01.com', '5', '通知', '8', 'NMS性能告警', '1438241942', '2015-07-30 15:39:02', '1438241942', '2015-07-30 15:39:02', '1', '已恢复', '$SYSTEM', '0', '', '0', '未确认', '', '性能任务（CPU利用率）的实例（[CPU:.1.48.1]）恢复正常，当前值为69%。', '0', '', null, null, null, null, '2015-08-05 23:14:10', '0', '3'), ('55553', '1.3.6.1.4.1.25506.4.1.1.2.6.2', 'iMC', '8', '10.253.5.11', 'f5-ltm02.com', '2', '重要', '15', '网管站告警（部分）', '1438242236', '2015-07-30 15:43:56', '0', '', '0', '未恢复', '', '0', '', '0', '未确认', '', '设备f5-ltm02.com拒绝访问。', '0', '', null, null, null, null, '2015-08-05 23:14:25', '0', '3');
COMMIT;

-- ----------------------------
--  Table structure for `device_category`
-- ----------------------------
DROP TABLE IF EXISTS `device_category`;
CREATE TABLE `device_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `preDefined` tinyint(1) DEFAULT '1' COMMENT '是否系统定义0-否，1-是',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `node_group` varchar(50) DEFAULT NULL COMMENT '节点配置信息  用于界面展示效果',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `device_category`
-- ----------------------------
BEGIN;
INSERT INTO `device_category` VALUES ('0', '路由器', '1', '2015-08-05 15:47:35', 'router'), ('1', '交换机', '1', '2015-08-05 22:38:16', 'switch'), ('2', '服务器', '1', '2015-08-05 15:47:41', 'server'), ('3', '安全设备', '1', '2015-08-05 22:49:19', 'firewall'), ('4', '存储设备', '1', '2015-08-05 15:48:39', 'driver'), ('5', '无线设备', '1', '2015-08-05 15:48:56', 'wireless'), ('6', '语音设备', '1', '2015-08-05 15:49:17', 'audio'), ('7', '打印机', '1', '2015-08-05 15:49:27', 'printer'), ('8', 'UPS', '1', '2015-08-05 15:49:29', 'ups'), ('9', 'PC', '1', '2015-08-05 15:49:33', 'pc'), ('10', '核心交换机', '1', '2015-08-09 12:13:43', 'switch'), ('11', '聚汇交换机', '1', '2015-08-09 12:14:05', 'switch');
COMMIT;

-- ----------------------------
--  Table structure for `device_info`
-- ----------------------------
DROP TABLE IF EXISTS `device_info`;
CREATE TABLE `device_info` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `mask` varchar(255) NOT NULL DEFAULT '',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '-1-未管理0-未知1-正常2-警告3-次要4-重要5-严重',
  `sysName` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `sysOid` varchar(255) DEFAULT NULL,
  `runtime` varchar(255) DEFAULT NULL,
  `lastPoll` datetime DEFAULT NULL,
  `categoryId` int(11) NOT NULL DEFAULT '0',
  `supportPing` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0' COMMENT '是否支持PING，0-不支持1-支持',
  `webMgrPort` int(11) DEFAULT '0',
  `configPollTime` int(11) DEFAULT '0',
  `statePollTime` int(11) DEFAULT '0',
  `typeName` varchar(255) DEFAULT NULL,
  `positionX` int(11) DEFAULT '0',
  `positionY` int(11) DEFAULT NULL,
  `symbolType` tinyint(2) DEFAULT '0',
  `symbolDesc` text,
  `mac` varchar(255) DEFAULT NULL,
  `phyName` varchar(255) DEFAULT NULL,
  `phyCreateTime` datetime DEFAULT NULL,
  `series_id` int(11) NOT NULL DEFAULT '0',
  `model_id` varchar(255) DEFAULT NULL,
  `interfaces` text,
  `category` varchar(255) DEFAULT NULL COMMENT '设备类型',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `series_name` varchar(255) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `device_info`
-- ----------------------------
BEGIN;
INSERT INTO `device_info` VALUES ('2', 'stack_0.A-F4-S5100-01', '10.6.251.41', '255.255.255.0', '1', 'stack_0.A-F4-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:31', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('3', 'stack_0.A-F2-S5100-01', '10.6.251.21', '255.255.255.0', '1', 'stack_0.A-F2-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:66:db:2d', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('4', 'stack_1.A-F5-S5100-02', '10.6.251.52', '255.255.255.0', '1', 'stack_1.A-F5-S5100-02', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:62:cb:4d', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('6', 'stack_0.A-F7-S5100-01', '10.6.251.71', '255.255.255.0', '1', 'stack_0.A-F7-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:03', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('8', 'stack_0.A-F3-S5100-01', '10.6.251.31', '255.255.255.0', '1', 'stack_0.A-F3-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.30', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-EI', '0', null, '3', '', '00:0f:e2:b1:26:34', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('9', 'stack_1.A-F8-S5100-02', '10.6.251.82', '255.255.255.0', '1', 'stack_1.A-F8-S5100-02', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:66:da:c3', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('10', 'stack_1.A-F9-S5100-02', '10.6.251.92', '255.255.255.0', '1', 'stack_1.A-F9-S5100-02', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:62:cb:4f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('12', 'stack_0.A-F10-S5100-01', '10.6.251.101', '255.255.255.0', '1', 'stack_0.A-F10-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.30', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-EI', '0', null, '3', '', '00:0f:e2:84:f9:01', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('13', 'stack_0.A-F7-S5100-02', '10.6.251.72', '255.255.255.0', '1', 'stack_0.A-F7-S5100-02', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:84:cd:46', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('16', 'stack_0.A-F8-S5100-01', '10.6.251.81', '255.255.255.0', '1', 'stack_0.A-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('17', 'stack_0.B-F8-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('19', 'stack_0.B-F8-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('20', 'stack_0.C-F8-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('21', 'stack_0.D-F8-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('22', 'stack_0.B-F6-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('23', 'stack_0.D-F2-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('24', 'stack_0.B-F3-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('25', 'stack_0.D-F4-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('26', 'stack_0.B-F5-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('27', 'stack_0.C-F2-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('28', 'stack_0.C-F3-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('29', 'stack_0.C-F4-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('30', 'stack_0.C-F5-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('31', 'stack_0.C-F2-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('32', 'stack_0.C-F3-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('33', 'stack_0.C-F4-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('34', 'stack_0.C-F5-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('35', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('36', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('37', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('38', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('39', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('40', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('41', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('42', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('43', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('44', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('45', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('46', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('47', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('48', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('49', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null), ('50', 'stack_0.C-F1-S5100-01', '10.6.251.82', '255.255.255.0', '1', 'stack_0.B-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `device_interface`
-- ----------------------------
DROP TABLE IF EXISTS `device_interface`;
CREATE TABLE `device_interface` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) DEFAULT NULL,
  `ifIndex` int(11) NOT NULL,
  `ifType` int(11) NOT NULL,
  `ifTypeDesc` varchar(255) DEFAULT NULL,
  `ifDescription` varchar(255) DEFAULT NULL,
  `adminStatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '管理状态。1：Up，2：Down。',
  `adminStatusDesc` varchar(255) DEFAULT NULL,
  `operationStatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '操作状态。 1：Up，2：Down，3：Testing，4：Unknown，5：Dormant，6：NotPresent，7：LowerLayerDown。',
  `operationStatusDesc` varchar(255) DEFAULT NULL,
  `showStatus` tinyint(1) NOT NULL DEFAULT '-2' COMMENT '显示状态。 -2：Unmanaged，-1：Disable，1：Up，2：Down，4：Unkown。',
  `statusDesc` varchar(255) DEFAULT NULL,
  `ifspeed` int(11) DEFAULT '0',
  `appointedSpeed` int(11) DEFAULT '0',
  `ifAlias` varchar(255) DEFAULT NULL,
  `phyAddress` varchar(255) DEFAULT NULL,
  `mtu` int(11) DEFAULT '0',
  `lastChange` varchar(255) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL COMMENT 'ip地址，接口的ipHash第一项拆出来',
  `mask` varchar(64) DEFAULT NULL COMMENT 'ip掩码，接口的ipHash第二项拆出来',
  `lastChangeTime` varchar(255) DEFAULT NULL COMMENT 'timestamp 时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `device_interface`
-- ----------------------------
BEGIN;
INSERT INTO `device_interface` VALUES ('10', '2', '10', '136', 'L3IPVLAN', 'Vlan-interface10', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface10 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.10', '255.255.255.0', '', '0000-00-00 00:00:00'), ('11', '2', '11', '136', 'L3IPVLAN', 'Vlan-interface11', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface11 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.11', '255.255.255.0', '', '0000-00-00 00:00:00'), ('12', '2', '12', '136', 'L3IPVLAN', 'Vlan-interface12', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface12 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.12', '255.255.255.0', '', '0000-00-00 00:00:00'), ('13', '2', '13', '136', 'L3IPVLAN', 'Vlan-interface13', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface13 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.13', '255.255.255.0', '', '0000-00-00 00:00:00'), ('14', '2', '14', '136', 'L3IPVLAN', 'Vlan-interface14', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface14 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.14', '255.255.255.0', '', '0000-00-00 00:00:00'), ('15', '2', '15', '136', 'L3IPVLAN', 'Vlan-interface15', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface15 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.15', '255.255.255.0', '', '0000-00-00 00:00:00'), ('16', '2', '16', '136', 'L3IPVLAN', 'Vlan-interface16', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface16 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.16', '255.255.255.0', '', '0000-00-00 00:00:00'), ('17', '2', '17', '136', 'L3IPVLAN', 'Vlan-interface17', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface17 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.17', '255.255.255.0', '', '0000-00-00 00:00:00'), ('18', '2', '18', '136', 'L3IPVLAN', 'Vlan-interface18', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface18 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.18', '255.255.255.0', '', '0000-00-00 00:00:00'), ('19', '2', '19', '136', 'L3IPVLAN', 'Vlan-interface19', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface19 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.19', '255.255.255.0', '', '0000-00-00 00:00:00'), ('20', '3', '20', '136', 'L3IPVLAN', 'Vlan-interface20', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface10 Interface', '00:0f:e2:64:1c:03', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.10', '255.255.255.0', '', '0000-00-00 00:00:00'), ('21', '3', '21', '136', 'L3IPVLAN', 'Vlan-interface21', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface11 Interface', '00:0f:e2:64:1c:03', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.11', '255.255.255.0', '', '0000-00-00 00:00:00'), ('22', '3', '22', '136', 'L3IPVLAN', 'Vlan-interface22', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface12 Interface', '00:0f:e2:64:1c:03', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.12', '255.255.255.0', '', '0000-00-00 00:00:00'), ('23', '6', '23', '136', 'L3IPVLAN', 'Vlan-interface23', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface10 Interface', '00:0f:e2:b1:26:34', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.10', '255.255.255.0', '', '0000-00-00 00:00:00'), ('24', '6', '24', '136', 'L3IPVLAN', 'Vlan-interface24', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface11 Interface', '00:0f:e2:b1:26:34', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.11', '255.255.255.0', '', '0000-00-00 00:00:00'), ('25', '6', '25', '136', 'L3IPVLAN', 'Vlan-interface25', '1', 'Up', '1', 'Up', '-2', '', '0', '0', 'Vlan-interface12 Interface', '00:0f:e2:b1:26:34', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.12', '255.255.255.0', '', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `device_interface_task`
-- ----------------------------
DROP TABLE IF EXISTS `device_interface_task`;
CREATE TABLE `device_interface_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instanceId` int(11) DEFAULT '0',
  `instanceName` varchar(255) DEFAULT NULL,
  `devId` int(11) NOT NULL,
  `devName` varchar(255) DEFAULT NULL,
  `devDisplayName` varchar(255) DEFAULT NULL,
  `devIP` varchar(64) DEFAULT NULL,
  `taskId` int(11) NOT NULL,
  `taskName` varchar(255) DEFAULT NULL,
  `taskNameWithUnit` varchar(255) DEFAULT NULL,
  `objIndex` int(11) DEFAULT NULL,
  `objIndexDesc` varchar(255) DEFAULT NULL,
  `averageValue` double(11,2) DEFAULT '0.00',
  `maximumValue` double(11,2) DEFAULT '0.00',
  `currentValue` double(11,2) DEFAULT '0.00',
  `summaryValue` double(11,2) unsigned DEFAULT '0.00',
  `dateTime` datetime DEFAULT NULL,
  `dataGranularity` tinyint(1) DEFAULT '0' COMMENT '数据粒度：缺省值为0，取值范围（0：自动计算；1：原始数据；2：小时汇总数据；3；天汇总数据）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `device_interface_task`
-- ----------------------------
BEGIN;
INSERT INTO `device_interface_task` VALUES ('1', '1', '111', '2', 'H3C', 'DSDS', '127.0.0.1', '1', null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0');
COMMIT;

-- ----------------------------
--  Table structure for `device_link`
-- ----------------------------
DROP TABLE IF EXISTS `device_link`;
CREATE TABLE `device_link` (
  `id` int(11) NOT NULL,
  `type` int(2) NOT NULL DEFAULT '0',
  `leftSymbolId` int(11) NOT NULL DEFAULT '0',
  `leftIfDesc` varchar(255) NOT NULL,
  `rightSymbolId` int(11) NOT NULL DEFAULT '0',
  `rightIfDesc` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0：UNKNOWN，1：NORMAL，2：DOWN，3：URGENT，4：IMPORTENT，5：MINOR，6：WARN，7：EVENT，8：VIRTUAL1。',
  `bandWidth` varchar(255) NOT NULL,
  `leftDevice` varchar(255) NOT NULL,
  `rightDevice` varchar(255) NOT NULL,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `device_link`
-- ----------------------------
BEGIN;
INSERT INTO `device_link` VALUES ('5', '0', '1036', 'GigabitEthernet1/0/52', '1015', 'GigabitEthernet1/0/52', '1', '1000000000', '13', '6', '2015-07-31 00:22:24'), ('6', '0', '1037', 'GigabitEthernet1/0/52', '1038', 'GigabitEthernet1/0/52', '1', '200000000', '2', '3', '2015-08-05 23:00:50'), ('7', '0', '1037', 'GigabitEthernet1/0/52', '1038', 'GigabitEthernet1/0/52', '1', '200000000', '2', '4', '2015-08-05 23:01:50'), ('8', '0', '1037', 'GigabitEthernet1/0/52', '1038', 'GigabitEthernet1/0/52', '1', '200000000', '2', '6', '2015-08-05 23:02:50'), ('9', '0', '1037', 'GigabitEthernet1/0/52', '1038', 'GigabitEthernet1/0/52', '1', '200000000', '4', '6', '2015-08-05 23:03:50'), ('10', '0', '1037', 'GigabitEthernet1/0/52', '1038', 'GigabitEthernet1/0/52', '1', '200000000', '3', '4', '2015-08-05 23:04:50'), ('11', '0', '1037', 'GigabitEthernet1/0/52', '1038', 'GigabitEthernet1/0/52', '1', '200000000', '3', '6', '2015-08-05 23:05:50'), ('12', '0', '1037', 'GigabitEthernet1/0/52', '1038', 'GigabitEthernet1/0/52', '1', '200000000', '2', '8', '2015-08-05 23:01:50'), ('13', '0', '1037', 'GigabitEthernet1/0/52', '1038', 'GigabitEthernet1/0/52', '1', '200000000', '3', '8', '2015-08-05 23:02:50'), ('14', '0', '1037', 'GigabitEthernet1/0/52', '1038', 'GigabitEthernet1/0/52', '1', '200000000', '4', '8', '2015-08-05 23:03:50'), ('15', '0', '1037', 'GigabitEthernet1/0/52', '1038', 'GigabitEthernet1/0/52', '1', '200000000', '6', '8', '2015-08-05 23:04:50');
COMMIT;

-- ----------------------------
--  Table structure for `device_model`
-- ----------------------------
DROP TABLE IF EXISTS `device_model`;
CREATE TABLE `device_model` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `sysOid` varchar(255) DEFAULT NULL,
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `series_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `device_model`
-- ----------------------------
BEGIN;
INSERT INTO `device_model` VALUES ('10178', '3Com OSR3720', null, '1.3.6.1.4.1.43.1.16.4.2.34', '3', '20', '0', '2015-07-22 17:48:05');
COMMIT;

-- ----------------------------
--  Table structure for `device_series`
-- ----------------------------
DROP TABLE IF EXISTS `device_series`;
CREATE TABLE `device_series` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `preDefined` tinyint(1) DEFAULT '1' COMMENT '是否系统定义0-否1-是',
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `device_series`
-- ----------------------------
BEGIN;
INSERT INTO `device_series` VALUES ('163', 'H3C AR18-2x', null, '1', '1', '2015-08-05 16:03:49');
COMMIT;

-- ----------------------------
--  Table structure for `device_task`
-- ----------------------------
DROP TABLE IF EXISTS `device_task`;
CREATE TABLE `device_task` (
  `instId` int(11) NOT NULL AUTO_INCREMENT COMMENT '实例，唯一ID主键',
  `insDesc` varchar(255) DEFAULT NULL,
  `devId` int(11) DEFAULT NULL COMMENT '设备',
  `devDesc` varchar(255) DEFAULT NULL,
  `taskId` int(11) DEFAULT NULL COMMENT '指标',
  `taskDesc` varchar(255) DEFAULT NULL,
  `dataVal` double(11,2) DEFAULT '0.00',
  `dataTime` datetime DEFAULT NULL COMMENT '数据时间',
  `dataTimeStr` datetime DEFAULT NULL COMMENT '显示时间',
  `dataType` int(11) DEFAULT '0',
  `minVal` double(11,0) DEFAULT '0' COMMENT '最小值',
  `maxVal` double(11,0) DEFAULT '0',
  `sumVal` double(11,0) DEFAULT '0' COMMENT '汇总值',
  `sumCount` int(11) DEFAULT '0' COMMENT '汇总计数',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`instId`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `device_task`
-- ----------------------------
BEGIN;
INSERT INTO `device_task` VALUES ('1', null, '2', null, '1', '接口接收速率(bps)', '19.00', '2015-00-00 00:00:00', '2015-00-00 00:00:00', '0', '19', '19', '19', '1', '2015-08-05 21:52:57'), ('2', null, '3', null, '1', '接口接收速率(bps)', '47.95', '2015-00-00 00:00:00', '2015-00-00 00:00:00', '0', '48', '48', '48', '1', '2015-08-05 21:59:56'), ('3', null, '4', null, '1', '接口接收速率(bps)', '10.00', '2015-00-00 00:00:00', '2015-00-00 00:00:00', '0', '10', '10', '10', '1', '2015-08-05 21:59:59'), ('4', null, '6', null, '1', '接口接收速率(bps)', '20.00', '2015-00-00 00:00:00', '2015-00-00 00:00:00', '0', '0', '0', '0', '1', '2015-08-05 22:06:38'), ('5', null, '8', null, '1', '接口接收速率(bps)', '30.00', '2015-00-00 00:00:00', '2015-00-00 00:00:00', '0', '0', '0', '0', '1', '2015-08-05 22:06:41'), ('6', null, '2', null, '2', 'CPU利用率(%)', '90.00', null, null, '0', '0', '0', '0', '0', '2015-08-05 22:06:30'), ('7', null, '3', null, '2', 'CPU利用率(%)', '87.00', null, null, '0', '0', '0', '0', '0', '2015-08-05 22:06:45'), ('8', null, '4', null, '2', 'CPU利用率(%)', '60.00', null, null, '0', '0', '0', '0', '0', '2015-08-05 22:06:48'), ('9', null, '6', null, '2', 'CPU利用率(%)', '50.00', null, null, '0', '0', '0', '0', '0', '2015-08-05 22:06:52'), ('10', null, '8', null, '2', 'CPU利用率(%)', '77.00', null, null, '0', '0', '0', '0', '0', '2015-08-05 22:08:31'), ('11', null, '2', null, '4', '内存利用率(%)', '99.00', null, null, '0', '0', '0', '0', '0', '2015-08-05 22:09:38'), ('12', null, '3', null, '4', '内存利用率(%)', '87.00', null, null, '0', '0', '0', '0', '0', '2015-08-05 22:09:55'), ('13', null, '4', null, '4', '内存利用率(%)', '66.00', null, null, '0', '0', '0', '0', '0', '2015-08-05 22:12:54'), ('14', null, '6', null, '4', '内存利用率(%)', '88.00', null, null, '0', '0', '0', '0', '0', '2015-08-05 22:12:57'), ('15', null, '8', null, '4', '内存利用率(%)', '87.00', null, null, '0', '0', '0', '0', '0', '2015-08-05 22:13:12');
COMMIT;

-- ----------------------------
--  Table structure for `device_vendor`
-- ----------------------------
DROP TABLE IF EXISTS `device_vendor`;
CREATE TABLE `device_vendor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `preDefined` tinyint(1) DEFAULT '1' COMMENT '是否系统自定义0-否1-是',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `device_vendor`
-- ----------------------------
BEGIN;
INSERT INTO `device_vendor` VALUES ('1', 'H3C', 'H3C', null, null, '1', '2015-08-05 16:03:10');
COMMIT;

-- ----------------------------
--  Table structure for `jumper_info`
-- ----------------------------
DROP TABLE IF EXISTS `jumper_info`;
CREATE TABLE `jumper_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(64) DEFAULT NULL COMMENT '交换机IP',
  `port` varchar(128) DEFAULT NULL COMMENT '端口号',
  `wire_frame` varchar(128) DEFAULT NULL COMMENT '线架号',
  `wire_position` varchar(128) DEFAULT NULL COMMENT '线架位置',
  `point` varchar(128) DEFAULT NULL,
  `insert_no` varchar(128) DEFAULT NULL COMMENT '插口号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`ip`,`port`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `migration`
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `migration`
-- ----------------------------
BEGIN;
INSERT INTO `migration` VALUES ('m000000_000000_base', '1436856356'), ('m130524_201442_init', '1436856359'), ('m140506_102106_rbac_init', '1436856663');
COMMIT;

-- ----------------------------
--  Table structure for `session`
-- ----------------------------
DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` char(40) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `session`
-- ----------------------------
BEGIN;
INSERT INTO `session` VALUES ('0bm2vndg08svn60qtsoa5rdru6', '1438758381', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a323b), ('6d63at52klac0r4rai01oeloo4', '1438802670', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a343b), ('8bgr7vel0njj4dk9h5h81vbvo5', '1438659419', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a343b), ('9mph8lm0v9gho0ejb1r69ikaq4', '1438829194', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a343b), ('a9ih29vjv957c2dcvfoljm6p33', '1438276287', 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32353a222f746f706f6c6f67792f64617368626f6172642f696e646578223b5f5f69647c693a343b), ('c924qhs9qn530tgd636ah156d3', '1438838604', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a343b), ('dc561fbnthhpdh6pbejbfg6n27', '1438241355', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a343b), ('e4qitikisoul5fj4cv46e4en90', '1438665211', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a323b), ('eq8amuds7msk7ksgpq6gbaj592', '1438749526', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a323b), ('kjnrn51lcrh96k09qgo5lj1161', '1439089263', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a343b), ('kotif30qdbibbttf8omk04q2b0', '1438669802', 0x5f5f666c6173687c613a303a7b7d), ('mloldokqo7es20netv3qbvnqf5', '1438750028', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a323b), ('mnn06brju1drar7fpv7n49kfr6', '1438673558', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a323b), ('pner97ri1j3bbf09bho9cfv8d7', '1438743278', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a323b), ('qdnjdg0ecv33eenad45ftsoff0', '1438838599', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a343b), ('se87s7i57ffr0e35r2euqhkno4', '1438680275', 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a323b);
COMMIT;

-- ----------------------------
--  Table structure for `task`
-- ----------------------------
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `taskId` int(11) NOT NULL,
  `taskName` varchar(255) NOT NULL,
  `taskDescr` varchar(255) DEFAULT NULL,
  `tempId` varchar(255) DEFAULT NULL,
  `alarmOneThresholdFirst` double(11,0) DEFAULT '0',
  `alarmOneThresholdSecond` double(11,0) DEFAULT '0',
  `alarmTwoTimes` int(11) DEFAULT '0',
  `componentID` int(11) DEFAULT '0',
  `unitId` int(11) DEFAULT '0',
  `sumId` int(11) DEFAULT '0',
  `groupId` int(11) NOT NULL DEFAULT '0',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`taskId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `task`
-- ----------------------------
BEGIN;
INSERT INTO `task` VALUES ('1', '接口接收速率(bps)', '接口接收速率', '2048', '300000000', '0', '3', '0', '220', '1', '6', '2015-07-28 00:43:17'), ('2', 'CPU利用率(%)', 'CPU利用率', '1', '70', '0', '3', '0', '10', '1', '1', '2015-07-28 00:43:17'), ('4', '内存利用率(%)', '内存利用率', '2', '80', '0', '3', '0', '10', '1', '2', '2015-07-28 00:43:17'), ('5', '接口发送速率(bps)', '接口发送速率', '2049', '300000000', '0', '3', '0', '220', '1', '6', '2015-07-28 00:43:17'), ('6', '设备响应时间(ms)', '设备响应时间', '512', '50', '0', '3', '0', '100', '1', '3', '2015-07-28 00:43:17'), ('8', '设备不可达性比例(%)', '设备不可达性比例', '513', '10', '0', '3', '0', '10', '1', '3', '2015-07-28 00:43:17'), ('9', '接口输入带宽利用率(%)', '接口输入带宽利用率', '2052', '60', '0', '3', '0', '10', '1', '6', '2015-07-28 00:43:17'), ('13', '接口输出带宽利用率(%)', '接口输出带宽利用率', '2053', '60', '0', '3', '0', '10', '1', '6', '2015-07-28 00:43:17'), ('14', '接收IP报文速率(datagrams/s)', '接收IP报文速率', '3072', '100000', '0', '3', '0', '40', '1', '4', '2015-07-28 00:43:17'), ('16', '转发IP报文速率(datagrams/s)', '转发IP报文速率', '3073', '100000', '0', '3', '0', '40', '1', '4', '2015-07-28 00:43:17'), ('17', '接口接收广播包速率(packets/s)', '接口接收广播包速率', '2064', '100000', '0', '3', '0', '30', '1', '6', '2015-07-28 00:43:17'), ('18', '输入IP报文丢弃率(%)', '输入IP报文丢弃率', '3074', '0', '0', '3', '0', '10', '1', '4', '2015-07-28 00:43:17'), ('20', '输出IP报文丢弃率(%)', '输出IP报文丢弃率', '3075', '0', '0', '3', '0', '10', '1', '4', '2015-07-28 00:43:17'), ('25', '接口发送广播包速率(packets/s)', '接口发送广播包速率', '2065', '100000', '0', '3', '0', '30', '1', '6', '2015-07-28 00:43:17'), ('33', '接口输入包丢弃率(%)', '接口输入包丢弃率', '2067', '0', '0', '3', '0', '10', '1', '6', '2015-07-28 00:43:17'), ('41', '接口输出包丢弃率(%)', '接口输出包丢弃率', '2068', '0', '0', '3', '0', '10', '1', '6', '2015-07-28 00:43:17'), ('49', '实体温度(Celsius)', '实体温度', '521', '60', '0', '3', '0', '400', '1', '11', '2015-07-28 00:43:17'), ('50', '客户端视频连接建立请求次数', '客户端视频连接建立请求次数', '12001', '40', '0', '3', '0', '0', '4', '1', '2015-07-28 00:43:17'), ('52', '分发服务器转发的最大并发连接数', '分发服务器转发的最大并发连接数', '12101', '200', '0', '3', '0', '0', '4', '3', '2015-07-28 00:43:17'), ('54', '客户端视频连接建立请求成功比例(%)', '客户端视频连接建立请求成功比例', '12002', '80', '0', '3', '0', '10', '4', '1', '2015-07-28 00:43:17'), ('56', '分发服务器转发的总时长', '分发服务器转发的总时长', '12102', '60000', '0', '3', '0', '0', '4', '3', '2015-07-28 00:43:17'), ('58', '客户端视频连接建立请求失败次数', '客户端视频连接建立请求失败次数', '12003', '10', '0', '3', '0', '0', '4', '1', '2015-07-28 00:43:17'), ('60', '分发服务器转发的总连接数', '分发服务器转发的总连接数', '12103', '200', '0', '3', '0', '0', '4', '3', '2015-07-28 00:43:17'), ('62', '客户端视频连接释放请求次数', '客户端视频连接释放请求次数', '12004', '40', '0', '3', '0', '0', '4', '1', '2015-07-28 00:43:17'), ('64', '分发服务器转发的平均连接数', '分发服务器转发的平均连接数', '12104', '200', '0', '3', '0', '0', '4', '3', '2015-07-28 00:43:17'), ('66', '客户端视频连接释放请求成功比例(%)', '客户端视频连接释放请求成功比例', '12005', '80', '0', '3', '0', '10', '4', '1', '2015-07-28 00:43:17'), ('68', '分发服务器点播的最大并发连接数', '分发服务器点播的最大并发连接数', '12105', '100', '0', '3', '0', '0', '4', '4', '2015-07-28 00:43:17'), ('70', '客户端视频连接释放请求失败次数', '客户端视频连接释放请求失败次数', '12006', '10', '0', '3', '0', '0', '4', '1', '2015-07-28 00:43:17'), ('72', '分发服务器点播的总时长', '分发服务器点播的总时长', '12106', '30000', '0', '3', '0', '0', '4', '4', '2015-07-28 00:43:17'), ('74', '客户端视频连接异常终止次数', '客户端视频连接异常终止次数', '12007', '5', '0', '3', '0', '0', '4', '1', '2015-07-28 00:43:17'), ('76', '分发服务器点播的总连接数', '分发服务器点播的总连接数', '12107', '100', '0', '3', '0', '0', '4', '4', '2015-07-28 00:43:17'), ('78', 'IVS设备硬盘占用率(%)', 'IVS设备硬盘占用率', '12008', '80', '0', '3', '0', '10', '4', '2', '2015-07-28 00:43:17'), ('80', '分发服务器点播的平均连接数', '分发服务器点播的平均连接数', '12108', '100', '0', '3', '0', '0', '4', '4', '2015-07-28 00:43:17'), ('82', '前端设备在线情况', '前端设备在线情况', '12201', '0', '0', '3', '0', '0', '4', '6', '2015-07-28 00:43:17'), ('84', '分发服务器录像的最大并发连接数', '分发服务器录像的最大并发连接数', '12109', '100', '0', '3', '0', '0', '4', '5', '2015-07-28 00:43:17'), ('86', '监控点在线情况', '监控点在线情况', '12202', '0', '0', '3', '0', '0', '4', '7', '2015-07-28 00:43:17'), ('88', '分发服务器录像的总时长', '分发服务器录像的总时长', '12110', '30000', '0', '3', '0', '0', '4', '5', '2015-07-28 00:43:17'), ('90', '监控点视频错误率(%)', '监控点视频错误率', '12203', '50', '0', '3', '0', '10', '4', '7', '2015-07-28 00:43:17'), ('92', '分发服务器录像的总连接数', '分发服务器录像的总连接数', '12111', '100', '0', '3', '0', '0', '4', '5', '2015-07-28 00:43:17'), ('94', '输入的视频信号报文数', '输入的视频信号报文数', '12204', '100', '0', '3', '0', '0', '4', '8', '2015-07-28 00:43:17'), ('96', '分发服务器录像的平均连接数', '分发服务器录像的平均连接数', '12112', '100', '0', '3', '0', '0', '4', '5', '2015-07-28 00:43:17'), ('98', '输入的视频信号关键帧数', '输入的视频信号关键帧数', '12205', '25', '0', '3', '0', '0', '4', '8', '2015-07-28 00:43:17'), ('100', '视频信号报文丢失率(%)', '视频信号报文丢失率', '12206', '20', '0', '3', '0', '10', '4', '8', '2015-07-28 00:43:17'), ('102', '视频信号关键帧丢失率(%)', '视频信号关键帧丢失率', '12207', '20', '0', '3', '0', '10', '4', '8', '2015-07-28 00:43:17'), ('600', '输入IP报文丢弃数(datagrams)', '输入IP报文丢弃数', '3076', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17'), ('601', '输出IP报文丢弃数(datagrams)', '输出IP报文丢弃数', '3077', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17'), ('602', '路由失败的IP报文数(datagrams)', '路由失败的IP报文数', '3078', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17'), ('603', '分片失败的IP报文数(datagrams)', '分片失败的IP报文数', '3079', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17'), ('604', '接收报文头错误的IP报文数(datagrams)', '接收报文头错误的IP报文数', '3080', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17'), ('605', '地址错误的IP报文数(datagrams)', '地址错误的IP报文数', '3081', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17'), ('606', '接收的未知协议报文数(datagrams)', '接收的未知协议报文数', '3082', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17'), ('607', 'IP报文重组失败次数', 'IP报文重组失败次数', '3083', '100000', '0', '3', '0', '0', '1', '5', '2015-07-28 00:43:17'), ('630', '接收TCP段速率(segments/s)', '接收TCP段速率(segments/s)', '4096', '100000', '0', '3', '0', '50', '1', '8', '2015-07-28 00:43:17'), ('631', '发送TCP段速率(segments/s)', '发送TCP段速率(segments/s)', '4097', '100000', '0', '3', '0', '50', '1', '8', '2015-07-28 00:43:17'), ('632', '接收的错误TCP段数(segments)', '接收的错误TCP段数', '4098', '100000', '0', '3', '0', '90', '1', '8', '2015-07-28 00:43:17'), ('633', '发送带RST标志的TCP段数(segments)', '发送带RST标志的TCP段数', '4099', '100000', '0', '3', '0', '90', '1', '8', '2015-07-28 00:43:17'), ('650', '接收UDP报文速率(datagrams/s)', '接收UDP报文速率(datagrams/s)', '5120', '100000', '0', '3', '0', '40', '1', '9', '2015-07-28 00:43:17'), ('651', '发送UDP报文速率(datagrams/s)', '发送UDP报文速率(datagrams/s)', '5121', '100000', '0', '3', '0', '40', '1', '9', '2015-07-28 00:43:17'), ('652', '目的端口错误的UDP报文数(datagrams)', '目的端口错误的UDP报文数', '5123', '100000', '0', '3', '0', '80', '1', '9', '2015-07-28 00:43:17'), ('653', '接收的错误UDP报文数(datagrams)', '接收的错误UDP报文数', '5124', '100000', '0', '3', '0', '80', '1', '9', '2015-07-28 00:43:17'), ('670', '验证名错误的SNMP报文数(datagrams)', '验证名错误的SNMP报文数', '6144', '100000', '0', '3', '0', '80', '1', '10', '2015-07-28 00:43:17'), ('671', '非法操作的SNMP报文数(datagrams)', '非法操作的SNMP报文数', '6145', '100000', '0', '3', '0', '80', '1', '10', '2015-07-28 00:43:17'), ('672', '接收的错误SNMP报文数(datagrams)', '接收的错误SNMP报文数', '6146', '100000', '0', '3', '0', '80', '1', '10', '2015-07-28 00:43:17'), ('700', 'IKE通道接收速率(Bps)', 'IKE通道接收速率(bytes/s)', '8192', '100000', '0', '3', '0', '20', '2', '1', '2015-07-28 00:43:17'), ('701', 'IKE通道接收速率(packets/s)', 'IKE通道接收速率(packets/s)', '8193', '100000', '0', '3', '0', '30', '2', '1', '2015-07-28 00:43:17'), ('702', 'IKE通道丢弃输入报文包数(packets)', 'IKE通道丢弃输入报文包数', '8194', '100000', '0', '3', '0', '70', '2', '1', '2015-07-28 00:43:17'), ('703', 'IKE通道发送速率(Bps)', 'IKE通道发送速率(bytes/s)', '8195', '100000', '0', '3', '0', '20', '2', '1', '2015-07-28 00:43:17'), ('704', 'IKE通道发送速率(packets/s)', 'IKE通道发送速率(packets/s)', '8196', '100000', '0', '3', '0', '30', '2', '1', '2015-07-28 00:43:17'), ('705', 'IKE通道丢弃输出报文包数(packets)', 'IKE通道丢弃输出报文包数', '8197', '100000', '0', '3', '0', '70', '2', '1', '2015-07-28 00:43:17'), ('720', '活跃的IKE通道数', '活跃的IKE通道数', '9216', '10', '0', '3', '0', '0', '2', '2', '2015-07-28 00:43:17'), ('721', '所有IKE通道接收速率(Bps)', '所有IKE通道接收速率(bytes/s)', '9217', '100000', '0', '3', '0', '20', '2', '2', '2015-07-28 00:43:17'), ('722', '所有IKE通道接收速率(packets/s)', '所有IKE通道接收速率(packets/s)', '9218', '100000', '0', '3', '0', '30', '2', '2', '2015-07-28 00:43:17'), ('723', '所有IKE通道丢弃输入报文包数(packets)', '所有IKE通道丢弃输入报文包数', '9219', '100000', '0', '3', '0', '70', '2', '2', '2015-07-28 00:43:17'), ('724', '所有IKE通道发送速率(Bps)', '所有IKE通道发送速率(bytes/s)', '9220', '100000', '0', '3', '0', '20', '2', '2', '2015-07-28 00:43:17'), ('725', '所有IKE通道发送速率(packets/s)', '所有IKE通道发送速率(packets/s)', '9221', '100000', '0', '3', '0', '30', '2', '2', '2015-07-28 00:43:17'), ('726', '所有IKE通道丢弃输出报文包数(packets)', '所有IKE通道丢弃输出报文包数', '9222', '100000', '0', '3', '0', '70', '2', '2', '2015-07-28 00:43:17'), ('727', '本地初始化的IKE通道数增长量', '本地初始化的IKE通道数增长量', '9223', '10', '0', '3', '0', '0', '2', '2', '2015-07-28 00:43:17'), ('728', '本地初始化失败的IKE通道数', '本地初始化失败的IKE通道数', '9224', '10', '0', '3', '0', '0', '2', '2', '2015-07-28 00:43:17'), ('729', '远端初始化的IKE通道数增长量', '远端初始化的IKE通道数增长量', '9225', '10', '0', '3', '0', '0', '2', '2', '2015-07-28 00:43:17'), ('730', '远端初始化失败的IKE通道数', '远端初始化失败的IKE通道数', '9226', '10', '0', '3', '0', '0', '2', '2', '2015-07-28 00:43:17'), ('750', 'IPSec通道接收速率(Bps)', 'IPSec通道接收速率(bytes/s)', '10240', '100000', '0', '3', '0', '20', '2', '3', '2015-07-28 00:43:17'), ('751', 'IPSec通道接收速率(packets/s)', 'IPSec通道接收速率(packets/s)', '10241', '100000', '0', '3', '0', '30', '2', '3', '2015-07-28 00:43:17'), ('752', 'IPSec通道丢弃输入报文包数(packets)', 'IPSec通道丢弃输入报文包数', '10242', '100000', '0', '3', '0', '70', '2', '3', '2015-07-28 00:43:17'), ('753', 'IPSec通道发送速率(Bps)', 'IPSec通道发送速率(bytes/s)', '10243', '100000', '0', '3', '0', '20', '2', '3', '2015-07-28 00:43:17'), ('754', 'IPSec通道发送速率(packets/s)', 'IPSec通道发送速率(packets/s)', '10244', '100000', '0', '3', '0', '30', '2', '3', '2015-07-28 00:43:17'), ('755', 'IPSec通道丢弃输出报文包数(packets)', 'IPSec通道丢弃输出报文包数', '10245', '100000', '0', '3', '0', '70', '2', '3', '2015-07-28 00:43:17'), ('756', 'IPSec通道入方向报文丢弃率(%)', 'IPSec通道入方向报文丢弃率(%)', '10246', '0', '0', '3', '0', '10', '2', '3', '2015-07-28 00:43:17'), ('757', 'IPSec通道出方向报文丢弃率(%)', 'IPSec通道出方向报文丢弃率(%)', '10247', '0', '0', '3', '0', '10', '2', '3', '2015-07-28 00:43:17'), ('770', '活跃的IPSec通道数', '活跃的IPSec通道数', '11264', '10', '0', '3', '0', '0', '2', '4', '2015-07-28 00:43:17'), ('771', '活跃的IPSec SA数', '活跃的IPSec SA数', '11265', '10', '0', '3', '0', '0', '2', '4', '2015-07-28 00:43:17'), ('772', '所有IPSec通道接收速率(Bps)', '所有IPSec通道接收速率(bytes/s)', '11266', '100000', '0', '3', '0', '20', '2', '4', '2015-07-28 00:43:17'), ('773', '所有IPSec通道接收速率(packets/s)', '所有IPSec通道接收速率(packets/s)', '11267', '100000', '0', '3', '0', '30', '2', '4', '2015-07-28 00:43:17'), ('774', '所有IPSec通道丢弃输入报文包数(packets)', '所有IPSec通道丢弃输入报文包数', '11268', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17'), ('775', '所有IPSec通道丢弃重复输入报文包数(packets)', '所有IPSec通道丢弃重复输入报文包数', '11269', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17'), ('776', '所有IPSec通道输入过程认证失败次数', '所有IPSec通道输入过程认证失败次数', '11270', '10', '0', '3', '0', '0', '2', '4', '2015-07-28 00:43:17'), ('777', '所有IPSec通道输入过程解密失败次数', '所有IPSec通道输入过程解密失败次数', '11271', '10', '0', '3', '0', '0', '2', '4', '2015-07-28 00:43:17'), ('778', '所有IPSec通道发送速率(Bps)', '所有IPSec通道发送速率(bytes/s)', '11272', '100000', '0', '3', '0', '20', '2', '4', '2015-07-28 00:43:17'), ('779', '所有IPSec通道发送速率(packets/s)', '所有IPSec通道发送速率(packets/s)', '11273', '100000', '0', '3', '0', '30', '2', '4', '2015-07-28 00:43:17'), ('780', '所有IPSec通道丢弃输出报文包数(packets)', '所有IPSec通道丢弃输出报文包数', '11274', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17'), ('781', '所有IPSec通道因内存不足丢弃报文包数(packets)', '所有IPSec通道因内存不足丢弃报文包数', '11275', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17'), ('782', '所有IPSec通道因未发现SA丢弃报文包数(packets)', '所有IPSec通道因未发现SA丢弃报文包数', '11276', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17'), ('783', '所有IPSec通道因队列已满丢弃报文包数(packets)', '所有IPSec通道因队列已满丢弃报文包数', '11277', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17'), ('784', '所有IPSec通道因长度无效丢弃报文包数(packets)', '所有IPSec通道因长度无效丢弃报文包数', '11278', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17'), ('785', '所有IPSec通道因报文太长丢弃报文包数(packets)', '所有IPSec通道因报文太长丢弃报文包数', '11279', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17'), ('786', '所有IPSec通道因SA无效丢弃报文包数(packets)', '所有IPSec通道因SA无效丢弃报文包数', '11280', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17'), ('787', '所有IPSec通道入方向报文丢弃率(%)', '所有IPSec通道入方向报文丢弃率(%)', '11282', '0', '0', '3', '0', '10', '2', '4', '2015-07-28 00:43:17'), ('788', '所有IPSec通道出方向报文丢弃率(%)', '所有IPSec通道出方向报文丢弃率(%)', '11283', '0', '0', '3', '0', '10', '2', '4', '2015-07-28 00:43:17'), ('800', 'QoS匹配速率(packets/s)', 'QoS匹配速率(packets/s)', '6500', '100000', '0', '3', '0', '30', '8', '1', '2015-07-28 00:43:17'), ('801', 'QoS匹配速率(Bps)', 'QoS匹配速率(bytes/s)', '6501', '100000', '0', '3', '0', '20', '8', '1', '2015-07-28 00:43:17'), ('802', '符合CIR的报文速率(packets/s)', '符合CIR的报文速率(packets/s)', '6502', '100000', '0', '3', '0', '30', '8', '2', '2015-07-28 00:43:17'), ('803', '符合CIR的报文速率(Bps)', '符合CIR的报文速率(bytes/s)', '6503', '100000', '0', '3', '0', '20', '8', '2', '2015-07-28 00:43:17'), ('804', '不符合CIR的报文速率(packets/s)', '不符合CIR的报文速率(packets/s)', '6504', '100000', '0', '3', '0', '30', '8', '2', '2015-07-28 00:43:17'), ('805', '不符合CIR的报文速率(Bps)', '不符合CIR的报文速率(bytes/s)', '6505', '100000', '0', '3', '0', '20', '8', '2', '2015-07-28 00:43:17'), ('806', 'GTS方式通过的报文速率(packets/s)', 'GTS方式通过的报文速率(packets/s)', '6506', '100000', '0', '3', '0', '30', '8', '3', '2015-07-28 00:43:17'), ('807', 'GTS方式通过的报文速率(Bps)', 'GTS方式通过的报文速率(bytes/s)', '6507', '100000', '0', '3', '0', '20', '8', '3', '2015-07-28 00:43:17'), ('808', 'GTS方式丢弃的报文速率(packets/s)', 'GTS方式丢弃的报文速率(packets/s)', '6508', '100000', '0', '3', '0', '30', '8', '3', '2015-07-28 00:43:17'), ('809', 'GTS方式丢弃的报文速率(Bps)', 'GTS方式丢弃的报文速率(bytes/s)', '6509', '100000', '0', '3', '0', '20', '8', '3', '2015-07-28 00:43:17'), ('810', 'GTS方式延迟报文速率(packets/s)', 'GTS方式延迟报文速率(packets/s)', '6510', '100000', '0', '3', '0', '30', '8', '3', '2015-07-28 00:43:17'), ('811', 'GTS方式延迟报文速率(Bps)', 'GTS方式延迟报文速率(bytes/s)', '6511', '100000', '0', '3', '0', '20', '8', '3', '2015-07-28 00:43:17'), ('812', '队列方式匹配的报文速率(packets/s)', '队列方式匹配的报文速率(packets/s)', '6512', '100000', '0', '3', '0', '30', '8', '4', '2015-07-28 00:43:17'), ('813', '队列方式匹配的报文速率(Bps)', '队列方式匹配的报文速率(bytes/s)', '6513', '100000', '0', '3', '0', '20', '8', '4', '2015-07-28 00:43:17'), ('816', '队列方式正常通过的报文速率(packets/s)', '队列方式正常通过的报文速率(packets/s)', '6516', '100000', '0', '3', '0', '30', '8', '4', '2015-07-28 00:43:17'), ('817', '队列方式正常通过的报文速率(Bps)', '队列方式正常通过的报文速率(bytes/s)', '6517', '100000', '0', '3', '0', '20', '8', '4', '2015-07-28 00:43:17'), ('818', '队列方式丢弃的报文速率(packets/s)', '队列方式丢弃的报文速率(packets/s)', '6518', '100000', '0', '3', '0', '30', '8', '4', '2015-07-28 00:43:17'), ('819', '队列方式丢弃的报文速率(Bps)', '队列方式丢弃的报文速率(bytes/s)', '6519', '100000', '0', '3', '0', '20', '8', '4', '2015-07-28 00:43:17'), ('851', 'CPU利用率(%)', 'CPU利用率', '28001', '60', '0', '3', '58', '10', '18', '1', '2015-07-28 00:43:17'), ('852', '内存利用率(%)', '内存利用率', '28002', '60', '0', '3', '58', '10', '18', '2', '2015-07-28 00:43:17'), ('853', '活动内存(Kbytes)', '活动内存', '28003', '3000000', '0', '3', '58', '61', '18', '2', '2015-07-28 00:43:17'), ('854', '共享的公用内存(Kbytes)', '共享的公用内存', '28004', '3000000', '0', '3', '58', '61', '18', '2', '2015-07-28 00:43:17'), ('855', '已分配内存(Kbytes)', '已分配内存', '28005', '10000', '0', '3', '58', '61', '18', '2', '2015-07-28 00:43:17'), ('856', '虚拟增长内存(Kbytes)', '虚拟增长内存', '28006', '10000', '0', '3', '58', '61', '18', '2', '2015-07-28 00:43:17'), ('857', '磁盘读速率(KBps)', '磁盘读速率', '28007', '10000', '0', '3', '58', '21', '18', '3', '2015-07-28 00:43:17'), ('858', '磁盘写速率(KBps)', '磁盘写速率', '28008', '10000', '0', '3', '58', '21', '18', '3', '2015-07-28 00:43:17'), ('859', '磁盘I/0速率(KBps)', '磁盘I/0速率', '28009', '10000', '0', '3', '58', '21', '18', '3', '2015-07-28 00:43:17'), ('860', '网络接收速率(KBps)', '网络接收速率', '28010', '10000', '0', '3', '58', '21', '18', '4', '2015-07-28 00:43:17'), ('861', '网络发送速率(KBps)', '网络发送速率', '28011', '10000', '0', '3', '58', '21', '18', '4', '2015-07-28 00:43:17'), ('862', '网络速率(KBps)', '网络速率', '28012', '10000', '0', '3', '58', '21', '18', '4', '2015-07-28 00:43:17'), ('900', '路由地址丢弃率(overload/s)', '路由地址丢弃率(overload/s)', '17', '70', '0', '3', '0', '140', '1', '111', '2015-07-28 00:43:17'), ('901', 'STP拓扑变化率(times/s)', 'STP拓扑变化率(times/s)', '18', '10', '0', '3', '0', '150', '1', '111', '2015-07-28 00:43:17'), ('902', '硬件监控', '硬件监控', '20', '1', '0', '3', '0', '0', '1', '111', '2015-07-28 00:43:17'), ('903', '实体扩展MIB内存总量(Mbytes)', '实体扩展MIB内存总量', '601', '100000', '0', '3', '0', '160', '1', '111', '2015-07-28 00:43:17'), ('905', '实体扩展MIB已用内存总量(Mbytes)', '实体扩展MIB已用内存总量', '603', '100000', '0', '3', '0', '160', '1', '111', '2015-07-28 00:43:17'), ('906', '服务器存储空间利用率(%)', '服务器存储空间利用率(%)', '16', '70', '0', '3', '0', '10', '1', '111', '2015-07-28 00:43:17'), ('907', 'Enterasys存储空间利用率(%)', 'Enterasys存储空间利用率(%)', '605', '70', '0', '3', '0', '10', '1', '111', '2015-07-28 00:43:17'), ('1000', '每秒E1接口收到错包总数(packets/s)', '每秒E1接口收到错包总数', '14001', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1001', '每秒E1接口收到的超短包的错误数(packets/s)', '每秒E1接口收到的超短包的错误数', '14002', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1002', '每秒E1接口收到的超长包的错误数(packets/s)', '每秒E1接口收到的超长包的错误数', '14003', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1003', '每秒E1接口收到的CRC错包数(packets/s)', '每秒E1接口收到的CRC错包数', '14004', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1004', '每秒E1接口收到的Align错包数(packets/s)', '每秒E1接口收到的Align错包数', '14005', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1005', '每秒E1接口收到的OverRun错包数(packets/s)', '每秒E1接口收到的OverRun错包数', '14006', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1006', '每秒E1接口收到的Dribble错包数(packets/s)', '每秒E1接口收到的Dribble错包数', '14007', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1007', '每秒E1接口收到的AbortedSeq错包数(packets/s)', '每秒E1接口收到的AbortedSeq错包数', '14008', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1008', '每秒E1接口收到的NoBuffer错包数(packets/s)', '每秒E1接口收到的NoBuffer错包数', '14009', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1009', '每秒E1接口收到的Framing错包数(packets/s)', '每秒E1接口收到的Framing错包数', '14010', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1010', '每秒E1接口发出的错包总数(packets/s)', '每秒E1接口发出的错包总数', '14011', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1011', '每秒E1接口发出的UnderRun错包数(packets/s)', '每秒E1接口发出的UnderRun错包数', '14012', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1012', '每秒E1接口发出的Collison错包数(packets/s)', '每秒E1接口发出的Collison错包数', '14013', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1013', '每秒E1接口发出的OutDefered错包数(packets/s)', '每秒E1接口发出的OutDefered错包数', '14014', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17'), ('1030', '每秒T1接口收到错包总数(packets/s)', '每秒T1接口收到错包总数', '15001', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1031', '每秒T1接口收到的超短包的错误数(packets/s)', '每秒T1接口收到的超短包的错误数', '15002', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1032', '每秒T1接口收到的超长包的错误数(packets/s)', '每秒T1接口收到的超长包的错误数', '15003', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1033', '每秒T1接口收到的CRC错包数(packets/s)', '每秒T1接口收到的CRC错包数', '15004', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1034', '每秒T1接口收到的Align错包数(packets/s)', '每秒T1接口收到的Align错包数', '15005', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1035', '每秒T1接口收到的OverRun错包数(packets/s)', '每秒T1接口收到的OverRun错包数', '15006', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1036', '每秒T1接口收到的Dribble错包数(packets/s)', '每秒T1接口收到的Dribble错包数', '15007', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1037', '每秒T1接口收到的AbortedSeq错包数(packets/s)', '每秒T1接口收到的AbortedSeq错包数', '15008', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1038', '每秒T1接口收到的NoBuffer错包数(packets/s)', '每秒T1接口收到的NoBuffer错包数', '15009', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1039', '每秒T1接口收到的Framing错包数(packets/s)', '每秒T1接口收到的Framing错包数', '15010', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1040', '每秒T1接口发出的错包总数(packets/s)', '每秒T1接口发出的错包总数', '15011', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1041', '每秒T1接口发出的UnderRun错包数(packets/s)', '每秒T1接口发出的UnderRun错包数', '15012', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1042', '每秒T1接口发出的Collison错包数(packets/s)', '每秒T1接口发出的Collison错包数', '15013', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1043', '每秒T1接口发出的OutDefered错包数(packets/s)', '每秒T1接口发出的OutDefered错包数', '15014', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17'), ('1060', '每秒PPP接收到错误地址域的包数(packets/s)', '每秒PPP接收到错误地址域的包数', '16001', '100000', '0', '3', '0', '30', '9', '3', '2015-07-28 00:43:17'), ('1061', '每秒PPP接收到错误控制域的包数(packets/s)', '每秒PPP接收到错误控制域的包数', '16002', '100000', '0', '3', '0', '30', '9', '3', '2015-07-28 00:43:17'), ('1062', '每秒PPP长度超过MRU而丢弃的包数(packets/s)', '每秒PPP长度超过MRU而丢弃的包数', '16003', '100000', '0', '3', '0', '30', '9', '3', '2015-07-28 00:43:17'), ('1063', '每秒PPP包含错误的FCS而丢弃的包数(packets/s)', '每秒PPP包含错误的FCS而丢弃的包数', '16004', '100000', '0', '3', '0', '30', '9', '3', '2015-07-28 00:43:17'), ('1080', 'MP链路绑定的下一级信道数', 'MP链路绑定的下一级信道数', '17001', '10', '0', '3', '0', '0', '9', '4', '2015-07-28 00:43:17'), ('1081', '每秒MP链路丢弃的错误的数据块数(packets/s)', '每秒MP链路丢弃的错误的数据块数', '17002', '100000', '0', '3', '0', '30', '9', '4', '2015-07-28 00:43:17'), ('1082', '每秒MP链路已重排序的接收包数(packets/s)', '每秒MP链路已重排序的接收包数', '17003', '100000', '0', '3', '0', '30', '9', '4', '2015-07-28 00:43:17'), ('1083', '每秒MP链路等待重排序的接收包数(packets/s)', '每秒MP链路等待重排序的接收包数', '17004', '100000', '0', '3', '0', '30', '9', '4', '2015-07-28 00:43:17'), ('1084', '每秒MP链路根据包序交叉存取的接收包数(packets/s)', '每秒MP链路根据包序交叉存取的接收包数', '17005', '100000', '0', '3', '0', '30', '9', '4', '2015-07-28 00:43:17'), ('1300', '接口接收错误包数(packets)', '接口接收错误包数', '2056', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17'), ('1301', '接口发送错误包数(packets)', '接口发送错误包数', '2057', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17'), ('1302', '接口丢弃的输入包数(packets)', '接口丢弃的输入包数', '2058', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17'), ('1303', '接口丢弃的输出包数(packets)', '接口丢弃的输出包数', '2059', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17'), ('1304', '接口接收速率(packets/s)', '接口接收速率(packets/s)', '2060', '100000', '0', '3', '0', '30', '1', '7', '2015-07-28 00:43:17'), ('1305', '接口发送速率(packets/s)', '接口发送速率(packets/s)', '2061', '100000', '0', '3', '0', '30', '1', '7', '2015-07-28 00:43:17'), ('1306', '接口接收多播包速率(packets/s)', '接口接收多播包速率(packets/s)', '2062', '100000', '0', '3', '0', '30', '1', '7', '2015-07-28 00:43:17'), ('1307', '接口发送多播包速率(packets/s)', '接口发送多播包速率(packets/s)', '2063', '100000', '0', '3', '0', '30', '1', '7', '2015-07-28 00:43:17'), ('1308', '接口接收的未知协议包数(packets)', '接口接收的未知协议包数', '2066', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17'), ('1309', '接口输入包错误率(%)', '接口输入包错误率(%)', '2069', '0', '0', '3', '0', '10', '1', '7', '2015-07-28 00:43:17'), ('1310', '接口输出包错误率(%)', '接口输出包错误率(%)', '2070', '0', '0', '3', '0', '10', '1', '7', '2015-07-28 00:43:17'), ('1311', '接口失效率(%)', '接口失效率(%)', '2071', '0', '0', '3', '0', '10', '1', '7', '2015-07-28 00:43:17'), ('1312', '接口收发速率(bps)', '接口收发速率(ifmib，bits/s)', '2072', '100000', '0', '3', '0', '220', '1', '7', '2015-07-28 00:43:17'), ('1313', '接口收发速率(packets/s)', '接口收发速率(packets/s)', '2074', '100000', '0', '3', '0', '30', '1', '7', '2015-07-28 00:43:17'), ('1314', '设备错误包数(packets)', '设备错误包数(frames)', '2075', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17'), ('1315', '接口包错误率(%)', '接口包错误率(%)', '19', '0', '0', '3', '0', '10', '1', '7', '2015-07-28 00:43:17'), ('1316', '接口接收字节数(bytes)', '接口接收字节数(ifmib，bytes)', '6620', '100000', '0', '3', '0', '60', '1', '7', '2015-07-28 00:43:17'), ('1317', '接口发送字节数(bytes)', '接口发送字节数(ifmib，bytes)', '6621', '100000', '0', '3', '0', '60', '1', '7', '2015-07-28 00:43:17'), ('1318', '接口接收包数(packets)', '接口接收包数(packets)', '6626', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17'), ('1319', '接口发送包数(packets)', '接口发送包数(packets)', '6627', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17'), ('1320', '丢弃报文数目(packets)', '丢弃报文数目(packets)', '6628', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17'), ('1321', '错误报文数目(packets)', '错误报文数目(packets)', '6629', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17'), ('1400', 'PoE端口当前消耗功率(milliWatts)', 'PoE端口当前消耗功率(milliWatts)', '18001', '100000', '0', '3', '0', '200', '12', '1', '2015-07-28 00:43:17'), ('1402', 'PSE板平均消耗功率(Watts)', 'PSE板端口平均消耗功率(Watts)', '18002', '100', '0', '3', '0', '201', '12', '1', '2015-07-28 00:43:17'), ('1451', '光模块当前发送功率(dBm)', '光模块当前发送功率(dbmw)', '18501', '100000', '0', '3', '0', '130', '12', '2', '2015-07-28 00:43:17'), ('1461', '光模块当前接收功率(dBm)', '光模块当前接收功率(dbmw)', '18502', '100000', '0', '3', '0', '130', '12', '2', '2015-07-28 00:43:17'), ('1500', '每秒报文丢弃事件数', '每秒报文丢弃事件数', '19001', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1501', '接收字节速率(Bps)', '接收字节速率', '19002', '70', '0', '3', '0', '20', '11', '1', '2015-07-28 00:43:17'), ('1502', '接收报文速率(packets/s)', '接收报文速率', '19003', '70', '0', '3', '0', '30', '11', '1', '2015-07-28 00:43:17'), ('1503', '接收广播报文速率(packets/s)', '接收广播报文速率', '19004', '70', '0', '3', '0', '30', '11', '1', '2015-07-28 00:43:17'), ('1504', '接收多播报文速率(packets/s)', '接收多播报文速率', '19005', '70', '0', '3', '0', '30', '11', '1', '2015-07-28 00:43:17'), ('1505', '每秒CRC校验错误报文数', '每秒CRC校验错误报文数', '19006', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1506', '每秒接收少于64字节报文数', '每秒接收少于64字节报文数', '19007', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1507', '每秒接收超过1518字节报文数', '每秒接收超过1518字节报文数', '19008', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1508', '每秒接收少于64字节且FCS错误报文数', '每秒接收少于64字节且FCS错误报文数', '19009', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1509', '每秒接收超过1518字节报文数且FCS错误报文数', '每秒接收超过1518字节报文数且FCS错误报文数', '19010', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1510', '每秒网络冲突速数', '每秒网络冲突速数', '19011', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1511', '每秒接收64字节报文数', '每秒接收64字节报文数', '19012', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1512', '每秒接收65至127字节报文数', '每秒接收65至127字节报文数', '19013', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1513', '每秒接收128至255字节报文数', '每秒接收128至255字节报文数', '19014', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1514', '每秒接收256至511字节报文数', '每秒接收256至511字节报文数', '19015', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1515', '每秒接收512至1023字节报文数', '每秒接收512至1023字节报文数', '19016', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1516', '每秒接收1024至1518字节报文数', '每秒接收1024至1518字节报文数', '19017', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17'), ('1600', '单个主叫号码每分钟接收报文数(packets/min)', '单个主叫号码每分钟接收报文数', '31600', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17'), ('1601', '单个主叫号码每分钟发送报文数(packets/min)', '单个主叫号码每分钟发送报文数', '31601', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17'), ('1602', '单个主叫号码每分钟因格式错误丢弃的报文数(packets/min)', '单个主叫号码每分钟因格式错误丢弃的报文数', '31602', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17'), ('1603', '单个主叫号码每分钟因映射处理错误丢弃的报文数(packets/min)', '单个主叫号码每分钟因映射处理错误丢弃的报文数', '31603', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17'), ('1604', '单个主叫号码每分钟因接收缓存满丢弃的报文数(packets/min)', '单个主叫号码每分钟因接收缓存满丢弃的报文数', '31604', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17'), ('1605', '单个主叫号码每分钟因链路不通丢弃的报文数(packets/min)', '单个主叫号码每分钟因链路不通丢弃的报文数', '31605', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17'), ('1610', '单个POS终端每分钟接收报文数(packets/min)', '单个POS终端每分钟接收报文数', '31620', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17'), ('1611', '单个POS终端每分钟发送报文数(packets/min)', '单个POS终端每分钟发送报文数', '31621', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17'), ('1612', '单个POS终端每分钟因格式错误丢弃的报文数(packets/min)', '单个POS终端每分钟因格式错误丢弃的报文数', '31622', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17'), ('1613', '单个POS终端每分钟因映射处理错误丢弃的报文数(packets/min)', '单个POS终端每分钟因映射处理错误丢弃的报文数', '31623', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17'), ('1614', '单个POS终端每分钟因接收缓存满丢弃的报文数(packets/min)', '单个POS终端每分钟因接收缓存满丢弃的报文数', '31624', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17'), ('1615', '单个POS终端每分钟因链路不通丢弃的报文数(packets/min)', '单个POS终端每分钟因链路不通丢弃的报文数', '31625', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17'), ('1620', '单个IP终端交易统计项每分钟接收报文数(packets/min)', '单个IP终端交易统计项每分钟接收报文数', '31640', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17'), ('1621', '单个IP终端交易统计项每分钟发送报文数(packets/min)', '单个IP终端交易统计项每分钟发送报文数', '31641', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17'), ('1622', '单个IP终端交易统计项每分钟因格式错误丢弃的报文数(packets/min)', '单个IP终端交易统计项每分钟因格式错误丢弃的报文数', '31642', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17'), ('1623', '单个IP终端交易统计项每分钟因映射处理错误丢弃的报文数(packets/min)', '单个IP终端交易统计项每分钟因映射处理错误丢弃的报文数', '31643', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17'), ('1624', '单个IP终端交易统计项每分钟因接收缓存满丢弃的报文数(packets/min)', '单个IP终端交易统计项每分钟因接收缓存满丢弃的报文数', '31644', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17'), ('1625', '单个IP终端交易统计项每分钟因链路不通丢弃的报文数(packets/min)', '单个IP终端交易统计项每分钟因链路不通丢弃的报文数', '31645', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17'), ('1630', '单个POS应用每分钟接收报文数(packets/min)', '单个POS应用每分钟接收报文数', '31660', '0', '0', '3', '0', '230', '19', '4', '2015-07-28 00:43:17'), ('1631', '单个POS应用每分钟发送报文数(packets/min)', '单个POS应用每分钟发送报文数', '31661', '0', '0', '3', '0', '230', '19', '4', '2015-07-28 00:43:17'), ('1632', '单个POS应用每分钟因格式错误丢弃的报文数(packets/min)', '单个POS应用每分钟因格式错误丢弃的报文数', '31662', '0', '0', '3', '0', '230', '19', '4', '2015-07-28 00:43:17'), ('1634', '单个POS应用每分钟因接收缓存满丢弃的报文数(packets/min)', '单个POS应用每分钟因接收缓存满丢弃的报文数', '31664', '0', '0', '3', '0', '230', '19', '4', '2015-07-28 00:43:17'), ('1635', '单个POS应用每分钟因链路不通丢弃的报文数(packets/min)', '单个POS应用每分钟因链路不通丢弃的报文数', '31665', '0', '0', '3', '0', '230', '19', '4', '2015-07-28 00:43:17'), ('1636', 'E1通道占用率(%)', 'E1通道占用率(%)', '31666', '80', '0', '3', '0', '10', '19', '4', '2015-07-28 00:43:17'), ('1640', '单个FCM接口每分钟因交易超时而断开连接次数', '单个FCM接口每分钟因交易超时而断开连接次数', '31680', '0', '0', '3', '0', '0', '19', '5', '2015-07-28 00:43:17'), ('1641', '单个FCM接口每分钟拨号协商失败的次数', '单个FCM接口每分钟拨号协商失败的次数', '31681', '0', '0', '3', '0', '0', '19', '5', '2015-07-28 00:43:17'), ('1642', 'POS机拨号接通率(%)', 'POS机拨号接通率(%)', '31682', '80', '0', '3', '0', '10', '19', '5', '2015-07-28 00:43:17'), ('1643', 'IP-POS并发交易数量', 'IP-POS并发交易数量', '31706', '0', '0', '3', '0', '0', '19', '2', '2015-07-28 00:43:17'), ('1644', 'E1-POS并发交易数量', 'E1-POS并发交易数量', '31707', '0', '0', '3', '0', '0', '19', '2', '2015-07-28 00:43:17'), ('200101', '(系统<-客户端)输入包速率(packets/s)', '(系统<-客户端)输入包速率', '50101', '10000000', '0', '3', '0', '30', '24', '1', '2015-07-28 00:43:17'), ('200102', '(系统->客户端)输出包速率(packets/s)', '(系统->客户端)输出包速率', '50102', '10000000', '0', '3', '0', '30', '24', '1', '2015-07-28 00:43:17'), ('200103', '(系统<-客户端)数据接收速率(bps)', '(系统<-客户端)数据接收速率', '50103', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17'), ('200104', '(系统->客户端)数据发送速率(bps)', '(系统->客户端)数据发送速率', '50104', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17'), ('200105', '(系统<->客户端)最大连接数', '(系统<->客户端)最大连接数', '50105', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17'), ('200106', '(系统<->客户端)所有连接数', '(系统<->客户端)所有连接数', '50106', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17'), ('200107', '(系统<->客户端)当前连接数', '(系统<->客户端)当前连接数', '50107', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17'), ('200108', '(系统<->客户端)数据收发速率(bps)', '(系统<->客户端)数据收发速率', '50108', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17'), ('200201', '(系统<-服务端)输入包速率(packets/s)', '(系统<-服务端)输入包速率', '50201', '10000000', '0', '3', '0', '30', '24', '1', '2015-07-28 00:43:17'), ('200202', '(系统->服务端)输出包速率(packets/s)', '(系统->服务端)输出包速率', '50202', '10000000', '0', '3', '0', '30', '24', '1', '2015-07-28 00:43:17'), ('200203', '(系统<-服务端)数据接收速率(bps)', '(系统<-服务端)数据接收速率', '50203', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17'), ('200204', '(系统->服务端)数据发送速率(bps)', '(系统->服务端)数据发送速率', '50204', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17'), ('200205', '(系统<->服务端)最大连接数', '(系统<->服务端)最大连接数', '50205', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17'), ('200206', '(系统<->服务端)所有连接数', '(系统<->服务端)所有连接数', '50206', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17'), ('200207', '(系统<->服务端)当前连接数', '(系统<->服务端)当前连接数', '50207', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17'), ('200208', '(系统<->服务端)数据收发速率(bps)', '(系统<->服务端)数据收发速率', '50208', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17'), ('203101', '(本地流量管理)(节点<-服务端)输入包速率(packets/s)', '(本地流量管理)(节点<-服务端)输入包速率', '55101', '10000000', '0', '3', '0', '30', '24', '5', '2015-07-28 00:43:17'), ('203102', '(本地流量管理)(节点->服务端)输出包速率(packets/s)', '(本地流量管理)(节点->服务端)输出包速率', '55102', '10000000', '0', '3', '0', '30', '24', '5', '2015-07-28 00:43:17'), ('203103', '(本地流量管理)(节点<-服务端)数据接收速率(bps)', '(本地流量管理)(节点<-服务端)数据接收速率', '55103', '10000000', '0', '3', '0', '220', '24', '5', '2015-07-28 00:43:17'), ('203104', '(本地流量管理)(节点->服务端)数据发送速率(bps)', '(本地流量管理)(节点->服务端)数据发送速率', '55104', '10000000', '0', '3', '0', '220', '24', '5', '2015-07-28 00:43:17'), ('203105', '(本地流量管理)(节点<->服务端)最大连接数', '(本地流量管理)(节点<->服务端)最大连接数', '55105', '10000000', '0', '3', '0', '0', '24', '5', '2015-07-28 00:43:17'), ('203106', '(本地流量管理)(节点<->服务端)所有连接数', '(本地流量管理)(节点<->服务端)所有连接数', '55106', '10000000', '0', '3', '0', '0', '24', '5', '2015-07-28 00:43:17'), ('203107', '(本地流量管理)(节点<->服务端)当前连接数', '(本地流量管理)(节点<->服务端)当前连接数', '55107', '10000000', '0', '3', '0', '0', '24', '5', '2015-07-28 00:43:17'), ('203108', '(本地流量管理)(节点<->服务端)所有请求数', '(本地流量管理)(节点<->服务端)所有请求数', '55108', '10000000', '0', '3', '0', '0', '24', '5', '2015-07-28 00:43:17'), ('203109', '(本地流量管理)(节点<->服务端)数据收发速率(bps)', '(本地流量管理)(节点<->服务端)数据收发速率', '55109', '10000000', '0', '3', '0', '220', '24', '5', '2015-07-28 00:43:17'), ('203110', '(本地流量管理)(节点<->服务端)-节点状态', '(本地流量管理)(节点<->服务端)-节点状态', '55110', '0', '0', '3', '0', '0', '24', '5', '2015-07-28 00:43:17'), ('204101', '(本地流量管理)(节点池&lt;-服务端)输入包速率(packets/s)', '(本地流量管理)(节点池&lt;-服务端)输入包速率', '56101', '10000000', '0', '3', '0', '30', '24', '6', '2015-07-28 00:43:17'), ('204102', '(本地流量管理)(节点池->服务端)输出包速率(packets/s)', '(本地流量管理)(节点池->服务端)输出包速率', '56102', '10000000', '0', '3', '0', '30', '24', '6', '2015-07-28 00:43:17'), ('204103', '(本地流量管理)(节点池&lt;-服务端)数据接收速率(bps)', '(本地流量管理)(节点池&lt;-服务端)数据接收速率', '56103', '10000000', '0', '3', '0', '220', '24', '6', '2015-07-28 00:43:17'), ('204104', '(本地流量管理)(节点池->服务端)数据发送速率(bps)', '(本地流量管理)(节点池->服务端)数据发送速率', '56104', '10000000', '0', '3', '0', '220', '24', '6', '2015-07-28 00:43:17'), ('204105', '(本地流量管理)(节点池&lt;->服务端)最大连接数', '(本地流量管理)(节点池&lt;->服务端)最大连接数', '56105', '10000000', '0', '3', '0', '0', '24', '6', '2015-07-28 00:43:17'), ('204106', '(本地流量管理)(节点池&lt;->服务端)所有连接数', '(本地流量管理)(节点池&lt;->服务端)所有连接数', '56106', '10000000', '0', '3', '0', '0', '24', '6', '2015-07-28 00:43:17'), ('204107', '(本地流量管理)(节点池&lt;->服务端)当前连接数', '(本地流量管理)(节点池&lt;->服务端)当前连接数', '56107', '10000000', '0', '3', '0', '0', '24', '6', '2015-07-28 00:43:17'), ('204108', '(本地流量管理)(节点池&lt;->服务端)数据收发速率(bps)', '(本地流量管理)(节点池&lt;->服务端)数据收发速率', '56108', '10000000', '0', '3', '0', '220', '24', '6', '2015-07-28 00:43:17'), ('204109', '(本地流量管理)(节点池&lt;->服务端)-节点池状态', '(本地流量管理)(节点池&lt;->服务端)-节点池状态', '56109', '0', '0', '3', '0', '0', '24', '6', '2015-07-28 00:43:17'), ('205101', '(本地流量管理)(虚拟服务器&lt;-客户端)输入包速率(packets/s)', '(本地流量管理)(虚拟服务器&lt;-客户端)输入包速率', '54101', '10000000', '0', '3', '0', '30', '24', '2', '2015-07-28 00:43:17'), ('205102', '(本地流量管理)(虚拟服务器->客户端)输出包速率(packets/s)', '(本地流量管理)(虚拟服务器->客户端)输出包速率', '54102', '10000000', '0', '3', '0', '30', '24', '2', '2015-07-28 00:43:17'), ('205103', '(本地流量管理)(虚拟服务器&lt;-客户端)数据接收速率(bps)', '(本地流量管理)(虚拟服务器&lt;-客户端)数据接收速率', '54103', '10000000', '0', '3', '0', '220', '24', '2', '2015-07-28 00:43:17'), ('205104', '(本地流量管理)(虚拟服务器->客户端)数据发送速率(bps)', '(本地流量管理)(虚拟服务器->客户端)数据发送速率', '54104', '10000000', '0', '3', '0', '220', '24', '2', '2015-07-28 00:43:17'), ('205105', '(本地流量管理)(虚拟服务器&lt;->客户端)最大连接数', '(本地流量管理)(虚拟服务器&lt;->客户端)最大连接数', '54105', '10000000', '0', '3', '0', '0', '24', '2', '2015-07-28 00:43:17'), ('205106', '(本地流量管理)(虚拟服务器&lt;->客户端)所有连接数', '(本地流量管理)(虚拟服务器&lt;->客户端)所有连接数', '54106', '10000000', '0', '3', '0', '0', '24', '2', '2015-07-28 00:43:17'), ('205107', '(本地流量管理)(虚拟服务器&lt;->客户端)当前连接数', '(本地流量管理)(虚拟服务器&lt;->客户端)当前连接数', '54107', '10000000', '0', '3', '0', '0', '24', '2', '2015-07-28 00:43:17'), ('205108', '(本地流量管理)(虚拟服务器&lt;->客户端)数据收发速率(bps)', '(本地流量管理)(虚拟服务器&lt;->客户端)数据收发速率', '54108', '10000000', '0', '3', '0', '220', '24', '2', '2015-07-28 00:43:17'), ('205109', '(本地流量管理)(虚拟服务器&lt;->客户端)-虚拟服务器状态', '(本地流量管理)(虚拟服务器&lt;->客户端)-虚拟服务器状态', '54109', '0', '0', '3', '0', '0', '24', '2', '2015-07-28 00:43:17'), ('208101', '负载均衡设备平均CPU利用率(%)', '负载均衡设备平均CPU利用率', '58101', '10000000', '0', '3', '0', '10', '24', '3', '2015-07-28 00:43:17'), ('208102', '负载均衡设备CPU利用率(流量管理模块)(%)', '负载均衡设备CPU利用率(流量管理模块)', '58501', '10000000', '0', '3', '0', '10', '24', '3', '2015-07-28 00:43:17'), ('209101', '负载均衡设备内存利用率(流量管理模块)(%)', '负载均衡设备内存利用率(流量管理模块)', '59101', '10000000', '0', '3', '0', '10', '24', '4', '2015-07-28 00:43:17');
COMMIT;

-- ----------------------------
--  Table structure for `task_group`
-- ----------------------------
DROP TABLE IF EXISTS `task_group`;
CREATE TABLE `task_group` (
  `groupId` int(11) NOT NULL,
  `sumId` int(11) NOT NULL DEFAULT '0',
  `groupName` varchar(255) NOT NULL,
  `interfaceFlag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否接口指标1-true,0-false',
  `summary_id` int(11) NOT NULL DEFAULT '0',
  `perfTask` varchar(255) DEFAULT NULL COMMENT '指标列表',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`groupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `task_summary`
-- ----------------------------
DROP TABLE IF EXISTS `task_summary`;
CREATE TABLE `task_summary` (
  `sumId` int(11) NOT NULL,
  `sumName` varchar(255) NOT NULL,
  `groupList` varchar(255) DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sumId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('1', 'test', '', '', null, '', '10', '0', '0', null, null), ('2', '111', 'xyRTkw563Ql_a8Y0OLjv5G4yyIJgQX2p', '$2y$13$aHzRtU8MOgRAS0c4RBXsw.zy8qqTXwyzqvP6vySAgKgSUwlseckFO', null, '1111@111.111', '10', '2015', '2015', '12121', '111'), ('3', 'test1', 'V_fyl11qCCvBHwdRW9noJVbmbz6jJQp4', '$2y$13$qLDuVOiBVbRJR3bTLOObB.WNfCJS//Yt9PIJ8SAGwLLmGJMyCrb5C', null, '111@111.111', '10', '2015', '2015', 'sdfadsfads', '111'), ('4', 'test2', 'Bs_q8pCeuMHmr_mGV-cIi6Sx1wZgsMR1', '$2y$13$kYwsuc/QMkWd7quG/mJMPeroor9MfABtUikOte8XT7oJ16ZwvJ0mK', null, '11@11.11', '10', '2015', '2015', 'ceshi', '111'), ('5', 'yrsdydsr', 'Qc2DYX7i-5xXJKYQypMHX3WdMrvqJRrT', '$2y$13$V6ulOTQoLWIsXFDLm41wVOKBiWVKhGNS0HxhBkQIJfk9SPPQPwoa.', null, 'ssds@11.11', '10', '2015', '2015', '', null), ('6', '1212', 'LS3G2y7Ec-GqFs1R_ePO5r-nmNsAvcRU', '$2y$13$mQVXQIG04w3zieVT8/WVHevcDQ9OFtJxB7jeYkZJWSOfxRl6rwtZW', null, 'sss@ss.ss', '10', '2015', '2015', '1撒大多数', '111'), ('7', 'dsfdfgfds', 'V6xuy3yt3ugR_r2Dd_iXZSOippvuB1VV', '$2y$13$vpQSmaQyQ4n2.z2TAXcUMO9sqRRQof4E5tgugrSZh1klp3SijBaW6', null, 'fdsfsd@11.11', '10', '2015', '2015', '', null), ('8', 'fdsfdsfsad', 'w6pP0PkLMGd5CbXP8MaJs7dpcIyK_DgC', '$2y$13$sTOE20VU/qz7Z.n7UneM3.tKLTFsFpBCb7JXyZYh7PJdjfOU/oLHW', null, '', '10', '2015', '2015', '', null), ('9', 'dsfdsafadsfs', 'myZ7k_muw5En9F3ttJFhdn3RFOo_QC-X', '$2y$13$kmDTxUJe3zqe9Yug6NjIVuW.v0DkF6nMyyNpJ7jyAlGoDc2fE08eG', null, '', '10', '2015', '2015', '', null), ('10', 'dsdsfsf', 'pZ3CvENXrnXKaSeSBJ2T2ugRKDUpGhNb', '$2y$13$pGb/76fxa8eXF3W1WQAHOuPMBpSHVdLpDmeUzE83zrJk1TLqPzAQa', null, '', '10', '2015', '2015', '', null), ('11', 'fdffdg', 'gyvmM7vt_82TEHlBBdy_EORbpWpZVzNv', '$2y$13$G.BkIwMkA488R9eC1HPpP.mHUfaUEQuvusU.u5vkLbSPe/rM6FsRS', null, '', '10', '2015', '2015', '', null);
COMMIT;

-- ----------------------------
--  Table structure for `view_template`
-- ----------------------------
DROP TABLE IF EXISTS `view_template`;
CREATE TABLE `view_template` (
  `id` int(11) NOT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1 build 2 wlan 3 wifi',
  `device_id` int(11) NOT NULL,
  `attributes` text NOT NULL,
  `links` text,
  `areaId` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `view_template`
-- ----------------------------
BEGIN;
INSERT INTO `view_template` VALUES ('5', '1', '4', '{\"type\":\"switch\",\"title\":\"stack_1.A-F5-S5100-02\",\"cx\":164,\"cy\":272,\"rx\":15,\"ry\":6.5,\"__id__\":\"5\"}', null, null), ('6', '1', '9', '{\"type\":\"switch\",\"title\":\"stack_1.A-F8-S5100-02\",\"cx\":161,\"cy\":231,\"rx\":15,\"ry\":6.5,\"__id__\":\"6\"}', null, null), ('7', '1', '6', '{\"type\":\"switch\",\"title\":\"stack_0.A-F7-S5100-01\",\"cx\":172,\"cy\":311,\"rx\":15,\"ry\":6.5,\"__id__\":\"7\"}', null, null), ('8', '1', '3', '{\"type\":\"switch\",\"title\":\"stack_0.A-F2-S5100-01\",\"cx\":179,\"cy\":354,\"rx\":15,\"ry\":6.5,\"__id__\":\"8\"}', null, null), ('9', '1', '8', '{\"type\":\"switch\",\"title\":\"stack_0.A-F3-S5100-01\",\"cx\":289,\"cy\":377,\"rx\":15,\"ry\":6.5,\"__id__\":\"9\"}', null, null), ('10', '1', '10', '{\"type\":\"switch\",\"title\":\"stack_1.A-F9-S5100-02\",\"cx\":184,\"cy\":441,\"rx\":15,\"ry\":6.5,\"__id__\":\"10\"}', null, null), ('11', '1', '17', '{\"type\":\"switch\",\"title\":\"stack_0.B-F8-S5100-01\",\"cx\":179,\"cy\":396,\"rx\":15,\"ry\":6.5,\"__id__\":\"11\"}', null, null), ('12', '1', '2', '{\"type\":\"switch\",\"title\":\"stack_0.A-F4-S5100-01\",\"cx\":293,\"cy\":428,\"rx\":15,\"ry\":6.5,\"__id__\":\"12\"}', null, null), ('13', '1', '16', '{\"type\":\"switch\",\"title\":\"stack_0.A-F8-S5100-01\",\"cx\":283,\"cy\":321,\"rx\":15,\"ry\":6.5,\"__id__\":\"13\"}', null, null), ('14', '1', '13', '{\"type\":\"switch\",\"title\":\"stack_0.A-F7-S5100-02\",\"cx\":277,\"cy\":268,\"rx\":15,\"ry\":6.5,\"__id__\":\"14\"}', null, null), ('15', '1', '19', '{\"type\":\"switch\",\"title\":\"stack_0.B-F8-S5100-01\",\"cx\":270,\"cy\":218,\"rx\":15,\"ry\":6.5,\"__id__\":\"15\"}', null, null), ('16', '1', '12', '{\"type\":\"switch\",\"title\":\"stack_0.A-F10-S5100-01\",\"cx\":346,\"cy\":135,\"rx\":15,\"ry\":6.5,\"__id__\":\"16\"}', null, null), ('17', '1', '20', '{\"type\":\"switch\",\"title\":\"stack_0.C-F8-S5100-01\",\"cx\":354,\"cy\":179,\"rx\":15,\"ry\":6.5,\"__id__\":\"17\"}', null, null), ('18', '1', '22', '{\"type\":\"switch\",\"title\":\"stack_0.B-F6-S5100-01\",\"cx\":357,\"cy\":233,\"rx\":15,\"ry\":6.5,\"__id__\":\"18\"}', null, null), ('19', '1', '21', '{\"type\":\"switch\",\"title\":\"stack_0.D-F8-S5100-01\",\"cx\":362,\"cy\":271,\"rx\":15,\"ry\":6.5,\"__id__\":\"19\"}', null, null), ('20', '1', '23', '{\"type\":\"switch\",\"title\":\"stack_0.D-F2-S5100-01\",\"cx\":363,\"cy\":312,\"rx\":15,\"ry\":6.5,\"__id__\":\"20\"}', null, null), ('21', '1', '26', '{\"type\":\"switch\",\"title\":\"stack_0.B-F5-S5100-01\",\"cx\":367,\"cy\":357,\"rx\":15,\"ry\":6.5,\"__id__\":\"21\"}', null, null), ('22', '1', '25', '{\"type\":\"switch\",\"title\":\"stack_0.D-F4-S5100-01\",\"cx\":370,\"cy\":407,\"rx\":15,\"ry\":6.5,\"__id__\":\"22\"}', null, null), ('23', '1', '27', '{\"type\":\"switch\",\"title\":\"stack_0.C-F2-S5100-01\",\"cx\":476,\"cy\":163,\"rx\":15,\"ry\":6.5,\"__id__\":\"23\"}', null, null), ('24', '1', '24', '{\"type\":\"switch\",\"title\":\"stack_0.B-F3-S5100-01\",\"cx\":476,\"cy\":210,\"rx\":15,\"ry\":6.5,\"__id__\":\"24\"}', null, null), ('25', '1', '28', '{\"type\":\"switch\",\"title\":\"stack_0.C-F3-S5100-01\",\"cx\":482,\"cy\":256,\"rx\":15,\"ry\":6.5,\"__id__\":\"25\"}', null, null), ('26', '1', '29', '{\"type\":\"switch\",\"title\":\"stack_0.C-F4-S5100-01\",\"cx\":485,\"cy\":302,\"rx\":15,\"ry\":6.5,\"__id__\":\"26\"}', null, null), ('27', '1', '30', '{\"type\":\"switch\",\"title\":\"stack_0.C-F5-S5100-01\",\"cx\":486,\"cy\":350,\"rx\":15,\"ry\":6.5,\"__id__\":\"27\"}', null, null), ('28', '1', '32', '{\"type\":\"switch\",\"title\":\"stack_0.C-F3-S5100-01\",\"cx\":492,\"cy\":390,\"rx\":15,\"ry\":6.5,\"__id__\":\"28\"}', null, null), ('29', '1', '31', '{\"type\":\"switch\",\"title\":\"stack_0.C-F2-S5100-01\",\"cx\":635,\"cy\":129,\"rx\":15,\"ry\":6.5,\"__id__\":\"29\"}', null, null), ('30', '1', '33', '{\"type\":\"switch\",\"title\":\"stack_0.C-F4-S5100-01\",\"cx\":639,\"cy\":168,\"rx\":15,\"ry\":6.5,\"__id__\":\"30\"}', null, null), ('31', '1', '34', '{\"type\":\"switch\",\"title\":\"stack_0.C-F5-S5100-01\",\"cx\":641,\"cy\":212,\"rx\":15,\"ry\":6.5,\"__id__\":\"31\"}', null, null), ('32', '1', '35', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":565,\"cy\":319,\"rx\":15,\"ry\":6.5,\"__id__\":\"32\"}', null, null), ('33', '1', '36', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":642,\"cy\":256,\"rx\":15,\"ry\":6.5,\"__id__\":\"33\"}', null, null), ('34', '1', '37', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":642,\"cy\":299,\"rx\":15,\"ry\":6.5,\"__id__\":\"34\"}', null, null), ('35', '1', '38', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":645,\"cy\":342,\"rx\":15,\"ry\":6.5,\"__id__\":\"35\"}', null, null), ('36', '1', '39', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":802,\"cy\":87,\"rx\":15,\"ry\":6.5,\"__id__\":\"36\"}', null, null), ('37', '1', '40', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":801,\"cy\":130,\"rx\":15,\"ry\":6.5,\"__id__\":\"37\"}', null, null), ('38', '1', '41', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":802,\"cy\":176,\"rx\":15,\"ry\":6.5,\"__id__\":\"38\"}', null, null), ('39', '1', '42', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":801,\"cy\":223,\"rx\":15,\"ry\":6.5,\"__id__\":\"39\"}', null, null), ('40', '1', '43', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":800,\"cy\":272,\"rx\":15,\"ry\":6.5,\"__id__\":\"40\"}', null, null), ('41', '1', '44', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":891,\"cy\":66,\"rx\":15,\"ry\":6.5,\"__id__\":\"41\"}', null, null), ('42', '1', '45', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":893,\"cy\":114,\"rx\":15,\"ry\":6.5,\"__id__\":\"42\"}', null, null), ('43', '1', '46', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":886,\"cy\":164,\"rx\":15,\"ry\":6.5,\"__id__\":\"43\"}', null, null), ('44', '1', '47', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":557,\"cy\":153,\"rx\":15,\"ry\":6.5,\"__id__\":\"44\"}', null, null), ('45', '1', '48', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":561,\"cy\":193,\"rx\":15,\"ry\":6.5,\"__id__\":\"45\"}', null, null), ('46', '1', '49', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":562,\"cy\":267,\"rx\":15,\"ry\":6.5,\"__id__\":\"46\"}', null, null), ('47', '1', '50', '{\"type\":\"switch\",\"title\":\"stack_0.C-F1-S5100-01\",\"cx\":887,\"cy\":217,\"rx\":15,\"ry\":6.5,\"__id__\":\"47\"}', null, null), ('9', '2', '2', '{\"type\":\"switch\",\"title\":\"stack_0.A-F4-S5100-01\",\"cx\":314,\"cy\":181,\"rx\":42.5,\"ry\":32.5,\"__id__\":\"9\"}', null, '1'), ('10', '2', '4', '{\"type\":\"switch\",\"title\":\"stack_1.A-F5-S5100-02\",\"cx\":373,\"cy\":218,\"rx\":42.5,\"ry\":32.5,\"__id__\":\"10\"}', null, '1'), ('11', '2', '8', '{\"type\":\"switch\",\"title\":\"stack_0.A-F3-S5100-01\",\"cx\":431,\"cy\":253,\"rx\":42.5,\"ry\":32.5,\"__id__\":\"11\"}', null, '1'), ('12', '2', '10', '{\"type\":\"switch\",\"title\":\"stack_1.A-F9-S5100-02\",\"cx\":489,\"cy\":294,\"rx\":42.5,\"ry\":32.5,\"__id__\":\"12\"}', null, '1'), ('13', '2', '3', '{\"type\":\"switch\",\"title\":\"stack_0.A-F2-S5100-01\",\"cx\":298,\"cy\":295,\"rx\":42.5,\"ry\":32.5,\"__id__\":\"13\"}', null, '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
