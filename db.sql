-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.26 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for surveyignitor1
CREATE DATABASE IF NOT EXISTS `surveyignitor1` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `surveyignitor1`;
SET FOREIGN_KEY_CHECKS = 0;
-- Dumping structure for table surveyignitor1.option
CREATE TABLE IF NOT EXISTS `option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `survey_id` int(10) unsigned NOT NULL,
  `question_id` bigint(20) unsigned NOT NULL,
  `option` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK1_question` (`question_id`),
  CONSTRAINT `FK1_question` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table surveyignitor1.participant
CREATE TABLE IF NOT EXISTS `participant` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(120) NOT NULL DEFAULT '',
  `survey_id` int(11) unsigned NOT NULL,
  `title` varchar(150) NOT NULL,
  `takers` int(11) unsigned NOT NULL,
  `finished` int(11) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table surveyignitor1.part_archive
CREATE TABLE IF NOT EXISTS `part_archive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `survey_title` varchar(150) NOT NULL DEFAULT '0',
  `started_at` date NOT NULL,
  `ended_at` date NOT NULL,
  `takers` int(10) unsigned NOT NULL,
  `finished` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table surveyignitor1.question
CREATE TABLE IF NOT EXISTS `question` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `survey_id` int(10) unsigned NOT NULL,
  `content` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('textarea','radio','checkbox') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'textarea',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK1_survey` (`survey_id`),
  CONSTRAINT `FK1_survey` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table surveyignitor1.survey
CREATE TABLE IF NOT EXISTS `survey` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `start_at` date DEFAULT NULL,
  `end_at` date DEFAULT NULL,
  `link` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK1_user` (`user_id`),
  CONSTRAINT `FK1_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table surveyignitor1.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


SET FOREIGN_KEY_CHECKS = 1;
