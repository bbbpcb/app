/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : dewei

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2015-05-13 15:04:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for draw_review
-- ----------------------------
DROP TABLE IF EXISTS `draw_review`;
CREATE TABLE `draw_review` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `proid` int(8) DEFAULT NULL,
  `modid` int(8) DEFAULT NULL,
  `intro` text CHARACTER SET utf8,
  `createtime` int(4) DEFAULT NULL,
  `endtime` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='发起评审';

-- ----------------------------
-- Records of draw_review
-- ----------------------------

-- ----------------------------
-- Table structure for dw_aboutsys
-- ----------------------------
DROP TABLE IF EXISTS `dw_aboutsys`;
CREATE TABLE `dw_aboutsys` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `rank` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_aboutsys
-- ----------------------------
INSERT INTO `dw_aboutsys` VALUES ('2', '级别标准分说明', '有着“超级高铁推销员”和“最强营销总监”等美称的李克强总理，向外方推荐中国高铁几乎成了其出访的必做功课，这同时也体现了中国政府对高铁走向国际市场的决心和信心。', '1');
INSERT INTO `dw_aboutsys` VALUES ('3', '任务积分说明', '据《中国经济周刊》不完全统计，2014年李克强总理已向12个国家（埃塞俄比亚、尼日利亚、安哥拉、肯尼亚、英国、美国、津巴布韦、俄罗斯、缅甸、哈萨克斯坦、塞尔维亚、泰国）表达了合作建设高铁的意愿。', '2');
INSERT INTO `dw_aboutsys` VALUES ('4', '问题研讨说明', '在中国高端装备制造业遭遇世界经济危机和面临其他国家的激烈竞争之际，高铁的出现成为中国制造转型升级的一大亮点。中国高铁企业频频斩获海外大单，中国南车和中国北车海外订单的连续增长已成为中国高铁开往世界的佐证。两家企业2014年上半年的出口签约额总计已达45亿美元（约合276.3亿元人民币）以上。', '3');

-- ----------------------------
-- Table structure for dw_article
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
INSERT INTO `dw_article` VALUES ('1', '云通讯领域领导企业CTO、资深云计算专家[good]，结合企业生产环境系统，深度揭秘构建千万级、高可靠用户规模PaaS平台的关键技术和经验', '1.1.0', 'http://www.xxx.com', '400-886-9008', 'aboutus');

-- ----------------------------
-- Table structure for dw_conquer
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
  `status` tinyint(2) DEFAULT '0' COMMENT '发布状态，1-正常，0-停止',
  `bestid` int(8) DEFAULT NULL COMMENT '最后回答用户id',
  `endtime` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='复盘表，原来的任职积分';

-- ----------------------------
-- Records of dw_conquer
-- ----------------------------

-- ----------------------------
-- Table structure for dw_conquer_reply
-- ----------------------------
DROP TABLE IF EXISTS `dw_conquer_reply`;
CREATE TABLE `dw_conquer_reply` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) DEFAULT NULL,
  `cid` int(8) DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  `createtime` int(4) DEFAULT NULL,
  `isbest` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_conquer_reply
-- ----------------------------

-- ----------------------------
-- Table structure for dw_department
-- ----------------------------
DROP TABLE IF EXISTS `dw_department`;
CREATE TABLE `dw_department` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_department
-- ----------------------------
INSERT INTO `dw_department` VALUES ('1', '技术部');
INSERT INTO `dw_department` VALUES ('2', '策划部');
INSERT INTO `dw_department` VALUES ('3', '产品部');

