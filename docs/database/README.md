#Database
##Tables
###User
Ime atributa | Tip atributa | Opis
--- | --- | ---
Id | integer | primarni ključ
username | string | korisničko ime
password | string | lozinka
status | integer | aktivan ili blokiran
isAdmin | boolean | povlašteni korisnik?
OIB | integer | -
firstName | string | ime korisnika
lastName | string | prezime korisnika
email | string | email adresa
contactPhoneNumber | integer | broj kontakt telefona
creditCardNumber | integer | broj kreditne kartice
dateCreated | datetime | datum registracije korisnika

###Reservation
Ime atributa | Tip atributa | Opis
--- | --- | ---
Id | integer | primarni ključ
userId | integer | korisnik koji je napravio rezervaciju
parkingId | integer | parking na kojem vrijedi rezervacija
type | integer | tip rezervacije - jednokratna, ponavljajuća, trajna
status | integer | prošla, otkazana, ...
startTime | timestamp | vrijeme kad registracija počinje
endTime | timestamp | vrijeme kad rezervacija završava
duration | integer | trajanje rezervacije u satima
period | timestamp | period ponavljanja periodičke rezervacije

###ParkingSpot
Ime atributa | Tip atributa | Opis
--- | --- | ---
Id | integer | primarni ključ
parkingId | integer | parkirališno mjesto pripada jednom parkiralištu
sensor | boolean | istina = zauzeto, laž = slobodno

###Parking
Ime atributa | Tip atributa | Opis
--- | --- | ---
Id | integer | primarni ključ
locationId | integer | lokacija parkirališta
companyId | integer | parkiralište pripada kompaniji
capacity | integer | broj parkirališnih mjesta
costPerHour | integer | vrijednost koliko košta sat parkiranja
status | integer | trenutni status parkirališta - otvoreno, zatvara se, zatvoreno
type | integer | tip parkirališta - garaža ili otvoreno parkiralište

###Company
Ime atributa | Tip atributa | Opis
--- | --- | ---
Id | integer | primarni ključ
locationId | integer | lokacija kompanije
name | string | ime kompanije

###Location
Ime atributa | Tip atributa | Opis
--- | --- | ---
Id | integer | primarni ključ
latitude | double | geografska širina
longitude | double | geografska dužina

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
