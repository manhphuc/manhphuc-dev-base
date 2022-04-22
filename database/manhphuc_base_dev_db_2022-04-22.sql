# ************************************************************
# Sequel Pro SQL dump
# Version 5446
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.26)
# Database: manhphuc_base_dev_db
# Generation Time: 2022-04-22 10:33:01 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table book
# ------------------------------------------------------------

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,0) NOT NULL,
  `special` tinyint(1) DEFAULT '0',
  `sale_off` int DEFAULT '0',
  `picture` text,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int DEFAULT '10',
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



# Dump of table cart
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id` varchar(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `books` text NOT NULL,
  `prices` text NOT NULL,
  `quantities` text NOT NULL,
  `names` text NOT NULL,
  `pictures` text NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `picture` text,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



# Dump of table group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `group`;

CREATE TABLE `group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `group_acp` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `ordering` int DEFAULT '10',
  `privilege_id` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

LOCK TABLES `group` WRITE;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;

INSERT INTO `group` (`id`, `name`, `group_acp`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `privilege_id`, `picture`)
VALUES
	(1,'Admin',1,'2013-11-11 00:00:00','admin','2022-04-18 00:00:00','admin','1',3,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31',''),
	(2,'Manager',1,'2013-11-07 00:00:00','admin','2013-12-03 00:00:00','admin','1',2,'1,2,3,4,6,7,8,9,10',''),
	(3,'Administrator',1,'2013-11-12 00:00:00','admin','2022-04-18 00:00:00','admin','1',1,'',''),
	(4,'member',1,'2021-10-06 00:00:00','Admin','2021-10-06 00:00:00','admin','0',10,'1','img1.png');

/*!40000 ALTER TABLE `group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table privilege
# ------------------------------------------------------------

DROP TABLE IF EXISTS `privilege`;

CREATE TABLE `privilege` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `module` varchar(45) NOT NULL,
  `controller` varchar(45) NOT NULL,
  `action` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

LOCK TABLES `privilege` WRITE;
/*!40000 ALTER TABLE `privilege` DISABLE KEYS */;

INSERT INTO `privilege` (`id`, `name`, `module`, `controller`, `action`)
VALUES
	(1,'Hiển thị danh sách người dùng','backend','user','index'),
	(2,'Thay đổi status của người dùng','backend','user','status'),
	(3,'Cập nhật thông tin của người dùng','backend','user','form'),
	(4,'Thay đổi status của người dùng sử dụng Ajax','backend','user','ajaxStatus'),
	(5,'Xóa một hoặc nhiều người dùng','backend','user','trash'),
	(6,'Thay đổi vị trí hiển thị của các người dùng','backend','user','ordering'),
	(7,'Truy cập menu Admin Control Panel','backend','index','index'),
	(8,'Đăng nhập Admin Control Panel','backend','index','login'),
	(9,'Đăng xuất Admin Control Panel','backend','index','logout'),
	(10,'Cập nhật thông tin tài khoản quản trị','backend','index','profile'),
	(11,'Hiển thị danh sách group','backend','group','index'),
	(12,'Thay đổi status của group','backend','group','status'),
	(13,'Cập nhật thông tin của group','backend','group','form'),
	(14,'Thay đổi status của group sử dụng Ajax','backend','group','ajaxStatus'),
	(15,'Xóa một hoặc nhiều group','backend','group','trash'),
	(16,'Thay đổi vị trí hiển thị của các group','backend','group','ordering'),
	(17,'Hiển thị danh sách category','backend','category','index'),
	(18,'Thay đổi status của category','backend','category','status'),
	(19,'Cập nhật thông tin của category','backend','category','form'),
	(20,'Thay đổi status của category sử dụng Ajax','backend','category','ajaxStatus'),
	(21,'Xóa một hoặc nhiều category','backend','category','trash'),
	(22,'Thay đổi vị trí hiển thị của các category','backend','category','ordering'),
	(23,'Hiển thị danh sách book','backend','book','index'),
	(24,'Thay đổi status của book','backend','book','status'),
	(25,'Cập nhật thông tin của book','backend','book','form'),
	(26,'Thay đổi status của book sử dụng Ajax','backend','book','ajaxStatus'),
	(27,'Xóa một hoặc nhiều book','backend','book','trash'),
	(28,'Thay đổi vị trí hiển thị của các book','backend','book','ordering'),
	(29,'Thay đổi special của book sử dụng Ajax','backend','book','ajaxSpecial'),
	(30,'Thay đổi ACP của group sử dụng Ajax','backend','group','ajaxACP'),
	(31,'Hiển thị danh sách đơn đặt hàng book','backend','book','orders');

/*!40000 ALTER TABLE `privilege` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(45) DEFAULT NULL,
  `register_date` datetime DEFAULT '0000-00-00 00:00:00',
  `register_ip` varchar(25) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int DEFAULT '10',
  `group_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `username`, `email`, `fullname`, `password`, `created`, `created_by`, `modified`, `modified_by`, `register_date`, `register_ip`, `status`, `ordering`, `group_id`)
VALUES
	(1,'manhphucofficial','manhphucofficial@gmail.com','Phuc Nguyen','3b269d99b6c31f1467421bbcfdec7908','2021-10-07 00:00:00','Admin','2021-11-04 00:00:00','admin','2013-11-19 18:11:09','192.168.1.1',1,1,1),
	(2,'user','manhphuc.dev@gmail.com','User','3b269d99b6c31f1467421bbcfdec7908','2021-10-07 00:00:00','Admin','2021-11-04 00:00:00','admin','2013-11-19 18:11:09','192.168.1.1',1,1,4);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