-- ----------------------------
-- Table structure for dw_expert
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_expert
-- ----------------------------
INSERT INTO `dw_expert` VALUES ('23', 'admin', '核专家', '13800138001', '13800138000', 'e10adc3949ba59abbe56e057f20f883e', 'default.jpg', '1', '计算机', '', '软件开发', '123123', '1420338649', '1418874703', '797af8031247c24dbcf0c3ec4d4adc37', '127');
INSERT INTO `dw_expert` VALUES ('24', 'litianji', 'IT专家', '13800138000', '13800138000', 'e10adc3949ba59abbe56e057f20f883e', 'default.jpg', '1', 'IT', '', 'it', '据德国媒体《图片报》的消息称，德甲劲旅多特蒙德有意比利时传统豪门安德莱赫特的两大妖星：20岁的丹尼斯-普莱特和17岁的尤里-蒂耶莱曼', null, '1420189365', null, '0');
INSERT INTO `dw_expert` VALUES ('25', 'expert1', '董事长', '13800138000', '13800138000', 'e10adc3949ba59abbe56e057f20f883e', '20150102112638.jpg', '1', 'IT', '', 'it', 'zhuanjia', null, '1420197730', null, '0');

-- ----------------------------
-- Table structure for dw_feedback
-- ----------------------------
DROP TABLE IF EXISTS `dw_feedback`;
CREATE TABLE `dw_feedback` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `createtime` int(4) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_feedback
-- ----------------------------
INSERT INTO `dw_feedback` VALUES ('4', '13', '“南北车合并”的重磅方案，终于抢在2014年年尾——12月30日正式对外公布。我们期待并相信，2015年的中国高铁，强强联合，所向披靡！----', '1420261184', '0');
INSERT INTO `dw_feedback` VALUES ('5', '13', 'content', '1420798783', '0');

-- ----------------------------
-- Table structure for dw_gongshi
-- ----------------------------
DROP TABLE IF EXISTS `dw_gongshi`;
CREATE TABLE `dw_gongshi` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `tags` varchar(60) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_gongshi
-- ----------------------------
INSERT INTO `dw_gongshi` VALUES ('1', 'xing', '5');
INSERT INTO `dw_gongshi` VALUES ('2', 'jisuan', 'g*n-zxt');

-- ----------------------------
-- Table structure for dw_invite
-- ----------------------------
DROP TABLE IF EXISTS `dw_invite`;
CREATE TABLE `dw_invite` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `pid` int(8) DEFAULT NULL COMMENT '项目id',
  `headid` int(8) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '被邀请人回复，0-邀请中，1-同意，2-拒绝',
  `createtime` int(4) DEFAULT NULL COMMENT '创建时间',
  `invite_time` int(4) DEFAULT NULL COMMENT '回复时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_invite
-- ----------------------------
INSERT INTO `dw_invite` VALUES ('12', '12', '34', '0', '1428717145', null);
INSERT INTO `dw_invite` VALUES ('13', '13', '35', '0', '1428717633', null);

-- ----------------------------
-- Table structure for dw_lead
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_lead
-- ----------------------------
INSERT INTO `dw_lead` VALUES ('23', 'admin', '核专家', '13800138001', '13800138000', 'e10adc3949ba59abbe56e057f20f883e', 'default.jpg', '1', '计算机', '', '软件开发', '123123', null, '1418874703', null, '127');
INSERT INTO `dw_lead` VALUES ('24', 'litianji', 'IT专家', '13800138000', '13800138000', 'e10adc3949ba59abbe56e057f20f883e', 'default.jpg', '1', 'IT', '', 'it', '据德国媒体《图片报》的消息称，德甲劲旅多特蒙德有意比利时传统豪门安德莱赫特的两大妖星：20岁的丹尼斯-普莱特和17岁的尤里-蒂耶莱曼', null, '1420189365', null, '0');
INSERT INTO `dw_lead` VALUES ('25', 'expert1', '董事长', '13800138000', '13800138000', 'e10adc3949ba59abbe56e057f20f883e', '20150102112638.jpg', '1', 'IT', '', 'it', 'zhuanjia', null, '1420197730', null, '0');

