-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2014 at 10:59 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `parking`
--
CREATE DATABASE IF NOT EXISTS `parking` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `parking`;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Gradski Parking d.o.o.',
  `location_id` int(11) NOT NULL COMMENT 'FOREIGN KEY location_id REFERENCES location(id)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `location_id`) VALUES
(1, 'Gradski Parking d.o.o.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `address`, `lat`, `lng`) VALUES
(1, 'Gradski Parking d.o.o.', 'Ozaljska ulica 105, 10000, Zagreb', 45.7972, 15.9385);

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE IF NOT EXISTS `parking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL COMMENT 'FOREIGN KEY location_id REFERENCES location(id)',
  `type` enum('garage','outdoor') COLLATE utf8_unicode_ci NOT NULL COMMENT 'garaza or otvoreno parkiraliste',
  `number_of_parking_spots` int(11) NOT NULL COMMENT 'number of parking spots',
  `company_id` int(11) NOT NULL COMMENT 'FOREIGN KEY company_id REFERENCES company(id)',
  `cost` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cost` (`cost`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`id`, `location_id`, `type`, `number_of_parking_spots`, `company_id`, `cost`) VALUES
(1, 1, 'garage', 10, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `parking_spot`
--

CREATE TABLE IF NOT EXISTS `parking_spot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parking_id` int(11) NOT NULL COMMENT 'FOREIGN KEY parking_id REFERENCES parking(id)',
  `sensor` tinyint(1) NOT NULL COMMENT 'free or taken',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'FOREIGN KEY user_id REFERENCES user(id)',
  `type` enum('instant','recurring','permanent') COLLATE utf8_unicode_ci NOT NULL,
  `parking_spot_id` int(11) NOT NULL COMMENT 'FOREIGN KEY parking_spot_id REFERENCES parking_spot(id)',
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NULL DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `period` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OIB` int(11) NOT NULL,
  `username` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `credit_card_number` int(20) NOT NULL,
  `location_id` int(11) DEFAULT NULL COMMENT 'FOREIGN KEY location_id REFERENCES location(id)',
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `OIB`, `username`, `first_name`, `last_name`, `email`, `password`, `phone`, `credit_card_number`, `location_id`, `last_login`) VALUES
(1, 123456789, 'admin', 'Ivan', 'Grgurina', 'ivan.grgurina@fer.hr', 'admin', '123456789', 123456789, 1, '2014-11-01 21:05:09');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
