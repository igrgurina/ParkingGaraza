#Database
##Tables
###User
Name | Type | Comments
--- | --- | ---
id | int(11) | primary key auto increment
OIB | int(11) | -
username | varchar(16) | username
name | varchar(40) | first name
surname | varchar(40) | last name
email | varchar(70) | valid email address
password | varchar(64) | hashed password
phone | varchar(20) | phone number
creditCardNumber | int(20) | credit card number
lastLogin | timestamp | time of the last login

###Reservation
Name | Type | Comments
--- | --- | ---
id | int(11) | primary key auto increment
userId | int(11) | foreign key user(id)
type | enum('instant','recurring','permanent') | reservation type
parkingSpotId | int(11) | foreign key parkingSpot(id)
start | timestamp | when does reservation start
end | timestamp | when does reservation end
duration | timestamp | how long does reservation last
period | timestamp | how often does reservation repeat
status | int(2) | past, active, canceled, in the future, ...

###ParkingSpot
Name | Type | Comments
--- | --- | ---
id | int(11) | primary key auto increment
parkingId | int(11) | foreign key parking(id)
sensor | boolean | true = taken, false = free

###Parking
Name | Type | Comments
--- | --- | ---
id | int(11) | primary key auto increment
locationId | int(11) | foreign key location(id)
type | enum('garage','outdoor') | parking type
numOfParkingSpots | int(11) | *maximum* number of parking spots
companyId | int(11) | foreign key company(id)
cost | int(11) | cost of parking per hour
status | int(2) | open, closing, closed #make_enum

###Company
Name | Type | Comments
--- | --- | ---
id | int(11) | primary key auto increment
name | varchar(32) | company name
locationId | int(11) | foreign key location(id)

###Location
Name | Type | Comments
--- | --- | ---
id | int(11) | primary key auto increment
name | varchar(60) | location description
address | varchar(60) | address
lat | float | latitude
lng | float | longitude

##Indexes

##SQL 
###Init.sql
``` sql
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
  `locationId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE IF NOT EXISTS `parking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locationId` int(11) NOT NULL,
  `type` enum('garage','outdoor') COLLATE utf8_unicode_ci NOT NULL COMMENT 'garaza or otvoreno parkiraliste',
  `numOfParkingSpots` int(11) NOT NULL COMMENT 'number of parking spots',
  `companyId` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cost` (`cost`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `parkingspot`
--

CREATE TABLE IF NOT EXISTS `parkingspot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parkingId` int(11) NOT NULL,
  `sensor` tinyint(1) NOT NULL COMMENT 'free or taken',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `type` enum('instant','recurring','permanent') COLLATE utf8_unicode_ci NOT NULL,
  `parkingSpotId` int(11) NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NULL DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `period` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OIB` int(11) NOT NULL,
  `username` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `creditCardNumber` int(20) NOT NULL,
  `lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

```

###Data.sql
``` sql

--
-- Database: `parking`
--

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `locationId`) VALUES(1, 'Gradski Parking d.o.o.', 1);

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `address`, `lat`, `lng`) VALUES(1, 'Gradski Parking d.o.o.', 'Ozaljska ulica 105, 10000, Zagreb', 45.7972, 15.9385);

```
