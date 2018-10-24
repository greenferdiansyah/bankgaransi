/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 5.7.21-log : Database - db_asset
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_asset` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `db_asset`;

/*Table structure for table `m_menu` */

DROP TABLE IF EXISTS `m_menu`;

CREATE TABLE `m_menu` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `menuname` varchar(30) DEFAULT NULL,
  `parent` smallint(4) DEFAULT NULL,
  `tenant_id` varchar(100) NOT NULL DEFAULT '["0"]',
  `userlevel` varchar(300) DEFAULT NULL,
  `url` text,
  `icon` varchar(50) DEFAULT NULL,
  `frontend` int(11) DEFAULT '0',
  `is_default` smallint(1) DEFAULT '0',
  `status` smallint(1) DEFAULT '1' COMMENT '(0 tidak aktif) (1 aktif)',
  `tooltip` text,
  `divider` smallint(1) DEFAULT '0',
  `created` smallint(2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated` smallint(2) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx0` (`tenant_id`),
  KEY `idx1` (`parent`),
  KEY `idx2` (`userlevel`(255))
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `m_menu` */

insert  into `m_menu`(`id`,`menuname`,`parent`,`tenant_id`,`userlevel`,`url`,`icon`,`frontend`,`is_default`,`status`,`tooltip`,`divider`,`created`,`created_at`,`updated`,`updated_at`) values 
(1,'Home',0,'[\"0\",\"1\"]','{\"superadmin\",\"users\"}','home','mdi mdi-blur-linear',0,0,1,NULL,1,2,'2018-02-02 10:32:08',NULL,NULL),
(2,'Administrasi Barang',0,'[\"0\",\"1\"]','{\"superadmin\",\"users\"}',NULL,'mdi mdi-pencil',0,0,1,NULL,0,NULL,NULL,NULL,NULL),
(3,'Barang',9,'[\"0\",\"1\"]','{\"superadmin\",\"users\"}','admin_monitoring','mdi mdi-checkbox-blank-circle-outline',0,0,1,NULL,0,2,'2018-02-02 10:32:08',NULL,NULL),
(4,'Kategori',9,'[\"0\",\"1\"]','{\"superadmin\",\"users\"}','kategori','mdi mdi-checkbox-blank-circle-outline',0,0,1,NULL,0,2,'2018-02-02 10:32:08',NULL,NULL),
(5,'Merk',9,'[\"0\",\"1\"]','{\"superadmin\",\"users\"}','admin_tenant','mdi mdi-checkbox-blank-circle-outline',0,0,1,NULL,0,2,'2018-02-02 10:32:08',NULL,NULL),
(6,'Tipe',9,'[\"0\",\"1\"]','{\"superadmin\",\"users\"}',NULL,'mdi mdi-checkbox-blank-circle-outline',0,0,1,NULL,0,NULL,NULL,NULL,NULL),
(7,'Jenis',9,'[\"0\",\"1\"]','{\"superadmin\",\"users\"}',NULL,'mdi mdi-checkbox-blank-circle-outline',0,0,1,NULL,0,NULL,NULL,NULL,NULL),
(8,'Satuan',9,'[\"0\",\"1\"]','{\"superadmin\",\"users\"}',NULL,'mdi mdi-checkbox-blank-circle-outline',0,0,1,NULL,0,NULL,NULL,NULL,NULL),
(9,'Master Data',0,'[\"0\",\"1\"]','{\"superadmin\",\"users\"}','#','mdi mdi-database',0,0,1,NULL,0,2,'2018-02-02 10:32:08',NULL,NULL),
(10,'History',2,'[\"0\",\"1\"]','{\"superadmin\",\"users\"}',NULL,'mdi mdi-checkbox-blank-circle-outline',0,0,1,NULL,0,NULL,NULL,NULL,NULL),
(11,'Reporting',2,'[\"0\",\"1\"]','{\"superadmin\",\"users\"}',NULL,'mdi mdi-checkbox-blank-circle-outline',0,0,1,NULL,0,NULL,NULL,NULL,NULL);

/*Table structure for table `m_option` */

DROP TABLE IF EXISTS `m_option`;

CREATE TABLE `m_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_type` varchar(15) CHARACTER SET latin1 NOT NULL,
  `option_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `option_name` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `sort` smallint(3) DEFAULT NULL,
  `status` smallint(1) DEFAULT '0',
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated` smallint(5) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`option_type`,`option_id`),
  UNIQUE KEY `idx_` (`option_type`,`option_id`),
  UNIQUE KEY `idx0` (`option_type`,`sort`),
  KEY `idx2` (`option_name`,`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `m_option` */

