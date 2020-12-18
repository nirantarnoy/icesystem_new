/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : vorapat

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-12-19 00:00:33
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
  PRIMARY KEY (`id`),
  KEY `fk_company` (`company_id`),
  CONSTRAINT `fk_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of branch
-- ----------------------------
INSERT INTO `branch` VALUES ('1', '1', 'B01', 'สาขา 1', '', '', '1', '1607428129', '1607428129', null, null);

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
  PRIMARY KEY (`id`),
  KEY `fk_company_car` (`company_id`),
  KEY `fk_branch_car` (`branch_id`),
  CONSTRAINT `fk_branch_car` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_car` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of car
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of car_type
-- ----------------------------

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('1', 'Vorapat', 'วรภัทรไอซ์', 'Vorapat Ice', '2222222222222', '', '1607417726', '1607417726', '1', null, null, null);

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
  PRIMARY KEY (`id`),
  KEY `fk_company_customer` (`company_id`),
  KEY `fk_branch_customer` (`branch_id`),
  CONSTRAINT `fk_branch_customer` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_customer` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_group
-- ----------------------------

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
INSERT INTO `delivery_route` VALUES ('1', '001', 'VP1', null, null, null, null, null, null, null);
INSERT INTO `delivery_route` VALUES ('2', '002', 'VP2', null, null, null, null, null, null, null);
INSERT INTO `delivery_route` VALUES ('3', '003', 'VP3', null, null, null, null, null, null, null);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of employee
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of location
-- ----------------------------

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
  PRIMARY KEY (`id`),
  KEY `fk_company_order` (`company_id`),
  KEY `fk_branch_order` (`branch_id`),
  CONSTRAINT `fk_branch_order` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_order` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('1', 'SO200001', '1', null, 'tarlek', '2020-12-09 16:19:14', null, null, '50', null, null, null, null, null, null, null, null, null, null, 'น้ำแข็งหลอดใหญ่');
INSERT INTO `orders` VALUES ('2', 'SO200002', '1', null, 'ร้านคุณทิพย์', '2020-12-10 16:40:42', null, null, '150', null, null, null, null, null, null, null, null, null, null, 'น้ำแข็งกั๊ก');
INSERT INTO `orders` VALUES ('3', 'SO200003', '1', null, 'คุณแวว', '2020-12-10 16:41:57', null, null, '80', null, null, null, null, null, null, null, null, null, null, 'หลอดเล็ก');
INSERT INTO `orders` VALUES ('4', 'SO200004', '1', null, 'คุณมนัส', '2020-12-16 16:50:03', null, null, '400', null, null, null, null, null, null, null, null, null, null, 'บด + หลอดเล็ก');
INSERT INTO `orders` VALUES ('5', 'SO200005', '1', null, 'ร้านสมพรการค้า', '2020-12-10 16:51:23', null, null, '540', null, null, null, null, null, null, null, null, null, null, 'หลอดใหญ่+หลอดเล็ก');
INSERT INTO `orders` VALUES ('6', 'SO200006', '1', null, 'ร้านมีทรัพย์', '2020-12-10 17:03:39', null, null, null, null, null, null, null, null, null, null, null, null, null, 'น้ำแข็งกั๊ก');
INSERT INTO `orders` VALUES ('7', 'SO200007', '1', null, 'ร้านน้องปัน', '2020-12-10 17:04:07', null, null, null, null, null, null, null, null, null, null, null, null, null, 'น้ำแข็งกั๊ก');
INSERT INTO `orders` VALUES ('8', 'SO200008', '1', null, 'คุณปลา', '2020-12-10 17:04:47', null, null, null, null, null, null, null, null, null, null, null, null, null, 'หลอดเล็ก');

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
  PRIMARY KEY (`id`),
  KEY `fk_company_order_line` (`company_id`),
  KEY `fk_branch_order_line` (`branch_id`),
  CONSTRAINT `fk_branch_order_line` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_order_line` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_line
-- ----------------------------

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
  PRIMARY KEY (`id`),
  KEY `fk_company_product` (`company_id`),
  KEY `fk_branch_product` (`branch_id`),
  CONSTRAINT `fk_branch_product` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_product` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', 'PB', 'PB หลอดใหญ่', '', '2', '1', '', '455', '500', null, null, null, null, null, '1', null, null, null, '1608282588', null, null);
INSERT INTO `product` VALUES ('2', 'PS', 'PB หลอดเล็ก', '', '2', '1', '', null, null, null, null, null, null, null, '2', null, null, null, '1607564156', null, null);
INSERT INTO `product` VALUES ('3', 'PC', 'PC แพ็คโม่', null, '2', '1', null, null, null, null, null, null, null, null, '2', null, null, null, null, null, null);
INSERT INTO `product` VALUES ('4', 'P2KG', 'P2KG น้ำแข็งแพ็ค2กก.', null, '2', '1', null, null, null, null, null, null, null, null, '2', null, null, null, null, null, null);
INSERT INTO `product` VALUES ('5', 'M', 'M น้ำแข็งโม่', null, '1', '1', null, null, null, null, null, null, null, null, '2', null, null, null, null, null, null);
INSERT INTO `product` VALUES ('6', 'K', 'K น้ำแข็งกั๊ก', null, '1', '1', null, null, null, null, null, null, null, null, '2', null, null, null, null, null, null);
INSERT INTO `product` VALUES ('7', 'B', 'B น้ำแข็งหลอดใหญ่', null, '1', '1', null, null, null, null, null, null, null, null, '2', null, null, null, null, null, null);
INSERT INTO `product` VALUES ('8', 'S', 'S น้ำแข็งหลอดเล็ก', null, '1', '1', null, null, null, null, null, null, null, null, '2', null, null, null, null, null, null);
INSERT INTO `product` VALUES ('9', 'SC', 'SC น้ำแข็งหลอดเล็กโม่', null, '1', '1', null, null, null, null, null, null, null, null, '2', null, null, null, null, null, null);
INSERT INTO `product` VALUES ('11', '09333', 'ชุดว่ายน้ำเด็กสายเดี่ยว', 'sdfd', '2', '1', '1608275982.jpg', '455', '500', null, null, null, null, null, '2', null, null, '1608274589', '1608276013', null, null);
INSERT INTO `product` VALUES ('13', 'A01', 'น้ำหวานเขียว', 'น้ำหวานผสมอาหารนะ', '1', '1', '', '455', '500', null, null, null, null, null, '1', null, null, '1608282372', '1608282394', null, null);

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
INSERT INTO `product_group` VALUES ('1', '01', 'ขายเงินสด', 'ทดสอบ', '1', '1', '1', '1608194431', '1608284001', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_type
-- ----------------------------
INSERT INTO `product_type` VALUES ('1', '01', 'น้ำแข็งก้อน', 'ทดสอบด', '2', '1', '1', '1608194405', '1608284076', null, null);
INSERT INTO `product_type` VALUES ('2', '02', 'น้ำแข็งแพ็ค', 'น้ำแข็งแพ็ค', '1', '1', '1', '1608199053', '1608199053', null, null);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of unit
-- ----------------------------

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
INSERT INTO `warehouse` VALUES ('1', 'Factory1', 'คลังกระจายสินค้า', 'คลังกระจายสินค้า', '', '1', '1', null, '1607417927', '1607417927', null, null);
INSERT INTO `warehouse` VALUES ('2', 'Factory2', 'Factory2', 'Factory2', '', '1', '1', null, '1607436837', '1607436872', null, null);
