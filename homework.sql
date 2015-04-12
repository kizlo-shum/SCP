-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 12, 2015 at 07:47 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE IF NOT EXISTS `homework` (
  `intId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `intTeacherId` tinyint(4) NOT NULL,
  `varFilename` varchar(256) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `intMark` tinyint(4) NOT NULL,
  `intStudentId` int(11) NOT NULL,
  PRIMARY KEY (`intId`),
  UNIQUE KEY `intId` (`intId`),
  KEY `intStudentId` (`intStudentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`intId`, `intTeacherId`, `varFilename`, `dateCreated`, `intMark`, `intStudentId`) VALUES
(1, 1, 'homework_33c00.doc', '2015-04-12 16:43:09', 0, 2),
(2, 1, 'homework_826c0.doc', '2015-04-12 16:43:16', 0, 2),
(3, 1, 'homework_d0dd4.xls', '2015-04-12 16:43:27', 0, 2),
(4, 1, 'homework_a36a2.doc', '2015-04-12 16:44:31', 0, 3),
(5, 1, 'homework_4ad83.xls', '2015-04-12 16:44:37', 0, 4),
(6, 1, 'homework_98bb5.xls', '2015-04-12 16:44:40', 0, 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `homework`
--
ALTER TABLE `homework`
  ADD CONSTRAINT `homework_ibfk_1` FOREIGN KEY (`intStudentId`) REFERENCES `user` (`intId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
