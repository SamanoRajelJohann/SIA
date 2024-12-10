-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 07:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `Email`, `Password`) VALUES
(1, 'dev', 'devs');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `time` enum('AM','PM') NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `late` tinyint(1) NOT NULL DEFAULT 0,
  `overtime` tinyint(1) NOT NULL DEFAULT 0,
  `late_hours` tinyint(2) NOT NULL DEFAULT 0,
  `late_minutes` tinyint(2) NOT NULL DEFAULT 0,
  `overtime_hours` tinyint(2) NOT NULL DEFAULT 0,
  `overtime_minutes` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `time`, `date`, `status`, `late`, `overtime`, `late_hours`, `late_minutes`, `overtime_hours`, `overtime_minutes`) VALUES
(55, 1, 'AM', '2024-12-01', 'Present', 0, 0, 0, 15, 1, 30),
(56, 2, 'AM', '2024-12-01', 'Absent', 0, 0, 0, 0, 0, 0),
(57, 3, 'AM', '2024-12-01', 'Present', 0, 0, 1, 0, 0, 45),
(58, 1, 'AM', '2024-12-02', 'Present', 0, 0, 0, 5, 2, 15),
(59, 2, 'AM', '2024-12-02', 'Present', 0, 0, 0, 0, 0, 0),
(60, 3, 'AM', '2024-12-02', 'Absent', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `Employee_ID` int(11) NOT NULL,
  `First_Name` varchar(255) NOT NULL,
  `Last_Name` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Address` text NOT NULL,
  `Salary` int(11) NOT NULL,
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `Employee_ID`, `First_Name`, `Last_Name`, `Age`, `Email`, `Address`, `Salary`, `Image`) VALUES
(1, 1, 'Rajel', 'Samano', 23, 'rajel.@coms', 'tycytcy', 30000, 'CC12BasePoint.png'),
(2, 2, 'Elijah', 'Fernanadez', 21, 'boris@gmail.com', 'dasdadwwda', 32000, 'Screenshot 2024-10-16 232758.png'),
(3, 3, 'John', 'Test', 12, 'boris@gmail.coms', 'dsdadasdasd', 28000, 'Screenshot 2024-04-23 200954.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
