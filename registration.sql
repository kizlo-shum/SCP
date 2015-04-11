-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2015 at 02:18 PM
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
  `isDeleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`intId`),
  UNIQUE KEY `intId` (`intId`),
  KEY `intStudentId` (`intStudentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`intId`, `intTeacherId`, `varFilename`, `dateCreated`, `intMark`, `intStudentId`, `isDeleted`) VALUES
(1, 1, 'homework.doc', '2015-04-08 18:48:48', 5, 2, 0),
(2, 1, 'homework2.doc', '2015-04-08 18:49:17', 4, 4, 0),
(3, 1, 'table.xls', '2015-04-08 18:49:46', 5, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `intId` int(11) NOT NULL AUTO_INCREMENT,
  `isTeacher` tinyint(4) NOT NULL,
  `varFirstName` varchar(20) DEFAULT NULL,
  `varSurname` varchar(30) DEFAULT NULL,
  `varEmail` varchar(30) DEFAULT NULL,
  `varAvatar` varchar(60) DEFAULT NULL,
  `varPasswordHash` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`intId`),
  KEY `intId` (`intId`),
  KEY `intId_2` (`intId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`intId`, `isTeacher`, `varFirstName`, `varSurname`, `varEmail`, `varAvatar`, `varPasswordHash`) VALUES
(1, 1, 'Ярослав', 'Рыбяк', 'yaroslav.rybyak@ya.ru', 'bae8f4661870f5229b3de9ad7df94714.png', '60d0b59714dcfc8918e9fafea1ac3815'),
(2, 0, 'Иван', 'Дубинин', 'ivan@dub.com', '27bd93099b6ed00f11e2807933a6a949.png', '60d0b59714dcfc8918e9fafea1ac3815'),
(3, 0, 'Анастасия', 'Кавецкая', 'myownjam@gmail.com', '47877f39e773b14a41acaa8def36da4d.png', '1b3fad5b6d6dcefcb4733bd10cdf84bc'),
(4, 0, 'Король', 'Джулиан', 'king@africa.com', 'dc415a7f529558268ab2f677973f60c0.jpg', '1b3fad5b6d6dcefcb4733bd10cdf84bc');

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