insert  into `m_option`(`id`,`option_type`,`option_id`,`option_name`,`sort`,`status`,`created`,`created_at`,`updated`,`updated_at`) values 
(1,'opt_userlevel','superadmin','Super Admin',1,0,NULL,NULL,NULL,NULL),
(2,'opt_userlevel','users','Users',2,0,NULL,NULL,NULL,NULL),
(6,'opt_status','0','deactive',2,0,NULL,NULL,NULL,NULL),
(7,'opt_status','1','active',1,0,NULL,NULL,NULL,NULL);

/*Table structure for table `m_route` */

DROP TABLE IF EXISTS `m_route`;

CREATE TABLE `m_route` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `userlevel` varchar(20) DEFAULT NULL,
  `route` varchar(30) DEFAULT NULL,
  `status` smallint(1) DEFAULT '1',
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated` smallint(5) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_userlevel` (`userlevel`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `m_route` */

insert  into `m_route`(`id`,`userlevel`,`route`,`status`,`created`,`created_at`,`updated`,`updated_at`) values 
(1,'superadmin','home',1,NULL,NULL,NULL,NULL),
(2,'users','home',1,NULL,NULL,NULL,NULL);

/*Table structure for table `m_tenant` */

DROP TABLE IF EXISTS `m_tenant`;

CREATE TABLE `m_tenant` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `tenant_name` varchar(30) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_nickname` varchar(50) DEFAULT NULL,
  `company_description` text,
  `address` varchar(255) DEFAULT NULL,
  `phone_no` varchar(30) DEFAULT NULL,
  `fax_no` varchar(30) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `email_support` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` smallint(1) DEFAULT '0',
  `is_deleted` int(1) unsigned zerofill NOT NULL DEFAULT '0',
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated` smallint(5) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx0` (`company_name`),
  KEY `idx1` (`status`),
  KEY `idx2` (`is_deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `m_tenant` */

insert  into `m_tenant`(`id`,`tenant_name`,`company_name`,`company_nickname`,`company_description`,`address`,`phone_no`,`fax_no`,`zip_code`,`email_support`,`logo`,`status`,`is_deleted`,`created`,`created_at`,`updated`,`updated_at`) values 
(0,'MASTER APP','MASTER APP','MasterApp',NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,0,2,'2018-01-18 16:11:50',2,'2018-02-08 04:37:53'),
(1,'INFOMEDIA','PT. Infomedia Nusantara','Infomedia',NULL,'Fatmawatii','62217201221','12345','12345','support@infomedia.co.id','623ef431d50527f876e7c31897caa414.png',1,0,2,'2018-09-13 11:18:33',2,'2018-09-13 11:18:33');

/*Table structure for table `m_user` */

DROP TABLE IF EXISTS `m_user`;

CREATE TABLE `m_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `userlevel` enum('superadmin','users') DEFAULT 'users',
  `tenant_id` smallint(5) DEFAULT NULL,
  `phone` int(12) DEFAULT NULL,
  `img_profile` varchar(30) DEFAULT NULL,
  `status` smallint(1) DEFAULT '0',
  `fail_login` smallint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated` smallint(5) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_locked` smallint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `m_user` */

insert  into `m_user`(`id`,`email`,`password`,`fullname`,`userlevel`,`tenant_id`,`phone`,`img_profile`,`status`,`fail_login`,`last_login`,`created`,`created_at`,`updated`,`updated_at`,`is_locked`) values 
(2,'superadmin@gmail.com','$2y$10$Ss7POs7n.hgvmiEeX2SaQe660IGia.bpijS3xklpDY5Wsjf0q.rhS','Super Admin','superadmin',0,NULL,NULL,0,0,'2018-10-03 22:56:46',NULL,NULL,2,'2018-10-03 22:56:46',0),
(8,'users@gmail.com','$2y$10$Ss7POs7n.hgvmiEeX2SaQe660IGia.bpijS3xklpDY5Wsjf0q.rhS','Users','users',1,NULL,NULL,0,0,'2018-10-03 22:56:49',NULL,NULL,2,'2018-10-03 22:56:49',0);

/*Table structure for table `master_setting` */

DROP TABLE IF EXISTS `master_setting`;

CREATE TABLE `master_setting` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `tenant_id` smallint(3) DEFAULT NULL,
  `title` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `favicon` varchar(35) CHARACTER SET latin1 DEFAULT NULL,
  `logo_full` varchar(80) CHARACTER SET latin1 DEFAULT NULL,
  `logo` varchar(80) CHARACTER SET latin1 DEFAULT NULL,
  `footer` varchar(35) DEFAULT NULL,
  `copyright` varchar(35) DEFAULT NULL,
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated` smallint(5) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` smallint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_tenant_id` (`tenant_id`),
  KEY `idx_is_deleted` (`is_deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `master_setting` */

insert  into `master_setting`(`id`,`tenant_id`,`title`,`favicon`,`logo_full`,`logo`,`footer`,`copyright`,`created`,`created_at`,`updated`,`updated_at`,`is_deleted`) values 
(1,0,'Sharedvis | Infomedia Nusantara','favicon.png','alt-home-logo-putih.png','logo.png','Powered By Infomedia Nusantara','2018',2,'2018-01-18 12:02:22',2,NULL,0),
(2,1,'DEVTEMP','pgn_favicon.ico','pgn_logo.png','pgn_logo.png','Powered By DevTemp','2018',2,'2018-01-18 12:02:22',2,NULL,0);

/*Table structure for table `t_barang` */

DROP TABLE IF EXISTS `t_barang`;

CREATE TABLE `t_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_id` int(11) DEFAULT NULL,
  `tipe_id` int(11) DEFAULT NULL,
  `jenis_id` int(11) DEFAULT NULL,
  `merk_id` int(11) DEFAULT NULL,
  `satuan_id` int(11) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `kode_barang` varchar(20) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `deskripsi` text,
  `status` smallint(1) DEFAULT '0',
  `updated` smallint(5) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx01` (`kode_barang`),
  KEY `idx02` (`kategori_id`),
  KEY `idx03` (`tipe_id`),
  KEY `idx04` (`jenis_id`),
  KEY `idx05` (`merk_id`),
  KEY `idx06` (`satuan_id`),
  KEY `idx07` (`kode_barang`),
  KEY `idx08` (`updated`),
  KEY `idx09` (`created`),
  KEY `idx10` (`status`),
  CONSTRAINT `barang_fk01` FOREIGN KEY (`kategori_id`) REFERENCES `t_kategori` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `barang_fk02` FOREIGN KEY (`tipe_id`) REFERENCES `t_tipe` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `barang_fk03` FOREIGN KEY (`jenis_id`) REFERENCES `t_jenis` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `barang_fk04` FOREIGN KEY (`merk_id`) REFERENCES `t_merk` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `barang_fk05` FOREIGN KEY (`satuan_id`) REFERENCES `t_satuan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `t_barang` */

/*Table structure for table `t_history` */

DROP TABLE IF EXISTS `t_history`;

CREATE TABLE `t_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_history` varchar(30) DEFAULT NULL,
  `barang_id` int(11) DEFAULT NULL,
  `tipe_history` enum('in','out') DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `status` smallint(1) DEFAULT '1',
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated` smallint(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx01` (`barang_id`),
  KEY `idx02` (`tipe_history`),
  KEY `idx03` (`kode_history`),
  KEY `idx04` (`jumlah`),
  KEY `idx05` (`status`),
  KEY `idx06` (`created`),
  KEY `idx07` (`updated`),
  CONSTRAINT `history_fk01` FOREIGN KEY (`barang_id`) REFERENCES `t_barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `t_history` */

/*Table structure for table `t_jenis` */

DROP TABLE IF EXISTS `t_jenis`;

CREATE TABLE `t_jenis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `status` smallint(1) DEFAULT '0',
  `updated` smallint(5) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx01` (`updated`),
  KEY `idx02` (`created`),
  KEY `idx03` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `t_jenis` */

/*Table structure for table `t_kategori` */

DROP TABLE IF EXISTS `t_kategori`;

CREATE TABLE `t_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `status` smallint(1) DEFAULT '0',
  `updated` smallint(5) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx01` (`updated`),
  KEY `idx02` (`created`),
  KEY `idx03` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `t_kategori` */

/*Table structure for table `t_merk` */

DROP TABLE IF EXISTS `t_merk`;

CREATE TABLE `t_merk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_merk` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `status` smallint(1) DEFAULT '0',
  `updated` smallint(5) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx01` (`updated`),
  KEY `idx02` (`created`),
  KEY `idx03` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `t_merk` */

/*Table structure for table `t_satuan` */

DROP TABLE IF EXISTS `t_satuan`;

CREATE TABLE `t_satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `status` smallint(1) DEFAULT '0',
  `updated` smallint(5) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx01` (`updated`),
  KEY `idx02` (`created`),
  KEY `idx03` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `t_satuan` */

/*Table structure for table `t_tipe` */

DROP TABLE IF EXISTS `t_tipe`;

CREATE TABLE `t_tipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tipe` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `status` smallint(1) DEFAULT '0',
  `updated` smallint(5) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx01` (`updated`),
  KEY `idx02` (`created`),
  KEY `idx03` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `t_tipe` */

/* Trigger structure for table `t_history` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `update_barang` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `update_barang` AFTER INSERT ON `t_history` FOR EACH ROW BEGIN
	UPDATE t_barang SET stok = CASE 
				WHEN new.tipe_history = 'in' 	THEN (stok + new.jumlah)
				WHEN new.tipe_history = 'out' 	THEN (stok - new.jumlah)
				ELSE stok
			   END
	WHERE t_barang.id = new.barang_id;
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
