-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2016 at 07:03 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE member (
  MID int(11) NOT NULL  AUTO_INCREMENT,
  firstName varchar(20) DEFAULT NULL,
  lastName varchar(20) DEFAULT NULL,
  Birthday int(11) NOT NULL,
  Role varchar(20) NOT NULL,
  Rating float(5) DEFAULT 0,
  isAdmin BOOLEAN,
  PRIMARY KEY (MID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE memberDetails(
  id int(11) NOT NULL,
  dob date NOT NULL,
  address1 varchar(20) DEFAULT NULL,
  address2 varchar(20) DEFAULT NULL,
  city varchar(20) DEFAULT NULL,
  postalCode varchar(20) DEFAULT NULL,
  province varchar(20) DEFAULT NULL,
  license varchar(20) DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id) REFERENCES member(MID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE city (
  cityName varchar(10) NOT NULL,
  citySurrounded varchar(20) DEFAULT NULL,
  PRIMARY KEY (cityName)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE trip
(
    TID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    authorID INT(11) NOT NULL,
    dDate VARCHAR(50) NOT NULL,
    dCity VARCHAR(10) NOT NULL,
    aCity VARCHAR(15) NOT NULL,
    dPostal VARCHAR(20) DEFAULT NULL,
    aPostal VARCHAR(20) DEFAULT NULL,
    Description VARCHAR(100) DEFAULT NULL,
    Restriction BOOLEAN DEFAULT NULL,
    Title VARCHAR(20) DEFAULT NULL,
    Comments VARCHAR(100) DEFAULT NULL,
    Category VARCHAR(15) NOT NULL,
    FOREIGN KEY (authorID) REFERENCES member (MID)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE account (
  MID int(11) NOT NULL,
  Username varchar(20) NOT NULL,
  Email varchar(70) NOT NULL,
  Password varchar(80) NOT NULL,
  Balance float(20) NOT NULL,
  adminPrivilege boolean NOT NULL,
  FOREIGN KEY(MID) REFERENCES member(MID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE Reviews(
  id int(11) NOT NULL,
  date date NOT NULL,
  rating tinyint(1) NOT NULL,
  review varchar(20) DEFAULT NULL,
  author int(11) NOT NULL,
  target int(11) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (author) REFERENCES member(MID),
  FOREIGN KEY (target) REFERENCES member(MID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE Transactions(
  id int(11) NOT NULL,
  tripId int(11) NOT NULL,
  memberId int(11) NOT NULL,
  amount float(20) DEFAULT NULL,
  transactionDate date NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (tripId) REFERENCES trip(TID),
  FOREIGN KEY (memberId) REFERENCES member(MID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=latin1;

INSERT INTO city (cityName, citySurrounded) VALUES
  ('Brossard', 'Montreal'),
  ('Dorval', 'Montreal'),
  ('Laval', 'Montreal'),
  ('Montreal', 'Toronto'),
  ('Quebec', 'Montreal'),
  ('Sherbrooke', 'Montreal'),
  ('Toronto', 'Montreal'),
  ('WestIsland', 'Montreal');


INSERT INTO member VALUES
  (  1,
     'Dragon',
     'Doctor',
     19880508,
     'rider',
	 0,
     1);
	 
INSERT INTO account VALUES
  (  1,
     'Dragonman',
	 'email@email.com',
     'qwerty',
     0,
     1);
	 /*
INSERT INTO trip VALUES
  (1,
    1,
    'Monday',
    'Dorval',
    'Montreal',
    'H4V2N2',
    'H4V2N2',
    'Description1',
    0,
    'title#1',
    'comments#1',
   'specialized'),

  (2,
    2,
    '20161116',
    'Dorval',
    'New York',
    'H4B2N2',
    'H4B2N2',
    'description#2',
    1,
    'title#2',
    'comments#2',
   'normal');
*/
/* CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) NOT NULL,
  `userEmail` varchar(60) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userEmail` (`userEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; */

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
