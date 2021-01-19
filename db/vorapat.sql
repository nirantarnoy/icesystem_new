/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : vorapat

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-01-19 20:12:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `addressbook`
-- ----------------------------
DROP TABLE IF EXISTS `addressbook`;
CREATE TABLE `addressbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` int(11) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `address_type_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_address` (`company_id`),
  KEY `fk_branch_address` (`branch_id`),
  CONSTRAINT `fk_branch_address` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_address` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of addressbook
-- ----------------------------

-- ----------------------------
-- Table structure for `branch`
-- ----------------------------
DROP TABLE IF EXISTS `branch`;
CREATE TABLE `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company` (`company_id`),
  CONSTRAINT `fk_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of branch
-- ----------------------------
INSERT INTO `branch` VALUES ('1', '1', 'B01', 'สาขา 1', '', '', '1', '1607428129', '1610769258', null, null, 'dfdfd');
INSERT INTO `branch` VALUES ('2', '1', 'B02', 'สาขา 2', 'dffd', null, '1', '1608950566', '1610767185', null, null, 'xxx');

-- ----------------------------
-- Table structure for `car`
-- ----------------------------
DROP TABLE IF EXISTS `car`;
CREATE TABLE `car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `car_type_id` int(11) DEFAULT NULL,
  `plate_number` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `sale_group_id` int(11) DEFAULT NULL,
  `sale_com_id` int(11) DEFAULT NULL,
  `sale_com_extra` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_car` (`company_id`),
  KEY `fk_branch_car` (`branch_id`),
  CONSTRAINT `fk_branch_car` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_car` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of car
-- ----------------------------
INSERT INTO `car` VALUES ('2', 'Car02', 'Car02', 'Car02', '1', '', '', '1', null, null, '1610685481', '1610727562', null, null, '2', '1', '1');
INSERT INTO `car` VALUES ('3', 'Car03', 'Car03', 'Car03', '1', '5สบ5798', '', '1', null, null, '1610718137', '1610727573', null, null, '1', '1', '1');

-- ----------------------------
-- Table structure for `car_emp`
-- ----------------------------
DROP TABLE IF EXISTS `car_emp`;
CREATE TABLE `car_emp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of car_emp
-- ----------------------------
INSERT INTO `car_emp` VALUES ('1', '2', '1', '1');
INSERT INTO `car_emp` VALUES ('2', '2', '5', '1');
INSERT INTO `car_emp` VALUES ('3', '1', '8', '1');
INSERT INTO `car_emp` VALUES ('4', '1', '11', '1');
INSERT INTO `car_emp` VALUES ('5', '1', '13', '1');
INSERT INTO `car_emp` VALUES ('6', '1', '17', '1');
INSERT INTO `car_emp` VALUES ('7', '1', '19', '1');
INSERT INTO `car_emp` VALUES ('8', '2', '33', '1');
INSERT INTO `car_emp` VALUES ('9', '2', '7', '1');
INSERT INTO `car_emp` VALUES ('12', '3', '3', '1');
INSERT INTO `car_emp` VALUES ('13', '3', '4', '1');

-- ----------------------------
-- Table structure for `car_type`
-- ----------------------------
DROP TABLE IF EXISTS `car_type`;
CREATE TABLE `car_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_car_type` (`company_id`),
  KEY `fk_branch_car_type` (`branch_id`),
  CONSTRAINT `fk_branch_car_type` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_car_type` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of car_type
-- ----------------------------
INSERT INTO `car_type` VALUES ('1', 'ปิกอัพ', 'ปิกอัพ', 'ปิกอัพ', '1', null, null, '1608953515', '1608953803', null, null);

-- ----------------------------
-- Table structure for `company`
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `engname` varchar(255) DEFAULT NULL,
  `taxid` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('1', 'Vorapat', 'วรภัทรไอซ์', 'Vorapat Ice', '2222222222222', '', '1607417726', '1610769475', '1', '1', null, '1', 'dfdfddfdf');

-- ----------------------------
-- Table structure for `contacts`
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_type` int(11) DEFAULT NULL,
  `contact_detail` varchar(255) DEFAULT NULL,
  `is_primary` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_contact` (`company_id`),
  KEY `fk_branch_contact` (`branch_id`),
  CONSTRAINT `fk_branch_contact` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_contact` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacts
-- ----------------------------

-- ----------------------------
-- Table structure for `customer`
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `customer_group_id` int(11) DEFAULT NULL,
  `location_info` varchar(255) DEFAULT NULL,
  `delivery_route_id` int(11) DEFAULT NULL,
  `active_date` datetime DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `shop_photo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `customer_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_customer` (`company_id`),
  KEY `fk_branch_customer` (`branch_id`),
  CONSTRAINT `fk_branch_customer` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_customer` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2250 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES ('1126', 'VP07022', 'พะเนียงแตก', 'พะเนียงแตก', '1', '', '2', null, null, '', '1', null, null, '1610022023', '1610358863', null, null, '', '2');