-- ----------------------------
-- Table structure for dw_member
-- ----------------------------
DROP TABLE IF EXISTS `dw_member`;
CREATE TABLE `dw_member` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) DEFAULT NULL COMMENT '用户名',
  `realname` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `check_mobile` varchar(20) DEFAULT NULL COMMENT '核实电话号码',
  `passwd` varchar(200) DEFAULT NULL COMMENT '密码',
  `gender` tinyint(1) DEFAULT '0' COMMENT '性别，1-男，2-女',
  `email` varchar(80) DEFAULT NULL COMMENT '邮箱',
  `headerurl` varchar(120) DEFAULT NULL,
  `depid` varchar(60) CHARACTER SET utf8 DEFAULT NULL COMMENT '部门id',
  `company` varchar(60) CHARACTER SET utf8 DEFAULT NULL COMMENT '单位',
  `position` varchar(60) CHARACTER SET utf8 DEFAULT NULL COMMENT '职位',
  `profession` varchar(80) CHARACTER SET utf8 DEFAULT NULL COMMENT '专业',
  `industry` varchar(80) CHARACTER SET utf8 DEFAULT NULL COMMENT '行业',
  `intro` text CHARACTER SET utf8 COMMENT '简介',
  `total` int(4) DEFAULT '0' COMMENT '总积分',
  `roleid` int(4) DEFAULT '0' COMMENT '角色，1-员工，2-专家，3-领导',
  `lastlogin` int(8) DEFAULT NULL COMMENT '最后登录时间',
  `createtime` int(8) DEFAULT NULL COMMENT '创建时间',
  `token` varchar(80) DEFAULT NULL COMMENT 'token',
  `enabled` tinyint(2) DEFAULT '0' COMMENT '帐号状态，0-不可用，1-正常使用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1 COMMENT='会员表';

-- ----------------------------
-- Records of dw_member
-- ----------------------------
INSERT INTO `dw_member` VALUES ('33', null, '员工一', '13800138000', null, 'e10adc3949ba59abbe56e057f20f883e', '0', null, null, '技术部', '公司一', null, null, null, null, '0', '1', '1428716620', '1428716299', '0a1a0456601843f3a014fb45ea031fb3', '0');
INSERT INTO `dw_member` VALUES ('34', null, '专家一', '13800138001', null, 'e10adc3949ba59abbe56e057f20f883e', '0', null, null, 'it', '公司一', null, null, null, null, '0', '2', null, '1428716426', '347cedcaf405718313cd9468ae72dd2c', '0');
INSERT INTO `dw_member` VALUES ('35', null, '领导一', '13800138002', null, 'e10adc3949ba59abbe56e057f20f883e', '0', null, null, '管理', '公司一', null, null, null, null, '0', '3', null, '1428716533', '688a59bece76657d04d45bf69bcb6226', '0');

-- ----------------------------
-- Table structure for dw_member_ex
-- ----------------------------
DROP TABLE IF EXISTS `dw_member_ex`;
CREATE TABLE `dw_member_ex` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) NOT NULL,
  `exid` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_member_ex
-- ----------------------------

-- ----------------------------
-- Table structure for dw_member_task
-- ----------------------------
DROP TABLE IF EXISTS `dw_member_task`;
CREATE TABLE `dw_member_task` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) NOT NULL COMMENT '领取用户id',
  `taskid` int(8) NOT NULL COMMENT '任务id',
  `modid` int(8) NOT NULL COMMENT '模块id',
  `projectid` int(8) NOT NULL COMMENT '项目id',
  `roleid` tinyint(4) NOT NULL COMMENT '领取任务的角色',
  `createtime` int(4) NOT NULL COMMENT '领取时间',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `total` int(4) NOT NULL DEFAULT '0' COMMENT '分数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='会员领取任务表';

-- ----------------------------
-- Records of dw_member_task
-- ----------------------------

-- ----------------------------
-- Table structure for dw_mod
-- ----------------------------
DROP TABLE IF EXISTS `dw_mod`;
CREATE TABLE `dw_mod` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `m_name` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '模块名称',
  `rank` int(4) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_mod
-- ----------------------------
INSERT INTO `dw_mod` VALUES ('10', '模块二', '2');
INSERT INTO `dw_mod` VALUES ('11', '模块一', '1');
INSERT INTO `dw_mod` VALUES ('12', '模块三', '3');
INSERT INTO `dw_mod` VALUES ('13', '模块四', '4');
INSERT INTO `dw_mod` VALUES ('14', '其它模块', '6');
INSERT INTO `dw_mod` VALUES ('15', '模块五', '5');

