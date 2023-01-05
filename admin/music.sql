-- --------------------------------------------------------
-- Host:                         192.168.20.249
-- Server version:               10.5.12-MariaDB - FreeBSD Ports
-- Server OS:                    FreeBSD12.2
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for music
CREATE DATABASE IF NOT EXISTS `music` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `music`;

-- Dumping structure for table music.album
CREATE TABLE IF NOT EXISTS `album` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `artist_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `record_label_id` int(10) unsigned NOT NULL DEFAULT 0,
  `year` year(4) NOT NULL DEFAULT 0000,
  `format` int(10) unsigned NOT NULL DEFAULT 0,
  `cat_number` varchar(50) NOT NULL DEFAULT '0',
  `discogs` varchar(255) DEFAULT NULL,
  `image` varchar(1024) DEFAULT NULL,
  `dateordered` date DEFAULT NULL,
  `onorder` tinyint(1) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `trackingnum` varchar(255) DEFAULT NULL,
  `wanted` tinyint(1) DEFAULT NULL,
  `barcode` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=308 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table music.artist
CREATE TABLE IF NOT EXISTS `artist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `MusicBrainz` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `clear` varchar(255) DEFAULT NULL,
  `officalsite` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1063 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table music.media
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL DEFAULT 0,
  `format` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table music.record_label
CREATE TABLE IF NOT EXISTS `record_label` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `logo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name_in_record_label` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1004 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
