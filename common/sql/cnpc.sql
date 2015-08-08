/*
MySQL Data Transfer
Source Host: localhost
Source Database: cnpc
Target Host: localhost
Target Database: cnpc
Date: 2015/7/30 1:05:19
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for alarm_category
-- ----------------------------
CREATE TABLE `alarm_category` (
  `id` int(11) NOT NULL,
  `baseClass` int(11) NOT NULL COMMENT '主分类id',
  `baseDesc` varchar(255) DEFAULT NULL COMMENT '主分类描述',
  `subClass` int(11) NOT NULL COMMENT '子分类id',
  `subDesc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for alarm_level
-- ----------------------------
CREATE TABLE `alarm_level` (
  `id` int(11) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for alarm_original_type
-- ----------------------------
CREATE TABLE `alarm_original_type` (
  `id` int(11) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for alarm_time_range
-- ----------------------------
CREATE TABLE `alarm_time_range` (
  `id` int(11) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Table structure for device_alarm
-- ----------------------------
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for device_category
-- ----------------------------
CREATE TABLE `device_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `preDefined` tinyint(1) DEFAULT '1' COMMENT '是否系统定义0-否，1-是',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for device_info
-- ----------------------------
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for device_interface
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for device_interface_task
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for device_link
-- ----------------------------
CREATE TABLE `device_link` (
  `id` int(11) NOT NULL,
  `type` int(2) NOT NULL DEFAULT '0',
  `leftSymbolId` int(11) NOT NULL DEFAULT '0',
  `leftIfDesc` varchar(255) DEFAULT NULL,
  `rightSymbolId` int(11) NOT NULL DEFAULT '0',
  `rightIfDesc` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0：UNKNOWN，1：NORMAL，2：DOWN，3：URGENT，4：IMPORTENT，5：MINOR，6：WARN，7：EVENT，8：VIRTUAL1。',
  `bandWidth` varchar(255) DEFAULT NULL,
  `leftDevice` varchar(255) DEFAULT NULL,
  `rightDevice` varchar(255) DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for device_model
-- ----------------------------
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for device_series
-- ----------------------------
CREATE TABLE `device_series` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `preDefined` tinyint(1) DEFAULT '1' COMMENT '是否系统定义0-否1-是',
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for device_task
-- ----------------------------
CREATE TABLE `device_task` (
  `instId` int(11) DEFAULT NULL COMMENT '实例，唯一ID主键',
  `insDesc` varchar(255) DEFAULT NULL,
  `devId` int(11) DEFAULT NULL COMMENT '设备',
  `devDesc` varchar(255) DEFAULT NULL,
  `taskId` int(11) NOT NULL COMMENT '指标',
  `taskDesc` varchar(255) DEFAULT NULL,
  `dataVal` double(11,2) DEFAULT '0.00',
  `dataTime` datetime DEFAULT NULL COMMENT '数据时间',
  `dataTimeStr` datetime DEFAULT NULL COMMENT '显示时间',
  `dataType` int(11) DEFAULT '0',
  `minVal` double(11,0) DEFAULT '0' COMMENT '最小值',
  `maxVal` double(11,0) DEFAULT '0',
  `sumVal` double(11,0) DEFAULT '0' COMMENT '汇总值',
  `sumCount` int(11) DEFAULT '0' COMMENT '汇总计数',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for device_vendor
-- ----------------------------
CREATE TABLE `device_vendor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `preDefined` tinyint(1) DEFAULT '1' COMMENT '是否系统自定义0-否1-是',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Table structure for task
-- ----------------------------
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for task_group
-- ----------------------------
CREATE TABLE `task_group` (
  `groupId` int(11) NOT NULL,
  `sumId` int(11) NOT NULL DEFAULT '0',
  `groupName` varchar(255) NOT NULL,
  `interfaceFlag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否接口指标1-true,0-false',
  `summary_id` int(11) NOT NULL DEFAULT '0',
  `perfTask` varchar(255) DEFAULT NULL COMMENT '指标列表',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`groupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for task_summary
-- ----------------------------
CREATE TABLE `task_summary` (
  `sumId` int(11) NOT NULL,
  `sumName` varchar(255) NOT NULL,
  `groupList` varchar(255) DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sumId`)
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for view_template
-- ----------------------------
CREATE TABLE `view_template` (
  `id` int(11) NOT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1 build 2 wlan 3 wifi',
  `device_id` int(11) NOT NULL,
  `attributes` text NOT NULL,
  `links` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `device_category` VALUES ('0', '路由器', '1', '2015-07-28 00:09:17');
INSERT INTO `device_category` VALUES ('1', '交换机', '1', '2015-07-28 00:09:17');
INSERT INTO `device_category` VALUES ('2', '服务器', '1', '2015-07-28 00:09:17');
INSERT INTO `device_category` VALUES ('3', '安全设备', '1', '2015-07-28 00:09:17');
INSERT INTO `device_category` VALUES ('4', '存储设备', '1', '2015-07-28 00:09:17');
INSERT INTO `device_category` VALUES ('5', '无线设备', '1', '2015-07-28 00:09:17');
INSERT INTO `device_category` VALUES ('6', '语音设备', '1', '2015-07-28 00:09:17');
INSERT INTO `device_category` VALUES ('7', '打印机', '1', '2015-07-28 00:09:17');
INSERT INTO `device_category` VALUES ('8', 'UPS', '1', '2015-07-28 00:09:17');
INSERT INTO `device_category` VALUES ('9', 'PC', '1', '2015-07-28 00:09:17');
INSERT INTO `device_info` VALUES ('2', 'stack_0.A-F4-S5100-01', '10.6.251.41', '255.255.255.0', '1', 'stack_0.A-F4-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:31', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null);
INSERT INTO `device_info` VALUES ('3', 'stack_0.A-F2-S5100-01', '10.6.251.21', '255.255.255.0', '2', 'stack_0.A-F2-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:66:db:2d', null, null, '0', null, null, null, '2015-07-30 01:02:05', null, null);
INSERT INTO `device_info` VALUES ('4', 'stack_1.A-F5-S5100-02', '10.6.251.52', '255.255.255.0', '3', 'stack_1.A-F5-S5100-02', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:62:cb:4d', null, null, '0', null, null, null, '2015-07-30 01:02:01', null, null);
INSERT INTO `device_info` VALUES ('6', 'stack_0.A-F7-S5100-01', '10.6.251.71', '255.255.255.0', '4', 'stack_0.A-F7-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:03', null, null, '0', null, null, null, '2015-07-30 01:01:58', null, null);
INSERT INTO `device_info` VALUES ('8', 'stack_0.A-F3-S5100-01', '10.6.251.31', '255.255.255.0', '3', 'stack_0.A-F3-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.30', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-EI', '0', null, '3', '', '00:0f:e2:b1:26:34', null, null, '0', null, null, null, '2015-07-30 01:01:59', null, null);
INSERT INTO `device_info` VALUES ('9', 'stack_1.A-F8-S5100-02', '10.6.251.82', '255.255.255.0', '5', 'stack_1.A-F8-S5100-02', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:66:da:c3', null, null, '0', null, null, null, '2015-07-30 01:01:15', null, null);
INSERT INTO `device_info` VALUES ('10', 'stack_1.A-F9-S5100-02', '10.6.251.92', '255.255.255.0', '1', 'stack_1.A-F9-S5100-02', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:62:cb:4f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null);
INSERT INTO `device_info` VALUES ('12', 'stack_0.A-F10-S5100-01', '10.6.251.101', '255.255.255.0', '1', 'stack_0.A-F10-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.30', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-EI', '0', null, '3', '', '00:0f:e2:84:f9:01', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null);
INSERT INTO `device_info` VALUES ('13', 'stack_0.A-F7-S5100-02', '10.6.251.72', '255.255.255.0', '1', 'stack_0.A-F7-S5100-02', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:84:cd:46', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null);
INSERT INTO `device_info` VALUES ('16', 'stack_0.A-F8-S5100-01', '10.6.251.81', '255.255.255.0', '1', 'stack_0.A-F8-S5100-01', 'Hangzhou China', '1.3.6.1.4.1.25506.1.169', null, null, '1', '0', '0', '0', '0', 'H3C S5100-50C-PWR-EI', '0', null, '3', '', '00:0f:e2:64:1c:3f', null, null, '0', null, null, null, '2015-07-28 00:18:38', null, null);
INSERT INTO `device_interface` VALUES ('10', '6', '10', '136', 'L3IPVLAN', 'Vlan-interface10', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface10 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.10', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('11', '6', '11', '136', 'L3IPVLAN', 'Vlan-interface11', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface11 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.11', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('12', '6', '12', '136', 'L3IPVLAN', 'Vlan-interface12', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface12 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.12', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('13', '6', '13', '136', 'L3IPVLAN', 'Vlan-interface13', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface13 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.13', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('14', '6', '14', '136', 'L3IPVLAN', 'Vlan-interface14', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface14 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.14', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('15', '6', '15', '136', 'L3IPVLAN', 'Vlan-interface15', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface15 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.15', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('16', '6', '16', '136', 'L3IPVLAN', 'Vlan-interface16', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface16 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.16', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('17', '6', '17', '136', 'L3IPVLAN', 'Vlan-interface17', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface17 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.17', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('18', '6', '18', '136', 'L3IPVLAN', 'Vlan-interface18', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface18 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.18', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('19', '6', '19', '136', 'L3IPVLAN', 'Vlan-interface19', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface19 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.19', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('20', '4', '20', '136', 'L3IPVLAN', 'Vlan-interface20', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface20 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.20', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('21', '4', '21', '136', 'L3IPVLAN', 'Vlan-interface21', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface21 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.21', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('22', '4', '22', '136', 'L3IPVLAN', 'Vlan-interface22', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface22 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.22', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('23', '4', '23', '136', 'L3IPVLAN', 'Vlan-interface23', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface23 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.23', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('24', '4', '24', '136', 'L3IPVLAN', 'Vlan-interface24', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface24 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.24', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('25', '4', '25', '136', 'L3IPVLAN', 'Vlan-interface25', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface25 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.25', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('26', '4', '26', '136', 'L3IPVLAN', 'Vlan-interface26', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface26 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.26', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('27', '4', '27', '136', 'L3IPVLAN', 'Vlan-interface27', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface27 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.27', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('28', '4', '28', '136', 'L3IPVLAN', 'Vlan-interface28', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface28 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.28', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('29', '4', '29', '136', 'L3IPVLAN', 'Vlan-interface29', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface29 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.29', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('30', '9', '30', '136', 'L3IPVLAN', 'Vlan-interface30', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface30 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.30', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('31', '9', '31', '136', 'L3IPVLAN', 'Vlan-interface31', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface31 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.31', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('32', '9', '32', '136', 'L3IPVLAN', 'Vlan-interface32', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface32 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.32', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('33', '9', '33', '136', 'L3IPVLAN', 'Vlan-interface33', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface33 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.33', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('34', '9', '34', '136', 'L3IPVLAN', 'Vlan-interface34', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface34 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.34', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('35', '9', '35', '136', 'L3IPVLAN', 'Vlan-interface35', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface35 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.35', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('36', '9', '36', '136', 'L3IPVLAN', 'Vlan-interface36', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface36 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.36', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('37', '9', '37', '136', 'L3IPVLAN', 'Vlan-interface37', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface37 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.37', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('38', '9', '38', '136', 'L3IPVLAN', 'Vlan-interface38', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface38 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.38', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface` VALUES ('39', '9', '39', '136', 'L3IPVLAN', 'Vlan-interface39', '1', 'Up', '1', 'Up', '-2', null, '0', '0', 'Vlan-interface39 Interface', '00:0f:e2:e1:ca:be', '1500', '51天11小时23分钟53秒860毫秒', '10.153.146.39', '255.255.255.0', null, '2015-07-22 17:52:29');
INSERT INTO `device_interface_task` VALUES ('1', '1', '111', '2', 'H3C', 'DSDS', '127.0.0.1', '1', null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0');
INSERT INTO `device_model` VALUES ('10178', '3Com OSR3720', null, '1.3.6.1.4.1.43.1.16.4.2.34', '3', '20', '0', '2015-07-22 17:48:05');
INSERT INTO `device_series` VALUES ('163', 'H3C AR18-2x', null, '1', '2', '2015-07-22 17:46:51');
INSERT INTO `migration` VALUES ('m000000_000000_base', '1436856356');
INSERT INTO `migration` VALUES ('m130524_201442_init', '1436856359');
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', '1436856663');
INSERT INTO `session` VALUES ('15id295f6n7c8rqkhpiesl2ib2', '1438189777', 0x5F5F666C6173687C613A303A7B7D5F5F69647C693A343B);
INSERT INTO `session` VALUES ('5an943sgn3nt9t4fld4inpheb4', '1437560245', 0x5F5F666C6173687C613A303A7B7D5F5F69647C693A343B);
INSERT INTO `session` VALUES ('l3l2tvbgakrpl956heinec16j4', '1437573913', 0x5F5F666C6173687C613A303A7B7D5F5F69647C693A343B);
INSERT INTO `session` VALUES ('qo59smoj973jqr1dabfng94h63', '1437583344', 0x5F5F666C6173687C613A303A7B7D5F5F69647C693A343B);
INSERT INTO `task` VALUES ('1', '接口接收速率(bps)', '接口接收速率', '2048', '300000000', '0', '3', '0', '220', '1', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('2', 'CPU利用率(%)', 'CPU利用率', '1', '70', '0', '3', '0', '10', '1', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('4', '内存利用率(%)', '内存利用率', '2', '80', '0', '3', '0', '10', '1', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('5', '接口发送速率(bps)', '接口发送速率', '2049', '300000000', '0', '3', '0', '220', '1', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('6', '设备响应时间(ms)', '设备响应时间', '512', '50', '0', '3', '0', '100', '1', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('8', '设备不可达性比例(%)', '设备不可达性比例', '513', '10', '0', '3', '0', '10', '1', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('9', '接口输入带宽利用率(%)', '接口输入带宽利用率', '2052', '60', '0', '3', '0', '10', '1', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('13', '接口输出带宽利用率(%)', '接口输出带宽利用率', '2053', '60', '0', '3', '0', '10', '1', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('14', '接收IP报文速率(datagrams/s)', '接收IP报文速率', '3072', '100000', '0', '3', '0', '40', '1', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('16', '转发IP报文速率(datagrams/s)', '转发IP报文速率', '3073', '100000', '0', '3', '0', '40', '1', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('17', '接口接收广播包速率(packets/s)', '接口接收广播包速率', '2064', '100000', '0', '3', '0', '30', '1', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('18', '输入IP报文丢弃率(%)', '输入IP报文丢弃率', '3074', '0', '0', '3', '0', '10', '1', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('20', '输出IP报文丢弃率(%)', '输出IP报文丢弃率', '3075', '0', '0', '3', '0', '10', '1', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('25', '接口发送广播包速率(packets/s)', '接口发送广播包速率', '2065', '100000', '0', '3', '0', '30', '1', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('33', '接口输入包丢弃率(%)', '接口输入包丢弃率', '2067', '0', '0', '3', '0', '10', '1', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('41', '接口输出包丢弃率(%)', '接口输出包丢弃率', '2068', '0', '0', '3', '0', '10', '1', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('49', '实体温度(Celsius)', '实体温度', '521', '60', '0', '3', '0', '400', '1', '11', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('50', '客户端视频连接建立请求次数', '客户端视频连接建立请求次数', '12001', '40', '0', '3', '0', '0', '4', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('52', '分发服务器转发的最大并发连接数', '分发服务器转发的最大并发连接数', '12101', '200', '0', '3', '0', '0', '4', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('54', '客户端视频连接建立请求成功比例(%)', '客户端视频连接建立请求成功比例', '12002', '80', '0', '3', '0', '10', '4', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('56', '分发服务器转发的总时长', '分发服务器转发的总时长', '12102', '60000', '0', '3', '0', '0', '4', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('58', '客户端视频连接建立请求失败次数', '客户端视频连接建立请求失败次数', '12003', '10', '0', '3', '0', '0', '4', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('60', '分发服务器转发的总连接数', '分发服务器转发的总连接数', '12103', '200', '0', '3', '0', '0', '4', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('62', '客户端视频连接释放请求次数', '客户端视频连接释放请求次数', '12004', '40', '0', '3', '0', '0', '4', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('64', '分发服务器转发的平均连接数', '分发服务器转发的平均连接数', '12104', '200', '0', '3', '0', '0', '4', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('66', '客户端视频连接释放请求成功比例(%)', '客户端视频连接释放请求成功比例', '12005', '80', '0', '3', '0', '10', '4', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('68', '分发服务器点播的最大并发连接数', '分发服务器点播的最大并发连接数', '12105', '100', '0', '3', '0', '0', '4', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('70', '客户端视频连接释放请求失败次数', '客户端视频连接释放请求失败次数', '12006', '10', '0', '3', '0', '0', '4', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('72', '分发服务器点播的总时长', '分发服务器点播的总时长', '12106', '30000', '0', '3', '0', '0', '4', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('74', '客户端视频连接异常终止次数', '客户端视频连接异常终止次数', '12007', '5', '0', '3', '0', '0', '4', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('76', '分发服务器点播的总连接数', '分发服务器点播的总连接数', '12107', '100', '0', '3', '0', '0', '4', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('78', 'IVS设备硬盘占用率(%)', 'IVS设备硬盘占用率', '12008', '80', '0', '3', '0', '10', '4', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('80', '分发服务器点播的平均连接数', '分发服务器点播的平均连接数', '12108', '100', '0', '3', '0', '0', '4', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('82', '前端设备在线情况', '前端设备在线情况', '12201', '0', '0', '3', '0', '0', '4', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('84', '分发服务器录像的最大并发连接数', '分发服务器录像的最大并发连接数', '12109', '100', '0', '3', '0', '0', '4', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('86', '监控点在线情况', '监控点在线情况', '12202', '0', '0', '3', '0', '0', '4', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('88', '分发服务器录像的总时长', '分发服务器录像的总时长', '12110', '30000', '0', '3', '0', '0', '4', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('90', '监控点视频错误率(%)', '监控点视频错误率', '12203', '50', '0', '3', '0', '10', '4', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('92', '分发服务器录像的总连接数', '分发服务器录像的总连接数', '12111', '100', '0', '3', '0', '0', '4', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('94', '输入的视频信号报文数', '输入的视频信号报文数', '12204', '100', '0', '3', '0', '0', '4', '8', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('96', '分发服务器录像的平均连接数', '分发服务器录像的平均连接数', '12112', '100', '0', '3', '0', '0', '4', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('98', '输入的视频信号关键帧数', '输入的视频信号关键帧数', '12205', '25', '0', '3', '0', '0', '4', '8', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('100', '视频信号报文丢失率(%)', '视频信号报文丢失率', '12206', '20', '0', '3', '0', '10', '4', '8', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('102', '视频信号关键帧丢失率(%)', '视频信号关键帧丢失率', '12207', '20', '0', '3', '0', '10', '4', '8', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('600', '输入IP报文丢弃数(datagrams)', '输入IP报文丢弃数', '3076', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('601', '输出IP报文丢弃数(datagrams)', '输出IP报文丢弃数', '3077', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('602', '路由失败的IP报文数(datagrams)', '路由失败的IP报文数', '3078', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('603', '分片失败的IP报文数(datagrams)', '分片失败的IP报文数', '3079', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('604', '接收报文头错误的IP报文数(datagrams)', '接收报文头错误的IP报文数', '3080', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('605', '地址错误的IP报文数(datagrams)', '地址错误的IP报文数', '3081', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('606', '接收的未知协议报文数(datagrams)', '接收的未知协议报文数', '3082', '100000', '0', '3', '0', '80', '1', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('607', 'IP报文重组失败次数', 'IP报文重组失败次数', '3083', '100000', '0', '3', '0', '0', '1', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('630', '接收TCP段速率(segments/s)', '接收TCP段速率(segments/s)', '4096', '100000', '0', '3', '0', '50', '1', '8', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('631', '发送TCP段速率(segments/s)', '发送TCP段速率(segments/s)', '4097', '100000', '0', '3', '0', '50', '1', '8', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('632', '接收的错误TCP段数(segments)', '接收的错误TCP段数', '4098', '100000', '0', '3', '0', '90', '1', '8', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('633', '发送带RST标志的TCP段数(segments)', '发送带RST标志的TCP段数', '4099', '100000', '0', '3', '0', '90', '1', '8', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('650', '接收UDP报文速率(datagrams/s)', '接收UDP报文速率(datagrams/s)', '5120', '100000', '0', '3', '0', '40', '1', '9', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('651', '发送UDP报文速率(datagrams/s)', '发送UDP报文速率(datagrams/s)', '5121', '100000', '0', '3', '0', '40', '1', '9', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('652', '目的端口错误的UDP报文数(datagrams)', '目的端口错误的UDP报文数', '5123', '100000', '0', '3', '0', '80', '1', '9', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('653', '接收的错误UDP报文数(datagrams)', '接收的错误UDP报文数', '5124', '100000', '0', '3', '0', '80', '1', '9', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('670', '验证名错误的SNMP报文数(datagrams)', '验证名错误的SNMP报文数', '6144', '100000', '0', '3', '0', '80', '1', '10', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('671', '非法操作的SNMP报文数(datagrams)', '非法操作的SNMP报文数', '6145', '100000', '0', '3', '0', '80', '1', '10', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('672', '接收的错误SNMP报文数(datagrams)', '接收的错误SNMP报文数', '6146', '100000', '0', '3', '0', '80', '1', '10', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('700', 'IKE通道接收速率(Bps)', 'IKE通道接收速率(bytes/s)', '8192', '100000', '0', '3', '0', '20', '2', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('701', 'IKE通道接收速率(packets/s)', 'IKE通道接收速率(packets/s)', '8193', '100000', '0', '3', '0', '30', '2', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('702', 'IKE通道丢弃输入报文包数(packets)', 'IKE通道丢弃输入报文包数', '8194', '100000', '0', '3', '0', '70', '2', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('703', 'IKE通道发送速率(Bps)', 'IKE通道发送速率(bytes/s)', '8195', '100000', '0', '3', '0', '20', '2', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('704', 'IKE通道发送速率(packets/s)', 'IKE通道发送速率(packets/s)', '8196', '100000', '0', '3', '0', '30', '2', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('705', 'IKE通道丢弃输出报文包数(packets)', 'IKE通道丢弃输出报文包数', '8197', '100000', '0', '3', '0', '70', '2', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('720', '活跃的IKE通道数', '活跃的IKE通道数', '9216', '10', '0', '3', '0', '0', '2', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('721', '所有IKE通道接收速率(Bps)', '所有IKE通道接收速率(bytes/s)', '9217', '100000', '0', '3', '0', '20', '2', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('722', '所有IKE通道接收速率(packets/s)', '所有IKE通道接收速率(packets/s)', '9218', '100000', '0', '3', '0', '30', '2', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('723', '所有IKE通道丢弃输入报文包数(packets)', '所有IKE通道丢弃输入报文包数', '9219', '100000', '0', '3', '0', '70', '2', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('724', '所有IKE通道发送速率(Bps)', '所有IKE通道发送速率(bytes/s)', '9220', '100000', '0', '3', '0', '20', '2', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('725', '所有IKE通道发送速率(packets/s)', '所有IKE通道发送速率(packets/s)', '9221', '100000', '0', '3', '0', '30', '2', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('726', '所有IKE通道丢弃输出报文包数(packets)', '所有IKE通道丢弃输出报文包数', '9222', '100000', '0', '3', '0', '70', '2', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('727', '本地初始化的IKE通道数增长量', '本地初始化的IKE通道数增长量', '9223', '10', '0', '3', '0', '0', '2', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('728', '本地初始化失败的IKE通道数', '本地初始化失败的IKE通道数', '9224', '10', '0', '3', '0', '0', '2', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('729', '远端初始化的IKE通道数增长量', '远端初始化的IKE通道数增长量', '9225', '10', '0', '3', '0', '0', '2', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('730', '远端初始化失败的IKE通道数', '远端初始化失败的IKE通道数', '9226', '10', '0', '3', '0', '0', '2', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('750', 'IPSec通道接收速率(Bps)', 'IPSec通道接收速率(bytes/s)', '10240', '100000', '0', '3', '0', '20', '2', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('751', 'IPSec通道接收速率(packets/s)', 'IPSec通道接收速率(packets/s)', '10241', '100000', '0', '3', '0', '30', '2', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('752', 'IPSec通道丢弃输入报文包数(packets)', 'IPSec通道丢弃输入报文包数', '10242', '100000', '0', '3', '0', '70', '2', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('753', 'IPSec通道发送速率(Bps)', 'IPSec通道发送速率(bytes/s)', '10243', '100000', '0', '3', '0', '20', '2', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('754', 'IPSec通道发送速率(packets/s)', 'IPSec通道发送速率(packets/s)', '10244', '100000', '0', '3', '0', '30', '2', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('755', 'IPSec通道丢弃输出报文包数(packets)', 'IPSec通道丢弃输出报文包数', '10245', '100000', '0', '3', '0', '70', '2', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('756', 'IPSec通道入方向报文丢弃率(%)', 'IPSec通道入方向报文丢弃率(%)', '10246', '0', '0', '3', '0', '10', '2', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('757', 'IPSec通道出方向报文丢弃率(%)', 'IPSec通道出方向报文丢弃率(%)', '10247', '0', '0', '3', '0', '10', '2', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('770', '活跃的IPSec通道数', '活跃的IPSec通道数', '11264', '10', '0', '3', '0', '0', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('771', '活跃的IPSec SA数', '活跃的IPSec SA数', '11265', '10', '0', '3', '0', '0', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('772', '所有IPSec通道接收速率(Bps)', '所有IPSec通道接收速率(bytes/s)', '11266', '100000', '0', '3', '0', '20', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('773', '所有IPSec通道接收速率(packets/s)', '所有IPSec通道接收速率(packets/s)', '11267', '100000', '0', '3', '0', '30', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('774', '所有IPSec通道丢弃输入报文包数(packets)', '所有IPSec通道丢弃输入报文包数', '11268', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('775', '所有IPSec通道丢弃重复输入报文包数(packets)', '所有IPSec通道丢弃重复输入报文包数', '11269', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('776', '所有IPSec通道输入过程认证失败次数', '所有IPSec通道输入过程认证失败次数', '11270', '10', '0', '3', '0', '0', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('777', '所有IPSec通道输入过程解密失败次数', '所有IPSec通道输入过程解密失败次数', '11271', '10', '0', '3', '0', '0', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('778', '所有IPSec通道发送速率(Bps)', '所有IPSec通道发送速率(bytes/s)', '11272', '100000', '0', '3', '0', '20', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('779', '所有IPSec通道发送速率(packets/s)', '所有IPSec通道发送速率(packets/s)', '11273', '100000', '0', '3', '0', '30', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('780', '所有IPSec通道丢弃输出报文包数(packets)', '所有IPSec通道丢弃输出报文包数', '11274', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('781', '所有IPSec通道因内存不足丢弃报文包数(packets)', '所有IPSec通道因内存不足丢弃报文包数', '11275', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('782', '所有IPSec通道因未发现SA丢弃报文包数(packets)', '所有IPSec通道因未发现SA丢弃报文包数', '11276', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('783', '所有IPSec通道因队列已满丢弃报文包数(packets)', '所有IPSec通道因队列已满丢弃报文包数', '11277', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('784', '所有IPSec通道因长度无效丢弃报文包数(packets)', '所有IPSec通道因长度无效丢弃报文包数', '11278', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('785', '所有IPSec通道因报文太长丢弃报文包数(packets)', '所有IPSec通道因报文太长丢弃报文包数', '11279', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('786', '所有IPSec通道因SA无效丢弃报文包数(packets)', '所有IPSec通道因SA无效丢弃报文包数', '11280', '100000', '0', '3', '0', '70', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('787', '所有IPSec通道入方向报文丢弃率(%)', '所有IPSec通道入方向报文丢弃率(%)', '11282', '0', '0', '3', '0', '10', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('788', '所有IPSec通道出方向报文丢弃率(%)', '所有IPSec通道出方向报文丢弃率(%)', '11283', '0', '0', '3', '0', '10', '2', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('800', 'QoS匹配速率(packets/s)', 'QoS匹配速率(packets/s)', '6500', '100000', '0', '3', '0', '30', '8', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('801', 'QoS匹配速率(Bps)', 'QoS匹配速率(bytes/s)', '6501', '100000', '0', '3', '0', '20', '8', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('802', '符合CIR的报文速率(packets/s)', '符合CIR的报文速率(packets/s)', '6502', '100000', '0', '3', '0', '30', '8', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('803', '符合CIR的报文速率(Bps)', '符合CIR的报文速率(bytes/s)', '6503', '100000', '0', '3', '0', '20', '8', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('804', '不符合CIR的报文速率(packets/s)', '不符合CIR的报文速率(packets/s)', '6504', '100000', '0', '3', '0', '30', '8', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('805', '不符合CIR的报文速率(Bps)', '不符合CIR的报文速率(bytes/s)', '6505', '100000', '0', '3', '0', '20', '8', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('806', 'GTS方式通过的报文速率(packets/s)', 'GTS方式通过的报文速率(packets/s)', '6506', '100000', '0', '3', '0', '30', '8', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('807', 'GTS方式通过的报文速率(Bps)', 'GTS方式通过的报文速率(bytes/s)', '6507', '100000', '0', '3', '0', '20', '8', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('808', 'GTS方式丢弃的报文速率(packets/s)', 'GTS方式丢弃的报文速率(packets/s)', '6508', '100000', '0', '3', '0', '30', '8', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('809', 'GTS方式丢弃的报文速率(Bps)', 'GTS方式丢弃的报文速率(bytes/s)', '6509', '100000', '0', '3', '0', '20', '8', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('810', 'GTS方式延迟报文速率(packets/s)', 'GTS方式延迟报文速率(packets/s)', '6510', '100000', '0', '3', '0', '30', '8', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('811', 'GTS方式延迟报文速率(Bps)', 'GTS方式延迟报文速率(bytes/s)', '6511', '100000', '0', '3', '0', '20', '8', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('812', '队列方式匹配的报文速率(packets/s)', '队列方式匹配的报文速率(packets/s)', '6512', '100000', '0', '3', '0', '30', '8', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('813', '队列方式匹配的报文速率(Bps)', '队列方式匹配的报文速率(bytes/s)', '6513', '100000', '0', '3', '0', '20', '8', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('816', '队列方式正常通过的报文速率(packets/s)', '队列方式正常通过的报文速率(packets/s)', '6516', '100000', '0', '3', '0', '30', '8', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('817', '队列方式正常通过的报文速率(Bps)', '队列方式正常通过的报文速率(bytes/s)', '6517', '100000', '0', '3', '0', '20', '8', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('818', '队列方式丢弃的报文速率(packets/s)', '队列方式丢弃的报文速率(packets/s)', '6518', '100000', '0', '3', '0', '30', '8', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('819', '队列方式丢弃的报文速率(Bps)', '队列方式丢弃的报文速率(bytes/s)', '6519', '100000', '0', '3', '0', '20', '8', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('851', 'CPU利用率(%)', 'CPU利用率', '28001', '60', '0', '3', '58', '10', '18', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('852', '内存利用率(%)', '内存利用率', '28002', '60', '0', '3', '58', '10', '18', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('853', '活动内存(Kbytes)', '活动内存', '28003', '3000000', '0', '3', '58', '61', '18', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('854', '共享的公用内存(Kbytes)', '共享的公用内存', '28004', '3000000', '0', '3', '58', '61', '18', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('855', '已分配内存(Kbytes)', '已分配内存', '28005', '10000', '0', '3', '58', '61', '18', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('856', '虚拟增长内存(Kbytes)', '虚拟增长内存', '28006', '10000', '0', '3', '58', '61', '18', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('857', '磁盘读速率(KBps)', '磁盘读速率', '28007', '10000', '0', '3', '58', '21', '18', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('858', '磁盘写速率(KBps)', '磁盘写速率', '28008', '10000', '0', '3', '58', '21', '18', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('859', '磁盘I/0速率(KBps)', '磁盘I/0速率', '28009', '10000', '0', '3', '58', '21', '18', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('860', '网络接收速率(KBps)', '网络接收速率', '28010', '10000', '0', '3', '58', '21', '18', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('861', '网络发送速率(KBps)', '网络发送速率', '28011', '10000', '0', '3', '58', '21', '18', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('862', '网络速率(KBps)', '网络速率', '28012', '10000', '0', '3', '58', '21', '18', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('900', '路由地址丢弃率(overload/s)', '路由地址丢弃率(overload/s)', '17', '70', '0', '3', '0', '140', '1', '111', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('901', 'STP拓扑变化率(times/s)', 'STP拓扑变化率(times/s)', '18', '10', '0', '3', '0', '150', '1', '111', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('902', '硬件监控', '硬件监控', '20', '1', '0', '3', '0', '0', '1', '111', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('903', '实体扩展MIB内存总量(Mbytes)', '实体扩展MIB内存总量', '601', '100000', '0', '3', '0', '160', '1', '111', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('905', '实体扩展MIB已用内存总量(Mbytes)', '实体扩展MIB已用内存总量', '603', '100000', '0', '3', '0', '160', '1', '111', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('906', '服务器存储空间利用率(%)', '服务器存储空间利用率(%)', '16', '70', '0', '3', '0', '10', '1', '111', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('907', 'Enterasys存储空间利用率(%)', 'Enterasys存储空间利用率(%)', '605', '70', '0', '3', '0', '10', '1', '111', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1000', '每秒E1接口收到错包总数(packets/s)', '每秒E1接口收到错包总数', '14001', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1001', '每秒E1接口收到的超短包的错误数(packets/s)', '每秒E1接口收到的超短包的错误数', '14002', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1002', '每秒E1接口收到的超长包的错误数(packets/s)', '每秒E1接口收到的超长包的错误数', '14003', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1003', '每秒E1接口收到的CRC错包数(packets/s)', '每秒E1接口收到的CRC错包数', '14004', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1004', '每秒E1接口收到的Align错包数(packets/s)', '每秒E1接口收到的Align错包数', '14005', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1005', '每秒E1接口收到的OverRun错包数(packets/s)', '每秒E1接口收到的OverRun错包数', '14006', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1006', '每秒E1接口收到的Dribble错包数(packets/s)', '每秒E1接口收到的Dribble错包数', '14007', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1007', '每秒E1接口收到的AbortedSeq错包数(packets/s)', '每秒E1接口收到的AbortedSeq错包数', '14008', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1008', '每秒E1接口收到的NoBuffer错包数(packets/s)', '每秒E1接口收到的NoBuffer错包数', '14009', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1009', '每秒E1接口收到的Framing错包数(packets/s)', '每秒E1接口收到的Framing错包数', '14010', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1010', '每秒E1接口发出的错包总数(packets/s)', '每秒E1接口发出的错包总数', '14011', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1011', '每秒E1接口发出的UnderRun错包数(packets/s)', '每秒E1接口发出的UnderRun错包数', '14012', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1012', '每秒E1接口发出的Collison错包数(packets/s)', '每秒E1接口发出的Collison错包数', '14013', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1013', '每秒E1接口发出的OutDefered错包数(packets/s)', '每秒E1接口发出的OutDefered错包数', '14014', '100000', '0', '3', '0', '30', '9', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1030', '每秒T1接口收到错包总数(packets/s)', '每秒T1接口收到错包总数', '15001', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1031', '每秒T1接口收到的超短包的错误数(packets/s)', '每秒T1接口收到的超短包的错误数', '15002', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1032', '每秒T1接口收到的超长包的错误数(packets/s)', '每秒T1接口收到的超长包的错误数', '15003', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1033', '每秒T1接口收到的CRC错包数(packets/s)', '每秒T1接口收到的CRC错包数', '15004', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1034', '每秒T1接口收到的Align错包数(packets/s)', '每秒T1接口收到的Align错包数', '15005', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1035', '每秒T1接口收到的OverRun错包数(packets/s)', '每秒T1接口收到的OverRun错包数', '15006', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1036', '每秒T1接口收到的Dribble错包数(packets/s)', '每秒T1接口收到的Dribble错包数', '15007', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1037', '每秒T1接口收到的AbortedSeq错包数(packets/s)', '每秒T1接口收到的AbortedSeq错包数', '15008', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1038', '每秒T1接口收到的NoBuffer错包数(packets/s)', '每秒T1接口收到的NoBuffer错包数', '15009', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1039', '每秒T1接口收到的Framing错包数(packets/s)', '每秒T1接口收到的Framing错包数', '15010', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1040', '每秒T1接口发出的错包总数(packets/s)', '每秒T1接口发出的错包总数', '15011', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1041', '每秒T1接口发出的UnderRun错包数(packets/s)', '每秒T1接口发出的UnderRun错包数', '15012', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1042', '每秒T1接口发出的Collison错包数(packets/s)', '每秒T1接口发出的Collison错包数', '15013', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1043', '每秒T1接口发出的OutDefered错包数(packets/s)', '每秒T1接口发出的OutDefered错包数', '15014', '100000', '0', '3', '0', '30', '9', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1060', '每秒PPP接收到错误地址域的包数(packets/s)', '每秒PPP接收到错误地址域的包数', '16001', '100000', '0', '3', '0', '30', '9', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1061', '每秒PPP接收到错误控制域的包数(packets/s)', '每秒PPP接收到错误控制域的包数', '16002', '100000', '0', '3', '0', '30', '9', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1062', '每秒PPP长度超过MRU而丢弃的包数(packets/s)', '每秒PPP长度超过MRU而丢弃的包数', '16003', '100000', '0', '3', '0', '30', '9', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1063', '每秒PPP包含错误的FCS而丢弃的包数(packets/s)', '每秒PPP包含错误的FCS而丢弃的包数', '16004', '100000', '0', '3', '0', '30', '9', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1080', 'MP链路绑定的下一级信道数', 'MP链路绑定的下一级信道数', '17001', '10', '0', '3', '0', '0', '9', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1081', '每秒MP链路丢弃的错误的数据块数(packets/s)', '每秒MP链路丢弃的错误的数据块数', '17002', '100000', '0', '3', '0', '30', '9', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1082', '每秒MP链路已重排序的接收包数(packets/s)', '每秒MP链路已重排序的接收包数', '17003', '100000', '0', '3', '0', '30', '9', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1083', '每秒MP链路等待重排序的接收包数(packets/s)', '每秒MP链路等待重排序的接收包数', '17004', '100000', '0', '3', '0', '30', '9', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1084', '每秒MP链路根据包序交叉存取的接收包数(packets/s)', '每秒MP链路根据包序交叉存取的接收包数', '17005', '100000', '0', '3', '0', '30', '9', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1300', '接口接收错误包数(packets)', '接口接收错误包数', '2056', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1301', '接口发送错误包数(packets)', '接口发送错误包数', '2057', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1302', '接口丢弃的输入包数(packets)', '接口丢弃的输入包数', '2058', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1303', '接口丢弃的输出包数(packets)', '接口丢弃的输出包数', '2059', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1304', '接口接收速率(packets/s)', '接口接收速率(packets/s)', '2060', '100000', '0', '3', '0', '30', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1305', '接口发送速率(packets/s)', '接口发送速率(packets/s)', '2061', '100000', '0', '3', '0', '30', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1306', '接口接收多播包速率(packets/s)', '接口接收多播包速率(packets/s)', '2062', '100000', '0', '3', '0', '30', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1307', '接口发送多播包速率(packets/s)', '接口发送多播包速率(packets/s)', '2063', '100000', '0', '3', '0', '30', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1308', '接口接收的未知协议包数(packets)', '接口接收的未知协议包数', '2066', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1309', '接口输入包错误率(%)', '接口输入包错误率(%)', '2069', '0', '0', '3', '0', '10', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1310', '接口输出包错误率(%)', '接口输出包错误率(%)', '2070', '0', '0', '3', '0', '10', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1311', '接口失效率(%)', '接口失效率(%)', '2071', '0', '0', '3', '0', '10', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1312', '接口收发速率(bps)', '接口收发速率(ifmib，bits/s)', '2072', '100000', '0', '3', '0', '220', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1313', '接口收发速率(packets/s)', '接口收发速率(packets/s)', '2074', '100000', '0', '3', '0', '30', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1314', '设备错误包数(packets)', '设备错误包数(frames)', '2075', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1315', '接口包错误率(%)', '接口包错误率(%)', '19', '0', '0', '3', '0', '10', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1316', '接口接收字节数(bytes)', '接口接收字节数(ifmib，bytes)', '6620', '100000', '0', '3', '0', '60', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1317', '接口发送字节数(bytes)', '接口发送字节数(ifmib，bytes)', '6621', '100000', '0', '3', '0', '60', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1318', '接口接收包数(packets)', '接口接收包数(packets)', '6626', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1319', '接口发送包数(packets)', '接口发送包数(packets)', '6627', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1320', '丢弃报文数目(packets)', '丢弃报文数目(packets)', '6628', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1321', '错误报文数目(packets)', '错误报文数目(packets)', '6629', '100000', '0', '3', '0', '70', '1', '7', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1400', 'PoE端口当前消耗功率(milliWatts)', 'PoE端口当前消耗功率(milliWatts)', '18001', '100000', '0', '3', '0', '200', '12', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1402', 'PSE板平均消耗功率(Watts)', 'PSE板端口平均消耗功率(Watts)', '18002', '100', '0', '3', '0', '201', '12', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1451', '光模块当前发送功率(dBm)', '光模块当前发送功率(dbmw)', '18501', '100000', '0', '3', '0', '130', '12', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1461', '光模块当前接收功率(dBm)', '光模块当前接收功率(dbmw)', '18502', '100000', '0', '3', '0', '130', '12', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1500', '每秒报文丢弃事件数', '每秒报文丢弃事件数', '19001', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1501', '接收字节速率(Bps)', '接收字节速率', '19002', '70', '0', '3', '0', '20', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1502', '接收报文速率(packets/s)', '接收报文速率', '19003', '70', '0', '3', '0', '30', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1503', '接收广播报文速率(packets/s)', '接收广播报文速率', '19004', '70', '0', '3', '0', '30', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1504', '接收多播报文速率(packets/s)', '接收多播报文速率', '19005', '70', '0', '3', '0', '30', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1505', '每秒CRC校验错误报文数', '每秒CRC校验错误报文数', '19006', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1506', '每秒接收少于64字节报文数', '每秒接收少于64字节报文数', '19007', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1507', '每秒接收超过1518字节报文数', '每秒接收超过1518字节报文数', '19008', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1508', '每秒接收少于64字节且FCS错误报文数', '每秒接收少于64字节且FCS错误报文数', '19009', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1509', '每秒接收超过1518字节报文数且FCS错误报文数', '每秒接收超过1518字节报文数且FCS错误报文数', '19010', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1510', '每秒网络冲突速数', '每秒网络冲突速数', '19011', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1511', '每秒接收64字节报文数', '每秒接收64字节报文数', '19012', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1512', '每秒接收65至127字节报文数', '每秒接收65至127字节报文数', '19013', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1513', '每秒接收128至255字节报文数', '每秒接收128至255字节报文数', '19014', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1514', '每秒接收256至511字节报文数', '每秒接收256至511字节报文数', '19015', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1515', '每秒接收512至1023字节报文数', '每秒接收512至1023字节报文数', '19016', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1516', '每秒接收1024至1518字节报文数', '每秒接收1024至1518字节报文数', '19017', '100', '0', '3', '0', '0', '11', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1600', '单个主叫号码每分钟接收报文数(packets/min)', '单个主叫号码每分钟接收报文数', '31600', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1601', '单个主叫号码每分钟发送报文数(packets/min)', '单个主叫号码每分钟发送报文数', '31601', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1602', '单个主叫号码每分钟因格式错误丢弃的报文数(packets/min)', '单个主叫号码每分钟因格式错误丢弃的报文数', '31602', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1603', '单个主叫号码每分钟因映射处理错误丢弃的报文数(packets/min)', '单个主叫号码每分钟因映射处理错误丢弃的报文数', '31603', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1604', '单个主叫号码每分钟因接收缓存满丢弃的报文数(packets/min)', '单个主叫号码每分钟因接收缓存满丢弃的报文数', '31604', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1605', '单个主叫号码每分钟因链路不通丢弃的报文数(packets/min)', '单个主叫号码每分钟因链路不通丢弃的报文数', '31605', '0', '0', '3', '0', '230', '19', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1610', '单个POS终端每分钟接收报文数(packets/min)', '单个POS终端每分钟接收报文数', '31620', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1611', '单个POS终端每分钟发送报文数(packets/min)', '单个POS终端每分钟发送报文数', '31621', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1612', '单个POS终端每分钟因格式错误丢弃的报文数(packets/min)', '单个POS终端每分钟因格式错误丢弃的报文数', '31622', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1613', '单个POS终端每分钟因映射处理错误丢弃的报文数(packets/min)', '单个POS终端每分钟因映射处理错误丢弃的报文数', '31623', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1614', '单个POS终端每分钟因接收缓存满丢弃的报文数(packets/min)', '单个POS终端每分钟因接收缓存满丢弃的报文数', '31624', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1615', '单个POS终端每分钟因链路不通丢弃的报文数(packets/min)', '单个POS终端每分钟因链路不通丢弃的报文数', '31625', '0', '0', '3', '0', '230', '19', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1620', '单个IP终端交易统计项每分钟接收报文数(packets/min)', '单个IP终端交易统计项每分钟接收报文数', '31640', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1621', '单个IP终端交易统计项每分钟发送报文数(packets/min)', '单个IP终端交易统计项每分钟发送报文数', '31641', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1622', '单个IP终端交易统计项每分钟因格式错误丢弃的报文数(packets/min)', '单个IP终端交易统计项每分钟因格式错误丢弃的报文数', '31642', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1623', '单个IP终端交易统计项每分钟因映射处理错误丢弃的报文数(packets/min)', '单个IP终端交易统计项每分钟因映射处理错误丢弃的报文数', '31643', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1624', '单个IP终端交易统计项每分钟因接收缓存满丢弃的报文数(packets/min)', '单个IP终端交易统计项每分钟因接收缓存满丢弃的报文数', '31644', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1625', '单个IP终端交易统计项每分钟因链路不通丢弃的报文数(packets/min)', '单个IP终端交易统计项每分钟因链路不通丢弃的报文数', '31645', '0', '0', '3', '0', '230', '19', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1630', '单个POS应用每分钟接收报文数(packets/min)', '单个POS应用每分钟接收报文数', '31660', '0', '0', '3', '0', '230', '19', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1631', '单个POS应用每分钟发送报文数(packets/min)', '单个POS应用每分钟发送报文数', '31661', '0', '0', '3', '0', '230', '19', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1632', '单个POS应用每分钟因格式错误丢弃的报文数(packets/min)', '单个POS应用每分钟因格式错误丢弃的报文数', '31662', '0', '0', '3', '0', '230', '19', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1634', '单个POS应用每分钟因接收缓存满丢弃的报文数(packets/min)', '单个POS应用每分钟因接收缓存满丢弃的报文数', '31664', '0', '0', '3', '0', '230', '19', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1635', '单个POS应用每分钟因链路不通丢弃的报文数(packets/min)', '单个POS应用每分钟因链路不通丢弃的报文数', '31665', '0', '0', '3', '0', '230', '19', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1636', 'E1通道占用率(%)', 'E1通道占用率(%)', '31666', '80', '0', '3', '0', '10', '19', '4', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1640', '单个FCM接口每分钟因交易超时而断开连接次数', '单个FCM接口每分钟因交易超时而断开连接次数', '31680', '0', '0', '3', '0', '0', '19', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1641', '单个FCM接口每分钟拨号协商失败的次数', '单个FCM接口每分钟拨号协商失败的次数', '31681', '0', '0', '3', '0', '0', '19', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1642', 'POS机拨号接通率(%)', 'POS机拨号接通率(%)', '31682', '80', '0', '3', '0', '10', '19', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1643', 'IP-POS并发交易数量', 'IP-POS并发交易数量', '31706', '0', '0', '3', '0', '0', '19', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('1644', 'E1-POS并发交易数量', 'E1-POS并发交易数量', '31707', '0', '0', '3', '0', '0', '19', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200101', '(系统<-客户端)输入包速率(packets/s)', '(系统<-客户端)输入包速率', '50101', '10000000', '0', '3', '0', '30', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200102', '(系统->客户端)输出包速率(packets/s)', '(系统->客户端)输出包速率', '50102', '10000000', '0', '3', '0', '30', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200103', '(系统<-客户端)数据接收速率(bps)', '(系统<-客户端)数据接收速率', '50103', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200104', '(系统->客户端)数据发送速率(bps)', '(系统->客户端)数据发送速率', '50104', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200105', '(系统<->客户端)最大连接数', '(系统<->客户端)最大连接数', '50105', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200106', '(系统<->客户端)所有连接数', '(系统<->客户端)所有连接数', '50106', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200107', '(系统<->客户端)当前连接数', '(系统<->客户端)当前连接数', '50107', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200108', '(系统<->客户端)数据收发速率(bps)', '(系统<->客户端)数据收发速率', '50108', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200201', '(系统<-服务端)输入包速率(packets/s)', '(系统<-服务端)输入包速率', '50201', '10000000', '0', '3', '0', '30', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200202', '(系统->服务端)输出包速率(packets/s)', '(系统->服务端)输出包速率', '50202', '10000000', '0', '3', '0', '30', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200203', '(系统<-服务端)数据接收速率(bps)', '(系统<-服务端)数据接收速率', '50203', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200204', '(系统->服务端)数据发送速率(bps)', '(系统->服务端)数据发送速率', '50204', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200205', '(系统<->服务端)最大连接数', '(系统<->服务端)最大连接数', '50205', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200206', '(系统<->服务端)所有连接数', '(系统<->服务端)所有连接数', '50206', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200207', '(系统<->服务端)当前连接数', '(系统<->服务端)当前连接数', '50207', '10000000', '0', '3', '0', '0', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('200208', '(系统<->服务端)数据收发速率(bps)', '(系统<->服务端)数据收发速率', '50208', '10000000', '0', '3', '0', '220', '24', '1', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('203101', '(本地流量管理)(节点<-服务端)输入包速率(packets/s)', '(本地流量管理)(节点<-服务端)输入包速率', '55101', '10000000', '0', '3', '0', '30', '24', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('203102', '(本地流量管理)(节点->服务端)输出包速率(packets/s)', '(本地流量管理)(节点->服务端)输出包速率', '55102', '10000000', '0', '3', '0', '30', '24', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('203103', '(本地流量管理)(节点<-服务端)数据接收速率(bps)', '(本地流量管理)(节点<-服务端)数据接收速率', '55103', '10000000', '0', '3', '0', '220', '24', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('203104', '(本地流量管理)(节点->服务端)数据发送速率(bps)', '(本地流量管理)(节点->服务端)数据发送速率', '55104', '10000000', '0', '3', '0', '220', '24', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('203105', '(本地流量管理)(节点<->服务端)最大连接数', '(本地流量管理)(节点<->服务端)最大连接数', '55105', '10000000', '0', '3', '0', '0', '24', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('203106', '(本地流量管理)(节点<->服务端)所有连接数', '(本地流量管理)(节点<->服务端)所有连接数', '55106', '10000000', '0', '3', '0', '0', '24', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('203107', '(本地流量管理)(节点<->服务端)当前连接数', '(本地流量管理)(节点<->服务端)当前连接数', '55107', '10000000', '0', '3', '0', '0', '24', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('203108', '(本地流量管理)(节点<->服务端)所有请求数', '(本地流量管理)(节点<->服务端)所有请求数', '55108', '10000000', '0', '3', '0', '0', '24', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('203109', '(本地流量管理)(节点<->服务端)数据收发速率(bps)', '(本地流量管理)(节点<->服务端)数据收发速率', '55109', '10000000', '0', '3', '0', '220', '24', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('203110', '(本地流量管理)(节点<->服务端)-节点状态', '(本地流量管理)(节点<->服务端)-节点状态', '55110', '0', '0', '3', '0', '0', '24', '5', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('204101', '(本地流量管理)(节点池&lt;-服务端)输入包速率(packets/s)', '(本地流量管理)(节点池&lt;-服务端)输入包速率', '56101', '10000000', '0', '3', '0', '30', '24', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('204102', '(本地流量管理)(节点池->服务端)输出包速率(packets/s)', '(本地流量管理)(节点池->服务端)输出包速率', '56102', '10000000', '0', '3', '0', '30', '24', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('204103', '(本地流量管理)(节点池&lt;-服务端)数据接收速率(bps)', '(本地流量管理)(节点池&lt;-服务端)数据接收速率', '56103', '10000000', '0', '3', '0', '220', '24', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('204104', '(本地流量管理)(节点池->服务端)数据发送速率(bps)', '(本地流量管理)(节点池->服务端)数据发送速率', '56104', '10000000', '0', '3', '0', '220', '24', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('204105', '(本地流量管理)(节点池&lt;->服务端)最大连接数', '(本地流量管理)(节点池&lt;->服务端)最大连接数', '56105', '10000000', '0', '3', '0', '0', '24', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('204106', '(本地流量管理)(节点池&lt;->服务端)所有连接数', '(本地流量管理)(节点池&lt;->服务端)所有连接数', '56106', '10000000', '0', '3', '0', '0', '24', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('204107', '(本地流量管理)(节点池&lt;->服务端)当前连接数', '(本地流量管理)(节点池&lt;->服务端)当前连接数', '56107', '10000000', '0', '3', '0', '0', '24', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('204108', '(本地流量管理)(节点池&lt;->服务端)数据收发速率(bps)', '(本地流量管理)(节点池&lt;->服务端)数据收发速率', '56108', '10000000', '0', '3', '0', '220', '24', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('204109', '(本地流量管理)(节点池&lt;->服务端)-节点池状态', '(本地流量管理)(节点池&lt;->服务端)-节点池状态', '56109', '0', '0', '3', '0', '0', '24', '6', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('205101', '(本地流量管理)(虚拟服务器&lt;-客户端)输入包速率(packets/s)', '(本地流量管理)(虚拟服务器&lt;-客户端)输入包速率', '54101', '10000000', '0', '3', '0', '30', '24', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('205102', '(本地流量管理)(虚拟服务器->客户端)输出包速率(packets/s)', '(本地流量管理)(虚拟服务器->客户端)输出包速率', '54102', '10000000', '0', '3', '0', '30', '24', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('205103', '(本地流量管理)(虚拟服务器&lt;-客户端)数据接收速率(bps)', '(本地流量管理)(虚拟服务器&lt;-客户端)数据接收速率', '54103', '10000000', '0', '3', '0', '220', '24', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('205104', '(本地流量管理)(虚拟服务器->客户端)数据发送速率(bps)', '(本地流量管理)(虚拟服务器->客户端)数据发送速率', '54104', '10000000', '0', '3', '0', '220', '24', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('205105', '(本地流量管理)(虚拟服务器&lt;->客户端)最大连接数', '(本地流量管理)(虚拟服务器&lt;->客户端)最大连接数', '54105', '10000000', '0', '3', '0', '0', '24', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('205106', '(本地流量管理)(虚拟服务器&lt;->客户端)所有连接数', '(本地流量管理)(虚拟服务器&lt;->客户端)所有连接数', '54106', '10000000', '0', '3', '0', '0', '24', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('205107', '(本地流量管理)(虚拟服务器&lt;->客户端)当前连接数', '(本地流量管理)(虚拟服务器&lt;->客户端)当前连接数', '54107', '10000000', '0', '3', '0', '0', '24', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('205108', '(本地流量管理)(虚拟服务器&lt;->客户端)数据收发速率(bps)', '(本地流量管理)(虚拟服务器&lt;->客户端)数据收发速率', '54108', '10000000', '0', '3', '0', '220', '24', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('205109', '(本地流量管理)(虚拟服务器&lt;->客户端)-虚拟服务器状态', '(本地流量管理)(虚拟服务器&lt;->客户端)-虚拟服务器状态', '54109', '0', '0', '3', '0', '0', '24', '2', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('208101', '负载均衡设备平均CPU利用率(%)', '负载均衡设备平均CPU利用率', '58101', '10000000', '0', '3', '0', '10', '24', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('208102', '负载均衡设备CPU利用率(流量管理模块)(%)', '负载均衡设备CPU利用率(流量管理模块)', '58501', '10000000', '0', '3', '0', '10', '24', '3', '2015-07-28 00:43:17');
INSERT INTO `task` VALUES ('209101', '负载均衡设备内存利用率(流量管理模块)(%)', '负载均衡设备内存利用率(流量管理模块)', '59101', '10000000', '0', '3', '0', '10', '24', '4', '2015-07-28 00:43:17');
INSERT INTO `user` VALUES ('1', 'test', '', '', null, '', '10', '0', '0', null, null);
INSERT INTO `user` VALUES ('2', '111', 'xyRTkw563Ql_a8Y0OLjv5G4yyIJgQX2p', '$2y$13$aHzRtU8MOgRAS0c4RBXsw.zy8qqTXwyzqvP6vySAgKgSUwlseckFO', null, '1111@111.111', '10', '2015', '2015', '12121', '111');
INSERT INTO `user` VALUES ('3', 'test1', 'V_fyl11qCCvBHwdRW9noJVbmbz6jJQp4', '$2y$13$qLDuVOiBVbRJR3bTLOObB.WNfCJS//Yt9PIJ8SAGwLLmGJMyCrb5C', null, '111@111.111', '10', '2015', '2015', 'sdfadsfads', '111');
INSERT INTO `user` VALUES ('4', 'test2', 'Bs_q8pCeuMHmr_mGV-cIi6Sx1wZgsMR1', '$2y$13$kYwsuc/QMkWd7quG/mJMPeroor9MfABtUikOte8XT7oJ16ZwvJ0mK', null, '11@11.11', '10', '2015', '2015', 'ceshi', '111');
INSERT INTO `user` VALUES ('5', 'yrsdydsr', 'Qc2DYX7i-5xXJKYQypMHX3WdMrvqJRrT', '$2y$13$V6ulOTQoLWIsXFDLm41wVOKBiWVKhGNS0HxhBkQIJfk9SPPQPwoa.', null, 'ssds@11.11', '10', '2015', '2015', '', null);
INSERT INTO `user` VALUES ('6', '1212', 'LS3G2y7Ec-GqFs1R_ePO5r-nmNsAvcRU', '$2y$13$mQVXQIG04w3zieVT8/WVHevcDQ9OFtJxB7jeYkZJWSOfxRl6rwtZW', null, 'sss@ss.ss', '10', '2015', '2015', '1撒大多数', '111');
INSERT INTO `user` VALUES ('7', 'dsfdfgfds', 'V6xuy3yt3ugR_r2Dd_iXZSOippvuB1VV', '$2y$13$vpQSmaQyQ4n2.z2TAXcUMO9sqRRQof4E5tgugrSZh1klp3SijBaW6', null, 'fdsfsd@11.11', '10', '2015', '2015', '', null);
INSERT INTO `user` VALUES ('8', 'fdsfdsfsad', 'w6pP0PkLMGd5CbXP8MaJs7dpcIyK_DgC', '$2y$13$sTOE20VU/qz7Z.n7UneM3.tKLTFsFpBCb7JXyZYh7PJdjfOU/oLHW', null, '', '10', '2015', '2015', '', null);
INSERT INTO `user` VALUES ('9', 'dsfdsafadsfs', 'myZ7k_muw5En9F3ttJFhdn3RFOo_QC-X', '$2y$13$kmDTxUJe3zqe9Yug6NjIVuW.v0DkF6nMyyNpJ7jyAlGoDc2fE08eG', null, '', '10', '2015', '2015', '', null);
INSERT INTO `user` VALUES ('10', 'dsdsfsf', 'pZ3CvENXrnXKaSeSBJ2T2ugRKDUpGhNb', '$2y$13$pGb/76fxa8eXF3W1WQAHOuPMBpSHVdLpDmeUzE83zrJk1TLqPzAQa', null, '', '10', '2015', '2015', '', null);
INSERT INTO `user` VALUES ('11', 'fdffdg', 'gyvmM7vt_82TEHlBBdy_EORbpWpZVzNv', '$2y$13$G.BkIwMkA488R9eC1HPpP.mHUfaUEQuvusU.u5vkLbSPe/rM6FsRS', null, '', '10', '2015', '2015', '', null);
INSERT INTO `view_template` VALUES ('5', '1', '4', '{\"type\":\"switch\",\"title\":\"stack_1.A-F5-S5100-02\",\"cx\":170,\"cy\":267,\"rx\":15,\"ry\":6.5,\"__id__\":\"5\"}', null);
INSERT INTO `view_template` VALUES ('6', '1', '9', '{\"type\":\"switch\",\"title\":\"stack_1.A-F8-S5100-02\",\"cx\":165,\"cy\":229,\"rx\":15,\"ry\":6.5,\"__id__\":\"6\"}', null);
INSERT INTO `view_template` VALUES ('7', '1', '6', '{\"type\":\"switch\",\"title\":\"stack_0.A-F7-S5100-01\",\"cx\":176,\"cy\":308,\"rx\":15,\"ry\":6.5,\"__id__\":\"7\"}', null);
INSERT INTO `view_template` VALUES ('8', '1', '3', '{\"type\":\"switch\",\"title\":\"stack_0.A-F2-S5100-01\",\"cx\":182,\"cy\":348,\"rx\":15,\"ry\":6.5,\"__id__\":\"8\"}', null);
INSERT INTO `view_template` VALUES ('9', '1', '8', '{\"type\":\"switch\",\"title\":\"stack_0.A-F3-S5100-01\",\"cx\":501,\"cy\":247,\"rx\":15,\"ry\":6.5,\"__id__\":\"9\"}', null);
INSERT INTO `view_template` VALUES ('10', '1', '13', '{\"type\":\"switch\",\"title\":\"stack_0.A-F7-S5100-02\",\"cx\":501,\"cy\":205,\"rx\":15,\"ry\":6.5,\"__id__\":\"10\"}', null);
INSERT INTO `view_template` VALUES ('11', '1', '16', '{\"type\":\"switch\",\"title\":\"stack_0.A-F8-S5100-01\",\"cx\":499,\"cy\":163,\"rx\":15,\"ry\":6.5,\"__id__\":\"11\"}', null);
INSERT INTO `view_template` VALUES ('12', '1', '10', '{\"type\":\"switch\",\"title\":\"stack_1.A-F9-S5100-02\",\"cx\":188,\"cy\":390,\"rx\":15,\"ry\":6.5,\"__id__\":\"12\"}', null);
INSERT INTO `view_template` VALUES ('13', '1', '12', '{\"type\":\"switch\",\"title\":\"stack_0.A-F10-S5100-01\",\"cx\":502,\"cy\":291,\"rx\":15,\"ry\":6.5,\"__id__\":\"13\"}', null);
INSERT INTO `view_template` VALUES ('14', '1', '2', '{\"type\":\"switch\",\"title\":\"stack_0.A-F4-S5100-01\",\"cx\":505,\"cy\":340,\"rx\":15,\"ry\":6.5,\"__id__\":\"14\"}', null);