INSERT INTO `customer` VALUES ('1127', 'VP07035', 'เจ้ขวัญ', 'เจ้ขวัญ', '1', '', null, null, null, '', '1', null, null, '1610022023', '1610118933', null, null, 'M62-23', '2');
INSERT INTO `customer` VALUES ('1128', 'VP10001', 'เอกโชห่วย 1', 'เอกโชห่วย 1', null, 'คุณพัชรี', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, 'M62-33,S61-65', null);
INSERT INTO `customer` VALUES ('1129', 'VP10005', 'เจ้ปู ของชำ', 'เจ้ปู ของชำ', null, 'คุณจำเริญ', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, 'E63-12,M61-03', null);
INSERT INTO `customer` VALUES ('1130', 'VP07054', 'ป้าแอ๊ด', 'ป้าแอ๊ด', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1131', 'VP14000', 'ขายสด', 'ขายสด', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1132', 'VP14001', 'ร้านน้ำปั่น รร. โดม 1', 'ร้านน้ำปั่น รร. โดม 1', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1133', 'VP14002', 'ร้านกาแฟ รร. โดม 1', 'ร้านกาแฟ รร. โดม 1', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1134', 'VP14003', 'ร้านก๋วยเตี๋ยว รร. โดม 1', 'ร้านก๋วยเตี๋ยว รร. โดม 1', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1135', 'VP14004', 'ร้านข้าวหมูแดง รร. โดม 1', 'ร้านข้าวหมูแดง รร. โดม 1', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1136', 'VP14005', 'ร้านข้าวแกง โดม 1 รร.', 'ร้านข้าวแกง โดม 1 รร.', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1137', 'VP14006', 'ร้านผลไม้ โดม 1 รร.', 'ร้านผลไม้ โดม 1 รร.', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1138', 'VP14007', 'ร้านน้ำพี่พล โดม 2 รร.', 'ร้านน้ำพี่พล โดม 2 รร.', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1139', 'VP14008', 'ร้านสเต็ก โดม 2 รร.', 'ร้านสเต็ก โดม 2 รร.', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1140', 'VP14009', 'ร้านน้ำ โดม 2 รร.', 'ร้านน้ำ โดม 2 รร.', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1141', 'VP14010', 'ร้านก๋วยเตี๋ยว โดม 2 รร.', 'ร้านก๋วยเตี๋ยว โดม 2 รร.', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1142', 'VP14011', 'ร้านข้าวแกง โดม 2 รร.', 'ร้านข้าวแกง โดม 2 รร.', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1143', 'VP14012', 'ร้านข้าวมันไก่ โดม 2 รร.', 'ร้านข้าวมันไก่ โดม 2 รร.', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1144', 'VP14013', 'ตึกครัว ร.ร. สารสาสน์', 'ตึกครัว ร.ร. สารสาสน์', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1145', 'VP14014', 'ร้านข้าวแกงปักษ์ใต้ 1', 'ร้านข้าวแกงปักษ์ใต้ 1', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1146', 'VP14015', 'ร้านป้าเล็ก (หลักชัย)', 'ร้านป้าเล็ก (หลักชัย)', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1147', 'VP14016', 'ร้านนายน้ำ', 'ร้านนายน้ำ', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1148', 'VP14017', 'ร้านข้าวแกงปักษ์ใต้ 2', 'ร้านข้าวแกงปักษ์ใต้ 2', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1149', 'VP14018', 'ร้านป้าหมึก', 'ร้านป้าหมึก', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1150', 'VP14019', 'ร้านป้าหนู', 'ร้านป้าหนู', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1151', 'VP14020', 'ร้านป้าตุ๋ม', 'ร้านป้าตุ๋ม', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1152', 'VP14021', 'สรัลการเกษตร', 'สรัลการเกษตร', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1153', 'VP14022', 'ร้านพี่นก', 'ร้านพี่นก', null, '', null, null, null, null, '1', null, null, '1610022023', '1610022023', null, null, '', null);
INSERT INTO `customer` VALUES ('1154', 'VP14023', 'ตามสั่งสุดซอย', 'ตามสั่งสุดซอย', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1155', 'VP14024', 'ร้านข้าวเหนียวหมู', 'ร้านข้าวเหนียวหมู', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1156', 'VP14025', 'ร้านเจ้อ้อย', 'ร้านเจ้อ้อย', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1157', 'VP14026', 'ชาชะเอม', 'ชาชะเอม', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1158', 'VP14027', 'ไก่ย่างวิเชียรบุรี', 'ไก่ย่างวิเชียรบุรี', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1159', 'VP14028', 'ร้านน้ำมะพร้าว ปากทางสะแกราย', 'ร้านน้ำมะพร้าว ปากทางสะแกราย', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1160', 'VP14029', 'ร้านสัมพันธ์ วันยันค่ำ', 'ร้านสัมพันธ์ วันยันค่ำ', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1161', 'VP14030', 'ร้านมาลัย คอฟฟี่ ช๊อบ', 'ร้านมาลัย คอฟฟี่ ช๊อบ', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1162', 'VP14031', 'ร้านตามสั่งพี่ฝ้าย', 'ร้านตามสั่งพี่ฝ้าย', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1163', 'VP14032', 'โรงอาหาร ร.ร.วัดตากแดด', 'โรงอาหาร ร.ร.วัดตากแดด', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1164', 'VP14033', 'ร้านค้าพี่เอ็กซ์', 'ร้านค้าพี่เอ็กซ์', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1165', 'VP14034', 'ร้านส้มตำ ป๋าสั่งลุย', 'ร้านส้มตำ ป๋าสั่งลุย', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1166', 'VP14035', 'ร้านก๋วยเตี๋ยว เจ้ฟ้า', 'ร้านก๋วยเตี๋ยว เจ้ฟ้า', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1167', 'VP14036', 'ร้านน้ำช่างไก่', 'ร้านน้ำช่างไก่', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1168', 'VP14037', 'ร้านโกยง เป็ดพะโล้', 'ร้านโกยง เป็ดพะโล้', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1169', 'VP14038', 'ร้านมะพร้าว บ้านเจ้าคุณปู่', 'ร้านมะพร้าว บ้านเจ้าคุณปู่', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1170', 'VP14039', 'ร้านมะพร้าวน้ำหอม', 'ร้านมะพร้าวน้ำหอม', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1171', 'VP14040', 'ร้านตามสั่งพี่ชัย', 'ร้านตามสั่งพี่ชัย', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1172', 'VP14041', 'ร้านส้มตำป้าขาว', 'ร้านส้มตำป้าขาว', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1173', 'VP14042', 'ร้านส้มตำพี่ตุ๊ก ข้าง ม.', 'ร้านส้มตำพี่ตุ๊ก ข้าง ม.', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1174', 'VP14043', 'ร้านก๋วยเตี๋ยวพี่จิ๋ม ข้าง ม.', 'ร้านก๋วยเตี๋ยวพี่จิ๋ม ข้าง ม.', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1175', 'VP14044', 'ร้านส้มตำซาดิสต์', 'ร้านส้มตำซาดิสต์', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1176', 'VP14045', 'ล้านตณทำกิน', 'ล้านตณทำกิน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1177', 'VP14046', 'ร้านก๋วยเตี๋ยวพี่เปิ้ล', 'ร้านก๋วยเตี๋ยวพี่เปิ้ล', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1178', 'VP14047', 'ร้านค้าป้าลี', 'ร้านค้าป้าลี', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1179', 'VP14048', 'บ้านยายจุ๊น', 'บ้านยายจุ๊น', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1180', 'VP14049', 'ร้านค้าพี่ไก่', 'ร้านค้าพี่ไก่', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1181', 'VP14050', 'บ้านป้าพร', 'บ้านป้าพร', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1182', 'VP14051', 'บ้านขายผลไม้ (ขายหน้า ม.)', 'บ้านขายผลไม้ (ขายหน้า ม.)', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1183', 'VP14052', 'ร้านค้าวัดดอนขนาก', 'ร้านค้าวัดดอนขนาก', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1184', 'VP14053', 'ร้านน้ำเจ๊หน่อย หน้าวัดดอนขนาก', 'ร้านน้ำเจ๊หน่อย หน้าวัดดอนขนาก', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1185', 'VP14054', 'บ้านพี่นกขายยำ (ขายหน้า ม.)', 'บ้านพี่นกขายยำ (ขายหน้า ม.)', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1186', 'VP14055', 'ร้านป้าปลา ข้าง ม.', 'ร้านป้าปลา ข้าง ม.', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1187', 'VP14056', 'ร้านส้มตำพี่นุช ข้าง ม.', 'ร้านส้มตำพี่นุช ข้าง ม.', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1188', 'VP14057', 'ร้านน้ำชาพะยอม ข้างม.', 'ร้านน้ำชาพะยอม ข้างม.', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1189', 'VP14058', 'ตามสั่งเจ้เพลา', 'ตามสั่งเจ้เพลา', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1190', 'VP14059', 'ร้านฟลุ๊คบะหมี่ ตรงข้ามวันดอน', 'ร้านฟลุ๊คบะหมี่ ตรงข้ามวันดอน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1191', 'VP14060', 'ร้านตามสั่งน้าบุญ', 'ร้านตามสั่งน้าบุญ', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1192', 'VP14061', 'ร้านชายิ้ม', 'ร้านชายิ้ม', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1193', 'VP14062', 'ร้านตามสั้ง ครัวต้นข้าว', 'ร้านตามสั้ง ครัวต้นข้าว', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1194', 'VP14063', 'ร้านทุกอย่าง 20 บาท', 'ร้านทุกอย่าง 20 บาท', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1195', 'VP14064', 'ร้านสตาร์ทบาร์', 'ร้านสตาร์ทบาร์', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1196', 'VP14065', 'ร้านน้ำพี่ทิพ ใน ม.คริสเตียน', 'ร้านน้ำพี่ทิพ ใน ม.คริสเตียน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1197', 'VP14066', 'ร้านป้าแก้ว ใน ม.คริสเตียน', 'ร้านป้าแก้ว ใน ม.คริสเตียน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1198', 'VP14067', 'ร้านสุขส่งยิ้ม', 'ร้านสุขส่งยิ้ม', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1199', 'VP14068', 'โรงงานแก้ว', 'โรงงานแก้ว', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1200', 'VP14069', 'บ้านนายก', 'บ้านนายก', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1201', 'VP14070', 'บ้านลุงจอน', 'บ้านลุงจอน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1202', 'VP14071', 'บ้านพี่ตู (ขายหน้า ม.ยำ)', 'บ้านพี่ตู (ขายหน้า ม.ยำ)', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1203', 'VP15001', 'ตามสั่งป้าอ้อย', 'ตามสั่งป้าอ้อย', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1204', 'VP15002', 'ร้านป้าถิ่น', 'ร้านป้าถิ่น', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1205', 'VP15003', 'ร้านพี่หมวย', 'ร้านพี่หมวย', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1206', 'VP15004', 'ร้านตามสั่งลุงอุดม', 'ร้านตามสั่งลุงอุดม', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1207', 'VP15005', 'ร้านพี่กาเหว่า', 'ร้านพี่กาเหว่า', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1208', 'VP15006', 'ร้านค้าชุมชน', 'ร้านค้าชุมชน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1209', 'VP15007', 'ร้านน้ำพี่เรือน', 'ร้านน้ำพี่เรือน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1210', 'VP15008', 'ตามสั่งลุงเขียด', 'ตามสั่งลุงเขียด', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1211', 'VP15009', 'ร้านเจ๊หมู', 'ร้านเจ๊หมู', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1212', 'VP15010', 'ร้านป้าเล็ก', 'ร้านป้าเล็ก', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1213', 'VP15011', 'ร้านป้าใจ', 'ร้านป้าใจ', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1214', 'VP15012', 'บ้านคอสะพาน โคกพระ', 'บ้านคอสะพาน โคกพระ', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1215', 'VP15013', 'ร้านลุงสัน', 'ร้านลุงสัน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1216', 'VP15014', 'ร้านน้ำแข็งใส โคกพระ', 'ร้านน้ำแข็งใส โคกพระ', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1217', 'VP15015', 'ร้านลุงชื่น', 'ร้านลุงชื่น', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1218', 'VP15016', 'ร้านป้าสวงค์', 'ร้านป้าสวงค์', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1219', 'VP15017', 'ร้านพี่ไก่', 'ร้านพี่ไก่', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1220', 'VP15018', 'ร้านพี่เด่น', 'ร้านพี่เด่น', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1221', 'VP15019', 'ร้านพี่เริด โคกพระ', 'ร้านพี่เริด โคกพระ', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1222', 'VP15020', 'ก๋วยเตี๋ยวพี่แนน', 'ก๋วยเตี๋ยวพี่แนน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1223', 'VP15021', 'ข้าวแกงในซอย', 'ข้าวแกงในซอย', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1224', 'VP15022', 'ของชำลุงเป้', 'ของชำลุงเป้', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1225', 'VP15023', 'ร้านลุงดม ซอย2', 'ร้านลุงดม ซอย2', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1226', 'VP15024', 'ร้านป้าเปลว', 'ร้านป้าเปลว', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1227', 'VP15025', 'ร้านพี่ลัก', 'ร้านพี่ลัก', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1228', 'VP15026', 'หมูปิ้ง ซ.อัสสัม', 'หมูปิ้ง ซ.อัสสัม', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1229', 'VP15027', 'ร้านค้าในวัด', 'ร้านค้าในวัด', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1230', 'VP15028', 'ของชำป้าสุนีย์', 'ของชำป้าสุนีย์', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1231', 'VP15029', 'มะม่วงคู่', 'มะม่วงคู่', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1232', 'VP15030', 'ข้าวแกงน้องเดียร์', 'ข้าวแกงน้องเดียร์', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1233', 'VP15031', 'ร้านสเต๊ก ม.คริสเตียน', 'ร้านสเต๊ก ม.คริสเตียน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1234', 'VP15032', 'ร้านน้ำ ใน ม.คริสเตียน', 'ร้านน้ำ ใน ม.คริสเตียน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1235', 'VP15033', 'ร้านส้มตำ น้องปาล์ม ครุเงิน', 'ร้านส้มตำ น้องปาล์ม ครุเงิน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1236', 'VP15034', 'ร้านกาแฟ พี่ส้ม', 'ร้านกาแฟ พี่ส้ม', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1237', 'VP15035', 'ของชำเจ๊ปราณี', 'ของชำเจ๊ปราณี', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1238', 'VP15036', 'ร้านกาแฟพี่แหม่ม', 'ร้านกาแฟพี่แหม่ม', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1239', 'VP15037', 'ร้านของชำหลังวัด เปาวลา', 'ร้านของชำหลังวัด เปาวลา', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1240', 'VP15038', 'เตี๋ยวเรือ ปตท', 'เตี๋ยวเรือ ปตท', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1241', 'VP15039', 'ร้านมะพร้าว', 'ร้านมะพร้าว', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1242', 'VP15040', 'ร้านน้ำแข็งใส อัสสัม', 'ร้านน้ำแข็งใส อัสสัม', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1243', 'VP15041', 'ร้านไก่ย่าง', 'ร้านไก่ย่าง', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1244', 'VP15042', 'สะพานครุเงิน', 'สะพานครุเงิน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1245', 'VP15043', 'ครัวคุณยาย', 'ครัวคุณยาย', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1246', 'VP15044', 'ร้านกาแฟ อัสสัม', 'ร้านกาแฟ อัสสัม', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1247', 'VP15045', 'ร้านค้าไพโรจน์ เสมา ซ.2', 'ร้านค้าไพโรจน์ เสมา ซ.2', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1248', 'VP14072', 'ร้านผลไม้', 'ร้านผลไม้', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1249', 'VP09097', 'สตรีท P2', 'สตรีท P2', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1250', 'VP15046', 'ร้านอาหารตามสั่ง', 'ร้านอาหารตามสั่ง', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1251', 'VP15047', 'ร้านส้มตำ', 'ร้านส้มตำ', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1252', 'VP15048', 'ก๋วยเตี๋ยวเรือ', 'ก๋วยเตี๋ยวเรือ', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1253', 'VP15049', 'ไก่ย่างวิเชียร', 'ไก่ย่างวิเชียร', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1254', 'VP15050', 'อาหารตามสั่ง', 'อาหารตามสั่ง', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1255', 'VP15051', 'ร้านน้ำเล่จัง', 'ร้านน้ำเล่จัง', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1256', 'VP14073', 'ร้านเครป โดม 1', 'ร้านเครป โดม 1', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1257', 'VP15052', 'ร้านกล้วยทอด', 'ร้านกล้วยทอด', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1258', 'VP15053', 'ร้านค้า', 'ร้านค้า', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1259', 'VP15055', 'อาหารตามสั่งพี่หน่อย', 'อาหารตามสั่งพี่หน่อย', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1260', 'VP15057', 'ก่อสร้าง', 'ก่อสร้าง', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1261', 'VP14075', 'ร้านป้าณี', 'ร้านป้าณี', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1262', 'VP15058', 'พี่นุ่นขายลูกชิ้น', 'พี่นุ่นขายลูกชิ้น', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1263', 'VP14076', 'ร้านยำลูกชิ้น', 'ร้านยำลูกชิ้น', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1264', 'VP15059', 'บ้านมะขาม', 'บ้านมะขาม', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1265', 'VP15060', 'ร้านพี่ปลา', 'ร้านพี่ปลา', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1266', 'VP09012', 'F-one วจ. @ 16', 'F-one วจ. @ 16', null, 'คุณนฤมล', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'C62-07,C63-07', null);
INSERT INTO `customer` VALUES ('1267', 'VP13019', 'F-One', 'F-One', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1268', 'VP06026', 'ของชำ ทบ. VP6', 'ของชำ ทบ. VP6', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'C63-03', null);
INSERT INTO `customer` VALUES ('1269', 'VP06029', 'ของชำ 3ควายเผือก', 'ของชำ 3ควายเผือก', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'C62-09', null);
INSERT INTO `customer` VALUES ('1270', 'VP02079', 'ร้านข้าวไข่เจียว ป้าแอ๊ว', 'ร้านข้าวไข่เจียว ป้าแอ๊ว', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'A63-93', null);
INSERT INTO `customer` VALUES ('1271', 'VP02080', 'ร้านหมาล่า พี่ฟิวส์', 'ร้านหมาล่า พี่ฟิวส์', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '-', null);
INSERT INTO `customer` VALUES ('1272', 'VP02081', 'ร้านข้าวมันไก่', 'ร้านข้าวมันไก่', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'A62-05 (1L)', null);
INSERT INTO `customer` VALUES ('1273', 'VP02082', 'สวนอาหารบ้านเป็ด', 'สวนอาหารบ้านเป็ด', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'xxxx', null);
INSERT INTO `customer` VALUES ('1274', 'VP02083', 'ร้านส้มตำ อ้วน', 'ร้านส้มตำ อ้วน', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'A62-14', null);
INSERT INTO `customer` VALUES ('1275', 'VP02084', 'ร้านก๋วยเตี๋ยวพี่โน๊ต', 'ร้านก๋วยเตี๋ยวพี่โน๊ต', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '-', null);
INSERT INTO `customer` VALUES ('1276', 'VP06001', 'ชาแบมบูร์', 'ชาแบมบูร์', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'S61-61', null);
INSERT INTO `customer` VALUES ('1277', 'VP06002', 'นิ้ว', 'นิ้ว', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'S61-47', null);
INSERT INTO `customer` VALUES ('1278', 'VP06003', 'อาหารตามสั่ง พี่สุ', 'อาหารตามสั่ง พี่สุ', null, 'คุณสุ', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1279', 'VP06004', 'ข้าวหมูแดง VP6', 'ข้าวหมูแดง VP6', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'A62-18', null);
INSERT INTO `customer` VALUES ('1280', 'VP06005', 'ชาพะยอม (บพ.) VP6', 'ชาพะยอม (บพ.) VP6', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1281', 'VP06006', 'ของชำ (บพ.) VP6', 'ของชำ (บพ.) VP6', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1282', 'VP06007', 'ขนมจีบบ่อพลับ', 'ขนมจีบบ่อพลับ', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1283', 'VP06008', 'ส้มตำบ่อพลับ', 'ส้มตำบ่อพลับ', null, 'คุณสมศักดิ์', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'S61-01,S62-118', null);
INSERT INTO `customer` VALUES ('1284', 'VP06009', 'กาแฟ 28', 'กาแฟ 28', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1285', 'VP06010', 'กาแฟเฌอค่าเฟ่', 'กาแฟเฌอค่าเฟ่', null, '', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, '', null);
INSERT INTO `customer` VALUES ('1286', 'VP06011', 'กาแฟเมคอะมิ้น', 'กาแฟเมคอะมิ้น', null, 'คุณอลงกรณ์', null, null, null, null, '1', null, null, '1610022024', '1610022024', null, null, 'A62-72', null);
INSERT INTO `customer` VALUES ('1287', 'VP06012', 'ชารินริน R', 'ชารินริน R', null, 'คุณพิไลวรรณ', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'M61-06,13', null);
INSERT INTO `customer` VALUES ('1288', 'VP06013', 'กาแฟดอยช้าง', 'กาแฟดอยช้าง', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1289', 'VP06014', 'ชาม', 'ชาม', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1290', 'VP06015', 'ขนมจีนคุณแบงค์', 'ขนมจีนคุณแบงค์', null, 'คุณแบงค์', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1291', 'VP06016', 'น้ำ VP6 ริเวอร์', 'น้ำ VP6 ริเวอร์', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1292', 'VP06017', 'กาแฟคามุ นฐ', 'กาแฟคามุ นฐ', null, 'คุณรัชนี', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S61-08,50', null);
INSERT INTO `customer` VALUES ('1293', 'VP06018', 'ขนมจีนคามุ', 'ขนมจีนคามุ', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1294', 'VP06019', 'วนิลาสกาย', 'วนิลาสกาย', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1295', 'VP06020', 'ชานมบุพเฟ่', 'ชานมบุพเฟ่', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1296', 'VP06021', 'ส้มตำ ซ.5 VP6', 'ส้มตำ ซ.5 VP6', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1297', 'VP06022', 'กาแฟสด +K VP6', 'กาแฟสด +K VP6', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1298', 'VP06023', 'ชากูรูโรตี', 'ชากูรูโรตี', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1299', 'VP06024', 'ก๋วยเตี๊ยว ซ.8 VP6', 'ก๋วยเตี๊ยว ซ.8 VP6', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1300', 'VP06025', 'ชาพะยอม ทบ. VP6', 'ชาพะยอม ทบ. VP6', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1301', 'VP06027', 'ขนมจีนเจ้เจี๊ยบ+K', 'ขนมจีนเจ้เจี๊ยบ+K', null, 'คุณเจี๊ยบ', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1302', 'VP06028', 'ไก่อบโอ่ง+ส้มตำ VP6', 'ไก่อบโอ่ง+ส้มตำ VP6', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A61-10,S61-22', null);
INSERT INTO `customer` VALUES ('1303', 'VP06032', 'มะพร้าวปั่น (บพ.) VP6', 'มะพร้าวปั่น (บพ.) VP6', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1304', 'VP06033', 'ของชำ เปรมยุดา', 'ของชำ เปรมยุดา', null, 'คุณเปรมยุดา', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'C63-02,S61-19', null);
INSERT INTO `customer` VALUES ('1305', 'VP06034', 'กาแฟ นภัสวรรณ', 'กาแฟ นภัสวรรณ', null, 'คุณนภัสวรรณ', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S61-23', null);
INSERT INTO `customer` VALUES ('1306', 'VP06035', 'ชาย 4 หมี่เกี้ยว ฟลุ๊ค', 'ชาย 4 หมี่เกี้ยว ฟลุ๊ค', null, 'คุณฟลุ๊ค', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S61-36', null);
INSERT INTO `customer` VALUES ('1307', 'VP06036', 'ป้าหมวย VP6', 'ป้าหมวย VP6', null, 'คุณหมวย', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1308', 'VP06037', 'เชฟตุ๋ยซี่โครง', 'เชฟตุ๋ยซี่โครง', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S62-96,99', null);
INSERT INTO `customer` VALUES ('1309', 'VP06038', 'ก๋วยเตี๊ยวเป็ด VP6', 'ก๋วยเตี๊ยวเป็ด VP6', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1310', 'VP06039', 'ไข่เจียว กัญวาลักษณ์', 'ไข่เจียว กัญวาลักษณ์', null, 'คุณกัญวาลักษณ์', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S62-82', null);
INSERT INTO `customer` VALUES ('1311', 'VP06040', 'โรงไฟฟ้า', 'โรงไฟฟ้า', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1312', 'VP06041', 'ก๋วยเตี๋ยวเนื้อ VP6', 'ก๋วยเตี๋ยวเนื้อ VP6', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1313', 'VP06042', 'มะพร้าวปั่น ซ.8 VP6', 'มะพร้าวปั่น ซ.8 VP6', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1314', 'VP06043', 'ราชมรรคา [P2] VP6', 'ราชมรรคา [P2] VP6', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1315', 'VP06044', 'นัดของชำ [P2] VP6', 'นัดของชำ [P2] VP6', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1316', 'VP06045', 'ตามใจสั่ง', 'ตามใจสั่ง', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1317', 'VP06046', 'พอใจก๋วยเตี๋ยว', 'พอใจก๋วยเตี๋ยว', null, 'คุณสุมาลี', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-73,S62-185', null);
INSERT INTO `customer` VALUES ('1318', 'VP06047', 'น้ำ วีรนาพร', 'น้ำ วีรนาพร', null, 'คุณบี๋', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1319', 'VP06048', 'แนท VP6', 'แนท VP6', null, 'คุณแนท', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1320', 'VP06049', 'โตราดหน้า', 'โตราดหน้า', null, 'คุณก้อย', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1321', 'VP06050', 'พี่วรรณ ตามสั่ง', 'พี่วรรณ ตามสั่ง', null, 'คุณศรีวัล', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-63', null);
INSERT INTO `customer` VALUES ('1322', 'VP06051', 'ข้าวมันไก่องค์พระ วีรกิตต์', 'ข้าวมันไก่องค์พระ วีรกิตต์', null, 'คุณวีรกิต', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'C62-05', null);
INSERT INTO `customer` VALUES ('1323', 'VP06052', 'บิ้วตี้ช็อป', 'บิ้วตี้ช็อป', null, 'คุณฐิติมน', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A63-28', null);
INSERT INTO `customer` VALUES ('1324', 'VP06053', 'อินเตอร์หม้อไฟ', 'อินเตอร์หม้อไฟ', null, 'คุณหน่อย', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-79', null);
INSERT INTO `customer` VALUES ('1325', 'VP06054', 'น้ำชงพี่อ้อย', 'น้ำชงพี่อ้อย', null, 'คุณสุวรรณี', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S63-93', null);
INSERT INTO `customer` VALUES ('1326', 'VP06055', 'เย็นตาโฟทะเลเดือด', 'เย็นตาโฟทะเลเดือด', null, 'คุณฉัตรมงคล', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A63-59,S61-28', null);
INSERT INTO `customer` VALUES ('1327', 'VP07026', 'ลาบเจ้แต๋ว', 'ลาบเจ้แต๋ว', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1328', 'VP07027', 'ลาบเมืองพล', 'ลาบเมืองพล', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1329', 'VP07028', 'ร้านน้ำพี่หมี', 'ร้านน้ำพี่หมี', null, 'คุณยวน', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1330', 'VP07032', 'ป้าสมบูรณ์', 'ป้าสมบูรณ์', null, 'คุณแก่', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1331', 'VP07037', 'ซีเจ', 'ซีเจ', null, 'คุณเรณู', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1332', 'VP07038', 'ป้าแมว', 'ป้าแมว', null, 'คุณมิ้งมด', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1333', 'VP07039', 'สุกีวาริน', 'สุกีวาริน', null, 'คุณรุ่งทิพย์', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1334', 'VP07042', 'บาร์สระบัว', 'บาร์สระบัว', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1335', 'VP07043', 'แซ่บบุรี', 'แซ่บบุรี', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'M62-73,S62-173', null);
INSERT INTO `customer` VALUES ('1336', 'VP07044', 'แพ็ค-บ้านแพ้ว', 'แพ็ค-บ้านแพ้ว', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1337', 'VP07045', 'แพ็ค-หลังเวล', 'แพ็ค-หลังเวล', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1338', 'VP07046', 'แพ็ค-อรพรรณ', 'แพ็ค-อรพรรณ', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1339', 'VP07047', 'ตำนัวณัฐชา', 'ตำนัวณัฐชา', null, 'คุณณัฐชา', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1340', 'VP07048', 'Bun [Lotus]', 'Bun [Lotus]', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1341', 'VP07050', 'ไก่ย่างห้าดาว พี่เมตตา', 'ไก่ย่างห้าดาว พี่เมตตา', null, 'คุณเมตตา', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A63-05', null);
INSERT INTO `customer` VALUES ('1342', 'VP07051', 'ชานม โลตัส', 'ชานม โลตัส', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A63-49', null);
INSERT INTO `customer` VALUES ('1343', 'VP07052', 'เบียร์โซไซตี้', 'เบียร์โซไซตี้', null, 'คุณพิชญ์พงศ์', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A63-58', null);
INSERT INTO `customer` VALUES ('1344', 'VP08001', 'ข้าวแกงจับกัง', 'ข้าวแกงจับกัง', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A61-01', null);
INSERT INTO `customer` VALUES ('1345', 'VP08002', 'โฟโคตรเครื่อง คุณเป้า', 'โฟโคตรเครื่อง คุณเป้า', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S62-219', null);
INSERT INTO `customer` VALUES ('1346', 'VP08003', 'PT กม.13', 'PT กม.13', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1347', 'VP08004', 'สหกรณ์โคนม นฐ', 'สหกรณ์โคนม นฐ', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1348', 'VP08005', 'เป็ดพะโล้ กม.17', 'เป็ดพะโล้ กม.17', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S61-36,M62-38', null);
INSERT INTO `customer` VALUES ('1349', 'VP08007', 'PT สาขา 00491', 'PT สาขา 00491', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1350', 'VP08009', 'SC2336 อเมซอน ม.เกษตร กพส.', 'SC2336 อเมซอน ม.เกษตร กพส.', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S62-211', null);
INSERT INTO `customer` VALUES ('1351', 'VP08010', 'ถังชา ม.เกษตร นพคุณ', 'ถังชา ม.เกษตร นพคุณ', null, 'คุณนพคุณ', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'M62-70', null);
INSERT INTO `customer` VALUES ('1352', 'VP08011', 'PT สาขา 00454', 'PT สาขา 00454', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1353', 'VP08014', 'PT สาขา 01561', 'PT สาขา 01561', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1354', 'VP08015', 'PT สาขา 00196', 'PT สาขา 00196', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1355', 'VP08016', 'กาแฟดอนตูม', 'กาแฟดอนตูม', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1356', 'VP08017', 'ป.ปลาผัดไท', 'ป.ปลาผัดไท', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A61-46,S61-49', null);
INSERT INTO `customer` VALUES ('1357', 'VP08018', 'ก๋วยเตี๋ยว พรจรินทร์', 'ก๋วยเตี๋ยว พรจรินทร์', null, 'คุณพรจรินทร์', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S61-26,S62-254', null);
INSERT INTO `customer` VALUES ('1358', 'VP08019', 'BOBA TEA', 'BOBA TEA', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1359', 'VP08020', 'ฟิตเนส', 'ฟิตเนส', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1360', 'VP08022', 'ข้าวมันไก่ กายแก้ว', 'ข้าวมันไก่ กายแก้ว', null, 'คุณกายแก้ว', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S61-45,S62-91', null);
INSERT INTO `customer` VALUES ('1361', 'VP08023', 'เจ๊ทิพย์อาหารตามสั่ง VP8', 'เจ๊ทิพย์อาหารตามสั่ง VP8', null, 'คุณทิพย์', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A61-21S62-95', null);
INSERT INTO `customer` VALUES ('1362', 'VP08024', 'ก๋วยเตี๋ยวเรืออยุธยา ช่างอาร์ต', 'ก๋วยเตี๋ยวเรืออยุธยา ช่างอาร์ต', null, 'คุณอาร์ต', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1363', 'VP08025', 'OTOP', 'OTOP', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A63-15', null);
INSERT INTO `customer` VALUES ('1364', 'VP08027', 'โกเด้ง ปรียาเนตร', 'โกเด้ง ปรียาเนตร', null, 'คุณปรียาเนตร', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S62-172,174', null);
INSERT INTO `customer` VALUES ('1365', 'VP08028', 'ศรีวิบูลย์ คาเฟ่', 'ศรีวิบูลย์ คาเฟ่', null, 'คุณหอม', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'C62-03', null);
INSERT INTO `customer` VALUES ('1366', 'VP08029', 'โรงหมู', 'โรงหมู', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1367', 'VP08030', 'ไร่อติภา', 'ไร่อติภา', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1368', 'VP08031', 'ปั๊มซัสโก้', 'ปั๊มซัสโก้', null, 'คุณมะตูม', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1369', 'VP08032', 'ของชำ 7แยก สมถวิล', 'ของชำ 7แยก สมถวิล', null, 'คุณสมถวิล', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A63-30', null);
INSERT INTO `customer` VALUES ('1370', 'VP08035', 'เตี๋ยวบ้านร่มฟ้า', 'เตี๋ยวบ้านร่มฟ้า', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1371', 'VP08036', 'หมี่เกี๊ยว พี่กัน', 'หมี่เกี๊ยว พี่กัน', null, 'คุณกัน', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1372', 'VP08037', 'น้ำส้มพิกุล', 'น้ำส้มพิกุล', null, 'คุณพิกุล', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1373', 'VP01085', 'ไก่ย่าง', 'ไก่ย่าง', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'xxxx', null);
INSERT INTO `customer` VALUES ('1374', 'VP06056', 'ร้านกาแฟพี่หญิง', 'ร้านกาแฟพี่หญิง', null, 'กมลชนก', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1375', 'VP06057', 'ก๋วยเตี๋ยวซ.5', 'ก๋วยเตี๋ยวซ.5', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1376', 'VP06058', 'อุ๊ ผักสด', 'อุ๊ ผักสด', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1377', 'VP06059', 'เจ๊นุช ของชำ', 'เจ๊นุช ของชำ', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1378', 'VP08038', 'อาหารตามสั่งร่มฟ้า', 'อาหารตามสั่งร่มฟ้า', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1379', 'VP08045', 'PT สาขา 01864', 'PT สาขา 01864', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1380', 'VP09063', 'ขายนอก', 'ขายนอก', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1381', 'VP11046', 'Lotus หนองโพ', 'Lotus หนองโพ', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1382', 'VP11047', 'Lotus หัวโพ', 'Lotus หัวโพ', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1383', 'VP13027', 'ลาบร้อยเอ็ด7', 'ลาบร้อยเอ็ด7', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1384', 'VP08053', 'ซีเจ ตรีสุข', 'ซีเจ ตรีสุข', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1385', 'VP08054', 'PT สาขา 01834', 'PT สาขา 01834', null, '', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, '', null);
INSERT INTO `customer` VALUES ('1386', 'VP01001', 'กาแฟ แอน', 'กาแฟ แอน', null, 'คุณมยุรา', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-12', null);
INSERT INTO `customer` VALUES ('1387', 'VP01002', 'ของชำ ป้าจำเนียร', 'ของชำ ป้าจำเนียร', null, 'คุณจำเนียร', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-112', null);
INSERT INTO `customer` VALUES ('1388', 'VP01003', 'ของชำ เฉลา', 'ของชำ เฉลา', null, 'คุณเฉลา', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1389', 'VP01004', 'ครัวคุณเย็น', 'ครัวคุณเย็น', null, 'คุณธัญชนา', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S62-212', null);
INSERT INTO `customer` VALUES ('1390', 'VP01005', 'อาหารป่า เจี๊ยบ', 'อาหารป่า เจี๊ยบ', null, 'คุณอัครโยธิน', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-04 S62-164', null);
INSERT INTO `customer` VALUES ('1391', 'VP01006', 'ของชำ เจ๊ดวงใจ', 'ของชำ เจ๊ดวงใจ', null, 'คุณดวงใจ', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-30', null);
INSERT INTO `customer` VALUES ('1392', 'VP01007', 'อาหารเจ พี่ลูกจันทร์', 'อาหารเจ พี่ลูกจันทร์', null, 'คุณบังอร', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-57', null);
INSERT INTO `customer` VALUES ('1393', 'VP01008', 'อาหารตามสั่งกาญ พี่ดำ', 'อาหารตามสั่งกาญ พี่ดำ', null, 'คุณดำ', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1394', 'VP01009', 'ชาไข่มุก The Again', 'ชาไข่มุก The Again', null, 'คุณดุสิต', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-46', null);
INSERT INTO `customer` VALUES ('1395', 'VP01010', 'ของชำ ป้านิด VP1', 'ของชำ ป้านิด VP1', null, 'คุณสุดใจ', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1396', 'VP01011', 'ก๋วยเตี๋ยว สุภาพร', 'ก๋วยเตี๋ยว สุภาพร', null, 'คุณสุภาพร', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S62-107', null);
INSERT INTO `customer` VALUES ('1397', 'VP01012', 'ก๋วยเตี๋ยว ป้าเด้', 'ก๋วยเตี๋ยว ป้าเด้', null, 'คุณรัฐนัน', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-01', null);
INSERT INTO `customer` VALUES ('1398', 'VP01013', 'ขายน้ำ บุญศิริ', 'ขายน้ำ บุญศิริ', null, 'คุณบุญสิริ', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-07S63-59', null);
INSERT INTO `customer` VALUES ('1399', 'VP01014', 'อาหารตามสั่ง พี่นิด VP1', 'อาหารตามสั่ง พี่นิด VP1', null, 'คุณมยุรี', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S62-206', null);
INSERT INTO `customer` VALUES ('1400', 'VP01015', 'ส้มตำขอนแก่น พี่สำ', 'ส้มตำขอนแก่น พี่สำ', null, 'คุณปิยะ', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-25', null);
INSERT INTO `customer` VALUES ('1401', 'VP01016', 'กาแฟ Jardin de chaisri', 'กาแฟ Jardin de chaisri', null, 'คุณณัชชา', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'M62-41', null);
INSERT INTO `customer` VALUES ('1402', 'VP01017', 'อาหารตามสั่ง ป้าอู๊ด VP1', 'อาหารตามสั่ง ป้าอู๊ด VP1', null, 'คุณปราณี', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A61-02', null);
INSERT INTO `customer` VALUES ('1403', 'VP01018', 'อาหารตามสั่ง พี่บี', 'อาหารตามสั่ง พี่บี', null, 'คุณจักกฤษ', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S62-258', null);
INSERT INTO `customer` VALUES ('1404', 'VP01019', 'ไก่ทอด คมสันต์', 'ไก่ทอด คมสันต์', null, 'คุณคมสันต์', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-38', null);
INSERT INTO `customer` VALUES ('1405', 'VP01020', 'กาแฟ ลุงระยอง', 'กาแฟ ลุงระยอง', null, 'คุณระยอง', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-15', null);
INSERT INTO `customer` VALUES ('1406', 'VP01021', 'อาหารตามสั่ง น้องเพลง', 'อาหารตามสั่ง น้องเพลง', null, 'คุณเสี่ยมเกียว', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-62 , A62-53 (1L)', null);
INSERT INTO `customer` VALUES ('1407', 'VP01022', 'น้ำแข็งใส ป้าจุก', 'น้ำแข็งใส ป้าจุก', null, 'คุณสมควร', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-02', null);
INSERT INTO `customer` VALUES ('1408', 'VP01023', 'ส้มตำ เจ๊ทุเรียน', 'ส้มตำ เจ๊ทุเรียน', null, 'คุณทุเรียน', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1409', 'VP01024', 'กาแฟบ้านพรแก้ว พี่จิ', 'กาแฟบ้านพรแก้ว พี่จิ', null, 'คุณจิรภาส', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A61-14', null);
INSERT INTO `customer` VALUES ('1410', 'VP01025', 'ฝันของพ่อ พี่เหมียว', 'ฝันของพ่อ พี่เหมียว', null, 'คุณศิริรัตนา', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-10', null);
INSERT INTO `customer` VALUES ('1411', 'VP01026', 'กาแฟโบราณ พี่จุ๋ม', 'กาแฟโบราณ พี่จุ๋ม', null, 'คุณธราธิป', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S62-146', null);
INSERT INTO `customer` VALUES ('1412', 'VP01027', 'น้ำรถ พี่ชบา', 'น้ำรถ พี่ชบา', null, 'คุณสิริรัตน์', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'S62-157', null);
INSERT INTO `customer` VALUES ('1413', 'VP01028', 'อาหารตามสั่ง ป้าปุ๊', 'อาหารตามสั่ง ป้าปุ๊', null, 'คุณกาญจนา', null, null, null, null, '1', null, null, '1610022025', '1610022025', null, null, 'A62-06', null);
INSERT INTO `customer` VALUES ('1414', 'VP01029', 'ขายกล้วยปิ้ง ป้าติ๋ม', 'ขายกล้วยปิ้ง ป้าติ๋ม', null, 'คุณบุญสม', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-152', null);
INSERT INTO `customer` VALUES ('1415', 'VP01030', 'อาหารตามสั่ง พี่ต่าย', 'อาหารตามสั่ง พี่ต่าย', null, 'คุณเกศราภรณ์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-95 ,S61-31', null);
INSERT INTO `customer` VALUES ('1416', 'VP01031', 'ร้านลุงเล็ก VP1', 'ร้านลุงเล็ก VP1', null, 'คุณสุปรีชา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-97', null);
INSERT INTO `customer` VALUES ('1417', 'VP01032', 'ข้าวแกงพี่แอ๋ว', 'ข้าวแกงพี่แอ๋ว', null, 'คุณบัน', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S63-31', null);
INSERT INTO `customer` VALUES ('1418', 'VP01033', 'ข้าวแกง ป้าเกตุ', 'ข้าวแกง ป้าเกตุ', null, 'คุณอภิญญา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-203', null);
INSERT INTO `customer` VALUES ('1419', 'VP01034', 'ขายปลาทู พี่จอย', 'ขายปลาทู พี่จอย', null, 'คุณทองล้วน', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-112', null);
INSERT INTO `customer` VALUES ('1420', 'VP01035', 'อาหารตามสั่ง ป้าภัค', 'อาหารตามสั่ง ป้าภัค', null, 'คุณสิริภัค', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-124', null);
INSERT INTO `customer` VALUES ('1421', 'VP01036', 'ส้มตำ พี่บัน', 'ส้มตำ พี่บัน', null, 'คุณรชยา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1422', 'VP01037', 'น้ำน้องต้า', 'น้ำน้องต้า', null, 'คุณขวัญชนก', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-16', null);
INSERT INTO `customer` VALUES ('1423', 'VP01038', 'ก๋วยเตี๋ยว ป้านิด VP1', 'ก๋วยเตี๋ยว ป้านิด VP1', null, 'คุณธนวรรน', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-20', null);
INSERT INTO `customer` VALUES ('1424', 'VP01039', 'ส้มตำ พี่พร รุ่งกาญต์ VP1', 'ส้มตำ พี่พร รุ่งกาญต์ VP1', null, 'คุณรุ่งกาญต์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-19 S62-159', null);
INSERT INTO `customer` VALUES ('1425', 'VP01040', 'ส้มตำ พี่นัด', 'ส้มตำ พี่นัด', null, 'คุณมานิส', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-235', null);
INSERT INTO `customer` VALUES ('1426', 'VP01041', 'โจ๊กพี่สุ', 'โจ๊กพี่สุ', null, 'คุณสุ', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1427', 'VP01042', 'ส้มตำ ป้าสำรวย', 'ส้มตำ ป้าสำรวย', null, 'คุณสำรวย', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-47', null);
INSERT INTO `customer` VALUES ('1428', 'VP01043', 'อาหารตามสั่ง ลุงสมชาย', 'อาหารตามสั่ง ลุงสมชาย', null, 'คุณสมชาย', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-54', null);
INSERT INTO `customer` VALUES ('1429', 'VP01044', 'อู่ซ่อมรถปรีชายนต์', 'อู่ซ่อมรถปรีชายนต์', null, 'คุณปรีชา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-202', null);
INSERT INTO `customer` VALUES ('1430', 'VP01045', 'อาหารตามสั่ง ป๋าน้อง', 'อาหารตามสั่ง ป๋าน้อง', null, 'คุณบุญเลิศ', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-68', null);
INSERT INTO `customer` VALUES ('1431', 'VP01046', 'อาหารตามสั่ง นะโมกะโฟกัส', 'อาหารตามสั่ง นะโมกะโฟกัส', null, 'คุณบัวหลง', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-223', null);
INSERT INTO `customer` VALUES ('1432', 'VP01047', 'ก๋วยเตี๋ยว ป้านา', 'ก๋วยเตี๋ยว ป้านา', null, 'คุณนา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1433', 'VP01048', 'ของชำ ปรีชา', 'ของชำ ปรีชา', null, 'คุณปรีชา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1434', 'VP01049', 'อู่ซ่อมรถยนต์ พี่เหมียน', 'อู่ซ่อมรถยนต์ พี่เหมียน', null, 'คุณเสมียน', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-26', null);
INSERT INTO `customer` VALUES ('1435', 'VP01050', 'ส้มตำ พี่พร ลำยอง VP1', 'ส้มตำ พี่พร ลำยอง VP1', null, 'คุณลำยอง', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-70', null);
INSERT INTO `customer` VALUES ('1436', 'VP01051', 'ชานมไข่มุก น้องเฟรน', 'ชานมไข่มุก น้องเฟรน', null, 'คุณอโนรัตน์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-260', null);
INSERT INTO `customer` VALUES ('1437', 'VP01052', 'อาหารตามสั่ง เจ๊หญิง', 'อาหารตามสั่ง เจ๊หญิง', null, 'คุณพนิดา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-44', null);
INSERT INTO `customer` VALUES ('1438', 'VP01053', 'ส้มตำ พี่เจี๊ยบ', 'ส้มตำ พี่เจี๊ยบ', null, 'คุณเจี๊ยบ', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-45', null);
INSERT INTO `customer` VALUES ('1439', 'VP01054', 'ร้านลุงอมร VP1', 'ร้านลุงอมร VP1', null, 'คุณอมร', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-34', null);
INSERT INTO `customer` VALUES ('1440', 'VP01055', 'สเต็ก ฟาไส', 'สเต็ก ฟาไส', null, 'คุณสิทธิเดช', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-66', null);
INSERT INTO `customer` VALUES ('1441', 'VP01056', 'อาหารตามสั่ง เจ้พร', 'อาหารตามสั่ง เจ้พร', null, 'คุณณัฐปภัสร์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-17', null);
INSERT INTO `customer` VALUES ('1442', 'VP01057', 'ข้าวแกงปักษ์ใต้ สุรีรัตน์', 'ข้าวแกงปักษ์ใต้ สุรีรัตน์', null, 'คุณสุรีรัตน์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-255', null);
INSERT INTO `customer` VALUES ('1443', 'VP01058', 'ขายน้ำ ป้าติ๋ม', 'ขายน้ำ ป้าติ๋ม', null, 'คุณสุพัตรา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-58 A62-98', null);
INSERT INTO `customer` VALUES ('1444', 'VP01059', 'อาหารตามสั่ง-น้ำ พี่จิ้งหรีด', 'อาหารตามสั่ง-น้ำ พี่จิ้งหรีด', null, 'คุณสุภาวรรณ', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-28', null);
INSERT INTO `customer` VALUES ('1445', 'VP01060', 'ของชำ ป้ามาลี VP1', 'ของชำ ป้ามาลี VP1', null, 'คุณมะลิจันทร์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-56', null);
INSERT INTO `customer` VALUES ('1446', 'VP01061', 'โรงงานพลาสติกคลองโยง', 'โรงงานพลาสติกคลองโยง', null, 'คุณ คุณภัทร', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A63-37', null);
INSERT INTO `customer` VALUES ('1447', 'VP01062', 'ก๋วยเตี๋ยว ป้าสำรวย', 'ก๋วยเตี๋ยว ป้าสำรวย', null, 'คุณสำรวย', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1448', 'VP01063', 'อาหารตามสั่ง ป้าอร', 'อาหารตามสั่ง ป้าอร', null, 'คุณอนงค์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-32', null);
INSERT INTO `customer` VALUES ('1449', 'VP01064', 'ของชำลุงพร (งิ้วราย)', 'ของชำลุงพร (งิ้วราย)', null, 'คุณสมพร', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-41', null);
INSERT INTO `customer` VALUES ('1450', 'VP01065', 'ก๋วยเตี๋ยวเรือ พี่ไอซ์', 'ก๋วยเตี๋ยวเรือ พี่ไอซ์', null, 'คุณไพโรจน์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-78', null);
INSERT INTO `customer` VALUES ('1451', 'VP01066', 'รถขายก๋วยเตี๋ยว คงศักดิ์', 'รถขายก๋วยเตี๋ยว คงศักดิ์', null, 'คุณคงศักดิ์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-208', null);
INSERT INTO `customer` VALUES ('1452', 'VP01067', 'กาแฟ ป้าติ๋ว', 'กาแฟ ป้าติ๋ว', null, 'คุณธนภัทร', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-131', null);
INSERT INTO `customer` VALUES ('1453', 'VP01068', 'ร้านพี่หนูแดง VP1', 'ร้านพี่หนูแดง VP1', null, 'คุณหนูแดง', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1454', 'VP01069', 'ม.พฤกษา8 ซอย12', 'ม.พฤกษา8 ซอย12', null, '', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1455', 'VP01070', 'บ้านสวน ป้านันท์', 'บ้านสวน ป้านันท์', null, 'คุณศิริลักษณ์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S63-22', null);
INSERT INTO `customer` VALUES ('1456', 'VP01071', 'บ้านสวน 3 หลัง พี่ชัย', 'บ้านสวน 3 หลัง พี่ชัย', null, 'คุณวันชัย', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-55', null);
INSERT INTO `customer` VALUES ('1457', 'VP01072', 'ลูกชิ้น นิรันพร', 'ลูกชิ้น นิรันพร', null, 'คุณนิรันพร', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A63-22', null);
INSERT INTO `customer` VALUES ('1458', 'VP01073', 'น้ำ สุธิษา', 'น้ำ สุธิษา', null, 'คุณสุธิษา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A63-34', null);
INSERT INTO `customer` VALUES ('1459', 'VP01074', 'กาแฟรถเข็น ภัทราภรณ์', 'กาแฟรถเข็น ภัทราภรณ์', null, 'คุณภัทราภรณ์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S63-100', null);
INSERT INTO `customer` VALUES ('1460', 'VP01075', 'บ้านสวนป้าแอ็ด', 'บ้านสวนป้าแอ็ด', null, 'คุณโศรยา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A63-27', null);
INSERT INTO `customer` VALUES ('1461', 'VP01076', 'ส้มตำ and ห่อหมกพี่โบว์', 'ส้มตำ and ห่อหมกพี่โบว์', null, 'คุณสุวิมล', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S63-67', null);
INSERT INTO `customer` VALUES ('1462', 'VP01077', 'ลูกชิ้นทอดพี่เป้า', 'ลูกชิ้นทอดพี่เป้า', null, 'คุณเป้า', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1463', 'VP01078', 'ข้าวแกงป้าแดง', 'ข้าวแกงป้าแดง', null, 'คุณศุภสุตา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-71', null);
INSERT INTO `customer` VALUES ('1464', 'VP01079', 'ลุงสาธร VP1', 'ลุงสาธร VP1', null, 'คุณสาธร', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1465', 'VP01080', 'บ้านบารมีสมเด็จ', 'บ้านบารมีสมเด็จ', null, '', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1466', 'VP01081', 'น้ำแข็งใส VP1', 'น้ำแข็งใส VP1', null, '', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1467', 'VP01082', 'ส้มตำ VP1', 'ส้มตำ VP1', null, '', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A63-61', null);
INSERT INTO `customer` VALUES ('1468', 'VP01083', 'ปลาหมึก พี่แบม', 'ปลาหมึก พี่แบม', null, '', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S63-80', null);
INSERT INTO `customer` VALUES ('1469', 'VP02001', 'กาแฟโบราณ 3 ควายเผือก', 'กาแฟโบราณ 3 ควายเผือก', null, '', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-09', null);
INSERT INTO `customer` VALUES ('1470', 'VP02002', 'อาหารตามสั่ง ป้าอู๊ด VP2', 'อาหารตามสั่ง ป้าอู๊ด VP2', null, 'คุณเพ็ญ', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-231', null);
INSERT INTO `customer` VALUES ('1471', 'VP02003', 'อาหารอีสาน ป้าฝอย', 'อาหารอีสาน ป้าฝอย', null, 'คุณฝอย', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1472', 'VP02004', 'ครัวป้าวรรณ', 'ครัวป้าวรรณ', null, 'คุณวรรณวิมล', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'D62-01', null);
INSERT INTO `customer` VALUES ('1473', 'VP02005', 'น้ำปั่นผลไม้พี่โป', 'น้ำปั่นผลไม้พี่โป', null, 'คุณธนกร', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-93', null);
INSERT INTO `customer` VALUES ('1474', 'VP02006', 'อ้วนรสเด็ด', 'อ้วนรสเด็ด', null, 'คุณยุทธศักดิ์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-155', null);
INSERT INTO `customer` VALUES ('1475', 'VP02007', 'อร่อย', 'อร่อย', null, 'คุณวิรินทร์ญา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-134', null);
INSERT INTO `customer` VALUES ('1476', 'VP02008', 'ข้าวขาหมู พี่เอ', 'ข้าวขาหมู พี่เอ', null, 'คุณอรุณี', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-110', null);
INSERT INTO `customer` VALUES ('1477', 'VP02009', 'โจ๊กบางกอก พี่จี้', 'โจ๊กบางกอก พี่จี้', null, 'คุณชฎาณัฐ', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-107', null);
INSERT INTO `customer` VALUES ('1478', 'VP02010', 'อาหารทะเล พี่หนุ่ม', 'อาหารทะเล พี่หนุ่ม', null, 'คุณหนุ่ม', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1479', 'VP02011', 'พวงมาลัยดอกไม้สด', 'พวงมาลัยดอกไม้สด', null, '', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1480', 'VP02012', 'ปูม้าสด พี่หนึ่ง', 'ปูม้าสด พี่หนึ่ง', null, 'คุณหนึ่ง', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1481', 'VP02013', 'ก๋วยเตี๋ยวเป็ดตุ๋นยาจีน ลุงแขก', 'ก๋วยเตี๋ยวเป็ดตุ๋นยาจีน ลุงแขก', null, 'คุณแขก', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-11', null);
INSERT INTO `customer` VALUES ('1482', 'VP02014', 'ไส้กรอกอีสาน คำพลอย', 'ไส้กรอกอีสาน คำพลอย', null, 'คุณคำพลอย', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1483', 'VP02015', 'ของชำ ป้าต้อย VP2', 'ของชำ ป้าต้อย VP2', null, 'คุณมัลลิกา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1484', 'VP02016', 'ส้มตำแซ่บนัว', 'ส้มตำแซ่บนัว', null, 'คุณดรุณี', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-13', null);
INSERT INTO `customer` VALUES ('1485', 'VP02017', 'หม่าล่า นับตัง', 'หม่าล่า นับตัง', null, 'คุณณัฐฐวลัญธ์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-22', null);
INSERT INTO `customer` VALUES ('1486', 'VP02018', 'ของชำ พี่นก วรรณิศา VP2', 'ของชำ พี่นก วรรณิศา VP2', null, 'คุณวรรณิศา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-35', null);
INSERT INTO `customer` VALUES ('1487', 'VP02019', 'ร้านกาแฟสด JAMES COFFEE', 'ร้านกาแฟสด JAMES COFFEE', null, 'คุณสุรีภรณ์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-187', null);
INSERT INTO `customer` VALUES ('1488', 'VP02020', 'อาหารตามสั่ง ป้าสวน', 'อาหารตามสั่ง ป้าสวน', null, 'คุณสวนทิพย์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S63-05', null);
INSERT INTO `customer` VALUES ('1489', 'VP02021', 'ของชำ พี่อร', 'ของชำ พี่อร', null, 'คุณอร', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1490', 'VP02022', 'รวย', 'รวย', null, '', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1491', 'VP02023', 'มะพร้าว พี่ฟ้า', 'มะพร้าว พี่ฟ้า', null, 'คุณพีรนัท', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-86', null);
INSERT INTO `customer` VALUES ('1492', 'VP02024', 'ส้มตำ ป้าแก้ว', 'ส้มตำ ป้าแก้ว', null, 'คุณสุทธิสัน', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-96 A63-29', null);
INSERT INTO `customer` VALUES ('1493', 'VP02025', 'อู่ซ่อมรถกฤษฎาการยาง', 'อู่ซ่อมรถกฤษฎาการยาง', null, 'คุณกฤษฎา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1494', 'VP02026', 'ก๋วยเตี๋ยว พี่โน๊ต', 'ก๋วยเตี๋ยว พี่โน๊ต', null, 'คุณน๊ต', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1495', 'VP02027', 'อาหารตามสั่ง พี่โซ', 'อาหารตามสั่ง พี่โซ', null, 'คุณโซ', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1496', 'VP02028', 'ของชำ พี่เก๋', 'ของชำ พี่เก๋', null, 'คุณศิริรัตน์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-104', null);
INSERT INTO `customer` VALUES ('1497', 'VP02029', 'ไก่ทอดสมุนไพรพี่พร', 'ไก่ทอดสมุนไพรพี่พร', null, 'คุณขวัญชัย', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-104', null);
INSERT INTO `customer` VALUES ('1498', 'VP02030', 'ผลไม้พี่ดาว', 'ผลไม้พี่ดาว', null, 'คุณศิริวัฒนา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-209', null);
INSERT INTO `customer` VALUES ('1499', 'VP02031', 'ก๋วยเตี๋ยว ส้มตำ พี่เยาว์', 'ก๋วยเตี๋ยว ส้มตำ พี่เยาว์', null, 'คุณเยาว์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1500', 'VP02032', 'ข้าวมันไก่ น้ำ พี่อำพัน', 'ข้าวมันไก่ น้ำ พี่อำพัน', null, 'คุณบัวหลั่น', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S63-09', null);
INSERT INTO `customer` VALUES ('1501', 'VP02033', 'โรงงานตะกร้า พี่จิน', 'โรงงานตะกร้า พี่จิน', null, 'คุณจิน', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1502', 'VP02034', 'ป้าแมว VP2', 'ป้าแมว VP2', null, 'คุณพรรณี', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-118', null);
INSERT INTO `customer` VALUES ('1503', 'VP02035', 'อาหารตามสั่ง ครัวพลฤทธิ์', 'อาหารตามสั่ง ครัวพลฤทธิ์', null, 'คุณสัมฤทธิ์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-43', null);
INSERT INTO `customer` VALUES ('1504', 'VP02036', 'โรงงานพ่นสีสแตนเลส พี่เอื้อ', 'โรงงานพ่นสีสแตนเลส พี่เอื้อ', null, 'คุณเอื้อ', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-102', null);
INSERT INTO `customer` VALUES ('1505', 'VP02037', 'ขนมจีนพี่เอ๋', 'ขนมจีนพี่เอ๋', null, 'คุณเอ๋', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1506', 'VP02038', 'กาแฟ พี่อี๊ด', 'กาแฟ พี่อี๊ด', null, 'คุณอี๊ด', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1507', 'VP02039', 'ไก่ย่าง วิเชียรพี่ไพบูลย์', 'ไก่ย่าง วิเชียรพี่ไพบูลย์', null, 'คุณชวน', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-33A62-113', null);
INSERT INTO `customer` VALUES ('1508', 'VP02040', 'หอมกรุ่น ชานมไข่มุก', 'หอมกรุ่น ชานมไข่มุก', null, 'คุณสุวสา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-125', null);
INSERT INTO `customer` VALUES ('1509', 'VP02041', 'ส้มตำ ป้ากุหลาบ', 'ส้มตำ ป้ากุหลาบ', null, 'คุณกุหลาบ', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-114', null);
INSERT INTO `customer` VALUES ('1510', 'VP02042', 'ชาช่า หม่าล่า', 'ชาช่า หม่าล่า', null, 'คุณวสุธิดา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-135 (2L)A62-29(1L)', null);
INSERT INTO `customer` VALUES ('1511', 'VP02043', 'ก๋วยเตี๋ยว พี่โอ๋', 'ก๋วยเตี๋ยว พี่โอ๋', null, 'คุณนฤมล', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-117', null);
INSERT INTO `customer` VALUES ('1512', 'VP02044', 'น้ำปั่น การ์ตูน', 'น้ำปั่น การ์ตูน', null, 'คุณนรีรีตน์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-230', null);
INSERT INTO `customer` VALUES ('1513', 'VP02045', 'ของชำ พี่นก มหามงคล 2 VP2', 'ของชำ พี่นก มหามงคล 2 VP2', null, 'คุณนก', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1514', 'VP02046', 'สลัด น้องเฟีย', 'สลัด น้องเฟีย', null, 'คุณกาญจนา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62- 220', null);
INSERT INTO `customer` VALUES ('1515', 'VP02047', 'ส้มตำ ป้าหวี', 'ส้มตำ ป้าหวี', null, 'คุณฉวี', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-186', null);
INSERT INTO `customer` VALUES ('1516', 'VP02048', 'ข้าวนึ่ง พี่น้อย', 'ข้าวนึ่ง พี่น้อย', null, 'คุณบุญสม', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A61-19', null);
INSERT INTO `customer` VALUES ('1517', 'VP02049', 'กาแฟ พี่อร', 'กาแฟ พี่อร', null, 'คุณอร', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1518', 'VP02050', 'อาหารตามสั่ง พี่หวิว', 'อาหารตามสั่ง พี่หวิว', null, 'คุณมยุรี', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'C62-01S62-222', null);
INSERT INTO `customer` VALUES ('1519', 'VP02051', 'เกี๊ยวทอด', 'เกี๊ยวทอด', null, 'คุณฐิติวรดา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-239', null);
INSERT INTO `customer` VALUES ('1520', 'VP02052', 'ท่าปล่อยรถเมล์สาย 84 ก', 'ท่าปล่อยรถเมล์สาย 84 ก', null, 'คุณกมลรัตน์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1521', 'VP02053', 'ร้านรับปะเปลี่ยนซิป', 'ร้านรับปะเปลี่ยนซิป', null, 'คุณกัญนิกา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-82', null);
INSERT INTO `customer` VALUES ('1522', 'VP02054', 'กาแฟ ตาสว่าง', 'กาแฟ ตาสว่าง', null, '', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1523', 'VP02055', 'หอยทอด ผัดไท', 'หอยทอด ผัดไท', null, 'คุณอิทธิพล', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-148', null);
INSERT INTO `customer` VALUES ('1524', 'VP02056', 'ร้าน ป้าวรรณา', 'ร้าน ป้าวรรณา', null, 'คุณวรรณา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S63-40', null);
INSERT INTO `customer` VALUES ('1525', 'VP02057', 'ส้มตำ น้าหวาน', 'ส้มตำ น้าหวาน', null, 'คุณกฤติกา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-21', null);
INSERT INTO `customer` VALUES ('1526', 'VP02058', 'กาแฟ ชาวดอย', 'กาแฟ ชาวดอย', null, '', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1527', 'VP02059', 'ของชำ พี่แต้', 'ของชำ พี่แต้', null, 'คุณแต้', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1528', 'VP02060', 'นิยมชา', 'นิยมชา', null, '', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1529', 'VP02061', 'ก๋วยเตี๋ยวเรือ รังสิต เจ๊โอ่ง', 'ก๋วยเตี๋ยวเรือ รังสิต เจ๊โอ่ง', null, 'คุณนิชาภา', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A63-23', null);
INSERT INTO `customer` VALUES ('1530', 'VP02062', 'ร้านน้ำ ซ.3 VP2', 'ร้านน้ำ ซ.3 VP2', null, 'คุณดาราวรรณ', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A63-20', null);
INSERT INTO `customer` VALUES ('1531', 'VP02063', 'ส้มตำ ร้อยเอ็ดพี่ไพวัลย์', 'ส้มตำ ร้อยเอ็ดพี่ไพวัลย์', null, 'คุณไพรวัลย์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-64S62-190A63-40', null);
INSERT INTO `customer` VALUES ('1532', 'VP02064', 'อาหารตามสั่ง ทิพย์ VP2', 'อาหารตามสั่ง ทิพย์ VP2', null, 'คุณกัญญาภัทร', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'A62-81,S61-16', null);
INSERT INTO `customer` VALUES ('1533', 'VP02065', 'พุงตุ่ย ก๋วยเตี๋ยวปลา', 'พุงตุ่ย ก๋วยเตี๋ยวปลา', null, 'คุณมาเรียม', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'S62-250S63-27A62-36', null);
INSERT INTO `customer` VALUES ('1534', 'VP02066', 'เพลย์วิทแคท', 'เพลย์วิทแคท', null, 'คุณธนวิโรจน์', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'C63-13', null);
INSERT INTO `customer` VALUES ('1535', 'VP02067', 'อาหารตามสั่ง ป้ามวล', 'อาหารตามสั่ง ป้ามวล', null, 'คุณมวล', null, null, null, null, '1', null, null, '1610022026', '1610022026', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1536', 'VP02068', 'ร้านกระจก VP2', 'ร้านกระจก VP2', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1537', 'VP02069', 'กาแฟ ป้าเล็ก VP2', 'กาแฟ ป้าเล็ก VP2', null, 'คุณเล็ก', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1538', 'VP02070', 'ของชำ พี่วรรณ', 'ของชำ พี่วรรณ', null, 'คุณวรรณ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1539', 'VP02071', 'น้ำโชติกา อาภาพร 2', 'น้ำโชติกา อาภาพร 2', null, 'คุณโชติกา', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-08', null);
INSERT INTO `customer` VALUES ('1540', 'VP02072', 'ก๋วยเตี๋ยว พี่แจ่ม', 'ก๋วยเตี๋ยว พี่แจ่ม', null, 'คุณแจ่ม', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1541', 'VP02073', 'ร้านพี่ไมค์ VP2', 'ร้านพี่ไมค์ VP2', null, 'คุณสุกใส', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-12', null);
INSERT INTO `customer` VALUES ('1542', 'VP02074', 'ข้าวนึ่ง อัศวิน', 'ข้าวนึ่ง อัศวิน', null, 'คุณอนงค์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A63-50', null);
INSERT INTO `customer` VALUES ('1543', 'VP02075', 'คาเฟ่ and รีสอร์ท พี่ต้น', 'คาเฟ่ and รีสอร์ท พี่ต้น', null, 'คุณพิชิต', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-89', null);
INSERT INTO `customer` VALUES ('1544', 'VP02076', 'กาแฟ พี่เล็ก VP2', 'กาแฟ พี่เล็ก VP2', null, 'คุณธิติ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-74', null);
INSERT INTO `customer` VALUES ('1545', 'VP02077', 'น้ำส้มคั้นพี่วรรณ', 'น้ำส้มคั้นพี่วรรณ', null, 'คุณทิพย์วรรณ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-23', null);
INSERT INTO `customer` VALUES ('1546', 'VP02078', 'ร้านน้ำป้าเล็ก ปตท.', 'ร้านน้ำป้าเล็ก ปตท.', null, 'คุณชุลี', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-37', null);
INSERT INTO `customer` VALUES ('1547', 'VP03001', 'ของชำ เจ๊อี๊ด', 'ของชำ เจ๊อี๊ด', null, 'คุณอี๊ด', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1548', 'VP03002', 'ครัวริมบึง', 'ครัวริมบึง', null, 'คุณณัฎฐ์กร', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-229S62-240A62-83S62-197', null);
INSERT INTO `customer` VALUES ('1549', 'VP03003', 'กาแฟ นิตยา', 'กาแฟ นิตยา', null, 'คุณนิตยา', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1550', 'VP03004', 'ส้มโอไทยทวีCoffee พี่ศรี', 'ส้มโอไทยทวีCoffee พี่ศรี', null, 'คุณศศิภา', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-87', null);
INSERT INTO `customer` VALUES ('1551', 'VP03005', 'กาแฟรถเข็น ป้าเริง', 'กาแฟรถเข็น ป้าเริง', null, 'คุณศิริกาญจน์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-242', null);
INSERT INTO `customer` VALUES ('1552', 'VP03006', 'สเต็กแอนด์คาเฟ่ ริเวอร์โซน พี่มล', 'สเต็กแอนด์คาเฟ่ ริเวอร์โซน พี่มล', null, 'คุณวรางรัตน์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-69', null);
INSERT INTO `customer` VALUES ('1553', 'VP03007', 'อาหารตามสั่ง น้ำหวาน', 'อาหารตามสั่ง น้ำหวาน', null, 'คุณธนมาศ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-138,S62-228', null);
INSERT INTO `customer` VALUES ('1554', 'VP03008', 'อาหารตามสั่ง พี่ไก่', 'อาหารตามสั่ง พี่ไก่', null, 'คุณศุภรัน', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-11', null);
INSERT INTO `customer` VALUES ('1555', 'VP03009', 'ส้มตำ สมหมาย', 'ส้มตำ สมหมาย', null, 'คุณสมหมาย', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S61-60 S62-236', null);
INSERT INTO `customer` VALUES ('1556', 'VP03010', 'ของชำ พี่อ้อย', 'ของชำ พี่อ้อย', null, 'คุณฉันทนา', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-16', null);
INSERT INTO `customer` VALUES ('1557', 'VP03011', 'บ้านปลายนา', 'บ้านปลายนา', null, 'คุณพรพิมล', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-205,116,221,139,178,224,218,257,115,160', null);
INSERT INTO `customer` VALUES ('1558', 'VP03012', 'อาหารตามสั่ง แบมแบม', 'อาหารตามสั่ง แบมแบม', null, 'คุณริน', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A61-18', null);
INSERT INTO `customer` VALUES ('1559', 'VP03013', 'คาเฟ่ แม่แมวหมูตุ๋นหอมละมุน', 'คาเฟ่ แม่แมวหมูตุ๋นหอมละมุน', null, 'คุณปุญญนุช', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-39', null);
INSERT INTO `customer` VALUES ('1560', 'VP03014', 'น้ำหวาน ป้ายา', 'น้ำหวาน ป้ายา', null, 'คุณจรินทร์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-144', null);
INSERT INTO `customer` VALUES ('1561', 'VP03015', 'บริษัทขวานทองพิทติ้งจำกัด', 'บริษัทขวานทองพิทติ้งจำกัด', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1562', 'VP03016', 'ก๋วยเตี๋ยว ป้าหญิง', 'ก๋วยเตี๋ยว ป้าหญิง', null, 'คุณสุนีย์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-111 ,114 ,S62-226', null);
INSERT INTO `customer` VALUES ('1563', 'VP03017', 'ลาบศรีษะเกษ สังคม', 'ลาบศรีษะเกษ สังคม', null, 'คุณสังคม', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, '', null);
INSERT INTO `customer` VALUES ('1564', 'VP03018', 'กาแฟ กู๋รัช', 'กาแฟ กู๋รัช', null, 'คุณสายใจ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-45', null);
INSERT INTO `customer` VALUES ('1565', 'VP03019', 'ของชำ ป้าแดง', 'ของชำ ป้าแดง', null, 'คุณธณยศ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-31', null);
INSERT INTO `customer` VALUES ('1566', 'VP03020', 'คาเฟ่น่ารัก', 'คาเฟ่น่ารัก', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1567', 'VP03021', 'ของชำ ยายตุ่ม', 'ของชำ ยายตุ่ม', null, 'คุณตุ่ม', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1568', 'VP03022', 'คาเฟ่กาแฟโบราณ วันเพ็ญ VP3', 'คาเฟ่กาแฟโบราณ วันเพ็ญ VP3', null, 'คุณวันเพ็ญ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-237', null);
INSERT INTO `customer` VALUES ('1569', 'VP03023', 'อาหารตามสั่ง บ้านสวนกัลยา', 'อาหารตามสั่ง บ้านสวนกัลยา', null, 'คุณจงกลรัตน์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-115 M61-20M62-56 S62-198', null);
INSERT INTO `customer` VALUES ('1570', 'VP03024', 'ของชำ ป้าสมจิตร์ VP3', 'ของชำ ป้าสมจิตร์ VP3', null, 'คุณสมจิตน์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-05', null);
INSERT INTO `customer` VALUES ('1571', 'VP03025', 'โจ๊กเห็ดหอม', 'โจ๊กเห็ดหอม', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-10', null);
INSERT INTO `customer` VALUES ('1572', 'VP03026', 'อาหารตามสั่ง ป้าแดง', 'อาหารตามสั่ง ป้าแดง', null, 'คุณแดง', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1573', 'VP03027', 'แพโนรี', 'แพโนรี', null, 'คุณคฑาวุท', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-244', null);
INSERT INTO `customer` VALUES ('1574', 'VP03028', 'กาแฟโบราณ กัญญารัตน์', 'กาแฟโบราณ กัญญารัตน์', null, 'คุณกัญญารัตน์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-08 S63-46', null);
INSERT INTO `customer` VALUES ('1575', 'VP03029', 'คาเฟ่ ฟาร์อะเวย์', 'คาเฟ่ ฟาร์อะเวย์', null, 'คุณปัญจพล', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A61-36', null);
INSERT INTO `customer` VALUES ('1576', 'VP03030', 'ก๋วยเตี๋ยว ป้าวาน', 'ก๋วยเตี๋ยว ป้าวาน', null, 'คุณบุษบง', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'C63-08', null);
INSERT INTO `customer` VALUES ('1577', 'VP03031', 'อาหารตามสั่ง แก่น', 'อาหารตามสั่ง แก่น', null, 'คุณแก่น', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1578', 'VP03032', 'อาหารตามสั่ง ป้าจิตร', 'อาหารตามสั่ง ป้าจิตร', null, 'คุณกิตติมา', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-36', null);
INSERT INTO `customer` VALUES ('1579', 'VP03033', 'กาแฟสดคุณเพ็ญ VP3', 'กาแฟสดคุณเพ็ญ VP3', null, 'คุณเพ็ญ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1580', 'VP03034', 'บ้านดอกรักษ์', 'บ้านดอกรักษ์', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1581', 'VP03035', 'ของชำ ป้าต้อย VP3', 'ของชำ ป้าต้อย VP3', null, 'คุณบุญธรรม', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-42', null);
INSERT INTO `customer` VALUES ('1582', 'VP03036', 'เอฟเวอร์กรีนคอฟฟี่', 'เอฟเวอร์กรีนคอฟฟี่', null, 'คุณชัชภรณ์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-204', null);
INSERT INTO `customer` VALUES ('1583', 'VP03037', 'ร้านป้าติ๋ม', 'ร้านป้าติ๋ม', null, 'คุณสุพร', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-71', null);
INSERT INTO `customer` VALUES ('1584', 'VP03038', 'ของชำ สมจิตต์ VP7', 'ของชำ สมจิตต์ VP7', null, 'คุณสมจิตต์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1585', 'VP03039', 'ก๋วยเตี๋ยว พี่นิด VP3', 'ก๋วยเตี๋ยว พี่นิด VP3', null, 'คุณขนิษฐา', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-132', null);
INSERT INTO `customer` VALUES ('1586', 'VP03040', 'ร้านน้ำ พี่จิ้ว', 'ร้านน้ำ พี่จิ้ว', null, 'คุณรัตนา', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'C63-09,S63-06', null);
INSERT INTO `customer` VALUES ('1587', 'VP03041', 'ร้านกินเส้น', 'ร้านกินเส้น', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1588', 'VP03042', 'อาหารตามสั่ง พี่อ้น', 'อาหารตามสั่ง พี่อ้น', null, 'คุณจำนงค์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-243', null);
INSERT INTO `customer` VALUES ('1589', 'VP03043', 'ลูกชิ้นปิ้ง คุณครู', 'ลูกชิ้นปิ้ง คุณครู', null, 'คุณเสาวรส', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-24', null);
INSERT INTO `customer` VALUES ('1590', 'VP03044', 'น้ำแข็งใส ดอนแฝก', 'น้ำแข็งใส ดอนแฝก', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1591', 'VP03045', 'กาแฟสดandหมูปิ้ง ทิพวรรณ', 'กาแฟสดandหมูปิ้ง ทิพวรรณ', null, 'คุณทิพวรรณ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-65', null);
INSERT INTO `customer` VALUES ('1592', 'VP03046', 'ขนมปังเย็น กกตาล', 'ขนมปังเย็น กกตาล', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1593', 'VP03047', 'ส้มตำ พี่หมวย', 'ส้มตำ พี่หมวย', null, 'คุณหมวย', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1594', 'VP03048', 'บ้านสวนทำผัก', 'บ้านสวนทำผัก', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1595', 'VP03049', 'กาแฟสด โกเพ้ง', 'กาแฟสด โกเพ้ง', null, 'คุณเพ้ง', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1596', 'VP03050', 'ของชำ ป้าตุ้ย', 'ของชำ ป้าตุ้ย', null, 'คุณสัมพันธ์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-19', null);
INSERT INTO `customer` VALUES ('1597', 'VP03051', 'ซุปเปอร์มาร์เก็ต โรงงานพีพีเอ', 'ซุปเปอร์มาร์เก็ต โรงงานพีพีเอ', null, 'คุณเอ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1598', 'VP03052', 'อู่ช่างอ้วน', 'อู่ช่างอ้วน', null, 'คุณอ้วน', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1599', 'VP03053', 'น้ำอ้อย อำพร', 'น้ำอ้อย อำพร', null, 'คุณอำพร', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-90', null);
INSERT INTO `customer` VALUES ('1600', 'VP04001', 'ตาหมูตุ๋น', 'ตาหมูตุ๋น', null, 'คุณตา', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1601', 'VP04002', 'ข้าวผัดปู สุกี้', 'ข้าวผัดปู สุกี้', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1602', 'VP04003', 'ก๋วยเตี๋ยวศาลาธรรมสพน์', 'ก๋วยเตี๋ยวศาลาธรรมสพน์', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1603', 'VP04004', 'กาแฟ ปลื้ม', 'กาแฟ ปลื้ม', null, 'คุณปลื้ม', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1604', 'VP04005', 'กาแฟ พี่สม', 'กาแฟ พี่สม', null, 'คุณสม', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1605', 'VP04006', 'อาหารตามสั่ง ป้าจิ๋ม', 'อาหารตามสั่ง ป้าจิ๋ม', null, 'คุณจิ๋ม', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1606', 'VP04007', 'กูเด็กเส้น', 'กูเด็กเส้น', null, 'คุณเกรียงไกร', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A61-34 (1L)', null);
INSERT INTO `customer` VALUES ('1607', 'VP04008', 'ป้อมยามชัยพฤกษ์', 'ป้อมยามชัยพฤกษ์', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1608', 'VP04009', 'ของชำ พี่มุก', 'ของชำ พี่มุก', null, 'คุณมุข', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'C63-11', null);
INSERT INTO `customer` VALUES ('1609', 'VP04010', 'มิคุชา', 'มิคุชา', null, 'คุณกฤตยา', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-80A61-03', null);
INSERT INTO `customer` VALUES ('1610', 'VP04012', 'ใบเตยกับใบตอง', 'ใบเตยกับใบตอง', null, 'คุณสะแกวัล', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-99A62-76', null);
INSERT INTO `customer` VALUES ('1611', 'VP04013', 'ป้านี กรมยุทธศึกษา', 'ป้านี กรมยุทธศึกษา', null, 'คุณนี', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1612', 'VP04014', 'The Salared', 'The Salared', null, 'คุณธีรยุท', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-52,M62-55,S62-238,125', null);
INSERT INTO `customer` VALUES ('1613', 'VP04015', 'ทอดมัน เจ๊เอ๋', 'ทอดมัน เจ๊เอ๋', null, 'คุณพุทธินี', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-67', null);
INSERT INTO `customer` VALUES ('1614', 'VP04016', 'หมูปิ้งลูกปลา สุภาพ', 'หมูปิ้งลูกปลา สุภาพ', null, 'คุณสุภาพ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-147', null);
INSERT INTO `customer` VALUES ('1615', 'VP04017', 'เมี่ยงปลาเผา พี่ต้อย', 'เมี่ยงปลาเผา พี่ต้อย', null, 'คุณมณีพรรณราย', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-121', null);
INSERT INTO `customer` VALUES ('1616', 'VP04018', 'ไก่ย่างดงตาล ป้าปุ้ย', 'ไก่ย่างดงตาล ป้าปุ้ย', null, 'คุณผ่อน', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1617', 'VP04019', 'ไก่ย่าง ป้าสมใจ', 'ไก่ย่าง ป้าสมใจ', null, 'คุณสมใจ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-29', null);
INSERT INTO `customer` VALUES ('1618', 'VP04020', 'พี่อ้อย VP4', 'พี่อ้อย VP4', null, 'คุณปิยนันท์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S61-225', null);
INSERT INTO `customer` VALUES ('1619', 'VP04021', 'พี่หมวย VP4', 'พี่หมวย VP4', null, 'คุณหมวย', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1620', 'VP04022', 'ของชำ ป้าเพ็ญ', 'ของชำ ป้าเพ็ญ', null, 'คุณเพ็ญ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1621', 'VP04023', 'กระหรี่ปั๊บ นิภา', 'กระหรี่ปั๊บ นิภา', null, 'คุณนิภา', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-127', null);
INSERT INTO `customer` VALUES ('1622', 'VP04024', 'ร้านพี่น้ำ VP4', 'ร้านพี่น้ำ VP4', null, 'คุณน้ำ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A63-11', null);
INSERT INTO `customer` VALUES ('1623', 'VP04025', 'ของชำ ป้าอาง', 'ของชำ ป้าอาง', null, 'คุณอาง', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1624', 'VP04026', 'ขนมหวาน พี่ตุ๋ย', 'ขนมหวาน พี่ตุ๋ย', null, 'คุณสัมฤทธิ์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-30', null);
INSERT INTO `customer` VALUES ('1625', 'VP04027', 'โรตี มนีรัตน์', 'โรตี มนีรัตน์', null, 'คุณมนีรัตน์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-25', null);
INSERT INTO `customer` VALUES ('1626', 'VP04028', 'ลูกชิ้น พี่เหมียว', 'ลูกชิ้น พี่เหมียว', null, 'คุณรสสุคนธ์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-40', null);
INSERT INTO `customer` VALUES ('1627', 'VP04029', 'ก๋วยเตี๋ยวป้าติ๋ม', 'ก๋วยเตี๋ยวป้าติ๋ม', null, 'คุณศศิธร', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A63-02', null);
INSERT INTO `customer` VALUES ('1628', 'VP04030', 'ร้านพี่เจี๊ยบ', 'ร้านพี่เจี๊ยบ', null, 'คุณเจี๊ยบ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1629', 'VP04031', 'ศาลาญาณี', 'ศาลาญาณี', null, 'คุณเจนธนภัทร', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-48', null);
INSERT INTO `customer` VALUES ('1630', 'VP04032', 'ร้านป้าเต้า', 'ร้านป้าเต้า', null, 'คุณเต้า', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1631', 'VP04033', 'รวงเดือน', 'รวงเดือน', null, 'คุณรวงเดือน', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1632', 'VP04034', 'กาแฟ พี่ปุ๊ก', 'กาแฟ พี่ปุ๊ก', null, 'คุณปุ๊ก', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1633', 'VP04035', 'ป้าแต๋น ริมคลอง', 'ป้าแต๋น ริมคลอง', null, 'คุณแต๋น', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A63-25', null);
INSERT INTO `customer` VALUES ('1634', 'VP04036', 'ป้าตุ้ม VP4', 'ป้าตุ้ม VP4', null, 'คุณตุ้ม', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1635', 'VP04037', 'พี่ทวีป VP4', 'พี่ทวีป VP4', null, 'คุณทวีป', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S61-56A63-42', null);
INSERT INTO `customer` VALUES ('1636', 'VP04038', 'น้ำมะพร้าว ถนอม', 'น้ำมะพร้าว ถนอม', null, 'คุณถนอม', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A63-01,', null);
INSERT INTO `customer` VALUES ('1637', 'VP04039', 'ชานมพี่ปุ๊ก', 'ชานมพี่ปุ๊ก', null, 'คุณฐิตินันท์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A63-32', null);
INSERT INTO `customer` VALUES ('1638', 'VP04040', 'ข้าวแกง มนัสชนก', 'ข้าวแกง มนัสชนก', null, 'คุณมนัสชนก', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-84', null);
INSERT INTO `customer` VALUES ('1639', 'VP04041', 'ปลาเผา จุฑามาศ', 'ปลาเผา จุฑามาศ', null, 'คุณจุฑามาศ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S61-04', null);
INSERT INTO `customer` VALUES ('1640', 'VP04042', 'ของชำ ชัญญานุช', 'ของชำ ชัญญานุช', null, 'คุณชัญญานุช', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A63-14A63-41', null);
INSERT INTO `customer` VALUES ('1641', 'VP04043', 'ก๋วยเตี๋ยว ริมคลอง ภูษา', 'ก๋วยเตี๋ยว ริมคลอง ภูษา', null, 'คุณภูษา', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A63-18', null);
INSERT INTO `customer` VALUES ('1642', 'VP04044', 'น้ำแข็งใสริมคลอง กรุณี', 'น้ำแข็งใสริมคลอง กรุณี', null, 'คุณกรุณี', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S62-227', null);
INSERT INTO `customer` VALUES ('1643', 'VP04045', 'อาหารตามสั่ง ป้ารัตน์', 'อาหารตามสั่ง ป้ารัตน์', null, 'คุณรัตน์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1644', 'VP04046', 'มะพร้าวปั่น VP4', 'มะพร้าวปั่น VP4', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A63-33', null);
INSERT INTO `customer` VALUES ('1645', 'VP04047', 'มะพร้าว พี่เพ๊ญ', 'มะพร้าว พี่เพ๊ญ', null, 'คุณเพ๊ญ', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-91', null);
INSERT INTO `customer` VALUES ('1646', 'VP04048', 'สวนมา', 'สวนมา', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, '', null);
INSERT INTO `customer` VALUES ('1647', 'VP04049', 'บ้านช่าง', 'บ้านช่าง', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, '', null);
INSERT INTO `customer` VALUES ('1648', 'VP04050', 'น้ำปั่นซิ่วซิ่ว สมูทตี้', 'น้ำปั่นซิ่วซิ่ว สมูทตี้', null, '', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A63-63', null);
INSERT INTO `customer` VALUES ('1649', 'VP05001', 'ก๋วยเตี๋ยวเรือ ปตท', 'ก๋วยเตี๋ยวเรือ ปตท', null, 'เจ้รุ่ง', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1650', 'VP05002', 'ร้านจันทร์เจ้า', 'ร้านจันทร์เจ้า', null, 'คุณภานุวัฒน์', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'S63-02', null);
INSERT INTO `customer` VALUES ('1651', 'VP05003', 'ร้านพี่กุ้งของชำดอนดายหอม', 'ร้านพี่กุ้งของชำดอนดายหอม', null, 'คุณกิตติชัย', null, null, null, null, '1', null, null, '1610022027', '1610022027', null, null, 'A62-85', null);
INSERT INTO `customer` VALUES ('1652', 'VP05004', 'กินเส้นข้างรง', 'กินเส้นข้างรง', null, 'คุณสุจีรัตน์', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A63-13', null);
INSERT INTO `customer` VALUES ('1653', 'VP05005', 'เตี๋ยวไก่ตลาดโพหัก', 'เตี๋ยวไก่ตลาดโพหัก', null, 'คุณสาลี่', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1654', 'VP05006', 'มนรักส้มตำ', 'มนรักส้มตำ', null, 'คุณทิพ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1655', 'VP05007', 'ตู่ แตน ตามสั่ง', 'ตู่ แตน ตามสั่ง', null, 'คุณนวพร', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S63-01', null);
INSERT INTO `customer` VALUES ('1656', 'VP05008', 'หมีอ้วนคาเฟ่ โพหัก', 'หมีอ้วนคาเฟ่ โพหัก', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'M62-65', null);
INSERT INTO `customer` VALUES ('1657', 'VP05009', 'ข้าวมันไก่', 'ข้าวมันไก่', null, 'คุณวรรณนิดา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A62-42', null);
INSERT INTO `customer` VALUES ('1658', 'VP05010', 'ชลิดา ข้าวแกงบุปเฟ่', 'ชลิดา ข้าวแกงบุปเฟ่', null, 'คุณสราวุธ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-154', null);
INSERT INTO `customer` VALUES ('1659', 'VP05011', 'ร้านซุปหางวัว', 'ร้านซุปหางวัว', null, 'คุณบัญชา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-102', null);
INSERT INTO `customer` VALUES ('1660', 'VP05012', 'ป.กุ้งสด โพหัก', 'ป.กุ้งสด โพหัก', null, 'คุณบุญมี', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1661', 'VP05013', 'ของชำป้ามล ดอนมะขามเทศ', 'ของชำป้ามล ดอนมะขามเทศ', null, 'คุณนันท์', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1662', 'VP05014', 'ของชำพี่หญิง ดอนมะขามเทศ', 'ของชำพี่หญิง ดอนมะขามเทศ', null, 'คุณอนุวัฒ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'M62-46M62-67', null);
INSERT INTO `customer` VALUES ('1663', 'VP05015', 'ร้านจูเนียร์ ตามสั่ง', 'ร้านจูเนียร์ ตามสั่ง', null, 'คุณสะอาด', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S63-28', null);
INSERT INTO `customer` VALUES ('1664', 'VP05016', 'ร้านข้าวแกง2ภาค', 'ร้านข้าวแกง2ภาค', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1665', 'VP05017', 'เจ้ติวเตี๋ยวเรือ แยกโพหัก', 'เจ้ติวเตี๋ยวเรือ แยกโพหัก', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1666', 'VP05018', 'ร้านขนมบ้านบัวหอม ปั๊มเชล์หัวโพ', 'ร้านขนมบ้านบัวหอม ปั๊มเชล์หัวโพ', null, 'คุณเอื้องฟ้า', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-119,S62-256', null);
INSERT INTO `customer` VALUES ('1667', 'VP05019', 'เวลาชา แยกดอนคลัง', 'เวลาชา แยกดอนคลัง', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1668', 'VP05020', 'ป้าตุ๋มตามสั่ง หน้าวัดโคก', 'ป้าตุ๋มตามสั่ง หน้าวัดโคก', null, 'คุณสุชัญญา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A61-24', null);
INSERT INTO `customer` VALUES ('1669', 'VP05021', 'ก๋วยเตี่ยวนายหนุ่ม', 'ก๋วยเตี่ยวนายหนุ่ม', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1670', 'VP05022', 'พี่กบของชำ ติดร.ร.สายธรรมจันทร์', 'พี่กบของชำ ติดร.ร.สายธรรมจันทร์', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1671', 'VP05023', 'ร้านสเตีก long', 'ร้านสเตีก long', null, 'คุณนันทิการ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A62-60S62-120', null);
INSERT INTO `customer` VALUES ('1672', 'VP05024', 'ป้าแพรวขายนำ ดำเนิน', 'ป้าแพรวขายนำ ดำเนิน', null, 'คุณเฉลิมพล', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A62-27', null);
INSERT INTO `customer` VALUES ('1673', 'VP05025', 'ร้านยำเจ้สา', 'ร้านยำเจ้สา', null, 'คุณเดชา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-232S62-246S62-143', null);
INSERT INTO `customer` VALUES ('1674', 'VP05026', 'ร้านน้ำป้าดับ แยกโคกฝรั่ง', 'ร้านน้ำป้าดับ แยกโคกฝรั่ง', null, 'คุณพรพิรุน', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S 62-81 S62-122', null);
INSERT INTO `customer` VALUES ('1675', 'VP05027', 'ส้มตำแยกดอนคลัง', 'ส้มตำแยกดอนคลัง', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1676', 'VP05028', 'เบริด เบริด แยกดอนคลัง', 'เบริด เบริด แยกดอนคลัง', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1677', 'VP05029', 'เตี๋ยวไก่ไชโย', 'เตี๋ยวไก่ไชโย', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1678', 'VP05030', 'ร้านน้ำอ้อย หน้าวัดดอนโฆสิต', 'ร้านน้ำอ้อย หน้าวัดดอนโฆสิต', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1679', 'VP05031', 'ราชาบะหมี่โพหัก', 'ราชาบะหมี่โพหัก', null, 'คุณเล็ก', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('1680', 'VP05032', 'ป้าฮวยหอยทอด สาขาโพหัก', 'ป้าฮวยหอยทอด สาขาโพหัก', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-130', null);
INSERT INTO `customer` VALUES ('1681', 'VP05033', 'เวลาชา ตรงข้ามศรีสวัสดิ์', 'เวลาชา ตรงข้ามศรีสวัสดิ์', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-161', null);
INSERT INTO `customer` VALUES ('1682', 'VP05034', 'ลาบเป็ดตลาดจินดา', 'ลาบเป็ดตลาดจินดา', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S63-74', null);
INSERT INTO `customer` VALUES ('1683', 'VP07001', 'อเมซอน', 'อเมซอน', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1684', 'VP07002', 'อาคาร100ปี', 'อาคาร100ปี', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1685', 'VP07003', 'ร้านกาแฟลุงเด็น', 'ร้านกาแฟลุงเด็น', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1686', 'VP07004', 'ร้านขนมหวาน', 'ร้านขนมหวาน', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1687', 'VP07005', 'อินทนิน', 'อินทนิน', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1688', 'VP07021', 'เจ้สาวตามสั่ง', 'เจ้สาวตามสั่ง', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1689', 'VP07025', 'สีหมอก', 'สีหมอก', null, 'คุณตา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1690', 'VP07049', 'น้ำส่ง ภักดี', 'น้ำส่ง ภักดี', null, 'คุณภักดี', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'C63-10,14,E63-18', null);
INSERT INTO `customer` VALUES ('1691', 'VP09001', 'อาร์ซิเร่', 'อาร์ซิเร่', null, 'คุณต้น', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S61-38,S62-213,M62-52', null);
INSERT INTO `customer` VALUES ('1692', 'VP09009', 'บ้านขนมจีน', 'บ้านขนมจีน', null, 'คุณอิ๋ว', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1693', 'VP09010', 'In’s me', 'In’s me', null, 'คุณต่าย', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1694', 'VP09011', 'คาเฟ่ไทยสไตล์', 'คาเฟ่ไทยสไตล์', null, 'คุณเอส', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1695', 'VP09013', 'Marracha', 'Marracha', null, 'คุณเม', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-79', null);
INSERT INTO `customer` VALUES ('1696', 'VP09014', 'กาแฟโจ๊กบางกอก', 'กาแฟโจ๊กบางกอก', null, 'คุณหญิง', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A61-20', null);
INSERT INTO `customer` VALUES ('1697', 'VP09015', 'ซูชิมั้ย 7', 'ซูชิมั้ย 7', null, 'คุณอ๋อ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1698', 'VP09016', 'กาแฟสด VP9', 'กาแฟสด VP9', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1699', 'VP09017', 'ณ เตี๋ยวเจ้าท่า ซ.8', 'ณ เตี๋ยวเจ้าท่า ซ.8', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1700', 'VP09018', 'ถังชา พี่นัท', 'ถังชา พี่นัท', null, 'คุณฐิติฐา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'C62-06,M62-74', null);
INSERT INTO `customer` VALUES ('1701', 'VP09019', 'บะหมี่อาม่า', 'บะหมี่อาม่า', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1702', 'VP09020', 'SUN and MOON CAFE', 'SUN and MOON CAFE', null, 'คุณรติดาภา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-233', null);
INSERT INTO `customer` VALUES ('1703', 'VP09021', 'ลิตเติ้ลโกโก้ คาเฟ่', 'ลิตเติ้ลโกโก้ คาเฟ่', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A62-03', null);
INSERT INTO `customer` VALUES ('1704', 'VP09022', 'The Trane', 'The Trane', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1705', 'VP09023', 'Coffee Process caf?\'', 'Coffee Process caf?\'', null, 'คุณจักชัย', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S63-15', null);
INSERT INTO `customer` VALUES ('1706', 'VP09024', 'ปูไข่ดองแวววาว พี่ตะวัน', 'ปูไข่ดองแวววาว พี่ตะวัน', null, 'คุณตะวัน', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S63-1343', null);
INSERT INTO `customer` VALUES ('1707', 'VP09025', 'ข้าวแกง ซ.8 VP9', 'ข้าวแกง ซ.8 VP9', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1708', 'VP09026', 'WAY ต้นสน', 'WAY ต้นสน', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'B100-1022', null);
INSERT INTO `customer` VALUES ('1709', 'VP09027', 'ไซด์งาน ปั๊มปตท.(แม็คโคร)', 'ไซด์งาน ปั๊มปตท.(แม็คโคร)', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A62-01', null);
INSERT INTO `customer` VALUES ('1710', 'VP09028', 'มุมสบาย', 'มุมสบาย', null, 'คุณอัปสร', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-169', null);
INSERT INTO `customer` VALUES ('1711', 'VP09029', 'MAX BEEF', 'MAX BEEF', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1712', 'VP09030', 'Youth Caf?', 'Youth Caf?', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1713', 'VP09031', 'ข้าวพี่เอ๋', 'ข้าวพี่เอ๋', null, 'คุณโสภณ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A63-09', null);
INSERT INTO `customer` VALUES ('1714', 'VP09032', 'ปะยาง น้องแนน', 'ปะยาง น้องแนน', null, 'คุณแนน', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1715', 'VP09033', 'อ๋าโภชนา', 'อ๋าโภชนา', null, 'คุณเม', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1716', 'VP09034', 'ข้าวแกงในสวน ป้านา', 'ข้าวแกงในสวน ป้านา', null, 'คุณณา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1717', 'VP09035', 'เจ๊ดาน้ำปั่น', 'เจ๊ดาน้ำปั่น', null, 'คุณดา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1718', 'VP09036', 'พี่นาตามสั่ง', 'พี่นาตามสั่ง', null, 'คุณนา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1719', 'VP09037', 'ไทยสไตล์หน้ามอ', 'ไทยสไตล์หน้ามอ', null, 'คุณนัน', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1720', 'VP09038', 'Bun บิ๊กซี', 'Bun บิ๊กซี', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1721', 'VP09039', 'TEA Tiger', 'TEA Tiger', null, 'คุณหนึ่ง', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1722', 'VP09040', 'ก๋วยเตี๋ยวไก่ พี่วาสนา', 'ก๋วยเตี๋ยวไก่ พี่วาสนา', null, 'คุณวาสนา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A61-31', null);
INSERT INTO `customer` VALUES ('1723', 'VP09041', 'PRO TRUCK', 'PRO TRUCK', null, 'คุณณรงค์', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S63-33', null);
INSERT INTO `customer` VALUES ('1724', 'VP09042', 'พี่เอียดของชำ', 'พี่เอียดของชำ', null, 'คุณเอียด', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1725', 'VP09043', 'ไซร์งาน KFC ซ.8', 'ไซร์งาน KFC ซ.8', null, 'คุณบุญเลิศ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A62-51', null);
INSERT INTO `customer` VALUES ('1726', 'VP09044', 'The Butter', 'The Butter', null, 'คุณทอย', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1727', 'VP09045', 'แพร เครื่องดื่ม', 'แพร เครื่องดื่ม', null, 'คุณฐรินดา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A63-19', null);
INSERT INTO `customer` VALUES ('1728', 'VP09046', 'กุ้งอบภูเขาไฟ', 'กุ้งอบภูเขาไฟ', null, 'คุณอุษา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'E63-04', null);
INSERT INTO `customer` VALUES ('1729', 'VP09047', 'พี่ทิพย์ น้ำปั่น ซ.2', 'พี่ทิพย์ น้ำปั่น ซ.2', null, 'คุณชนิดาภา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A63-17', null);
INSERT INTO `customer` VALUES ('1730', 'VP09049', 'พี่ยาตามสั่ง', 'พี่ยาตามสั่ง', null, 'คุณยา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1731', 'VP10002', 'ส้มตำยายหอม', 'ส้มตำยายหอม', null, 'คุณหอม', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1732', 'VP10004', 'อรพรรณส้มตำ', 'อรพรรณส้มตำ', null, 'คุณอรพรรณ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1733', 'VP10007', 'เจ้อารีย์ ตามสั้ง', 'เจ้อารีย์ ตามสั้ง', null, 'คุณอารี', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A62-120', null);
INSERT INTO `customer` VALUES ('1734', 'VP10009', 'ส้มตำตาก้อง', 'ส้มตำตาก้อง', null, 'คุณพุ่ม', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-140', null);
INSERT INTO `customer` VALUES ('1735', 'VP10012', 'ตัดผมชาย พี่ชาย', 'ตัดผมชาย พี่ชาย', null, 'คุณชาย', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1736', 'VP10013', 'ตะวันตามสั่ง', 'ตะวันตามสั่ง', null, 'คุณตะวัน', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-183', null);
INSERT INTO `customer` VALUES ('1737', 'VP10015', 'ป้าลัดดา ของชำ', 'ป้าลัดดา ของชำ', null, 'คุณลัดดา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1738', 'VP10016', 'กล้วยทอด พี่พร', 'กล้วยทอด พี่พร', null, 'คุณพร', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1739', 'VP10017', 'อินจันกาแฟ', 'อินจันกาแฟ', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1740', 'VP10020', 'ปลาสี (ปลากัด)', 'ปลาสี (ปลากัด)', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1741', 'VP10022', 'ตาพจน์ ของชำ', 'ตาพจน์ ของชำ', null, 'คุณพจน์', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1742', 'VP10024', 'เจ้มาลี ของชำ VP10', 'เจ้มาลี ของชำ VP10', null, 'คุณมาลี', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1743', 'VP10026', 'บ้านเย็บผ้า น้องกาญ', 'บ้านเย็บผ้า น้องกาญ', null, 'คุณกาญ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A63-21', null);
INSERT INTO `customer` VALUES ('1744', 'VP10027', 'บ้านผู้ใหญ่ ข้าวแกง', 'บ้านผู้ใหญ่ ข้าวแกง', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1745', 'VP10028', 'ทำผม พี่พจน์', 'ทำผม พี่พจน์', null, 'คุณพจน์', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1746', 'VP10029', 'น้ำปั่นตาก้อง เจ้น้อย', 'น้ำปั่นตาก้อง เจ้น้อย', null, 'คุณน้อย', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A63-48', null);
INSERT INTO `customer` VALUES ('1747', 'VP10030', 'เจ้นวล ของชำ', 'เจ้นวล ของชำ', null, 'คุณนวล', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1748', 'VP10031', 'น้องออย น้ำปั่น', 'น้องออย น้ำปั่น', null, 'คุณนริศรา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A62-50', null);
INSERT INTO `customer` VALUES ('1749', 'VP10032', 'น้ำอ้อย ไพโรจน์', 'น้ำอ้อย ไพโรจน์', null, 'คุณไพโรจน์', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-249', null);
INSERT INTO `customer` VALUES ('1750', 'VP10035', 'น้องเกตุ เครื่องดื่ม', 'น้องเกตุ เครื่องดื่ม', null, 'คุณกาญจนาพร', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A62-49', null);
INSERT INTO `customer` VALUES ('1751', 'VP10036', 'เจ๊นิด ของชำ VP10', 'เจ๊นิด ของชำ VP10', null, 'คุณไพรวรรณ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-259', null);
INSERT INTO `customer` VALUES ('1752', 'VP10037', 'เมแหนมย่าง', 'เมแหนมย่าง', null, 'คุณอรัญญา', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A61-23', null);
INSERT INTO `customer` VALUES ('1753', 'VP10038', 'น้ำ ป้าบังอร', 'น้ำ ป้าบังอร', null, 'คุณบังอร', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'S62-126', null);
INSERT INTO `customer` VALUES ('1754', 'VP01084', 'ร้านสับปะรด พี่ต๋อง', 'ร้านสับปะรด พี่ต๋อง', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, 'A63-112', null);
INSERT INTO `customer` VALUES ('1755', 'VP11001', 'สวนหม่อน', 'สวนหม่อน', null, '', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1756', 'VP11003', 'กาแฟรัตน์โกสินทร์', 'กาแฟรัตน์โกสินทร์', null, 'พี่นัด', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1757', 'VP11009', 'ครัวคุณวรรณ', 'ครัวคุณวรรณ', null, 'ป้ามะลิ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1758', 'VP11010', 'สาขา3 ข้าวแกงปักษ์ใต้', 'สาขา3 ข้าวแกงปักษ์ใต้', null, 'ป้ากี้', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1759', 'VP11011', 'ช.โภชนา อาหารตามสั่ง', 'ช.โภชนา อาหารตามสั่ง', null, 'พีพี', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1760', 'VP11012', 'กาแฟบุญมี', 'กาแฟบุญมี', null, 'ป้าทัด', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1761', 'VP11013', 'ครัวแม่นันท์ ท่าราบ', 'ครัวแม่นันท์ ท่าราบ', null, 'พี่วิว', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1762', 'VP11014', 'ผลไม้ พี่ฝน', 'ผลไม้ พี่ฝน', null, 'พี่เจี๊ยบ', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1763', 'VP11015', 'บ้านส้ม 3', 'บ้านส้ม 3', null, 'ป้าติ๋ม', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1764', 'VP11016', 'กาแฟสด ศูนย์อาหาร ปตท. หนองโพ', 'กาแฟสด ศูนย์อาหาร ปตท. หนองโพ', null, 'น้องโบว์', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1765', 'VP11018', 'Octospider', 'Octospider', null, 'พี่ปุ๋ย', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1766', 'VP11019', 'Pasaya Cafe In', 'Pasaya Cafe In', null, 'ป้าสุข', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1767', 'VP11020', 'บางแพ ไม้เก่า', 'บางแพ ไม้เก่า', null, 'เจ้บัว', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1768', 'VP11021', 'เต๊กกอ ข้างปั๊มบางจาก', 'เต๊กกอ ข้างปั๊มบางจาก', null, 'สาว', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1769', 'VP11022', 'สาขา7 ข้าวแกงปักษ์ใต้', 'สาขา7 ข้าวแกงปักษ์ใต้', null, 'ป้าแอ็ด', null, null, null, null, '1', null, null, '1610022028', '1610022028', null, null, '', null);
INSERT INTO `customer` VALUES ('1770', 'VP11023', 'บ้านส้ม เขางู', 'บ้านส้ม เขางู', null, 'ป้าหยุด', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1771', 'VP11024', 'ก๋วยเตี๋ยวกันเอง', 'ก๋วยเตี๋ยวกันเอง', null, 'พี่นุ้ย', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1772', 'VP11025', 'ชูชกยิ้ม', 'ชูชกยิ้ม', null, 'ลุงไอร์', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1773', 'VP11026', 'เพลินกรุง', 'เพลินกรุง', null, 'ป้าแต๋ว', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1774', 'VP11027', 'เจี๊ยบผลไม้', 'เจี๊ยบผลไม้', null, 'พี่จอย', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1775', 'VP11028', 'ร้านน้ำ พี่ทิพย์', 'ร้านน้ำ พี่ทิพย์', null, 'พี่หมี', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1776', 'VP11029', 'หม่าล่า', 'หม่าล่า', null, 'พี่ส้ม', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1777', 'VP11030', 'ลูกชิ้นปลา ศรีบุรี', 'ลูกชิ้นปลา ศรีบุรี', null, 'พี่พลอย', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1778', 'VP11031', 'CC2853 อเมซอน 4แยกห้วย', 'CC2853 อเมซอน 4แยกห้วย', null, 'ป้าตุ๊ก', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1779', 'VP11032', 'SC2570 อเมซอน โลตัส', 'SC2570 อเมซอน โลตัส', null, 'ป้าบูรณ์', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1780', 'VP11033', 'SC2680 อเมซอน รพ.ราชบุรี', 'SC2680 อเมซอน รพ.ราชบุรี', null, 'ป้าแขก', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1781', 'VP11034', 'อาหารตามสั่ง พี่หน่อย', 'อาหารตามสั่ง พี่หน่อย', null, 'ป้าเพ็ญ', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1782', 'VP11035', 'กาแฟ เจ้เล็ก', 'กาแฟ เจ้เล็ก', null, 'พี่ขวัญ', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1783', 'VP11036', 'สาขา2 ข้าวแกงปักษ์ใต้', 'สาขา2 ข้าวแกงปักษ์ใต้', null, 'ป้าเรณู', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1784', 'VP11037', 'สาขา1 ข้าวแกงปักษ์ใต้', 'สาขา1 ข้าวแกงปักษ์ใต้', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1785', 'VP11039', 'ของชำ พี่หญิง', 'ของชำ พี่หญิง', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1786', 'VP11040', 'ร้านน้ำ พิเชษฐ์', 'ร้านน้ำ พิเชษฐ์', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1787', 'VP11041', 'ร้านชา กาแฟ บ้านสิงห์', 'ร้านชา กาแฟ บ้านสิงห์', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1788', 'VP11042', 'Oni โลตัส ราชบุรี', 'Oni โลตัส ราชบุรี', null, '15D', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1789', 'VP06060', 'ส้มตำพี่นิว', 'ส้มตำพี่นิว', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1790', 'VP01086', 'พี่ตอง น้ำปั่น', 'พี่ตอง น้ำปั่น', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1791', 'VP01087', 'ข้าวไข่เจียวพี่จิ้งหรีด', 'ข้าวไข่เจียวพี่จิ้งหรีด', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1792', 'VP05035', 'ร้านน้ำปั่นพี่เจี๊ยบ', 'ร้านน้ำปั่นพี่เจี๊ยบ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1793', 'VP05036', 'ชามิจิ', 'ชามิจิ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1794', 'VP05037', 'กระเพราจานใหญ่', 'กระเพราจานใหญ่', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1795', 'VP05038', 'โลมาชาชง PT', 'โลมาชาชง PT', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1796', 'VP05039', 'ร้านบ้านเฉาก๊วยเต็งหนึ่ง', 'ร้านบ้านเฉาก๊วยเต็งหนึ่ง', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1797', 'VP05040', 'น้ำแข็งใสน้องไอซ์', 'น้ำแข็งใสน้องไอซ์', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1798', 'VP05041', 'MP คอฟฟี่', 'MP คอฟฟี่', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1799', 'VP05042', 'มาลัยกาแฟ', 'มาลัยกาแฟ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1800', 'VP05043', 'ไก่ย่างจิ้มแจ่ว', 'ไก่ย่างจิ้มแจ่ว', null, 'ลุงสร', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1801', 'VP05044', 'เกี๊ยว 7 หัวโพ', 'เกี๊ยว 7 หัวโพ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1802', 'VP05045', 'อาหารอีสานเจ้แอ๊ด', 'อาหารอีสานเจ้แอ๊ด', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1803', 'VP05046', 'พี่สานการยาง', 'พี่สานการยาง', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1804', 'VP05047', 'กาแฟสด น้ำปั่น', 'กาแฟสด น้ำปั่น', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1805', 'VP05048', 'ข้าวหมูแดง', 'ข้าวหมูแดง', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1806', 'VP05049', 'ข้าวแกงออมสิน', 'ข้าวแกงออมสิน', null, 'หน่อย', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1807', 'VP05050', 'ร้านปอนด์เตี่ยวเรือ', 'ร้านปอนด์เตี่ยวเรือ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1808', 'VP05051', 'เตี๋ยวไก่น้องปาล์ม', 'เตี๋ยวไก่น้องปาล์ม', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1809', 'VP05052', 'โรงเรียนสายธรรมจันทร์', 'โรงเรียนสายธรรมจันทร์', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1810', 'VP05053', 'ครูเล็กน้ำปั่น', 'ครูเล็กน้ำปั่น', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1811', 'VP05054', 'พี่ปุ๋ย', 'พี่ปุ๋ย', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1812', 'VP05055', 'ปลาหมึก', 'ปลาหมึก', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1813', 'VP05056', 'ร้านเผือกมันหู้', 'ร้านเผือกมันหู้', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1814', 'VP05057', 'ร้านข้าวแกง', 'ร้านข้าวแกง', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1815', 'VP05058', 'พี่ชมพู่แยกหัวโพ', 'พี่ชมพู่แยกหัวโพ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1816', 'VP05059', 'ร้านส้มตำพี่ประนอม', 'ร้านส้มตำพี่ประนอม', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1817', 'VP05060', 'หมูสดเจ้บัว', 'หมูสดเจ้บัว', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1818', 'VP05061', 'พี่เอกปลาหมึก', 'พี่เอกปลาหมึก', null, 'เอก', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1819', 'VP05062', 'พี่แสงน้ำปั่น', 'พี่แสงน้ำปั่น', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1820', 'VP05063', 'พี่นุกุ้งสด', 'พี่นุกุ้งสด', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1821', 'VP05064', 'ร้านลูกชิ้นหมูปิ้ง', 'ร้านลูกชิ้นหมูปิ้ง', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1822', 'VP05065', 'ปิ่นก๋วยเตี๋ยว', 'ปิ่นก๋วยเตี๋ยว', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1823', 'VP05066', 'ร้านหรั่งยำแซ่บ', 'ร้านหรั่งยำแซ่บ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1824', 'VP05067', 'ร้านเฉาก๊วยเต็งหนึ่ง', 'ร้านเฉาก๊วยเต็งหนึ่ง', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1825', 'VP05069', 'ข้าวหมูแดงพี่กาญ', 'ข้าวหมูแดงพี่กาญ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1826', 'VP05070', 'Amazon ปตท', 'Amazon ปตท', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1827', 'VP05071', 'ร้านยำแรด', 'ร้านยำแรด', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1828', 'VP05072', 'พี่ศรีชาบู', 'พี่ศรีชาบู', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1829', 'VP05073', 'ชาราณี', 'ชาราณี', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1830', 'VP09050', 'ลูกชิ้นพี่ทิพย์', 'ลูกชิ้นพี่ทิพย์', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1831', 'VP09051', 'ก๋วยเตี๋ยวเนื้อ', 'ก๋วยเตี๋ยวเนื้อ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1832', 'VP09052', 'ร้านตามกาลเวลา', 'ร้านตามกาลเวลา', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1833', 'VP09053', 'หมีพ่นไฟ', 'หมีพ่นไฟ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1834', 'VP09054', 'ไซค์งาน ซ.8', 'ไซค์งาน ซ.8', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1835', 'VP09055', 'สะบัดสาก', 'สะบัดสาก', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1836', 'VP05075', 'ป้านาง', 'ป้านาง', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1837', 'VP05076', 'พี่มล หอยขม', 'พี่มล หอยขม', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1838', 'VP05077', 'ป้านวลจันทร์ ลูกชิ้น', 'ป้านวลจันทร์ ลูกชิ้น', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1839', 'VP04051', 'พี่หนา', 'พี่หนา', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1840', 'VP04052', 'เกี๊ยวปลา', 'เกี๊ยวปลา', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1841', 'VP04053', 'โอซาก้า', 'โอซาก้า', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1842', 'VP04054', 'SC1865 อเมซอน', 'SC1865 อเมซอน', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1843', 'VP04055', 'พี่หมวย', 'พี่หมวย', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1844', 'VP04056', 'ปลาหมึกย่าง', 'ปลาหมึกย่าง', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1845', 'VP04057', 'บ้านกล้วยไม้', 'บ้านกล้วยไม้', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1846', 'VP04058', 'พี่นันท์', 'พี่นันท์', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1847', 'VP04059', 'ป้าสุนีย์', 'ป้าสุนีย์', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1848', 'VP04060', 'ธาราไอซ์', 'ธาราไอซ์', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1849', 'VP02085', 'สนง', 'สนง', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1850', 'VP09056', 'เหล่าซา', 'เหล่าซา', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1851', 'VP05081', '641', '641', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1852', 'VP05096', 'ร้านน้ำพี่จุก', 'ร้านน้ำพี่จุก', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1853', 'VP05100', 'ทดลอง', 'ทดลอง', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1854', 'VP05102', 'พี่อี๊ด', 'พี่อี๊ด', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1855', 'VP05106', 'ละมุน', 'ละมุน', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1856', 'VP06061', 'เจ๊ซิ้ม', 'เจ๊ซิ้ม', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1857', 'VP05111', 'เครป', 'เครป', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1858', 'VP01088', 'พี่โย', 'พี่โย', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1859', 'VP05115', 'เจ๊กระเทย', 'เจ๊กระเทย', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1860', 'VP08040', 'ขายดี', 'ขายดี', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1861', 'VP08042', 'ส้มตำ', 'ส้มตำ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1862', 'VP09060', 'ชา', 'ชา', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1863', 'VP04063', 'สายลม', 'สายลม', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1864', 'VP03055', 'ไซร์งาน', 'ไซร์งาน', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1865', 'VP09061', 'ข้าวซอย', 'ข้าวซอย', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1866', 'VP05122', 'เตี๋ยวไก่มะระ', 'เตี๋ยวไก่มะระ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1867', 'VP08046', 'ก๋วยเตี๋ยว', 'ก๋วยเตี๋ยว', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1868', 'VP03057', 'พี่แหม่ม', 'พี่แหม่ม', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1869', 'VP05125', 'พี่สำราญ', 'พี่สำราญ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1870', 'VP05126', 'น้องแก้มขายน้ำ', 'น้องแก้มขายน้ำ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1871', 'VP05127', 'เจมส์บอย', 'เจมส์บอย', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1872', 'VP01089', 'บ้านสวนป้ารัก', 'บ้านสวนป้ารัก', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1873', 'VP09062', 'พัฟฟี่เค้ก', 'พัฟฟี่เค้ก', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1874', 'VP09064', 'ร้านน้ำ', 'ร้านน้ำ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1875', 'VP03058', 'ป้าแก้ว', 'ป้าแก้ว', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1876', 'VP09065', 'กล้วยทอด', 'กล้วยทอด', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1877', 'VP01091', 'พี่เชษฐ์', 'พี่เชษฐ์', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1878', 'VP08047', 'ลาบร้อยเอ็ด', 'ลาบร้อยเอ็ด', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1879', 'VP05131', 'พี่สุ', 'พี่สุ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1880', 'VP05132', 'ทาโยยากิ', 'ทาโยยากิ', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1881', 'VP05133', 'ก๋วยเตี๋ยวไก่', 'ก๋วยเตี๋ยวไก่', null, '', null, null, null, null, '1', null, null, '1610022029', '1610022029', null, null, '', null);
INSERT INTO `customer` VALUES ('1882', 'VP05134', 'Aquas', 'Aquas', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1883', 'VP02087', 'น้ำผลไม้ปั่นพี่เปิ้ล', 'น้ำผลไม้ปั่นพี่เปิ้ล', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1884', 'VP01092', 'บ้านกาแฟ ม.พฤกษา 8 ซ.1', 'บ้านกาแฟ ม.พฤกษา 8 ซ.1', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1885', 'VP01093', 'บ้านกาแฟ ม.พฤกษา 4 ซ.1', 'บ้านกาแฟ ม.พฤกษา 4 ซ.1', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1886', 'VP04065', 'ร้านชาพะยอม', 'ร้านชาพะยอม', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1887', 'VP08048', 'ต้มเลือดหมู', 'ต้มเลือดหมู', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1888', 'VP08049', 'ร้านชา', 'ร้านชา', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1889', 'VP10041', 'ร้านผู้ใหญ่', 'ร้านผู้ใหญ่', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1890', 'VP01094', 'พี่กบ', 'พี่กบ', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1891', 'VP01095', 'ร้านค้าทัพแก้ว', 'ร้านค้าทัพแก้ว', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1892', 'VP02088', 'ร้านป้าสว่าง', 'ร้านป้าสว่าง', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1893', 'VP04067', 'Izekimo', 'Izekimo', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1894', 'VP09067', 'N&B', 'N&B', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1895', 'VP01098', 'ตามสั่งลุงสมชาย', 'ตามสั่งลุงสมชาย', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1896', 'VP02089', 'ข้าวแกงป้านิด', 'ข้าวแกงป้านิด', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1897', 'VP01099', 'ร้านลุกชิ้นพี่ภา', 'ร้านลุกชิ้นพี่ภา', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1898', 'VP01100', 'ร้านตามสั่งป้าเล็ก', 'ร้านตามสั่งป้าเล็ก', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1899', 'VP01101', 'ร้านค้าพี่แนน', 'ร้านค้าพี่แนน', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1900', 'VP01102', 'กาแฟรถเข็น', 'กาแฟรถเข็น', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1901', 'VP01103', 'ร้านส้มตำป้าจิตร', 'ร้านส้มตำป้าจิตร', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1902', 'VP09068', 'หนองโพ', 'หนองโพ', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1903', 'VP02091', 'เฮง เฮง', 'เฮง เฮง', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1904', 'VP01104', 'ร้านพี่ปุ๋ยตำรัว', 'ร้านพี่ปุ๋ยตำรัว', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1905', 'VP01105', 'ร้านขนมจีนพี่อุ้ม', 'ร้านขนมจีนพี่อุ้ม', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1906', 'VP10043', 'พี่น้ำน้ำแข็งใส', 'พี่น้ำน้ำแข็งใส', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1907', 'VP05135', 'พี่นกเป็ดพะโล้', 'พี่นกเป็ดพะโล้', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1908', 'VP05136', 'พี่อ้อยตามสั่ง', 'พี่อ้อยตามสั่ง', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1909', 'VP09069', 'ร้านน้ำพันทิพา', 'ร้านน้ำพันทิพา', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1910', 'VP06064', 'ร้านก๋วยจั๊บ', 'ร้านก๋วยจั๊บ', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1911', 'VP02092', 'ร้านปลาหมึกพี่ปิ้ง', 'ร้านปลาหมึกพี่ปิ้ง', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1912', 'VP09070', 'พี่เบ็นขายน้ำ', 'พี่เบ็นขายน้ำ', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1913', 'VP09071', 'POTATA', 'POTATA', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1914', 'VP09072', 'แกงใต้', 'แกงใต้', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1915', 'VP09074', 'Majime', 'Majime', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1916', 'VP02093', 'โรงงานคิวบีซีไอ คลองโยง', 'โรงงานคิวบีซีไอ คลองโยง', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1917', 'VP04068', 'น้ำส้มปั่น เซ็นทรัลศาลายา', 'น้ำส้มปั่น เซ็นทรัลศาลายา', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1918', 'VP09076', 'บาส ลูกชิ้น', 'บาส ลูกชิ้น', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1919', 'VP01106', 'พี่มนตรี', 'พี่มนตรี', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1920', 'VP05139', 'พี่รัตน์', 'พี่รัตน์', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1921', 'VP12006', 'SC1514 อเมซอน-ศิลปากร', 'SC1514 อเมซอน-ศิลปากร', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1922', 'VP12008', 'ป้าไร', 'ป้าไร', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1923', 'VP12009', 'เจ้จิ๋ม', 'เจ้จิ๋ม', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1924', 'VP12011', 'นวลทวี', 'นวลทวี', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1925', 'VP12012', 'กาแฟ ซ.2', 'กาแฟ ซ.2', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1926', 'VP12013', 'ป้าหยก', 'ป้าหยก', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1927', 'VP12014', 'ร้านข้าวแกง 123', 'ร้านข้าวแกง 123', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1928', 'VP12015', 'ปั๊มบางจาก', 'ปั๊มบางจาก', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1929', 'VP12016', 'ไทวัสดุ', 'ไทวัสดุ', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1930', 'VP12017', 'ปั๊มเซลล์', 'ปั๊มเซลล์', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1931', 'VP12018', 'ข้ามต้มม้าหมุน', 'ข้ามต้มม้าหมุน', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1932', 'VP12019', 'ข้าวแกงแม่เสียน', 'ข้าวแกงแม่เสียน', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1933', 'VP12020', 'กาแฟแบ่งปันศิลปากร', 'กาแฟแบ่งปันศิลปากร', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1934', 'VP12021', 'ร้านขนมจีน', 'ร้านขนมจีน', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1935', 'VP12023', 'ก๋วยเตี๋ยวฟ้าแลบ', 'ก๋วยเตี๋ยวฟ้าแลบ', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1936', 'VP12024', 'นมว้าว', 'นมว้าว', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1937', 'VP12025', 'เจ้ยวน', 'เจ้ยวน', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1938', 'VP12026', 'บ้านสวน', 'บ้านสวน', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1939', 'VP12027', 'เจ้กุ๊ก', 'เจ้กุ๊ก', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1940', 'VP12028', 'จ่ามิตร', 'จ่ามิตร', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1941', 'VP12029', 'ข้าวแกงป้าแก่', 'ข้าวแกงป้าแก่', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1942', 'VP12030', 'ก๋วยเตี๋ยวริมทาง', 'ก๋วยเตี๋ยวริมทาง', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1943', 'VP12031', 'ร้านน้ำปั่น', 'ร้านน้ำปั่น', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1944', 'VP12032', 'บ้านขายผัก', 'บ้านขายผัก', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1945', 'VP12033', 'เจ้เรณู', 'เจ้เรณู', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1946', 'VP12034', 'ร้านมิ้งมด', 'ร้านมิ้งมด', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1947', 'VP12035', 'รุ่งทิพย์', 'รุ่งทิพย์', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1948', 'VP12036', 'ป้าลี ซ.2', 'ป้าลี ซ.2', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1949', 'VP12041', 'จ๊อปูเยาวราช', 'จ๊อปูเยาวราช', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1950', 'VP12042', 'ร้านไก่ย่างห้าดาว', 'ร้านไก่ย่างห้าดาว', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1951', 'VP12043', 'ร้านชานม โลตัส', 'ร้านชานม โลตัส', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1952', 'VP12044', 'ร้านเบียร์โซไซตี้', 'ร้านเบียร์โซไซตี้', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1953', 'VP12045', 'ชานม-ตัดผม', 'ชานม-ตัดผม', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1954', 'VP13001', 'ตามสั่งหน้า', 'ตามสั่งหน้า', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1955', 'VP13002', 'The For Rest', 'The For Rest', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1956', 'VP13007', 'จูน สตูดิโอ', 'จูน สตูดิโอ', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1957', 'VP13008', 'ส้มตำไฟแดงหนองขาหยั่ง', 'ส้มตำไฟแดงหนองขาหยั่ง', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1958', 'VP13009', 'อาหารตามสั่งบรรเทิง', 'อาหารตามสั่งบรรเทิง', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1959', 'VP13010', 'ร้านกาแฟโจ๊กบางกอก', 'ร้านกาแฟโจ๊กบางกอก', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1960', 'VP13013', 'เตี๋ยวไก่ พี่วาสนา', 'เตี๋ยวไก่ พี่วาสนา', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1961', 'VP13014', 'ร้านซูชิมั้ย 7', 'ร้านซูชิมั้ย 7', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1962', 'VP13015', 'พี่ทิพย์ นมปั่น ซ.2', 'พี่ทิพย์ นมปั่น ซ.2', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1963', 'VP13016', 'พี่ทิพย์นมปั่น ซ.เสือดุ', 'พี่ทิพย์นมปั่น ซ.เสือดุ', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1964', 'VP13017', 'บ้านผัก', 'บ้านผัก', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1965', 'VP13018', 'ชามิงโก้', 'ชามิงโก้', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1966', 'VP13022', 'กะดึก', 'กะดึก', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1967', 'VP13023', 'ครัวเสน่ห์', 'ครัวเสน่ห์', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1968', 'VP11043', 'สิบล้อรุ่งลดา', 'สิบล้อรุ่งลดา', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1969', 'VP13024', 'ตามสั่งร้านเหลือง', 'ตามสั่งร้านเหลือง', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1970', 'VP05140', 'กล้วยทอดพี่นน', 'กล้วยทอดพี่นน', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1971', 'VP05141', 'ตำนัว', 'ตำนัว', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1972', 'VP06066', 'มารุชา', 'มารุชา', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1973', 'VP06067', 'ร้านสองแซ่บ', 'ร้านสองแซ่บ', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1974', 'VP06068', 'ร้านก๋วยเตี๋ยว', 'ร้านก๋วยเตี๋ยว', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1975', 'VP04069', 'ร้านของชำ', 'ร้านของชำ', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1976', 'VP04070', 'Umm Juice', 'Umm Juice', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1977', 'VP04071', 'ร้ายผลไม้สด', 'ร้ายผลไม้สด', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1978', 'VP04072', 'ข้าวแกง', 'ข้าวแกง', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1979', 'VP02094', 'ก๋วยเตี๋ยวเรือ 10 บาท', 'ก๋วยเตี๋ยวเรือ 10 บาท', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1980', 'VP10044', 'กรูอิ่ม', 'กรูอิ่ม', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1981', 'VP08050', 'ข้าวแกงป้ายา', 'ข้าวแกงป้ายา', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1982', 'VP08051', 'ชาพยอม', 'ชาพยอม', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1983', 'VP13025', 'ร้านเลอรส', 'ร้านเลอรส', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1984', 'VP03059', 'กาแฟอินทนิน', 'กาแฟอินทนิน', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1985', 'VP05143', 'ราชาบะหมี่', 'ราชาบะหมี่', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1986', 'VP13028', 'ร้านหมู หนองปากโลง', 'ร้านหมู หนองปากโลง', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1987', 'VP02099', 'ร้านค้าป้ายิ้ม', 'ร้านค้าป้ายิ้ม', null, '', null, null, null, null, '1', null, null, '1610022030', '1610022030', null, null, '', null);
INSERT INTO `customer` VALUES ('1988', 'VP05144', 'ร้านกาแฟ', 'ร้านกาแฟ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('1989', 'VP05145', 'โรงงานซิตี้ฟู้ด', 'โรงงานซิตี้ฟู้ด', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('1990', 'VP05146', 'ป้ารัตน์', 'ป้ารัตน์', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('1991', 'VP05147', 'ร้านของเก่าญี่ปุ่น', 'ร้านของเก่าญี่ปุ่น', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('1992', 'VP09100', 'พักพิ้งค์', 'พักพิ้งค์', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('1993', 'VP13030', 'กาแฟ', 'กาแฟ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('1994', 'VP07059', 'โต๊ะสนุ๊ก', 'โต๊ะสนุ๊ก', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('1995', 'VP12049', 'ร้านตามสั่ง', 'ร้านตามสั่ง', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('1996', 'VP12050', 'ลูกชิ้น', 'ลูกชิ้น', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('1997', 'VP06069', 'ก๋วยจั๊บ', 'ก๋วยจั๊บ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('1998', 'VP04077', 'พิณทองเรือนแพ', 'พิณทองเรือนแพ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('1999', 'VP04078', 'ข้าวราดแกง', 'ข้าวราดแกง', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2000', 'VP13031', 'โมเอชะ', 'โมเอชะ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2001', 'VP13032', 'ร้านน้ำจับเลี้ยง', 'ร้านน้ำจับเลี้ยง', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2002', 'VP04081', 'สวีทไทม์', 'สวีทไทม์', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2003', 'VP13033', 'ร้านฟรุ๊ตตี้', 'ร้านฟรุ๊ตตี้', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2004', 'VP03060', 'บ่อตกปลาป้าจิน', 'บ่อตกปลาป้าจิน', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2005', 'VP13034', 'น้ำจับเลี้ยง', 'น้ำจับเลี้ยง', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2006', 'VP02100', 'ร้านนมหมีปั่น พี่หมวย', 'ร้านนมหมีปั่น พี่หมวย', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2007', 'VP12010', 'อเมซอนธรรมศาลา', 'อเมซอนธรรมศาลา', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2008', 'VP07018', 'เจ้ปุ๋ยน้ำหอม', 'เจ้ปุ๋ยน้ำหอม', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2009', 'VP08008', 'Connect ม.เกษตร', 'Connect ม.เกษตร', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, 'M61-11', null);
INSERT INTO `customer` VALUES ('2010', 'VP07053', 'วัดพะเนียงแตก', 'วัดพะเนียงแตก', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2011', 'VP00053', 'ทาโกยากิ', 'ทาโกยากิ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2012', 'VP05082', 'ชาคุณชัย', 'ชาคุณชัย', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2013', 'VP04061', 'ร้านป้าติ๋ว', 'ร้านป้าติ๋ว', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2014', 'VP04062', 'ป้าสุดตา', 'ป้าสุดตา', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2015', 'VP05086', 'สามพี่น้อง', 'สามพี่น้อง', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2016', 'VP05087', 'หมูปลาร้า', 'หมูปลาร้า', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2017', 'VP05088', 'ไข่นกกระทา', 'ไข่นกกระทา', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2018', 'VP05089', 'ร้านคุณนาย', 'ร้านคุณนาย', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2019', 'VP05090', 'ร้านป้าเวียงโคตรแซ่บ', 'ร้านป้าเวียงโคตรแซ่บ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2020', 'VP05091', 'ร้านแอมบาร์บีคิว', 'ร้านแอมบาร์บีคิว', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2021', 'VP05093', 'ไตเติ้ล', 'ไตเติ้ล', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2022', 'VP05097', 'พี่ต่าย', 'พี่ต่าย', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2023', 'VP05103', 'ร้านไข่', 'ร้านไข่', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2024', 'VP10040', 'พี่ทา', 'พี่ทา', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2025', 'VP09059', 'ดังกิ้น', 'ดังกิ้น', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2026', 'VP03054', 'ป้าวันดี', 'ป้าวันดี', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2027', 'VP05123', 'ชาคุณชัย 2', 'ชาคุณชัย 2', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2028', 'VP05124', 'พี่โอ๋', 'พี่โอ๋', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2029', 'VP06063', 'น้ำปั่น', 'น้ำปั่น', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2030', 'VP04064', 'ร้านน้ำพี่ตุ่น', 'ร้านน้ำพี่ตุ่น', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2031', 'VP09066', 'กาแฟมวลชน', 'กาแฟมวลชน', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2032', 'VP04066', 'ร้านของชำป้าสม', 'ร้านของชำป้าสม', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2033', 'VP02095', 'ร้านข้าวแกงพี่ตุ่ม ซ. 2', 'ร้านข้าวแกงพี่ตุ่ม ซ. 2', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2034', 'VP05142', 'เฮียยุทธข้าวแกง', 'เฮียยุทธข้าวแกง', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2035', 'VP02096', 'ร้านของชำป้าบังอร', 'ร้านของชำป้าบังอร', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2036', 'VP02097', 'ร้านอาหารเจ', 'ร้านอาหารเจ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2037', 'VP12046', 'วาฟเฟิล', 'วาฟเฟิล', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2038', 'VP12047', 'แคปหมู', 'แคปหมู', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2039', 'VP02098', 'ร้านกันเองข้าวมันไก่', 'ร้านกันเองข้าวมันไก่', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2040', 'VP09098', 'ร้านนมรุ้ง', 'ร้านนมรุ้ง', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2041', 'VP11048', 'ร้านเทิกไทส', 'ร้านเทิกไทส', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2042', 'VP12048', 'ผลไม้ดอง', 'ผลไม้ดอง', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2043', 'VP07058', 'ตามสั่ง', 'ตามสั่ง', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2044', 'VP04073', 'ร้านกาแฟแนน', 'ร้านกาแฟแนน', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2045', 'VP08052', 'ไก่ทอด', 'ไก่ทอด', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2046', 'VP09099', 'สวนสาธารณะ', 'สวนสาธารณะ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2047', 'VP07061', 'น้ำมะพร้าวพรชัย', 'น้ำมะพร้าวพรชัย', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2048', 'VP04082', 'ยาม', 'ยาม', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2049', 'VP10046', 'ร้านป้าก่ำ', 'ร้านป้าก่ำ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2050', 'VP05078', 'เจ้าของตลาด', 'เจ้าของตลาด', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2051', 'VP05079', 'เจ้ทราย', 'เจ้ทราย', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2052', 'VP05080', 'ดร๊าฟ', 'ดร๊าฟ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2053', 'VP05083', 'เอกปลาสด', 'เอกปลาสด', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2054', 'VP05084', 'เนอาร์', 'เนอาร์', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2055', 'VP05085', 'น้องกิ๊ฟ', 'น้องกิ๊ฟ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2056', 'VP05092', 'พี่ดอย', 'พี่ดอย', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2057', 'VP05094', 'บาส', 'บาส', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2058', 'VP05098', 'น้องแก้ม', 'น้องแก้ม', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2059', 'VP05099', 'เอกส้ม', 'เอกส้ม', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2060', 'VP05101', 'เกมส์', 'เกมส์', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2061', 'VP09058', 'ร้านน้ำผลไม้', 'ร้านน้ำผลไม้', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2062', 'VP05105', 'นุช', 'นุช', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2063', 'VP05107', 'แคท', 'แคท', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2064', 'VP05108', 'พี่ทอม', 'พี่ทอม', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2065', 'VP06062', 'เบิร์ด', 'เบิร์ด', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2066', 'VP05109', 'ป้า', 'ป้า', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2067', 'VP05110', 'คุณสุ', 'คุณสุ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2068', 'VP05113', '3พี่น้อง', '3พี่น้อง', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2069', 'VP05114', 'นานา', 'นานา', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2070', 'VP08041', 'ยำทะเล', 'ยำทะเล', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2071', 'VP05117', 'หอมซี๊ดปาก', 'หอมซี๊ดปาก', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2072', 'VP05118', 'เจ๊', 'เจ๊', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2073', 'VP05119', 'พันฟลาวเวอร์', 'พันฟลาวเวอร์', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2074', 'VP05121', 'เจ๊เพ็ญ', 'เจ๊เพ็ญ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2075', 'VP05128', 'เจ๊ทราย', 'เจ๊ทราย', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2076', 'VP05129', 'พี่เลย์', 'พี่เลย์', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2077', 'VP05130', 'นิสิต', 'นิสิต', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2078', 'VP01090', 'พี่พัดคลองเจ๊ก', 'พี่พัดคลองเจ๊ก', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2079', 'VP01096', 'ร้านพี่อ้นหมูสด', 'ร้านพี่อ้นหมูสด', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2080', 'VP01097', 'กาแฟโบราณพี่สมบูรณ์', 'กาแฟโบราณพี่สมบูรณ์', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2081', 'VP02090', 'พี่พลอย', 'พี่พลอย', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2082', 'VP05137', 'พี่ต๋องไก่ทอด', 'พี่ต๋องไก่ทอด', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2083', 'VP05138', 'ชลิดา', 'ชลิดา', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2084', 'VP07056', 'ปลาเผา', 'ปลาเผา', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2085', 'VP06065', 'ร้านยำ', 'ร้านยำ', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2086', 'VP04074', 'ขนมคุณทิพย์', 'ขนมคุณทิพย์', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2087', 'VP04075', 'เฮียกุ่ยลูกชิ้นปลา', 'เฮียกุ่ยลูกชิ้นปลา', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2088', 'VP04076', 'โมเดลน้ำผลไม้', 'โมเดลน้ำผลไม้', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2089', 'VP10045', 'พี่โยก๋วยเตี๋ยว', 'พี่โยก๋วยเตี๋ยว', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2090', 'VP13029', 'พี่ต้นน้ำอ้อย', 'พี่ต้นน้ำอ้อย', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2091', 'VP04079', 'เสน่ห์น้ำพริก', 'เสน่ห์น้ำพริก', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2092', 'VP04080', 'ยำขนมจีนแม่ตุ๊', 'ยำขนมจีนแม่ตุ๊', null, '', null, null, null, null, '1', null, null, '1610022031', '1610022031', null, null, '', null);
INSERT INTO `customer` VALUES ('2093', 'VP07006', 'ร้านน้ำA6 ล่าง', 'ร้านน้ำA6 ล่าง', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'S61-05', null);
INSERT INTO `customer` VALUES ('2094', 'VP07007', 'ร้านน้ำเปิ้ล+น้ำปั่น', 'ร้านน้ำเปิ้ล+น้ำปั่น', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2095', 'VP07023', 'ป้าหยุด', 'ป้าหยุด', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2096', 'VP07024', 'แกงใต้นู๋นุ้ย', 'แกงใต้นู๋นุ้ย', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2097', 'VP07029', 'ชาพะยอม', 'ชาพะยอม', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2098', 'VP07030', 'น้องพลอย', 'น้องพลอย', null, 'คุณเรณู', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'C63-05,S63-39', null);
INSERT INTO `customer` VALUES ('2099', 'VP07031', 'ดำข้าวหน้าเป็ด', 'ดำข้าวหน้าเป็ด', null, 'คุณมิตร', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2100', 'VP07033', 'ป้าแขก', 'ป้าแขก', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2101', 'VP07034', 'ป้าเพ็ญราชภัฎ', 'ป้าเพ็ญราชภัฎ', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2102', 'VP07036', 'ส้มตำเรณู', 'ส้มตำเรณู', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2103', 'VP08034', 'ของชำปาณิสา', 'ของชำปาณิสา', null, 'คุณปาณิสา', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2104', 'VP09006', 'คาปี ร้านกาแฟ', 'คาปี ร้านกาแฟ', null, 'คุณนิด', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2105', 'VP09007', 'คาปี โรงครัว', 'คาปี โรงครัว', null, 'คุณนิด', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'S62-165,168,M62-43,72', null);
INSERT INTO `customer` VALUES ('2106', 'VP09008', 'คาปี คาราโอเกะ', 'คาปี คาราโอเกะ', null, 'คุณนิด', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2107', 'VP10006', 'กาแฟ - ลูกชิ้น ป้าจิน', 'กาแฟ - ลูกชิ้น ป้าจิน', null, 'คุณจิน', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2108', 'VP10008', 'เจ้สำรวย ของชำ', 'เจ้สำรวย ของชำ', null, 'คุณสำรวย', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2109', 'VP10010', 'ร.ร.ตาก้อง ข้าวแกง', 'ร.ร.ตาก้อง ข้าวแกง', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2110', 'VP10014', 'เจ้พรกาแฟ', 'เจ้พรกาแฟ', null, 'คุณพร', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2111', 'VP10018', 'บ้านกระชาย ตาสัน', 'บ้านกระชาย ตาสัน', null, 'คุณสัน', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'S62-117', null);
INSERT INTO `customer` VALUES ('2112', 'VP10019', 'แจ๋มโชห่วย', 'แจ๋มโชห่วย', null, 'คุณสิริวิมล', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'A61-44', null);
INSERT INTO `customer` VALUES ('2113', 'VP10021', 'น้องนาง ของชำ', 'น้องนาง ของชำ', null, 'คุณนาง', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2114', 'VP10034', 'กาแฟแม่จ๋า พี่อ้วน', 'กาแฟแม่จ๋า พี่อ้วน', null, 'คุณเสมา', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'S63-37', null);
INSERT INTO `customer` VALUES ('2115', 'VP10039', 'ตั้มโชห่วย', 'ตั้มโชห่วย', null, 'คุณวิศรุต', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'A63-47', null);
INSERT INTO `customer` VALUES ('2116', 'VP12001', 'โรงแรมไมด้า', 'โรงแรมไมด้า', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2117', 'VP12002', 'ไมด้าไคลแม็ก', 'ไมด้าไคลแม็ก', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2118', 'VP12003', 'อเมซอน รร.เซ็น', 'อเมซอน รร.เซ็น', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2119', 'VP12004', 'โรงแรมเซ็น', 'โรงแรมเซ็น', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2120', 'VP12007', 'ร้านอิ๊ว', 'ร้านอิ๊ว', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2121', 'VP08006', 'กาแฟพันธุ์ไทย PT อ้อน้อย', 'กาแฟพันธุ์ไทย PT อ้อน้อย', null, '', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '', null);
INSERT INTO `customer` VALUES ('2122', 'CJ01001', 'สิรินธร', 'สิรินธร', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 143/32 หมู่ 2 ต.สนามจันทร์ อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2123', 'CJ01002', 'ลาดปลาเค้า', 'ลาดปลาเค้า', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 37/6 หมู่9 ต.บางแขม อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2124', 'CJ01003', 'สระกระเทียม', 'สระกระเทียม', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 115 หมู่ 1 ตำบลสวนป่าน อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2125', 'CJ01005', 'ดอนทราย', 'ดอนทราย', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 82/30 หมู่ 9 ต.ดอนทราย อ.โพธาราม จ.ราชบุรี 70120', null);
INSERT INTO `customer` VALUES ('2126', 'CJ01006', 'หลุมดิน', 'หลุมดิน', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 94 หมู่ที่ 6 ตำบลหลุมดิน อำเภอเมืองราชบุรี จังหวัดราชบุรี 70000', null);
INSERT INTO `customer` VALUES ('2127', 'CJ01007', 'บ้านไร่', 'บ้านไร่', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 223/2 ถนนมนตรีสุริยวงศ์ ตำบลหน้าเมือง อำเภอเมืองราชบุรี จังหวัดราชบุรี 70000', null);
INSERT INTO `customer` VALUES ('2128', 'CJ01008', 'ดอนตะโก', 'ดอนตะโก', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 252/7 หมู่ 3 ต.ดอนตะโก อ.เมืองราชบุรี จ.ราชบุรี 70000', null);
INSERT INTO `customer` VALUES ('2129', 'CJ01009', 'เมืองทอง', 'เมืองทอง', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 99/4 ถ.สมบูรณ์กุล ต.หน้าเมือง อ.เมืองราชบุรี จ.ราชบุรี 70000', null);
INSERT INTO `customer` VALUES ('2130', 'CJ01010', 'แยกต้นสำโรง', 'แยกต้นสำโรง', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 37/26 ถ.เจดีย์หัก ต.หน้าเมือง อ.เมืองราชบุรี จ.ราชบุรี 70000', null);
INSERT INTO `customer` VALUES ('2131', 'CJ01011', 'เขาวัง', 'เขาวัง', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 152 หมู่ 10 ต.เจดีย์หัก อ.เมืองราชบุรี จ.ราชบุรี 70000', null);
INSERT INTO `customer` VALUES ('2132', 'CJ01012', 'เจดีย์หัก', 'เจดีย์หัก', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 225/3 หมู่ 11 ต.เจดีย์หัก อ.เมืองราชบุรี จ.ราชบุรี 70000', null);
INSERT INTO `customer` VALUES ('2133', 'CJ01013', 'เขางู', 'เขางู', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 240 หมู่ 5 ต.เจดีย์หัก อ.เมืองราชบุรี จ.ราชบุรี 70000', null);
INSERT INTO `customer` VALUES ('2134', 'CJ01014', 'จอมบึง2', 'จอมบึง2', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 680 หมู่ 3 ต.จอมบึง อ.จอมบึง จ.ราชบุรี 70150', null);
INSERT INTO `customer` VALUES ('2135', 'CJ01015', 'จอมบึง 1', 'จอมบึง 1', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 299/18 หมู่ 3 ต.จอมบึง อ.จอมบึง จ.ราชบุรี 70150', null);
INSERT INTO `customer` VALUES ('2136', 'CJ01016', 'ด่านทับตะโก', 'ด่านทับตะโก', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 91 หมู่1 ต.ด่านทับตะโก อ.จอมบึง จ.ราชบุรี 70150', null);
INSERT INTO `customer` VALUES ('2137', 'CJ01017', 'ชัฎป่าหวาย', 'ชัฎป่าหวาย', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 5/20 หมู่ 1 ต.ป่าหวาย อ.สวนผึ้ง จ.ราชบุรี 70180', null);
INSERT INTO `customer` VALUES ('2138', 'CJ01018', 'สวนผึ้ง', 'สวนผึ้ง', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 140/3 หมู่1 ต.สวนผึ้ง อ.สวนผึ้ง จ.ราชบุรี 70180', null);
INSERT INTO `customer` VALUES ('2139', 'CJ01019', 'บ้านคา', 'บ้านคา', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 43/7 หมู่ 1 ต.บ้านคา อ.บ้านคา จ.ราชบุรี 70180', null);
INSERT INTO `customer` VALUES ('2140', 'CJ01020', 'ห้วยชินสีห์', 'ห้วยชินสีห์', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 143/4 หมู่7 ต.อ่างทอง อ.เมือง จ.ราชบุรี 70000', null);
INSERT INTO `customer` VALUES ('2141', 'CJ01021', 'ตลาดนัดบ้านนา', 'ตลาดนัดบ้านนา', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 245 หมู่ที่ 1 ตำบลโพรงมะเดื่อ อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2142', 'CJ02001', 'บึงกระจับ', 'บึงกระจับ', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 24/12  หมู่ที่ 5  ตำบลหนองอ้อ  อำเภอบ้านโป่ง  จังหวัดราชบุรี  70110', null);
INSERT INTO `customer` VALUES ('2143', 'CJ02002', 'โป่งดุสิต', 'โป่งดุสิต', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 110/19 ถ.หลังสถานี ต.บ้านโป่ง อ.บ้านโป่ง จ.ราชบุรี 70110', null);
INSERT INTO `customer` VALUES ('2144', 'CJ02003', 'ปากแรต', 'ปากแรต', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 13/17 ถ.ค่ายหลวง ต.บ้านโป่ง อ.บ้านโป่ง จ.ราชบุรี 70110', null);
INSERT INTO `customer` VALUES ('2145', 'CJ02004', 'เบิกไพร', 'เบิกไพร', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 86/17-19 หมู่6 ต.เบิกไพร อ.บ้านโป่ง จ.ราชบุรี 70110', null);
INSERT INTO `customer` VALUES ('2146', 'CJ02005', 'ไผ่สามเกาะ', 'ไผ่สามเกาะ', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 127 หมู่ 17 ต.เขาขลุง อ.บ้านโป่ง จ.ราชบุรี 70110', null);
INSERT INTO `customer` VALUES ('2147', 'CJ02006', 'เขาขวาง', 'เขาขวาง', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 163 หมู่6 ต.นางแก้ว อ.โพธาราม จ.ราชบุรี 70120', null);
INSERT INTO `customer` VALUES ('2148', 'CJ02007', 'ท่าชุมพล', 'ท่าชุมพล', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 253 หมู่ที่ 2 ตำบลท่าชุมพล อำเภอโพธาราม จังหวัดราชบุรี 70120', null);
INSERT INTO `customer` VALUES ('2149', 'CJ02008', 'ท่าวัด', 'ท่าวัด', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 18 ถ.ท่าวัด ต.โพธาราม อ.โพธาราม จ.ราชบุรี 70120', null);
INSERT INTO `customer` VALUES ('2150', 'CJ02009', 'ตลาดโพธาราม', 'ตลาดโพธาราม', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 209 ถนนโชคชัย ตำบลโพธาราม อำเภอโพธาราม จังหวัดราชบุรี 70120', null);
INSERT INTO `customer` VALUES ('2151', 'CJ02010', 'บ้านฆ้อง', 'บ้านฆ้อง', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 121/1 หมู่ 2 ต.บ้านฆ้อง อ.โพธาราม จ.ราชบุรี 70120', null);
INSERT INTO `customer` VALUES ('2152', 'CJ02011', 'บางแพ', 'บางแพ', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 167/5 หมู่ 5 ต.บางแพ อ.บางแพ จ.ราชบุรี 70160', null);
INSERT INTO `customer` VALUES ('2153', 'CJ02012', 'บ้านไร่ชาวเหนือ', 'บ้านไร่ชาวเหนือ', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 351 หมู่ 4 ต.บ้านไร่ อ.ดำเนินสะดวก จ.ราชบุรี 70130', null);
INSERT INTO `customer` VALUES ('2154', 'CJ02013', 'โพหัก', 'โพหัก', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 192 หมู่ 3 ต.โพหัก อ.บางแพ จ.ราชบุรี 70160', null);
INSERT INTO `customer` VALUES ('2155', 'CJ02014', 'ประสาทสิทธิ์', 'ประสาทสิทธิ์', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 413 หมู่ 5 ต.ประสาทสิทธิ์ อ.ดำเนินสะดวก จ.ราชบุรี 70130', null);
INSERT INTO `customer` VALUES ('2156', 'CJ02015', 'ดอนกรวย', 'ดอนกรวย', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 107/6 หมู่ที่ 5  ตำบลดอนกรวย  อำเภอดำเนินสะดวก  จังหวัดราชบุรี  70130', null);
INSERT INTO `customer` VALUES ('2157', 'CJ02016', 'ดำเนิน 1', 'ดำเนิน 1', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 162 หมู่ 4 ต.ท่านัด อ.ดำเนินสะดวก จ.ราชบุรี 70130', null);
INSERT INTO `customer` VALUES ('2158', 'CJ02017', 'ตลาดน้ำดำเนิน2', 'ตลาดน้ำดำเนิน2', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 399 หมู่9 ต.ดำเนินสะดวก อ.ดำเนินสะดวก จ.ราชบุรี 70130', null);
INSERT INTO `customer` VALUES ('2159', 'CJ02018', 'วัดเพลง', 'วัดเพลง', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 59/1 หมู่ 5 ต.วัดเพลง อำภอวัดเพลง จ.ราชบุรี 70170', null);
INSERT INTO `customer` VALUES ('2160', 'CJ02019', 'ปากท่อ1', 'ปากท่อ1', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 399  หมู่ที่ 1  ตำบลปากท่อ  อำเภอปากท่อ  จังหวัดราชบุรี  70140', null);
INSERT INTO `customer` VALUES ('2161', 'CJ02020', 'ปากท่อ3', 'ปากท่อ3', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 404 หมู่ 4 ต.ดอนทราย อ.ปากท่อ จ.ราชบุรี 70140', null);
INSERT INTO `customer` VALUES ('2162', 'CJ02021', 'ปากท่อ2', 'ปากท่อ2', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 134/1 หมู่ 4 ต.ดอนทราย อ.ปากท่อ จ.ราชบุรี 70140', null);
INSERT INTO `customer` VALUES ('2163', 'CJ03001', 'สนามจันทร์', 'สนามจันทร์', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 51/3 ถ.สนามจันทร์ ต.สนามจันทร์ อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2164', 'CJ03002', 'เหนือวัง', 'เหนือวัง', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 18 ถ.ข้างวัง ต.พระปฐมเจดีย์ อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2165', 'CJ03003', 'สวนตะไคร้', 'สวนตะไคร้', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 41/2 ถ.สวนตะไคร้ ต.สนามจันทร์ อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2166', 'CJ03004', 'ลำพยา', 'ลำพยา', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 35/1 หมู่ 3 ต.ลำพยา อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2167', 'CJ03005', 'โพรงมะเดื่อ', 'โพรงมะเดื่อ', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 18/23 หมู่ที่ 14 ตำบลโพรงมะเดื่อ อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2168', 'CJ03006', 'วัดลาดหญ้าไทร', 'วัดลาดหญ้าไทร', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, '177  หมู่ที่ 10  ตำบลห้วยขวาง  อำเภอกำแพงแสน จังหวัดนครปฐม  73140', null);
INSERT INTO `customer` VALUES ('2169', 'CJ03007', 'หนองงูเหลือม', 'หนองงูเหลือม', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'ตำบลบางแม่นาง อำเภอบางใหญ่ จังหวัดนนทบุรี 11140', null);
INSERT INTO `customer` VALUES ('2170', 'CJ03008', 'ห้วยกระบอก', 'ห้วยกระบอก', null, 'ราชบุรี', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 117/12 หมู่ 9 ต.กรับใหญ่ อ.บ้านโป่ง จ.ราชบุรี 70110', null);
INSERT INTO `customer` VALUES ('2171', 'CJ03009', 'กำแพงแสน', 'กำแพงแสน', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 244 หมู่ 1 ต.กำแพงแสน อ.กำแพงแสน จ.นครปฐม 73140', null);
INSERT INTO `customer` VALUES ('2172', 'CJ03010', 'PT สาขาพนมทวน', 'PT สาขาพนมทวน', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่315 ม.3 ตำบลกำแพงแสน อำเภอกำแพงแสน นครปฐม 73140', null);
INSERT INTO `customer` VALUES ('2173', 'CJ03011', 'PT สาขาหน้าม.เกษตร', 'PT สาขาหน้าม.เกษตร', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่9/9 ตำบลกำแพงแสน อำเภอกำแพงแสน นครปฐม 73140', null);
INSERT INTO `customer` VALUES ('2174', 'CJ03012', 'PT สาขาสระสี่มุม', 'PT สาขาสระสี่มุม', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่18 หมู่12 ตำบลสระสี่มุม อำเภอกำแพงแสน จ.นครปฐม 73140', null);
INSERT INTO `customer` VALUES ('2175', 'CJ03013', 'PT สาขาสระพัฒนา', 'PT สาขาสระพัฒนา', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่12/1 หมู่2 ตำบลสระพัฒนา อำเภอกำแพงแสน จ.นครปฐม 73140', null);
INSERT INTO `customer` VALUES ('2176', 'CJ03014', 'สระพัฒนา', 'สระพัฒนา', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 27 หมู่ที่ 2 ตำบลสระพัฒนา อำเภอกำแพงแสน จังหวัดนครปฐม 73140', null);
INSERT INTO `customer` VALUES ('2177', 'CJ03015', 'บางหลวง', 'บางหลวง', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 238 หมู่ 6 ต.บางหลวง อ.บางเลน จ.นครปฐม 73130', null);
INSERT INTO `customer` VALUES ('2178', 'CJ03016', 'บางเลน', 'บางเลน', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 518 หมู่ที่ 8 ตำบลบางเลน อำเภอบางเลน จังหวัดนครปฐม 73130', null);
INSERT INTO `customer` VALUES ('2179', 'CJ03017', 'ตลาดโรงยาง', 'ตลาดโรงยาง', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 216 หมู่ที่ 13 ตำบลบางปลา อำเภอบางเลน จังหวัดนครปฐม 73130', null);
INSERT INTO `customer` VALUES ('2180', 'CJ03018', 'นราภิรมย์', 'นราภิรมย์', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 229 หมู่ที่ 3 ตำบลนราภิรมย์ อำเภอบางเลน จังหวัดนครปฐม 73130', null);
INSERT INTO `customer` VALUES ('2181', 'CJ03019', 'ศาลายา', 'ศาลายา', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 179/10 หมู่ 5 ต.ศาลายา อ.พุทธมณฑล จ.นครปฐม 73170', null);
INSERT INTO `customer` VALUES ('2182', 'CJ03020', 'ห้วยพลู', 'ห้วยพลู', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 278/1 หมู่ 1 ต.ห้วยพลู อ.นครชัยศรี จ.นครปฐม 73120', null);
INSERT INTO `customer` VALUES ('2183', 'CJ03021', 'บางพระ', 'บางพระ', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 28/41 หมู่ 1 ต.บางพระ อ.นครชัยศรี จ.นครปฐม 73120', null);
INSERT INTO `customer` VALUES ('2184', 'CJ03022', 'บ้านหลวง', 'บ้านหลวง', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 16/1  หมู่ที่ 4  ตำบลดอนพุทรา อำเภอดอนตูม  จังหวัดนครปฐม  73150', null);
INSERT INTO `customer` VALUES ('2185', 'CJ03023', 'ดอนตูม', 'ดอนตูม', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 186 หมู่ 1 ต.สามง่าม อ.ดอนตูม จ.นครปฐม 73150', null);
INSERT INTO `customer` VALUES ('2186', 'CJ03024', 'วัดตาก้อง', 'วัดตาก้อง', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 147/2 หมู่ที่ 10 ตำบลตาก้อง อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2187', 'CJ04001', 'ห้วยจรเข้', 'ห้วยจรเข้', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 19/1 หมู่ 6 ต.ห้วยจรเข้ อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2188', 'CJ04002', 'ทุ่งพระเมรุ', 'ทุ่งพระเมรุ', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 241 ถ.ทวาราวดี ต.ห้วยจรเข้ อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2189', 'CJ04003', 'วัดไผ่ล้อม', 'วัดไผ่ล้อม', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 18/2 ถ.ไผ่เตย ต.ห้วยจรเข้ อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2190', 'CJ04004', 'ต้นสน', 'ต้นสน', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 44 ถ.ราชดำเนิน ต.พระปฐมเจดีย์ อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2191', 'CJ04005', 'ประปานาสร้าง', 'ประปานาสร้าง', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 9/1 ถ.นาสร้าง ต.นครปฐม อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2192', 'CJ04006', 'สี่แยกวัดกลาง', 'สี่แยกวัดกลาง', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022032', '1610022032', null, null, 'เลขที่ 16 ถ.ถวิลราษฎรบูรณะ ต.บ่อพลับ อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2193', 'CJ04007', 'บ่อพลับ', 'บ่อพลับ', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 383 ถ.ทหารบก ต.บ่อพลับ อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2194', 'CJ04008', 'หน้าวัดสามกระบือเผือก', 'หน้าวัดสามกระบือเผือก', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 5/7 หมู่ 4 ต.สามควายเผือก อ.เมืองงนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2195', 'CJ04009', 'พุทธมณฑลสาย7', 'พุทธมณฑลสาย7', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 59/54 หมู่ 2 ต.ท่าตลาด อ.สามพราน จ.นครปฐม 73110', null);
INSERT INTO `customer` VALUES ('2196', 'CJ04010', 'วัดไร่ขิง', 'วัดไร่ขิง', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 69/28 หมู่6 ต.ท่าตลาด อ.สามพราน จ.นครปฐม 73110', null);
INSERT INTO `customer` VALUES ('2197', 'CJ04011', 'ดอนหวาย', 'ดอนหวาย', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 4/2  หมู่ที่ 5  ตำบลบางกระทึก  อำเภอสามพราน  จังหวัดนครปฐม  73210', null);
INSERT INTO `customer` VALUES ('2198', 'CJ04012', 'นครชื่นชุ่ม', 'นครชื่นชุ่ม', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 168/5  หมู่ที่ 7  ตำบลกระทุ่มล้ม อำเภอสามพราน  จังหวัดนครปฐม  73220', null);
INSERT INTO `customer` VALUES ('2199', 'CJ04013', 'ซอยไวไว', 'ซอยไวไว', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 6/256 หมู่ที่ 7 ตำบลไร่ขิง อำเภอสามพราน จังหวัดนครปฐม 73210', null);
INSERT INTO `customer` VALUES ('2200', 'CJ04014', 'เทียนดัด 2', 'เทียนดัด 2', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 43/10 หมู่ 1 ต.บ้านใหม่ อ.สามพราน จ.นครปฐม 73110', null);
INSERT INTO `customer` VALUES ('2201', 'CJ04015', 'เทียนดัด', 'เทียนดัด', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 99/5 หมู่1 ต.บ้านใหม่ อ.สามพราน จ.นครปฐม 73110', null);
INSERT INTO `customer` VALUES ('2202', 'CJ04016', 'สามพราน', 'สามพราน', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 236/9 หมู่ 8 ต.สามพราน อ.สามพราน จ.นครปฐม 73110', null);
INSERT INTO `customer` VALUES ('2203', 'CJ04017', 'แยกอนุสาวรีย์', 'แยกอนุสาวรีย์', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 29/64 หมู่ 1 ต.ท่าตลาด อ.สามพราน จ.นครปฐม 73110', null);
INSERT INTO `customer` VALUES ('2204', 'CJ04018', 'คลองใหม่', 'คลองใหม่', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 127/2 หมู่ที่ 7  ตำบลคลองใหม่ อำเภอสามพราน จังหวัดนครปฐม 73110', null);
INSERT INTO `customer` VALUES ('2205', 'CJ04019', 'ซอยวัดไทร(นครปฐม)', 'ซอยวัดไทร(นครปฐม)', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 20/4 หมู่ 4 ต.ท่าตำหนัก อ.นครชัยศรี จ.นครปฐม 73120', null);
INSERT INTO `customer` VALUES ('2206', 'CJ04020', 'ห้วยตะโก', 'ห้วยตะโก', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 71/3 หมู่ที่ 2 ตำบลพะเนียด อำเภอนครชัยศรี จังหวัดนครปฐม 73120', null);
INSERT INTO `customer` VALUES ('2207', 'CJ04021', 'โคกพระ', 'โคกพระ', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 43/4 หมู่ที่ 4 ตำบลบางระกำ อำเภอนครชัยศรี จังหวัดนครปฐม 73120', null);
INSERT INTO `customer` VALUES ('2208', 'CJ04022', 'ดอนยายหอม', 'ดอนยายหอม', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 262/4 หมู่ 3 ต.ดอนยายหอม อ.เมืองนครปฐม จ.นครปฐม 73000', null);
INSERT INTO `customer` VALUES ('2209', 'CJ04023', 'ตลาดจินดา', 'ตลาดจินดา', null, 'นครปฐม', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'เลขที่ 145 หมู่ที่ 2 ตำบลตลาดจินดา อำเภอสามพราน จังหวัดนครปฐม 73110', null);
INSERT INTO `customer` VALUES ('2210', 'VP08044', 'CJ', 'CJ', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2211', 'VP06030', 'อเมซอน 3ควายเผือก', 'อเมซอน 3ควายเผือก', null, 'คุณกชพร', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'M62-63', null);
INSERT INTO `customer` VALUES ('2212', 'VP06031', 'อเมซอน ปะปา', 'อเมซอน ปะปา', null, 'คุณธนดล', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'M62-26', null);
INSERT INTO `customer` VALUES ('2213', 'VP08013', 'SC2603 อเมซอน โลตัส กพส.', 'SC2603 อเมซอน โลตัส กพส.', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'A63-16', null);
INSERT INTO `customer` VALUES ('2214', 'VP08021', 'อเมซอน ดอนตูม', 'อเมซอน ดอนตูม', null, 'คุณดารารัตน์', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'A61-08M61-05E63-01', null);
INSERT INTO `customer` VALUES ('2215', 'VP08033', 'อเมซอน ปตท กำแพงแสน', 'อเมซอน ปตท กำแพงแสน', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2216', 'VP09002', 'บ.มณฑล (อมซ.ทหารบก)', 'บ.มณฑล (อมซ.ทหารบก)', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'A61-16,S61-37', null);
INSERT INTO `customer` VALUES ('2217', 'VP09003', 'อเมซอล ต้นสน', 'อเมซอล ต้นสน', null, 'คุณกาย', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2218', 'VP09004', 'อเมซอน สิรินธร', 'อเมซอน สิรินธร', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2219', 'VP09005', 'อเมซอน บิ๊กซี', 'อเมซอน บิ๊กซี', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2220', 'VP09048', 'อเมซอน ปตท ข้างแมคโคร', 'อเมซอน ปตท ข้างแมคโคร', null, 'คุณต้น', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2221', 'VP08039', 'อเมซอน หน้า ม.เกษตร', 'อเมซอน หน้า ม.เกษตร', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2222', 'VP08012', 'อเมซอน ตลาดกำแพงแสน', 'อเมซอน ตลาดกำแพงแสน', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2223', 'VP08026', 'อินทนิน ดอนตูม', 'อินทนิน ดอนตูม', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2224', 'VP10025', 'สุนทรีย์ออยล์', 'สุนทรีย์ออยล์', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2225', 'VP10011', 'โกอ๋อง ของชำ+ข้าวมันไก่', 'โกอ๋อง ของชำ+ข้าวมันไก่', null, 'คุณอ๋อง', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2226', 'VP10003', 'หนุงหนิงกาแฟ', 'หนุงหนิงกาแฟ', null, 'คุณหนิง', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2227', 'VP10023', 'ป้าตุ๊ก ของชำ', 'ป้าตุ๊ก ของชำ', null, 'คุณเบญจพานี', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'C65-15', null);
INSERT INTO `customer` VALUES ('2228', 'VP07008', 'ร้านพี่เชต', 'ร้านพี่เชต', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2229', 'VP07009', 'มะลิ-สมชาย', 'มะลิ-สมชาย', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2230', 'VP07010', 'เจ้เพ', 'เจ้เพ', null, 'คุณไร', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2231', 'VP07013', 'ข้าวแกงตาวิว', 'ข้าวแกงตาวิว', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'S62-145,245', null);
INSERT INTO `customer` VALUES ('2232', 'VP07016', 'ร้านมะนาวหวาน', 'ร้านมะนาวหวาน', null, 'คุณหยก', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2233', 'VP07017', 'ข้าวแกง 123', 'ข้าวแกง 123', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2234', 'VP07019', 'ข้าวแกงเจ้สุข', 'ข้าวแกงเจ้สุข', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2235', 'VP07020', 'ข้าวแกงเจ้บัว', 'ข้าวแกงเจ้บัว', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2236', 'VP07041', 'ข้าวแกงข้างพี่เชต', 'ข้าวแกงข้างพี่เชต', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2237', 'VP07057', 'ตำกะยำ', 'ตำกะยำ', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2238', 'VP04011', 'รถนม', 'รถนม', null, '', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, 'ถังเอง', null);
INSERT INTO `customer` VALUES ('2239', 'VP11002', 'โพธาราม3', 'โพธาราม3', null, 'พี่อุ๋ย', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2240', 'VP11004', 'กาญจนวิฐ', 'กาญจนวิฐ', null, 'พี่เวก', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2241', 'VP11005', 'แกงใต้ เจ้สาลี่', 'แกงใต้ เจ้สาลี่', null, 'พี่เปิ้ล', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2242', 'VP11006', 'กะเพราถาด แม่ทิพย์', 'กะเพราถาด แม่ทิพย์', null, 'พี่หมี', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2243', 'VP11007', 'ราชบุรี6', 'ราชบุรี6', null, 'พี่เปิ้ล', null, null, null, null, '1', null, null, '1610022033', '1610022033', null, null, '', null);
INSERT INTO `customer` VALUES ('2244', 'VP11008', 'คามุ', 'คามุ', '1', 'พี่เชต', '2', null, null, '', '1', null, null, '1610022033', '1610699310', null, null, '', '1');
INSERT INTO `customer` VALUES ('2245', 'VP11017', 'อเมซอน ปตท.หนองโพ', 'อเมซอน ปตท.หนองโพ', '1', 'พี่มด', '2', null, null, '', '1', null, null, '1610022033', '1610367830', null, null, '', '1');
INSERT INTO `customer` VALUES ('2246', 'VP11038', 'มินิมาร์ท ปั๊มเซลล์', 'มินิมาร์ท ปั๊มเซลล์', '1', '', '2', null, null, '', '1', null, null, '1610022033', '1610367814', null, null, '', '1');
INSERT INTO `customer` VALUES ('2247', 'VP12005', 'ปั๊ม-พรอำภา', 'ปั๊ม-พรอำภา', '1', '', '1', null, null, '', '1', null, null, '1610022033', '1610278404', null, null, '', '1');
INSERT INTO `customer` VALUES ('2248', 'VP11044', 'ครัวสุพรรณ', 'ครัวสุพรรณ', '1', '', '2', null, null, '', '1', null, null, '1610022033', '1610278390', null, null, '', '2');
INSERT INTO `customer` VALUES ('2249', 'VP11045', 'ศูนย์ฮอนด้า', 'ศูนย์ฮอนด้า', '1', '', '1', null, null, '', '1', null, null, '1610022033', '1610278377', null, null, '', '1');

-- ----------------------------
-- Table structure for `customer_group`
-- ----------------------------
DROP TABLE IF EXISTS `customer_group`;
CREATE TABLE `customer_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_customer_group` (`company_id`),
  KEY `fk_branch_customer_group` (`branch_id`),
  CONSTRAINT `fk_branch_customer_group` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_customer_group` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_group
-- ----------------------------
INSERT INTO `customer_group` VALUES ('1', '001', 'ทดสอบ', 'fdfd', '1', null, null, '1608949052', '1608952700', null, null);

-- ----------------------------
-- Table structure for `customer_type`
-- ----------------------------
DROP TABLE IF EXISTS `customer_type`;
CREATE TABLE `customer_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_type
-- ----------------------------
INSERT INTO `customer_type` VALUES ('1', 'TR20', 'ขายปลีก 20', 'ขายปลีก 20', '1', '1610115919', null, '1610979358', null);
INSERT INTO `customer_type` VALUES ('2', 'ขายปลีก 30', 'ขายปลีก 30', 'ขายปลีก 30', '1', '1610115938', null, '1610119424', null);

-- ----------------------------
-- Table structure for `delivery_route`
-- ----------------------------
DROP TABLE IF EXISTS `delivery_route`;
CREATE TABLE `delivery_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_delivery_route` (`company_id`),
  KEY `fk_branch_delivery_route` (`branch_id`),
  CONSTRAINT `fk_branch_delivery_route` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_delivery_route` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of delivery_route
-- ----------------------------
INSERT INTO `delivery_route` VALUES ('1', '001', 'VP1', 'VP1', null, null, null, '1610347283', null, null);
INSERT INTO `delivery_route` VALUES ('2', '002', 'VP2', 'VP2', null, null, null, '1610347276', null, null);
INSERT INTO `delivery_route` VALUES ('3', '003', 'VP3', 'VP3', null, null, null, '1610347269', null, null);

-- ----------------------------
-- Table structure for `employee`
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `salary_type` int(11) DEFAULT NULL,
  `emp_start` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_employee` (`company_id`),
  KEY `fk_branch_employee` (`branch_id`),
  CONSTRAINT `fk_branch_employee` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_employee` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES ('1', 'AZ01', 'นายศุภชัย', 'สุทธิประภา', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('2', 'AZ02', 'นายหอมหวน', 'รอดหิรัญ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('3', 'AZ03', 'นายมาโนช', 'เอี่ยมละออ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('4', 'AZ04', 'นายพงศ์พัทธ์', 'เลิศวัชรลือชา', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('5', 'AZ05', 'นายรักชาติ', 'ยังแก้ว', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('6', 'AZ06', 'นายอภิชาติ', 'ธนาทัพย์เจริญ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('7', 'AZ07', 'นายตุลา', 'โพธิ์จินดา', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('8', 'CJ01', 'นายอโณทัย', 'มุจะเงิน', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('9', 'VP01', 'นายวสูตร์', 'เหลืองพุ่มพิพัฒน์', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('10', 'VP02', 'นายฉัตรมงคล', 'ทองมณโท', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('11', 'VP03', 'นายนราธิป', 'เฉลิมชัย', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('12', 'VP04', 'นายกัญจน์อมร', 'เกศเกื้อวิชญ์กุล', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('13', 'VP05', 'นายณธกร', 'ศรีเพชร', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('14', 'VP06', 'นายไพรัช', 'มัจฉาชม', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('15', 'VP07', 'นายธำรงค์', 'แก้วพูนผล', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('16', 'VP08', 'นายจตุภัทร', 'อ่วมวงษ์', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('17', 'VP09', 'นายพิพต', 'สุภาเสิด', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('18', 'VP10', 'นายธีรพงษ์', 'เกตุสม', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('19', 'VP11', 'นายสุวัฒน์', 'รัฐลาด', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('20', 'VP12', 'นายณัทพงษ์', 'ตามะนี', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('21', 'VP13', 'นายณราชัย', 'เกิดสมบุญ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('22', 'VP14', 'นายวีรวัฒน์', 'หอมขจร', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('23', 'S001', 'นายประสพโชค', 'ประทุมแก้ว', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('24', 'S002', 'นายธวัชร์', 'อุปการะ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('25', 'S003', 'นายสุพจน์', 'ชีพันธ์', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('26', 'S004', 'นายกฤษณะ', 'ผิวผ่อง', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('27', 'S006', 'นายจีระวัฒน์', 'จ่างแสง', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('28', 'S007', 'นายชาญณรงค์', 'บ่อสอาด', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('29', 'S008', 'นายอานนท์', 'บุญธรรม', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('30', 'S009', 'นายตนุภัทร', 'อิทธิกรวรกุล', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('31', 'S010', 'นายพิสิษฐ์', 'วงษ์จำปา', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('32', 'S011', 'นายนวนนท์', 'นาคนุช', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('33', 'S012', 'นายนิรันดร์', 'ชีพันธ์', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('34', 'S015', 'นายวรนาถ', 'สุวรรณพิทักษ์', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('35', 'S016', 'นายวรพงศ์', 'สงวนชื่อ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('36', 'S017', 'นายพิจักษณ์', 'แสงใหญ่', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('37', 'S018', 'นายกิตติธัช', 'เปี่ยมคล้า', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('38', 'M001', 'นางสาวอนิสรา', 'รักศรี', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('39', 'M002', 'นางสาวสุรัตร์ดา', 'หมวกเมือง', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('40', 'M003', 'นางสาวกันทิมา', 'ชูสุวรรณ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('41', 'M004', 'นางสาวสุทธิดา', 'เอกสินิทธ์กุล', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('42', 'M005', 'นางสาวสุวัจจี', 'ตริศายลักษณ์', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('43', 'S019', 'นายรุ่งเรือง', 'เปล่งปลั่ง', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);

-- ----------------------------
-- Table structure for `location`
-- ----------------------------
DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_location` (`company_id`),
  KEY `fk_branch_location` (`branch_id`),
  CONSTRAINT `fk_branch_location` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_location` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of location
-- ----------------------------
INSERT INTO `location` VALUES ('1', '2', 'LOC01', 'LOC01', '', '', '1', null, null, '1608949019', '1608952467', null, null);

-- ----------------------------
-- Table structure for `member`
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('4', 'niran', null, '1', null);
INSERT INTO `member` VALUES ('5', 'tarlek', null, '2', null);

-- ----------------------------
-- Table structure for `migration`
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1607399800');
INSERT INTO `migration` VALUES ('m130524_201442_init', '1607400303');
INSERT INTO `migration` VALUES ('m180505_140600_create_sequence_table', '1610206908');
INSERT INTO `migration` VALUES ('m190124_110200_add_verification_token_column_to_user_table', '1607400303');
INSERT INTO `migration` VALUES ('m201208_035857_create_company_table', '1607400303');
INSERT INTO `migration` VALUES ('m201208_040301_create_branch_table', '1607400602');
INSERT INTO `migration` VALUES ('m201208_040357_add_tenant_id_column_to_company_table', '1607400303');
INSERT INTO `migration` VALUES ('m201208_041659_add_status_column_to_company_table', '1607401024');
INSERT INTO `migration` VALUES ('m201208_042419_create_addressbook_table', '1607404890');
INSERT INTO `migration` VALUES ('m201208_042926_create_contacts_table', '1607405059');
INSERT INTO `migration` VALUES ('m201208_043127_create_unit_table', '1607405059');
INSERT INTO `migration` VALUES ('m201208_043224_create_product_type_table', '1607405059');
INSERT INTO `migration` VALUES ('m201208_043253_create_customer_group_table', '1607405059');
INSERT INTO `migration` VALUES ('m201208_044133_create_product_group_table', '1607405060');
INSERT INTO `migration` VALUES ('m201208_045324_create_standard_price_table', '1607405060');
INSERT INTO `migration` VALUES ('m201208_052613_create_delivery_route_table', '1607405515');
INSERT INTO `migration` VALUES ('m201208_052942_create_employee_table', '1607405515');
INSERT INTO `migration` VALUES ('m201208_074407_create_warehouse_table', '1607413666');
INSERT INTO `migration` VALUES ('m201208_074431_create_location_table', '1607413666');
INSERT INTO `migration` VALUES ('m201208_080819_create_car_type_table', '1607415143');
INSERT INTO `migration` VALUES ('m201208_081001_create_car_table', '1607415143');
INSERT INTO `migration` VALUES ('m201208_082456_create_orders_table', '1607416117');
INSERT INTO `migration` VALUES ('m201208_082630_create_order_line_table', '1607416117');
INSERT INTO `migration` VALUES ('m201208_083739_create_user_group_table', '1607431347');
INSERT INTO `migration` VALUES ('m201208_124019_create_customer_table', '1607431347');
INSERT INTO `migration` VALUES ('m201208_125131_create_product_table', '1607431993');
INSERT INTO `migration` VALUES ('m201208_132837_create_member_table', '1607434142');
INSERT INTO `migration` VALUES ('m201208_133314_add_status_column_to_member_table', '1607434400');
INSERT INTO `migration` VALUES ('m201209_094324_add_note_column_to_orders_table', '1607507012');
INSERT INTO `migration` VALUES ('m210107_121716_add_contact_name_column_to_customer_table', '1610021843');
INSERT INTO `migration` VALUES ('m210107_134401_add_sale_status_column_to_product_table', '1610027047');
INSERT INTO `migration` VALUES ('m210107_154145_create_customer_type_table', '1610034116');
INSERT INTO `migration` VALUES ('m210107_154731_create_price_group_table', '1610034703');
INSERT INTO `migration` VALUES ('m210107_155137_create_price_group_line_table', '1610034703');
INSERT INTO `migration` VALUES ('m210108_144031_create_price_customer_type_table', '1610116890');
INSERT INTO `migration` VALUES ('m210108_150930_add_customer_type_column_to_customer_table', '1610118577');
INSERT INTO `migration` VALUES ('m210109_134756_create_sale_group_table', '1610200083');
INSERT INTO `migration` VALUES ('m210110_153026_create_sale_com_table', '1610292836');
INSERT INTO `migration` VALUES ('m210110_153249_create_sale_com_summary_table', '1610292836');
INSERT INTO `migration` VALUES ('m210114_151250_add_customer_id_column_to_order_line_table', '1610637175');
INSERT INTO `migration` VALUES ('m210115_015438_create_payment_method_table', '1610675684');
INSERT INTO `migration` VALUES ('m210115_033428_add_payment_method_id_column_to_orders_table', '1610681674');
INSERT INTO `migration` VALUES ('m210115_043106_create_car_emp_table', '1610685073');
INSERT INTO `migration` VALUES ('m210115_061228_add_sale_group_id_column_to_car_table', '1610691216');
INSERT INTO `migration` VALUES ('m210115_061327_add_delivery_route_id_column_to_sale_group_table', '1610691216');
INSERT INTO `migration` VALUES ('m210115_161634_add_sale_com_id_column_to_car_table', '1610727398');
INSERT INTO `migration` VALUES ('m210116_031531_add_address_column_to_company_table', '1610766954');
INSERT INTO `migration` VALUES ('m210116_031544_add_address_column_to_branch_table', '1610767018');
INSERT INTO `migration` VALUES ('m210118_142958_create_payment_term_table', '1610980203');
INSERT INTO `migration` VALUES ('m210118_163121_create_position_table', '1610987487');

-- ----------------------------
-- Table structure for `orders`
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_type` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `vat_amt` float DEFAULT NULL,
  `vat_per` float DEFAULT NULL,
  `order_total_amt` float DEFAULT NULL,
  `emp_sale_id` int(11) DEFAULT NULL,
  `car_ref_id` int(11) DEFAULT NULL,
  `order_channel_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_order` (`company_id`),
  KEY `fk_branch_order` (`branch_id`),
  CONSTRAINT `fk_branch_order` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_order` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('39', 'SO21000001', null, null, null, '2021-01-18 00:00:00', null, null, '145', null, '3', '1', '1', null, null, '1610728631', '1610981424', null, null, null, '1');
INSERT INTO `orders` VALUES ('40', 'SO21000002', null, null, null, '2021-01-15 00:00:00', null, null, '540', null, '3', '1', '1', null, null, '1610728665', '1610728665', null, null, null, '2');

-- ----------------------------
-- Table structure for `order_line`
-- ----------------------------
DROP TABLE IF EXISTS `order_line`;
CREATE TABLE `order_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `price` float DEFAULT NULL,
  `line_disc_amt` float DEFAULT NULL,
  `line_disc_per` float DEFAULT NULL,
  `line_total` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_order_line` (`company_id`),
  KEY `fk_branch_order_line` (`branch_id`),
  CONSTRAINT `fk_branch_order_line` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_order_line` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=390 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_line
-- ----------------------------
INSERT INTO `order_line` VALUES ('382', '39', '1', '3', '15', null, null, '45', null, null, null, '1610728631', '1610728631', null, null, '2247');
INSERT INTO `order_line` VALUES ('383', '39', '2', '4', '5', null, null, '20', null, null, null, '1610728631', '1610728631', null, null, '2247');
INSERT INTO `order_line` VALUES ('384', '39', '1', '4', '15', null, null, '60', null, null, null, '1610728631', '1610728631', null, null, '2249');
INSERT INTO `order_line` VALUES ('385', '39', '2', '4', '5', null, null, '20', null, null, null, '1610728631', '1610728631', null, null, '2249');
INSERT INTO `order_line` VALUES ('386', '40', '1', '9', '15', null, null, '135', null, null, null, '1610728665', '1610728665', null, null, '2247');
INSERT INTO `order_line` VALUES ('387', '40', '2', '12', '5', null, null, '60', null, null, null, '1610728665', '1610728665', null, null, '2247');
INSERT INTO `order_line` VALUES ('388', '40', '1', '16', '15', null, null, '240', null, null, null, '1610728665', '1610728665', null, null, '2249');
INSERT INTO `order_line` VALUES ('389', '40', '2', '13', '5', null, null, '65', null, null, null, '1610728665', '1610728665', null, null, '2249');

-- ----------------------------
-- Table structure for `payment_method`
-- ----------------------------
DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_method
-- ----------------------------
INSERT INTO `payment_method` VALUES ('1', 'เงินสด', 'เงินสด', 'เงินสด', '1', '1610681572', null, '1610681608', null);
INSERT INTO `payment_method` VALUES ('2', ' เงินเชื่อ', ' เงินเชื่อ', ' เงินเชื่อ', '1', '1610728609', null, '1610728609', null);

-- ----------------------------
-- Table structure for `payment_term`
-- ----------------------------
DROP TABLE IF EXISTS `payment_term`;
CREATE TABLE `payment_term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_term
-- ----------------------------

-- ----------------------------
-- Table structure for `position`
-- ----------------------------
DROP TABLE IF EXISTS `position`;
CREATE TABLE `position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of position
-- ----------------------------

-- ----------------------------
-- Table structure for `price_customer_type`
-- ----------------------------
DROP TABLE IF EXISTS `price_customer_type`;
CREATE TABLE `price_customer_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price_group_id` int(11) DEFAULT NULL,
  `customer_type_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of price_customer_type
-- ----------------------------
INSERT INTO `price_customer_type` VALUES ('5', '6', '2', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('16', '7', '1', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('17', '7', '2', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('18', '6', '1', '1', null, null, null, null);

-- ----------------------------
-- Table structure for `price_group`
-- ----------------------------
DROP TABLE IF EXISTS `price_group`;
CREATE TABLE `price_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of price_group
-- ----------------------------
INSERT INTO `price_group` VALUES ('6', 'ขายปลีก 10', 'ขายปลีก 10', 'ขายปลีก 10', '1', '1610118066', null, '1610118066', null);
INSERT INTO `price_group` VALUES ('7', 'ขายปลีก 15', 'ขายปลีก 15', 'ขายปลีก 15', '1', '1610118268', null, '1610118268', null);

-- ----------------------------
-- Table structure for `price_group_line`
-- ----------------------------
DROP TABLE IF EXISTS `price_group_line`;
CREATE TABLE `price_group_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price_group_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `sale_price` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of price_group_line
-- ----------------------------
INSERT INTO `price_group_line` VALUES ('14', '6', '1', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('15', '6', '2', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('16', '6', '3', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('17', '6', '4', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('18', '6', '5', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('19', '6', '6', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('28', '7', '1', '15', '1', null, null, null, null);

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `product_group_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `std_cost` float DEFAULT NULL,
  `sale_price` float DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `nw` float DEFAULT NULL,
  `gw` float DEFAULT NULL,
  `min_stock` float DEFAULT NULL,
  `max_stock` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `sale_status` int(11) DEFAULT NULL,
  `stock_type` int(11) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_product` (`company_id`),
  KEY `fk_branch_product` (`branch_id`),
  CONSTRAINT `fk_branch_product` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_product` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', 'PB', 'PB หลอดใหญ่', '', '1', '1', '1608311644.jpg', '455', '27', '1', null, null, null, null, '1', null, null, null, '1610028331', null, null, '1', '1', null);
INSERT INTO `product` VALUES ('2', 'PS', 'PB หลอดเล็ก', '', '2', '1', '', null, '10', '0', null, null, null, null, '2', null, null, null, '1610119052', null, null, '1', '1', null);
INSERT INTO `product` VALUES ('3', 'PC', 'PC แพ็คโม่', null, '2', '1', null, null, '23', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('4', 'P2KG', 'P2KG น้ำแข็งแพ็ค2กก.', null, '2', '1', null, null, '13', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('5', 'M', 'M น้ำแข็งโม่', null, '1', '1', null, null, '14', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('6', 'K', 'K น้ำแข็งกั๊ก', null, '1', '1', null, null, '33', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('7', 'B', 'B น้ำแข็งหลอดใหญ่', null, '1', '1', null, null, '12', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('8', 'S', 'S น้ำแข็งหลอดเล็ก', null, '1', '1', null, null, '15', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('9', 'SC', 'SC น้ำแข็งหลอดเล็กโม่', null, '1', '1', null, null, '13', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `product_group`
-- ----------------------------
DROP TABLE IF EXISTS `product_group`;
CREATE TABLE `product_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_product_group` (`company_id`),
  KEY `fk_branch_product_group` (`branch_id`),
  CONSTRAINT `fk_branch_product_group` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_product_group` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_group
-- ----------------------------
INSERT INTO `product_group` VALUES ('1', '01', 'ขายเงินสด', 'ทดสอบxcxcxcxccx', '1', '1', '1', '1608194431', '1608951690', null, null);
INSERT INTO `product_group` VALUES ('2', '02', 'ขายเงินเชื่อ', 'ขายเงินเชื่อ', '1', null, null, '1610704172', '1610704172', null, null);

-- ----------------------------
-- Table structure for `product_type`
-- ----------------------------
DROP TABLE IF EXISTS `product_type`;
CREATE TABLE `product_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_product_type` (`company_id`),
  KEY `fk_branch_product_type` (`branch_id`),
  CONSTRAINT `fk_branch_product_type` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_product_type` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_type
-- ----------------------------
INSERT INTO `product_type` VALUES ('1', '01', 'น้ำแข็งก้อน', 'ทดสอบด', '1', '1', '1', '1608194405', '1608952485', null, null);
INSERT INTO `product_type` VALUES ('2', '02', 'น้ำแข็งแพ็ค', 'น้ำแข็งแพ็ค34343', '1', '1', '1', '1608199053', '1608311444', null, null);

-- ----------------------------
-- Table structure for `sale_com`
-- ----------------------------
DROP TABLE IF EXISTS `sale_com`;
CREATE TABLE `sale_com` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `emp_qty` int(11) DEFAULT NULL,
  `com_extra` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sale_com
-- ----------------------------
INSERT INTO `sale_com` VALUES ('1', 'SALE01', 'SALE01', '2', '0.5', '1', '1610345757', '1610727734', null);

-- ----------------------------
-- Table structure for `sale_com_summary`
-- ----------------------------
DROP TABLE IF EXISTS `sale_com_summary`;
CREATE TABLE `sale_com_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sale_price` float DEFAULT NULL,
  `com_extra` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sale_com_summary
-- ----------------------------
INSERT INTO `sale_com_summary` VALUES ('1', 'Orver 3,000', 'Orver 3,000', '3500', '30', '1', '1610345813', '1610944015', null, null);

-- ----------------------------
-- Table structure for `sale_group`
-- ----------------------------
DROP TABLE IF EXISTS `sale_group`;
CREATE TABLE `sale_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `delivery_route_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sale_group
-- ----------------------------
INSERT INTO `sale_group` VALUES ('1', 'VP1', 'สาย 4-5', '1', '1610691426', null, '1610718232', null, '1');
INSERT INTO `sale_group` VALUES ('2', 'VP2', 'VP2', '1', '1610697545', null, '1610697545', null, '2');

-- ----------------------------
-- Table structure for `sequence`
-- ----------------------------
DROP TABLE IF EXISTS `sequence`;
CREATE TABLE `sequence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `use_year` int(11) DEFAULT NULL,
  `use_month` int(11) DEFAULT NULL,
  `use_day` int(11) DEFAULT NULL,
  `minimum` int(11) DEFAULT NULL,
  `maximum` int(11) DEFAULT NULL,
  `currentnum` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sequence
-- ----------------------------
INSERT INTO `sequence` VALUES ('1', null, '1', 'PR', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('2', null, '2', 'PO', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('3', null, '3', 'QUO', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('4', null, '4', 'SO', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('5', null, '5', 'TF', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('6', null, '6', 'IS', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('7', null, '7', 'RT', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('8', null, '8', 'SRT', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('9', null, '9', 'PRT', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('10', null, '10', 'CT', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('11', null, '11', 'AD', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('12', null, '12', 'CU', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('13', null, '13', 'WO', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('14', null, '14', 'PDR', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('15', null, '15', 'REP', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('16', null, '16', 'INV', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('17', null, '17', 'QC', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);

-- ----------------------------
-- Table structure for `standard_price`
-- ----------------------------
DROP TABLE IF EXISTS `standard_price`;
CREATE TABLE `standard_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_standard_price` (`company_id`),
  KEY `fk_branch_standard_price` (`branch_id`),
  CONSTRAINT `fk_branch_standard_price` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_standard_price` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of standard_price
-- ----------------------------

-- ----------------------------
-- Table structure for `unit`
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_unit` (`company_id`),
  KEY `fk_branch_unit` (`branch_id`),
  CONSTRAINT `fk_branch_unit` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_unit` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of unit
-- ----------------------------
INSERT INTO `unit` VALUES ('1', 'Pcs', 'ชิ้น', '', '1', null, null, '1608948374', '1608952504', null, null);
INSERT INTO `unit` VALUES ('2', 'Set', 'Set', '', '1', null, null, '1610159013', '1610159013', null, null);

-- ----------------------------
-- Table structure for `user`
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
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'iceadmin', 'mYoUzWjaVR-YU1QuZq8XFss-Z32Hd49u', '$2y$13$l9F0RL6wBqCHh3mRm4tPOupGQ6azGVh6/3L2W6GLapM5h.OWplTG.', null, 'admin@icesystem.com', '10', '1607409003', '1607409003', null);

-- ----------------------------
-- Table structure for `user_group`
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `car_type_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_group
-- ----------------------------

-- ----------------------------
-- Table structure for `warehouse`
-- ----------------------------
DROP TABLE IF EXISTS `warehouse`;
CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_warehouse` (`company_id`),
  KEY `fk_branch_warehouse` (`branch_id`),
  CONSTRAINT `fk_branch_warehouse` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_warehouse` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of warehouse
-- ----------------------------
INSERT INTO `warehouse` VALUES ('1', 'Factory1', 'คลังกระจายสินค้า', 'คลังกระจายสินค้า', '', '2', '1', null, '1607417927', '1608951503', null, null);
INSERT INTO `warehouse` VALUES ('2', 'Factory2', 'Factory2', 'Factory2', '', '1', '1', null, '1607436837', '1607436872', null, null);

-- ----------------------------
-- View structure for `newview`
-- ----------------------------
DROP VIEW IF EXISTS `newview`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `newview` AS select `query_sale_trans_by_emp`.`order_channel_id` AS `order_channel_id`,`query_sale_trans_by_emp`.`route_code` AS `route_code`,`query_sale_trans_by_emp`.`payment_method_id` AS `payment_method_id`,`query_sale_trans_by_emp`.`emp_id` AS `emp_id`,`query_sale_trans_by_emp`.`fname` AS `fname`,`query_sale_trans_by_emp`.`lname` AS `lname`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 1) then `query_sale_trans_by_emp`.`qty` end)) AS `1`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 2) then `query_sale_trans_by_emp`.`qty` end)) AS `2`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 3) then `query_sale_trans_by_emp`.`qty` end)) AS `3`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 4) then `query_sale_trans_by_emp`.`qty` end)) AS `4`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 5) then `query_sale_trans_by_emp`.`qty` end)) AS `5`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 6) then `query_sale_trans_by_emp`.`qty` end)) AS `6`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 7) then `query_sale_trans_by_emp`.`qty` end)) AS `7`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 8) then `query_sale_trans_by_emp`.`qty` end)) AS `8`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 9) then `query_sale_trans_by_emp`.`qty` end)) AS `9`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 10) then `query_sale_trans_by_emp`.`qty` end)) AS `10`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 11) then `query_sale_trans_by_emp`.`qty` end)) AS `11`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 12) then `query_sale_trans_by_emp`.`qty` end)) AS `12`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 13) then `query_sale_trans_by_emp`.`qty` end)) AS `13`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 14) then `query_sale_trans_by_emp`.`qty` end)) AS `14`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 15) then `query_sale_trans_by_emp`.`qty` end)) AS `15` from `query_sale_trans_by_emp` group by `query_sale_trans_by_emp`.`order_channel_id`,`query_sale_trans_by_emp`.`route_code`,`query_sale_trans_by_emp`.`payment_method_id`,`query_sale_trans_by_emp`.`emp_id`,`query_sale_trans_by_emp`.`fname`,`query_sale_trans_by_emp`.`lname` ;

-- ----------------------------
-- View structure for `query_car_emp_data`
-- ----------------------------
DROP VIEW IF EXISTS `query_car_emp_data`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_car_emp_data` AS select `delivery_route`.`code` AS `code`,`car`.`code` AS `car_code_`,`car`.`name` AS `car_name_`,`car_emp`.`emp_id` AS `emp_id`,`employee`.`code` AS `emp_code_`,`employee`.`fname` AS `fname`,`employee`.`lname` AS `lname`,`delivery_route`.`id` AS `id`,`car`.`id` AS `car_id_` from ((((`delivery_route` join `sale_group` on((`delivery_route`.`id` = `sale_group`.`delivery_route_id`))) join `car` on((`sale_group`.`id` = `car`.`sale_group_id`))) join `car_emp` on((`car`.`id` = `car_emp`.`car_id`))) join `employee` on((`car_emp`.`emp_id` = `employee`.`id`))) ;

-- ----------------------------
-- View structure for `query_customer_info`
-- ----------------------------
DROP VIEW IF EXISTS `query_customer_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_customer_info` AS select `delivery_route`.`id` AS `rt_id`,`delivery_route`.`code` AS `route_code`,`sale_group`.`name` AS `sale_grp_name`,`customer`.`name` AS `cus_name`,`customer_group`.`name` AS `cus_group_name`,`customer_type`.`name` AS `cus_type_name`,`customer`.`id` AS `customer_id` from ((((`delivery_route` left join `sale_group` on((`sale_group`.`delivery_route_id` = `delivery_route`.`code`))) join `customer` on((`delivery_route`.`id` = `customer`.`delivery_route_id`))) left join `customer_group` on((`customer`.`customer_group_id` = `customer_group`.`id`))) left join `customer_type` on((`customer`.`customer_type_id` = `customer_type`.`id`))) ;

-- ----------------------------
-- View structure for `query_customer_price`
-- ----------------------------
DROP VIEW IF EXISTS `query_customer_price`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_customer_price` AS select `customer`.`id` AS `customer_id`,`price_customer_type`.`price_group_id` AS `price_group_id`,`price_group_line`.`product_id` AS `product_id`,`price_group_line`.`sale_price` AS `sale_price`,`customer`.`customer_type_id` AS `customer_type_id` from ((`customer` join `price_customer_type` on((`customer`.`customer_type_id` = `price_customer_type`.`customer_type_id`))) join `price_group_line` on((`price_customer_type`.`price_group_id` = `price_group_line`.`price_group_id`))) ;

-- ----------------------------
-- View structure for `query_order_data`
-- ----------------------------
DROP VIEW IF EXISTS `query_order_data`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_order_data` AS select `orders`.`id` AS `id`,`orders`.`order_no` AS `order_no`,`orders`.`order_date` AS `order_date`,`orders`.`vat_amt` AS `vat_amt`,`orders`.`order_channel_id` AS `order_channel_id`,`orders`.`payment_method_id` AS `payment_method_id`,`order_line`.`product_id` AS `product_id`,`order_line`.`qty` AS `qty`,`order_line`.`price` AS `price`,`order_line`.`customer_id` AS `customer_id`,`orders`.`car_ref_id` AS `car_ref_id` from (`orders` join `order_line` on((`orders`.`id` = `order_line`.`order_id`))) ;

-- ----------------------------
-- View structure for `query_order_update`
-- ----------------------------
DROP VIEW IF EXISTS `query_order_update`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_order_update` AS select `order_line`.`customer_id` AS `customer_id`,`customer`.`name` AS `name`,`order_line`.`order_id` AS `order_id`,`customer`.`code` AS `code` from (`order_line` join `customer` on((`order_line`.`customer_id` = `customer`.`id`))) group by `order_line`.`customer_id`,`order_line`.`order_id` ;

-- ----------------------------
-- View structure for `query_products`
-- ----------------------------
DROP VIEW IF EXISTS `query_products`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_products` AS select `product`.`id` AS `id`,`product`.`code` AS `code`,`product`.`name` AS `name`,`product`.`description` AS `description`,`product`.`product_type_id` AS `product_type_id`,`product`.`product_group_id` AS `product_group_id`,`product_type`.`code` AS `type_code`,`product_type`.`name` AS `type_name`,`product_group`.`code` AS `group_code`,`product_group`.`name` AS `group_name`,(case when (`product`.`status` = 1) then 'ใช้งาน' else 'ไม่ใช้งาน' end) AS `status` from ((`product` left join `product_group` on((`product`.`product_group_id` = `product_group`.`id`))) left join `product_type` on((`product`.`product_type_id` = `product_type`.`id`))) ;

-- ----------------------------
-- View structure for `query_product_by_route`
-- ----------------------------
DROP VIEW IF EXISTS `query_product_by_route`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_product_by_route` AS select `customer`.`delivery_route_id` AS `delivery_route_id`,`price_group_line`.`product_id` AS `product_id`,`product`.`code` AS `code`,`product`.`name` AS `name`,`price_group_line`.`sale_price` AS `sale_price` from (((`customer` left join `price_customer_type` on((`customer`.`customer_type_id` = `price_customer_type`.`customer_type_id`))) join `price_group_line` on((`price_customer_type`.`price_group_id` = `price_group_line`.`price_group_id`))) join `product` on((`price_group_line`.`product_id` = `product`.`id`))) group by `customer`.`id`,`customer`.`code`,`customer`.`name`,`customer`.`customer_type_id`,`price_customer_type`.`price_group_id`,`price_group_line`.`product_id`,`customer`.`delivery_route_id`,`price_group_line`.`sale_price` ;

-- ----------------------------
-- View structure for `query_product_from_route`
-- ----------------------------
DROP VIEW IF EXISTS `query_product_from_route`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_product_from_route` AS select `query_product_by_route`.`delivery_route_id` AS `delivery_route_id`,`query_product_by_route`.`product_id` AS `product_id`,`query_product_by_route`.`code` AS `code`,`query_product_by_route`.`sale_price` AS `sale_price` from `query_product_by_route` where (`query_product_by_route`.`delivery_route_id` > 0) group by `query_product_by_route`.`delivery_route_id`,`query_product_by_route`.`product_id` ;

-- ----------------------------
-- View structure for `query_sale_summary_by_emp`
-- ----------------------------
DROP VIEW IF EXISTS `query_sale_summary_by_emp`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_sale_summary_by_emp` AS select `query_sale_trans_by_emp`.`order_channel_id` AS `order_channel_id`,`query_sale_trans_by_emp`.`route_code` AS `route_code`,`query_sale_trans_by_emp`.`payment_method_id` AS `payment_method_id`,`query_sale_trans_by_emp`.`emp_id` AS `emp_id`,`query_sale_trans_by_emp`.`fname` AS `fname`,`query_sale_trans_by_emp`.`lname` AS `lname`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 1) then `query_sale_trans_by_emp`.`qty` end)) AS `1`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 2) then `query_sale_trans_by_emp`.`qty` end)) AS `2`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 3) then `query_sale_trans_by_emp`.`qty` end)) AS `3`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 4) then `query_sale_trans_by_emp`.`qty` end)) AS `4`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 5) then `query_sale_trans_by_emp`.`qty` end)) AS `5`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 6) then `query_sale_trans_by_emp`.`qty` end)) AS `6`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 7) then `query_sale_trans_by_emp`.`qty` end)) AS `7`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 8) then `query_sale_trans_by_emp`.`qty` end)) AS `8`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 9) then `query_sale_trans_by_emp`.`qty` end)) AS `9`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 10) then `query_sale_trans_by_emp`.`qty` end)) AS `10`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 11) then `query_sale_trans_by_emp`.`qty` end)) AS `11`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 12) then `query_sale_trans_by_emp`.`qty` end)) AS `12`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 13) then `query_sale_trans_by_emp`.`qty` end)) AS `13`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 14) then `query_sale_trans_by_emp`.`qty` end)) AS `14`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 15) then `query_sale_trans_by_emp`.`qty` end)) AS `15` from `query_sale_trans_by_emp` group by `query_sale_trans_by_emp`.`order_channel_id`,`query_sale_trans_by_emp`.`route_code`,`query_sale_trans_by_emp`.`payment_method_id`,`query_sale_trans_by_emp`.`emp_id`,`query_sale_trans_by_emp`.`fname`,`query_sale_trans_by_emp`.`lname` ;

-- ----------------------------
-- View structure for `query_sale_summary_by_emp2`
-- ----------------------------
DROP VIEW IF EXISTS `query_sale_summary_by_emp2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_sale_summary_by_emp2` AS select `query_sale_trans_by_emp`.`order_channel_id` AS `order_channel_id`,`query_sale_trans_by_emp`.`route_code` AS `route_code`,`query_sale_trans_by_emp`.`emp_id` AS `emp_id`,`query_sale_trans_by_emp`.`fname` AS `fname`,`query_sale_trans_by_emp`.`lname` AS `lname`,sum((case when (`query_sale_trans_by_emp`.`payment_method_id` = 1) then `query_sale_trans_by_emp`.`qty` end)) AS `Cash`,sum((case when (`query_sale_trans_by_emp`.`payment_method_id` = 2) then `query_sale_trans_by_emp`.`qty` end)) AS `Credit`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 1) then `query_sale_trans_by_emp`.`qty` end)) AS `1`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 2) then `query_sale_trans_by_emp`.`qty` end)) AS `2`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 3) then `query_sale_trans_by_emp`.`qty` end)) AS `3`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 4) then `query_sale_trans_by_emp`.`qty` end)) AS `4`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 5) then `query_sale_trans_by_emp`.`qty` end)) AS `5`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 6) then `query_sale_trans_by_emp`.`qty` end)) AS `6`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 7) then `query_sale_trans_by_emp`.`qty` end)) AS `7`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 8) then `query_sale_trans_by_emp`.`qty` end)) AS `8`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 9) then `query_sale_trans_by_emp`.`qty` end)) AS `9`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 10) then `query_sale_trans_by_emp`.`qty` end)) AS `10`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 11) then `query_sale_trans_by_emp`.`qty` end)) AS `11`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 12) then `query_sale_trans_by_emp`.`qty` end)) AS `12`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 13) then `query_sale_trans_by_emp`.`qty` end)) AS `13`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 14) then `query_sale_trans_by_emp`.`qty` end)) AS `14`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 15) then `query_sale_trans_by_emp`.`qty` end)) AS `15` from `query_sale_trans_by_emp` group by `query_sale_trans_by_emp`.`order_channel_id`,`query_sale_trans_by_emp`.`route_code`,`query_sale_trans_by_emp`.`emp_id`,`query_sale_trans_by_emp`.`fname`,`query_sale_trans_by_emp`.`lname` ;

-- ----------------------------
-- View structure for `query_sale_trans_by_emp`
-- ----------------------------
DROP VIEW IF EXISTS `query_sale_trans_by_emp`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_sale_trans_by_emp` AS select `query_sale_trans_data`.`order_no` AS `order_no`,`query_sale_trans_data`.`order_date` AS `order_date`,`query_sale_trans_data`.`vat_amt` AS `vat_amt`,`query_sale_trans_data`.`order_channel_id` AS `order_channel_id`,`query_sale_trans_data`.`payment_method_id` AS `payment_method_id`,`query_sale_trans_data`.`product_id` AS `product_id`,`query_sale_trans_data`.`qty` AS `qty`,`query_sale_trans_data`.`price` AS `price`,`query_sale_trans_data`.`customer_id` AS `customer_id`,`query_sale_trans_data`.`route_code` AS `route_code`,`query_sale_trans_data`.`sale_grp_name` AS `sale_grp_name`,`query_sale_trans_data`.`cus_name` AS `cus_name`,`query_sale_trans_data`.`cus_group_name` AS `cus_group_name`,`query_sale_trans_data`.`cus_type_name` AS `cus_type_name`,`query_car_emp_data`.`car_id_` AS `car_id_`,`query_car_emp_data`.`car_code_` AS `car_code_`,`query_car_emp_data`.`car_name_` AS `car_name_`,`query_car_emp_data`.`emp_id` AS `emp_id`,`query_car_emp_data`.`fname` AS `fname`,`query_car_emp_data`.`lname` AS `lname` from (`query_sale_trans_data` join `query_car_emp_data` on((`query_sale_trans_data`.`order_channel_id` = `query_car_emp_data`.`id`))) ;

-- ----------------------------
-- View structure for `query_sale_trans_data`
-- ----------------------------
DROP VIEW IF EXISTS `query_sale_trans_data`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_sale_trans_data` AS select `query_order_data`.`order_no` AS `order_no`,`query_order_data`.`order_date` AS `order_date`,`query_order_data`.`vat_amt` AS `vat_amt`,`query_order_data`.`order_channel_id` AS `order_channel_id`,`query_order_data`.`payment_method_id` AS `payment_method_id`,`query_order_data`.`product_id` AS `product_id`,`query_order_data`.`qty` AS `qty`,`query_order_data`.`price` AS `price`,`query_order_data`.`customer_id` AS `customer_id`,`query_customer_info`.`route_code` AS `route_code`,`query_customer_info`.`sale_grp_name` AS `sale_grp_name`,`query_customer_info`.`cus_name` AS `cus_name`,`query_customer_info`.`cus_group_name` AS `cus_group_name`,`query_customer_info`.`cus_type_name` AS `cus_type_name` from (`query_order_data` left join `query_customer_info` on((`query_order_data`.`customer_id` = `query_customer_info`.`customer_id`))) ;
