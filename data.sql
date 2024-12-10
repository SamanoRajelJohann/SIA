-- Adminer 4.8.1 MySQL 10.4.32-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `accounts` (`id`, `Email`, `Password`) VALUES
(1,	'dev',	'devs');

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `time` enum('AM','PM') NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `late` tinyint(1) NOT NULL DEFAULT 0,
  `overtime` tinyint(1) NOT NULL DEFAULT 0,
  `late_hours` tinyint(2) NOT NULL DEFAULT 0,
  `late_minutes` tinyint(2) NOT NULL DEFAULT 0,
  `overtime_hours` tinyint(2) NOT NULL DEFAULT 0,
  `overtime_minutes` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `attendance` (`id`, `employee_id`, `time`, `date`, `status`, `late`, `overtime`, `late_hours`, `late_minutes`, `overtime_hours`, `overtime_minutes`) VALUES
(55,	1,	'AM',	'2024-12-01',	'Present',	0,	0,	0,	15,	1,	30),
(56,	2,	'AM',	'2024-12-01',	'Absent',	0,	0,	0,	0,	0,	0),
(57,	3,	'AM',	'2024-12-01',	'Present',	0,	0,	1,	0,	0,	45),
(58,	1,	'AM',	'2024-12-02',	'Present',	0,	0,	0,	5,	2,	15),
(59,	2,	'AM',	'2024-12-02',	'Present',	0,	0,	0,	0,	0,	0),
(60,	3,	'AM',	'2024-12-02',	'Absent',	0,	0,	0,	0,	0,	0);

DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Employee_ID` int(11) NOT NULL,
  `First_Name` varchar(255) NOT NULL,
  `Last_Name` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Address` text NOT NULL,
  `Salary` int(11) NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `employee` (`id`, `Employee_ID`, `First_Name`, `Last_Name`, `Age`, `Email`, `Address`, `Salary`, `Image`) VALUES
(1,	1,	'Rajel',	'Samano',	23,	'rajel.@coms',	'tycytcy',	30000,	'CC12BasePoint.png'),
(2,	2,	'Elijah',	'Fernanadez',	21,	'boris@gmail.com',	'dasdadwwda',	32000,	'Screenshot 2024-10-16 232758.png'),
(3,	3,	'John',	'Test',	12,	'boris@gmail.coms',	'dsdadasdasd',	28000,	'Screenshot 2024-04-23 200954.png');

-- 2024-12-10 06:40:13