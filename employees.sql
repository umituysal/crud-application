# Host: localhost  (Version 5.5.5-10.1.37-MariaDB)
# Date: 2019-03-31 23:42:11
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "employees"
#

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `salary` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "employees"
#

INSERT INTO `employees` VALUES (2,'uysal','datca kemalpasasadad',6000),(5,'mahmude','datca/mugla',5000);