-- ----------------------------
-- Table structure for dw_opinion
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
-- Table structure for dw_pics
-- ----------------------------
DROP TABLE IF EXISTS `dw_pics`;
CREATE TABLE `dw_pics` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `typeid` tinyint(3) DEFAULT '0' COMMENT '图片类型，1-重大项目，2-基础项目，3-复盘，4-任务',
  `nandu` int(4) DEFAULT '0' COMMENT '难度',
  `picname` varchar(120) DEFAULT NULL COMMENT '图片名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='图片资源表';

-- ----------------------------
-- Records of dw_pics
-- ----------------------------
INSERT INTO `dw_pics` VALUES ('1', '1', '2', '20150415104858.png');
INSERT INTO `dw_pics` VALUES ('2', '2', '2', '20150415105102.jpg');
INSERT INTO `dw_pics` VALUES ('4', '3', '5', '20150415110618.jpg');
INSERT INTO `dw_pics` VALUES ('5', '4', '5', '20150415110701.jpg');

-- ----------------------------
-- Table structure for dw_project
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
  `status` tinyint(2) DEFAULT '0' COMMENT '项目状态,0-关闭，1-进行中，2-延时，3,-结束',
  `rank` int(4) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_project
-- ----------------------------
INSERT INTO `dw_project` VALUES ('12', '33', null, '34', '1', '3', '4', '3', '5', '0', '个人创建项目一', '项目说明', null, '1428717145', '0', '0');
INSERT INTO `dw_project` VALUES ('13', '33', null, '35', '2', '3', '4', '3', '5', '0', '个人创建基础项目', '基础项目描述', null, '1428717633', '0', '0');

-- ----------------------------
-- Table structure for dw_project_bak
-- ----------------------------
DROP TABLE IF EXISTS `dw_project_bak`;
CREATE TABLE `dw_project_bak` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) DEFAULT NULL COMMENT '创建人id',
  `headid` int(8) DEFAULT NULL COMMENT '负责人id',
  `typeid` tinyint(2) DEFAULT '0' COMMENT '项目类型，1-重大项目，2-基础项目',
  `scale` int(4) DEFAULT '0' COMMENT '规模',
  `difficulty` int(4) DEFAULT '0' COMMENT '难度',
  `quality` int(4) DEFAULT '0' COMMENT '质量',
  `features` int(4) DEFAULT '0' COMMENT '特性',
  `review` tinyint(2) DEFAULT '0' COMMENT '审核状态，0-待审核，1-评审中，2-已评审,3-进行中，4-延时，5-已结束',
  `title` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '项目标题',
  `intro` text CHARACTER SET utf8,
  `icon` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `createtime` int(4) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '项目状态,0-关闭，1-正常',
  `rank` int(4) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_project_bak
-- ----------------------------
INSERT INTO `dw_project_bak` VALUES ('26', '13', '21', '1', '3', '4', '3', '5', '0', '个人创建项目', null, null, '1425436476', '0', '0');
INSERT INTO `dw_project_bak` VALUES ('27', '13', '21', '1', '3', '4', '3', '5', '0', '个人创建项目', null, null, '1425436572', '0', '0');
INSERT INTO `dw_project_bak` VALUES ('28', '13', '21', '1', '3', '4', '3', '5', '0', '个人创建项目', null, null, '1425436743', '0', '0');
INSERT INTO `dw_project_bak` VALUES ('29', '13', '21', '1', '3', '4', '3', '5', '0', '个人创建项目', null, null, '1425436831', '0', '0');
INSERT INTO `dw_project_bak` VALUES ('30', '13', '21', '1', '3', '4', '3', '5', '0', '个人创建项目', null, null, '1425436850', '0', '0');
INSERT INTO `dw_project_bak` VALUES ('31', '13', '21', '1', '3', '4', '3', '5', '0', '个人创建项目', null, null, '1425436867', '0', '0');

