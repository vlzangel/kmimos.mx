/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : kmimos_mg_est

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-04-20 13:09:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `list_subscribe`
-- ----------------------------
DROP TABLE IF EXISTS `list_subscribe`;
CREATE TABLE `list_subscribe` (
  `source` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of list_subscribe
-- ----------------------------
INSERT INTO `list_subscribe` VALUES ('kmimos-animados', '1@sdfg.com', '2017-04-20 11:53:35', '1');
INSERT INTO `list_subscribe` VALUES ('kmimos-animados', 'asdfadsf@dddsd.com', '2017-04-20 11:40:57', '2');
INSERT INTO `list_subscribe` VALUES ('kmimos-animados', 'conect@asd.com', '2017-04-20 11:59:37', '3');
INSERT INTO `list_subscribe` VALUES ('kmimos-animados', 'conect@assd.com', '2017-04-20 12:01:08', '4');
INSERT INTO `list_subscribe` VALUES ('kmimos-animados', 'ialo@sdf.com', '2017-04-20 11:39:13', '5');
INSERT INTO `list_subscribe` VALUES ('kmimos-animados', 'italo@kmimos.la', '2017-04-20 12:02:29', '6');
INSERT INTO `list_subscribe` VALUES ('kmimos-animados', 'italo@ksmimos.la', '2017-04-20 11:42:03', '7');
INSERT INTO `list_subscribe` VALUES ('kmimos-animados', 'ultima@prueba.com', '2017-04-20 11:37:11', '8');
