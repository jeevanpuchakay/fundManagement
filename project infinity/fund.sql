-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jan 25, 2020 at 10:43 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fund`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` varchar(30) NOT NULL,
  `name` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `office` varchar(12) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `password`, `contact`, `office`) VALUES
('kunal@gmail.com', 'Kunal', '1234567', '6205264003', 'Pod 1A-302');

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

DROP TABLE IF EXISTS `balance`;
CREATE TABLE IF NOT EXISTS `balance` (
  `user_id` varchar(30) NOT NULL,
  `trans_id` varchar(30) NOT NULL,
  PRIMARY KEY (`user_id`,`trans_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `trans_id` varchar(30) NOT NULL,
  `type` varchar(1) NOT NULL,
  `amount` int(15) NOT NULL,
  `date` date NOT NULL,
  `purpose` varchar(50) NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` varchar(30) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `office` varchar(12) NOT NULL,
  `add_date` date NOT NULL,
  `left_balance` int(15) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `password`, `contact`, `office`, `add_date`, `left_balance`) VALUES
('jay@hotmail.com', 'Jay', '12345', '6378516182', 'Pod 1A-411', '2020-01-25', 150000),
('uday@yahoo.com', 'Uday', '123456', '9969822578', 'Pod 1A-412', '2020-01-26', 15000000);

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

DROP TABLE IF EXISTS `work`;
CREATE TABLE IF NOT EXISTS `work` (
  `user_id` varchar(30) NOT NULL,
  `admin_id` varchar(30) NOT NULL,
  PRIMARY KEY (`user_id`,`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `work`
--

INSERT INTO `work` (`user_id`, `admin_id`) VALUES
('jay@hotmail.com', 'kunal@gmail.com'),
('uday@yahoo.com', 'kunal@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