-- ----------------------------
-- Table structure for dw_project_type
-- ----------------------------
DROP TABLE IF EXISTS `dw_project_type`;
CREATE TABLE `dw_project_type` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_project_type
-- ----------------------------
INSERT INTO `dw_project_type` VALUES ('1', '开放型');
INSERT INTO `dw_project_type` VALUES ('2', '内部型');

-- ----------------------------
-- Table structure for dw_question
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
-- Table structure for dw_question_reply
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
-- Table structure for dw_replay_type
-- ----------------------------
DROP TABLE IF EXISTS `dw_replay_type`;
CREATE TABLE `dw_replay_type` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `rank` int(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_replay_type
-- ----------------------------
INSERT INTO `dw_replay_type` VALUES ('1', '复盘类型一', '0');
INSERT INTO `dw_replay_type` VALUES ('2', '复盘类型二', '0');
INSERT INTO `dw_replay_type` VALUES ('3', '复盘类型三', '1');
INSERT INTO `dw_replay_type` VALUES ('4', '复盘类型四', '2');
INSERT INTO `dw_replay_type` VALUES ('6', '复盘类型五', '5');

-- ----------------------------
-- Table structure for dw_review
-- ----------------------------
DROP TABLE IF EXISTS `dw_review`;
CREATE TABLE `dw_review` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mid` int(8) DEFAULT NULL COMMENT '创建者id',
  `proid` int(8) DEFAULT NULL,
  `modid` int(8) DEFAULT NULL,
  `intro` text CHARACTER SET utf8,
  `endtime` int(4) DEFAULT NULL,
  `createtime` int(4) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '评审状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='项目评审表';

-- ----------------------------
-- Records of dw_review
-- ----------------------------
INSERT INTO `dw_review` VALUES ('5', '33', '12', '10', 'intro', '1436392800', '1429857115', '0');

-- ----------------------------
-- Table structure for dw_review_question
-- ----------------------------
DROP TABLE IF EXISTS `dw_review_question`;
CREATE TABLE `dw_review_question` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `revid` int(8) DEFAULT NULL COMMENT '评审id',
  `revtitle` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `revintro` text CHARACTER SET utf8 COMMENT '会议内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COMMENT='评审题目';

-- ----------------------------
-- Records of dw_review_question
-- ----------------------------
INSERT INTO `dw_review_question` VALUES ('13', '5', null, 'question-1');
INSERT INTO `dw_review_question` VALUES ('14', '5', null, 'question-2');
INSERT INTO `dw_review_question` VALUES ('15', '5', null, 'question-3');

-- ----------------------------
-- Table structure for dw_review_question_feedback
-- ----------------------------
DROP TABLE IF EXISTS `dw_review_question_feedback`;
CREATE TABLE `dw_review_question_feedback` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `revid` int(8) DEFAULT NULL COMMENT '审批项目id，对应dw_review的id',
  `questionid` int(8) DEFAULT NULL COMMENT '审批问题id',
  `mid` int(8) DEFAULT NULL COMMENT '审批用户id',
  `grade` int(4) DEFAULT '0' COMMENT '审批分数',
  `createtime` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='用户审批结果表';

-- ----------------------------
-- Records of dw_review_question_feedback
-- ----------------------------
INSERT INTO `dw_review_question_feedback` VALUES ('3', '1', '1', '1', '1', '1429864531');
INSERT INTO `dw_review_question_feedback` VALUES ('4', '1', '2', '1', '2', '1429864531');
INSERT INTO `dw_review_question_feedback` VALUES ('5', '1', '1', '1', '1', '1429864580');
INSERT INTO `dw_review_question_feedback` VALUES ('6', '1', '2', '1', '2', '1429864580');

-- ----------------------------
-- Table structure for dw_review_staff
-- ----------------------------
DROP TABLE IF EXISTS `dw_review_staff`;
CREATE TABLE `dw_review_staff` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `revid` int(8) DEFAULT NULL,
  `mid` int(8) DEFAULT NULL,
  `grade` int(2) DEFAULT '0',
  `createtime` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COMMENT='评选人员';

-- ----------------------------
-- Records of dw_review_staff
-- ----------------------------
INSERT INTO `dw_review_staff` VALUES ('17', '5', '34', '0', '1429857116');
INSERT INTO `dw_review_staff` VALUES ('18', '5', '35', '0', '1429857116');

-- ----------------------------
-- Table structure for dw_task
-- ----------------------------
DROP TABLE IF EXISTS `dw_task`;
CREATE TABLE `dw_task` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `modid` int(8) DEFAULT NULL COMMENT '模块id',
  `proid` int(8) DEFAULT NULL COMMENT '项目id',
  `task_type` int(8) DEFAULT NULL COMMENT '任务类型',
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
  `status` tinyint(1) DEFAULT '0' COMMENT '0-关闭，1-进行中，2-延时，3,-结束',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task
-- ----------------------------
INSERT INTO `dw_task` VALUES ('25', '1', '1', '2', 'title', 'intro', null, '2', '3', '4', '5', '22', '1429155979', '0', '0');
INSERT INTO `dw_task` VALUES ('26', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429155979', '0', '0');
INSERT INTO `dw_task` VALUES ('27', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429156021', '0', '0');
INSERT INTO `dw_task` VALUES ('28', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429156021', '0', '0');
INSERT INTO `dw_task` VALUES ('29', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429156055', '0', '0');
INSERT INTO `dw_task` VALUES ('30', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429156135', '0', '0');
INSERT INTO `dw_task` VALUES ('31', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429156135', '0', '0');
INSERT INTO `dw_task` VALUES ('32', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429156556', '0', '0');
INSERT INTO `dw_task` VALUES ('33', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429156556', '0', '0');
INSERT INTO `dw_task` VALUES ('34', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429157112', '0', '0');
INSERT INTO `dw_task` VALUES ('35', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429157112', '0', '0');
INSERT INTO `dw_task` VALUES ('36', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429163151', '0', '0');
INSERT INTO `dw_task` VALUES ('37', '1', '1', '2', 'ttttt', 'asfasfasdf', null, '2', '3', '4', '5', '22', '1429163151', '0', '0');

-- ----------------------------
-- Table structure for dw_task_fansi
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_fansi
-- ----------------------------

-- ----------------------------
-- Table structure for dw_task_plan
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_plan`;
CREATE TABLE `dw_task_plan` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `taskid` int(8) NOT NULL,
  `mid` int(8) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `createtime` int(4) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_plan
-- ----------------------------

-- ----------------------------
-- Table structure for dw_task_plan_reply
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_plan_reply`;
CREATE TABLE `dw_task_plan_reply` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `planid` int(8) NOT NULL,
  `exid` int(8) NOT NULL COMMENT '专家id',
  `content` text CHARACTER SET utf8 NOT NULL,
  `createtime` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_plan_reply
-- ----------------------------

-- ----------------------------
-- Table structure for dw_task_type
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_type`;
CREATE TABLE `dw_task_type` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `rank` int(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_type
-- ----------------------------
INSERT INTO `dw_task_type` VALUES ('1', '类型三', '0');
INSERT INTO `dw_task_type` VALUES ('2', '类型二', '0');
INSERT INTO `dw_task_type` VALUES ('3', '类型一', '1');

-- ----------------------------
-- Table structure for dw_task_wenti
-- ----------------------------
DROP TABLE IF EXISTS `dw_task_wenti`;
CREATE TABLE `dw_task_wenti` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `taskid` int(8) NOT NULL,
  `mid` int(8) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `createtime` int(4) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dw_task_wenti
-- ----------------------------

-- ----------------------------
-- Table structure for dw_trouble
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
-- Table structure for dw_user
-- ----------------------------
DROP TABLE IF EXISTS `dw_user`;
CREATE TABLE `dw_user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `pwd` varchar(120) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `createtime` varchar(35) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dw_user
-- ----------------------------
INSERT INTO `dw_user` VALUES ('8', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'test@163.com', '');
