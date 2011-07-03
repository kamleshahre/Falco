-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 03, 2011 at 02:54 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `falco_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `costs`
--

DROP TABLE IF EXISTS `costs`;
CREATE TABLE IF NOT EXISTS `costs` (
  `cost_id` int(11) NOT NULL AUTO_INCREMENT,
  `prej` varchar(255) NOT NULL,
  `deri` varchar(255) NOT NULL,
  `cost` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cost_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `costs`
--

INSERT INTO `costs` (`cost_id`, `prej`, `deri`, `cost`, `date`) VALUES
(32, 'Tetov', 'Stuttgart', 100, '2011-06-24 03:50:32'),
(31, 'Berlin', 'Tetov', 160, '2011-06-24 03:44:05'),
(35, 'Hamburg', 'Tetov', 180, '2011-06-24 03:50:44'),
(30, 'Tetov', 'Berlin', 160, '2011-06-24 03:44:05'),
(36, 'Gostivar', 'Berlin', 200, '2011-06-26 20:44:15'),
(37, 'Berlin', 'Gostivar', 200, '2011-06-26 20:44:15'),
(33, 'Stuttgart', 'Tetov', 100, '2011-06-24 03:50:32'),
(34, 'Tetov', 'Hamburg', 180, '2011-06-24 03:50:44');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
CREATE TABLE IF NOT EXISTS `destinations` (
  `dest_id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `direction` enum('1','2') NOT NULL,
  PRIMARY KEY (`dest_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`dest_id`, `name`, `direction`) VALUES
(17, 'Tetov', '1'),
(3, 'Berlin', '2'),
(18, 'Gostivar', '1'),
(6, 'Stuttgart', '2'),
(9, 'Hamburg', '2');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `prej` varchar(255) NOT NULL,
  `deri` varchar(255) NOT NULL,
  `KthyesePrej` varchar(255) NOT NULL,
  `KthyeseDeri` varchar(255) NOT NULL,
  `persona` int(25) NOT NULL DEFAULT '1',
  `femij` int(25) NOT NULL,
  `date` date NOT NULL,
  `data_kthyese` date NOT NULL,
  `rezervues` varchar(255) NOT NULL,
  `cost` int(255) NOT NULL,
  `provision` decimal(20,2) NOT NULL,
  `cost_noprovision` int(255) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=174 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `name`, `surname`, `prej`, `deri`, `KthyesePrej`, `KthyeseDeri`, `persona`, `femij`, `date`, `data_kthyese`, `rezervues`, `cost`, `provision`, `cost_noprovision`) VALUES
(132, 'Barack', 'Obama', 'Berlin', 'Tetov', '', '', 1, 0, '2011-07-31', '0000-00-00', 'admin', 160, '16.00', 0),
(133, 'Fatmir', 'Sejdiu', 'Tetov', 'Berlin', '', '', 1, 0, '2011-07-02', '2011-07-31', 'tetova_turs', 320, '115.20', 0),
(134, 'Albert', 'Einstein', 'Berlin', 'Tetov', 'Tetov', 'Berlin', 2, 0, '2011-07-01', '2011-07-31', 'gradec_turizam', 640, '115.20', 0),
(136, 'Artim', 'Shaqiri', 'Tetov', 'Berlin', 'Berlin', 'Tetov', 1, 0, '2011-07-01', '2011-07-31', 'admin', 320, '32.00', 0),
(155, 'Shpetim', 'Islami', 'Berlin', 'Tetov', '', '', 2, 0, '2011-07-01', '0000-00-00', 'admin', 320, '32.00', 0),
(169, 'Artim', 'Shaqiri', 'Tetov', 'Berlin', 'Berlin', 'Tetov', 1, 0, '2011-07-01', '2011-07-31', 'admin', 320, '32.00', 0),
(172, 'Shpetim', 'Islami', 'Berlin', 'Tetov', '', '', 2, 0, '2011-07-01', '0000-00-00', 'admin', 320, '32.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET ucs2 NOT NULL,
  `status` enum('admin','agent') CHARACTER SET utf8 NOT NULL DEFAULT 'agent',
  `selected_provis` decimal(20,2) NOT NULL DEFAULT '0.10',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `address`, `username`, `password`, `status`, `selected_provis`) VALUES
(1, 'Shpetim', 'Islami', 'Tetov', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '0.10'),
(2, 'Shpetim', 'Islami', 'Gradec', 'gradec_turizam', '5d0f3c466d6d3a0d87ba175b0f2ef933', 'agent', '0.18'),
(3, 'Fatmir', 'Sejdiu', 'Tetov', 'tetova_turs', '9bd818c8b63c8769501bb5ee5893791d', 'agent', '0.12');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
