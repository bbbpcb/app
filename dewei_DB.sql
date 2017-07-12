/*
Navicat MySQL Data Transfer

Source Server         : 德为
Source Server Version : 50173
Source Host           : 120.24.101.39:3306
Source Database       : dewei

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2016-12-28 20:48:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dw_aboutsys`
-- ----------------------------
DROP TABLE IF EXISTS `dw_aboutsys`;
CREATE TABLE `dw_aboutsys` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `rank` int(4) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_aboutsys
-- ----------------------------
INSERT INTO `dw_aboutsys` VALUES ('2', '级别标准分说明', '', '1', '1');
INSERT INTO `dw_aboutsys` VALUES ('3', '任务积分说明', '', '2', '1');
INSERT INTO `dw_aboutsys` VALUES ('4', '问题研讨说明', '', '3', '1');

-- ----------------------------
-- Table structure for `dw_advs`
-- ----------------------------
DROP TABLE IF EXISTS `dw_advs`;
CREATE TABLE `dw_advs` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `typeid` tinyint(3) DEFAULT '1',
  `title` varchar(120) CHARACTER SET utf8 DEFAULT NULL COMMENT '图片名称',
  `img1` varchar(512) NOT NULL,
  `links` varchar(512) NOT NULL COMMENT '链接地址',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='图片资源表';

-- ----------------------------
-- Records of dw_advs
-- ----------------------------
INSERT INTO `dw_advs` VALUES ('1', '1', '测试', '20150825103232.jpg', '#', '1');
INSERT INTO `dw_advs` VALUES ('3', '1', 'aaaaa', '20150825103242.jpg', '#', '1');

-- ----------------------------
-- Table structure for `dw_article`
-- ----------------------------
DROP TABLE IF EXISTS `dw_article`;
CREATE TABLE `dw_article` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 NOT NULL,
  `version` varchar(200) CHARACTER SET utf8 NOT NULL,
  `website` varchar(255) NOT NULL,
  `tel` varchar(40) NOT NULL,
  `tag` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_article
-- ----------------------------
INSERT INTO `dw_article` VALUES ('1', '', '1.1.0', 'http://www.xxx.com', '400-886-9008', 'aboutus');

-- ----------------------------
-- Table structure for `dw_conquer`
-- ----------------------------
DROP TABLE IF EXISTS `dw_conquer`;
CREATE TABLE `dw_conquer` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '发布者id',
  `title` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '攻关标题',
  `typeid` int(8) DEFAULT NULL COMMENT '类型',
  `content` text CHARACTER SET utf8 COMMENT '任务描述',
  `icon` varchar(200) DEFAULT NULL COMMENT '图标',
  `c_cost` decimal(8,2) NOT NULL,
  `c_days` int(4) NOT NULL DEFAULT '0',
  `c_degree` int(4) NOT NULL DEFAULT '0',
  `total` int(4) DEFAULT '0' COMMENT '最优得分',
  `summary` text CHARACTER SET utf8 COMMENT '专家总结',
  `createtime` int(4) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '发布状态，1-正常，0-停止.3结束',
  `bestid` int(8) DEFAULT NULL COMMENT '最后回答用户id',
  `endtime` int(4) DEFAULT NULL,
  `proid` int(11) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1 COMMENT='复盘表，原来的任职积分';

-- ----------------------------
-- Records of dw_conquer
-- ----------------------------
INSERT INTO `dw_conquer` VALUES ('97', '119', '启动会方案', '1', '畅所欲言', null, '0.00', '0', '0', '1', '三个建议比较好', '1441507601', '3', null, '1441507787', '555', '1');
INSERT INTO `dw_conquer` VALUES ('98', '126', '默默', '1', '阿德', null, '0.00', '0', '0', '10', '很好', '1479386211', '3', null, '1481869354', '562', '1');
INSERT INTO `dw_conquer` VALUES ('99', '123', '义', '1', '…', null, '0.00', '0', '0', '5', null, '1482810597', '1', null, null, '618', '1');

-- ----------------------------
-- Table structure for `dw_conquer_reply`
-- ----------------------------
DROP TABLE IF EXISTS `dw_conquer_reply`;
CREATE TABLE `dw_conquer_reply` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) DEFAULT NULL,
  `cid` int(8) DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  `createtime` int(4) DEFAULT NULL,
  `isbest` tinyint(2) DEFAULT '0',
  `company_id` int(11) DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_conquer_reply
-- ----------------------------
INSERT INTO `dw_conquer_reply` VALUES ('184', '121', '97', '法国家看看', '1441507705', '1', '1');
INSERT INTO `dw_conquer_reply` VALUES ('185', '121', '97', '一让他鱼', '1441507712', '0', '1');
INSERT INTO `dw_conquer_reply` VALUES ('186', '119', '97', '是哪？', '1441507736', '0', '1');
INSERT INTO `dw_conquer_reply` VALUES ('187', '123', '97', '测试', '1479375371', '0', '1');
INSERT INTO `dw_conquer_reply` VALUES ('188', '126', '97', '啊啊啊', '1479386166', '0', '1');
INSERT INTO `dw_conquer_reply` VALUES ('189', '126', '97', '还有', '1479386176', '0', '1');
INSERT INTO `dw_conquer_reply` VALUES ('190', '126', '98', '的我就', '1479386228', '0', '1');
INSERT INTO `dw_conquer_reply` VALUES ('191', '126', '98', '好的', '1481869364', '0', '1');
INSERT INTO `dw_conquer_reply` VALUES ('192', '126', '97', '好的', '1481869378', '0', '1');

-- ----------------------------
-- Table structure for `dw_department`
-- ----------------------------
DROP TABLE IF EXISTS `dw_department`;
CREATE TABLE `dw_department` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_department
-- ----------------------------
INSERT INTO `dw_department` VALUES ('1', '技术部', '1');
INSERT INTO `dw_department` VALUES ('3', '产品部', '1');
INSERT INTO `dw_department` VALUES ('6', '测试部门', '1');
INSERT INTO `dw_department` VALUES ('7', '生产部门', '1');
INSERT INTO `dw_department` VALUES ('10', '结构部', '1');
INSERT INTO `dw_department` VALUES ('11', '电气部', '1');
INSERT INTO `dw_department` VALUES ('12', '工艺部', '1');

-- ----------------------------
-- Table structure for `dw_excel_mobile`
-- ----------------------------
DROP TABLE IF EXISTS `dw_excel_mobile`;
CREATE TABLE `dw_excel_mobile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(512) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_excel_mobile
-- ----------------------------
INSERT INTO `dw_excel_mobile` VALUES ('24', '13924591660', '1');
INSERT INTO `dw_excel_mobile` VALUES ('23', '15626583449', '1');
INSERT INTO `dw_excel_mobile` VALUES ('22', '15012565998', '1');
INSERT INTO `dw_excel_mobile` VALUES ('21', '13603064292', '1');
INSERT INTO `dw_excel_mobile` VALUES ('20', '18666213011', '1');
INSERT INTO `dw_excel_mobile` VALUES ('19', '13923739056', '1');
INSERT INTO `dw_excel_mobile` VALUES ('17', '18858231949', '1');
INSERT INTO `dw_excel_mobile` VALUES ('25', '15013743170', '1');

-- ----------------------------
-- Table structure for `dw_expert`
-- ----------------------------
DROP TABLE IF EXISTS `dw_expert`;
CREATE TABLE `dw_expert` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) DEFAULT NULL COMMENT '用户名',
  `realname` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `check_mobile` varchar(20) DEFAULT NULL COMMENT '核实电话号码',
  `passwd` varchar(200) DEFAULT NULL COMMENT '密码',
  `headerurl` varchar(120) DEFAULT NULL,
  `depid` int(8) DEFAULT NULL COMMENT '部门id',
  `profession` varchar(80) CHARACTER SET utf8 DEFAULT NULL COMMENT '专业',
  `email` varchar(35) NOT NULL,
  `industry` varchar(80) CHARACTER SET utf8 DEFAULT NULL COMMENT '行业',
  `content` text CHARACTER SET utf8 COMMENT '简介',
  `lastlogin` int(8) DEFAULT NULL COMMENT '最后登录时间',
  `createtime` int(8) DEFAULT NULL COMMENT '创建时间',
  `token` varchar(80) DEFAULT NULL COMMENT 'token',
  `enabled` tinyint(2) DEFAULT '0' COMMENT '帐号状态，0-不可用，1-正常使用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_expert
-- ----------------------------

-- ----------------------------
-- Table structure for `dw_feedback`
-- ----------------------------
DROP TABLE IF EXISTS `dw_feedback`;
CREATE TABLE `dw_feedback` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `createtime` int(4) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for `dw_gongshi`
-- ----------------------------
DROP TABLE IF EXISTS `dw_gongshi`;
CREATE TABLE `dw_gongshi` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `tags` varchar(60) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_gongshi
-- ----------------------------
INSERT INTO `dw_gongshi` VALUES ('7', 'renqi', '1', '1');
INSERT INTO `dw_gongshi` VALUES ('8', 'jisuan', 'g*n*z*t', '1');

-- ----------------------------
-- Table structure for `dw_invite`
-- ----------------------------
DROP TABLE IF EXISTS `dw_invite`;
CREATE TABLE `dw_invite` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `pid` int(8) DEFAULT NULL COMMENT '项目id',
  `headid` int(8) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '被邀请人回复，0-等待，1-同意，2-拒绝',
  `createtime` int(4) DEFAULT NULL COMMENT '创建时间',
  `invite_time` int(4) DEFAULT NULL COMMENT '回复时间',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=616 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_invite
-- ----------------------------
INSERT INTO `dw_invite` VALUES ('548', '553', '120', '0', '1441165513', null, '1');
INSERT INTO `dw_invite` VALUES ('549', '554', '119', '1', '1441504960', '1442380489', '1');
INSERT INTO `dw_invite` VALUES ('550', '555', '119', '1', '1441505310', '1441505782', '1');
INSERT INTO `dw_invite` VALUES ('551', '556', '121', '0', '1441505332', null, '1');
INSERT INTO `dw_invite` VALUES ('552', '557', '121', '0', '1479176942', null, '1');
INSERT INTO `dw_invite` VALUES ('553', '558', '120', '0', '1479285297', null, '1');
INSERT INTO `dw_invite` VALUES ('554', '559', '121', '0', '1479285937', null, '1');
INSERT INTO `dw_invite` VALUES ('555', '560', '124', '2', '1479379252', '1479379415', '1');
INSERT INTO `dw_invite` VALUES ('556', '561', '124', '1', '1479379345', '1479379362', '1');
INSERT INTO `dw_invite` VALUES ('557', '562', '124', '1', '1479384888', '1479384948', '1');
INSERT INTO `dw_invite` VALUES ('558', '563', '123', '1', '1479737441', '1479798607', '1');
INSERT INTO `dw_invite` VALUES ('561', '566', '124', '1', '1479956382', '1479957649', '1');
INSERT INTO `dw_invite` VALUES ('562', '567', '124', '1', '1479956449', '1479956457', '1');
INSERT INTO `dw_invite` VALUES ('563', '568', '124', '1', '1479969249', '1479969255', '1');
INSERT INTO `dw_invite` VALUES ('564', '569', '124', '1', '1479970438', '1479970464', '1');
INSERT INTO `dw_invite` VALUES ('565', '570', '124', '1', '1479970716', '1479970737', '1');
INSERT INTO `dw_invite` VALUES ('566', '571', '119', '0', '1479971019', null, '1');
INSERT INTO `dw_invite` VALUES ('567', '572', '124', '1', '1479978999', '1479979004', '1');
INSERT INTO `dw_invite` VALUES ('568', '573', '123', '1', '1479998585', '1479998592', '1');
INSERT INTO `dw_invite` VALUES ('569', '574', '123', '1', '1479998731', '1479998737', '1');
INSERT INTO `dw_invite` VALUES ('570', '575', '123', '1', '1479999300', '1479999373', '1');
INSERT INTO `dw_invite` VALUES ('571', '576', '124', '1', '1479999562', '1481114531', '1');
INSERT INTO `dw_invite` VALUES ('572', '577', '123', '1', '1479999658', '1480075347', '1');
INSERT INTO `dw_invite` VALUES ('573', '578', '120', '0', '1480299986', null, '1');
INSERT INTO `dw_invite` VALUES ('574', '579', '120', '1', '1480502479', '1480502719', '1');
INSERT INTO `dw_invite` VALUES ('575', '580', '120', '1', '1480503554', '1480503582', '1');
INSERT INTO `dw_invite` VALUES ('576', '581', '21', '0', '1480504842', null, '1');
INSERT INTO `dw_invite` VALUES ('577', '582', '120', '2', '1480504991', '1480505022', '1');
INSERT INTO `dw_invite` VALUES ('578', '583', '120', '1', '1480505136', '1480505152', '1');
INSERT INTO `dw_invite` VALUES ('579', '584', '124', '1', '1480560538', '1480560580', '1');
INSERT INTO `dw_invite` VALUES ('580', '585', '124', '1', '1480562330', '1480562336', '1');
INSERT INTO `dw_invite` VALUES ('581', '586', '124', '1', '1480565229', '1480565269', '1');
INSERT INTO `dw_invite` VALUES ('582', '587', '126', '1', '1480644036', '1480644043', '1');
INSERT INTO `dw_invite` VALUES ('584', '588', '126', '1', '1480644962', '1480644969', '1');
INSERT INTO `dw_invite` VALUES ('585', '589', '126', '1', '1480645718', '1480645755', '1');
INSERT INTO `dw_invite` VALUES ('586', '590', '126', '1', '1480645828', '1480645910', '1');
INSERT INTO `dw_invite` VALUES ('587', '591', '120', '1', '1480658499', '1480658599', '1');
INSERT INTO `dw_invite` VALUES ('589', '593', '124', '1', '1480670992', '1480671024', '1');
INSERT INTO `dw_invite` VALUES ('590', '594', '124', '1', '1480673081', '1480673098', '1');
INSERT INTO `dw_invite` VALUES ('591', '595', '126', '1', '1480900428', '1480900435', '1');
INSERT INTO `dw_invite` VALUES ('592', '596', '126', '1', '1481114766', '1481869155', '1');
INSERT INTO `dw_invite` VALUES ('593', '597', '124', '1', '1481168634', '1481168701', '1');
INSERT INTO `dw_invite` VALUES ('594', '598', '124', '1', '1481177012', '1481177073', '1');
INSERT INTO `dw_invite` VALUES ('595', '599', '124', '1', '1481183850', '1481184247', '1');
INSERT INTO `dw_invite` VALUES ('596', '600', '124', '1', '1481186778', '1481186817', '1');
INSERT INTO `dw_invite` VALUES ('597', '601', '125', '0', '1481199828', null, '1');
INSERT INTO `dw_invite` VALUES ('598', '602', '120', '0', '1481200881', null, '1');
INSERT INTO `dw_invite` VALUES ('599', '603', '123', '1', '1481201236', '1481201242', '1');
INSERT INTO `dw_invite` VALUES ('600', '604', '120', '1', '1481271515', '1481271555', '1');
INSERT INTO `dw_invite` VALUES ('601', '605', '120', '1', '1481271746', '1481271764', '1');
INSERT INTO `dw_invite` VALUES ('603', '607', '120', '1', '1481273233', '1481273249', '1');
INSERT INTO `dw_invite` VALUES ('604', '608', '127', '1', '1481276474', '1481276483', '1');
INSERT INTO `dw_invite` VALUES ('605', '609', '123', '1', '1481278222', '1481278227', '1');
INSERT INTO `dw_invite` VALUES ('606', '610', '123', '1', '1481278620', '1481278625', '1');
INSERT INTO `dw_invite` VALUES ('607', '611', '123', '1', '1481281770', '1481281775', '1');
INSERT INTO `dw_invite` VALUES ('608', '612', '126', '1', '1481869639', '1481869649', '1');
INSERT INTO `dw_invite` VALUES ('609', '613', '124', '1', '1481870006', '1481870045', '1');
INSERT INTO `dw_invite` VALUES ('610', '614', '124', '1', '1481871619', '1481871634', '1');
INSERT INTO `dw_invite` VALUES ('611', '615', '124', '1', '1482112061', '1482112768', '1');
INSERT INTO `dw_invite` VALUES ('612', '616', '124', '1', '1482138955', '1482139108', '1');
INSERT INTO `dw_invite` VALUES ('613', '617', '124', '1', '1482139686', '1482139692', '1');
INSERT INTO `dw_invite` VALUES ('614', '618', '124', '1', '1482150257', '1482469915', '1');
INSERT INTO `dw_invite` VALUES ('615', '619', '126', '1', '1482582404', '1482582502', '1');

-- ----------------------------
-- Table structure for `dw_jobs`
-- ----------------------------
DROP TABLE IF EXISTS `dw_jobs`;
CREATE TABLE `dw_jobs` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_jobs
-- ----------------------------
INSERT INTO `dw_jobs` VALUES ('2', '工程师', '1');
INSERT INTO `dw_jobs` VALUES ('3', '高级工程师', '1');
INSERT INTO `dw_jobs` VALUES ('4', '助理工程师', '1');
INSERT INTO `dw_jobs` VALUES ('5', '专家', '1');
INSERT INTO `dw_jobs` VALUES ('6', '主任工程师', '1');
INSERT INTO `dw_jobs` VALUES ('7', '部门经理', '1');
INSERT INTO `dw_jobs` VALUES ('8', '部门总监', '1');

-- ----------------------------
-- Table structure for `dw_lead`
-- ----------------------------
DROP TABLE IF EXISTS `dw_lead`;
CREATE TABLE `dw_lead` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) DEFAULT NULL COMMENT '用户名',
  `realname` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `check_mobile` varchar(20) DEFAULT NULL COMMENT '核实电话号码',
  `passwd` varchar(200) DEFAULT NULL COMMENT '密码',
  `headerurl` varchar(120) DEFAULT NULL,
  `depid` int(8) DEFAULT NULL COMMENT '部门id',
  `profession` varchar(80) CHARACTER SET utf8 DEFAULT NULL COMMENT '专业',
  `email` varchar(35) NOT NULL,
  `industry` varchar(80) CHARACTER SET utf8 DEFAULT NULL COMMENT '行业',
  `content` text CHARACTER SET utf8 COMMENT '简介',
  `lastlogin` int(8) DEFAULT NULL COMMENT '最后登录时间',
  `createtime` int(8) DEFAULT NULL COMMENT '创建时间',
  `token` varchar(80) DEFAULT NULL COMMENT 'token',
  `enabled` tinyint(2) DEFAULT '0' COMMENT '帐号状态，0-不可用，1-正常使用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_lead
-- ----------------------------

-- ----------------------------
-- Table structure for `dw_member`
-- ----------------------------
DROP TABLE IF EXISTS `dw_member`;
CREATE TABLE `dw_member` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) DEFAULT NULL COMMENT '用户名',
  `realname` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `check_mobile` varchar(20) DEFAULT NULL COMMENT '核实电话号码',
  `passwd` varchar(200) DEFAULT NULL COMMENT '密码',
  `gender` tinyint(1) DEFAULT '0' COMMENT '性别，1-男，0-女',
  `email` varchar(80) DEFAULT NULL COMMENT '邮箱',
  `headerurl` varchar(120) DEFAULT NULL,
  `depid` int(60) DEFAULT '0' COMMENT '部门id',
  `company` varchar(60) CHARACTER SET utf8 DEFAULT NULL COMMENT '单位',
  `position` int(60) DEFAULT '0' COMMENT '职位',
  `profession` varchar(80) CHARACTER SET utf8 DEFAULT NULL COMMENT '专业',
  `industry` varchar(80) CHARACTER SET utf8 DEFAULT NULL COMMENT '行业',
  `intro` text CHARACTER SET utf8 COMMENT '简介',
  `total` int(4) DEFAULT '0' COMMENT '总积分',
  `roleid` int(4) DEFAULT '0' COMMENT '角色，1-员工，2-专家，3-领导',
  `lastlogin` int(8) DEFAULT NULL COMMENT '最后登录时间',
  `createtime` int(8) DEFAULT NULL COMMENT '创建时间',
  `token` varchar(80) DEFAULT NULL COMMENT 'token',
  `enabled` tinyint(2) DEFAULT '1' COMMENT '帐号状态，0-不可用，1-正常使用',
  `sex` int(11) NOT NULL DEFAULT '0',
  `zhiwei` int(5) NOT NULL DEFAULT '0' COMMENT '职位',
  `integraltotal` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '积分总分',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=latin1 COMMENT='会员表';

-- ----------------------------
-- Records of dw_member
-- ----------------------------
INSERT INTO `dw_member` VALUES ('119', '??', '测试', '15324875452', null, 'e10adc3949ba59abbe56e057f20f883e', '0', null, 'default.jpg', '1', '测试', '0', null, null, null, '0', '0', '1479791575', '1479700734', 'd519ee337529cd4148f88a84b331cc07', '1', '0', '0', '3.60', '1');
INSERT INTO `dw_member` VALUES ('120', null, '豆世红', '18666213011', null, 'e10adc3949ba59abbe56e057f20f883e', '0', null, 'h_1441164321.jpg', '1', '咨询顾问', '0', null, null, null, '0', '2', '1482139769', '1441164234', 'eb446fc4007372bc7aceafb7aa4d4f52', '1', '0', '5', '245.86', '1');
INSERT INTO `dw_member` VALUES ('121', null, '杨旭东', '13923739056', null, 'e10adc3949ba59abbe56e057f20f883e', '0', null, 'default.jpg', '1', '德为咨询', '0', null, null, null, '0', '2', '1481278833', '1441164245', '', '1', '0', '5', '8.60', '1');
INSERT INTO `dw_member` VALUES ('123', '0', '美希', '13603064292', null, 'e10adc3949ba59abbe56e057f20f883e', '0', '', 'h_1481168591.jpg', '3', '深圳可以', '0', '', '', '', '0', '1', '1482810581', '1479285375', '82802359e1e5c2f63bfbc5886e1eaba4', '1', '0', '2', '464.23', '1');
INSERT INTO `dw_member` VALUES ('124', '0', '王雷', '15012565998', null, '202cb962ac59075b964b07152d234b70', '0', '', 'h_1481118889.png', '1', '', '0', '', '', '', '0', '1', '1482640587', '1479376468', '1fddb368a4dfabb2cb0bf7fddea6511c', '1', '0', '0', '456.83', '1');
INSERT INTO `dw_member` VALUES ('125', '0', '志敏', '15626583449', null, '202cb962ac59075b964b07152d234b70', '0', '', '20161207212116.png', '1', '德为', '0', '', '', '', '0', '1', '1482640221', '1479378108', '', '1', '0', '6', '453.60', '1');
INSERT INTO `dw_member` VALUES ('126', '0', '姝燕', '13924591660', null, '202cb962ac59075b964b07152d234b70', '0', '', '20161207212203.png', '1', '德为', '0', '', '', '', '0', '1', '1482640288', '1479378281', '', '1', '0', '7', '122.46', '1');
INSERT INTO `dw_member` VALUES ('127', '0', '流川枫', '15013743170', '', 'e10adc3949ba59abbe56e057f20f883e', '0', '', '20161207212647.png', '1', '测试单位', '0', '测试专业', '', '0', '0', '1', '1481881561', '1479781617', '', '1', '0', '2', '720.50', '1');

-- ----------------------------
-- Table structure for `dw_member_ex`
-- ----------------------------
DROP TABLE IF EXISTS `dw_member_ex`;
CREATE TABLE `dw_member_ex` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) NOT NULL,
  `exid` int(8) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0进行中1邀请',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=292 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_member_ex
-- ----------------------------
INSERT INTO `dw_member_ex` VALUES ('291', '124', '120', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('290', '127', '123', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('289', '120', '123', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('288', '120', '124', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('287', '125', '127', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('278', '119', '127', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('285', '127', '120', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('271', '126', '125', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('270', '126', '124', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('286', '125', '120', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('284', '123', '121', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('283', '123', '120', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('266', '122', '120', '1', '1');
INSERT INTO `dw_member_ex` VALUES ('265', '119', '121', '1', '1');

-- ----------------------------
-- Table structure for `dw_member_group`
-- ----------------------------
DROP TABLE IF EXISTS `dw_member_group`;
CREATE TABLE `dw_member_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL COMMENT '用户id',
  `title` varchar(512) NOT NULL COMMENT '组名',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_member_group
-- ----------------------------
INSERT INTO `dw_member_group` VALUES ('81', '124', '啊啊啊', '1481872142', '1');
INSERT INTO `dw_member_group` VALUES ('80', '123', '测试积分港元', '1481275044', '1');
INSERT INTO `dw_member_group` VALUES ('79', '127', '朋友', '1481274976', '1');
INSERT INTO `dw_member_group` VALUES ('78', '123', '测试', '1481274894', '1');
INSERT INTO `dw_member_group` VALUES ('77', '119', '巅峰计划', '1441508290', '1');
INSERT INTO `dw_member_group` VALUES ('76', '121', '后备干部培养', '1441164300', '1');

-- ----------------------------
-- Table structure for `dw_member_group_relation`
-- ----------------------------
DROP TABLE IF EXISTS `dw_member_group_relation`;
CREATE TABLE `dw_member_group_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `createtime` int(11) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=197 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_member_group_relation
-- ----------------------------
INSERT INTO `dw_member_group_relation` VALUES ('196', '81', '123', '1481872147', '1');
INSERT INTO `dw_member_group_relation` VALUES ('195', '81', '121', '1481872147', '1');
INSERT INTO `dw_member_group_relation` VALUES ('194', '81', '120', '1481872147', '1');
INSERT INTO `dw_member_group_relation` VALUES ('193', '81', '119', '1481872147', '1');
INSERT INTO `dw_member_group_relation` VALUES ('192', '80', '127', '1481275050', '1');
INSERT INTO `dw_member_group_relation` VALUES ('191', '80', '126', '1481275050', '1');
INSERT INTO `dw_member_group_relation` VALUES ('190', '80', '125', '1481275050', '1');
INSERT INTO `dw_member_group_relation` VALUES ('189', '80', '121', '1481275050', '1');
INSERT INTO `dw_member_group_relation` VALUES ('188', '80', '120', '1481275050', '1');
INSERT INTO `dw_member_group_relation` VALUES ('187', '80', '119', '1481275050', '1');
INSERT INTO `dw_member_group_relation` VALUES ('186', '79', '120', '1481274997', '1');
INSERT INTO `dw_member_group_relation` VALUES ('185', '79', '127', '1481274997', '1');
INSERT INTO `dw_member_group_relation` VALUES ('184', '79', '126', '1481274988', '1');
INSERT INTO `dw_member_group_relation` VALUES ('183', '78', '124', '1481274912', '1');
INSERT INTO `dw_member_group_relation` VALUES ('182', '77', '121', '1441508303', '1');
INSERT INTO `dw_member_group_relation` VALUES ('181', '77', '119', '1441508303', '1');
INSERT INTO `dw_member_group_relation` VALUES ('180', '76', '121', '1441164308', '1');
INSERT INTO `dw_member_group_relation` VALUES ('179', '76', '120', '1441164308', '1');
INSERT INTO `dw_member_group_relation` VALUES ('178', '76', '119', '1441164308', '1');

-- ----------------------------
-- Table structure for `dw_member_qi`
-- ----------------------------
DROP TABLE IF EXISTS `dw_member_qi`;
CREATE TABLE `dw_member_qi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL,
  `typeid` int(11) NOT NULL COMMENT '1为立项2问题3结果',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_member_qi
-- ----------------------------
INSERT INTO `dw_member_qi` VALUES ('27', '127', '1', '12.00', '1');
INSERT INTO `dw_member_qi` VALUES ('26', '120', '1', '51.00', '1');
INSERT INTO `dw_member_qi` VALUES ('25', '123', '1', '14.00', '1');
INSERT INTO `dw_member_qi` VALUES ('24', '125', '1', '9.00', '1');
INSERT INTO `dw_member_qi` VALUES ('23', '124', '1', '32.00', '1');
INSERT INTO `dw_member_qi` VALUES ('22', '126', '1', '7.00', '1');
INSERT INTO `dw_member_qi` VALUES ('21', '121', '1', '7.00', '1');

-- ----------------------------
-- Table structure for `dw_member_task`
-- ----------------------------
DROP TABLE IF EXISTS `dw_member_task`;
CREATE TABLE `dw_member_task` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `isstatus` int(11) NOT NULL COMMENT '是否查看',
  `mid` int(8) NOT NULL,
  `taskid` int(8) NOT NULL,
  `modid` int(8) NOT NULL,
  `projectid` int(8) NOT NULL,
  `roleid` tinyint(4) NOT NULL,
  `createtime` int(4) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `total` int(4) NOT NULL DEFAULT '0',
  `typeid` int(11) NOT NULL COMMENT '1为重大项目，2为基础项目',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=514 DEFAULT CHARSET=latin1 COMMENT='会员领取任务表';

-- ----------------------------
-- Records of dw_member_task
-- ----------------------------
INSERT INTO `dw_member_task` VALUES ('484', '1', '127', '1079', '10', '603', '1', '1481207937', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('483', '0', '123', '1079', '10', '603', '3', '1481201430', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('482', '1', '125', '1079', '10', '603', '3', '1481201370', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('481', '1', '125', '2', '0', '600', '1', '1481186849', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('480', '1', '123', '1073', '10', '599', '3', '1481186126', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('479', '1', '127', '1073', '10', '599', '3', '1481186067', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('433', '1', '124', '0', '0', '554', '1', '1479376806', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('432', '1', '123', '1025', '16', '555', '3', '1479286122', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('427', '1', '121', '1022', '10', '555', '3', '1441506080', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('426', '1', '119', '1022', '10', '555', '1', '1441506067', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('429', '1', '120', '1022', '10', '555', '2', '1479176847', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('428', '1', '120', '1024', '13', '555', '1', '1441955724', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('443', '1', '123', '0', '0', '563', '1', '1479737461', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('501', '1', '127', '1085', '10', '608', '1', '1481276491', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('431', '1', '123', '1024', '13', '555', '3', '1479286062', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('430', '1', '123', '1022', '10', '555', '3', '1479285990', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('496', '0', '120', '2', '0', '605', '1', '1481273034', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('498', '1', '120', '1081', '10', '604', '3', '1481273105', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('495', '1', '120', '1080', '10', '604', '3', '1481273013', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('497', '1', '123', '1081', '10', '604', '2', '1481273082', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('494', '1', '127', '1080', '10', '604', '3', '1481272971', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('437', '1', '124', '1022', '10', '555', '3', '1479378458', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('436', '1', '126', '2', '0', '554', '3', '1479378304', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('434', '1', '123', '2', '0', '554', '3', '1479376940', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('493', '1', '123', '1080', '10', '604', '2', '1481272951', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('435', '0', '125', '2', '0', '554', '2', '1479378180', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('440', '1', '124', '2', '0', '562', '1', '1479386457', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('439', '1', '125', '1029', '10', '561', '1', '1479384799', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('438', '1', '124', '1024', '13', '555', '2', '1479378961', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('502', '1', '127', '2', '0', '607', '3', '1481276558', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('503', '1', '123', '0', '0', '609', '1', '1481278235', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('500', '1', '123', '2', '0', '607', '3', '1481273279', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('445', '1', '124', '2', '0', '569', '1', '1479971041', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('499', '1', '120', '2', '0', '607', '2', '1481273257', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('442', '1', '123', '1029', '10', '561', '2', '1479712711', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('441', '1', '123', '1028', '13', '561', '3', '1479712651', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('450', '1', '120', '1037', '13', '579', '1', '1480502745', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('444', '1', '124', '2', '0', '567', '1', '1479969975', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('449', '1', '120', '1036', '10', '579', '2', '1480502739', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('448', '1', '127', '2', '0', '572', '3', '1480300088', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('447', '1', '120', '2', '0', '577', '1', '1480080778', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('446', '1', '123', '1035', '10', '575', '1', '1480072578', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('505', '1', '123', '0', '0', '611', '1', '1481281783', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('504', '1', '123', '1087', '10', '610', '1', '1481278638', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('507', '1', '124', '2', '0', '613', '1', '1481870063', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('506', '1', '126', '2', '0', '612', '1', '1481869945', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('456', '1', '123', '2', '0', '580', '1', '1480503637', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('455', '1', '120', '2', '0', '580', '2', '1480503594', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('454', '0', '123', '1038', '14', '579', '1', '1480502990', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('453', '1', '123', '1037', '13', '579', '3', '1480502984', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('452', '1', '123', '1036', '10', '579', '1', '1480502972', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('451', '1', '120', '1038', '14', '579', '3', '1480502756', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('461', '1', '123', '0', '0', '597', '3', '1481176452', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('460', '1', '127', '0', '0', '597', '1', '1481169138', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('459', '1', '124', '2', '0', '595', '1', '1481114489', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('458', '1', '126', '2', '0', '587', '1', '1480644085', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('457', '0', '120', '2', '0', '583', '2', '1480505160', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('463', '1', '127', '2', '0', '595', '2', '1481177420', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('462', '1', '125', '1068', '10', '598', '1', '1481177269', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('465', '0', '127', '2', '0', '587', '3', '1481177669', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('464', '0', '127', '2', '0', '593', '2', '1481177450', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('508', '1', '124', '1091', '10', '614', '2', '1481871652', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('467', '0', '127', '2', '0', '591', '2', '1481178405', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('509', '1', '124', '1093', '10', '615', '1', '1482112810', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('469', '0', '125', '1069', '10', '598', '1', '1481183106', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('468', '1', '125', '2', '0', '597', '3', '1481180825', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('471', '0', '125', '1070', '10', '598', '1', '1481183323', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('466', '1', '127', '1068', '10', '598', '3', '1481177925', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('470', '1', '127', '1069', '10', '598', '2', '1481183116', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('485', '1', '127', '0', '0', '600', '2', '1481208602', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('472', '1', '127', '1070', '10', '598', '2', '1481183349', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('510', '1', '124', '1094', '10', '616', '1', '1482139271', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('511', '1', '124', '2', '0', '617', '1', '1482139701', '0', '0', '2', '1');
INSERT INTO `dw_member_task` VALUES ('512', '1', '124', '1096', '10', '618', '1', '1482469958', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('473', '1', '127', '1071', '10', '599', '1', '1481184287', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('476', '1', '127', '1072', '10', '599', '1', '1481184790', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('475', '1', '123', '1071', '10', '599', '3', '1481184453', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('474', '1', '125', '1071', '10', '599', '2', '1481184378', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('477', '1', '125', '1072', '10', '599', '2', '1481184846', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('478', '1', '125', '1073', '10', '599', '2', '1481185974', '0', '0', '1', '1');
INSERT INTO `dw_member_task` VALUES ('513', '1', '126', '2', '0', '619', '1', '1482582512', '0', '0', '2', '1');

-- ----------------------------
-- Table structure for `dw_messages`
-- ----------------------------
DROP TABLE IF EXISTS `dw_messages`;
CREATE TABLE `dw_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `msg` varchar(512) NOT NULL,
  `createtime` int(11) NOT NULL DEFAULT '0',
  `messagesign` varchar(512) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '是否查看',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=536 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_messages
-- ----------------------------
INSERT INTO `dw_messages` VALUES ('529', '127', '120', '测试一下', '1479790466', '120127no', '1', '1');
INSERT INTO `dw_messages` VALUES ('528', '123', '121', 'we', '1479738640', '121123no', '1', '0');
INSERT INTO `dw_messages` VALUES ('527', '123', '120', '999999', '1479576595', '120123no', '1', '1');
INSERT INTO `dw_messages` VALUES ('526', '123', '121', '6666666', '1479485098', '121123no', '1', '0');
INSERT INTO `dw_messages` VALUES ('525', '123', '124', '啊啊啊啊', '1479376626', '123124no', '1', '1');
INSERT INTO `dw_messages` VALUES ('524', '123', '124', '你好', '1479376558', '123124no', '1', '1');
INSERT INTO `dw_messages` VALUES ('530', '127', '120', '好好过好', '1479791654', '120127no', '1', '1');
INSERT INTO `dw_messages` VALUES ('531', '120', '127', 'hi啊哈', '1479791699', '120127no', '1', '1');
INSERT INTO `dw_messages` VALUES ('532', '120', '127', '这个这个呀！', '1479791718', '120127no', '1', '1');
INSERT INTO `dw_messages` VALUES ('533', '120', '127', '这个可以吗？', '1479793175', '120127no', '1', '1');
INSERT INTO `dw_messages` VALUES ('534', '124', '123', '谢谢', '1479952052', '123124no', '1', '1');
INSERT INTO `dw_messages` VALUES ('535', '125', '127', '但大多数', '1481178307', '125127no', '1', '1');

-- ----------------------------
-- Table structure for `dw_mod`
-- ----------------------------
DROP TABLE IF EXISTS `dw_mod`;
CREATE TABLE `dw_mod` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `m_name` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '模块名称',
  `rank` int(4) DEFAULT '0' COMMENT '排序',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_mod
-- ----------------------------
INSERT INTO `dw_mod` VALUES ('10', '一模块', '1', '1');
INSERT INTO `dw_mod` VALUES ('13', '二模块', '2', '1');
INSERT INTO `dw_mod` VALUES ('14', '三模块', '3', '1');
INSERT INTO `dw_mod` VALUES ('16', '四模块', '4', '1');
INSERT INTO `dw_mod` VALUES ('20', '五模块', '5', '1');

-- ----------------------------
-- Table structure for `dw_opinion`
-- ----------------------------
DROP TABLE IF EXISTS `dw_opinion`;
CREATE TABLE `dw_opinion` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(8) DEFAULT NULL COMMENT '用户id',
  `u_type` tinyint(4) DEFAULT NULL COMMENT '用户类型（专家，员工，领导）',
  `content` text CHARACTER SET utf8 COMMENT '意见内容',
  `createtime` int(4) DEFAULT NULL COMMENT '创建时间',
  `stats` tinyint(2) DEFAULT '0' COMMENT '状态，0-未处理，1-已处理',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_opinion
-- ----------------------------

-- ----------------------------
-- Table structure for `dw_pics`
-- ----------------------------
DROP TABLE IF EXISTS `dw_pics`;
CREATE TABLE `dw_pics` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `typeid` tinyint(3) DEFAULT '0' COMMENT '图片类型，1-重大项目，2-基础项目，3-复盘，4-任务',
  `nandu` int(4) DEFAULT '0' COMMENT '难度',
  `guimo` int(11) NOT NULL DEFAULT '1' COMMENT '规模系数星',
  `picname` varchar(120) DEFAULT NULL COMMENT '图片名称',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1 COMMENT='图片资源表';

-- ----------------------------
-- Records of dw_pics
-- ----------------------------
INSERT INTO `dw_pics` VALUES ('19', '4', '1', '2', '20150506115155.jpg', '1');
INSERT INTO `dw_pics` VALUES ('20', '4', '5', '4', '20150506115211.jpg', '1');
INSERT INTO `dw_pics` VALUES ('21', '4', '2', '5', '20150603102341.jpg', '1');
INSERT INTO `dw_pics` VALUES ('22', '4', '3', '4', '20150603102358.jpg', '1');
INSERT INTO `dw_pics` VALUES ('23', '4', '4', '3', '20150603102413.jpg', '1');
INSERT INTO `dw_pics` VALUES ('24', '4', '2', '4', '20150603103109.jpg', '1');
INSERT INTO `dw_pics` VALUES ('25', '4', '3', '3', '20150603103123.jpg', '1');
INSERT INTO `dw_pics` VALUES ('26', '4', '4', '2', '20150603103136.jpg', '1');
INSERT INTO `dw_pics` VALUES ('27', '4', '3', '3', '20150603103850.jpg', '1');
INSERT INTO `dw_pics` VALUES ('33', '1', '1', '5', '20150804154945.png', '1');
INSERT INTO `dw_pics` VALUES ('34', '1', '2', '5', '20150804155006.png', '1');
INSERT INTO `dw_pics` VALUES ('35', '1', '3', '5', '20150804155024.png', '1');
INSERT INTO `dw_pics` VALUES ('36', '1', '4', '5', '20150804155041.png', '1');
INSERT INTO `dw_pics` VALUES ('37', '1', '5', '5', '20150804155057.png', '1');
INSERT INTO `dw_pics` VALUES ('38', '2', '1', '5', '20150804155113.png', '1');
INSERT INTO `dw_pics` VALUES ('39', '2', '2', '5', '20150804155129.png', '1');
INSERT INTO `dw_pics` VALUES ('40', '2', '3', '5', '20150804155148.png', '1');
INSERT INTO `dw_pics` VALUES ('41', '2', '4', '5', '20150804160121.png', '1');
INSERT INTO `dw_pics` VALUES ('42', '2', '5', '5', '20150804160134.png', '1');
INSERT INTO `dw_pics` VALUES ('43', '1', '1', '4', '20150804160201.png', '1');
INSERT INTO `dw_pics` VALUES ('44', '1', '2', '4', '20150804160216.png', '1');
INSERT INTO `dw_pics` VALUES ('45', '1', '3', '4', '20150804160228.png', '1');
INSERT INTO `dw_pics` VALUES ('46', '1', '4', '4', '20150804160238.png', '1');
INSERT INTO `dw_pics` VALUES ('48', '2', '1', '4', '20150804160300.png', '1');
INSERT INTO `dw_pics` VALUES ('49', '2', '2', '4', '20150804160328.png', '1');
INSERT INTO `dw_pics` VALUES ('50', '2', '3', '4', '20150804160350.png', '1');
INSERT INTO `dw_pics` VALUES ('51', '2', '4', '4', '20150804160400.png', '1');
INSERT INTO `dw_pics` VALUES ('52', '2', '5', '4', '20150804160414.png', '1');
INSERT INTO `dw_pics` VALUES ('53', '1', '1', '3', '20150804160435.png', '1');
INSERT INTO `dw_pics` VALUES ('54', '1', '2', '3', '20150804160446.png', '1');
INSERT INTO `dw_pics` VALUES ('55', '1', '3', '3', '20150804160456.png', '1');
INSERT INTO `dw_pics` VALUES ('56', '1', '4', '3', '20150804160507.png', '1');
INSERT INTO `dw_pics` VALUES ('57', '1', '5', '3', '20150804160522.png', '1');
INSERT INTO `dw_pics` VALUES ('58', '2', '1', '3', '20150804160540.png', '1');
INSERT INTO `dw_pics` VALUES ('59', '2', '2', '3', '20150804160549.png', '1');
INSERT INTO `dw_pics` VALUES ('60', '2', '3', '3', '20150804160600.png', '1');
INSERT INTO `dw_pics` VALUES ('61', '2', '4', '3', '20150804161623.png', '1');
INSERT INTO `dw_pics` VALUES ('62', '2', '5', '3', '20150804161632.png', '1');
INSERT INTO `dw_pics` VALUES ('63', '2', '1', '2', '20150804161642.png', '1');
INSERT INTO `dw_pics` VALUES ('64', '1', '2', '2', '20150804161651.png', '1');
INSERT INTO `dw_pics` VALUES ('65', '1', '3', '2', '20150804161700.png', '1');
INSERT INTO `dw_pics` VALUES ('66', '1', '4', '2', '20150804161715.png', '1');
INSERT INTO `dw_pics` VALUES ('67', '1', '5', '2', '20150804161729.png', '1');
INSERT INTO `dw_pics` VALUES ('68', '2', '1', '2', '20150804161739.png', '1');
INSERT INTO `dw_pics` VALUES ('69', '2', '2', '2', '20150804161746.png', '1');
INSERT INTO `dw_pics` VALUES ('70', '2', '3', '2', '20150804161753.png', '1');
INSERT INTO `dw_pics` VALUES ('71', '2', '4', '2', '20150804161804.png', '1');
INSERT INTO `dw_pics` VALUES ('72', '2', '5', '2', '20150804161813.png', '1');
INSERT INTO `dw_pics` VALUES ('73', '1', '1', '1', '20150804161829.png', '1');
INSERT INTO `dw_pics` VALUES ('74', '1', '2', '1', '20150804161836.png', '1');
INSERT INTO `dw_pics` VALUES ('75', '1', '3', '1', '20150804161845.png', '1');
INSERT INTO `dw_pics` VALUES ('76', '1', '4', '1', '20150804161853.png', '1');
INSERT INTO `dw_pics` VALUES ('77', '1', '5', '1', '20150804161902.png', '1');
INSERT INTO `dw_pics` VALUES ('78', '2', '1', '1', '20150804161911.png', '1');
INSERT INTO `dw_pics` VALUES ('79', '2', '2', '1', '20150804161921.png', '1');
INSERT INTO `dw_pics` VALUES ('80', '2', '3', '1', '20150804161931.png', '1');
INSERT INTO `dw_pics` VALUES ('81', '2', '4', '1', '20150804161940.png', '1');
INSERT INTO `dw_pics` VALUES ('82', '2', '5', '1', '20150804161950.png', '1');
INSERT INTO `dw_pics` VALUES ('83', '4', '4', '5', '20150820104347.jpg', '1');
INSERT INTO `dw_pics` VALUES ('84', '4', '1', '2', '20150820104529.jpg', '1');
INSERT INTO `dw_pics` VALUES ('85', '4', '1', '2', '20150820104613.jpg', '1');
INSERT INTO `dw_pics` VALUES ('86', '4', '1', '1', '20150820104921.jpg', '1');
INSERT INTO `dw_pics` VALUES ('87', '4', '1', '3', '20150820104935.jpg', '1');
INSERT INTO `dw_pics` VALUES ('88', '4', '1', '4', '20150820104950.jpg', '1');
INSERT INTO `dw_pics` VALUES ('89', '4', '1', '5', '20150820105006.jpg', '1');
INSERT INTO `dw_pics` VALUES ('90', '4', '2', '1', '20150820105041.jpg', '1');
INSERT INTO `dw_pics` VALUES ('91', '4', '2', '2', '20150820105106.jpg', '1');
INSERT INTO `dw_pics` VALUES ('92', '4', '2', '3', '20150820105124.jpg', '1');
INSERT INTO `dw_pics` VALUES ('93', '4', '3', '1', '20150820105152.jpg', '1');
INSERT INTO `dw_pics` VALUES ('94', '4', '3', '2', '20150820105205.jpg', '1');
INSERT INTO `dw_pics` VALUES ('95', '4', '3', '5', '20150820105219.jpg', '1');
INSERT INTO `dw_pics` VALUES ('96', '4', '4', '1', '20150820105251.jpg', '1');
INSERT INTO `dw_pics` VALUES ('97', '4', '4', '4', '20150820105305.jpg', '1');
INSERT INTO `dw_pics` VALUES ('98', '4', '5', '1', '20150820105331.jpg', '1');
INSERT INTO `dw_pics` VALUES ('99', '4', '5', '2', '20150820105347.jpg', '1');
INSERT INTO `dw_pics` VALUES ('100', '4', '5', '3', '20150820105402.jpg', '1');
INSERT INTO `dw_pics` VALUES ('101', '4', '5', '5', '20150820105415.jpg', '1');
INSERT INTO `dw_pics` VALUES ('102', '1', '4', '5', '20161208205532.png', '1');
INSERT INTO `dw_pics` VALUES ('103', '1', '5', '4', '20161208205727.png', '1');

-- ----------------------------
-- Table structure for `dw_project`
-- ----------------------------
DROP TABLE IF EXISTS `dw_project`;
CREATE TABLE `dw_project` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) DEFAULT NULL COMMENT '创建人id',
  `modid` int(8) DEFAULT NULL COMMENT '模块id',
  `headid` int(8) DEFAULT NULL COMMENT '负责人id',
  `typeid` tinyint(2) DEFAULT '0' COMMENT '项目类型，1-重大项目，2-基础项目',
  `scale` int(4) DEFAULT '0' COMMENT '规模',
  `difficulty` int(4) DEFAULT '0' COMMENT '难度',
  `quality` int(4) DEFAULT '0' COMMENT '质量',
  `features` int(4) DEFAULT '0' COMMENT '特性',
  `review` tinyint(2) DEFAULT '0' COMMENT '审核状态，0-待审核，1-已经审核，2-已评审',
  `title` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '项目标题',
  `intro` text CHARACTER SET utf8 COMMENT '项目描述',
  `icon` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `createtime` int(4) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '项目状态,0-关闭，1-创建中，2-进行中，3,-结束',
  `rank` int(4) DEFAULT '0' COMMENT '排序',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=620 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_project
-- ----------------------------
INSERT INTO `dw_project` VALUES ('553', '120', null, '120', '1', '5', '4', '4', '5', '0', '测试项目', '把所有问题都要测试一遍', null, '1441165513', '1', '0', '1');
INSERT INTO `dw_project` VALUES ('554', '119', null, '119', '2', '4', '4', '5', '3', '0', '阳光计划', '应届生培训', null, '1441504960', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('555', '119', null, '119', '1', '2', '4', '4', '3', '0', '巅峰计划', '领导力', null, '1441505310', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('556', '121', null, '121', '1', '4', '3', '3', '3', '0', 'vbnm', '东莞呵呵', null, '1441505332', '1', '0', '1');
INSERT INTO `dw_project` VALUES ('557', '120', null, '121', '1', '4', '4', '5', '5', '0', '第一项目', '图图他', null, '1479176942', '1', '0', '1');
INSERT INTO `dw_project` VALUES ('558', '122', null, '120', '1', '5', '5', '5', '4', '0', '估计', '突然', null, '1479285297', '1', '0', '1');
INSERT INTO `dw_project` VALUES ('559', '123', null, '121', '1', '5', '5', '5', '4', '0', '啦啦啦啦', '解决了', null, '1479285937', '1', '0', '1');
INSERT INTO `dw_project` VALUES ('560', '126', null, '124', '2', '4', '4', '3', '3', '0', '擦擦', '我拿考虑考虑', null, '1479379252', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('561', '124', null, '124', '1', '5', '4', '2', '4', '0', '测试项目', '摸摸得得哦啦啦', null, '1479379345', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('562', '125', null, '124', '2', '3', '5', '4', '4', '0', '测试3333', '测试', null, '1479384888', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('563', '123', null, '123', '2', '5', '5', '5', '5', '0', 'as', 'qqqq', null, '1479737441', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('566', '123', null, '124', '1', '5', '3', '3', '4', '0', '测试删除', '同学', null, '1479956382', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('567', '124', null, '124', '2', '4', '3', '4', '4', '0', '印天科技', '战略解码', null, '1479956449', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('568', '124', null, '124', '2', '4', '3', '4', '3', '0', '评审测试', '评审测试', null, '1479969249', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('569', '124', null, '124', '2', '5', '4', '4', '4', '0', '解决了', '解决了', null, '1479970438', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('570', '124', null, '124', '1', '4', '3', '3', '4', '0', '重大项目评审', '重大评审', null, '1479970716', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('571', '124', null, '119', '2', '5', '4', '3', '4', '0', '啦啦啦啦', '兔兔', null, '1479971019', '1', '0', '1');
INSERT INTO `dw_project` VALUES ('572', '124', null, '124', '2', '4', '3', '4', '4', '0', '基础评审', '基础', null, '1479978999', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('573', '123', null, '123', '1', '5', '3', '3', '3', '0', '这是一个iOS版本重大项目创建测试', '测试用', null, '1479998585', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('574', '123', null, '123', '1', '5', '3', '3', '5', '0', '继续创建重大项目发起评审', 'vvg', null, '1479998731', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('575', '124', null, '123', '1', '5', '2', '3', '5', '0', '王雷iOS创建重大项目用于评审', '给哈哈哈', null, '1479999300', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('576', '124', null, '124', '2', '4', '3', '4', '4', '0', '王雷创建一个基础项目进行评审', '哥哥哥哥', null, '1479999562', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('577', '124', null, '123', '2', '5', '4', '3', '5', '0', '创建一个基础项目咽喉负责', '搞活经济', null, '1479999658', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('578', '127', null, '120', '2', '3', '3', '5', '4', '0', '测试基础芳', '测试一下了就是滴呀', null, '1480299986', '1', '0', '1');
INSERT INTO `dw_project` VALUES ('579', '127', null, '120', '1', '3', '4', '2', '4', '0', '哈哈哈哈', '嘻嘻', null, '1480502479', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('580', '127', null, '120', '2', '2', '4', '1', '3', '0', '考虑考虑基础', '吃好喝好', null, '1480503554', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('582', '127', null, '120', '2', '2', '4', '2', '4', '0', '改改二基础', '抹灰工好', null, '1480504991', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('583', '127', null, '120', '2', '2', '5', '2', '2', '0', '哈哈哈基础', '纠结了龙膜', null, '1480505136', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('584', '123', null, '124', '2', '4', '2', '4', '2', '0', '基础项目测试评审1201', '测试评审用咽喉创建', null, '1480560538', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('585', '123', null, '124', '2', '3', '3', '4', '5', '0', '基础项目测试评审02', '测试评审用哦', null, '1480562330', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('586', '123', null, '124', '2', '4', '2', '3', '4', '0', '用于测试基础项目评审显示星星', 'vhhh', null, '1480565229', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('587', '126', null, '126', '2', '4', '3', '4', '4', '0', '基础项目测试', '测试评审', null, '1480644036', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('588', '126', null, '126', '1', '4', '5', '5', '4', '0', '重大项目测试1', '测试评审', null, '1480644809', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('589', '126', null, '126', '1', '4', '4', '3', '4', '0', '重大项目测试2', '测试2', null, '1480645718', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('590', '126', null, '126', '1', '4', '4', '4', '4', '0', '重大3', '3', null, '1480645828', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('591', '127', null, '120', '2', '3', '5', '3', '4', '0', '哈哈测试', '昵昵红', null, '1480658499', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('593', '123', null, '124', '2', '5', '5', '3', '3', '0', '基础项目创建评审测试', 'vbh', null, '1480670992', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('594', '124', null, '124', '1', '5', '3', '3', '5', '0', '我没看见', '咯莫', null, '1480673081', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('595', '126', null, '126', '2', '4', '3', '4', '4', '0', '基础测试1', '测试', null, '1480900428', '0', '0', '1');
INSERT INTO `dw_project` VALUES ('596', '124', null, '126', '1', '4', '3', '4', '4', '0', '重大测试5', '5', null, '1481114766', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('597', '123', null, '124', '2', '3', '4', '4', '2', '0', '创建一个基础项目001', '123456', null, '1481168634', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('598', '123', null, '124', '1', '4', '5', '5', '2', '0', '创建一个重大项目', '不回家', null, '1481177012', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('599', '126', null, '124', '1', '3', '5', '5', '0', '0', '姝燕创建一个重大项目', '这是为了测试分数，当有人选取了独立时，别人则不能选取其他', null, '1481183850', '0', '0', '1');
INSERT INTO `dw_project` VALUES ('600', '126', null, '124', '2', '4', '3', '5', '5', '0', '书燕创建一个基础项目', '还斤斤计较', null, '1481186778', '0', '0', '1');
INSERT INTO `dw_project` VALUES ('601', '123', null, '125', '1', '5', '4', '5', '5', '0', 'we', 'qwert', null, '1481199828', '1', '0', '1');
INSERT INTO `dw_project` VALUES ('602', '125', null, '120', '1', '5', '5', '5', '5', '0', '1', '1', null, '1481200881', '1', '0', '1');
INSERT INTO `dw_project` VALUES ('603', '123', null, '123', '1', '4', '5', '5', '2', '0', '刘磊看这里哦', '很纠结', null, '1481201236', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('604', '127', null, '120', '1', '2', '4', '2', '3', '0', '1209重大', '考虑考虑', null, '1481271515', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('605', '127', null, '120', '2', '2', '4', '3', '2', '0', '1209基础', '咯摸摸墨迹了', null, '1481271746', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('607', '127', null, '120', '2', '2', '3', '4', '4', '0', '1209222基础', '哦可口可乐了', null, '1481273233', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('608', '127', null, '127', '1', '5', '5', '4', '5', '0', '空间看看咯1209', '咯莫', null, '1481276474', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('609', '123', null, '123', '2', '1', '1', '1', '1', '0', '黑胡椒', '很纠结', null, '1481278222', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('610', '123', null, '123', '1', '2', '3', '3', '2', '0', '就一个任务', '就一个任务', null, '1481278620', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('611', '123', null, '123', '2', '2', '4', '3', '3', '0', '高规格', '规划好', null, '1481281770', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('612', '126', null, '126', '2', '4', '3', '4', '4', '0', '基础项目领取测试', '测试', null, '1481869639', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('613', '126', null, '124', '2', '4', '3', '4', '4', '0', '基础项目领取测试2', '测试2', null, '1481870006', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('614', '124', null, '124', '1', '3', '4', '3', '4', '0', '重大项目领取测试', '测试', null, '1481871619', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('615', '124', null, '124', '1', '2', '3', '3', '4', '0', '王雷iOS创建一个重大项目', 'vgg', null, '1482112061', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('616', '124', null, '124', '1', '2', '4', '3', '3', '0', '安卓上传一个重大项目王雷创建', '考虑考虑', null, '1482138955', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('617', '124', null, '124', '2', '4', '4', '4', '2', '0', '创建基础项目', '兔兔', null, '1482139686', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('618', '124', null, '124', '1', '3', '4', '4', '4', '0', '哈哈哈哈', '京津冀', null, '1482150257', '2', '0', '1');
INSERT INTO `dw_project` VALUES ('619', '124', null, '126', '2', '3', '4', '3', '4', '0', '基础项目测试2', '测试2', null, '1482582404', '2', '0', '1');

-- ----------------------------
-- Table structure for `dw_project_total`
-- ----------------------------
DROP TABLE IF EXISTS `dw_project_total`;
CREATE TABLE `dw_project_total` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proid` int(11) NOT NULL DEFAULT '0',
  `proname` varchar(512) NOT NULL,
  `realname` varchar(512) NOT NULL,
  `rolename` varchar(512) NOT NULL,
  `modtitle` varchar(512) NOT NULL,
  `taskname` varchar(512) NOT NULL,
  `difficulty` int(11) NOT NULL COMMENT '难度',
  `quality` int(11) NOT NULL COMMENT '质量',
  `features` int(11) NOT NULL COMMENT '特性',
  `scale` int(11) NOT NULL COMMENT '规模',
  `taskgrand` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lingname` text NOT NULL,
  `linggrand` text NOT NULL,
  `gdifficulty` int(11) NOT NULL COMMENT '难度',
  `gquality` int(11) NOT NULL COMMENT '质量',
  `gfeatures` int(11) NOT NULL COMMENT '特性',
  `gscale` int(11) NOT NULL COMMENT '规模',
  `gtaskgrand` decimal(10,2) NOT NULL DEFAULT '0.00',
  `glingname` text NOT NULL,
  `glinggrand` text NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=165 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_project_total
-- ----------------------------
INSERT INTO `dw_project_total` VALUES ('159', '563', 'as', '喉咙', '员工', '', '', '5', '5', '5', '5', '187.50', '喉咙', '187.5', '5', '5', '5', '5', '187.50', '喉咙', '187.5', '1');
INSERT INTO `dw_project_total` VALUES ('160', '600', '书燕创建一个基础项目', '王雷', '员工', '', '', '3', '5', '5', '4', '66.00', '志敏,流川枫', '66,66', '3', '5', '5', '4', '66.00', '志敏,流川枫', '66,66', '1');
INSERT INTO `dw_project_total` VALUES ('161', '599', '姝燕创建一个重大项目', '王雷', '员工', '一模块', '创建核心参与', '2', '3', '5', '4', '30.00', '美希,流川枫,志敏', '6,6,18', '2', '3', '5', '4', '30.00', '美希,流川枫,志敏', '6,6,18', '1');
INSERT INTO `dw_project_total` VALUES ('162', '599', '姝燕创建一个重大项目', '王雷', '员工', '一模块', '创建一个苹果优酷', '5', '3', '3', '4', '44.00', '流川枫,志敏', '44,44', '5', '3', '3', '4', '44.00', '流川枫,志敏', '44,44', '1');
INSERT INTO `dw_project_total` VALUES ('163', '599', '姝燕创建一个重大项目', '王雷', '员工', '一模块', '任务A', '2', '4', '5', '4', '36.00', '流川枫,美希,志敏', '36,9,27', '2', '4', '5', '4', '36.00', '流川枫,美希,志敏', '36,9,27', '1');
INSERT INTO `dw_project_total` VALUES ('164', '595', '基础测试1', '姝燕', '员工', '', '', '3', '4', '4', '4', '35.90', '王雷,流川枫', '35.904,35.904', '3', '4', '4', '4', '35.90', '王雷,流川枫', '35.904,35.904', '1');

-- ----------------------------
-- Table structure for `dw_project_type`
-- ----------------------------
DROP TABLE IF EXISTS `dw_project_type`;
CREATE TABLE `dw_project_type` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_project_type
-- ----------------------------
INSERT INTO `dw_project_type` VALUES ('1', '开放型', '1');
INSERT INTO `dw_project_type` VALUES ('2', '内部型', '1');

-- ----------------------------
-- Table structure for `dw_question`
-- ----------------------------
DROP TABLE IF EXISTS `dw_question`;
CREATE TABLE `dw_question` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) DEFAULT NULL COMMENT '用户id',
  `content` text CHARACTER SET utf8 COMMENT '问题内容',
  `createtime` int(4) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_question
-- ----------------------------

-- ----------------------------
-- Table structure for `dw_question_reply`
-- ----------------------------
DROP TABLE IF EXISTS `dw_question_reply`;
CREATE TABLE `dw_question_reply` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `exid` int(8) DEFAULT NULL COMMENT '专家id',
  `qid` int(11) DEFAULT NULL COMMENT '问题表id',
  `content` text CHARACTER SET utf8 COMMENT '回复内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_question_reply
-- ----------------------------

-- ----------------------------
-- Table structure for `dw_replay`
-- ----------------------------
DROP TABLE IF EXISTS `dw_replay`;
CREATE TABLE `dw_replay` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `types` varchar(80) DEFAULT NULL,
  `rank` int(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='复盘表';

-- ----------------------------
-- Records of dw_replay
-- ----------------------------

-- ----------------------------
-- Table structure for `dw_replay_type`
-- ----------------------------
DROP TABLE IF EXISTS `dw_replay_type`;
CREATE TABLE `dw_replay_type` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `rank` int(4) DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_replay_type
-- ----------------------------
INSERT INTO `dw_replay_type` VALUES ('1', '需求与规格分析', '1', '1');
INSERT INTO `dw_replay_type` VALUES ('2', '概要设计', '2', '1');
INSERT INTO `dw_replay_type` VALUES ('3', '详细设计', '3', '1');
INSERT INTO `dw_replay_type` VALUES ('4', '测试', '4', '1');
INSERT INTO `dw_replay_type` VALUES ('6', '转产', '5', '1');

-- ----------------------------
-- Table structure for `dw_review`
-- ----------------------------
DROP TABLE IF EXISTS `dw_review`;
CREATE TABLE `dw_review` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) DEFAULT NULL,
  `proid` int(8) DEFAULT NULL,
  `modid` int(8) DEFAULT NULL,
  `intro` text CHARACTER SET utf8,
  `endtime` int(4) DEFAULT NULL,
  `createtime` int(4) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态,0-关闭，1-进行中，2-延时，3,-结束',
  `praise` int(11) NOT NULL DEFAULT '0' COMMENT '点赞值',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_review
-- ----------------------------
INSERT INTO `dw_review` VALUES ('189', '119', '555', '10', '无', '1441814400', '1441508033', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('190', '124', '555', '13', '额额', '1479381020', '1479380708', '3', '3', '1');
INSERT INTO `dw_review` VALUES ('191', '126', '554', '10', '来来来', '1479312000', '1479384070', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('192', '124', '561', '10', '额额', '1479384388', '1479384369', '3', '3', '1');
INSERT INTO `dw_review` VALUES ('193', '124', '562', '10', '测试？？？？', '1479312000', '1479385028', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('194', '123', '561', '13', 'eee', '1479969629', '1479738559', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('195', '124', '567', '10', '评审', '1479916800', '1479956538', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('196', '123', '567', '13', '弄', '1479916800', '1479969268', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('197', '123', '566', '13', '通过了', '1479916800', '1479969762', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('198', '124', '555', '16', '解决了', '1479970115', '1479970067', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('199', '124', '569', '10', '兔兔', '1479916800', '1479970579', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('200', '124', '570', '10', '评审', '1479970786', '1479970767', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('201', '123', '573', '10', '我们来评审一下这个模块吧', '1479998660', '1479998634', '3', '1', '1');
INSERT INTO `dw_review` VALUES ('202', '123', '574', '10', 'vbbb', '0', '1479998757', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('203', '123', '575', '10', '给哈哈哈', '1480512356', '1479999408', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('204', '123', '572', '10', 'bbj', '0', '1479999797', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('205', '127', '577', '10', '测试', '1480348800', '1480080573', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('206', '120', '575', '13', '测试器芳', '1480348800', '1480080903', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('207', '127', '572', '0', '测试赛基础评审', '1480435200', '1480299811', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('208', '127', '575', '14', 'haha', '1480694400', '1480472895', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('209', '123', '554', '0', '66666666666', '1483027200', '1480474103', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('210', '123', '577', '0', '', '1480435200', '1480497367', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('211', '127', '579', '10', '紧急集合', '1480694400', '1480503098', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('212', '127', '583', '0', '紧急集合回家了', '1480559645', '1480559540', '3', '2', '1');
INSERT INTO `dw_review` VALUES ('213', '124', '585', '0', '默默咯', '1480562509', '1480562385', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('214', '123', '584', '0', '666666666', '1480564557', '1480563428', '3', '1', '1');
INSERT INTO `dw_review` VALUES ('215', '127', '579', '0', '可口可乐了', '1480521600', '1480568355', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('216', '123', '561', '0', 'rr', '0', '1480596427', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('217', '126', '588', '10', '3333', '1480645148', '1480645128', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('218', '126', '590', '10', '测试', '1480645960', '1480645936', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('219', '120', '591', '0', '柠檬', '1480659437', '1480659382', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('220', '120', '589', '0', '哦你问问', '1480608000', '1480659485', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('223', '124', '593', '0', '监控', '1480671132', '1480671057', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('225', '124', '594', '10', '弄', '1480673184', '1480673120', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('226', '126', '595', '0', '测试', '1480900509', '1480900485', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('227', '124', '587', '0', '规划好', '0', '1481114442', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('228', '120', '600', '0', '幸福的', '1481188855', '1481188730', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('229', '120', '599', '10', '非公有', '1481188965', '1481188927', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('230', '123', '610', '10', 'dd', '0', '1481282317', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('231', '124', '613', '0', '测试', '1481817600', '1481871730', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('232', '124', '614', '10', '哈哈哈', '1481872897', '1481872871', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('233', '126', '612', '10', '测试', '1481817600', '1481873280', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('234', '124', '612', '0', 'high', '1482582616', '1481882731', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('235', '124', '607', '0', 'hi', '1481882781', '1481882769', '3', '1', '1');
INSERT INTO `dw_review` VALUES ('236', '124', '616', '10', '吐了', '1482139621', '1482139474', '3', '1', '1');
INSERT INTO `dw_review` VALUES ('237', '120', '617', '0', '兔兔', '1482076800', '1482139912', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('238', '120', '605', '0', '吐了', '1482139952', '1482139940', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('239', '120', '616', '13', '看见了', '1482076800', '1482139981', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('240', '124', '618', '10', '评审', '1482508800', '1482582463', '1', '0', '1');
INSERT INTO `dw_review` VALUES ('241', '125', '619', '0', '评审2', '1482635786', '1482635764', '3', '0', '1');
INSERT INTO `dw_review` VALUES ('242', '123', '615', '0', '', '1482768000', '1482810623', '1', '0', '1');

-- ----------------------------
-- Table structure for `dw_review_praise`
-- ----------------------------
DROP TABLE IF EXISTS `dw_review_praise`;
CREATE TABLE `dw_review_praise` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `revid` int(8) DEFAULT NULL,
  `mid` int(8) DEFAULT NULL,
  `grade` int(2) DEFAULT '0',
  `createtime` int(4) DEFAULT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='评选人员';

-- ----------------------------
-- Records of dw_review_praise
-- ----------------------------
INSERT INTO `dw_review_praise` VALUES ('1', '190', '124', '0', '1479381036', '1');
INSERT INTO `dw_review_praise` VALUES ('2', '190', '126', '0', '1479384033', '1');
INSERT INTO `dw_review_praise` VALUES ('3', '192', '124', '0', '1479384745', '1');
INSERT INTO `dw_review_praise` VALUES ('4', '192', '126', '0', '1479385498', '1');
INSERT INTO `dw_review_praise` VALUES ('5', '192', '125', '0', '1479700788', '1');
INSERT INTO `dw_review_praise` VALUES ('6', '190', '125', '0', '1479700792', '1');
INSERT INTO `dw_review_praise` VALUES ('7', '212', '127', '0', '1480559714', '1');
INSERT INTO `dw_review_praise` VALUES ('8', '212', '120', '0', '1480559767', '1');
INSERT INTO `dw_review_praise` VALUES ('9', '214', '123', '0', '1480564631', '1');
INSERT INTO `dw_review_praise` VALUES ('10', '201', '124', '0', '1481869780', '1');
INSERT INTO `dw_review_praise` VALUES ('11', '235', '124', '0', '1482111496', '1');
INSERT INTO `dw_review_praise` VALUES ('12', '236', '124', '0', '1482139641', '1');

-- ----------------------------
-- Table structure for `dw_review_question`
-- ----------------------------
DROP TABLE IF EXISTS `dw_review_question`;
CREATE TABLE `dw_review_question` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `revid` int(8) DEFAULT NULL COMMENT '项目id',
  `revtitle` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `revintro` text CHARACTER SET utf8,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  `modid` int(11) NOT NULL COMMENT '模块id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=latin1 COMMENT='评审题目';

-- ----------------------------
-- Records of dw_review_question
-- ----------------------------
INSERT INTO `dw_review_question` VALUES ('168', '0', '成本符合度评审', '与设定的目标成本比较', '1', '10');
INSERT INTO `dw_review_question` VALUES ('170', '0', '质量达标度评审', '与设定的质量目标进行比较', '1', '10');
INSERT INTO `dw_review_question` VALUES ('172', '0', '成本符合度评审', '与设定的目标成本进行比较', '1', '13');
INSERT INTO `dw_review_question` VALUES ('178', '0', '成本符合度评审', '与设定的目标成本进行比较', '1', '14');
INSERT INTO `dw_review_question` VALUES ('179', '0', '质量达标度评审', '与设定的质量目标进行比较', '1', '13');
INSERT INTO `dw_review_question` VALUES ('180', '0', '需求满足度评审', '实现的需求与设定的需求目标进行比较', '1', '13');
INSERT INTO `dw_review_question` VALUES ('182', '0', '需求满足度评审', '实现的需求与设定的需求目标进行比较', '1', '10');
INSERT INTO `dw_review_question` VALUES ('183', '0', '质量达标度评审', '与设定的质量目标进行比较', '1', '14');
INSERT INTO `dw_review_question` VALUES ('184', '0', '需求满足度评审', '需求实现程度与设定的需求目标进行比较', '1', '14');
INSERT INTO `dw_review_question` VALUES ('185', '0', '成本符合度评审', '与设定的目标成本进行比较', '1', '16');
INSERT INTO `dw_review_question` VALUES ('186', '0', '质量达标度评审', '与设定的质量目标进行比较', '1', '16');
INSERT INTO `dw_review_question` VALUES ('187', '0', '需求满足度评审', '需求实现程度与设定的需求目标进行比较', '1', '16');
INSERT INTO `dw_review_question` VALUES ('188', '0', '成本符合度评审', '与设定的目标成本进行比较', '1', '20');
INSERT INTO `dw_review_question` VALUES ('189', '0', '质量达标度评审', '与设定的质量目标进行比较', '1', '20');
INSERT INTO `dw_review_question` VALUES ('190', '0', '需求满足度评审', '需求实现程度与设定的需求目标进行比较', '1', '20');
INSERT INTO `dw_review_question` VALUES ('191', '0', '成本符合度评审', '与设定的目标成本进行比较', '1', '24');
INSERT INTO `dw_review_question` VALUES ('192', '0', '质量达标度评审', '与设定的质量目标进行比较', '1', '24');
INSERT INTO `dw_review_question` VALUES ('193', '0', '需求满足度评审', '需求实现程度与设定的需求目标进行比较', '1', '24');
INSERT INTO `dw_review_question` VALUES ('194', '0', '成本符合度评审', '与设定的质量目标进行比较', '1', '25');
INSERT INTO `dw_review_question` VALUES ('195', '0', '质量达标度评审', '与设定的质量目标进行比较', '1', '25');
INSERT INTO `dw_review_question` VALUES ('196', '0', '需求满足度评审', '需求实现程度与设定的需求目标进行比较', '1', '25');
INSERT INTO `dw_review_question` VALUES ('197', '0', '质量', '质量', '1', '0');

-- ----------------------------
-- Table structure for `dw_review_question_feedback`
-- ----------------------------
DROP TABLE IF EXISTS `dw_review_question_feedback`;
CREATE TABLE `dw_review_question_feedback` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `revid` int(8) DEFAULT NULL COMMENT '审批项目id，对应dw_review的id',
  `questionid` int(8) DEFAULT NULL COMMENT '审批问题id',
  `mid` int(8) DEFAULT NULL COMMENT '审批用户id',
  `grade` int(4) DEFAULT '0' COMMENT '审批分数',
  `createtime` int(4) DEFAULT NULL,
  `modid` int(11) NOT NULL COMMENT '模块id',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1 COMMENT='用户审批结果表';

-- ----------------------------
-- Records of dw_review_question_feedback
-- ----------------------------
INSERT INTO `dw_review_question_feedback` VALUES ('1', '191', '168', '126', '3', '1479384088', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('2', '191', '170', '126', '3', '1479384088', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('3', '191', '182', '126', '3', '1479384088', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('4', '191', '168', '124', '3', '1479384538', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('5', '191', '170', '124', '4', '1479384538', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('6', '191', '182', '124', '4', '1479384538', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('7', '191', '168', '125', '5', '1479384686', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('8', '191', '170', '125', '5', '1479384686', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('9', '191', '182', '125', '5', '1479384686', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('10', '193', '168', '126', '4', '1479385106', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('11', '193', '170', '126', '4', '1479385106', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('12', '193', '182', '126', '4', '1479385106', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('13', '195', '168', '124', '4', '1479956558', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('14', '195', '170', '124', '4', '1479956558', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('15', '195', '182', '124', '4', '1479956559', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('16', '197', '172', '124', '4', '1479969781', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('17', '197', '179', '124', '3', '1479969781', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('18', '197', '180', '124', '4', '1479969781', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('19', '198', '185', '124', '4', '1479970108', '16', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('20', '198', '186', '124', '4', '1479970108', '16', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('21', '198', '187', '124', '4', '1479970108', '16', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('22', '198', '185', '123', '4', '1479970154', '16', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('23', '198', '186', '123', '4', '1479970154', '16', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('24', '198', '187', '123', '4', '1479970154', '16', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('25', '199', '168', '124', '5', '1479970591', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('26', '199', '170', '124', '4', '1479970591', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('27', '199', '182', '124', '4', '1479970591', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('28', '200', '168', '124', '4', '1479970783', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('29', '200', '170', '124', '4', '1479970783', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('30', '200', '182', '124', '4', '1479970783', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('31', '204', '168', '123', '5', '1480074138', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('32', '204', '170', '123', '5', '1480074138', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('33', '204', '182', '123', '5', '1480074138', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('34', '203', '168', '123', '5', '1480074200', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('35', '203', '170', '123', '5', '1480074200', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('36', '203', '182', '123', '5', '1480074200', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('37', '205', '168', '120', '3', '1480080742', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('38', '205', '170', '120', '4', '1480080742', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('39', '205', '182', '120', '4', '1480080742', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('40', '206', '172', '127', '3', '1480476275', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('41', '206', '179', '127', '3', '1480476275', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('42', '206', '180', '127', '5', '1480476275', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('43', '207', '197', '120', '3', '1480499302', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('47', '208', '178', '120', '3', '1480501833', '14', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('48', '208', '183', '120', '2', '1480501833', '14', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('49', '208', '184', '120', '4', '1480501833', '14', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('50', '209', '197', '123', '5', '1480510650', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('51', '212', '197', '120', '3', '1480559589', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('52', '209', '197', '120', '2', '1480559786', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('53', '213', '197', '123', '4', '1480562401', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('54', '213', '197', '120', '5', '1480562442', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('55', '213', '197', '121', '5', '1480562466', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('56', '214', '197', '123', '4', '1480564554', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('57', '217', '168', '126', '4', '1480645139', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('58', '217', '170', '126', '3', '1480645139', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('59', '217', '182', '126', '4', '1480645139', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('60', '211', '168', '120', '3', '1480658654', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('61', '211', '170', '120', '3', '1480658654', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('62', '211', '182', '120', '4', '1480658654', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('63', '219', '197', '127', '2', '1480659405', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('64', '222', '172', '120', '2', '1480660180', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('65', '222', '179', '120', '3', '1480660180', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('66', '222', '180', '120', '4', '1480660180', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('67', '221', '168', '120', '5', '1480660198', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('68', '221', '170', '120', '5', '1480660198', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('69', '221', '182', '120', '5', '1480660198', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('70', '223', '197', '123', '4', '1480671074', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('71', '225', '168', '123', '3', '1480673142', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('72', '225', '170', '123', '4', '1480673142', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('73', '225', '182', '123', '4', '1480673143', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('74', '226', '197', '126', '3', '1480900513', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('75', '210', '197', '124', '3', '1480903903', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('76', '228', '197', '124', '4', '1481188790', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('77', '229', '168', '120', '4', '1481188958', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('78', '229', '170', '120', '5', '1481188958', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('79', '229', '182', '120', '4', '1481188958', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('80', '227', '197', '123', '3', '1481277588', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('81', '232', '168', '124', '2', '1481872890', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('82', '232', '170', '124', '3', '1481872890', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('83', '232', '182', '124', '4', '1481872890', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('84', '234', '197', '124', '3', '1481882742', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('85', '235', '197', '124', '2', '1481882778', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('86', '236', '168', '120', '3', '1482139528', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('87', '236', '170', '120', '4', '1482139528', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('88', '236', '182', '120', '2', '1482139528', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('89', '238', '197', '120', '4', '1482139945', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('90', '239', '172', '120', '4', '1482140000', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('91', '239', '179', '120', '3', '1482140000', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('92', '239', '180', '120', '4', '1482140000', '13', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('93', '237', '197', '124', '4', '1482462437', '0', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('94', '240', '168', '126', '4', '1482582539', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('95', '240', '170', '126', '4', '1482582539', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('96', '240', '182', '126', '3', '1482582539', '10', '1');
INSERT INTO `dw_review_question_feedback` VALUES ('97', '241', '197', '125', '3', '1482635782', '0', '1');

-- ----------------------------
-- Table structure for `dw_review_staff`
-- ----------------------------
DROP TABLE IF EXISTS `dw_review_staff`;
CREATE TABLE `dw_review_staff` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `revid` int(8) DEFAULT NULL,
  `mid` int(8) DEFAULT NULL,
  `grade` int(2) DEFAULT '0',
  `createtime` int(4) DEFAULT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  `isstatus` int(11) NOT NULL DEFAULT '0' COMMENT '是否查看',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=535 DEFAULT CHARSET=latin1 COMMENT='评选人员';

-- ----------------------------
-- Records of dw_review_staff
-- ----------------------------
INSERT INTO `dw_review_staff` VALUES ('464', '189', '121', '0', '1441508033', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('465', '190', '124', '0', '1479380708', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('466', '190', '126', '0', '1479380708', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('467', '190', '125', '0', '1479380708', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('468', '191', '124', '0', '1479384070', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('469', '191', '125', '0', '1479384070', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('470', '191', '126', '0', '1479384070', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('471', '192', '124', '0', '1479384369', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('472', '192', '125', '0', '1479384369', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('473', '192', '126', '0', '1479384369', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('474', '193', '126', '0', '1479385028', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('475', '194', '121', '0', '1479738559', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('476', '194', '123', '0', '1479738559', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('477', '195', '124', '0', '1479956538', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('478', '196', '120', '0', '1479969268', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('479', '197', '124', '0', '1479969762', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('480', '198', '123', '0', '1479970067', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('481', '198', '124', '0', '1479970067', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('482', '199', '124', '0', '1479970580', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('483', '200', '124', '0', '1479970767', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('484', '201', '124', '0', '1479998634', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('485', '201', '123', '0', '1479998634', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('486', '202', '123', '0', '1479998757', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('487', '203', '123', '0', '1479999408', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('488', '203', '124', '0', '1479999408', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('489', '204', '123', '0', '1479999797', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('490', '205', '120', '0', '1480080573', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('491', '206', '127', '0', '1480080903', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('492', '207', '120', '0', '1480299811', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('493', '208', '120', '0', '1480472895', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('494', '209', '120', '0', '1480474103', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('495', '209', '121', '0', '1480474103', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('496', '209', '123', '0', '1480474103', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('497', '210', '124', '0', '1480497367', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('498', '211', '120', '0', '1480503098', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('499', '212', '120', '0', '1480559540', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('500', '213', '123', '0', '1480562385', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('501', '213', '120', '0', '1480562385', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('502', '213', '121', '0', '1480562385', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('503', '214', '121', '0', '1480563428', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('504', '214', '123', '0', '1480563428', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('505', '214', '124', '0', '1480563428', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('506', '215', '120', '0', '1480568355', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('507', '216', '121', '0', '1480596427', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('508', '217', '126', '0', '1480645128', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('509', '218', '126', '0', '1480645936', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('510', '219', '127', '0', '1480659382', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('511', '220', '127', '0', '1480659485', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('514', '223', '123', '0', '1480671057', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('516', '225', '123', '0', '1480673120', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('517', '226', '126', '0', '1480900485', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('518', '227', '123', '0', '1481114442', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('519', '228', '124', '0', '1481188730', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('520', '229', '120', '0', '1481188927', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('521', '230', '120', '0', '1481282317', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('522', '231', '124', '0', '1481871730', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('523', '232', '124', '0', '1481872871', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('524', '233', '126', '0', '1481873280', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('525', '234', '124', '0', '1481882731', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('526', '235', '124', '0', '1481882769', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('527', '236', '120', '0', '1482139474', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('528', '237', '124', '0', '1482139912', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('529', '238', '120', '0', '1482139940', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('530', '239', '120', '0', '1482139981', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('531', '240', '125', '0', '1482582463', '1', '0');
INSERT INTO `dw_review_staff` VALUES ('532', '240', '126', '0', '1482582463', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('533', '241', '125', '0', '1482635764', '1', '1');
INSERT INTO `dw_review_staff` VALUES ('534', '242', '124', '0', '1482810623', '1', '0');

-- ----------------------------
-- Table structure for `dw_review_task`
-- ----------------------------
DROP TABLE IF EXISTS `dw_review_task`;
CREATE TABLE `dw_review_task` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `revid` int(8) DEFAULT NULL COMMENT '审批项目id，对应dw_review的id',
  `taskid` int(8) DEFAULT NULL COMMENT '任务id',
  `mid` int(8) DEFAULT NULL COMMENT '审批用户id',
  `grade` int(4) DEFAULT '0' COMMENT '审批分数',
  `createtime` int(4) DEFAULT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 COMMENT='用户审批结果表';

-- ----------------------------
-- Records of dw_review_task
-- ----------------------------
INSERT INTO `dw_review_task` VALUES ('1', '190', '1024', '124', '4', '1479381020', '1');
INSERT INTO `dw_review_task` VALUES ('2', '192', '1029', '124', '4', '1479384388', '1');
INSERT INTO `dw_review_task` VALUES ('3', '194', '1028', '123', '4', '1479969629', '1');
INSERT INTO `dw_review_task` VALUES ('4', '198', '1025', '124', '3', '1479970115', '1');
INSERT INTO `dw_review_task` VALUES ('5', '200', '1032', '124', '3', '1479970786', '1');
INSERT INTO `dw_review_task` VALUES ('6', '201', '1033', '123', '4', '1479998660', '1');
INSERT INTO `dw_review_task` VALUES ('7', '203', '1035', '123', '5', '1480512356', '1');
INSERT INTO `dw_review_task` VALUES ('8', '212', '1043', '127', '2', '1480559645', '1');
INSERT INTO `dw_review_task` VALUES ('9', '213', '1045', '124', '4', '1480562509', '1');
INSERT INTO `dw_review_task` VALUES ('10', '214', '1044', '123', '4', '1480564557', '1');
INSERT INTO `dw_review_task` VALUES ('11', '217', '1049', '126', '4', '1480645148', '1');
INSERT INTO `dw_review_task` VALUES ('12', '217', '1048', '126', '4', '1480645148', '1');
INSERT INTO `dw_review_task` VALUES ('13', '218', '1054', '126', '3', '1480645960', '1');
INSERT INTO `dw_review_task` VALUES ('14', '218', '1053', '126', '3', '1480645960', '1');
INSERT INTO `dw_review_task` VALUES ('15', '218', '1052', '126', '2', '1480645960', '1');
INSERT INTO `dw_review_task` VALUES ('16', '219', '1055', '120', '5', '1480659437', '1');
INSERT INTO `dw_review_task` VALUES ('17', '222', '1057', '127', '2', '1480660229', '1');
INSERT INTO `dw_review_task` VALUES ('18', '221', '1056', '127', '5', '1480660239', '1');
INSERT INTO `dw_review_task` VALUES ('19', '223', '1058', '124', '3', '1480671132', '1');
INSERT INTO `dw_review_task` VALUES ('20', '225', '1059', '124', '3', '1480673184', '1');
INSERT INTO `dw_review_task` VALUES ('21', '226', '1060', '126', '4', '1480900509', '1');
INSERT INTO `dw_review_task` VALUES ('22', '228', '1074', '120', '3', '1481188855', '1');
INSERT INTO `dw_review_task` VALUES ('23', '229', '1073', '120', '4', '1481188965', '1');
INSERT INTO `dw_review_task` VALUES ('24', '229', '1072', '120', '3', '1481188965', '1');
INSERT INTO `dw_review_task` VALUES ('25', '229', '1071', '120', '5', '1481188965', '1');
INSERT INTO `dw_review_task` VALUES ('26', '232', '1092', '124', '2', '1481872897', '1');
INSERT INTO `dw_review_task` VALUES ('27', '232', '1091', '124', '4', '1481872897', '1');
INSERT INTO `dw_review_task` VALUES ('28', '234', '1089', '124', '5', '1481882746', '1');
INSERT INTO `dw_review_task` VALUES ('29', '235', '1084', '124', '3', '1481882781', '1');
INSERT INTO `dw_review_task` VALUES ('30', '236', '1094', '124', '4', '1482139621', '1');
INSERT INTO `dw_review_task` VALUES ('31', '238', '1082', '120', '4', '1482139952', '1');
INSERT INTO `dw_review_task` VALUES ('32', '234', '1089', '126', '4', '1482582616', '1');
INSERT INTO `dw_review_task` VALUES ('33', '241', '1097', '125', '4', '1482635786', '1');

-- ----------------------------
-- Table structure for `dw_star`
-- ----------------------------
DROP TABLE IF EXISTS `dw_star`;
CREATE TABLE `dw_star` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1规模,2难度,3质量.4特性',
  `star1` decimal(10,2) NOT NULL DEFAULT '0.00',
  `star2` decimal(10,2) NOT NULL DEFAULT '0.00',
  `star3` decimal(10,2) NOT NULL DEFAULT '0.00',
  `star4` decimal(10,2) NOT NULL DEFAULT '0.00',
  `star5` decimal(10,2) NOT NULL DEFAULT '0.00',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_star
-- ----------------------------
INSERT INTO `dw_star` VALUES ('5', '1', '1.00', '2.00', '3.00', '4.00', '5.00', '1');
INSERT INTO `dw_star` VALUES ('6', '2', '1.00', '1.50', '2.20', '3.40', '5.00', '1');
INSERT INTO `dw_star` VALUES ('7', '3', '0.50', '0.80', '1.00', '1.20', '1.50', '1');
INSERT INTO `dw_star` VALUES ('8', '4', '1.00', '1.50', '2.20', '3.40', '5.00', '1');

-- ----------------------------
-- Table structure for `dw_task`
-- ----------------------------
DROP TABLE IF EXISTS `dw_task`;
CREATE TABLE `dw_task` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `modid` int(8) DEFAULT NULL COMMENT '模块id',
  `proid` int(8) DEFAULT NULL COMMENT '项目id',
  `task_type` int(8) DEFAULT '0',
  `title` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '项目名称',
  `intro` text CHARACTER SET utf8,
  `icon` varchar(150) DEFAULT NULL,
  `scale` int(4) DEFAULT '0' COMMENT '规模',
  `difficulty` int(4) NOT NULL DEFAULT '0' COMMENT '难度',
  `quality` int(4) DEFAULT '0' COMMENT '质量',
  `features` int(4) DEFAULT '0' COMMENT '特性',
  `mid` int(8) DEFAULT NULL COMMENT '用户id',
  `createtime` int(4) DEFAULT NULL,
  `rank` int(4) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态,0-关闭，1-启用，2-停止，3-结束',
  `company_id` int(11) DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1098 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task
-- ----------------------------
INSERT INTO `dw_task` VALUES ('1018', '10', '553', '6', '汇总问题清单', '先收集再分类', null, '5', '5', '3', '4', '120', '1441165513', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1019', '10', '553', '6', '排列顺序', '没有', null, '4', '3', '3', '3', '120', '1441165567', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1020', '10', '553', '6', '制定方法', '成熟方法优先', null, '3', '3', '3', '4', '120', '1441165600', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1021', '10', '553', '6', '检查清单', '汇总', null, '3', '3', '3', '5', '120', '1441165628', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1022', '10', '555', '6', '启动阶段', '启动会', null, '2', '2', '2', '2', '119', '1441505310', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1023', '10', '556', '6', '废话', '的%发给“', null, '4', '4', '4', '4', '121', '1441505332', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1024', '13', '555', '8', '徽杭古道', '无', null, '3', '3', '3', '3', '119', '1441505383', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1025', '16', '555', '2', '走进华为', '管理变革', null, '2', '3', '3', '3', '119', '1441505431', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1026', '10', '557', '6', '研究资料', 'KTV路将熊熊一窝', null, '3', '4', '4', '5', '120', '1479176942', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1027', '10', '557', '6', '查阅', '可口可乐了了', null, '4', '4', '4', '5', '120', '1479176989', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1028', '13', '561', '8', '哈哈哈哈哈', '图图', null, '3', '3', '3', '3', '124', '1479379345', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1029', '10', '561', '6', '休息一下', '我想问一下', null, '3', '3', '4', '4', '124', '1479379345', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1031', '10', '566', '6', '弄', '同', null, '4', '3', '4', '4', '123', '1479956382', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1032', '10', '570', '6', '任务1', '任务', null, '4', '3', '4', '3', '124', '1479970716', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1033', '10', '573', '6', '这是任务一用来测试评审', '测试评审个你好吗', null, '5', '4', '3', '3', '123', '1479998585', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1034', '10', '574', '6', 'vbbh', '比比画画', null, '4', '2', '3', '3', '123', '1479998732', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1035', '10', '575', '6', '用于发起评审1', 'vhnh', null, '4', '5', '1', '3', '124', '1479999300', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1036', '10', '579', '6', '模块一', '测试', null, '3', '2', '5', '4', '127', '1480502479', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1037', '13', '579', '8', '模块二', '吼吼', null, '1', '4', '1', '3', '127', '1480502494', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1038', '14', '579', '1', '模块三', '你好', null, '5', '2', '4', '2', '127', '1480502509', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1039', '16', '579', '2', '模块四', '里面磨', null, '4', '5', '5', '4', '127', '1480502528', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1040', '20', '579', '10', '模块五', '昵昵', null, '5', '2', '4', '2', '127', '1480502545', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1042', '0', '582', '0', '改改二基础', '抹灰工好', null, '2', '4', '2', '4', '127', '1480504991', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1043', '0', '583', '0', '哈哈哈基础', '纠结了龙膜', null, '2', '5', '2', '2', '127', '1480505136', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1044', '0', '584', '0', '基础项目测试评审1201', '测试评审用咽喉创建', null, '4', '2', '4', '2', '123', '1480560538', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1045', '0', '585', '0', '基础项目测试评审02', '测试评审用哦', null, '3', '3', '4', '5', '123', '1480562330', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1046', '0', '586', '0', '用于测试基础项目评审显示星星', 'vhhh', null, '4', '2', '3', '4', '123', '1480565229', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1047', '0', '587', '0', '基础项目测试', '测试评审', null, '4', '3', '4', '4', '126', '1480644036', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1048', '10', '588', '6', '开始测试', '测试', null, '3', '4', '4', '4', '126', '1480644809', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1049', '10', '588', '6', '呃呃呃', '啊', null, '3', '3', '3', '3', '126', '1480644923', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1050', '10', '589', '6', '任务1', '任务1', null, '3', '2', '4', '3', '126', '1480645718', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1051', '10', '589', '6', '任务2', '任务2', null, '3', '4', '3', '4', '126', '1480645742', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1052', '10', '590', '6', '1', '1', null, '3', '3', '3', '3', '126', '1480645828', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1053', '10', '590', '6', '2', '2', null, '4', '4', '4', '4', '126', '1480645843', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1054', '10', '590', '6', '3', '3', null, '4', '4', '4', '4', '126', '1480645856', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1055', '0', '591', '0', '哈哈测试', '昵昵红', null, '3', '5', '3', '4', '127', '1480658499', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1058', '0', '593', '0', '基础项目创建评审测试', 'vbh', null, '5', '5', '3', '3', '123', '1480670992', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1059', '10', '594', '6', '弄', '弄', null, '5', '3', '4', '5', '124', '1480673081', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1060', '0', '595', '0', '基础测试1', '测试', null, '4', '3', '4', '4', '126', '1480900428', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1061', '10', '596', '6', '任务', '热衷于', null, '3', '3', '2', '4', '124', '1481114766', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1062', '10', '596', '6', '任务2', '2', null, '4', '3', '4', '4', '124', '1481114799', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1063', '10', '596', '6', 'renwu3', 'vh', null, '3', '4', '5', '5', '124', '1481114912', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1064', '13', '596', '8', '规划好', '发广告', null, '3', '4', '3', '4', '124', '1481115031', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1065', '13', '596', '8', '覆盖规划', '此次改革', null, '4', '5', '4', '4', '124', '1481115031', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1066', '10', '574', '6', '咯莫', '', null, '3', '3', '4', '5', '123', '1481163969', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1067', '0', '597', '0', '创建一个基础项目001', '123456', null, '3', '4', '4', '2', '123', '1481168634', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1068', '10', '598', '6', '任务一', '很纠结', null, '2', '5', '2', '4', '123', '1481177012', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1069', '10', '598', '6', '斤斤计较', '白白净净', null, '5', '4', '4', '4', '123', '1481177012', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1070', '10', '598', '11', '还斤斤计较', '白白嫩嫩', null, '5', '4', '3', '5', '123', '1481177012', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1071', '10', '599', '6', '任务A', '一个人选取独立安卓来领取', null, '4', '2', '4', '5', '126', '1481183850', '0', '0', '1');
INSERT INTO `dw_task` VALUES ('1072', '10', '599', '6', '创建一个苹果优酷', '突然间', null, '4', '5', '3', '3', '126', '1481184739', '0', '0', '1');
INSERT INTO `dw_task` VALUES ('1073', '10', '599', '6', '创建核心参与', '图文', null, '4', '2', '3', '5', '126', '1481185957', '0', '0', '1');
INSERT INTO `dw_task` VALUES ('1074', '0', '600', '0', '书燕创建一个基础项目', '还斤斤计较', null, '4', '3', '5', '5', '126', '1481186778', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1075', '10', '601', '6', 'we', 'rtyu', null, '5', '4', '5', '5', '123', '1481199828', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1076', '10', '602', '6', '1', '1', null, '5', '5', '5', '5', '125', '1481200944', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1077', '13', '602', '8', '2', '2', null, '5', '5', '5', '5', '125', '1481200967', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1078', '14', '602', '1', '3', '3', null, '5', '5', '5', '5', '125', '1481200981', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1079', '10', '603', '6', '并不会', '规划好', null, '3', '5', '4', '5', '123', '1481201236', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1080', '10', '604', '6', '1209任务一', '空间看看', null, '2', '5', '3', '3', '127', '1481271515', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1081', '10', '604', '11', '任务二', '魔剑录图像永', null, '2', '5', '3', '4', '127', '1481271515', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1082', '0', '605', '0', '1209基础', '咯摸摸墨迹了', null, '2', '4', '3', '2', '127', '1481271746', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1084', '0', '607', '0', '1209222基础', '哦可口可乐了', null, '2', '3', '4', '4', '127', '1481273233', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1085', '10', '608', '6', '体重', '他现在', null, '5', '4', '4', '3', '127', '1481276474', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1086', '0', '609', '0', '黑胡椒', '很纠结', null, '1', '1', '1', '1', '123', '1481278222', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1087', '10', '610', '6', '要好好', '高规格', null, '1', '2', '4', '1', '123', '1481278620', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1088', '0', '611', '0', '高规格', '规划好', null, '2', '4', '3', '3', '123', '1481281770', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1089', '0', '612', '0', '基础项目领取测试', '测试', null, '4', '3', '4', '4', '126', '1481869639', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1090', '0', '613', '0', '基础项目领取测试2', '测试2', null, '4', '3', '4', '4', '126', '1481870006', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1091', '10', '614', '6', '测试', '测试', null, '3', '3', '4', '3', '124', '1481871619', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1092', '10', '614', '11', '测试2', '测试2', null, '3', '4', '3', '4', '124', '1481871619', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1093', '10', '615', '6', 'iOS创建', '不后悔', null, '3', '4', '4', '4', '124', '1482112061', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1094', '10', '616', '6', '停机了', '吐了', null, '2', '3', '3', '3', '124', '1482138955', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1095', '0', '617', '0', '创建基础项目', '兔兔', null, '4', '4', '4', '2', '124', '1482139686', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1096', '10', '618', '6', '哈哈哈', '哈哈哈', null, '4', '4', '2', '4', '124', '1482150258', '0', '1', '1');
INSERT INTO `dw_task` VALUES ('1097', '0', '619', '0', '基础项目测试2', '测试2', null, '3', '4', '3', '4', '124', '1482582404', '0', '1', '1');

-- ----------------------------
-- Table structure for `dw_task_fansi`
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_fansi`;
CREATE TABLE `dw_task_fansi` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `taskid` int(8) DEFAULT NULL COMMENT '任务ID',
  `mid` int(8) DEFAULT NULL COMMENT '用户id',
  `qingkuang` text CHARACTER SET utf8 COMMENT '完成情况',
  `feiyong` text CHARACTER SET utf8 COMMENT '实际费用',
  `tianshu` text CHARACTER SET utf8 COMMENT '实际天数',
  `total` decimal(4,2) DEFAULT '0.00' COMMENT '最终得分',
  `status` tinyint(4) DEFAULT '0' COMMENT '完成情况，所有内容填写完后改变值-1，0为没有填写完整',
  `createtime` int(4) DEFAULT NULL COMMENT '发布时间',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_fansi
-- ----------------------------
INSERT INTO `dw_task_fansi` VALUES ('43', '1022', '119', '完成', '10000', '25', '0.00', '0', '1441507000', '1');
INSERT INTO `dw_task_fansi` VALUES ('44', '1022', '124', 'babajjjjjttttsqxyonjjjttttojttttskoxzttljttyttttyongquklv分析一下我吐吐吐急急急急坏哦哦现在正在走停停我进课堂突然说嗯我最近', '300', '2', '0.00', '0', '1479379876', '1');
INSERT INTO `dw_task_fansi` VALUES ('45', '554', '126', '啊啊啊', '200', '80', '0.00', '0', '1479385173', '1');
INSERT INTO `dw_task_fansi` VALUES ('46', '1024', '124', '吧', '100', '20', '0.00', '0', '1479387331', '1');
INSERT INTO `dw_task_fansi` VALUES ('47', '1022', '123', '', '', '', '0.00', '0', '1479712505', '1');
INSERT INTO `dw_task_fansi` VALUES ('48', '563', '123', '', '', '', '0.00', '0', '1480061417', '1');
INSERT INTO `dw_task_fansi` VALUES ('49', '577', '120', '昵昵', '300', '3', '0.00', '0', '1480501280', '1');
INSERT INTO `dw_task_fansi` VALUES ('50', '1036', '120', '好好完毕', '333', '5', '0.00', '0', '1480502791', '1');
INSERT INTO `dw_task_fansi` VALUES ('51', '1037', '120', '经历过', '222', '6', '0.00', '0', '1480502860', '1');
INSERT INTO `dw_task_fansi` VALUES ('52', '1038', '120', '没流量了', '2000', '4', '0.00', '0', '1480502894', '1');
INSERT INTO `dw_task_fansi` VALUES ('53', '580', '123', '几个号', '5555', '5', '0.00', '0', '1480503675', '1');
INSERT INTO `dw_task_fansi` VALUES ('54', '580', '120', '干净利落', '555', '7', '0.00', '0', '1480503717', '1');
INSERT INTO `dw_task_fansi` VALUES ('55', '587', '126', '30', '20', '1', '0.00', '0', '1480644377', '1');
INSERT INTO `dw_task_fansi` VALUES ('56', '597', '127', 'vbb', '哈哈', 'vvn', '0.00', '0', '1481169204', '1');
INSERT INTO `dw_task_fansi` VALUES ('57', '1068', '125', '完成', '789', '7天', '0.00', '0', '1481178492', '1');
INSERT INTO `dw_task_fansi` VALUES ('58', '1073', '125', '编辑', 'vb', 'vvb', '0.00', '0', '1481186342', '1');
INSERT INTO `dw_task_fansi` VALUES ('59', '600', '125', '吐', '解决了', '汉口呢', '0.00', '0', '1481186953', '1');
INSERT INTO `dw_task_fansi` VALUES ('60', '1080', '127', '路路通', '6666', '5', '0.00', '0', '1481276254', '1');
INSERT INTO `dw_task_fansi` VALUES ('61', '1080', '123', '默默哦', '66666', '5', '0.00', '0', '1481276330', '1');
INSERT INTO `dw_task_fansi` VALUES ('62', '1085', '127', '现在', '天下', '他现在', '0.00', '0', '1481276522', '1');
INSERT INTO `dw_task_fansi` VALUES ('63', '607', '123', '可口可乐了', '666', '5', '0.00', '0', '1481276621', '1');
INSERT INTO `dw_task_fansi` VALUES ('64', '607', '127', '噢噢噢', '66', '8', '0.00', '0', '1481276816', '1');
INSERT INTO `dw_task_fansi` VALUES ('65', '609', '123', '爸爸', '不会', 'vbb', '0.00', '0', '1481278286', '1');
INSERT INTO `dw_task_fansi` VALUES ('66', '1087', '123', '哈哈哈', 'vvv', 'vvv', '0.00', '0', '1481278716', '1');
INSERT INTO `dw_task_fansi` VALUES ('67', '611', '123', '对的', '双色球', '是谁', '0.00', '0', '1481282049', '1');
INSERT INTO `dw_task_fansi` VALUES ('68', '613', '124', '解决了', '吐', '了', '0.00', '0', '1482111107', '1');
INSERT INTO `dw_task_fansi` VALUES ('69', '1094', '124', '看看', '看见了', '出来了', '0.00', '0', '1482139322', '1');
INSERT INTO `dw_task_fansi` VALUES ('70', '617', '124', '看看', '兔兔', '图', '0.00', '0', '1482139738', '1');
INSERT INTO `dw_task_fansi` VALUES ('71', '1096', '124', '好', '800', '20', '0.00', '0', '1482470021', '1');
INSERT INTO `dw_task_fansi` VALUES ('72', '619', '126', '哈子', '80', '14', '0.00', '0', '1482640454', '1');

-- ----------------------------
-- Table structure for `dw_task_fansi_reply`
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_fansi_reply`;
CREATE TABLE `dw_task_fansi_reply` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `fansiid` int(8) NOT NULL COMMENT '反思id',
  `exid` int(8) NOT NULL COMMENT '专家id，或用户id',
  `content` text CHARACTER SET utf8 NOT NULL,
  `createtime` int(4) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '是否查看',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_fansi_reply
-- ----------------------------
INSERT INTO `dw_task_fansi_reply` VALUES ('67', '64', '120', '我要用喔喔喔', '1481278274', '1', '1');
INSERT INTO `dw_task_fansi_reply` VALUES ('66', '62', '123', '提供', '1481276743', '1', '0');
INSERT INTO `dw_task_fansi_reply` VALUES ('63', '53', '120', '突然', '1481276249', '1', '0');
INSERT INTO `dw_task_fansi_reply` VALUES ('64', '59', '120', '图腾机柜', '1481276276', '1', '0');
INSERT INTO `dw_task_fansi_reply` VALUES ('65', '62', '120', '突然', '1481276574', '1', '0');
INSERT INTO `dw_task_fansi_reply` VALUES ('62', '57', '127', '通了', '1481178603', '1', '1');
INSERT INTO `dw_task_fansi_reply` VALUES ('59', '48', '126', '不知道', '1480643964', '1', '1');
INSERT INTO `dw_task_fansi_reply` VALUES ('60', '55', '124', '还可以', '1480903355', '1', '0');
INSERT INTO `dw_task_fansi_reply` VALUES ('61', '55', '124', '嗯', '1480906635', '1', '0');
INSERT INTO `dw_task_fansi_reply` VALUES ('58', '45', '124', '模拟', '1479386389', '1', '1');
INSERT INTO `dw_task_fansi_reply` VALUES ('57', '43', '121', '方%就看看', '1441507087', '1', '1');
INSERT INTO `dw_task_fansi_reply` VALUES ('56', '43', '121', '方%就看看常vb', '1441507040', '1', '1');
INSERT INTO `dw_task_fansi_reply` VALUES ('68', '55', '124', '解决了', '1482111255', '1', '0');
INSERT INTO `dw_task_fansi_reply` VALUES ('69', '55', '124', '吐', '1482111287', '1', '0');
INSERT INTO `dw_task_fansi_reply` VALUES ('70', '69', '120', '吐了', '1482139388', '1', '1');
INSERT INTO `dw_task_fansi_reply` VALUES ('71', '70', '120', '剧照', '1482139787', '1', '1');
INSERT INTO `dw_task_fansi_reply` VALUES ('72', '55', '124', '11', '1482156139', '1', '0');
INSERT INTO `dw_task_fansi_reply` VALUES ('73', '55', '125', '可以', '1482635115', '1', '0');
INSERT INTO `dw_task_fansi_reply` VALUES ('74', '45', '125', '也许吧', '1482635455', '1', '0');

-- ----------------------------
-- Table structure for `dw_task_fansi_score`
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_fansi_score`;
CREATE TABLE `dw_task_fansi_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fansiid` int(11) NOT NULL COMMENT '反思id',
  `exid` int(11) NOT NULL COMMENT '专家id',
  ` score` decimal(18,2) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_task_fansi_score
-- ----------------------------

-- ----------------------------
-- Table structure for `dw_task_marking`
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_marking`;
CREATE TABLE `dw_task_marking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taskid` int(11) NOT NULL COMMENT '任务id',
  `projectid` int(11) NOT NULL COMMENT '项目id',
  `typeid` int(11) NOT NULL COMMENT '1重大项目2基础项目',
  `mid` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `taskmid` int(11) NOT NULL COMMENT '任务所属mid',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  `status` int(11) DEFAULT '0' COMMENT '是否查看',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COMMENT='指导项目打分表';

-- ----------------------------
-- Records of dw_task_marking
-- ----------------------------
INSERT INTO `dw_task_marking` VALUES ('36', '1073', '599', '1', '120', '4', '1481186521', '125', '1', '0');
INSERT INTO `dw_task_marking` VALUES ('35', '1068', '598', '1', '120', '3', '1481179066', '125', '1', '1');
INSERT INTO `dw_task_marking` VALUES ('34', '1068', '598', '1', '127', '4', '1481178645', '125', '1', '1');
INSERT INTO `dw_task_marking` VALUES ('33', '597', '597', '2', '120', '3', '1481169315', '127', '1', '1');
INSERT INTO `dw_task_marking` VALUES ('32', '587', '587', '2', '124', '4', '1481022952', '126', '1', '0');
INSERT INTO `dw_task_marking` VALUES ('31', '580', '580', '2', '126', '3', '1481022829', '123', '1', '0');
INSERT INTO `dw_task_marking` VALUES ('30', '554', '554', '2', '124', '4', '1479387271', '126', '1', '0');
INSERT INTO `dw_task_marking` VALUES ('37', '1073', '599', '1', '127', '2', '1481186625', '125', '1', '0');
INSERT INTO `dw_task_marking` VALUES ('38', '600', '600', '2', '120', '4', '1481187002', '125', '1', '0');
INSERT INTO `dw_task_marking` VALUES ('39', '1080', '604', '1', '120', '2', '1481276504', '127', '1', '0');
INSERT INTO `dw_task_marking` VALUES ('40', '1085', '608', '1', '123', '4', '1481277034', '127', '1', '0');
INSERT INTO `dw_task_marking` VALUES ('41', '609', '609', '2', '120', '3', '1481278374', '123', '1', '1');
INSERT INTO `dw_task_marking` VALUES ('42', '1087', '610', '1', '120', '3', '1481278777', '123', '1', '1');
INSERT INTO `dw_task_marking` VALUES ('43', '1087', '610', '1', '121', '4', '1481278846', '123', '1', '1');
INSERT INTO `dw_task_marking` VALUES ('44', '607', '607', '2', '120', '4', '1481279449', '123', '1', '1');
INSERT INTO `dw_task_marking` VALUES ('52', '611', '611', '2', '120', '3', '1481282159', '123', '1', '1');
INSERT INTO `dw_task_marking` VALUES ('51', '607', '607', '2', '120', '3', '1481281319', '127', '1', '0');
INSERT INTO `dw_task_marking` VALUES ('53', '1038', '579', '1', '124', '2', '1482111403', '120', '1', '0');
INSERT INTO `dw_task_marking` VALUES ('54', '1094', '616', '1', '120', '2', '1482139407', '124', '1', '1');
INSERT INTO `dw_task_marking` VALUES ('55', '617', '617', '2', '120', '2', '1482139817', '124', '1', '1');

-- ----------------------------
-- Table structure for `dw_task_plan`
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_plan`;
CREATE TABLE `dw_task_plan` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `taskid` int(8) NOT NULL,
  `mid` int(8) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `createtime` int(4) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `company_id` int(11) DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_plan
-- ----------------------------
INSERT INTO `dw_task_plan` VALUES ('98', '1080', '123', '酷兔兔', '1481276315', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('97', '1081', '120', 'yyyy', '1481275669', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('96', '1071', '125', 'bbbbb', '1481275391', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('93', '1079', '127', 'very good', '1481271490', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('94', '1080', '127', '666', '1481274881', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('95', '1079', '125', 'bbbbb', '1481275375', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('91', '1073', '125', '成交价', '1481186329', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('92', '600', '125', '山咀头', '1481186938', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('89', '597', '127', '我是来要回家', '1481169188', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('90', '1068', '125', '这件事我准备这样', '1481178470', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('88', '567', '124', 'r', '1480944468', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('87', '587', '126', '挺好玩的', '1480644356', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('86', '580', '120', '图图他', '1480503697', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('83', '1037', '120', '经历过', '1480502842', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('84', '1038', '120', '将计就计', '1480502877', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('85', '580', '123', '冥界警局', '1480503657', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('82', '1036', '120', '这个', '1480502770', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('81', '577', '120', '测试一下', '1480501257', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('73', '1022', '119', '无', '1441506330', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('74', '1022', '121', '二个好觉', '1441506366', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('75', '1022', '123', '刚洗完', '1479286157', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('76', '1022', '124', '还可以', '1479379819', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('77', '554', '126', '陌陌争霸天下', '1479385140', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('78', '1024', '124', '哈哈哈哈', '1479387301', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('79', '562', '124', '很好', '1479961944', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('80', '563', '123', 'eseeee', '1480061356', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('99', '1085', '127', ' 田祖站', '1481276505', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('100', '607', '123', '兔兔图', '1481276601', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('101', '607', '127', '好好过好', '1481276798', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('102', '609', '123', 'vbn', '1481278271', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('103', '1087', '123', '风格吧', '1481278699', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('104', '611', '123', '相当的', '1481282034', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('105', '1091', '124', '对对对', '1482110822', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('106', '613', '124', '都发到', '1482111076', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('107', '1094', '124', '空间', '1482139306', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('108', '617', '124', ' 看看', '1482139721', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('109', '1096', '124', '策划不错', '1482469984', '1', '1');
INSERT INTO `dw_task_plan` VALUES ('110', '619', '126', '好', '1482640421', '1', '1');

-- ----------------------------
-- Table structure for `dw_task_plan_reply`
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_plan_reply`;
CREATE TABLE `dw_task_plan_reply` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `planid` int(8) NOT NULL COMMENT '任务id,taskid',
  `exid` int(8) NOT NULL COMMENT '专家id，或用户id',
  `content` text CHARACTER SET utf8 NOT NULL,
  `createtime` int(4) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '是否查看',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_plan_reply
-- ----------------------------
INSERT INTO `dw_task_plan_reply` VALUES ('141', '97', '124', '吐', '1482111211', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('131', '99', '123', '如果你', '1481276730', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('132', '99', '123', '啦啦啦啦', '1481277023', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('133', '101', '120', '可口可乐了了', '1481278268', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('129', '94', '120', '好滴', '1481276487', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('130', '99', '120', '突然间', '1481276562', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('128', '73', '127', '监控', '1481276374', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('140', '97', '124', '对对对', '1482111207', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('139', '104', '120', 'vvb', '1481282135', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('138', '103', '120', '风格', '1481278759', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('137', '102', '120', '让丰富', '1481278347', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('136', '102', '120', '让丰富', '1481278347', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('135', '102', '120', '让丰富', '1481278341', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('134', '102', '120', '让丰富', '1481278337', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('127', '92', '127', '那种', '1481276357', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('142', '84', '124', '兔兔', '1482111370', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('124', '85', '120', '体重', '1481276242', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('125', '92', '120', '解决了', '1481276262', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('126', '96', '127', '兔兔', '1481276310', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('122', '95', '120', '不理你了', '1481276201', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('115', '94', '120', 'ddddd', '1481275913', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('116', '94', '120', 'gggg', '1481275922', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('117', '93', '120', 'ddddd', '1481275946', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('118', '93', '120', 'ddddd', '1481275947', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('119', '93', '120', 'ddddd', '1481275948', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('120', '95', '120', 'ggggg', '1481275992', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('121', '94', '120', '阿龙', '1481276185', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('114', '91', '127', 'we', '1481206992', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('123', '95', '120', '了咯了', '1481276215', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('147', '87', '124', '', '1482155786', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('146', '108', '120', '兔兔', '1482139781', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('145', '107', '120', '看见了', '1482139399', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('144', '107', '120', '吐了', '1482139379', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('112', '90', '127', ' 通过了', '1481178633', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('113', '91', '127', 'qqqq', '1481206802', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('108', '77', '124', '不知道', '1479386370', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('109', '80', '126', '测试', '1480643949', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('150', '77', '125', '也许吧', '1482635432', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('149', '87', '125', '可以', '1482635098', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('148', '87', '125', '可以', '1482635088', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('143', '84', '124', '对的', '1482111374', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('106', '73', '121', '东莞厚街', '1441506830', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('107', '75', '124', '测试', '1479386322', '1', '1');
INSERT INTO `dw_task_plan_reply` VALUES ('110', '87', '124', '太差了', '1480903333', '1', '0');
INSERT INTO `dw_task_plan_reply` VALUES ('111', '90', '127', '布沙路', '1481178576', '1', '1');

-- ----------------------------
-- Table structure for `dw_task_type`
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_type`;
CREATE TABLE `dw_task_type` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `rank` int(4) DEFAULT '0',
  `modid` int(11) NOT NULL COMMENT '模块id',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_type
-- ----------------------------
INSERT INTO `dw_task_type` VALUES ('1', '任务1', '4', '14', '1');
INSERT INTO `dw_task_type` VALUES ('2', '任务1', '5', '16', '1');
INSERT INTO `dw_task_type` VALUES ('6', '任务1', '2', '10', '1');
INSERT INTO `dw_task_type` VALUES ('8', '任务1', '2', '13', '1');
INSERT INTO `dw_task_type` VALUES ('10', '任务1', '6', '20', '1');
INSERT INTO `dw_task_type` VALUES ('11', '任务2', '0', '10', '1');

-- ----------------------------
-- Table structure for `dw_task_wenti`
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_wenti`;
CREATE TABLE `dw_task_wenti` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `taskid` int(8) NOT NULL,
  `mid` int(8) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `createtime` int(4) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=182 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_wenti
-- ----------------------------
INSERT INTO `dw_task_wenti` VALUES ('181', '619', '126', '好', '1482640429', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('180', '1096', '124', '都解决了', '1482469998', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('179', '617', '124', '兔兔', '1482139726', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('178', '1094', '124', '看见了', '1482139311', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('177', '613', '124', '兔兔', '1482111088', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('176', '613', '124', '兔兔', '1482111088', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('175', '1091', '124', '兔兔', '1482110839', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('174', '611', '123', '休闲鞋', '1481282039', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('173', '611', '123', '休闲鞋', '1481282038', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('172', '1087', '123', 'vbb', '1481278705', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('171', '1087', '123', 'vbb', '1481278704', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('170', '609', '123', '不不不', '1481278275', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('169', '607', '127', '弄弄头发', '1481276805', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('168', '607', '123', '流量监控哦n', '1481276609', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('167', '1085', '127', '兔兔', '1481276510', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('166', '1080', '123', '监狱兔', '1481276337', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('165', '1080', '123', '咯摸摸默默哦', '1481276320', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('163', '1071', '125', 'ggggg', '1481275454', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('164', '1080', '127', '可口可乐了', '1481276230', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('160', '1080', '127', 'mmmm', '1481274949', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('161', '1080', '127', '6666', '1481274955', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('162', '1071', '125', 'dddddd', '1481275447', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('159', '600', '125', '突然', '1481186943', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('158', '1073', '125', '宝宝不好', '1481186333', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('157', '1068', '125', '不觉得这样好吗', '1481178477', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('156', '597', '127', 'vbnj', '1481169193', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('155', '567', '124', '88888', '1480944488', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('154', '587', '126', '把', '1480903227', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('153', '587', '126', '不好玩', '1480644362', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('152', '580', '120', '我考虑考虑', '1480503703', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('151', '580', '123', '投机取巧', '1480503664', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('150', '1038', '120', '桃李花歌', '1480502882', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('147', '577', '120', '吧考虑考虑', '1480501263', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('148', '1036', '120', '文艺青年', '1480502776', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('149', '1037', '120', '生日快乐', '1480502848', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('145', '563', '123', 'kkkkkkk', '1480061385', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('146', '563', '123', 'jjjjjj', '1480061389', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('144', '563', '123', 'hhhhhh', '1480061378', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('143', '563', '123', 'edeeeee', '1480061362', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('142', '554', '126', '的', '1479468039', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('141', '1024', '124', '来来来', '1479387308', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('140', '554', '126', '阿奎利亚', '1479385150', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('139', '1022', '124', '啊啊啊图谱', '1479379890', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('138', '1022', '119', '？', '1441506833', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('137', '1022', '119', '怎么办？', '1441506608', '0', '1');
INSERT INTO `dw_task_wenti` VALUES ('136', '1022', '119', '领导难以预约', '1441506592', '0', '1');

-- ----------------------------
-- Table structure for `dw_task_wenti_reply`
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_wenti_reply`;
CREATE TABLE `dw_task_wenti_reply` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `wentiid` int(8) NOT NULL COMMENT '问题id',
  `exid` int(8) NOT NULL COMMENT '专家id，或用户id',
  `content` text CHARACTER SET utf8 NOT NULL,
  `createtime` int(4) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属管理员',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '是否查看',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_wenti_reply
-- ----------------------------
INSERT INTO `dw_task_wenti_reply` VALUES ('97', '136', '121', '方“老哥哥好', '1441506886', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('96', '137', '121', '的感觉吗', '1441506852', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('95', '137', '121', '蛋糕和快乐', '1441506847', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('118', '154', '125', '可以', '1482635195', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('117', '154', '125', '可以', '1482635158', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('116', '178', '120', '回来了', '1482139383', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('115', '150', '124', 'kk', '1482111395', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('114', '150', '124', '哈哈哈', '1482111390', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('113', '174', '120', 'vv', '1481282140', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('112', '167', '123', '啦啦啦啦', '1481277028', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('111', '167', '123', '漏水了', '1481276738', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('110', '167', '120', '过来看看', '1481276569', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('109', '161', '120', '好', '1481276499', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('108', '163', '127', '突然', '1481276317', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('107', '159', '120', '155', '1481276269', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('106', '151', '120', '解决了', '1481276255', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('105', '160', '120', '突然', '1481276192', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('104', '157', '120', '对方尴尬', '1481179039', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('102', '156', '120', '还不错', '1481169272', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('101', '140', '124', '6666666', '1480944695', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('100', '140', '124', 'kkkkkkkkk', '1480944545', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('98', '154', '124', '高规格', '1480906125', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('99', '153', '124', '不好玩', '1480906622', '1', '1');
INSERT INTO `dw_task_wenti_reply` VALUES ('103', '157', '127', '挺好的', '1481178590', '1', '1');

-- ----------------------------
-- Table structure for `dw_trouble`
-- ----------------------------
DROP TABLE IF EXISTS `dw_trouble`;
CREATE TABLE `dw_trouble` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `task_id` int(8) DEFAULT NULL,
  `tr_name` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `tr_num` int(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_trouble
-- ----------------------------

-- ----------------------------
-- Table structure for `dw_user`
-- ----------------------------
DROP TABLE IF EXISTS `dw_user`;
CREATE TABLE `dw_user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `pwd` varchar(120) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `createtime` varchar(35) NOT NULL,
  `end_time` int(11) NOT NULL DEFAULT '0',
  `roleid` int(11) NOT NULL,
  `usernum` int(11) NOT NULL DEFAULT '0' COMMENT '会员人数',
  `userdomain` varchar(500) NOT NULL COMMENT '域名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_user
-- ----------------------------
INSERT INTO `dw_user` VALUES ('1', 'admin', '202cb962ac59075b964b07152d234b70', 'test@163.com', '1440731802', '1452902460', '1', '30', 'http://120.24.101.39/dewei/');

-- ----------------------------
-- Table structure for `dw_user_menu`
-- ----------------------------
DROP TABLE IF EXISTS `dw_user_menu`;
CREATE TABLE `dw_user_menu` (
  `nodeId` int(11) NOT NULL AUTO_INCREMENT,
  `displayName` varchar(50) DEFAULT NULL,
  `module_name` varchar(512) DEFAULT NULL,
  `action_name` varchar(50) NOT NULL,
  `DisplayOrder` int(11) DEFAULT NULL,
  `parentNodeId` int(11) DEFAULT NULL,
  `paramVal` int(11) NOT NULL COMMENT '用于传递参数，0为无参数',
  PRIMARY KEY (`nodeId`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_user_menu
-- ----------------------------
INSERT INTO `dw_user_menu` VALUES ('1', '管理员', null, '', '1', '0', '0');
INSERT INTO `dw_user_menu` VALUES ('2', '管理员', 'home', 'user', '1', '1', '0');
INSERT INTO `dw_user_menu` VALUES ('3', '角色管理', 'home', 'user_role', '2', '1', '0');
INSERT INTO `dw_user_menu` VALUES ('4', '会员管理', null, '', '2', '0', '0');
INSERT INTO `dw_user_menu` VALUES ('5', '员工列表', 'home', 'member', '1', '4', '1');
INSERT INTO `dw_user_menu` VALUES ('6', '专家列表', 'home', 'member', '2', '4', '2');
INSERT INTO `dw_user_menu` VALUES ('7', '领导列表', 'home', 'member', '3', '4', '3');
INSERT INTO `dw_user_menu` VALUES ('8', '部门管理', 'home', 'department', '4', '4', '0');
INSERT INTO `dw_user_menu` VALUES ('9', '项目池', null, '', '3', '0', '0');
INSERT INTO `dw_user_menu` VALUES ('10', '公式设置', 'home', 'gongshi', '1', '9', '0');
INSERT INTO `dw_user_menu` VALUES ('11', '重大项目', 'home', 'project', '2', '9', '1');
INSERT INTO `dw_user_menu` VALUES ('12', '基础项目', 'home', 'project', '3', '9', '2');
INSERT INTO `dw_user_menu` VALUES ('13', '模块列表', 'home', 'mod', '4', '9', '0');
INSERT INTO `dw_user_menu` VALUES ('14', '任务类型', 'home', 'tasktype', '5', '9', '0');
INSERT INTO `dw_user_menu` VALUES ('15', '任务列表', 'home', 'task', '6', '9', '0');
INSERT INTO `dw_user_menu` VALUES ('17', '复盘', null, '', '4', '0', '0');
INSERT INTO `dw_user_menu` VALUES ('18', '复盘类型', 'home', 'replay_type', '1', '17', '0');
INSERT INTO `dw_user_menu` VALUES ('19', '复盘列表', 'home', 'conquer', '2', '17', '0');
INSERT INTO `dw_user_menu` VALUES ('20', '系统相关', null, '', '5', '0', '0');
INSERT INTO `dw_user_menu` VALUES ('21', '系统说明', 'home', 'aboutsys', '1', '20', '0');
INSERT INTO `dw_user_menu` VALUES ('22', '意见反馈', 'home', 'feedback', '2', '20', '0');
INSERT INTO `dw_user_menu` VALUES ('23', '关于我们', 'home', 'aboutus', '3', '20', '0');
INSERT INTO `dw_user_menu` VALUES ('24', '图片库', 'home', 'pics', '4', '20', '0');
INSERT INTO `dw_user_menu` VALUES ('25', '轮播图', 'home', 'advs', '5', '20', '0');
INSERT INTO `dw_user_menu` VALUES ('76', '导入EXCEL', 'home', 'excelmobile', '4', '4', '0');
INSERT INTO `dw_user_menu` VALUES ('77', '职位管理', 'home', 'jobs', '5', '4', '0');
INSERT INTO `dw_user_menu` VALUES ('78', '统计管理', 'home', 'membertotal', '6', '4', '0');
INSERT INTO `dw_user_menu` VALUES ('79', '项目统计', 'home', 'projecttotal', '7', '9', '0');

-- ----------------------------
-- Table structure for `dw_user_right`
-- ----------------------------
DROP TABLE IF EXISTS `dw_user_right`;
CREATE TABLE `dw_user_right` (
  `roleRightId` int(11) NOT NULL AUTO_INCREMENT,
  `roleId` int(11) DEFAULT NULL,
  `nodeId` int(11) DEFAULT NULL,
  PRIMARY KEY (`roleRightId`)
) ENGINE=InnoDB AUTO_INCREMENT=756 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_user_right
-- ----------------------------
INSERT INTO `dw_user_right` VALUES ('575', '1', '9');
INSERT INTO `dw_user_right` VALUES ('576', '2', '9');
INSERT INTO `dw_user_right` VALUES ('577', '3', '9');
INSERT INTO `dw_user_right` VALUES ('578', '4', '9');
INSERT INTO `dw_user_right` VALUES ('579', '5', '9');
INSERT INTO `dw_user_right` VALUES ('580', '6', '9');
INSERT INTO `dw_user_right` VALUES ('581', '7', '9');
INSERT INTO `dw_user_right` VALUES ('582', '8', '9');
INSERT INTO `dw_user_right` VALUES ('583', '9', '9');
INSERT INTO `dw_user_right` VALUES ('584', '10', '9');
INSERT INTO `dw_user_right` VALUES ('585', '11', '9');
INSERT INTO `dw_user_right` VALUES ('586', '12', '9');
INSERT INTO `dw_user_right` VALUES ('587', '13', '9');
INSERT INTO `dw_user_right` VALUES ('588', '14', '9');
INSERT INTO `dw_user_right` VALUES ('589', '15', '9');
INSERT INTO `dw_user_right` VALUES ('590', '16', '9');
INSERT INTO `dw_user_right` VALUES ('591', '17', '9');
INSERT INTO `dw_user_right` VALUES ('592', '18', '9');
INSERT INTO `dw_user_right` VALUES ('593', '19', '9');
INSERT INTO `dw_user_right` VALUES ('594', '20', '9');
INSERT INTO `dw_user_right` VALUES ('595', '21', '9');
INSERT INTO `dw_user_right` VALUES ('596', '22', '9');
INSERT INTO `dw_user_right` VALUES ('597', '23', '9');
INSERT INTO `dw_user_right` VALUES ('598', '24', '9');
INSERT INTO `dw_user_right` VALUES ('599', '25', '9');
INSERT INTO `dw_user_right` VALUES ('600', '26', '9');
INSERT INTO `dw_user_right` VALUES ('601', '27', '9');
INSERT INTO `dw_user_right` VALUES ('602', '28', '9');
INSERT INTO `dw_user_right` VALUES ('681', '1', '1');
INSERT INTO `dw_user_right` VALUES ('682', '2', '1');
INSERT INTO `dw_user_right` VALUES ('683', '3', '1');
INSERT INTO `dw_user_right` VALUES ('684', '4', '1');
INSERT INTO `dw_user_right` VALUES ('685', '5', '1');
INSERT INTO `dw_user_right` VALUES ('686', '6', '1');
INSERT INTO `dw_user_right` VALUES ('687', '7', '1');
INSERT INTO `dw_user_right` VALUES ('688', '8', '1');
INSERT INTO `dw_user_right` VALUES ('689', '76', '1');
INSERT INTO `dw_user_right` VALUES ('690', '77', '1');
INSERT INTO `dw_user_right` VALUES ('691', '78', '1');
INSERT INTO `dw_user_right` VALUES ('692', '79', '1');
INSERT INTO `dw_user_right` VALUES ('693', '9', '1');
INSERT INTO `dw_user_right` VALUES ('694', '10', '1');
INSERT INTO `dw_user_right` VALUES ('695', '11', '1');
INSERT INTO `dw_user_right` VALUES ('696', '12', '1');
INSERT INTO `dw_user_right` VALUES ('697', '13', '1');
INSERT INTO `dw_user_right` VALUES ('698', '14', '1');
INSERT INTO `dw_user_right` VALUES ('699', '15', '1');
INSERT INTO `dw_user_right` VALUES ('700', '17', '1');
INSERT INTO `dw_user_right` VALUES ('701', '18', '1');
INSERT INTO `dw_user_right` VALUES ('702', '19', '1');
INSERT INTO `dw_user_right` VALUES ('703', '20', '1');
INSERT INTO `dw_user_right` VALUES ('704', '21', '1');
INSERT INTO `dw_user_right` VALUES ('705', '22', '1');
INSERT INTO `dw_user_right` VALUES ('706', '23', '1');
INSERT INTO `dw_user_right` VALUES ('707', '24', '1');
INSERT INTO `dw_user_right` VALUES ('708', '25', '1');
INSERT INTO `dw_user_right` VALUES ('735', '4', '11');
INSERT INTO `dw_user_right` VALUES ('736', '5', '11');
INSERT INTO `dw_user_right` VALUES ('737', '6', '11');
INSERT INTO `dw_user_right` VALUES ('738', '7', '11');
INSERT INTO `dw_user_right` VALUES ('739', '8', '11');
INSERT INTO `dw_user_right` VALUES ('740', '76', '11');
INSERT INTO `dw_user_right` VALUES ('741', '77', '11');
INSERT INTO `dw_user_right` VALUES ('742', '78', '11');
INSERT INTO `dw_user_right` VALUES ('743', '9', '11');
INSERT INTO `dw_user_right` VALUES ('744', '10', '11');
INSERT INTO `dw_user_right` VALUES ('745', '11', '11');
INSERT INTO `dw_user_right` VALUES ('746', '12', '11');
INSERT INTO `dw_user_right` VALUES ('747', '13', '11');
INSERT INTO `dw_user_right` VALUES ('748', '14', '11');
INSERT INTO `dw_user_right` VALUES ('749', '15', '11');
INSERT INTO `dw_user_right` VALUES ('750', '79', '11');
INSERT INTO `dw_user_right` VALUES ('751', '17', '11');
INSERT INTO `dw_user_right` VALUES ('752', '18', '11');
INSERT INTO `dw_user_right` VALUES ('753', '19', '11');
INSERT INTO `dw_user_right` VALUES ('754', '20', '11');
INSERT INTO `dw_user_right` VALUES ('755', '22', '11');

-- ----------------------------
-- Table structure for `dw_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `dw_user_role`;
CREATE TABLE `dw_user_role` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '角色名称',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '显示状态，0显示，1不显示',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `pid` varchar(1024) NOT NULL COMMENT '权限id（多个权限用逗号隔开）如果是0为超级管理员',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='角色';

-- ----------------------------
-- Records of dw_user_role
-- ----------------------------
INSERT INTO `dw_user_role` VALUES ('1', 'Administrator', '1', '1', '0');
INSERT INTO `dw_user_role` VALUES ('11', 'cccc', '0', '0', '');

-- ----------------------------
-- View structure for `dw_viewseach`
-- ----------------------------
DROP VIEW IF EXISTS `dw_viewseach`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dw_viewseach` AS select `dw_project`.`id` AS `id`,`dw_project`.`title` AS `title`,_utf8'1' AS `type`,`dw_project`.`company_id` AS `company_id` from `dw_project` where (`dw_project`.`typeid` = 1) union select `dw_project`.`id` AS `id`,`dw_project`.`title` AS `title`,_utf8'2' AS `type`,`dw_project`.`company_id` AS `company_id` from `dw_project` where (`dw_project`.`typeid` = 2) union select `dw_conquer`.`id` AS `id`,`dw_conquer`.`title` AS `title`,_utf8'3' AS `type`,`dw_conquer`.`company_id` AS `company_id` from `dw_conquer` ;
